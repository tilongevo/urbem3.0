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

class ConfiguracaoBbContaAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'recursos-humanos/informacoes/configuracao/banco-brasil/contas';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codConfiguracaoBbConta')
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
            ->add('codConfiguracaoBbConta')
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
            'attr' => [
                'class' => 'select2-parameters ',
                'data-related-from' => '_codBanco'
            ],
            'class' => Monetario\Agencia::class,
            'choice_label' => 'nomAgencia',
            'label' => 'label.agencia',
            'placeholder' => 'label.selecione'
        ];
        $fieldOptions['codContaCorrente'] = [
            'attr' => [
                'class' => 'select2-parameters ',
                'data-related-from' => '_codAgencia'
            ],
            'class' => Monetario\ContaCorrente::class,
            'choice_label' => 'numContaCorrente',
            'label' => 'label.contaCorrente',
            'placeholder' => 'label.selecione'
        ];
        $fieldOptions['configuracoesBbOrgao'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => Organograma\Orgao::class,
            'choice_label' => 'siglaOrgao',
            'multiple' => true,
            'expanded' => false,
            'mapped' => false
        ];
        $fieldOptions['configuracoesBbLocal'] = [
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
            $configuracaoConvenioBb = $em->getRepository('CoreBundle:Ima\ConfiguracaoConvenioBb')->find($id);

            $configuracoesBbOrgao = $configuracaoConvenioBb->getConfiguracaoBbOrgaoCollection();
            $configuracoesBbLocal = $configuracaoConvenioBb->getConfiguracaoBbLocalCollection();

            $fieldOptions['configuracoesBbOrgao']['choice_attr'] = function ($orgao, $key, $index) use ($configuracoesBbOrgao) {
                foreach ($configuracoesBbOrgao as $configuracaoBbOrgao) {
                    if ($configuracaoBbOrgao->getCodOrgao() == $orgao) {
                        return ['selected' => 'selected'];
                    }
                }

                return ['selected' => false];
            };

            $fieldOptions['configuracoesBbLocal']['choice_attr'] = function ($local, $key, $index) use ($configuracoesBbLocal) {
                foreach ($configuracoesBbLocal as $configuracaoBbOrgao) {
                    if ($configuracaoBbOrgao->getCodLocal() == $local) {
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
            ->add('orgao', 'entity', $fieldOptions['configuracoesBbOrgao'])
            ->add('local', 'entity', $fieldOptions['configuracoesBbLocal'])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codConfiguracaoBbConta')
            ->add('descricao')
            ->add('timestamp')
            ->add('vigencia')
        ;
    }
}
