<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Beneficio;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Model\Beneficio\ConcessaoValeTransporteModel;
use Urbem\CoreBundle\Model\Beneficio\ValeTransporteModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Model\Beneficio\ContratoServidorConcessaoValeTransporteModel;

class ConcessaoValeTransporteAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_beneficio_concessao_vale_transporte';
    protected $baseRoutePattern = 'recursos-humanos/beneficio/concessao-vale-transporte';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $entityManager = $this->modelManager->getEntityManager('CoreBundle:Pessoal\ContratoServidor');
        $entityManagerValeTransporte = $this->modelManager->getEntityManager('CoreBundle:Beneficio\ValeTransporte');

        $datagridMapper
            ->add(
                'contratoServidorConcessaoValeTransporte.codContrato',
                null,
                array(
                    'label' => 'label.matricula',
                    'associated_property' => function ($contratoServidorConcessaoValeTransporte) use ($entityManager) {
                        $contratoServidorModel = new ContratoServidorConcessaoValeTransporteModel($entityManager);
                        $cgm = $contratoServidorModel->getCgm($contratoServidorConcessaoValeTransporte);

                        return $cgm->getNomCgm();
                    }
                )
            )
            ->add('exercicio')
            ->add('quantidade')
            ->add(
                'codValeTransporte',
                null,
                array(
                    'class' => 'CoreBundle:Beneficio\ValeTransporte',
                    'associated_property' => function ($codValeTransporte) use ($entityManagerValeTransporte) {
                        $valeTransporteModel = new ValeTransporteModel($entityManagerValeTransporte);
                        $itinerario = $valeTransporteModel->getItinerario($codValeTransporte);
                        $itinerario = $itinerario[0];

                        $linhaOrigem =  $itinerario->getCodLinhaOrigem()->getDescricao();
                        $municipioOrigem = $itinerario->getMunicipioDestino()->getNomMunicipio();
                        $linhaDestino = $itinerario->getCodLinhaDestino()->getDescricao();
                        $municipioDestino = $itinerario->getMunicipioDestino()->getNomMunicipio();

                        return "{$municipioOrigem}/{$linhaOrigem} - {$municipioDestino}/{$linhaDestino}";
                    },
                    'label' => 'label.faixadesconto.valetransporte',
                    'attr' => array(
                        'class' => 'select2-parameters '
                    )
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
        parent::configureListFields($listMapper);

        $entityManager = $this->modelManager->getEntityManager('CoreBundle:Pessoal\ContratoServidor');
        $entityManagerValeTransporte = $this->modelManager->getEntityManager('CoreBundle:Beneficio\ValeTransporte');

        $listMapper
            ->add(
                'codContrato',
                'entity',
                array(
                    'label' => 'label.matricula',
                    'associated_property' => function ($contrato) use ($entityManager) {
                        $contratoServidorModel = new ContratoServidorConcessaoValeTransporteModel($entityManager);
                        $cgm = $contratoServidorModel->getCgm($contrato->getCodContrato());

                        return $cgm->getNomCgm();
                    },
                )
            )
            ->add('exercicio')
            ->add('quantidade')
            ->add(
                'codValeTransporte',
                'entity',
                array(
                    'class' => 'CoreBundle:Beneficio\ValeTransporte',
                    'associated_property' => function ($codValeTransporte) use ($entityManagerValeTransporte) {
                        $valeTransporteModel = new ValeTransporteModel($entityManagerValeTransporte);
                        $itinerario = $valeTransporteModel->getItinerario($codValeTransporte);
                        $itinerario = $itinerario[0];

                        $linhaOrigem =  $itinerario->getCodLinhaOrigem()->getDescricao();
                        $municipioOrigem = $itinerario->getMunicipioDestino()->getNomMunicipio();
                        $linhaDestino = $itinerario->getCodLinhaDestino()->getDescricao();
                        $municipioDestino = $itinerario->getMunicipioDestino()->getNomMunicipio();

                        return "{$municipioOrigem}/{$linhaOrigem} - {$municipioDestino}/{$linhaDestino}";
                    },
                    'label' => 'label.faixadesconto.valetransporte',
                    'attr' => array(
                        'class' => 'select2-parameters '
                    )
                )
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

        $entityManager = $this->modelManager->getEntityManager('CoreBundle:Beneficio\ValeTransporte');

        $concessaoModel = new ConcessaoValeTransporteModel($entityManager);

        $codTipo = 1;
        if ($id) {
            $codTipo = $concessaoModel->findOneByCodConcessao($id)->getCodTipo();
        }

        $codTipo = null;

        $formMapper
            ->with("Informações da Concessão")
                ->add(
                    'codTipo',
                    'entity',
                    array(
                        'class' => 'CoreBundle:Beneficio\TipoConcessaoValeTransporte',
                        'choice_label' => 'descricao',
                        'data' => $codTipo,
                        'expanded' => true,
                        'label' => 'label.concessao',
                        'multiple' => false
                    )
                )
            ->end()

            ->with("Concessão por Grupo")
                ->add(
                    'contratoServidorConcessaoValeTransporte',
                    'sonata_type_admin',
                    array(
                        'label' => false,
                        'mapped' => false,
                    ),
                    array(
                        'admin_code' => 'recursos_humanos.admin.contrato_servidor_concessao_vale_transporte'
                    )
                )
                ->add(
                    'grupoConcessaoValeTransporte',
                    'sonata_type_admin',
                    array(
                        'label' => false,
                        'mapped' => false
                    ),
                    array(
                        'admin_code' => 'recursos_humanos.admin.grupo_concessao_vale_transporte'
                    )
                )
                ->add(
                    'exercicio',
                    'text',
                    array(
                        'label' => 'label.ano'
                    )
                )
                ->add(
                    'codMes',
                    'entity',
                    array(
                        'class' => 'CoreBundle:Administracao\Mes',
                        'choice_label' => 'descricao',
                        'label' => 'label.mes',
                        'attr' => array(
                            'class' => 'select2-parameters '
                        )
                    )
                )
                ->add(
                    'tipoValeTransporte',
                    'choice',
                    array(
                        'choices' => array(
                            'label.mensal' => 'mensal',
                            'label.diario' => 'diario'
                        ),
                        'data' => 'mensal',
                        'expanded' => true,
                        'mapped' => false,
                        'multiple' => false
                    )
                )
                ->add(
                    'concessaoValeTransporteCalendario',
                    'sonata_type_admin',
                    array(
                        'label' => false,
                        'mapped' => false
                    ),
                    array(
                        'admin_code' => 'recursos_humanos.admin.concessao_vale_transporte_calendario'
                    )
                )
            ->end()

            ->with('Quantidade')
                ->add(
                    'quantidade',
                    'number',
                    array(
                        'label' => 'label.diaria.quantidade'
                    )
                )
            ->end()

            ->with('Concessão')
                ->add(
                    'codValeTransporte',
                    'entity',
                    array(
                        'class' => 'CoreBundle:Beneficio\ValeTransporte',
                        'choice_label' => 'codValeTransporte',
                    //                        function ($codValeTransporte) use ($entityManager) {
                    //                            $valeTransporteModel = new ValeTransporteModel($entityManager);
                    //                            $itinerario = $valeTransporteModel->getItinerario($codValeTransporte);
                    //                            $itinerario = $itinerario[0];
                    //
                    //                            $linhaOrigem =  $itinerario->getCodLinhaOrigem()->getDescricao();
                    //                            $municipioOrigem = $itinerario->getMunicipioDestino()->getNomMunicipio();
                    //                            $linhaDestino = $itinerario->getCodLinhaDestino()->getDescricao();
                    //                            $municipioDestino = $itinerario->getMunicipioDestino()->getNomMunicipio();
                    //
                    //                            return "{$municipioOrigem}/{$linhaOrigem} - {$municipioDestino}/{$linhaDestino}";
                    //                        },
                        'label' => 'label.faixadesconto.valetransporte',
                        'attr' => array(
                            'class' => 'select2-parameters '
                        )
                    )
                )
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $entityManagerContrato = $this->modelManager->getEntityManager('CoreBundle:Pessoal\ContratoServidor');
        $entityManagerValeTransporte = $this->modelManager->getEntityManager('CoreBundle:Beneficio\ValeTransporte');

        $showMapper
            ->add(
                'contratoServidorConcessaoValeTransporte.codContrato',
                'entity',
                array(
                    'label' => 'label.matricula',
                    'associated_property' => function ($contrato) use ($entityManagerContrato) {
                        $contratoServidorModel = new ContratoServidorConcessaoValeTransporteModel($entityManagerContrato);
                        $cgm = $contratoServidorModel->getCgm($contrato->getCodContrato());

                        return $cgm->getNomCgm();
                    },
                )
            )
            ->add('codConcessao')
            ->add('exercicio')
            ->add('quantidade')
            ->add('inicializado')
            ->add(
                'codValeTransporte',
                'entity',
                array(
                    'class' => 'CoreBundle:Beneficio\ValeTransporte',
                    'associated_property' => function ($codValeTransporte) use ($entityManagerValeTransporte) {
                        $valeTransporteModel = new ValeTransporteModel($entityManagerValeTransporte);
                        $itinerario = $valeTransporteModel->getItinerario($codValeTransporte);
                        $itinerario = $itinerario[0];

                        $linhaOrigem =  $itinerario->getCodLinhaOrigem()->getDescricao();
                        $municipioOrigem = $itinerario->getMunicipioDestino()->getNomMunicipio();
                        $linhaDestino = $itinerario->getCodLinhaDestino()->getDescricao();
                        $municipioDestino = $itinerario->getMunicipioDestino()->getNomMunicipio();

                        return "{$municipioOrigem}/{$linhaOrigem} - {$municipioDestino}/{$linhaDestino}";
                    },
                    'label' => 'label.faixadesconto.valetransporte',
                    'attr' => array(
                        'class' => 'select2-parameters '
                    )
                )
            )
        ;
    }

    public function prePersist($concessaoValeTransporte)
    {
        /**
         * Os acampos $utilizaGrupo e $tipoValeTransporte estão com mapped false
         * ambos são usados apenas para filtro
         */
        $utilizaGrupo = $this->getForm()->get('grupoConcessaoValeTransporte')->get('utilizarGrupo')->getData();
        $tipoValeTransporte = $this->getForm()->get('tipoValeTransporte')->getData();
        $contratoServidorConcessaoValeTransporte = $this->getForm()->get('contratoServidorConcessaoValeTransporte')->getData();

        #Esses campos são replicados em Grupo Concessao, Concessao Calendario e Contrato Servidor
        $exercicio = $concessaoValeTransporte->getExercicio();
        $codMes = $concessaoValeTransporte->getCodMes();

        /**
         * Pega o tipo do formulario:  Matrícula | CGM/Matrícula | Grupo
         * Sendo Matrícula e CGM/Matrícula, possui a mesma ação
         * Foi necessário deixa os campos com embbed form setados como mapped false, pois os mesmo são opicionais
         */
        $concessaoValeTransporte->setContratoServidorConcessaoValeTransporte($contratoServidorConcessaoValeTransporte);

        $contratoServidorConcessaoValeTransporte->setCodConcessao($concessaoValeTransporte);
        $contratoServidorConcessaoValeTransporte->setCodMes($codMes);
        $contratoServidorConcessaoValeTransporte->setExercicio($exercicio);

        $grupoConcessaoValeTransporte = $this->getForm()->get('grupoConcessaoValeTransporte') ->getData();

        $concessaoValeTransporte->setGrupoConcessaoValeTransporte($grupoConcessaoValeTransporte);

        $grupoConcessaoValeTransporte->setCodConcessao($concessaoValeTransporte);
        $grupoConcessaoValeTransporte->setCodMes($codMes);
        $grupoConcessaoValeTransporte->setExercicio($exercicio);
        $grupoConcessaoValeTransporte->setVigencia($contratoServidorConcessaoValeTransporte->getVigencia());

        /**
         * Se o campo tipoValeTransporte estiver como diário ele precisa ser amarrado à classe pai
         */
        if ($tipoValeTransporte == 'diario') {
            $concessaoValeTransporteCalendario = $this->getForm()->get('concessaoValeTransporteCalendario') ->getData();

            # Por conta dos campos com embbed form tiver que ser setado como mapped de false, é necessário referencia-los no objeto novamente
            $concessaoValeTransporte->setConcessaoValeTransporteCalendario($concessaoValeTransporteCalendario);

            $concessaoValeTransporteCalendario->setCodConcessao($concessaoValeTransporte);
            $concessaoValeTransporteCalendario->setCodMes($codMes);
            $concessaoValeTransporteCalendario->setExercicio($exercicio);
            $concessaoValeTransporte->setQuantidade(0);
        }
    }

    public function preUpdate($concessaoValeTransporte)
    {
        /**
         * Os acampos $utilizaGrupo e $tipoValeTransporte estão com mapped false
         * ambos são usados apenas para filtro
         */
        $utilizaGrupo = $this->getForm()->get('grupoConcessaoValeTransporte')->get('utilizarGrupo')->getData();
        $tipoValeTransporte = $this->getForm()->get('tipoValeTransporte')->getData();
        $contratoServidorConcessaoValeTransporte = $this->getForm()->get('contratoServidorConcessaoValeTransporte')->getData();

        #Esses campos são replicados em Grupo Concessao, Concessao Calendario e Contrato Servidor
        $exercicio = $concessaoValeTransporte->getExercicio();
        $codMes = $concessaoValeTransporte->getCodMes();

        /**
         * Pega o tipo do formulario:  Matrícula | CGM/Matrícula | Grupo
         * Sendo Matrícula e CGM/Matrícula, possui a mesma ação
         * Foi necessário deixa os campos com embbed form setados como mapped false, pois os mesmo são opicionais
         */
        $concessaoValeTransporte->setContratoServidorConcessaoValeTransporte($contratoServidorConcessaoValeTransporte);

        $contratoServidorConcessaoValeTransporte->setCodConcessao($concessaoValeTransporte);
        $contratoServidorConcessaoValeTransporte->setCodMes($codMes);
        $contratoServidorConcessaoValeTransporte->setExercicio($exercicio);

        $grupoConcessaoValeTransporte = $this->getForm()->get('grupoConcessaoValeTransporte') ->getData();

        $concessaoValeTransporte->setGrupoConcessaoValeTransporte($grupoConcessaoValeTransporte);

        $grupoConcessaoValeTransporte->setCodConcessao($concessaoValeTransporte);
        $grupoConcessaoValeTransporte->setCodMes($codMes);
        $grupoConcessaoValeTransporte->setExercicio($exercicio);
        $grupoConcessaoValeTransporte->setVigencia($contratoServidorConcessaoValeTransporte->getVigencia());

        /**
         * Se o campo tipoValeTransporte estiver como diário ele precisa ser amarrado à classe pai
         */
        if ($tipoValeTransporte == 'diario') {
            $concessaoValeTransporteCalendario = $this->getForm()->get('concessaoValeTransporteCalendario') ->getData();

            # Por conta dos campos com embbed form tiver que ser setado como mapped de false, é necessário referencia-los no objeto novamente
            $concessaoValeTransporte->setConcessaoValeTransporteCalendario($concessaoValeTransporteCalendario);

            $concessaoValeTransporteCalendario->setCodConcessao($concessaoValeTransporte);
            $concessaoValeTransporteCalendario->setCodMes($codMes);
            $concessaoValeTransporteCalendario->setExercicio($exercicio);
            $concessaoValeTransporte->setQuantidade(0);
        }
    }
}
