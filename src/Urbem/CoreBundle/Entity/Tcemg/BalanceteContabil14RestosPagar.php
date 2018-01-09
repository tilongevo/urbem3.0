<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * BalanceteContabil14RestosPagar
 */
class BalanceteContabil14RestosPagar
{
    /**
     * PK
     * @var integer
     */
    private $numOrgao;

    /**
     * @var integer
     */
    private $numUnidade;

    /**
     * @var integer
     */
    private $codFuncao;

    /**
     * @var integer
     */
    private $codSubfuncao;

    /**
     * @var integer
     */
    private $numPrograma;

    /**
     * @var integer
     */
    private $numAcao;

    /**
     * @var integer
     */
    private $codRecurso;

    /**
     * @var string
     */
    private $naturezaDespesa;

    /**
     * @var integer
     */
    private $codEmpenho;

    /**
     * @var string
     */
    private $exercicioEmpenho;

    /**
     * @var string
     */
    private $tipoValor;

    /**
     * @var integer
     */
    private $vlLancamentoRpProcessados;

    /**
     * @var integer
     */
    private $vlLancamentoRpNaoProcessados;

    /**
     * @var integer
     */
    private $codEntidade;

    /**
     * @var integer
     */
    private $codLote;

    /**
     * @var \DateTime
     */
    private $dtLote;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $tipo;

    /**
     * @var integer
     */
    private $sequencia;

    /**
     * @var integer
     */
    private $oidTemp;

    /**
     * @var integer
     */
    private $codSistema;


    /**
     * Set numOrgao
     *
     * @param integer $numOrgao
     * @return BalanceteContabil14RestosPagar
     */
    public function setNumOrgao($numOrgao)
    {
        $this->numOrgao = $numOrgao;
        return $this;
    }

    /**
     * Get numOrgao
     *
     * @return integer
     */
    public function getNumOrgao()
    {
        return $this->numOrgao;
    }

    /**
     * Set numUnidade
     *
     * @param integer $numUnidade
     * @return BalanceteContabil14RestosPagar
     */
    public function setNumUnidade($numUnidade = null)
    {
        $this->numUnidade = $numUnidade;
        return $this;
    }

    /**
     * Get numUnidade
     *
     * @return integer
     */
    public function getNumUnidade()
    {
        return $this->numUnidade;
    }

    /**
     * Set codFuncao
     *
     * @param integer $codFuncao
     * @return BalanceteContabil14RestosPagar
     */
    public function setCodFuncao($codFuncao = null)
    {
        $this->codFuncao = $codFuncao;
        return $this;
    }

    /**
     * Get codFuncao
     *
     * @return integer
     */
    public function getCodFuncao()
    {
        return $this->codFuncao;
    }

    /**
     * Set codSubfuncao
     *
     * @param integer $codSubfuncao
     * @return BalanceteContabil14RestosPagar
     */
    public function setCodSubfuncao($codSubfuncao = null)
    {
        $this->codSubfuncao = $codSubfuncao;
        return $this;
    }

    /**
     * Get codSubfuncao
     *
     * @return integer
     */
    public function getCodSubfuncao()
    {
        return $this->codSubfuncao;
    }

    /**
     * Set numPrograma
     *
     * @param integer $numPrograma
     * @return BalanceteContabil14RestosPagar
     */
    public function setNumPrograma($numPrograma = null)
    {
        $this->numPrograma = $numPrograma;
        return $this;
    }

    /**
     * Get numPrograma
     *
     * @return integer
     */
    public function getNumPrograma()
    {
        return $this->numPrograma;
    }

    /**
     * Set numAcao
     *
     * @param integer $numAcao
     * @return BalanceteContabil14RestosPagar
     */
    public function setNumAcao($numAcao = null)
    {
        $this->numAcao = $numAcao;
        return $this;
    }

    /**
     * Get numAcao
     *
     * @return integer
     */
    public function getNumAcao()
    {
        return $this->numAcao;
    }

    /**
     * Set codRecurso
     *
     * @param integer $codRecurso
     * @return BalanceteContabil14RestosPagar
     */
    public function setCodRecurso($codRecurso = null)
    {
        $this->codRecurso = $codRecurso;
        return $this;
    }

    /**
     * Get codRecurso
     *
     * @return integer
     */
    public function getCodRecurso()
    {
        return $this->codRecurso;
    }

    /**
     * Set naturezaDespesa
     *
     * @param string $naturezaDespesa
     * @return BalanceteContabil14RestosPagar
     */
    public function setNaturezaDespesa($naturezaDespesa = null)
    {
        $this->naturezaDespesa = $naturezaDespesa;
        return $this;
    }

