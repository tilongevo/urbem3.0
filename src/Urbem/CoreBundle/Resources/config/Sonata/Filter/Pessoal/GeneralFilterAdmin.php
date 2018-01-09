<?php

namespace Urbem\CoreBundle\Resources\config\Sonata\Filter\Pessoal;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Folhapagamento\Evento;
use Urbem\CoreBundle\Entity\Organograma\Local;
use Urbem\CoreBundle\Entity\Pessoal\Cargo;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Entity\Pessoal\Especialidade;
use Urbem\CoreBundle\Entity\Pessoal\Regime;
use Urbem\CoreBundle\Entity\Pessoal\SubDivisao;
use Urbem\CoreBundle\Model\Folhapagamento\EventoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PadraoModel;
use Urbem\CoreBundle\Model\Organograma\OrganogramaModel;
use Urbem\CoreBundle\Model\Organograma\OrgaoModel;
use Urbem\CoreBundle\Model\Pessoal\CargoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

class GeneralFilterAdmin extends AbstractAdmin
{
    const RECURSOSHUMANOS_FOLHA_TERMORESCISAO = ['codContrato', 'reg_sub_car_esp_grupo', 'codContratoRescisao', 'padrao', 'funcao','evento'];
    const RECURSOSHUMANOS_FOLHA_RECIBOFERIAS = ['funcao', 'reg_sub_car_esp_grupo', 'padrao', 'matricula', 'codContratoRescisao','evento'];
    const RECURSOSHUMANOS_FOLHA_CONTRACHEQUE = ['funcao', 'reg_sub_car_esp_grupo', 'padrao', 'matricula', 'codContratoRescisao','evento'];
    const RECURSOSHUMANOS_FOLHA_CONTRIBUICAOPREVIDENCIARIA = ['funcao', 'reg_sub_car_esp_grupo', 'padrao', 'codContratoRescisao','evento'];
    const RECURSOSHUMANOS_FOLHA_CUSTOMIZAVELEVENTOS = ['funcao', 'codContratoRescisao','evento'];
    const RECURSOSHUMANOS_FOLHA_CALCULOSALARIO = ['funcao', 'padrao', 'matricula', 'reg_sub_car_esp_grupo', 'codContratoRescisao','evento'];
    const RECURSOSHUMANOS_FOLHA_REGISTRAREVENTORESCISAOCONTRATO = ['funcao', 'reg_sub_car_esp_grupo', 'padrao', 'codContrato', 'codContratoRescisao','evento'];
    const RECURSOSHUMANOS_FOLHA_REGISTRAREVENTO = ['funcao', 'reg_sub_car_esp_grupo', 'padrao', 'matricula', 'codContratoRescisao','evento'];
    const RECURSOSHUMANOS_IMA_ARQUIVOIPERS = ['funcao', 'reg_sub_car_esp_grupo', 'padrao', 'matricula', 'codContratoRescisao','evento'];
    const RECURSOSHUMANOS_PESSOAL_RESCISAO_CONTRATO_SERVIDOR = ['funcao', 'reg_sub_car_esp_grupo', 'padrao', 'matricula', 'lotacao', 'local', 'geral','evento'];
    const RECURSOSHUMANOS_FOLHA_FICHA_FINANCEIRA = ['funcao', 'reg_sub_car_esp_grupo', 'padrao', 'matricula'];
    const RECURSOSHUMANOS_FOLHA_CONCEDER_DECIMO = ['funcao', 'reg_sub_car_esp_grupo', 'padrao', 'matricula', 'evento'];
    const RECURSOSHUMANOS_FOLHA_CALCULAR_DECIMO = ['funcao', 'reg_sub_car_esp_grupo', 'padrao', 'matricula', 'evento', 'local'];

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureGridFilters(DatagridMapper $datagridMapper, $camposARetirar = [])
    {
        $this->setIncludeJs(array_merge(parent::getIncludeJs(), [
            '/core/javascripts/generalfilter/form--filter.js',
        ]));

        $entityManager = $this->getDoctrine();

        $organogramaModel = new OrganogramaModel($entityManager);
        $orgaoModel = new OrgaoModel($entityManager);

        $resOrganograma = $organogramaModel->getOrganogramaVigentePorTimestamp();
        $codOrganograma = $resOrganograma['cod_organograma'];
        $dataFinal = $resOrganograma['dt_final'];
        $lotacoes = $orgaoModel->montaRecuperaOrgaos($dataFinal, $codOrganograma);

        $lotacaoArray = [];
        foreach ($lotacoes as $lotacao) {
            $key = $lotacao->cod_orgao;
            $value = $lotacao->cod_estrutural . " - " . $lotacao->descricao;
            $lotacaoArray[$value] = $key;
        }

        $formGridOptions = [];

        $opcoes = [];
        if (!in_array('codContrato', $camposARetirar)) {
            $opcoes = array_merge(['cgm' => 'cgm_contrato'], $opcoes);
        }
        if (!in_array('lotacao', $camposARetirar)) {
            $opcoes = array_merge(['lotacao' => 'lotacao'], $opcoes);
        }
        if (!in_array('local', $camposARetirar)) {
            $opcoes = array_merge(['local' => 'local'], $opcoes);
        }
        if (!in_array('funcao', $camposARetirar)) {
            $opcoes = array_merge(['funcao' => 'funcao'], $opcoes);
        }
        if (!in_array('reg_sub_car_esp_grupo', $camposARetirar)) {
            $opcoes = array_merge(['Regime/Subdivisão/Cargo/Especialidade' => 'reg_sub_car_esp_grupo'], $opcoes);
        }
        if (!in_array('geral', $camposARetirar)) {
            $opcoes = array_merge(['geral' => 'geral'], $opcoes);
        }
        if (!in_array('padrao', $camposARetirar)) {
            $opcoes = array_merge(['Padrão' => 'padrao'], $opcoes);
        }
        if (!in_array('matricula', $camposARetirar)) {
            $opcoes = array_merge(['cgm' => 'matricula'], $opcoes);
        }
//        if (!in_array('codContratoRescisao', $camposARetirar)) {
//            $opcoes = array_merge(['cgm' => 'codContratoRescisao'], $opcoes);
//        }

        $formGridOptions['tipo'] = [
            'label' => 'label.recursosHumanos.folhas.grid.tipo',
            'mapped' => false,
            'callback' => [$this, 'getSearchFilter'],
        ];

        $formGridOptions['tipoChoices'] = [
            'choices' => $opcoes,
            'expanded' => false,
            'multiple' => false,
            'placeholder' => 'label.selecione',
            'attr' => [
                'required' => true,
                'class' => 'select2-parameters '
            ],
        ];

        $formGridOptions['fkPessoalContratoServidor'] = [
            'label' => 'label.cgmmatricula',
            'callback' => [
                $this,
                'getSearchFilter'
            ],
        ];

        $formGridOptions['fkPessoalContratoServidorChoices'] = [
            'class' => Contrato::class,
            'route' => [
                'name' => 'carrega_contrato_nao_rescindido'
            ],
            'multiple' => true,
            'json_choice_label' => function ($contrato) use ($entityManager) {
                if (!is_null($contrato->getFkPessoalContratoServidor())) {
                    $nomcgm = $contrato->getRegistro() . " - " . $contrato->getFkPessoalContratoServidor()
                            ->getFkPessoalServidorContratoServidores()->last()
                            ->getFkPessoalServidor()
                            ->getFkSwCgmPessoaFisica()
                            ->getFkSwCgm();
                } else {
                    $nomcgm = "Não localizado";
                }

                return $nomcgm;
            },
            'attr'        => ['class' => 'select2-parameters select2-multiple-options-custom '],
            'mapped' => false
        ];

        $formGridOptions['lotacao'] = [
            'label' => 'label.recursosHumanos.folhas.grid.lotacao',
            'callback' => [$this, 'getSearchFilter'],
            'required' => true,
            'mapped' => false,
            'attr'        => ['class' => 'select2-parameters select2-multiple-options-custom '],
        ];

        $formGridOptions['lotacaoChoices'] = [
            'choices' => $lotacaoArray,
            'expanded' => false,
            'multiple' => true,
            'attr'        => ['class' => 'select2-parameters select2-multiple-options-custom '],
        ];

        $formGridOptions['local'] = [
            'label' => 'label.recursosHumanos.folhas.grid.local',
            'callback' => [$this, 'getSearchFilter'],
            'required' => true,
            'mapped' => false,
            'attr'        => ['class' => 'select2-parameters select2-multiple-options-custom '],
        ];

        $formGridOptions['localChoices'] = [
            'class' => Local::class,
            'expanded' => false,
            'multiple' => true,
            'attr'        => ['class' => 'select2-parameters select2-multiple-options-custom '],
        ];

        $formGridOptions['funcao'] = [
            'label' => 'funcao',
            'callback' => [$this, 'getSearchFilter'],
            'required' => true,
            'mapped' => false,
            'attr'        => ['class' => 'select2-parameters select2-multiple-options-custom '],
        ];

        $formGridOptions['funcaoChoices'] = [
            'class' => Cargo::class,
            'expanded' => false,
            'multiple' => true,
            'attr'        => ['class' => 'select2-parameters select2-multiple-options-custom '],
        ];

        $formGridOptions['matricula'] = [
            'label' => 'label.cgmmatricula',
            'callback' => [$this, 'getSearchFilter']
        ];

        $formGridOptions['matriculaChoices'] = [
            'class' => Contrato::class,
            'route' => [
                'name' => 'carrega_contrato_rescindido'
            ],
            'multiple' => true,
            'json_choice_label' => function ($contrato) use ($entityManager) {
                if (!is_null($contrato->getFkPessoalContratoServidor())) {
                    $nomcgm = $contrato->getRegistro() . " - " . $contrato->getFkPessoalContratoServidor()
                            ->getFkPessoalServidorContratoServidores()->last()
                            ->getFkPessoalServidor()
                            ->getFkSwCgmPessoaFisica()
                            ->getFkSwCgm();
                } else {
                    $nomcgm = "Não localizado";
                }

                return $nomcgm;
            },
            'attr'        => ['class' => 'select2-parameters select2-multiple-options-custom '],
            'mapped' => false
        ];

        $datagridMapper->add(
            'tipo',
            'doctrine_orm_callback',
            $formGridOptions['tipo'],
            'choice',
            $formGridOptions['tipoChoices']
        );
        if (!in_array('codContrato', $camposARetirar)) {
            $datagridMapper->add(
                'codContrato',
                'doctrine_orm_callback',
                $formGridOptions['fkPessoalContratoServidor'],
                'autocomplete',
                $formGridOptions['fkPessoalContratoServidorChoices']
            );
        }
        if (!in_array('lotacao', $camposARetirar)) {
            $datagridMapper->add(
                'lotacao',
                'doctrine_orm_callback',
                $formGridOptions['lotacao'],
                'choice',
                $formGridOptions['lotacaoChoices']
            );
        }
        if (!in_array('local', $camposARetirar)) {
            $datagridMapper->add(
                'local',
                'doctrine_orm_callback',
                $formGridOptions['local'],
                'entity',
                $formGridOptions['localChoices']
            );
        }
        if (!in_array('funcao', $camposARetirar)) {
            $datagridMapper->add(
                'funcao',
                'doctrine_orm_callback',
                $formGridOptions['funcao'],
                'entity',
                $formGridOptions['funcaoChoices']
            );
        }
        if (!in_array('matricula', $camposARetirar)) {
            $datagridMapper->add(
                'matricula',
                'doctrine_orm_callback',
                $formGridOptions['matricula'],
                'autocomplete',
                $formGridOptions['matriculaChoices']
            );
        }
//        if (!in_array('codContratoRescisao', $camposARetirar)) {
//            $datagridMapper->add(
//                'codContratoRescisao',
//                'doctrine_orm_callback',
//                $formGridOptions['codContratoRescisao'],
//                'autocomplete',
//                $formGridOptions['codContratoRescisaoChoices']
//            );
//        }
    }

