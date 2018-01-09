<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Informacoes;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Symfony\Component\Form\Form;

use Urbem\CoreBundle\Entity\Ima;
use Urbem\CoreBundle\Entity\Monetario;
use Urbem\CoreBundle\Entity\Organograma;

use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model\Organograma\OrganogramaModel;
use Urbem\CoreBundle\Repository\AbstractRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

class ConfiguracaoConvenioBescAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_informacoes_configuracao_besc';
    protected $baseRoutePattern = 'recursos-humanos/ima/configuracao-besc';
    protected $includeJs = ['/recursoshumanos/javascripts/ima/configuracao-besc.js'];

    protected $numBanco = '027';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codConvenio', null, [
                'label' => 'label.besc.codConvenioBanco'
            ])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codConvenio', null, [
                'label' => 'label.besc.codConvenio'
            ])
            ->add('codConvenioBanco', null, [
                'label' => 'label.besc.codConvenioBanco'
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
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $organograma = new OrganogramaModel($em);

        $fieldOptions = [];
        $fieldOptions['codConvenio'] = [
            'label' => 'label.configuracaoBesc.codConvenio',
            'mapped' => false
        ];

        $fieldOptions['descricao'] = ['label' => 'label.descricao'];
        $fieldOptions['codOrgao'] = [
            'class' => 'CoreBundle:Organograma\Orgao',
            'choice_label' => function (Organograma\Orgao $codOrgao) {
                $return = $codOrgao->getCodOrgao();
                $return .= ' - ';
                return $return ;
            },
            'placeholder' => 'label.selecione',
            'label' => 'label.configuracaoBesc.orgao',
            'mapped' => false,
            'multiple' => true,
            'attr' => ['class' => 'select2-parameters ']
        ];
        $fieldOptions['codLocal'] = [
            'class' => 'CoreBundle:Organograma\Local',
            'choice_label' => 'descricao',
            'placeholder' => 'label.selecione',
            'label' => 'label.configuracaoBesc.local',
            'mapped' => false,
            'multiple' => true,
            'attr' => ['class' => 'select2-parameters ']
        ];
        $fieldOptions['vigencia'] = [
            'label' => 'label.configuracaoBesc.vigencia',
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

        $codBanco = $em->getRepository(Monetario\Banco::class)->findOneByNumBanco($this->numBanco)->getCodBanco();
        $fieldOptions['codAgencia'] = [
            'class' => Monetario\Agencia::class,
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

        $fieldOptions['codConvenio'] = [
            'label' => 'label.configuraCaixa.codConvenio',
            'mapped' => false
        ];

        $fieldOptions['codContaCorrente'] = [
            'attr' => [
                'class' => 'select2-parameters ',
                'data-related-from' => '_codAgencia'
            ],
            'class' => Monetario\ContaCorrente::class,
            'choice_label' => 'numContaCorrente',
            'choice_value' => 'codContaCorrente',
            'label' => 'label.fornecedor.numConta',
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'disabled' => true
        ];

        $fieldOptions['codConvenio'] = [
            'label' => 'label.configuracaoCaixa.codConvenio',
            'mapped' => false
        ];

        $fieldOptions['codBanco'] = [
            'class' => Monetario\Banco::class,
            'query_builder' => function ($banco) use ($codBanco) {
                $qb = $banco->createQueryBuilder('b');
                $qb->where($qb->expr()->andX(
                    $qb->expr()->eq('b.codBanco', '?1')
                ))
                    ->setParameter(1, $codBanco);
                return $qb;
            },
            'choice_label' => function ($codBanco) {
                return $codBanco->getNomBanco();
            },
            'label' => 'label.configuracaoCaixa.banco',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'disabled' => true,
            'mapped' => false
        ];

        $id = $this->getAdminRequestId();
        $codBanco = null;
        $codAgencia = null;
        $codContaCorrente = null;
        if (!is_null($id)) {
            list($codEmpresa, $codBanco, $timestamp) = explode("~", $id);
            $besc = $this->id($this->getSubject());
            $fieldOptions['codBanco']['data'] = $besc->getCodBanco();
            $fieldOptions['codAgencia']['data'] = $besc->getCodAgencia();

            $bescLocal = $em->getRepository('CoreBundle:Ima\ConfiguracaoBescLocal')->findByCodBanco($codBanco);
            $fieldOptions['codLocal']['choice_attr'] = function ($evento, $key, $index) use ($bescLocal) {
                foreach ($bescLocal as $local) {
                    if ($local->getCodLocal() == $index) {
                        return ['selected' => 'selected'];
                    }
                }
                return ['selected' => false];
            };

            $bescOrgao = $em->getRepository('CoreBundle:Ima\ConfiguracaoBanrisulOrgao')->findByCodBanco($codBanco);
            $fieldOptions['orgao']['choice_attr'] = function ($evento, $key, $index) use ($bescOrgao) {
                foreach ($bescOrgao as $orgao) {
                    if ($orgao->getCodOrgao() == $index) {
                        return ['selected' => 'selected'];
                    }
                }
                return ['selected' => false];
            };
        }

        $formMapper
            ->with('Configuração da Exportação Bancária -  Banrisul')
            ->add('vigencia', 'datepkpicker', $fieldOptions['vigencia'])
            ->add('codConvenio', 'number', $fieldOptions['codConvenio'])
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
            ->with('label.besc.bancoEstadoSC')
            ->add('codConvenio', null, [
                'label' => 'label.besc.codConvenio'
            ])
            ->add('codConvenioBanco', null, [
                'label' => 'label.besc.codConvenioBanco'
            ])
        ;
    }

    /**
     * @param Ima\ConfiguracaoBescConta $object
     */
    public function prePersist($object)
    {

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $codBanco = $em->getRepository(Monetario\Banco::class)->findOneByNumBanco($this->numBanco)->getCodBanco();

        $params = $this->getRequest()->request->get($this->getUniqid());



        $object->setCodConvenio($params['codConvenio']);
        $object->setCodAgencia($params['codAgencia']);
        $object->setCodContaCorrente($params['codContaCorrente']);
        $object->setTimestamp(new DateTimeMicrosecondPK());

        $convenio = $em->getRepository(Ima\ConfiguracaoConvenioBesc::class)
            ->findOneBy([
                'codBanco' => $codBanco,
                'codConvenio' => $params['codConvenio'],
            ]);

        if (!$convenio) {
            $convenio = new Ima\ConfiguracaoConvenioBesc();
            $convenio->setCodConvenio($params['codConvenio']);
            $convenio->setCodBanco($codBanco);
            $convenio->setCodConvenioBanco($codBanco);
            $em->persist($convenio);
        }

        $object->setFkImaConfiguracaoConvenioBesc($convenio);

        $locais = $this->getForm()->get('codLocal')->getData();
        foreach ($locais as $local) {
            $bescLocal = new Ima\ConfiguracaoBescLocal();
            $bescLocal->setFkOrganogramaLocal($local);
            $object->addFkImaConfiguracaoBescLocais($bescLocal);
        }

        $orgaos = $this->getForm()->get('codOrgao')->getData();
        foreach ($orgaos as $orgao) {
            $organogramaOrgao = $em->getRepository('CoreBundle:Organograma\Orgao')->findOneByCodOrgao($orgao);
            $bescOrgao = new Ima\ConfiguracaoBescOrgao();
            $bescOrgao->setFkOrganogramaOrgao($organogramaOrgao);
            $object->addFkImaConfiguracaoBescOrgoes($bescOrgao);
        }
    }

    /**
     * @param Ima\ConfiguracaoBescConta $object
     */
    public function preUpdate($object)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $orgaosArrayCollection = $object->getFkImaConfiguracaoBescOrgoes();
        $locaisArrayCollection = $object->getFkImaConfiguracaoBescLocais();

        foreach ($orgaosArrayCollection as $orgao) {
            $em->remove($orgao);
        }
        foreach ($locaisArrayCollection as $local) {
            $em->remove($local);
        }
    }

    /**
     * @param Ima\ConfiguracaoBescConta $object
     */
    public function postUpdate($object)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        /** @var Form $form */
        $form = $this->getForm();
        $locaisToUpdate = $form->get('codLocal')->getData();
        $orgaosToUpdate = $form->get('codOrgao')->getData();

        /** @var Ima\ConfiguracaoBescLocal $local */
        foreach ($locaisToUpdate as $local) {
            $bLocal = new Ima\ConfiguracaoBescLocal();
            $bLocal->setCodConvenio($object->getCodConvenio());
            $bLocal->setCodBanco($object->getCodBanco());
            $bLocal->setCodAgencia($object->getCodAgencia());
            $bLocal->setCodContaCorrente($object->getCodContaCorrente());
            $bLocal->setCodLocal($local->getCodLocal());
            $bLocal->setTimestamp($object->getTimestamp());
            $em->persist($bLocal);
        }

        /** @var Ima\ConfiguracaoBescOrgao $orgao */
        foreach ($orgaosToUpdate as $orgao) {
            $bOrgao = new Ima\ConfiguracaoBescOrgao();
            $bOrgao->setCodConvenio($object->getCodConvenio());
            $bOrgao->setCodBanco($object->getCodBanco());
            $bOrgao->setCodAgencia($object->getCodAgencia());
            $bOrgao->setCodContaCorrente($object->getCodContaCorrente());
            $bOrgao->setCodOrgao($orgao->getCodOrgao());
            $bOrgao->setTimestamp($object->getTimestamp());
            $em->persist($bOrgao);
        }

        $this->forceRedirect('/recursos-humanos/ima/configuracao-besc/create');
    }

    /**
     * @param Ima\ConfiguracaoBescConta $object
     */
    public function postPersist($object)
    {
        $this->forceRedirect('/recursos-humanos/ima/configuracao-besc/create');
    }
}
