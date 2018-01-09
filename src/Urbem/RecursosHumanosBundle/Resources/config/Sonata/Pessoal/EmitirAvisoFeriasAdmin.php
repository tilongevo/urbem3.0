<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Administracao\Gestao;
use Urbem\CoreBundle\Entity\Administracao\Mes;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Relatorio;
use Urbem\CoreBundle\Entity\Organograma\Local;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Entity\Pessoal\Regime;
use Urbem\CoreBundle\Entity\Pessoal\SubDivisao;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Helper\ReportHelper;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Model\Organograma\OrganogramaModel;
use Urbem\CoreBundle\Model\Organograma\OrgaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Symfony\Component\HttpFoundation\Request;

class EmitirAvisoFeriasAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_ferias_emitir_aviso';
    protected $baseRoutePattern = 'recursos-humanos/pessoal/ferias/emitir-aviso';
    protected $layoutDefaultReport = '/bundles/report/gestaoRH/fontes/RPT/pessoal/report/design/EmitirAvisoFerias.rptdesign';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Gerar'];

    const COD_ACAO = '1512';

    protected $includeJs = [
        '/recursoshumanos/javascripts/pessoal/ferias/emitir-aviso.js'
    ];

    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('create'));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $em = $this->getEntityManager();

        $filter = $this->getRequest()->query->get('filter');

        $mes = '';
        if ($filter) {
            if (array_key_exists('value', $filter['mes'])) {
                $mes = $filter['mes']['value'];
            }
        }

        $periodoMovimentacaoModel = new PeriodoMovimentacaoModel($em);
        $meses = $periodoMovimentacaoModel->getMesCompetenciaFolhaPagamento($this->getExercicio());

        $fieldOptions = array();

        $fieldOptions['ano'] = array(
            'label' => 'label.emitirFerias.competenciaAno',
            'mapped' => false,
            'attr' => [
                'value' => $this->getExercicio(),
                'class' => 'numero '
            ],
        );

        $fieldOptions['mes'] = array(
            'label' => 'label.emitirFerias.competenciaMes',
            'mapped' => false,
            'placeholder' => 'label.selecione',
            'choices' => $meses,
            'attr' => [
                'data-mes' => $mes,
            ],
            'data' => end($meses)
        );

        $formMapper
            ->with('label.emitirFerias.titulo')
            ->add('ano', 'number', $fieldOptions['ano'])
            ->add('mes', 'choice', $fieldOptions['mes'])
        ->end();

        $fieldOptions['tipo'] = array(
            'mapped' => false,
            'required' => true,
            'placeholder' => 'label.selecione',
            'choices' => [
                'label.emitirFerias.cgmMatricula' => 'cgmMatricula',
                'label.emitirFerias.lotacao' => 'lotacao',
                'label.emitirFerias.local' => 'local',
                'label.emitirFerias.subDivisaoRegime' => 'subDivisao',
            ],
            'label' => 'label.emitirFerias.tipo',
            'attr' => [
                'class' => 'select2-parameters '
            ],
        );

        $fieldOptions['cgmMatricula'] = array(
            'label' => 'label.cgmmatricula',
            'class' => Contrato::class,
            'route' => [
                'name' => 'carrega_contrato_nao_rescindido'
            ],
            'multiple' => true,
            'required' => false,
            'json_choice_label' => function ($contrato) use ($em) {
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
        );

        $organogramaModel = new OrganogramaModel($em);
        $orgaoModel = new OrgaoModel($em);

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

        $fieldOptions['lotacao'] = array(
            'label' => 'label.emitirFerias.lotacao',
            'required' => false,
            'mapped' => false,
            'data' => $lotacaoArray,
            'attr' => [
                'class' => 'select2-parameters select2-multiple-options-custom ',
            ],
            'choices' => $lotacaoArray,
            'expanded' => false,
            'multiple' => true
        );

        $fieldOptions['local'] = array(
            'class' => Local::class,
            'label' => 'label.emitirFerias.local',
            'required' => false,
            'mapped' => false,
            'data' => array_flip($lotacaoArray),
            'attr' => [
                'class' => 'select2-parameters select2-multiple-options-custom '
            ],
            'expanded' => false,
            'multiple' => true
        );

        $regimes = $em->getRepository(Regime::class)->findAll();
        $regimesArray = [];
        foreach ($regimes as $regime) {
            $regimesArray[$regime->getCodRegime() . " - " . $regime->getDescricao()] = $regime->getCodRegime();
        }

        $fieldOptions['regime'] = array(
            'choices' => $regimesArray,
            'data' => $regimesArray,
            'label' => 'label.emitirFerias.regime',
            'expanded' => false,
            'attr' => [
                'class' => 'select2-parameters select2-multiple-options-custom '
            ],
            'mapped' => false,
            'required' => false,
            'multiple' => true,
        );

        $subDivisoes = $em->getRepository(SubDivisao::class)->findAll();
        $subDivisoesArray = [];
        foreach ($subDivisoes as $subDivisao) {
            $subDivisoesArray[$subDivisao->getCodSubDivisao() . " - " . $subDivisao->getDescricao()] = $subDivisao->getCodSubDivisao();
        }

        $fieldOptions['subDivisao'] = array(
            'choices' => $subDivisoesArray,
            'data' => $subDivisoesArray,
            'label' => 'label.emitirFerias.subDivisao',
            'expanded' => false,
            'required' => false,
            'attr' => ['class' => 'select2-parameters select2-multiple-options-custom '],
            'mapped' => false,
            'multiple' => true,
        );

        $formMapper
            ->with('Tipo de Filtro')
            ->add('tipo', 'choice', $fieldOptions['tipo'])
            ->add('cgmMatricula', 'autocomplete', $fieldOptions['cgmMatricula'])
            ->add('lotacao', 'choice', $fieldOptions['lotacao'])
            ->add('local', 'entity', $fieldOptions['local'])
            ->add('regime', 'choice', $fieldOptions['regime'])
            ->add('subDivisao', 'choice', $fieldOptions['subDivisao'])
            ->end();

        $fieldOptions['lotacaoFilter'] = array(
            'mapped' => false,
            'required' => false,
            'placeholder' => 'label.selecione',
            'choices' => [
                'label.emitirFerias.alfabetica' => 'orgao',
                'label.emitirFerias.numerica' => 'cod_orgao',
            ],
            'label' => 'label.emitirFerias.lotacao',
            'attr' => [
                'class' => 'select2-parameters '
            ],
        );

        $fieldOptions['regimeFilter'] = array(
            'mapped' => false,
            'required' => false,
            'placeholder' => 'label.selecione',
            'choices' => [
                'label.emitirFerias.alfabetica' => 'regime',
                'label.emitirFerias.numerica' => 'contrato_servidor.cod_regime',
            ],
            'label' => 'label.emitirFerias.regime',
            'attr' => [
                'class' => 'select2-parameters '
            ],
        );

        $fieldOptions['matriculaFilter'] = array(
            'mapped' => false,
            'required' => false,
            'placeholder' => 'label.selecione',
            'choices' => [
                'label.emitirFerias.alfabetica' => 'sw_cgm.nom_cgm',
                'label.emitirFerias.numerica' => 'contrato.registro',
            ],
            'label' => 'label.emitirFerias.matriculaServidor',
            'attr' => [
                'class' => 'select2-parameters '
            ],
        );

        $formMapper
            ->with('Ordenação')
            ->add('lotacaoFilter', 'choice', $fieldOptions['lotacaoFilter'])
            ->add('regimeFilter', 'choice', $fieldOptions['regimeFilter'])
            ->add('matriculaFilter', 'choice', $fieldOptions['matriculaFilter'])
            ->end();
    }

    /**
     * @return array
     */
    public function getMesCompetencia()
    {
        $entityManager = $this->getEntityManager();
        $periodoMovimentacao = new PeriodoMovimentacaoModel($entityManager);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        $periodoUnico = reset($periodoUnico);

        $meses = $entityManager->getRepository(Mes::class)->findAll();

        $arData = explode("/", $periodoUnico->dt_final);
        $inAno = (int) $arData[2];
        $inCodMes = (int) $arData[1];

        $options = [];
        foreach ($meses as $mes) {
            if ($inAno <= (int) $this->getExercicio()) {
                if ($mes->getCodMes() >= $inCodMes) {
                    $options[trim($mes->getDescricao())] = $mes->getCodMes();
                }
            }
        }

        return $options;
    }

    public function prePersist($object)
    {
        // sql só aceita string do mês com 2 caracteres. Necessário o zero à esquerda
        $mesCompetencia = (string) $this->getForm()->get('mes')->getData();
        if (strlen($mesCompetencia) == 1) {
            $mesCompetencia = '0'.$mesCompetencia;
        }

        $cgmMatriculas = $this->getFormField($this->getForm(), 'cgmMatricula');
        $lotacoes = $this->getFormField($this->getForm(), 'lotacao');
        $locais = $this->getFormField($this->getForm(), 'local');
        $regimes = $this->getFormField($this->getForm(), 'regime');
        $subDivisoes = $this->getFormField($this->getForm(), 'subDivisao');
        $lotacaoFilter = $this->getFormField($this->getForm(), 'lotacaoFilter');
        $regimeFilter = $this->getFormField($this->getForm(), 'regimeFilter');
        $matriculaFilter = $this->getFormField($this->getForm(), 'matriculaFilter');

        $fileName = $this->parseNameFile("EmissaoAvisoFerias");

        $params = [
            'term_user' => $this->getCurrentUser()->getUserName(),
            'cod_acao' => self::COD_ACAO,
            'exercicio' => $this->getExercicio(),
            'inCodGestao' => Gestao::GESTAO_RECURSOS_HUMANOS,
            'inCodModulo' => Modulo::MODULO_PESSOAL ,
            'inCodRelatorio' => Relatorio::RECURSOS_HUMANOS_PESSOAL_FERIAS_EMITIR_AVISO_FERIAS,
            'stEntidade' => '',
            'stcodEntidade' => (string) $this->getEntidade()->getCodEntidade(),
            'mesCompetencia' =>  $mesCompetencia,
            'anoCompetencia' => (string) $this->getForm()->get('ano')->getData(),
            'OrderBy' => $this::getOrderBy(array($lotacaoFilter, $regimeFilter, $matriculaFilter)),
            'codSubDivisao' => ReportHelper::getValoresComVirgula($subDivisoes, ''),
            'codRegime' => ReportHelper::getValoresComVirgula($regimes, ''),
            'codMatricula' => ReportHelper::getValoresComVirgula($cgmMatriculas, 'registro'),
            'codLotacao' => $lotacoes = ReportHelper::getValoresComVirgula($lotacoes, ''),
            'codLocal' => ReportHelper::getValoresComVirgula($locais, 'codLocal')
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

    /**
     * @param $form
     * @param $fieldName
     * @return string
     */
    public function getFormField($form, $fieldName)
    {
        return ($form->get($fieldName)->getData()) ? $form->get($fieldName)->getData() : '';
    }

    /**
     * @param $params
     * @return bool|string
     */
    private function getOrderBy($params)
    {

        $orderBy = '';

        foreach ($params as $param) {
            if ($param) {
                $orderBy .= $param.', ';
            }
        }
        $orderBy = substr($orderBy, 0, -2);

        if (!$orderBy) {
            $orderBy = 'null';
        }

        return $orderBy;
    }

    /**
     * @param mixed $object
     * @return mixed|string|EmitirAvisoFeriasAdmin
     */
    public function toString($object)
    {
        return $object instanceof EmitirAvisoFeriasAdmin
            ? $object
            : $this->getTranslator()->trans('label.emitirFerias.titulo');
    }
}
