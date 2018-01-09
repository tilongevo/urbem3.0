<?php

namespace Urbem\CoreBundle\Model\Ppa;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Ldo\AcaoValidada;
use Urbem\CoreBundle\Entity\Ppa\Acao;
use Urbem\CoreBundle\Entity\Ppa\AcaoDados;
use Urbem\CoreBundle\Entity\Ppa\AcaoNorma;
use Urbem\CoreBundle\Entity\Ppa\AcaoPeriodo;
use Urbem\CoreBundle\Entity\Ppa\AcaoQuantidade;
use Urbem\CoreBundle\Entity\Ppa\AcaoRecurso;
use Urbem\CoreBundle\Entity\Ppa\AcaoUnidadeExecutora;
use Urbem\CoreBundle\Entity\Ppa\MacroObjetivo;
use Urbem\CoreBundle\Entity\Ppa\Ppa;
use Urbem\CoreBundle\Entity\Ppa\PpaPrecisao;
use Urbem\CoreBundle\Entity\Ppa\Precisao;
use Urbem\CoreBundle\Entity\Ppa\Programa;
use Urbem\CoreBundle\Entity\Ppa\ProgramaDados;
use Urbem\CoreBundle\Entity\Ppa\ProgramaIndicadores;
use Urbem\CoreBundle\Entity\Ppa\ProgramaSetorial;
use Urbem\CoreBundle\Entity\Ppa\ProgramaTemporarioVigencia;
use \Urbem\CoreBundle\Entity\Orcamento;
use Urbem\CoreBundle\Model;

class PpaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;
    protected $importado;
    const COD_PRECISAO = 2;
    protected $newCodPrograma;
    protected $newNumPao;
    protected $newPpaCodPrograma;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Ppa::class);
        $this->newCodPrograma = $this->entityManager->getRepository(Orcamento\Programa::class)->getProximoCodPrograma();
        $this->newNumPao = $this->entityManager->getRepository(Orcamento\Pao::class)->getProximoNumPao();
        $this->newPpaCodPrograma = $this->entityManager->getRepository(Programa::class)->getProximoCodGrupo();
    }

    /**
     * @param $ano_exercicio
     * @return array
     */
    public function getPpaExercicio($ano_exercicio)
    {
        $repository = $this->entityManager->getRepository(Ppa::class);
        $query = $repository->createQueryBuilder('p')
                            ->where('p.anoInicio <= :ano_exercicio')
                            ->andWhere('p.anoFinal >= :ano_exercicio')
                            ->setParameter('ano_exercicio', $ano_exercicio);

        return $query->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();
    }

    /**
     * @param $params
     * @return mixed
     */
    public function getProgramasPpa($params)
    {
        return $this->repository->getProgramasPpa($params);
    }

    /**
     * @param $params
     * @return mixed
     */
    public function getAcoesByPpaAndPrograma($params)
    {
        return $this->repository->getAcoesByPpaAndPrograma($params);
    }

    /**
     * @param $params
     * @return mixed
     */
    public function getPpasByStatus($params)
    {
        return $this->repository->getPpasByStatus($params);
    }

    /**
     * @param $codPpa
     * @return mixed
     */
    public function getDadosPpa($codPpa)
    {
        return $this->repository->getDadosPpa($codPpa);
    }

    /**
     * @param $params
     * @return mixed
     */
    public function getStatus($params)
    {
        return $this->repository->getStatus($params);
    }

    /**
     * @return mixed
     */
    public function getPpasHomologados()
    {
        return $this->repository->getPpasHomologados();
    }

    /**
     * @param $anoInicio
     * @param $exercicio
     * @return mixed
     */
    public function fnGerarDadosPpa($anoInicio, $exercicio)
    {
        return $this->repository->fnGerarDadosPpa($anoInicio, $exercicio);
    }

    /**
     * @param $ppaPorExercicio
     * @param $novoPpa
     * @param $importado
     * @param $arredondarValores
     */
    public function iniciandoCopiaDadosParaPpa($ppaPorExercicio, $novoPpa, $importado, $arredondarValores)
    {
        if (!$ppaPorExercicio->getFkPpaMacroObjetivos()->isEmpty()) {
            $this->importado = $importado;
            $this->populaMacroObjetivo($ppaPorExercicio, $novoPpa);
        }

        if ($arredondarValores) {
            $this->populaPpaPrecisao($novoPpa);
        }
    }

    /**
     * @param $novoPpa
     */
    public function populaPpaPrecisao($novoPpa)
    {
        $precisao = $this->entityManager->getRepository(Precisao::class)->findOneByCodPrecisao(self::COD_PRECISAO);
        $ppaPrecisao = new PpaPrecisao();
        $ppaPrecisao->setFkPpaPrecisao($precisao);
        $ppaPrecisao->setFkPpaPpa($novoPpa);
        $novoPpa->setFkPpaPpaPrecisao($ppaPrecisao);
    }

    /**
     * @param $ppaPorExercicio
     * @param $novoPpa
     */
    public function populaMacroObjetivo($ppaPorExercicio, $novoPpa)
    {
        //4 Importa macros objetivos com mesmo código do PPA.
        foreach ($ppaPorExercicio->getFkPpaMacroObjetivos() as $macroObjetivoRef) {
            $macroObjetivo = new MacroObjetivo();
            $macroObjetivo->setDescricao($macroObjetivoRef->getDescricao());
            $macroObjetivo->setFkPpaPpa($novoPpa);
            $this->populaProgramaSetorial($macroObjetivoRef, $macroObjetivo);
            $novoPpa->addFkPpaMacroObjetivos($macroObjetivo);
        }
    }

    /**
     * @param $macroObjetivoRef
     * @param $macroObjetivo
     */
    public function populaProgramaSetorial($macroObjetivoRef, $macroObjetivo)
    {
        foreach ($macroObjetivoRef->getFkPpaProgramaSetoriais() as $programaSetorialRef) {
            $programaSetorial = new ProgramaSetorial();
            $programaSetorial->setDescricao($programaSetorialRef->getDescricao());
            $programaSetorial->setFkPpaMacroObjetivo($macroObjetivo);
            $this->populaPrograma($programaSetorialRef, $programaSetorial);
            $macroObjetivo->addFkPpaProgramaSetoriais($programaSetorial);
        }
    }

    /**
     * @param $programaSetorialRef
     * @param $programaSetorial
     */
    public function populaPrograma($programaSetorialRef, $programaSetorial)
    {
        foreach ($programaSetorialRef->getFkPpaProgramas() as $programaRef) {
            $programa = new Programa();
            $programa->setCodPrograma($this->newPpaCodPrograma);
            $programa->setNumPrograma($programaRef->getNumPrograma());
            $programa->setAtivo($programaRef->getAtivo());
            $programa->setFkPpaProgramaSetorial($programaSetorial);
            if (!empty($programaRef->getFkPpaProgramaDados()->current())) {
                $this->populaProgramaDados($programaRef->getFkPpaProgramaDados()->current(), $programa);
            }
            $this->populaAcao($programaRef, $programa);
            $this->populaOrcamentoProgramaPpaProgramas($programaRef->getFkOrcamentoProgramaPpaProgramas(), $programa);
            $this->newCodPrograma++;
            $this->newPpaCodPrograma++;
            $programaSetorial->addFkPpaProgramas($programa);
        }
    }

    /**
     * @param $programaDadosRef
     * @param $programa
     */
    public function populaProgramaDados($programaDadosRef, $programa)
    {
        $programaDados = new ProgramaDados();
        $programaDados->setFkPpaPrograma($programa);
        $programaDados->setTimestampProgramaDados($programa->getUltimoTimestampProgramaDados());
        $programaDados->setIdentificacao($programaDadosRef->getIdentificacao());
        $programaDados->setDiagnostico($programaDadosRef->getDiagnostico());
        $programaDados->setObjetivo($programaDadosRef->getObjetivo());
        $programaDados->setDiretriz($programaDadosRef->getDiretriz());
        $programaDados->setContinuo($programaDadosRef->getContinuo());
        $programaDados->setPublicoAlvo($programaDadosRef->getPublicoAlvo());
        $programaDados->setJustificativa($programaDadosRef->getJustificativa());
        $programaDados->setExercicioUnidade($programaDadosRef->getExercicioUnidade());
        $programaDados->setNumUnidade($programaDadosRef->getNumUnidade());
        $programaDados->setNumOrgao($programaDadosRef->getNumOrgao());
        $programaDados->setFkPpaProgramaNormas($programaDadosRef->getFkPpaProgramaNormas());
        $programaDados->setFkPpaProgramaIndicadoreses($programaDadosRef->getFkPpaProgramaIndicadoreses());
        $programaDados->setFkPpaPrograma($programa);
        $programaDados->setFkPpaTipoPrograma($programaDadosRef->getFkPpaTipoPrograma());
        $programaDados->setFkOrcamentoUnidade($programaDadosRef->getFkOrcamentoUnidade());

        if ($programaDadosRef->getContinuo()) {
            if (!empty($programaDadosRef->getFkPpaProgramaTemporarioVigencia())) {
                $this->populaProgramaTemporarioVigencia($programaDadosRef->getFkPpaProgramaTemporarioVigencia(), $programaDados);
            }
        }
        $this->populaProgramaIndicadores($programaDadosRef, $programaDados);
        $programa->addFkPpaProgramaDados($programaDados);
    }

    /**
     * @param $programaTemporarioVigenciaRefs
     * @param $programaDados
     */
    public function populaProgramaTemporarioVigencia($programaTemporarioVigenciaRefs, $programaDados)
    {
        $programaTemporarioVigencia = new ProgramaTemporarioVigencia();
        $programaTemporarioVigencia->setFkPpaProgramaDados($programaDados);
        $programaTemporarioVigencia->setDtInicial($programaTemporarioVigenciaRefs->getDtInicial());
        $programaTemporarioVigencia->setDtFinal($programaTemporarioVigenciaRefs->getDtFinal());
        $programaTemporarioVigencia->setValorGlobal($programaTemporarioVigenciaRefs->getValorGlobal());
        $programaDados->setFkPpaProgramaTemporarioVigencia($programaTemporarioVigencia);
    }

    /**
     * @param $programasIndicadoresRef
     * @param $programaDados
     */
    public function populaProgramaIndicadores($programasIndicadoresRef, $programaDados)
    {
        foreach ($programasIndicadoresRef->getFkPpaProgramaIndicadoreses() as $programaIndicadoresRef) {
            $programaIndicadores = new ProgramaIndicadores();
            $programaIndicadores->setFkPpaProgramaDados($programaDados);
            $programaIndicadores->setCodIndicador($programaIndicadoresRef->getCodIndicador());
            $programaIndicadores->setIndiceRecente($programaIndicadoresRef->getIndiceRecente());
            $programaIndicadores->setDescricao($programaIndicadoresRef->getDescricao());
            $programaIndicadores->setIndiceDesejado($programaIndicadoresRef->getIndiceDesejado());
            $programaIndicadores->setFonte($programaIndicadoresRef->getFonte());
            $programaIndicadores->setBaseGeografica($programaIndicadoresRef->getBaseGeografica());
            $programaIndicadores->setFormaCalculo($programaIndicadoresRef->getFormaCalculo());
            $programaIndicadores->setDtIndiceRecente($programaIndicadoresRef->getDtIndiceRecente());
            $programaIndicadores->setCodUnidade($programaIndicadoresRef->getCodUnidade());
            $programaIndicadores->setCodPeriodicidade($programaIndicadoresRef->getCodPeriodicidade());
            $programaIndicadores->setCodGrandeza($programaIndicadoresRef->getCodGrandeza());
            $programaDados->addFkPpaProgramaIndicadoreses($programaIndicadores);
        }
    }

    /**
     * @param $acaoRefs
     * @param $programa
     */
    public function populaAcao($acaoRefs, $programa)
    {
        foreach ($acaoRefs->getFkPpaAcoes() as $acaoRef) {
            $acao = new Acao();
            $acao->setFkPpaPrograma($programa);
            $acao->setUltimoTimestampAcaoDados($programa->getUltimoTimestampProgramaDados());
            $acao->setAtivo($acaoRef->getAtivo());
            $acao->setNumAcao($acaoRef->getNumAcao());
            $this->entityManager->persist($acao);
            $this->entityManager->flush($acao);
            $this->entityManager->refresh($acao);
            if (!empty($acaoRef->getFkPpaAcaoDados()->current())) {
                $this->populaAcaoDados($acaoRef->getFkPpaAcaoDados()->current(), $acao);
            }
            $this->entityManager->persist($acao);
            $this->entityManager->flush($acao);
            $this->entityManager->refresh($acao);
            $programa->addFkPpaAcoes($acao);
        }
    }

    /**
     * @param $acaoRef
     * @param $acao
     */
    public function populaOrcamentoPaoPpaAcoes($acaoRef, $acao)
    {
        foreach ($acaoRef->getFkOrcamentoPaoPpaAcoes() as $orcamentoPaoPpaAcaoRef) {
            $paoPpaAcao = new Orcamento\PaoPpaAcao();
            $paoPpaAcao->setFkPpaAcao($acao);
            $paoPpaAcao->setExercicio($acao->getFkPpaPrograma()->getFkPpaProgramaSetorial()->getFkPpaMacroObjetivo()->getFkPpaPpa()->getAnoInicio());
            $this->populaPao($orcamentoPaoPpaAcaoRef, $paoPpaAcao);
            $acao->addFkOrcamentoPaoPpaAcoes($paoPpaAcao);
            $this->newNumPao++;
        }
    }

    /**
     * @param $orcamentoPaoPpaAcaoRef
     * @param $paoPpaAcao
     */
    public function populaPao($orcamentoPaoPpaAcaoRef, $paoPpaAcao)
    {
        $pao = new Orcamento\Pao();
        $pao->setNumPao($this->newNumPao);
        $pao->setExercicio($paoPpaAcao->getExercicio());
        $pao->setNomPao($orcamentoPaoPpaAcaoRef->getFkOrcamentoPao()->getNomPao());
        $pao->setDetalhamento($orcamentoPaoPpaAcaoRef->getFkOrcamentoPao()->getNomPao());
        $paoPpaAcao->setFkOrcamentoPao($pao);
    }

    /**
     * @param $acaoDadosRef
     * @param $acao
     */
    public function populaAcaoDados($acaoDadosRef, $acao)
    {
        $acaoDados = new AcaoDados();
        $acaoDados->setFkPpaAcao($acao);
        $acaoDados->setTimestampAcaoDados($acao->getUltimoTimestampAcaoDados());
        $acaoDados->setCodTipo($acaoDadosRef->getCodTipo());
        $acaoDados->setCodProduto($acaoDadosRef->getCodProduto());
        $acaoDados->setCodRegiao($acaoDadosRef->getCodRegiao());
        $acaoDados->setExercicio($acaoDadosRef->getExercicio());
        $acaoDados->setCodFuncao($acaoDadosRef->getCodFuncao());
        $acaoDados->setCodSubFuncao($acaoDadosRef->getCodSubFuncao());
        $acaoDados->setCodGrandeza($acaoDadosRef->getCodGrandeza());
        $acaoDados->setCodUnidadeMedida($acaoDadosRef->getCodUnidadeMedida());
        $acaoDados->setTitulo($acaoDadosRef->getTitulo());
        $acaoDados->setDescricao($acaoDadosRef->getDescricao());
        $acaoDados->setFinalidade($acaoDadosRef->getFinalidade());
        $acaoDados->setCodForma($acaoDadosRef->getCodForma());
        $acaoDados->setCodTipoOrcamento($acaoDadosRef->getCodTipoOrcamento());
        $acaoDados->setDetalhamento($acaoDadosRef->getDetalhamento());
        $acaoDados->setValorEstimado($acaoDadosRef->getValorEstimado());
        $acaoDados->setMetaEstimada($acaoDadosRef->getMetaEstimada());
        $acaoDados->setCodNatureza($acaoDadosRef->getCodNatureza());
        $this->populaAcaoRecurso($acaoDadosRef, $acaoDados);
        $this->populaAcaoNorma($acaoDadosRef, $acaoDados);
        $this->populaAcaoUnidadeExecutora($acaoDadosRef, $acaoDados);
        if (!empty($acaoDadosRef->getFkPpaAcaoPeriodo())) {
            $this->popularAcaoPeriodo($acaoDadosRef->getFkPpaAcaoPeriodo(), $acaoDados);
        }
        $acao->addFkPpaAcaoDados($acaoDados);
    }

    /**
     * @param $acaoDadosRef
     * @param $acaoDados
     */
    public function populaAcaoRecurso($acaoDadosRef, $acaoDados)
    {
        foreach ($acaoDadosRef->getFkPpaAcaoRecursos() as $acaoRecursoRef) {
            $acaoRecurso = new AcaoRecurso();
            $acaoRecurso->setFkPpaAcaoDados($acaoDados);
            $acaoRecurso->setTimestampAcaoDados($acaoDados->getTimestampAcaoDados());
            $acaoRecurso->setCodRecurso($acaoRecursoRef->getCodRecurso());
            $acaoRecurso->setExercicioRecurso($acaoRecursoRef->getExercicioRecurso());
            $acaoRecurso->setAno($acaoRecursoRef->getAno());
            $acaoRecurso->setValor($acaoRecursoRef->getValor());
            $this->populaAcaoQuantidade($acaoRecursoRef->getFkPpaAcaoQuantidade(), $acaoRecurso);
            $acaoDados->addFkPpaAcaoRecursos($acaoRecurso);
        }
    }

    /**
     * @param $acaoQuantidadeRef
     * @param $acaoRecurso
     */
    public function populaAcaoQuantidade($acaoQuantidadeRef, $acaoRecurso)
    {
        $acaoQuantidade = new AcaoQuantidade();
        $acaoQuantidade->setFkPpaAcaoRecurso($acaoRecurso);
        $acaoQuantidade->setTimestampAcaoDados($acaoRecurso->getTimestampAcaoDados());
        $acaoQuantidade->setAno($acaoQuantidadeRef->getAno());
        if ($this->importado) {
            $acaoQuantidade->setValor($acaoQuantidadeRef->getValor());
        }
        $acaoQuantidade->setQuantidade($acaoQuantidadeRef->getQuantidade());
        $acaoQuantidade->setCodRecurso($acaoQuantidadeRef->getCodRecurso());
        $acaoQuantidade->setExercicioRecurso($acaoQuantidadeRef->getExercicioRecurso());

        if (!empty($acaoQuantidadeRef->getFkLdoAcaoValidada())) {
            $this->populaAcaoValidada($acaoQuantidadeRef->getFkLdoAcaoValidada(), $acaoQuantidade);
        }

        $acaoRecurso->setFkPpaAcaoQuantidade($acaoQuantidade);
    }

    /**
     * @param $acaoValidadaRef
     * @param $acaoQuantidade
     */
    public function populaAcaoValidada($acaoValidadaRef, $acaoQuantidade)
    {
        $acaoValidada = new AcaoValidada();
        $acaoValidada->setFkPpaAcaoQuantidade($acaoQuantidade);
        $acaoValidada->setAno($acaoValidadaRef->getAno());
        $acaoValidada->setTimestampAcaoDados($acaoQuantidade->getTimestampAcaoDados());
        $acaoValidada->setValor($acaoValidadaRef->getValor());
        $acaoValidada->setQuantidade($acaoValidadaRef->getQuantidade());
        $acaoValidada->setCodRecurso($acaoValidadaRef->getCodRecurso());
        $acaoValidada->setExercicioRecurso($acaoValidadaRef->getExercicioRecurso());
        $acaoQuantidade->setFkLdoAcaoValidada($acaoValidada);
    }

    /**
     * @param $acaoDadosRef
     * @param $acaoDados
     */
    public function populaAcaoNorma($acaoDadosRef, $acaoDados)
    {
        foreach ($acaoDadosRef->getFkPpaAcaoNormas() as $acaoNormasRef) {
            $acaoNorma = new AcaoNorma();
            $acaoNorma->setFkPpaAcaoDados($acaoDados);
            $acaoNorma->setTimestampAcaoDados($acaoDados->getTimestampAcaoDados());
            $acaoNorma->setFkNormasNorma($acaoNormasRef->getFkNormasNorma());
            $acaoDados->addFkPpaAcaoNormas($acaoNorma);
        }
    }

    /**
     * @param $acaoDadosRef
     * @param $acaoDados
     */
    public function populaAcaoUnidadeExecutora($acaoDadosRef, $acaoDados)
    {
        foreach ($acaoDadosRef->getFkPpaAcaoUnidadeExecutoras() as $acaoUnidadeExecutoras) {
            $acaoUnidadeExecutora = new AcaoUnidadeExecutora();
            $acaoUnidadeExecutora->setFkPpaAcaoDados($acaoDados);
            $acaoUnidadeExecutora->setTimestampAcaoDados($acaoDados->getTimestampAcaoDados());
            $acaoUnidadeExecutora->setExercicioUnidade($acaoUnidadeExecutoras->getExercicioUnidade());
            $acaoUnidadeExecutora->setNumUnidade($acaoUnidadeExecutoras->getNumUnidade());
            $acaoUnidadeExecutora->setNumOrgao($acaoUnidadeExecutoras->getNumOrgao());
            $acaoDados->addFkPpaAcaoUnidadeExecutoras($acaoUnidadeExecutora);
        }
    }

    /**
     * @param $acaoPeriodoRef
     * @param $acaoDados
     */
    public function popularAcaoPeriodo($acaoPeriodoRef, $acaoDados)
    {
        $acaoPeriodo = new AcaoPeriodo();
        $acaoPeriodo->setFkPpaAcaoDados($acaoDados);
        $acaoPeriodo->setTimestampAcaoDados($acaoDados->getTimestampAcaoDados());
        $acaoPeriodo->setDataInicio($acaoPeriodoRef->getDataInicio());
        $acaoPeriodo->setDataTermino($acaoPeriodoRef->getDataTermino());
        $acaoDados->setFkPpaAcaoPeriodo($acaoPeriodo);
    }

    /**
     * @param $programaPpaProgramasRef
     * @param $programa
     */
    public function populaOrcamentoProgramaPpaProgramas($programaPpaProgramasRef, $programa)
    {
        $anoInicio = $programa->getFkPpaProgramaSetorial()->getFkPpaMacroObjetivo()->getFkPpaPpa()->getAnoInicio();
        if (!$programaPpaProgramasRef->isEmpty()) {
            foreach ($programaPpaProgramasRef as $programaPpaProgramaRef) {
                $programaPpaPrograma = new Orcamento\ProgramaPpaPrograma();
                $programaPpaPrograma->setFkPpaPrograma($programa);
                $programaPpaPrograma->setExercicio($anoInicio);
                $this->populaOrcamentoPrograma($programaPpaProgramaRef, $programaPpaPrograma);
                $programa->addFkOrcamentoProgramaPpaProgramas($programaPpaPrograma);
                $anoInicio++;
            }
        }
    }

    /**
     * @param $programaPpaProgramaRef
     * @param $programaPpaPrograma
     */
    public function populaOrcamentoPrograma($programaPpaProgramaRef, $programaPpaPrograma)
    {
        $orcamentoPrograma = new Orcamento\Programa();
        $orcamentoPrograma->setCodPrograma($this->newCodPrograma);
        $orcamentoPrograma->setExercicio($programaPpaPrograma->getExercicio());
        $orcamentoPrograma->setDescricao($programaPpaProgramaRef->getFkOrcamentoPrograma()->getDescricao());
        $programaPpaPrograma->setFkOrcamentoPrograma($orcamentoPrograma);
    }
    
    /**
     * @param int $exercicio
     * @param int $codPpa
     * @param boolean $hmlg
     * @return array
     */
    public function recuperaAcaoDespesa($exercicio = null, $codPpa = null, $hmlg = false)
    {
        return $this->repository->recuperaAcaoDespesa($exercicio, $codPpa, $hmlg);
    }
    
    /**
     * @param int $exercicio
     * @param int $codAno
     * @param int $codAcao
     * @return mixed
     */
    public function recuperaDespesaByAcao($exercicio, $codAno, $codAcao)
    {
        return $this->repository->recuperaDespesaByAcao($exercicio, $codAno, $codAcao);
    }
}