    /**
     * @param $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     *
     * @return bool|void
     */
    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
    }

    /**
     * @param FormMapper $form
     * @param array      $camposARetirar
     */
    protected function configureFields(FormMapper $form, $camposARetirar = [])
    {
        $this->setIncludeJs(array_merge(parent::getIncludeJs(), [
            '/core/javascripts/generalfilter/formMapper--filter.js',
        ]));

        /** @var EntityManager $entityManager */
        $entityManager = $this->getDoctrine();

        /** @var OrganogramaModel $organogramaModel */
        $organogramaModel = new OrganogramaModel($entityManager);
        /** @var OrgaoModel $orgaoModel */
        $orgaoModel = new OrgaoModel($entityManager);

        $resOrganograma = $organogramaModel->getOrganogramaVigentePorTimestamp();
        $codOrganograma = $resOrganograma['cod_organograma'];
        $dataFinal = $resOrganograma['dt_final'];
        $lotacoes = $orgaoModel->montaRecuperaOrgaos($dataFinal, $codOrganograma);

        $lotacaoArray = [];
        foreach ($lotacoes as $lotacao) {
            $key = $lotacao->cod_orgao;
            $value = $lotacao->cod_estrutural . " - " . $lotacao->descricao;
            $lotacaoArray[$value] = $key;
        }

        $eventoModel = new EventoModel($entityManager);
        $eventos = $eventoModel->getEventoByParams(['P', 'D', 'B', 'I'], false, false);

        foreach ($eventos as $evento) {
            $codEventos[] = $evento;
        }

        $formGridOptions = [];

        $opcoes = [];
        if (!in_array('codContrato', $camposARetirar)) {
            $opcoes = array_merge(['cgm' => 'cgm_contrato'], $opcoes);
        }
        if (!in_array('lotacao', $camposARetirar)) {
            $opcoes = array_merge(['lotacao' => 'lotacao'], $opcoes);
        }
        if (!in_array('evento', $camposARetirar)) {
            $opcoes = array_merge(['evento' => 'evento'], $opcoes);
        }
        if (!in_array('local', $camposARetirar)) {
            $opcoes = array_merge(['local' => 'local'], $opcoes);
        }
        if (!in_array('funcao', $camposARetirar)) {
            $opcoes = array_merge(['funcao' => 'funcao'], $opcoes);
        }
        if (!in_array('reg_sub_car_esp_grupo', $camposARetirar)) {
            $opcoes = array_merge(['Regime/Subdivisão/Cargo/Especialidade' => 'reg_sub_car_esp_grupo'], $opcoes);
        }
        if (!in_array('padrao', $camposARetirar)) {
            $opcoes = array_merge(['Padrão' => 'padrao'], $opcoes);
        }
        if (!in_array('matricula', $camposARetirar)) {
            $opcoes = array_merge(['label.cgmmatricula' => 'matricula'], $opcoes);
        }
        if (!in_array('geral', $camposARetirar)) {
            $opcoes = array_merge(['geral' => 'geral'], $opcoes);
        }

        $formGridOptions['tipo'] = [
            'label' => 'label.recursosHumanos.folhas.grid.tipo',
            'mapped' => false,
            'choices' => $opcoes,
            'expanded' => false,
            'multiple' => false,
            'placeholder' => 'label.selecione',
            'attr' => [
                'required' => true,
                'class' => 'select2-parameters '
            ],
        ];

        $formGridOptions['fkPessoalContratoServidor'] = [
            'label' => 'label.cgmmatricula',
            'class' => Contrato::class,
            'route' => [
                'name' => 'carrega_contrato_nao_rescindido'
            ],
            'multiple' => true,
            'json_choice_label' => function ($contrato) use ($entityManager) {
                if (!is_null($contrato->getFkPessoalContratoServidor())) {
                    $nomcgm = $contrato->getFkPessoalContratoServidor()
                        ->getFkPessoalServidorContratoServidores()->last()
                        ->getFkPessoalServidor()
                        ->getFkSwCgmPessoaFisica()
                        ->getFkSwCgm()
                        ->getNomcgm();
                } else {
                    $nomcgm = "Não localizado";
                }

                return $nomcgm;
            },
            'attr'        => ['class' => 'select2-parameters select2-multiple-options-custom '],
            'mapped' => false
        ];

        $formGridOptions['lotacao'] = [
            'label' => 'label.recursosHumanos.folhas.grid.lotacao',
            'required' => true,
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters select2-multiple-options-custom ',
            ],
            'choices' => $lotacaoArray,
            'expanded' => false,
            'multiple' => true
        ];

        $formGridOptions['local'] = [
            'label' => 'label.recursosHumanos.folhas.grid.local',
            'required' => true,
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters select2-multiple-options-custom '
            ],
            'class' => Local::class,
            'expanded' => false,
            'multiple' => true
        ];

        $formGridOptions['evento'] = [
            'label' => 'label.recursosHumanos.folhas.grid.evento',
            'required' => true,
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters select2-multiple-options-custom '
            ],
            'class' => Evento::class,
            'choice_label' => function ($evento) {
                return $evento->getCodigo() . ' - ' . $evento->getDescricao();
            },
            'label' => 'label.recursosHumanos.contratoServidorPeriodo.evento',
            'query_builder' => function (EntityRepository $repo) use ($codEventos) {
                $qb = $repo->createQueryBuilder('e');
                $qb->where(
                    $qb->expr()->In('e.codigo', $codEventos)
                );

                return $qb;
            },
            'expanded' => false,
            'multiple' => true
        ];

        $formGridOptions['funcao'] = [
            'class' => Cargo::class,
            'expanded' => false,
            'multiple' => true,
            'label' => 'funcao',
            'required' => true,
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters select2-multiple-options-custom '
            ],
        ];

        /** @var Regime $regimes */
        $regimes = $entityManager->getRepository(Regime::class)->findAll();
        $regimesArray = [];
        /** @var Regime $regime */
        foreach ($regimes as $regime) {
            $regimesArray[$regime->getCodRegime() . " - " . $regime->getDescricao()] = $regime->getCodRegime();
        }

        $formGridOptions['regime'] = [
            'choices' => $regimesArray,
            'label' => 'label.recursosHumanos.relatorios.folha.customizavelEventos.regime',
            'expanded' => false,
            'attr' => ['class' => 'select2-parameters'],
            'mapped' => false,
            'multiple' => true,
        ];

        /** @var SubDivisao $subDivisoes */
        $subDivisoes = $entityManager->getRepository(SubDivisao::class)->findAll();
        $subDivisoesArray = [];
        /** @var SubDivisao $subDivisao */
        foreach ($subDivisoes as $subDivisao) {
            $subDivisoesArray[$subDivisao->getCodSubDivisao() . " - " . $subDivisao->getDescricao()] = $subDivisao->getCodSubDivisao();
        }

        $formGridOptions['subdivisao'] = [
            'choices' => $subDivisoesArray,
            'label' => 'label.recursosHumanos.relatorios.folha.customizavelEventos.subdivisao',
            'expanded' => false,
            'attr' => ['class' => 'select2-parameters select2-multiple-options-custom '],
            'mapped' => false,
            'multiple' => true,
        ];

        /** @var CargoModel $cargoModel */
        $cargoModel = new CargoModel($entityManager);
        $cargos = $cargoModel->consultaCargoSubDivisoes(array_values($subDivisoesArray));

        $formGridOptions['cargo'] = [
            'choices' => $cargos,
            'label' => 'label.recursosHumanos.relatorios.folha.customizavelEventos.cargo',
            'expanded' => false,
            'multiple' => true,
            'attr' => ['class' => 'select2-parameters select2-multiple-options-custom '],
            'mapped' => false,
        ];

        /** @var Especialidade $especialidades */
        $especialidades = $entityManager->getRepository(Especialidade::class)->findAll();
        $especialidadesArray = [];
        /** @var Especialidade $especialidade */
        foreach ($especialidades as $especialidade) {
            $especialidadesArray[$especialidade->getCodEspecialidade() . " - " . $especialidade->getDescricao()] = $especialidade->getCodEspecialidade();
        }

        $formGridOptions['especialidade'] = [
            'choices' => $especialidadesArray,
            'label' => 'label.recursosHumanos.relatorios.folha.customizavelEventos.especialidade',
            'expanded' => false,
            'multiple' => true,
            'attr' => ['class' => 'select2-parameters select2-multiple-options-custom '],
            'mapped' => false,
        ];

        $padraoModel = new PadraoModel($entityManager);
        $padroes = $padraoModel->getPadraoFilter();
        $padraoArray = [];

        foreach ($padroes as $padrao) {
            $padraoArray[$padrao->cod_padrao . " - " . $padrao->descricao] = $padrao->cod_padrao;
        }

        $formGridOptions['padrao'] = [
            'choices' => $padraoArray,
            'label' => 'label.recursosHumanos.relatorios.folha.customizavelEventos.padrao',
            'expanded' => false,
            'multiple' => true,
            'attr' => ['class' => 'select2-parameters select2-multiple-options-custom '],
            'mapped' => false,
        ];

        $formGridOptions['matricula'] = [
            'label' => 'label.cgmmatricula',
            'class' => Contrato::class,
            'route' => [
                'name' => 'carrega_contrato_rescindido'
            ],
            'multiple' => true,
            'json_choice_label' => function ($contrato) use ($entityManager) {
                if (!is_null($contrato->getFkPessoalContratoServidor())) {
                    $nomcgm = $contrato->getFkPessoalContratoServidor()
                        ->getFkPessoalServidorContratoServidores()->last()
                        ->getFkPessoalServidor()
                        ->getFkSwCgmPessoaFisica()
                        ->getFkSwCgm()
                        ->getNomcgm();
                } else {
                    $nomcgm = "Não localizado";
                }

                return $nomcgm;
            },
            'attr' => [
                'class' => 'select2-parameters select2-multiple-options-custom '
            ],
            'mapped' => false
        ];

        $form->add('tipo', 'choice', $formGridOptions['tipo']);
        if (!in_array('codContrato', $camposARetirar)) {
            $form->add('codContrato', 'autocomplete', $formGridOptions['fkPessoalContratoServidor']);
        }
        if (!in_array('lotacao', $camposARetirar)) {
            $form->add('lotacao', 'choice', $formGridOptions['lotacao']);
        }
        if (!in_array('local', $camposARetirar)) {
            $form->add('local', 'entity', $formGridOptions['local']);
        }
        if (!in_array('evento', $camposARetirar)) {
            $form->add('evento', 'entity', $formGridOptions['evento']);
        }
        if (!in_array('funcao', $camposARetirar)) {
            $form->add('funcao', 'entity', $formGridOptions['funcao']);
        }
        if (!in_array('reg_sub_car_esp_grupo', $camposARetirar)) {
            $form->add('regime', 'choice', $formGridOptions['regime']);
        }
        if (!in_array('reg_sub_car_esp_grupo', $camposARetirar)) {
            $form->add('subdivisao', 'choice', $formGridOptions['subdivisao']);
        }
        if (!in_array('reg_sub_car_esp_grupo', $camposARetirar)) {
            $form->add('cargo', 'choice', $formGridOptions['cargo']);
        }
        if (!in_array('reg_sub_car_esp_grupo', $camposARetirar)) {
            $form->add('especialidade', 'choice', $formGridOptions['especialidade']);
        }
        if (!in_array('padrao', $camposARetirar)) {
            $form->add('padrao', 'choice', $formGridOptions['padrao']);
        }
        if (!in_array('matricula', $camposARetirar)) {
            $form->add('matricula', 'autocomplete', $formGridOptions['matricula']);
        }

        $camposStr = (!empty($camposARetirar)) ? implode(",", $camposARetirar) : '';

        $form->add('camposARetirar', 'hidden', ['mapped' => false, 'data' => $camposStr]);
    }
}
