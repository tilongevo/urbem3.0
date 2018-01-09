<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * RegistrosArquivoInclusaoPrograma
 */
class RegistrosArquivoInclusaoPrograma
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codPrograma;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ppa\Programa
     */
    private $fkPpaPrograma;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \DateTime;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return RegistrosArquivoInclusaoPrograma
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
     * Set codPrograma
     *
     * @param integer $codPrograma
     * @return RegistrosArquivoInclusaoPrograma
     */
    public function setCodPrograma($codPrograma)
    {
        $this->codPrograma = $codPrograma;
        return $this;
    }

    /**
     * Get codPrograma
     *
     * @return integer
     */
    public function getCodPrograma()
    {
        return $this->codPrograma;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return RegistrosArquivoInclusaoPrograma
     */
    public function setTimestamp(\DateTime $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPpaPrograma
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\Programa $fkPpaPrograma
     * @return RegistrosArquivoInclusaoPrograma
     */
    public function setFkPpaPrograma(\Urbem\CoreBundle\Entity\Ppa\Programa $fkPpaPrograma)
    {
        $this->codPrograma = $fkPpaPrograma->getCodPrograma();
        $this->fkPpaPrograma = $fkPpaPrograma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPpaPrograma
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\Programa
     */
    public function getFkPpaPrograma()
    {
        return $this->fkPpaPrograma;
    }
}
