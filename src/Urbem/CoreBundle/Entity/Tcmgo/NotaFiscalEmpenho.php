<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

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
     * @var integer
     */
    private $vlAssociado;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmgo\NotaFiscal
     */
    private $fkTcmgoNotaFiscal;

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
     * ManyToOne (inverse side)
     * Set fkTcmgoNotaFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\NotaFiscal $fkTcmgoNotaFiscal
     * @return NotaFiscalEmpenho
     */
    public function setFkTcmgoNotaFiscal(\Urbem\CoreBundle\Entity\Tcmgo\NotaFiscal $fkTcmgoNotaFiscal)
    {
        $this->codNota = $fkTcmgoNotaFiscal->getCodNota();
        $this->fkTcmgoNotaFiscal = $fkTcmgoNotaFiscal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmgoNotaFiscal
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\NotaFiscal
     */
    public function getFkTcmgoNotaFiscal()
    {
        return $this->fkTcmgoNotaFiscal;
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
        $this->exercicio = $fkEmpenhoEmpenho->getExercicio();
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