    /**
     * Get naturezaDespesa
     *
     * @return string
     */
    public function getNaturezaDespesa()
    {
        return $this->naturezaDespesa;
    }

    /**
     * Set codEmpenho
     *
     * @param integer $codEmpenho
     * @return BalanceteContabil14RestosPagar
     */
    public function setCodEmpenho($codEmpenho = null)
    {
        $this->codEmpenho = $codEmpenho;
        return $this;
    }

    /**
     * Get codEmpenho
     *
     * @return integer
     */
    public function getCodEmpenho()
    {
        return $this->codEmpenho;
    }

    /**
     * Set exercicioEmpenho
     *
     * @param string $exercicioEmpenho
     * @return BalanceteContabil14RestosPagar
     */
    public function setExercicioEmpenho($exercicioEmpenho = null)
    {
        $this->exercicioEmpenho = $exercicioEmpenho;
        return $this;
    }

    /**
     * Get exercicioEmpenho
     *
     * @return string
     */
    public function getExercicioEmpenho()
    {
        return $this->exercicioEmpenho;
    }

    /**
     * Set tipoValor
     *
     * @param string $tipoValor
     * @return BalanceteContabil14RestosPagar
     */
    public function setTipoValor($tipoValor = null)
    {
        $this->tipoValor = $tipoValor;
        return $this;
    }

    /**
     * Get tipoValor
     *
     * @return string
     */
    public function getTipoValor()
    {
        return $this->tipoValor;
    }

    /**
     * Set vlLancamentoRpProcessados
     *
     * @param integer $vlLancamentoRpProcessados
     * @return BalanceteContabil14RestosPagar
     */
    public function setVlLancamentoRpProcessados($vlLancamentoRpProcessados = null)
    {
        $this->vlLancamentoRpProcessados = $vlLancamentoRpProcessados;
        return $this;
    }

    /**
     * Get vlLancamentoRpProcessados
     *
     * @return integer
     */
    public function getVlLancamentoRpProcessados()
    {
        return $this->vlLancamentoRpProcessados;
    }

    /**
     * Set vlLancamentoRpNaoProcessados
     *
     * @param integer $vlLancamentoRpNaoProcessados
     * @return BalanceteContabil14RestosPagar
     */
    public function setVlLancamentoRpNaoProcessados($vlLancamentoRpNaoProcessados = null)
    {
        $this->vlLancamentoRpNaoProcessados = $vlLancamentoRpNaoProcessados;
        return $this;
    }

    /**
     * Get vlLancamentoRpNaoProcessados
     *
     * @return integer
     */
    public function getVlLancamentoRpNaoProcessados()
    {
        return $this->vlLancamentoRpNaoProcessados;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return BalanceteContabil14RestosPagar
     */
    public function setCodEntidade($codEntidade = null)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return BalanceteContabil14RestosPagar
     */
    public function setCodLote($codLote = null)
    {
        $this->codLote = $codLote;
        return $this;
    }

    /**
     * Get codLote
     *
     * @return integer
     */
    public function getCodLote()
    {
        return $this->codLote;
    }

    /**
     * Set dtLote
     *
     * @param \DateTime $dtLote
     * @return BalanceteContabil14RestosPagar
     */
    public function setDtLote(\DateTime $dtLote = null)
    {
        $this->dtLote = $dtLote;
        return $this;
    }

    /**
     * Get dtLote
     *
     * @return \DateTime
     */
    public function getDtLote()
    {
        return $this->dtLote;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return BalanceteContabil14RestosPagar
     */
    public function setExercicio($exercicio = null)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return BalanceteContabil14RestosPagar
     */
    public function setTipo($tipo = null)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set sequencia
     *
     * @param integer $sequencia
     * @return BalanceteContabil14RestosPagar
     */
    public function setSequencia($sequencia = null)
    {
        $this->sequencia = $sequencia;
        return $this;
    }

    /**
     * Get sequencia
     *
     * @return integer
     */
    public function getSequencia()
    {
        return $this->sequencia;
    }

    /**
     * Set oidTemp
     *
     * @param integer $oidTemp
     * @return BalanceteContabil14RestosPagar
     */
    public function setOidTemp($oidTemp = null)
    {
        $this->oidTemp = $oidTemp;
        return $this;
    }

    /**
     * Get oidTemp
     *
     * @return integer
     */
    public function getOidTemp()
    {
        return $this->oidTemp;
    }

    /**
     * Set codSistema
     *
     * @param integer $codSistema
     * @return BalanceteContabil14RestosPagar
     */
    public function setCodSistema($codSistema = null)
    {
        $this->codSistema = $codSistema;
        return $this;
    }

    /**
     * Get codSistema
     *
     * @return integer
     */
    public function getCodSistema()
    {
        return $this->codSistema;
    }
}
