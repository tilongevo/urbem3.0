<?php
 
namespace Urbem\CoreBundle\Entity\Tcepb;

/**
 * NotaFiscal
 */
class NotaFiscal
{
    /**
     * PK
     * @var integer
     */
    private $codNota;

    /**
     * PK
     * @var integer
     */
    private $codNotaLiquidacao;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $nroNota;

    /**
     * @var string
     */
    private $nroSerie;

    /**
     * @var \DateTime
     */
    private $dataEmissao;

    /**
     * @var integer
     */
    private $nroSequencial;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao
     */
    private $fkEmpenhoNotaLiquidacao;


    /**
     * Set codNota
     *
     * @param integer $codNota
     * @return NotaFiscal
     */
    public function setCodNota($codNota)
    {
        $this->codNota = $codNota;
        return $this;
    }

    /**
     * Get codNota
     *
     * @return integer
     */
    public function getCodNota()
    {
        return $this->codNota;
    }

    /**
     * Set codNotaLiquidacao
     *
     * @param integer $codNotaLiquidacao
     * @return NotaFiscal
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return NotaFiscal
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return NotaFiscal
     */
    public function setExercicio($exercicio)
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
     * Set nroNota
     *
     * @param integer $nroNota
     * @return NotaFiscal
     */
    public function setNroNota($nroNota)
    {
        $this->nroNota = $nroNota;
        return $this;
    }

    /**
     * Get nroNota
     *
     * @return integer
     */
    public function getNroNota()
    {
        return $this->nroNota;
    }

    /**
     * Set nroSerie
     *
     * @param string $nroSerie
     * @return NotaFiscal
     */
    public function setNroSerie($nroSerie)
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
     * Set dataEmissao
     *
     * @param \DateTime $dataEmissao
     * @return NotaFiscal
     */
    public function setDataEmissao(\DateTime $dataEmissao)
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
     * Set nroSequencial
     *
     * @param integer $nroSequencial
     * @return NotaFiscal
     */
    public function setNroSequencial($nroSequencial)
    {
        $this->nroSequencial = $nroSequencial;
        return $this;
    }

    /**
     * Get nroSequencial
     *
     * @return integer
     */
    public function getNroSequencial()
    {
        return $this->nroSequencial;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoNotaLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao $fkEmpenhoNotaLiquidacao
     * @return NotaFiscal
     */
    public function setFkEmpenhoNotaLiquidacao(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao $fkEmpenhoNotaLiquidacao)
    {
        $this->exercicio = $fkEmpenhoNotaLiquidacao->getExercicio();
        $this->codNotaLiquidacao = $fkEmpenhoNotaLiquidacao->getCodNota();
        $this->codEntidade = $fkEmpenhoNotaLiquidacao->getCodEntidade();
        $this->fkEmpenhoNotaLiquidacao = $fkEmpenhoNotaLiquidacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoNotaLiquidacao
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao
     */
    public function getFkEmpenhoNotaLiquidacao()
    {
        return $this->fkEmpenhoNotaLiquidacao;
    }
}
