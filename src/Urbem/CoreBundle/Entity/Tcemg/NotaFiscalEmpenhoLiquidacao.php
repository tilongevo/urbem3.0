<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * NotaFiscalEmpenhoLiquidacao
 */
class NotaFiscalEmpenhoLiquidacao
{
    /**
     * PK
     * @var integer
     */
    private $codNota;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $codEmpenho;

    /**
     * PK
     * @var string
     */
    private $exercicioEmpenho;

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
     * @var integer
     */
    private $vlLiquidacao;

    /**
     * @var integer
     */
    private $vlAssociado;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcemg\NotaFiscal
     */
    private $fkTcemgNotaFiscal;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao
     */
    private $fkEmpenhoNotaLiquidacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    private $fkEmpenhoEmpenho;


    /**
     * Set codNota
     *
     * @param integer $codNota
     * @return NotaFiscalEmpenhoLiquidacao
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return NotaFiscalEmpenhoLiquidacao
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return NotaFiscalEmpenhoLiquidacao
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
     * Set codEmpenho
     *
     * @param integer $codEmpenho
     * @return NotaFiscalEmpenhoLiquidacao
     */
    public function setCodEmpenho($codEmpenho)
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
     * @return NotaFiscalEmpenhoLiquidacao
     */
    public function setExercicioEmpenho($exercicioEmpenho)
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
     * Set codNotaLiquidacao
     *
     * @param integer $codNotaLiquidacao
     * @return NotaFiscalEmpenhoLiquidacao
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
     * @return NotaFiscalEmpenhoLiquidacao
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
     * Set vlLiquidacao
     *
     * @param integer $vlLiquidacao
     * @return NotaFiscalEmpenhoLiquidacao
     */
    public function setVlLiquidacao($vlLiquidacao)
    {
        $this->vlLiquidacao = $vlLiquidacao;
        return $this;
    }

    /**
     * Get vlLiquidacao
     *
     * @return integer
     */
    public function getVlLiquidacao()
    {
        return $this->vlLiquidacao;
    }

    /**
     * Set vlAssociado
     *
     * @param integer $vlAssociado
     * @return NotaFiscalEmpenhoLiquidacao
     */
    public function setVlAssociado($vlAssociado)
    {
        $this->vlAssociado = $vlAssociado;
        return $this;
    }

    /**
     * Get vlAssociado
     *
     * @return integer
     */
    public function getVlAssociado()
    {
        return $this->vlAssociado;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcemgNotaFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\NotaFiscal $fkTcemgNotaFiscal
     * @return NotaFiscalEmpenhoLiquidacao
     */
    public function setFkTcemgNotaFiscal(\Urbem\CoreBundle\Entity\Tcemg\NotaFiscal $fkTcemgNotaFiscal)
    {
        $this->codNota = $fkTcemgNotaFiscal->getCodNota();
        $this->exercicio = $fkTcemgNotaFiscal->getExercicio();
        $this->codEntidade = $fkTcemgNotaFiscal->getCodEntidade();
        $this->fkTcemgNotaFiscal = $fkTcemgNotaFiscal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgNotaFiscal
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\NotaFiscal
     */
    public function getFkTcemgNotaFiscal()
    {
        return $this->fkTcemgNotaFiscal;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoNotaLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao $fkEmpenhoNotaLiquidacao
     * @return NotaFiscalEmpenhoLiquidacao
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
     * ManyToOne (inverse side)
     * Get fkEmpenhoNotaLiquidacao
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao
     */
    public function getFkEmpenhoNotaLiquidacao()
    {
        return $this->fkEmpenhoNotaLiquidacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho
     * @return NotaFiscalEmpenhoLiquidacao
     */
    public function setFkEmpenhoEmpenho(\Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho)
    {
        $this->codEmpenho = $fkEmpenhoEmpenho->getCodEmpenho();
        $this->exercicioEmpenho = $fkEmpenhoEmpenho->getExercicio();
        $this->codEntidade = $fkEmpenhoEmpenho->getCodEntidade();
        $this->fkEmpenhoEmpenho = $fkEmpenhoEmpenho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    public function getFkEmpenhoEmpenho()
    {
        return $this->fkEmpenhoEmpenho;
    }
}
