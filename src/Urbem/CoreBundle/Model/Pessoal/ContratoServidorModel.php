<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Folhapagamento\Previdencia;
use Urbem\CoreBundle\Entity\Organograma\OrgaoNivel;
use Urbem\CoreBundle\Entity\Pessoal\AtributoContratoServidorValor;
use Urbem\CoreBundle\Entity\Pessoal\Cargo;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidor;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidorContaFgts;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidorContaSalario;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidorEspecialidadeCargo;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidorExameMedico;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidorFormaPagamento;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidorFuncao;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidorInicioProgressao;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidorLocal;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidorNomeacaoPosse;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidorOcorrencia;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidorOrgao;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidorPadrao;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidorPrevidencia;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidorRegimeFuncao;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSalario;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSindicato;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSubDivisaoFuncao;
use Urbem\CoreBundle\Entity\Pessoal\Especialidade;
use Urbem\CoreBundle\Entity\Pessoal\Servidor;
use Urbem\CoreBundle\Entity\Pessoal\ServidorContratoServidor;
use Urbem\CoreBundle\Entity\Pessoal\SubDivisao;
use Urbem\CoreBundle\Entity\Pessoal\TipoSalario;
use Urbem\CoreBundle\Helper\StringHelper;
use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\RecursosHumanosBundle\Helper\Constants\Pessoal\ContratoServidor as ContratoServidorConstants;

/**
 * Class ContratoServidorModel
 * @package Urbem\CoreBundle\Model\Pessoal
 */
