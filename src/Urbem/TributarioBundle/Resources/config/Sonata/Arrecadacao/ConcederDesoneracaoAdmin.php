<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao;
use Urbem\CoreBundle\Entity\Arrecadacao\Desonerado;
use Urbem\CoreBundle\Entity\Arrecadacao\DesoneradoCadEconomico;
use Urbem\CoreBundle\Entity\Arrecadacao\DesoneradoImovel;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;
use Urbem\CoreBundle\Entity\Imobiliario\Imovel;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Exception\Error;
use Urbem\CoreBundle\Form\Type\AutoCompleteType;
use Urbem\CoreBundle\Model\Arrecadacao\DesoneradoModel;
use Urbem\CoreBundle\Model\Economico\CadastroEconomicoModel;
use Urbem\CoreBundle\Model\Imobiliario\ImovelModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class ConcederDesoneracaoAdmin
 * @package Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao
 */
class ConcederDesoneracaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_arrecadacao_desoneracao_conceder_desoneracao';
    protected $baseRoutePattern = 'tributario/arrecadacao/desoneracao/conceder-desoneracao';
    protected $exibirBotaoIncluir = false;
    protected $includeJs = array(
        '/administrativo/javascripts/administracao/atributo-dinamico-component.js',
        '/tributario/javascripts/arrecadacao/conceder-desoneracao.js'
    );
    const VINCULAR_INSCRICAO_ECONOMICA = 'IE';
    const VINCULAR_INSCRICAO_IMOBILIARIA = 'II';

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('create', 'list'));

        $collection->add('busca_cadastro_imobiliario', 'busca-cadastro-imobiliario');
        $collection->add('busca_cadastro_economico', 'busca-cadastro-economico');
        $collection->add('prorrogar', 'prorrogar');
        $collection->add('revogar', 'revogar');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codDesoneracao', null, array('label' => 'label.codigo'))
            ->add(
                'fkSwCgm',
                'doctrine_orm_choice',
                array('label' => 'label.cgm'),
                'autocomplete',
                array(
                    'class' => SwCgm::class,
                    'route' => array(
                        'name' => 'api-search-swcgm-pessoa-fisica-numcgm-nomecgm'
                    ),
                    'mapped' => false,
                )
            );
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        $filter = $this->getRequest()->query->get('filter');

        $params = [];
        if (isset($filter['fkSwCgm']) && $filter['fkSwCgm']['value'] != '') {
            $query->andWhere('o.numcgm = :fkSwCgm');
            $params['fkSwCgm'] = $filter['fkSwCgm']['value'];
        }

        $query->setParameters($params);

        $query->innerJoin('CoreBundle:Arrecadacao\Desoneracao', 'd', 'WITH', 'd.codDesoneracao = o.codDesoneracao');
        $query->andWhere($query->expr()->eq("d.prorrogavel", 'true'));
        $query->orWhere($query->expr()->eq("d.revogavel", 'true'));

        return $query;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();
        $listMapper
            ->add('codDesoneracao', null, array('label' => 'label.codigo'))
            ->add('fkArrecadacaoDesoneracao.fkArrecadacaoTipoDesoneracao', null, array('label' => 'label.concederDesoneracao.tipoDesoneracao'))
            ->add('fkArrecadacaoDesoneracao.fkMonetarioCredito_', null, array('label' => 'label.concederDesoneracao.credito'))
            ->add('fkSwCgm', null, array('label' => 'label.cgm'))
            ->add('dataConcessao', null, array('label' => 'label.concederDesoneracao.dataConcessao'))
            ->add('dataProrrogacao', null, array('label' => 'label.concederDesoneracao.dataProrrogacao'))
            ->add('dataRevogacao', null, array('label' => 'label.concederDesoneracao.dataRevogacao'))
            ->add(
                'inscricaoMunicipal',
                'numeric',
                array(
                    'label' => 'label.concederDesoneracao.inscricaoImobiliaria',
                    'template' => 'TributarioBundle:Arrecadacao\Desoneracao\Conceder:inscricaoMunicipal.html.twig'
                )
            )
            ->add(
                'inscricaoEconomica',
                null,
                array(
                    'label' => 'label.concederDesoneracao.inscricaoEconomica',
                    'template' => 'TributarioBundle:Arrecadacao\Desoneracao\Conceder:inscricaoEconomica.html.twig'
                )
            )
            ->add('ocorrencia', null, array('label' => 'label.concederDesoneracao.ocorrencia'));

        $listMapper
            ->add(
                '_action',
                'actions',
                array(
                    'actions' => array(
                        'prorrogar' => array('template' => 'TributarioBundle:Sonata/Arrecadacao/Desoneracao/CRUD:list__action_prorrogar.html.twig'),
                        'revogar' => array('template' => 'TributarioBundle:Sonata/Arrecadacao/Desoneracao/CRUD:list__action_revogar.html.twig'),
                    )
                )
            );
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager->getEntityManager($this->getClass());

        $fieldOptions = array();

        $fieldOptions['fkArrecadacaoDesoneracao'] = array(
            'class' => Desoneracao::class,
            'label' => 'label.concederDesoneracao.desoneracao',
            'required' => true,
            'choice_value' => 'codDesoneracao',
            'choice_label' => function ($desoneracao) {
                return sprintf("%d - %s - %s", $desoneracao->getCodDesoneracao(), $desoneracao->getFkArrecadacaoTipoDesoneracao()->getDescricao(), $desoneracao->getFkMonetarioCredito());
            },
            'attr' => [
                'class' => 'select2-parameters '
            ],
        );

        $fieldOptions['fkSwCgm'] = array(
            'class' => SwCgm::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                $qb = $repo->createQueryBuilder('o');
                $qb->where($qb->expr()->orX(
                    $qb->expr()->like('LOWER(o.nomCgm)', ':nomCgm'),
                    $qb->expr()->eq('o.numcgm', ':numcgm')
                ));
                $qb->setParameters([
                    'nomCgm' => sprintf('%%%s%%', strtolower($term)),
                    'numcgm' => ((int) $term) ? $term : null
                ]);
                return $qb;
            },
            'label' => 'label.cgm',
            'required' => true,
        );

        $fieldOptions['vincularDesoneracao'] = array(
            'label' => 'label.concederDesoneracao.vincularDesoneracao',
            'mapped' => false,
            'choices' => array(
                'label.concederDesoneracao.inscricaoImobiliaria' => $this::VINCULAR_INSCRICAO_IMOBILIARIA,
                'label.concederDesoneracao.inscricaoEconomica' => $this::VINCULAR_INSCRICAO_ECONOMICA
            ),
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione'
        );

        $imovelModel = new ImovelModel($em);
        $imoveis = $imovelModel->findImoveis(array());

        $imovelList = array();

        if (!is_null($imoveis)) {
            foreach ($imoveis as $imovel) {
                $imovelList[$imovel['inscricao_municipal']] = $imovel['inscricao_municipal'];
            }
        }
        $imovelList = array_flip($imovelList);

        $fieldOptions['inscricaoImobiliaria'] = array(
            'label' => 'label.concederDesoneracao.inscricaoImobiliaria',
            'mapped' => false,
            'choices' => $imovelList,
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione'
        );

        $cadastroEconomicoModel = new CadastroEconomicoModel($em);
        $cadastrosEconomico = $cadastroEconomicoModel->findCadastrosEconomico(array());

        $cadastrosEconomicoList = array();

        if (!is_null($cadastrosEconomico)) {
            foreach ($cadastrosEconomico as $imovel) {
                $cadastrosEconomicoList[$imovel['inscricao_economica']] = $imovel['inscricao_economica'];
            }
        }

        $cadastrosEconomicoList = array_flip($cadastrosEconomicoList);

        $fieldOptions['inscricaoEconomica'] = array(
            'label' => 'label.concederDesoneracao.inscricaoEconomica',
            'mapped' => false,
            'choices' => $cadastrosEconomicoList,
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione'
        );

        $formMapper
            ->with('label.concederDesoneracao.dados')
            ->add('fkArrecadacaoDesoneracao', EntityType::class, $fieldOptions['fkArrecadacaoDesoneracao'])
            ->add('fkSwCgm', AutoCompleteType::class, $fieldOptions['fkSwCgm'])
            ->add('vincularDesoneracao', ChoiceType::class, $fieldOptions['vincularDesoneracao'])
            ->add('inscricaoImobiliaria', ChoiceType::class, $fieldOptions['inscricaoImobiliaria'])
            ->add('inscricaoEconomica', ChoiceType::class, $fieldOptions['inscricaoEconomica'])
            ->end()
            ->with('label.imobiliarioTrecho.atributos', array('class' => 'atributoDinamicoWith'))
            ->add('atributosDinamicos', 'text', array('mapped' => false, 'required' => false))
            ->end();
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $container = $this->getConfigurationPool()->getContainer();

        try {
            $vincularDesoneracao = $this->getForm()->get('vincularDesoneracao')->getdata();

            $ocorrencia = 1;
            $ocorrenciaLast = $em->getRepository(Desonerado::class)
                ->findOneBy(
                    [
                        'codDesoneracao' => $object->getFkArrecadacaoDesoneracao()->getCodDesoneracao(),
                        'numcgm' => $object->getFkSwCgm()->getNumcgm()
                    ],
                    [
                        'ocorrencia' => 'DESC'
                    ]
                );


            if (!empty($ocorrenciaLast)) {
                $ocorrencia = $ocorrenciaLast->getOcorrencia() + 1;
            }
            $object->setOcorrencia($ocorrencia);
            $object->setDataConcessao(new \DateTime());

            if ($this->request->request->get('atributoDinamico')) {
                $desoneradoModel = new DesoneradoModel($em);
                $desoneradoModel->saveAtributoDinamico($object, $this->request->request->get('atributoDinamico'));
            }

            if ($vincularDesoneracao === $this::VINCULAR_INSCRICAO_ECONOMICA) {
                $inscricao = $this->getForm()->get('inscricaoEconomica')->getdata();

                $cadastroEconomico = $em->getRepository(CadastroEconomico::class)
                    ->findOneBy([
                        'inscricaoEconomica' => $inscricao
                    ]);

                if (!empty($inscricao) && !empty($cadastroEconomico)) {
                    $desoneradoCadEconomico = new DesoneradoCadEconomico();
                    $desoneradoCadEconomico->setFkArrecadacaoDesonerado($object);
                    $desoneradoCadEconomico->setFkEconomicoCadastroEconomico($cadastroEconomico);

                    $object->addFkArrecadacaoDesoneradoCadEconomicos($desoneradoCadEconomico);
                }
            } elseif ($vincularDesoneracao === $this::VINCULAR_INSCRICAO_IMOBILIARIA) {
                $inscricao = $this->getForm()->get('inscricaoImobiliaria')->getdata();

                $imovel = $em->getRepository(Imovel::class)
                    ->findOneBy([
                        'inscricaoMunicipal' => $inscricao
                    ]);

                if (!empty($inscricao) && !empty($imovel)) {
                    $desoneradoImovel = new DesoneradoImovel();
                    $desoneradoImovel->setFkArrecadacaoDesonerado($object);
                    $desoneradoImovel->setFkImobiliarioImovel($imovel);
                    $object->addFkArrecadacaoDesoneradoImoveis($desoneradoImovel);
                }
            }
            $em->persist($object);
            $em->flush();
            $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.concederDesoneracao.sucesso'));
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
        }
        $this->forceRedirect("/tributario/arrecadacao/desoneracao/conceder-desoneracao/create");
    }

    /**
     * @param $object
     * @return bool
     */
    public function canRevogar($object)
    {
        if (is_null($object->getDataRevogacao())) {
            return true;
        }
        return false;
    }
}
