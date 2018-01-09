<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * NotaFiscalLiquidacao
 */
class NotaFiscalLiquidacao
{
    /**
     * PK
     * @var integer
     */
    private $codNotaLiquidacao;

    /**
     * PK
     * @var string
     */
    private $exercicioLiquidacao;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * @var string
     */
    private $ano;

    /**
     * @var string
     */
    private $nroNota;

    /**
     * @var string
     */
    private $nroSerie;

    /**
     * @var string
     */
    private $nroSubserie;

    /**
     * @var \DateTime
     */
    private $dataEmissao;

    /**
     * @var integer
     */
    private $vlNota;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var integer
     */
    private $codUf;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao
     */
    private $fkEmpenhoNotaLiquidacao;


    /**
     * Set codNotaLiquidacao
     *
     * @param integer $codNotaLiquidacao
     * @return NotaFiscalLiquidacao
     */
    public function setCodNotaLiquidacao($codNotaLiquidacao)
    {
        $this->codNotaLiquidacao = $codNotaLiquidacao;
        return $this;
    }

    /**
     * Get codNotaLiquidacao
     *
     * @return integer
     */
    public function getCodNotaLiquidacao()
    {
        return $this->codNotaLiquidacao;
    }

    /**
     * Set exercicioLiquidacao
     *
     * @param string $exercicioLiquidacao
     * @return NotaFiscalLiquidacao
     */
    public function setExercicioLiquidacao($exercicioLiquidacao)
    {
        $this->exercicioLiquidacao = $exercicioLiquidacao;
        return $this;
    }

    /**
     * Get exercicioLiquidacao
     *
     * @return string
     */
    public function getExercicioLiquidacao()
    {
        return $this->exercicioLiquidacao;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return NotaFiscalLiquidacao
     */
    public function setCodEntidade($codEntidade)
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
     * Set ano
     *
     * @param string $ano
     * @return NotaFiscalLiquidacao
     */
    public function setAno($ano = null)
    {
        $this->ano = $ano;
        return $this;
    }

    /**
     * Get ano
     *
     * @return string
     */
    public function getAno()
    {
        return $this->ano;
    }

    /**
     * Set nroNota
     *
     * @param string $nroNota
     * @return NotaFiscalLiquidacao
     */
    public function setNroNota($nroNota = null)
    {
        $this->nroNota = $nroNota;
        return $this;
    }

    /**
     * Get nroNota
     *
     * @return string
     */
    public function getNroNota()
    {
        return $this->nroNota;
    }

    /**
     * Set nroSerie
     *
     * @param string $nroSerie
     * @return NotaFiscalLiquidacao
     */
    public function setNroSerie($nroSerie = null)
    {
        $this->nroSerie = $nroSerie;
        return $this;
    }

    /**
     * Get nroSerie
     *
     * @return string
     */
    public function getNroSerie()
    {
        return $this->nroSerie;
    }

    /**
     * Set nroSubserie
     *
     * @param string $nroSubserie
     * @return NotaFiscalLiquidacao
     */
    public function setNroSubserie($nroSubserie = null)
    {
        $this->nroSubserie = $nroSubserie;
        return $this;
    }

    /**
     * Get nroSubserie
     *
     * @return string
     */
    public function getNroSubserie()
    {
        return $this->nroSubserie;
    }

    /**
     * Set dataEmissao
     *
     * @param \DateTime $dataEmissao
     * @return NotaFiscalLiquidacao
     */
    public function setDataEmissao(\DateTime $dataEmissao = null)
    {
        $this->dataEmissao = $dataEmissao;
        return $this;
    }

    /**
     * Get dataEmissao
     *
     * @return \DateTime
     */
    public function getDataEmissao()
    {
        return $this->dataEmissao;
    }

    /**
     * Set vlNota
     *
     * @param integer $vlNota
     * @return NotaFiscalLiquidacao
     */
    public function setVlNota($vlNota = null)
    {
        $this->vlNota = $vlNota;
        return $this;
    }

    /**
     * Get vlNota
     *
     * @return integer
     */
    public function getVlNota()
    {
        return $this->vlNota;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return NotaFiscalLiquidacao
     */
    public function setDescricao($descricao = null)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set codUf
     *
     * @param integer $codUf
     * @return NotaFiscalLiquidacao
     */
    public function setCodUf($codUf = null)
    {
        $this->codUf = $codUf;
        return $this;
    }

    /**
     * Get codUf
     *
     * @return integer
     */
    public function getCodUf()
    {
        return $this->codUf;
    }

    /**
     * OneToOne (owning side)
     * Set EmpenhoNotaLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao $fkEmpenhoNotaLiquidacao
     * @return NotaFiscalLiquidacao
     */
    public function setFkEmpenhoNotaLiquidacao(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao $fkEmpenhoNotaLiquidacao)
    {
        $this->exercicioLiquidacao = $fkEmpenhoNotaLiquidacao->getExercicio();
        $this->codNotaLiquidacao = $fkEmpenhoNotaLiquidacao->getCodNota();
        $this->codEntidade = $fkEmpenhoNotaLiquidacao->getCodEntidade();
        $this->fkEmpenhoNotaLiquidacao = $fkEmpenhoNotaLiquidacao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkEmpenhoNotaLiquidacao
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao
     */
    public function getFkEmpenhoNotaLiquidacao()
    {
        return $this->fkEmpenhoNotaLiquidacao;
    }
}
