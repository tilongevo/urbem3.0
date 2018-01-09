<?php

namespace Urbem\CoreBundle\Resources\config\Sonata\Filter;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\SwCgmPessoaFisica;
use Urbem\CoreBundle\Repository\SwCgmPessoaFisicaRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

// code: core.admin.filter.sw_cgm_pessoa_fisica
class SwCgmPessoaFisicaAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('numcgm')
            ->add('codCategoriaCnh')
            ->add('dtEmissaoRg')
            ->add('orgaoEmissor')
            ->add('cpf')
            ->add('numCnh')
            ->add('dtValidadeCnh')
            ->add('codNacionalidade')
            ->add('codEscolaridade')
            ->add('rg')
            ->add('dtNascimento')
            ->add('sexo')
            ->add('codUfOrgaoEmissor')
            ->add('servidorPisPasep')
            ->add('fkSwCgm.nomCgm')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('numcgm')
            ->add('codCategoriaCnh')
            ->add('dtEmissaoRg')
            ->add('orgaoEmissor')
            ->add('cpf')
            ->add('numCnh')
            ->add('dtValidadeCnh')
            ->add('codNacionalidade')
            ->add('codEscolaridade')
            ->add('rg')
            ->add('dtNascimento')
            ->add('sexo')
            ->add('codUfOrgaoEmissor')
            ->add('servidorPisPasep')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form->add('autocomplete_field', 'autocomplete', [
            'class' => SwCgmPessoaFisica::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (SwCgmPessoaFisicaRepository $repo, $term, Request $request) {
                return $repo->getSwCgmPessoaFisicaQueryBuilder($term);
            },
        ]);
    }
}
