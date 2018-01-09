<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Ima;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\CoreBundle;
use Urbem\CoreBundle\Entity\Monetario\Agencia;
use Urbem\CoreBundle\Entity\Monetario\Banco;
use Urbem\CoreBundle\Entity\Monetario\ContaCorrente;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Form;
use Urbem\CoreBundle\Entity\Ima;
use Urbem\CoreBundle\Entity\Organograma;
use Urbem\CoreBundle\Model;

class ConfiguracaoBanrisulAdmin extends AbstractSonataAdmin
{

    protected $baseRouteName = 'urbem_recursos_humanos_informacoes_configuracao_banrisul';
    protected $baseRoutePattern = 'recursos-humanos/informacoes/configuracao/banrisul';
    protected $includeJs = ['/recursoshumanos/javascripts/ima/configuracao-banrisul.js'];

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create', 'edit', 'delete', 'list']);
        $collection->add('search_cc', 'search/cc/{cod_agencia}');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {

        $datagridMapper
            ->add('descricao', null, [
                'label' => 'label.descricao'
            ])
            ->add('codConvenio', null, [
                'label' => 'label.configuracaoBanpara.numOrgaoBanpara'
            ])
            ->add(
                'vigencia',
                null,
                [
                    'label' => 'label.dtVigencia',
                ],
                'sonata_type_date_picker',
                [
                 'required'        => false,
                 'format'          => 'dd/MM/yyyy',
                 'label'           => 'label.vigencia',
                ]
            )
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {

        $this->setBreadCrumb();

        $listMapper
            ->add('descricao', null, [
                'label' => 'label.descricao'
            ])
            ->add('codConvenio', null, [
                'label' => 'label.configuracaoBanpara.numOrgaoBanpara'
            ])
            ->add('vigencia', null, [
                'label' => 'label.vigencia'
            ])
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {

        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = [];

        $em = $this->modelManager->getEntityManager($this->getClass());
        $organograma = new Model\Organograma\OrganogramaModel($em);

        $fieldOptions['codEmpresa'] = [
            'label' => 'Código da empresa',
            'mapped' => false
        ];

        $fieldOptions['descricao'] = ['label' => 'label.descricao'];
        $fieldOptions['codOrgao'] = [
            'class' => 'CoreBundle:Organograma\Orgao',
            'choice_label' => function ($codOrgao) {
                $return = $codOrgao->getCodOrgao();
                $return .= ' - ';
                return $return ;
            },
            'placeholder' => 'label.selecione',
            'label' => 'Lotação',
            'mapped' => false,
            'multiple' => true,
            'attr' => ['class' => 'select2-parameters ']
        ];
        $fieldOptions['codLocal'] = [
            'class' => 'CoreBundle:Organograma\Local',
            'choice_label' => 'descricao',
            'placeholder' => 'label.selecione',
            'label' => 'Local',
            'mapped' => false,
            'multiple' => true,
            'attr' => ['class' => 'select2-parameters ']
        ];
        $fieldOptions['vigencia'] = [
            'label' => 'Vigência',
            'format' => 'dd/MM/yyyy',
            'pk_class' => DatePK::class,
            'required' => true,
        ];

        $resOrganograma = $organograma->getOrganogramaVigentePorTimestamp();
        $codOrganograma = $resOrganograma['cod_organograma'];
        $dataFinal = $resOrganograma['dt_final'];
        $resultFuncoes = $organograma->getOrganograma($codOrganograma, $dataFinal);

        $choices = [];

        foreach ($resultFuncoes as $result) {
            $label = $result['cod_estrutural'].' - '.$result['descricao'];
            $choices[$label] = $result['cod_orgao'];
        }


        $fieldOptions['orgao'] = [
            'attr' => ['class' => 'select2-parameters '],
            'choices' => $choices,
            'multiple' => true,
            'expanded' => false,
            'mapped' => false,
            'label' => 'Lotação',
        ];

        $codBanco = $em->getRepository(Banco::class)->findOneByNumBanco('041')->getCodBanco();

        $fieldOptions['codBanco'] = [
            'class' => Banco::class,
            'query_builder' => function ($codBanco) {
                $qb = $codBanco->createQueryBuilder('b');
                $qb->where($qb->expr()->andX(
                    $qb->expr()->eq('b.numBanco', '?1')
                ))
                    ->setParameter(1, '041');
                return $qb;
            },
            'choice_label' => function ($codBanco) {
                return $codBanco->getNomBanco();
            },
            'label' => 'label.configuracaoHsbc.banco',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'disabled' => true,
            'mapped' => false
        ];

        $fieldOptions['codAgencia'] = [
            'class' => Agencia::class,
            'choice_label' => 'nomAgencia',
            'choice_value' => 'codAgencia',
            'label' => 'label.agencia',
            'mapped' => false,
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'query_builder' => function ($agencia) use ($codBanco) {
                /** @var QueryBuilder $qb */
                $qb = $agencia->createQueryBuilder('a');
                $qb->where('a.codBanco = ?1')
                    ->setParameter(1, $codBanco);
                return $qb;
            },
        ];

        $fieldOptions['codContaCorrente'] = [
            'attr' => [
                'class' => 'select2-parameters ',
                'data-related-from' => '_codAgencia'
            ],
            'class' => ContaCorrente::class,
            'choice_label' => 'numContaCorrente',
            'choice_value' => 'codContaCorrente',
            'label' => 'label.fornecedor.numConta',
            'placeholder' => 'label.selecione',
            'mapped' => false
        ];
        $id = $this->getAdminRequestId();

        $codBanco = null;
        $codAgencia = null;
        $codContaCorrente = null;
        if (!is_null($id)) {
            list($codEmpresa, $codBanco, $timestamp) = explode("~", $id);

            $banrisul = $this->id($this->getSubject());
            $fieldOptions['codBanco']['data'] = $banrisul->getCodBanco();
            $fieldOptions['codAgencia']['data'] = $banrisul->getCodAgencia();

            $configuracaoBanrisulLocal = $em->getRepository('CoreBundle:Ima\ConfiguracaoBanrisulLocal')
                ->findByCodBanco($codBanco);
            if (count($configuracaoBanrisulLocal) > 0) {
                $fieldOptions['codLocal']['choice_attr'] = function ($evento, $key, $index) use ($configuracaoBanrisulLocal) {
                    foreach ($configuracaoBanrisulLocal as $banrisulLocal) {
                        if ($banrisulLocal->getCodLocal() == $index) {
                            return ['selected' => 'selected'];
                        }
                    }
                    return ['selected' => false];
                };
            }

            $configuracaoBanrisulOrgao = $em->getRepository('CoreBundle:Ima\ConfiguracaoBanrisulOrgao')
                ->findByCodBanco($codBanco);
                $fieldOptions['orgao']['choice_attr'] = function ($evento, $key, $index) use ($configuracaoBanrisulOrgao) {
                    foreach ($configuracaoBanrisulOrgao as $banrisulOrgao) {
                        if ($banrisulOrgao->getCodOrgao() == $index) {
                            return ['selected' => 'selected'];
                        }
                    }
                    return ['selected' => false];
                };
        }


        $formMapper
            ->with('Configuração da Exportação Bancária -  Banrisul')
            ->add('vigencia', 'datepkpicker', $fieldOptions['vigencia'])
            ->add('codConvenio', 'number', $fieldOptions['codEmpresa'])
            ->end()
            ->with('Contas de Convênio')
            ->add('codBanco', 'entity', $fieldOptions['codBanco'])
            ->add('codAgencia', 'entity', $fieldOptions['codAgencia'])
            ->add('codContaCorrente', 'entity', $fieldOptions['codContaCorrente'])
            ->add('descricao', null, $fieldOptions['descricao'])
            ->add('codOrgao', 'choice', $fieldOptions['orgao'])
            ->add('codLocal', 'entity', $fieldOptions['codLocal'])
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {

        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('descricao')
            ->add('codBanco')
            ->add('vigencia')
        ;
    }

    /**
     * @param Ima\ConfiguracaoBanrisulConta $object
     */
    public function prePersist($object)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $codConvenio = $this->getForm()->get('codConvenio')->getData();
        //$codBanco = $this->getForm()->get('codBanco')->getData();
        $codBanco = $em->getRepository(Banco::class)->findOneByNumBanco('041')->getCodBanco();
        /** @var Agencia $codAgencia */
        $codAgencia = $this->getForm()->get('codAgencia')->getData();
        /** @var ContaCorrente $codContaCorrente$codContaCorrente */
        $codContaCorrente = $this->getForm()->get('codContaCorrente')->getData();

        $object->setCodAgencia($codAgencia->getCodAgencia());
        $object->setCodContaCorrente($codContaCorrente->getCodContaCorrente());
        $object->setTimestamp(new DateTimeMicrosecondPK());

        $convenio = $em->getRepository(Ima\ConfiguracaoConvenioBanrisul::class)
            ->findOneBy([
                'codBanco' => $codBanco,
                'codConvenio' => $codConvenio,
            ]);

        if (!$convenio) {
            $convenio = new Ima\ConfiguracaoConvenioBanrisul();
            $convenio->setCodConvenio($codConvenio);
            $convenio->setCodBanco($codBanco);
            $convenio->setCodConvenioBanco($codBanco);

            $em->persist($convenio);
        }

        $object->setFkImaConfiguracaoConvenioBanrisul($convenio);

        $locais = $this->getForm()->get('codLocal')->getData();
        foreach ($locais as $local) {
            $banriLocal = new Ima\ConfiguracaoBanrisulLocal();
            $banriLocal->setFkOrganogramaLocal($local);
            $object->addFkImaConfiguracaoBanrisulLocais($banriLocal);
        }

        $orgaos = $this->getForm()->get('codOrgao')->getData();
        foreach ($orgaos as $orgao) {
            $organogramaOrgao = $em->getRepository('CoreBundle:Organograma\Orgao')->findOneByCodOrgao($orgao);
            $banrisulOrgao = new Ima\ConfiguracaoBanrisulOrgao();
            $banrisulOrgao->setFkOrganogramaOrgao($organogramaOrgao);
            $object->addFkImaConfiguracaoBanrisulOrgoes($banrisulOrgao);
        }
    }

    /**
     * @param Ima\ConfiguracaoBanrisulConta $object
     */
    public function preUpdate($object)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $orgaosArrayCollection = $object->getFkImaConfiguracaoBanrisulOrgoes();
        $locaisArrayCollection = $object->getFkImaConfiguracaoBanrisulLocais();

        foreach ($orgaosArrayCollection as $orgao) {
            $em->remove($orgao);
        }
        foreach ($locaisArrayCollection as $local) {
            $em->remove($local);
        }
    }

    /**
     * @param Ima\ConfiguracaoBanrisulConta $object
     */
    public function postUpdate($object)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        /** @var Form $form */
        $form = $this->getForm();
        $locaisToUpdate = $form->get('codLocal')->getData();
        $orgaosToUpdate = $form->get('codOrgao')->getData();


        /** @var Ima\ConfiguracaoBanrisulLocal $local */
        foreach ($locaisToUpdate as $local) {
            $bLocal = new Ima\ConfiguracaoBanrisulLocal();
            $bLocal->setCodConvenio($object->getCodConvenio());
            $bLocal->setCodBanco($object->getCodBanco());
            $bLocal->setCodAgencia($object->getCodAgencia());
            $bLocal->setCodContaCorrente($object->getCodContaCorrente());
            $bLocal->setCodLocal($local->getCodLocal());
            $bLocal->setTimestamp($object->getTimestamp());
            $em->persist($bLocal);
        }

        /** @var Ima\ConfiguracaoBanrisulOrgao $orgao */
        foreach ($orgaosToUpdate as $orgao) {
            $bOrgao = new Ima\ConfiguracaoBanrisulOrgao();
            $bOrgao->setCodConvenio($object->getCodConvenio());
            $bOrgao->setCodBanco($object->getCodBanco());
            $bOrgao->setCodAgencia($object->getCodAgencia());
            $bOrgao->setCodContaCorrente($object->getCodContaCorrente());
            $bOrgao->setCodOrgao($orgao->getCodOrgao());
            $bOrgao->setTimestamp($object->getTimestamp());
            $em->persist($bOrgao);
        }
    }

    public function toString($object)
    {
        return $object->getDescricao();
    }
}
