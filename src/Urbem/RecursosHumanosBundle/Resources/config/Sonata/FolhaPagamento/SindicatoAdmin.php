<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Urbem\CoreBundle\Entity\Folhapagamento\Evento;
use Urbem\CoreBundle\Entity\Folhapagamento\Sindicato;
use Urbem\CoreBundle\Entity\SwCgmPessoaFisica;
use Urbem\CoreBundle\Entity\SwCgmPessoaJuridica;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SindicatoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_sindicato';

    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/sindicato';

    /**
     * Disable edit button
     */
    protected $exibirBotaoEditar = false;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('numcgm', null, ['label' => 'label.folhapagamento.sindicato.sindicato'])
            ->add('codEvento', null, ['label' => 'label.folhapagamento.sindicato.evento'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'fkSwCgmPessoaJuridica',
                'sonata_type_model_autocomplete',
                [
                    'class' => SwCgmPessoaFisica::class,
                    'property' => 'nomCgm',
                    'label' => 'label.servidor.codServidor',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                    'admin_code' => 'administrativo.admin.sw_cgm_pessoa_fisica',
                ]
            )
            ->add(
                'fkFolhapagamentoEvento',
                null,
                [
                    'label' => 'label.folhapagamento.sindicato.evento',
                ]
            )
            ->add('dataBase')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $formMapper
            ->add(
                'fkSwCgmPessoaJuridica',
                'autocomplete',
                [
                    'label' => 'label.folhapagamento.sindicato.sindicato',
                    'class' => SwCgmPessoaJuridica::class,
                    'route' => ['name' => 'carrega_sw_cgm_pessoa_juridica'],
                    'attr' => [
                        'class' => 'select2-parameters'
                    ],
                ],
                [
                    'admin_code' => 'administrativo.admin.sw_cgm_admin_pj',
                ]
            )
            ->add(
                'fkFolhapagamentoEvento',
                'entity',
                [
                    'class' => Evento::class,
                    'label' => 'label.folhapagamento.sindicato.evento',
                    'attr' => [
                        'class' => 'select2-parameters ',
                    ],
                ]
            )
            ->add(
                'dataBase',
                null,
                [
                    'label' => 'label.folhapagamento.sindicato.dataBase',
                    'required' => true,
                ]
            )
        ;
    }

    /**
     * @param Sindicato $sindicato
     * @return \Symfony\Component\HttpFoundation\Response|void
     */
    public function preValidate($sindicato)
    {
        $em = $this->getDoctrine();
        $checkSindicato = $em->getRepository(Sindicato::class)->findOneBy([
            'numcgm' => $sindicato->getNumcgm()
        ]);

        if ($checkSindicato) {
            $em->clear();

            $this->getFlashBag()
                ->add('error', $this->trans('errors.rh.folhapagamento.sindicato.jaCadastrado'));
            return $this->redirectToUrl($this->request->headers->get('referer'));
        }

        if ($sindicato->getDataBase() > 12 || $sindicato->getDataBase() < 1) {
            $em->clear();

            $this->getFlashBag()
                ->add('error', $this->trans('errors.rh.folhapagamento.sindicato.dataBaseInvalida'));
            return $this->redirectToUrl($this->request->headers->get('referer'));

        }
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add(
                'fkSwCgmPessoaJuridica',
                null,
                [
                    'label' => 'label.servidor.codServidor',
                ]
            )
            ->add(
                'fkFolhapagamentoEvento',
                null,
                [
                    'label' => 'label.folhapagamento.sindicato.evento',
                ]
            )
            ->add(
                'dataBase',
                null,
                [
                    'label' => 'label.database',
                ]
            )
        ;
    }
}
