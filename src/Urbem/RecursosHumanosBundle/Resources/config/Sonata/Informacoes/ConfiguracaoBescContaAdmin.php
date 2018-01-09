<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Informacoes;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Urbem\CoreBundle\Entity\Ima;
use Urbem\CoreBundle\Entity\Monetario;
use Urbem\CoreBundle\Entity\Organograma;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

class ConfiguracaoBescContaAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'recursos-humanos/informacoes/configuracao/besc/contas';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('descricao')
            ->add('timestamp')
            ->add('vigencia')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('descricao')
            ->add('timestamp')
            ->add('vigencia')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $fieldOptions = [];
        $fieldOptions['descricao'] = ['label' => 'label.descricao'];
        $fieldOptions['codAgencia'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => Monetario\Agencia::class,
            'choice_label' => 'nomAgencia',
            'label' => 'label.agencia',
            'placeholder' => 'label.selecione'
        ];
        $fieldOptions['codContaCorrente'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => Monetario\ContaCorrente::class,
            'choice_label' => 'numContaCorrente',
            'label' => 'label.contaCorrente',
            'placeholder' => 'label.selecione'
        ];
        $fieldOptions['configuracoesBescOrgao'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => Organograma\Orgao::class,
            'choice_label' => 'siglaOrgao',
            'multiple' => true,
            'expanded' => false,
            'mapped' => false
        ];
        $fieldOptions['configuracoesBescLocal'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => Organograma\Local::class,
            'choice_label' => 'descricao',
            'multiple' => true,
            'expanded' => false,
            'mapped' => false
        ];

        $id = $this->getAdminRequestId();

        if(!is_null($id)) {
            $em = $this->modelManager->getEntityManager($this->getClass());
            $configuracaoConvenioBesc = $em->getRepository('CoreBundle:Ima\ConfiguracaoConvenioBesc')->find($id);

            $configuracoesBescOrgao = $configuracaoConvenioBesc->getConfiguracoesBescOrgao();
            $configuracoesBescLocal = $configuracaoConvenioBesc->getConfiguracoesBescLocal();

            $fieldOptions['configuracoesBescOrgao']['choice_attr'] = function ($orgao, $key, $index) use ($configuracoesBescOrgao) {
                foreach ($configuracoesBescOrgao as $configuracaoBescOrgao) {
                    if ($configuracaoBescOrgao->getCodOrgao() == $orgao) {
                        return ['selected' => 'selected'];
                    }
                }

                return ['selected' => false];
            };

            $fieldOptions['configuracoesBescLocal']['choice_attr'] = function ($local, $key, $index) use ($configuracoesBescLocal) {
                foreach ($configuracoesBescLocal as $configuracaoBescOrgao) {
                    if ($configuracaoBescOrgao->getCodLocal() == $local) {
                        return ['selected' => 'selected'];
                    }
                }

                return ['selected' => false];
            };
        }

        $formMapper
            ->add('descricao', 'text', $fieldOptions['descricao'])
            ->add('codAgencia', 'entity', $fieldOptions['codAgencia'])
            ->add('codContaCorrente', 'entity', $fieldOptions['codContaCorrente'])
        ;

        // Fields não mapeados
        $formMapper
            ->add('orgao', 'entity', $fieldOptions['configuracoesBescOrgao'])
            ->add('local', 'entity', $fieldOptions['configuracoesBescLocal'])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('descricao')
            ->add('timestamp')
            ->add('vigencia')
        ;
    }
}
