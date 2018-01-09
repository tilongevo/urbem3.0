<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal\Assentamento;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Entity\Pessoal;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

class ClassificacaoAssentamentoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_assentamento_classificacao';
    protected $baseRoutePattern = 'recursos-humanos/pessoal/assentamento/classificacao';
    protected $model = Model\Pessoal\Assentamento\ClassificacaoAssentamentoModel::class;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'descricao',
                null,
                [
                    'label' => 'label.descricao'
                ]
            )
            ->add(
                'codTipo',
                'doctrine_orm_callback',
                array(
                    'callback' => function ($queryBuilder, $alias, $field, $value) {
                        if (! $value['value']) {
                            return;
                        }
                        $queryBuilder->andWhere("{$alias}.codTipo = :codTipo");
                        $queryBuilder->setParameter("codTipo", $value['value']);

                        return true;
                    },
                    'label' => 'label.tipo',
                ),
                'entity',
                array(
                    'attr' => array(
                        'class' => 'select2-parameters '
                    ),
                    'choice_label' => 'descricao',
                    'class' => Pessoal\TipoClassificacao::class,
                )
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
            ->add('descricao', 'text', [
                'label' => 'label.descricao'
            ])
            ->add(
                'fkPessoalTipoClassificacao',
                'entity',
                [
                    'class' => 'CoreBundle:Pessoal\TipoClassificacao',
                    'associated_property' => 'descricao',
                    'label' => 'label.tipo'
                ]
            )
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
        
        $fieldOptions = array();
        
        $fieldOptions['descricao'] = [
            'label' => 'label.classificacaoAssentamento.descricao'
        ];
        
        $fieldOptions['fkPessoalTipoClassificacao'] = [
            'choice_label' => function ($tipoClassificacao) {
                return $tipoClassificacao->getCodTipo()
                . " - "
                . $tipoClassificacao->getDescricao();
            },
            'class' => Pessoal\TipoClassificacao::class,
            'label' => 'label.tipo',
            'attr' => array(
                'class' => 'select2-parameters '
            )
        ];
        
        $formMapper
            ->with('label.classificacaoAssentamento.descricao_classificacao')
                ->add(
                    'descricao',
                    'text',
                    $fieldOptions['descricao']
                )
                ->add(
                    'fkPessoalTipoClassificacao',
                    'entity',
                    $fieldOptions['fkPessoalTipoClassificacao']
                )
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
            ->with('label.classificacaoAssentamento.descricao_classificacao')
                ->add('descricao', 'text', [
                    'label' => 'label.classificacaoAssentamento.descricao'
                ])
                ->add('codTipo', null, [
                    'label' => 'label.tipo',
                    'associated_property' => 'descricao'
                ])
            ->end()
        ;
    }
}
