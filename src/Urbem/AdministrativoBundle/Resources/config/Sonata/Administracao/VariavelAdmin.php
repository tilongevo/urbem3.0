<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Administracao;

use Doctrine\Common\Collections\ArrayCollection;
use Urbem\CoreBundle\Entity\Administracao\Funcao;
use Urbem\CoreBundle\Entity\Administracao\TipoPrimitivo;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class VariavelAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_administrativo_administracao_gerador_calculo_funcao_variavel';
    protected $baseRoutePattern = 'administrativo/administracao/gerador-calculo/funcao/variavel';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('codModulo')
            ->add('codBiblioteca')
            ->add('codFuncao')
            ->add('codVariavel')
            ->add('nomVariavel')
            ->add('valorInicial')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('codModulo')
            ->add('codBiblioteca')
            ->add('codFuncao')
            ->add('codVariavel')
            ->add('nomVariavel')
            ->add('valorInicial')
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
        $repository = $this->getDoctrine()->getRepository(TipoPrimitivo::class);
        $tipos = $repository->findAll();

        $tiposArray = new ArrayCollection();
        foreach ($tipos as $tipo) {
            $tiposArray->set($tipo->getNomTipo(), $tipo->getCodTipo());
        }


        $form = $formMapper->getFormBuilder()->getOption('data');
        $formMapper
            ->add('nomVariavel', null, ['required' => false, 'label' => 'label.nome'])
            ->add(
                'codTipo',
                'choice',
                [
                    'required' => false,
                    'choices' => $tiposArray->toArray(),
                    'label' => 'label.tipo',
                    'choice_attr' => function ($tipo, $key, $index) use ($form) {
                        if ($form->getCodTipo() == $tipo) {
                            return ['selected' => 'selected'];
                        }
                        return ['selected' => false];
                    },
                    'placeholder' => 'label.tipo',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->add('valorInicial', 'text', ['required' => false ,'label' => 'Value' ])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('codModulo')
            ->add('codBiblioteca')
            ->add('codFuncao')
            ->add('codVariavel')
            ->add('nomVariavel')
            ->add('valorInicial')
        ;
    }
}
