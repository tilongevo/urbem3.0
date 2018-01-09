<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Model\Folhapagamento\ComplementarModel;
use Urbem\CoreBundle\Model\Folhapagamento\FolhaComplementarModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class EventosContratoReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_relatorios_eventos_contrato';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/relatorios/eventos-contrato';
    protected $layoutDefaultReport = '/bundles/report/gestaoRH/fontes/RPT/folhaPagamento/report/design/eventosPorContrato.rptdesign';

    public function prePersist($object)
    {
        $filtro = $this->configureFilters($object);

        $fileName = $this->parseNameFile("eventosPorContrato");

        $complementar = null;
        if ($object->getFolhaComplementar()) {
            $complementar = (string) $object->getFolhaComplementar();
        }

        $params = [
            // Códigos contidos no menu
            'cod_acao' => '1351',
            'inCodGestao' => '4',
            'inCodModulo' => '27',
            'inCodRelatorio' => '18',
            // Entidade escolhida no combo de RH
            'stEntidade' => '',
            'entidade' => '',
            // Itens exclusivos deste relatório
            'exercicio' => $object->getCompetencia()->format("Y"),
            'inCodPeriodoMovimentacao' => '551',
            'stTipoFiltro' => $filtro['stTipoFiltro'],
            'stCodigos' => $filtro['stCodigos'],
            'inCodConfiguracao' => $object->getTipoCalculo() ? $object->getTipoCalculo() : null,
            'inCodComplementar' => $complementar,
        ];

        $apiService = $this->getReportService();
        $apiService->setReportNameFile($fileName);
        $apiService->setLayoutDefaultReport($this->layoutDefaultReport);
        $res = $apiService->getReportContent($params);

        $this->parseContentToPdf(
            $res->getBody()->getContents(),
            $fileName
        );
    }

    private function configureFilters($object)
    {
        if ($object->getTipoFiltro() == 1) { // Matricula
            $matriculas = $object->getMatricula();
            $matriculasString = ArrayHelper::parseCollectionToString($matriculas, 'getNumCgm', ',');
            return [
                'stCodigos' => $matriculasString,
                'stTipoFiltro' => 'matricula'
            ];
        }

        if ($object->getTipoFiltro() == 2) { // Lotacao
            $lotacoes = $object->getLotacao();
            $lotacoesString = ArrayHelper::parseCollectionToString($lotacoes, 'getCodOrgao', ',');
            return [
                'stCodigos' => $lotacoesString,
                'stTipoFiltro' => 'lotacao'
            ];
        }

        if ($object->getTipoFiltro() == 3) { // Local
            $locais = $object->getLocal();

            $locaisString = ArrayHelper::parseCollectionToString($locais, 'getCodLocal', ',');
            return [
                'stCodigos' => $locaisString,
                'stTipoFiltro' => 'local'
            ];
        }

        if ($object->getTipoFiltro() == 4) { // Evento
            $eventos = $object->getEvento();
            $eventosString = ArrayHelper::parseCollectionToString($eventos, 'getCodEvento', ',');
            return [
                'stCodigos' => $eventosString,
                'stTipoFiltro' => 'evento'
            ];
        }

        return [
            'stCodigos' => null,
            'stTipoFiltro' => 'geral'
        ];
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('competencia')
            ->add('matricula')
            ->add('lotacao')
            ->add('local')
            ->add('evento')
            ->add('tipoCalculo')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('competencia')
            ->add('matricula')
            ->add('lotacao')
            ->add('local')
            ->add('evento')
            ->add('tipoCalculo')
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

        $formMapper
            ->with("Eventos por Contrato")
                ->add(
                    'competencia',
                    'date',
                    array(
                        'label' => 'Competência',
                        'widget' => 'single_text',
                        'html5' => false,
                        'attr' => array(
                            'data-provide' => 'datepicker',
                            'class' => 'datepicker '
                        ),
                        'format' => 'MM/dd/yyyy',
                    )
                )
            ->end()
            ->with("Filtro")
                ->add(
                    'tipoFiltro',
                    'choice',
                    [
                        'required' => true,
                        'choices' => [
                            'label.geral' => 0,
                            'label.matricula' => 1,
                            'label.lotacao' => 2,
                            'label.local' => 3,
                            'label.evento' => 4,
                        ],
                        'label' => 'label.tipoFiltro',
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    ]
                )
                ->add(
                    'matricula',
                    'entity',
                    array(
                        'class' => 'CoreBundle:SwCgmPessoaFisica',
                        'choice_label' => 'numcgm.nomCgm',
                        'label' => 'Matrícula',
                        'multiple' => true,
                        'required' => false,
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    )
                )
                ->add(
                    'lotacao',
                    'entity',
                    array(
                        'class' => 'CoreBundle:Organograma\Orgao',
                        'choice_label' => 'siglaOrgao',
                        'label' => 'Lotação',
                        'multiple' => true,
                        'required' => false,
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    )
                )
                ->add(
                    'local',
                    'entity',
                    array(
                        'class' => 'CoreBundle:Organograma\Local',
                        'choice_label' => 'descricao',
                        'label' => 'Locais',
                        'multiple' => true,
                        'required' => false,
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    )
                )
                ->add(
                    'evento',
                    'entity',
                    array(
                        'class' => 'CoreBundle:Folhapagamento\Evento',
                        'choice_label' => 'descricao',
                        'label' => 'Eventos',
                        'multiple' => true,
                        'required' => false,
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    )
                )
            ->end()
            ->with("Tipo")
                ->add(
                    'tipoCalculo',
                    'choice',
                    array(
                        'choices' => array(
                            'Complementar' => '0',
                            'Salário' => '1',
                            'Férias' => '2',
                            '13o Salário' => '3',
                            'Rescisao' => '4',
                        ),
                        'placeholder' => 'label.selecione',
                        'multiple' => false,
                        'label' => 'Tipo de cálculo',
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    )
                )
                ->add(
                    'folhaComplementar',
                    'entity',
                    array(
                        'class' => 'CoreBundle:Folhapagamento\Complementar',
                        'choice_label' => 'cod_complementar',
                        'multiple' => false,
                        'label' => 'label.folhaComplementar',
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
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

        $showMapper
            ->add('competencia')
            ->add('matricula')
            ->add('lotacao')
            ->add('local')
            ->add('evento')
            ->add('tipoCalculo')
        ;
    }
}
