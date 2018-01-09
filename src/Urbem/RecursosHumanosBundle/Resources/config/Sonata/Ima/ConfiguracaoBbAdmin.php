<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Ima;

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

class ConfiguracaoBbAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_ima_configuracao_bb';
    protected $baseRoutePattern = 'recursos-humanos/ima/configuracao-bb';
    protected $includeJs = ['/recursoshumanos/javascripts/ima/configuracao-bb.js'];

    protected $numBanco = '001';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codConvenio', null, [
                'label' => 'label.configuracaoBb.codConvenioBanco'
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
                'label' => 'label.configuracaoBb.codConvenio'
            ])
            ->add('codConvenioBanco', null, [
                'label' => 'label.configuracaoBb.codConvenioBanco'
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
            'label' => 'label.configuracaoBb.codConvenio',
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
            'label' => 'label.configuracaoBb.orgao',
            'mapped' => false,
            'multiple' => true,
            'attr' => ['class' => 'select2-parameters ']
        ];
        $fieldOptions['codLocal'] = [
            'class' => 'CoreBundle:Organograma\Local',
            'choice_label' => 'descricao',
            'placeholder' => 'label.selecione',
            'label' => 'label.configuracaoBb.local',
            'mapped' => false,
            'multiple' => true,
            'attr' => ['class' => 'select2-parameters ']
        ];
        $fieldOptions['vigencia'] = [
            'label' => 'label.configuracaoBb.vigencia',
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
            $bb = $this->id($this->getSubject());
            $fieldOptions['codBanco']['data'] = $bb->getCodBanco();
            $fieldOptions['codAgencia']['data'] = $bb->getCodAgencia();

            $bbLocal = $em->getRepository('CoreBundle:Ima\configuracaoBbLocal')->findByCodBanco($codBanco);
            $fieldOptions['codLocal']['choice_attr'] = function ($evento, $key, $index) use ($bbLocal) {
                foreach ($bbLocal as $local) {
                    if ($local->getCodLocal() == $index) {
                        return ['selected' => 'selected'];
                    }
                }
                return ['selected' => false];
            };

            $bbOrgao = $em->getRepository('CoreBundle:Ima\ConfiguracaoBanrisulOrgao')->findByCodBanco($codBanco);
            $fieldOptions['orgao']['choice_attr'] = function ($evento, $key, $index) use ($bbOrgao) {
                foreach ($bbOrgao as $orgao) {
                    if ($orgao->getCodOrgao() == $index) {
                        return ['selected' => 'selected'];
                    }
                }
                return ['selected' => false];
            };
        }

        $formMapper
            ->with('label.configuracaoBb.with_modulo')
            ->add('vigencia', 'datepkpicker', $fieldOptions['vigencia'])
            ->add('codConvenio', 'number', $fieldOptions['codConvenio'])
            ->end()
            ->with('label.configuracaoBb.contasConvenio')
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
            ->with('label.configuracaoBb.with_modulo')
            ->add('codConvenio', null, [
                'label' => 'label.configuracaoBb.codConvenio'
            ])
            ->add('codConvenioBanco', null, [
                'label' => 'label.configuracaoBb.codConvenioBanco'
            ])
        ;
    }

    /**
     * @param Ima\ConfiguracaoBbConta $object
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

        $convenio = $em->getRepository(Ima\ConfiguracaoConvenioBb::class)
            ->findOneBy([
                'codBanco' => $codBanco,
                'codConvenio' => $params['codConvenio'],
            ]);

        if (!$convenio) {
            $convenio = new Ima\ConfiguracaoConvenioBb();
            $convenio->setCodConvenio($params['codConvenio']);
            $convenio->setCodBanco($codBanco);
            $convenio->setCodConvenioBanco($codBanco);
            $em->persist($convenio);
        }

        $object->setFkImaConfiguracaoConvenioBb($convenio);

        $locais = $this->getForm()->get('codLocal')->getData();
        foreach ($locais as $local) {
            $bbLocal = new Ima\ConfiguracaoBbLocal();
            $bbLocal->setFkOrganogramaLocal($local);
            $object->addFkImaConfiguracaoBbLocais($bbLocal);
        }

        $orgaos = $this->getForm()->get('codOrgao')->getData();
        foreach ($orgaos as $orgao) {
            $organogramaOrgao = $em->getRepository('CoreBundle:Organograma\Orgao')->findOneByCodOrgao($orgao);
            $bbOrgao = new Ima\ConfiguracaoBbOrgao();
            $bbOrgao->setFkOrganogramaOrgao($organogramaOrgao);
            $object->addFkImaConfiguracaoBbOrgoes($bbOrgao);
        }
    }

    /**
     * @param Ima\ConfiguracaoBbConta $object
     */
    public function preUpdate($object)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $orgaosArrayCollection = $object->getFkImaConfiguracaoBbOrgoes();
        $locaisArrayCollection = $object->getFkImaConfiguracaoBbLocais();

        foreach ($orgaosArrayCollection as $orgao) {
            $em->remove($orgao);
        }
        foreach ($locaisArrayCollection as $local) {
            $em->remove($local);
        }
    }

    /**
     * @param Ima\ConfiguracaoBbConta $object
     */
    public function postUpdate($object)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        /** @var Form $form */
        $form = $this->getForm();
        $locaisToUpdate = $form->get('codLocal')->getData();
        $orgaosToUpdate = $form->get('codOrgao')->getData();

        /** @var Ima\ConfiguracaoBbLocal $local */
        foreach ($locaisToUpdate as $local) {
            $bLocal = new Ima\ConfiguracaoBbLocal();
            $bLocal->setCodConvenio($object->getCodConvenio());
            $bLocal->setCodBanco($object->getCodBanco());
            $bLocal->setCodAgencia($object->getCodAgencia());
            $bLocal->setCodContaCorrente($object->getCodContaCorrente());
            $bLocal->setCodLocal($local->getCodLocal());
            $bLocal->setTimestamp($object->getTimestamp());
            $em->persist($bLocal);
        }

        /** @var Ima\ConfiguracaoBbOrgao $orgao */
        foreach ($orgaosToUpdate as $orgao) {
            $bOrgao = new Ima\ConfiguracaoBbOrgao();
            $bOrgao->setCodConvenio($object->getCodConvenio());
            $bOrgao->setCodBanco($object->getCodBanco());
            $bOrgao->setCodAgencia($object->getCodAgencia());
            $bOrgao->setCodContaCorrente($object->getCodContaCorrente());
            $bOrgao->setCodOrgao($orgao->getCodOrgao());
            $bOrgao->setTimestamp($object->getTimestamp());
            $em->persist($bOrgao);
        }

        $this->forceRedirect('/recursos-humanos/ima/configuracao-bb/create');
    }

    /**
     * @param Ima\ConfiguracaoBbConta $object
     */
    public function postPersist($object)
    {
        $this->forceRedirect('/recursos-humanos/ima/configuracao-bb/create');
    }
}