class ContratoServidorModel extends AbstractModel
{
    protected $entityManager = null;
    protected $contratoRepository = null;
    protected $cargoRepository = null;
    protected $subDivisaoRepository = null;
    protected $servidorRepository = null;
    protected $especialidadeRepository = null;
    protected $previdenciaRepository = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(ContratoServidor::class);
        $this->cargoRepository = $this->entityManager->getRepository(Cargo::class);
        $this->contratoRepository = $this->entityManager->getRepository(Contrato::class);
        $this->subDivisaoRepository = $this->entityManager->getRepository(SubDivisao::class);
        $this->especialidadeRepository = $this->entityManager->getRepository(Especialidade::class);
        $this->servidorRepository = $this->entityManager->getRepository(Servidor::class);
        $this->previdenciaRepository = $this->entityManager->getRepository(Previdencia::class);
    }

    public function findOneByCodContrato($codContrato)
    {
        return $this->repository->findOneByCodContrato($codContrato);
    }

    public function montaRecuperaContratosComRegistroDeEventoReduzido($cod_periodo_movimentacao, $cod_complementar)
    {
        return $this->repository->montaRecuperaContratosComRegistroDeEventoReduzido($cod_periodo_movimentacao, $cod_complementar);
    }

    public function listaTipoSalario()
    {
        $salarios = $this->entityManager->getRepository(TipoSalario::class)
        ->findBy([], ['descricao' => 'ASC']);

        $options = [];

        foreach ($salarios as $salario) {
            $options[$salario->getCodTipoSalario() . " - " . $salario->getDescricao()] = $salario->getCodTipoSalario();
        }

        return $options;
    }

    /**
     * Retorna a lista de previdencias cadastrados para o contrato atual.
     * @param ContratoServidor $contratoServidor
     * @return array
     */
    public function getCurrentContratoServidorPrevidencia(ContratoServidor $contratoServidor)
    {
        $contratoServidorPrevidencias = $contratoServidor->getFkPessoalContratoServidorPrevidencias();

        $currentOptions = [];

        foreach ($contratoServidorPrevidencias as $contratoServidorPrevidencia) {
            $currentOptions[] = $contratoServidorPrevidencia->getCodPrevidencia();
        }

        return $currentOptions;
    }

    /**
     * @param ContratoServidor $contratoServidor
     */
    public function saveContrato(ContratoServidor $contratoServidor)
    {
        $fkPessoalContrato = new Contrato();
        $fkPessoalContrato->setCodContrato($this->contratoRepository->getNextCodContrato());
        $fkPessoalContrato->setRegistro($this->contratoRepository->getNextRegistro());

        $this->entityManager->persist($fkPessoalContrato);

        $contratoServidor->setFkPessoalContrato($fkPessoalContrato);
    }

    /**
     * @param ContratoServidor $contratoServidor
     * @param $formData
     */
    public function saveContratoServidorExameMedico(ContratoServidor $contratoServidor, $formData)
    {
        $dtValidadeExame = $formData->get('dtValidadeExame')->getData();

        if ($dtValidadeExame) {
            $contratoServidorExameMedico = new ContratoServidorExameMedico();
            $contratoServidorExameMedico->setFkPessoalContratoServidor($contratoServidor);
            $contratoServidorExameMedico->setDtValidadeExame($dtValidadeExame);

            $contratoServidor->addFkPessoalContratoServidorExameMedicos($contratoServidorExameMedico);
        }
    }

    /**
     * @param ContratoServidor $contratoServidor
     * @param $formData
     */
    public function saveContratoServidorSindicato(ContratoServidor $contratoServidor, $formData)
    {
        $numcgmSindicato = $formData->get('numcgmSindicato')->getData();

        if ($numcgmSindicato) {
            $fkPessoalContratoServidorSindicato = $contratoServidor->getFkPessoalContratoServidorSindicato();

            if (! $fkPessoalContratoServidorSindicato) {
                $fkPessoalContratoServidorSindicato = new ContratoServidorSindicato();
            }
            $fkPessoalContratoServidorSindicato->setFkPessoalContratoServidor($contratoServidor);
            $fkPessoalContratoServidorSindicato->setFkFolhapagamentoSindicato($formData->get('numcgmSindicato')->getData());

            $contratoServidor->setFkPessoalContratoServidorSindicato($fkPessoalContratoServidorSindicato);
        }
    }

    /**
     * @param ContratoServidor $contratoServidor
     * @param $formData
     */
    public function saveContratoServidorSalario(ContratoServidor $contratoServidor, $formData)
    {
        $periodoMovimentacao = new PeriodoMovimentacaoModel($this->entityManager);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        $contratoServidorSalario = new ContratoServidorSalario();
        $contratoServidorSalario->setFkPessoalContratoServidor($contratoServidor);
        $contratoServidorSalario->setSalario($formData->get('salario')->getData());
        $contratoServidorSalario->setHorasMensais($formData->get('horasMensais')->getData());
        $contratoServidorSalario->setHorasSemanais($formData->get('horasSemanais')->getData());
        $contratoServidorSalario->setVigencia($formData->get('vigencia')->getData());
        $contratoServidorSalario->setFkFolhapagamentoPeriodoMovimentacao($periodoFinal);

        $contratoServidor->addFkPessoalContratoServidorSalarios($contratoServidorSalario);
    }

    /**
     * @param ContratoServidor $contratoServidor
     * @param $formData
     */
    public function saveContratoServidorInicioProgressao(ContratoServidor $contratoServidor, $formData)
    {
        $dtInicioProgressao = $formData->get('dtInicioProgressao')->getData();

        if ($dtInicioProgressao) {
            $contratoServidorInicioProgressao = new ContratoServidorInicioProgressao();
            $contratoServidorInicioProgressao->setFkPessoalContratoServidor($contratoServidor);
            $contratoServidorInicioProgressao->setDtInicioProgressao($formData->get('dtInicioProgressao')->getData());

            $contratoServidor->addFkPessoalContratoServidorInicioProgressoes($contratoServidorInicioProgressao);
        }
    }

    public function saveContratoServidorLocal(ContratoServidor $contratoServidor, $formData)
    {
        $codLocal = $formData->get('codLocal')->getData();

        if ($codLocal) {
            $contratoServidorLocal = new ContratoServidorLocal();
            $contratoServidorLocal->setFkPessoalContratoServidor($contratoServidor);
            $contratoServidorLocal->setFkOrganogramaLocal($codLocal);

            $contratoServidor->addFkPessoalContratoServidorLocais($contratoServidorLocal);
        }
    }

    /**
     * @param ContratoServidor $contratoServidor
     * @param $formData
     */
    public function saveContratoServidorNomeacaoPosse(ContratoServidor $contratoServidor, $formData)
    {
        $contratoServidorNomeacaoPosse = new ContratoServidorNomeacaoPosse();
        $contratoServidorNomeacaoPosse->setFkPessoalContratoServidor($contratoServidor);
        $contratoServidorNomeacaoPosse->setDtNomeacao($formData->get('dtNomeacao')->getData());
        $contratoServidorNomeacaoPosse->setDtPosse($formData->get('dtPosse')->getData());
        $contratoServidorNomeacaoPosse->setDtAdmissao($formData->get('dtAdmissao')->getData());

        $contratoServidor->addFkPessoalContratoServidorNomeacaoPosses($contratoServidorNomeacaoPosse);
    }

    /**
     * @param ContratoServidor $contratoServidor
     * @param $formData
     */
    public function saveContratoServidorOcorrencia(ContratoServidor $contratoServidor, $formData)
    {
        $contratoServidorOcorrencia = new ContratoServidorOcorrencia();
        $contratoServidorOcorrencia->setFkPessoalContratoServidor($contratoServidor);
        $contratoServidorOcorrencia->setFkPessoalOcorrencia($formData->get('codOcorrencia')->getData());

        $contratoServidor->addFkPessoalContratoServidorOcorrencias($contratoServidorOcorrencia);
    }

    /**
     * @param ContratoServidor $contratoServidor
     * @param OrgaoNivel $orgaoNivel
     */
    public function saveContratoServidorOrgao(ContratoServidor $contratoServidor, OrgaoNivel $orgaoNivel)
    {
        $contratoServidorOrgao = new ContratoServidorOrgao();
        $contratoServidorOrgao->setFkPessoalContratoServidor($contratoServidor);
        $contratoServidorOrgao->setFkOrganogramaOrgao($orgaoNivel->getFkOrganogramaOrgao());

        $contratoServidor->addFkPessoalContratoServidorOrgoes($contratoServidorOrgao);
    }

    /**
     * @param ContratoServidor $contratoServidor
     * @param $formData
     */
    public function saveContratoServidorPadrao(ContratoServidor $contratoServidor, $formData)
    {
        $codPadrao = $formData->get('codPadrao')->getData();

        if ($codPadrao) {
            $contratoServidorPadrao = new ContratoServidorPadrao();
            $contratoServidorPadrao->setFkPessoalContratoServidor($contratoServidor);
            $contratoServidorPadrao->setFkFolhapagamentoPadrao($codPadrao);

            $contratoServidor->addFkPessoalContratoServidorPadroes($contratoServidorPadrao);
        }
    }

    /**
     * @param ContratoServidor $contratoServidor
     * @param $formData
     */
    public function saveContratoServidorEspecialidadeCargo(ContratoServidor $contratoServidor, $formData)
    {
        $codEspecialidade = $formData->get('codEspecialidade')->getData();

        if ($codEspecialidade) {
            $fkPessoalEspecialidade = $this->especialidadeRepository
            ->findOneByCodEspecialidade($codEspecialidade);

            $contratoServidorEspecialidadeCargo = new ContratoServidorEspecialidadeCargo();
            $contratoServidorEspecialidadeCargo->setFkPessoalContratoServidor($contratoServidor);
            $contratoServidorEspecialidadeCargo->setFkPessoalEspecialidade($fkPessoalEspecialidade);

            $contratoServidor->addFkPessoalContratoServidorEspecialidadeCargos($contratoServidorEspecialidadeCargo);
        }
    }

    /**
     * @param ContratoServidor $contratoServidor
     * @param $formData
     * @param Cargo $fkPessoalCargoFuncao
     */
    public function saveContratoServidorFuncao(ContratoServidor $contratoServidor, $formData, Cargo $fkPessoalCargoFuncao)
    {
        $contratoServidorFuncao = new ContratoServidorFuncao();
        $contratoServidorFuncao->setFkPessoalContratoServidor($contratoServidor);
        $contratoServidorFuncao->setFkPessoalCargo($fkPessoalCargoFuncao);
        $contratoServidorFuncao->setVigencia($formData->get('vigencia')->getData());

        $contratoServidor->addFkPessoalContratoServidorFuncoes($contratoServidorFuncao);
    }

    /**
     * @param ContratoServidor $contratoServidor
     * @param SubDivisao $fkPessoalSubDivisaoFuncao
     */
    public function saveContratoServidorSubDivisaoFuncao(ContratoServidor $contratoServidor, SubDivisao $fkPessoalSubDivisaoFuncao)
    {
        $contratoServidorSubDivisaoFuncao = new ContratoServidorSubDivisaoFuncao();
        $contratoServidorSubDivisaoFuncao->setFkPessoalContratoServidor($contratoServidor);
        $contratoServidorSubDivisaoFuncao->setFkPessoalSubDivisao($fkPessoalSubDivisaoFuncao);

        $contratoServidor->addFkPessoalContratoServidorSubDivisaoFuncoes($contratoServidorSubDivisaoFuncao);
    }

    /**
     * @param ContratoServidor $contratoServidor
     * @param $formData
     */
    public function saveContratoServidorRegimeFuncao(ContratoServidor $contratoServidor, $formData)
    {
        $contratoServidorRegimeFuncao = new ContratoServidorRegimeFuncao();
        $contratoServidorRegimeFuncao->setFkPessoalContratoServidor($contratoServidor);
        $contratoServidorRegimeFuncao->setFkPessoalRegime($formData->get('codRegimeFuncao')->getData());

        $contratoServidor->addFkPessoalContratoServidorRegimeFuncoes($contratoServidorRegimeFuncao);
    }

    /**
     * @param ContratoServidor $contratoServidor
     * @param $formData
     */
    public function saveContratoServidorFormaPagamento(ContratoServidor $contratoServidor, $formData)
    {
        $fkPessoalFormaPagamento = $formData->get('codFormaPagamento')->getData();

        $contratoServidorFormaPagamento = new ContratoServidorFormaPagamento();
        $contratoServidorFormaPagamento->setFkPessoalContratoServidor($contratoServidor);
        $contratoServidorFormaPagamento->setFkPessoalFormaPagamento($fkPessoalFormaPagamento);

        $contratoServidor->addFkPessoalContratoServidorFormaPagamentos($contratoServidorFormaPagamento);

        if ($fkPessoalFormaPagamento->getCodFormaPagamento() == 3) {
            $fkPessoalContratoServidorContaSalario = $contratoServidor->getFkPessoalContratoServidorContaSalario();

            if (! $fkPessoalContratoServidorContaSalario) {
                $fkPessoalContratoServidorContaSalario = new ContratoServidorContaSalario();
            }
            $fkPessoalContratoServidorContaSalario->setFkPessoalContratoServidor($contratoServidor);
            $fkPessoalContratoServidorContaSalario->setFkMonetarioAgencia($formData->get('codAgenciaSalario')->getData());
            $fkPessoalContratoServidorContaSalario->setNrConta($formData->get('nrContaSalario')->getData());

            $contratoServidor->setFkPessoalContratoServidorContaSalario($fkPessoalContratoServidorContaSalario);
        }
    }

    /**
     * @param ContratoServidor $contratoServidor
     * @param $formData
     */
    public function saveContratoServidorContaFgts(ContratoServidor $contratoServidor, $formData)
    {
        $codAgenciaFgts = $formData->get('codAgenciaFgts')->getData();
        $nrContaFgts = $formData->get('nrContaFgts')->getData();

        if ($codAgenciaFgts && $nrContaFgts) {
            $contratoServidorContaFgts = $contratoServidor->getFkPessoalContratoServidorContaFgts();
            if (! $contratoServidorContaFgts) {
                $contratoServidorContaFgts = new ContratoServidorContaFgts();
            }
            $contratoServidorContaFgts->setFkPessoalContratoServidor($contratoServidor);
            $contratoServidorContaFgts->setFkMonetarioAgencia($codAgenciaFgts);
            $contratoServidorContaFgts->setNrConta($nrContaFgts);

            $contratoServidor->setFkPessoalContratoServidorContaFgts($contratoServidorContaFgts);
        }
    }

    /**
     * @param ContratoServidor $contratoServidor
     * @param $formData
     */
    public function saveContratoServidorConselho(ContratoServidor $contratoServidor, $formData)
    {
        $contratoServidor->setFkPessoalContratoServidorConselho(null);

        $fkPessoalConselho = $formData->get('codConselho')->getData();
        $contratoServidorConselho = $formData->get('fkPessoalContratoServidorConselho')->getData();

        if ($contratoServidorConselho && $fkPessoalConselho) {
            $contratoServidorConselho->setFkPessoalContratoServidor($contratoServidor);
            $contratoServidorConselho->setFkPessoalConselho($formData->get('codConselho')->getData());

            $contratoServidor->setFkPessoalContratoServidorConselho($contratoServidorConselho);
        }
    }

    /**
     * @param ContratoServidor $contratoServidor
     * @param Servidor $fkPessoalServidor
     */
    public function saveServidorContratoServidor(ContratoServidor $contratoServidor, Servidor $fkPessoalServidor)
    {
        $servidorContratoServidor = new ServidorContratoServidor();
        $servidorContratoServidor->setFkPessoalContratoServidor($contratoServidor);
        $servidorContratoServidor->setFkPessoalServidor($fkPessoalServidor);

        $contratoServidor->addFkPessoalServidorContratoServidores($servidorContratoServidor);
    }

    /**
     * @param ContratoServidor $contratoServidor
     * @param $formData
     */
    public function saveContratoServidorPrevidencia(ContratoServidor $contratoServidor, $formData)
    {
        $contratoServidorPrevidencias = $contratoServidor->getFkPessoalContratoServidorPrevidencias();

        foreach ($contratoServidorPrevidencias as $contratoServidorPrevidencia) {
            $contratoServidor->removeFkPessoalContratoServidorPrevidencias($contratoServidorPrevidencia);
        }

        $codPrevidencias = $formData->get('codPrevidencia')->getData();

        foreach ($codPrevidencias as $codPrevidencia) {
            $fkFolhapagamentoPrevidencia = $this->previdenciaRepository->findOneByCodPrevidencia($codPrevidencia);

            $contratoServidorPrevidencia = new ContratoServidorPrevidencia();
            $contratoServidorPrevidencia->setFkPessoalContratoServidor($contratoServidor);
            $contratoServidorPrevidencia->setFkFolhapagamentoPrevidencia($fkFolhapagamentoPrevidencia);

            $contratoServidor->addFkPessoalContratoServidorPrevidencias($contratoServidorPrevidencia);
        }
    }

    /**
     * @param ContratoServidor $contratoServidor
     * @param $formData
     */
    public function saveAtributoContratoServidorValor(ContratoServidor $contratoServidor, $formData)
    {
        $atributosDinamicos = (new AtributoDinamicoModel($this->entityManager))
        ->getAtributosDinamicosPorModuloQuery(
            ContratoServidorConstants::CODMODULO,
            ContratoServidorConstants::CODCADASTRO
        )->getQuery()->getResult();

        $atributosDinamicosForRemoval = $contratoServidor->getFkPessoalAtributoContratoServidorValores();

        if (! $atributosDinamicosForRemoval->isEmpty()) {
            foreach ($atributosDinamicosForRemoval as $atributoDinamicoForRemoval) {
                $contratoServidor->removeFkPessoalAtributoContratoServidorValores($atributoDinamicoForRemoval);
            }
        }

        foreach ($atributosDinamicos as $atributoDinamico) {
            $fieldName = sprintf('%s_atributoDinamico', $atributoDinamico->getCodAtributo());

            $atributoContratoServidorValor = new AtributoContratoServidorValor();
            $atributoContratoServidorValor->setFkPessoalContratoServidor($contratoServidor);
            $atributoContratoServidorValor->setFkAdministracaoAtributoDinamico($atributoDinamico);

            $valor = StringHelper::convertAtributoDinamicoValorToString(
                $atributoDinamico->getCodTipo(),
                $formData->get($fieldName)->getData()
            );

            $atributoContratoServidorValor->setValor($valor);

            $contratoServidor->addFkPessoalAtributoContratoServidorValores($atributoContratoServidorValor);
        }
    }

    /**
     * @param ContratoServidor $contratoServidor
     * @param $formData
     * @param OrgaoNivel $orgaoNivel
     */
    public function buildContratoServidor(ContratoServidor $contratoServidor, $formData, OrgaoNivel $orgaoNivel)
    {
        $fkPessoalServidor = $this->servidorRepository->findOneByCodServidor($formData->get('servidor')->getData());
        $fkPessoalSubDivisao = $this->subDivisaoRepository->findOneByCodSubDivisao($formData->get('codSubDivisao')->getData());
        $fkPessoalSubDivisaoFuncao = $this->subDivisaoRepository->findOneByCodSubDivisao($formData->get('codSubDivisaoFuncao')->getData());
        $fkPessoalCargo = $this->cargoRepository->findOneByCodCargo($formData->get('codCargo')->getData());
        $fkPessoalCargoFuncao = $this->cargoRepository->findOneByCodCargo($formData->get('codCargoFuncao')->getData());

        $this->saveContrato($contratoServidor, $formData);

        $contratoServidor->setCodTipoSalario($formData->get('codTipoSalario')->getData());
        $contratoServidor->setFkPessoalSubDivisao($fkPessoalSubDivisao);
        $contratoServidor->setFkPessoalCargo($fkPessoalCargo);

        $this->saveContratoServidorExameMedico($contratoServidor, $formData);
        $this->saveContratoServidorSindicato($contratoServidor, $formData);
        $this->saveContratoServidorSalario($contratoServidor, $formData);
        $this->saveContratoServidorInicioProgressao($contratoServidor, $formData);
        $this->saveContratoServidorLocal($contratoServidor, $formData);
        $this->saveContratoServidorNomeacaoPosse($contratoServidor, $formData);
        $this->saveContratoServidorOcorrencia($contratoServidor, $formData);
        $this->saveContratoServidorOrgao($contratoServidor, $orgaoNivel);
        $this->saveContratoServidorPadrao($contratoServidor, $formData);
        $this->saveContratoServidorEspecialidadeCargo($contratoServidor, $formData);
        $this->saveContratoServidorFuncao($contratoServidor, $formData, $fkPessoalCargoFuncao);
        $this->saveContratoServidorSubDivisaoFuncao($contratoServidor, $fkPessoalSubDivisaoFuncao);
        $this->saveContratoServidorRegimeFuncao($contratoServidor, $formData);
        $this->saveContratoServidorFormaPagamento($contratoServidor, $formData);
        $this->saveContratoServidorContaFgts($contratoServidor, $formData);
        $this->saveContratoServidorConselho($contratoServidor, $formData);
        $this->saveContratoServidorPrevidencia($contratoServidor, $formData);
        $this->saveAtributoContratoServidorValor($contratoServidor, $formData);
        $this->saveServidorContratoServidor($contratoServidor, $fkPessoalServidor);
    }

    /**
     * @param ContratoServidor $contratoServidor
     * @param $formData
     * @param OrgaoNivel $orgaoNivel
     */
    public function updateContratoServidor(ContratoServidor $contratoServidor, $formData, OrgaoNivel $orgaoNivel)
    {
        $fkPessoalSubDivisaoFuncao = $this->subDivisaoRepository->findOneByCodSubDivisao($formData->get('codSubDivisaoFuncao')->getData());
        $fkPessoalCargoFuncao = $this->cargoRepository->findOneByCodCargo($formData->get('codCargoFuncao')->getData());

        $this->saveContratoServidorExameMedico($contratoServidor, $formData);
        $this->saveContratoServidorSindicato($contratoServidor, $formData);
        $this->saveContratoServidorSalario($contratoServidor, $formData);
        $this->saveContratoServidorInicioProgressao($contratoServidor, $formData);
        $this->saveContratoServidorLocal($contratoServidor, $formData);
        $this->saveContratoServidorNomeacaoPosse($contratoServidor, $formData);
        $this->saveContratoServidorOcorrencia($contratoServidor, $formData);
        $this->saveContratoServidorOrgao($contratoServidor, $orgaoNivel);
        $this->saveContratoServidorPadrao($contratoServidor, $formData);
        $this->saveContratoServidorEspecialidadeCargo($contratoServidor, $formData);
        $this->saveContratoServidorFuncao($contratoServidor, $formData, $fkPessoalCargoFuncao);
        $this->saveContratoServidorSubDivisaoFuncao($contratoServidor, $fkPessoalSubDivisaoFuncao);
        $this->saveContratoServidorRegimeFuncao($contratoServidor, $formData);
        $this->saveContratoServidorFormaPagamento($contratoServidor, $formData);
        $this->saveContratoServidorContaFgts($contratoServidor, $formData);
        $this->saveContratoServidorConselho($contratoServidor, $formData);
        $this->saveContratoServidorPrevidencia($contratoServidor, $formData);
        $this->saveAtributoContratoServidorValor($contratoServidor, $formData);
    }

    public function toStringContratoServidorAutocomplete(ContratoServidor $contratoServidor)
    {
        return $contratoServidor->getFkPessoalContrato()->getRegistro()
        . " - "
        . $contratoServidor->getFkPessoalServidorContratoServidores()->last()
        ->getFkPessoalServidor()->getFkSwCgmPessoaFisica()->getFkSwCgm()->getNumcgm()
        . " - "
        . $contratoServidor->getFkPessoalServidorContratoServidores()->last()
        ->getFkPessoalServidor()->getFkSwCgmPessoaFisica()->getFkSwCgm()->getNomcgm();
    }

    /**
     * @param $exercicio
     * @param $entidade
     * @param $params
     * @return array
     */
    public function montaRecuperaContratosServidorResumido($exercicio, $entidade, $params)
    {
        return $this->repository->montaRecuperaContratosServidorResumido($exercicio, $entidade, $params);
    }

    /**
     * @param $stJoin
     * @param $stFiltro
     *
     * @return array
     */
    public function recuperaContratosSEFIP($stJoin, $stFiltro)
    {
        return $this->repository->recuperaContratosSEFIP($stJoin, $stFiltro);
    }

    /**
     * @param $stFiltro
     * @param $params
     * @param $stOrdem
     *
     * @return array
     */
    public function recuperaRegistroTrabalhadoresSEFIP($stFiltro, $params, $stOrdem)
    {
        return $this->repository->recuperaRegistroTrabalhadoresSEFIP($stFiltro, $params, $stOrdem);
    }
}
