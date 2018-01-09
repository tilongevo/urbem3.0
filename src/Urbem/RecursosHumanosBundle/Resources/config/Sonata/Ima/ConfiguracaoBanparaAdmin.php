<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Ima;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\CoreBundle;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Form;
use Urbem\CoreBundle\Entity\Ima;
use Urbem\CoreBundle\Entity\Organograma;
use Urbem\CoreBundle\Model;

class ConfiguracaoBanparaAdmin extends AbstractSonataAdmin
{

    protected $baseRouteName = 'urbem_recursos_humanos_informacoes_configuracao_banpara';
    protected $baseRoutePattern = 'recursos-humanos/informacoes/configuracao/banpara';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {

        $datagridMapper
            ->add('descricao', null, [
                'label' => 'label.descricao'
            ])
            ->add('numOrgaoBanpara', null, [
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
            ->add('numOrgaoBanpara', null, [
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
            'dp_use_current' => true,
            'format' => 'dd/MM/yyyy',
            'label' => 'label.apolice.dtVencimento'
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
            'label' => 'Orgão',
        ];

        $id = $this->getAdminRequestId();

        $numOrgaoBanpara = null;
        if (!is_null($id)) {
            list($codEmpresa, $numOrgaoBanpara, $timestamp) = explode("~", $id);

            $banparaEmpresa = $em->getRepository('CoreBundle:Ima\ConfiguracaoBanparaEmpresa')->find($codEmpresa);

            $fieldOptions['codEmpresa']['data'] = $banparaEmpresa->getCodigo();
            $fieldOptions['vigencia']['attr']['readonly']       = true;
            $fieldOptions['codEmpresa']['attr']['readonly']     = true;

            $configuracaoBanparaLocal = $em->getRepository('CoreBundle:Ima\ConfiguracaoBanparaLocal')->findByNumOrgaoBanpara($numOrgaoBanpara);
            if (count($configuracaoBanparaLocal) > 0) {
                $fieldOptions['codLocal']['choice_attr'] = function ($evento, $key, $index) use ($configuracaoBanparaLocal) {
                    foreach ($configuracaoBanparaLocal as $banparaLocal) {
                        if ($banparaLocal->getCodLocal() == $index) {
                            return ['selected' => 'selected'];
                        }
                    }
                    return ['selected' => false];
                };
            }

            $configuracaoPanparaOrgao = $em->getRepository('CoreBundle:Ima\ConfiguracaoBanparaOrgao')->findByNumOrgaoBanpara($numOrgaoBanpara);
                $fieldOptions['orgao']['choice_attr'] = function ($evento, $key, $index) use ($configuracaoPanparaOrgao) {
                    foreach ($configuracaoPanparaOrgao as $banparaOrgao) {
                        if ($banparaOrgao->getCodOrgao() == $index) {
                            return ['selected' => 'selected'];
                        }
                    }
                    return ['selected' => false];
                };
        }

        $formMapper
            ->with('Configuração da Exportação Bancária -  BanPará')
                ->add('vigencia', 'sonata_type_date_picker', $fieldOptions['vigencia'])
                ->add('codEmpresa', 'number', $fieldOptions['codEmpresa'])
            ->end()
            ->with('Configuração de Orgãos')
                ->add('numOrgaoBanpara', null, [
                    'label' => 'Código do Orgão',
                    'mapped' => false,
                    'data' => $numOrgaoBanpara
                ])
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
            ->add('numOrgaoBanpara')
            ->add('vigencia')
        ;
    }

    public function prePersist($object)
    {
        $em         = $this->modelManager->getEntityManager($this->getClass());
        $codEmpresa = $this->getForm()->get('codEmpresa')->getData();
        $empresa    = $em->getRepository('CoreBundle:Ima\ConfiguracaoBanparaEmpresa')->findOneByCodigo($codEmpresa);

        if (!$empresa) {
            $empresa = new Ima\ConfiguracaoBanparaEmpresa();
            $empresa->setCodigo($codEmpresa);
            $em->persist($empresa);
            $em->flush();
        }

        $object->setFkImaConfiguracaoBanparaEmpresa($empresa);

        $locais = $this->getForm()->get('codLocal')->getData();

        $numOrgaoBanpara = $this->getForm()->get('numOrgaoBanpara')->getData();
        $object->setNumOrgaoBanpara($numOrgaoBanpara);

        foreach ($locais as $local) {
            $banParaLocal = new Ima\ConfiguracaoBanparaLocal();
            $banParaLocal->setFkOrganogramaLocal($local);
            $object->addFkImaConfiguracaoBanparaLocais($banParaLocal);
        }

        $orgaos = $this->getForm()->get('codOrgao')->getData();
        foreach ($orgaos as $orgao) {
            $organogramaOrgao = $em->getRepository('CoreBundle:Organograma\Orgao')->findOneByCodOrgao($orgao);
            $banParaOrgao = new Ima\ConfiguracaoBanparaOrgao();
            $banParaOrgao->setFkOrganogramaOrgao($organogramaOrgao);
            $object->addFkImaConfiguracaoBanparaOrgoes($banParaOrgao);
        }
    }

    /**
     * @param Ima\ConfiguracaoBanpara $object
     */
    public function preUpdate($object)
    {

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $orgaosArrayCollection = $object->getFkImaConfiguracaoBanparaOrgoes();
        $locaisArrayCollection = $object->getFkImaConfiguracaoBanparaLocais();
        $configuracaoBanparaOrgaoModel = new Model\Ima\ConfiguracaoBanparaOrgaoModel($em);
        $configuracaoBanparaLocalModel = new Model\Ima\ConfiguracaoBanparaLocalModel($em);

        foreach ($orgaosArrayCollection as $orgao){
                $configuracaoBanparaOrgaoModel->removeConfiguracaoBanparaOrgao($orgao);
        }
        foreach ($locaisArrayCollection as $local) {

            /** @var Organograma\Local $element */
            $configuracaoBanparaLocalModel->removeConfiguracaoBanparaLocal($local);
        }

        $numOrgaoBanpara = $this->getForm()->get('numOrgaoBanpara')->getData();
        $object->setNumOrgaoBanpara($numOrgaoBanpara);
    }

    public function postUpdate($object)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        /** @var Form $form */
        $form = $this->getForm();
        $locaisToUpdate = $form->get('codLocal')->getData();
        $orgaosToUpdate = $form->get('codOrgao')->getData();
        $configuracaoBanparaOrgaoModel = new Model\Ima\ConfiguracaoBanparaOrgaoModel($em);
        $configuracaoBanparaLocalModel = new Model\Ima\ConfiguracaoBanparaLocalModel($em);
        $codEmpresa = $object->getCodEmpresa();
        $timestampConfiguracaoBanpara = $object->getTimestamp();
        $numOrgaoBanpara = $this->getForm()->get('numOrgaoBanpara')->getData();

        foreach ($locaisToUpdate as $local){
            $configuracaoBanparaLocalModel
                ->createConfiguracaoBanparaLocal(
                    $codEmpresa,
                    $local,
                    $timestampConfiguracaoBanpara,
                    $numOrgaoBanpara
                );
        }

        foreach ($orgaosToUpdate as $orgao){
            $configuracaoBanparaOrgaoModel
                ->createConfiguracaoBanparaOrgao(
                    $codEmpresa,
                    $orgao,
                    $timestampConfiguracaoBanpara,
                    $numOrgaoBanpara
                );
        }
    }

    public function toString($object)
    {
        return $object->getDescricao();
    }
}
