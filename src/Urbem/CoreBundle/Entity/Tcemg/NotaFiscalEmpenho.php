<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * NotaFiscalEmpenho
 */
class NotaFiscalEmpenho
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
     * @var string
     */
    private $exercicioEmpenho;

    /**
     * @var integer
     */
    private $vlAssociado;

    /**
     * @var integer
     */
    private $vlTotalLiquido;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcemg\NotaFiscal
     */
    private $fkTcemgNotaFiscal;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    private $fkEmpenhoEmpenho;


    /**
     * Set codNota
     *
     * @param integer $codNota
     * @return NotaFiscalEmpenho
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
     * @return NotaFiscalEmpenho
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
     * @return NotaFiscalEmpenho
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
     * @return NotaFiscalEmpenho
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
     * @return NotaFiscalEmpenho
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
     * Set vlAssociado
     *
     * @param integer $vlAssociado
     * @return NotaFiscalEmpenho
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
     * Set vlTotalLiquido
     *
     * @param integer $vlTotalLiquido
     * @return NotaFiscalEmpenho
     */
    public function setVlTotalLiquido($vlTotalLiquido)
    {
        $this->vlTotalLiquido = $vlTotalLiquido;
        return $this;
    }

    /**
     * Get vlTotalLiquido
     *
     * @return integer
     */
    public function getVlTotalLiquido()
    {
        return $this->vlTotalLiquido;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcemgNotaFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\NotaFiscal $fkTcemgNotaFiscal
     * @return NotaFiscalEmpenho
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
     * Set fkEmpenhoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho
     * @return NotaFiscalEmpenho
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
