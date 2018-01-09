<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * ProcessoLoteamento
 */
class ProcessoLoteamento
{
    /**
     * PK
     * @var integer
     */
    private $codLoteamento;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codProcesso;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Loteamento
     */
    private $fkImobiliarioLoteamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwProcesso
     */
    private $fkSwProcesso;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codLoteamento
     *
     * @param integer $codLoteamento
     * @return ProcessoLoteamento
     */
    public function setCodLoteamento($codLoteamento)
    {
        $this->codLoteamento = $codLoteamento;
        return $this;
    }

    /**
     * Get codLoteamento
     *
     * @return integer
     */
    public function getCodLoteamento()
    {
        return $this->codLoteamento;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return ProcessoLoteamento
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimePK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return ProcessoLoteamento
     */
    public function setCodProcesso($codProcesso)
    {
        $this->codProcesso = $codProcesso;
        return $this;
    }

    /**
     * Get codProcesso
     *
     * @return integer
     */
    public function getCodProcesso()
    {
        return $this->codProcesso;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ProcessoLoteamento
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
     * ManyToOne (inverse side)
     * Set fkImobiliarioLoteamento
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Loteamento $fkImobiliarioLoteamento
     * @return ProcessoLoteamento
     */
    public function setFkImobiliarioLoteamento(\Urbem\CoreBundle\Entity\Imobiliario\Loteamento $fkImobiliarioLoteamento)
    {
        $this->codLoteamento = $fkImobiliarioLoteamento->getCodLoteamento();
        $this->fkImobiliarioLoteamento = $fkImobiliarioLoteamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioLoteamento
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Loteamento
     */
    public function getFkImobiliarioLoteamento()
    {
        return $this->fkImobiliarioLoteamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     * @return ProcessoLoteamento
     */
    public function setFkSwProcesso(\Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso)
    {
        $this->codProcesso = $fkSwProcesso->getCodProcesso();
        $this->exercicio = $fkSwProcesso->getAnoExercicio();
        $this->fkSwProcesso = $fkSwProcesso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwProcesso
     *
     * @return \Urbem\CoreBundle\Entity\SwProcesso
     */
    public function getFkSwProcesso()
    {
        return $this->fkSwProcesso;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->fkSwProcesso;
    }
}
