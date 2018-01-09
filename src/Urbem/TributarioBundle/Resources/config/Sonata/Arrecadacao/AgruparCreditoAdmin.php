<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;
use Urbem\CoreBundle\Entity\Administracao\Funcao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Arrecadacao\ArrecadacaoModulos;
use Urbem\CoreBundle\Entity\Arrecadacao\AtributoGrupo;
use Urbem\CoreBundle\Entity\Arrecadacao\CreditoGrupo;
use Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito;
use Urbem\CoreBundle\Entity\Arrecadacao\RegraDesoneracaoGrupo;
use Urbem\CoreBundle\Entity\Monetario\Credito;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Arrecadacao\GrupoCreditoModel;
use Urbem\CoreBundle\Model\Monetario\AcrescimoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class AgruparCreditoAdmin
 * @package Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao
 */
class AgruparCreditoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_arrecadacao_grupo_credito_agrupar_credito';
    protected $baseRoutePattern = 'tributario/arrecadacao/grupo-credito/agrupar-credito';
    protected $includeJs = array(
        '/tributario/javascripts/arrecadacao/agrupar-credito.js'
    );

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codGrupo', null, array('label' => 'label.codigo'))
            ->add('descricao', null, array('label' => 'label.descricao'))
            ->add('anoExercicio', null, array('label' => 'label.grupoCredito.anoExercicio'));
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codGrupo', null, array('label' => 'label.codigo'))
            ->add('anoExercicio', null, array('label' => 'label.grupoCredito.anoExercicio'))
            ->add('descricao', null, array('label' => 'label.descricao'));

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $em = $this->modelManager->getEntityManager(GrupoCredito::class);

        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = array();

        $fieldOptions['descricao'] = array(
            'label' => 'label.descricao',
            'required' => true,
        );

        $isEdit = $this->isCurrentRoute('edit');
        $fieldOptions['anoExercicio'] = array(
            'label' => 'label.grupoCredito.anoExercicio',
            'required' => true,
            'disabled' => $isEdit
        );

        $fieldOptions['funcao'] = array(
            'label' => 'label.grupoCredito.regraDesoneracao',
            'class' => Funcao::class,
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'mapped' => false,
            'query_builder' => function (EntityRepository $repo) {
                $qb = $repo->createQueryBuilder('f')
                    ->where('f.codModulo = :codModulo')
                    ->andWhere('f.codBiblioteca = :codBiblioteca')
                    ->setParameter('codModulo', ConfiguracaoModel::MODULO_TRIBUTARIO_ARRECADACAO)
                    ->setParameter('codBiblioteca', AcrescimoModel::BIBLIOTECA_ORIGEM);
                return $qb;
            },
        );

        $fieldOptions['modulo'] = array(
            'class' => ArrecadacaoModulos::class,
            'label' => 'label.grupoCredito.moduloField',
            'mapped' => false,
            'required' => true,
            'attr' => ['class' => 'select2-parameters'],
            'query_builder' => function ($em) {
                $qb = $em->createQueryBuilder('am');
                $qb->innerJoin(Modulo::class, 'm', 'WITH', 'm.codModulo = am.codModulo');
                $qb->orderBy('m.codModulo', 'ASC');
                return $qb;
            }
        );

        $fieldOptions['creditoGrupo'] = array(
            'label' => 'label.grupoCredito.credito',
            'mapped' => false,
            'route' => array(
                'name' => 'api-search-monetario-credito',
            ),
            'help' => 'Deve haver ao menos um crédito agrupado!',
        );

        $fieldOptions['ordem'] = array(
            'label' => 'label.grupoCredito.ordem',
            'mapped' => false,
            'attr' => array(
                'min' => 1
            )
        );

        $fieldOptions['desconto'] = array(
            'label' => 'label.grupoCredito.aplicarDesconto',
            'mapped' => false,
            'expanded' => true,
            'choices' => array(
                'sim' => 1,
                'nao' => 0
            ),
            'data' => 0,
            'label_attr' => array(
                'class' => 'checkbox-sonata'
            ),
            'attr' => array(
                'class' => 'checkbox-sonata'
            )
        );

        $fieldOptions['fkArrecadacaoCreditoGrupos'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'TributarioBundle::Arrecadacao/GrupoCredito/AgruparCredito/creditoGrupos.html.twig',
            'data' => array(
                'creditoGrupos' => array()
            )
        );

        $fieldOptions['atributos'] = array(
            'class' => AtributoDinamico::class,
            'label' => 'label.grupoCredito.atributos',
            'attr' => [
                'class' => 'select2-parameters',
            ],
            'required' => false,
            'multiple' => true,
            'query_builder' => function ($em) {
                $qb = $em->createQueryBuilder('a');
                $qb->where('a.codModulo = :codModulo');
                $qb->setParameter('codModulo', ConfiguracaoModel::MODULO_TRIBUTARIO_ARRECADACAO);
                $qb->orderBy('a.codModulo', 'ASC');
                return $qb;
            },
            'mapped' => false,
        );

        if ($this->id($this->getSubject())) {
            /** @var GrupoCredito $grupoCredito */
            $grupoCredito = $this->getSubject();

            $fieldOptions['fkArrecadacaoCreditoGrupos']['data'] = array(
                'creditoGrupos' => $grupoCredito->getFkArrecadacaoCreditoGrupos()
            );

            $desoneracao = $this->getSubject()->getFkArrecadacaoRegraDesoneracaoGrupo();
            $desoneracao = $desoneracao ? $desoneracao->getFkAdministracaoFuncao() : '';
            $fieldOptions['funcao']['data'] = $desoneracao;

            $modulo = $this->getSubject()->getFkArrecadacaoArrecadacaoModulos();
            $fieldOptions['modulo']['data'] = $modulo;

            $atributos = array();
            $atributosGrupos = $em->getRepository(AtributoGrupo::class)
                ->findBy([
                    'codModulo' => ConfiguracaoModel::MODULO_TRIBUTARIO_ARRECADACAO,
                    'codGrupo' => $grupoCredito->getCodGrupo()
                ]);
            foreach ($atributosGrupos as $atributoGrupo) {
                $atributos[] = $atributoGrupo->getFkAdministracaoAtributoDinamico();
            }
            $fieldOptions['atributos']['data'] = $atributos;
        }

        $formMapper
            ->with('label.grupoCredito.dados')
            ->add('descricao', 'text', $fieldOptions['descricao'])
            ->add('anoExercicio', 'text', $fieldOptions['anoExercicio'])
            ->add('funcao', 'entity', $fieldOptions['funcao'])
            ->add('modulo', 'entity', $fieldOptions['modulo'])
            ->end()
            ->with('label.grupoCredito.creditos')
            ->add('creditoGrupo', 'autocomplete', $fieldOptions['creditoGrupo'])
            ->add('ordem', 'number', $fieldOptions['ordem'])
            ->add('desconto', 'choice', $fieldOptions['desconto'])
            ->add('fkArrecadacaoCreditoGrupos', 'customField', $fieldOptions['fkArrecadacaoCreditoGrupos'])
            ->end()
            ->with('label.grupoCredito.atributos')
            ->add('atributos', 'entity', $fieldOptions['atributos'])
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->with('label.grupoCredito.dados')
            ->add('codGrupo', null, array('label' => 'label.codigo'))
            ->add('anoExercicio', 'text', array('label' => 'label.grupoCredito.anoExercicio'))
            ->add('descricao', 'text', array('label' => 'label.descricao'))
            ->add(
                'fkArrecadacaoRegraDesoneracaoGrupo.fkAdministracaoFuncao',
                'text',
                array(
                    'label' => 'label.grupoCredito.regraDesoneracao',
                )
            )
            ->add(
                'fkArrecadacaoCreditoGrupos',
                'string',
                array(
                    'label' => 'label.grupoCredito.listaCreditos',
                    'template' => 'TributarioBundle::Arrecadacao/GrupoCredito/AgruparCredito/dadosCreditoGrupos.html.twig',
                )
            )
            ->add(
                'fkArrecadacaoAtributoGrupos',
                'string',
                array(
                    'label' => 'label.grupoCredito.atributos',
                    'template' => 'TributarioBundle::Arrecadacao/GrupoCredito/AgruparCredito/dadosAtributoGrupos.html.twig',
                )
            )
            ->end();
    }

    /**
     * @param mixed $grupoCredito
     * @throws \Exception
     */
    public function prePersist($grupoCredito)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $em = $this->modelManager->getEntityManager(GrupoCredito::class);
            $grupoCreditoModel = new GrupoCreditoModel($em);
            $codGrupo = $grupoCreditoModel->getNextVal($grupoCredito->getAnoExercicio());

            $grupoCredito->setCodGrupo($codGrupo);

            $funcao = $this->getForm()->get('funcao')->getdata();

            if ($funcao) {
                $regraDesoneracaoGrupo = new RegraDesoneracaoGrupo();
                $regraDesoneracaoGrupo->setAnoExercicio($grupoCredito->getAnoExercicio());
                $regraDesoneracaoGrupo->setFkAdministracaoFuncao($funcao);
                $regraDesoneracaoGrupo->setFkArrecadacaoGrupoCredito($grupoCredito);

                $grupoCredito->setFkArrecadacaoRegraDesoneracaoGrupo($regraDesoneracaoGrupo);
            }

            $modulo = $this->getForm()->get('modulo')->getData();
            $grupoCredito->setCodModulo($modulo->getCodModulo());

            $this->saveRelationships($grupoCredito);
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $container->get('session')->getFlashBag()->add('error', $e->getMessage());
            throw $e;
        }
    }

    /**
     * @param mixed $object
     * @throws \Exception
     */
    public function preUpdate($object)
    {
        $container = $this->getConfigurationPool()->getContainer();

        try {
            $em = $this->modelManager->getEntityManager(GrupoCredito::class);

            $creditoGrupoObject = $em->getRepository(CreditoGrupo::class)->findBy(['codGrupo' => $object->getCodGrupo(), 'anoExercicio' => $object->getAnoExercicio()]);
            foreach ($creditoGrupoObject as $creditoGrupo) {
                $em->remove($creditoGrupo);
            }

            $atributoGrupoObject = $em->getRepository(AtributoGrupo::class)->findBy(['codGrupo' => $object->getCodGrupo(), 'anoExercicio' => $object->getAnoExercicio()]);

            foreach ($atributoGrupoObject as $atributo) {
                $em->remove($atributo);
            }
            $em->flush();

            $funcao = $this->getForm()->get('funcao')->getdata();
            $regraDesoneracaoGrupo = $em->getRepository(RegraDesoneracaoGrupo::class)
                ->findOneBy(['codGrupo' => $object->getCodGrupo(), 'anoExercicio' => $object->getAnoExercicio()]);

            if ($regraDesoneracaoGrupo && $funcao) {
                $regraDesoneracaoGrupo->setFkAdministracaoFuncao($funcao);
                $object->setFkArrecadacaoRegraDesoneracaoGrupo($regraDesoneracaoGrupo);
            } elseif ($funcao) {
                $regraDesoneracaoGrupo = new RegraDesoneracaoGrupo();
                $regraDesoneracaoGrupo->setAnoExercicio($object->getAnoExercicio());
                $regraDesoneracaoGrupo->setFkAdministracaoFuncao($funcao);
                $regraDesoneracaoGrupo->setFkArrecadacaoGrupoCredito($object);
                $object->setFkArrecadacaoRegraDesoneracaoGrupo($regraDesoneracaoGrupo);
            }

            $modulo = $this->getForm()->get('modulo')->getData();
            $object->setCodModulo($modulo->getCodModulo());
            $object->getFkArrecadacaoArrecadacaoModulos($modulo);

            $this->saveRelationships($object);
            $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.grupoCredito.sucesso'));
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $container->get('session')->getFlashBag()->add('error', $e->getMessage());
            throw $e;
        }
        $this->forceRedirect($this->generateUrl('list'));
    }

    /**
     * @param GrupoCredito $grupoCredito
     */
    private function saveRelationships($grupoCredito)
    {
        $em = $this->modelManager->getEntityManager(GrupoCredito::class);

        $creditos = $this->getRequest()->request->get('creditos');

        if (count($creditos)) {
            foreach ($creditos as $credito) {
                list($descricao, $codigoCompostoCredito, $ordem, $desconto) = explode('__', $credito);

                list($codCredito, $codGenero, $codEspecie, $codNatureza) = explode('.', $codigoCompostoCredito);
                $creditoObject = $em->getRepository(Credito::class)
                    ->findOneBy([
                        'codCredito' => $codCredito,
                        'codGenero' => $codGenero,
                        'codEspecie' => $codEspecie,
                        'codNatureza' => $codNatureza
                    ]);

                $creditoGrupo = new CreditoGrupo();
                $creditoGrupo->setOrdem($ordem);
                $creditoGrupo->setDesconto($desconto);
                $creditoGrupo->setFkMonetarioCredito($creditoObject);

                $grupoCredito->addFkArrecadacaoCreditoGrupos($creditoGrupo);
            }
        }

        $atributos = $this->getForm()->get('atributos')->getdata();
        if (count($atributos)) {
            foreach ($atributos as $atributo) {
                $atributoGrupo = new AtributoGrupo();
                $atributoGrupo->setFkAdministracaoAtributoDinamico($atributo);
                $atributoGrupo->setFkArrecadacaoGrupoCredito($grupoCredito);

                $grupoCredito->addFkArrecadacaoAtributoGrupos($atributoGrupo);
            }
        }
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return $object instanceof GrupoCredito
            ? $object->getDescricao()
            : $this->getTranslator()->trans('label.grupoCredito.modulo');
    }
}
