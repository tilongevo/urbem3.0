<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwProcessoApensado
 */
class SwProcessoApensado
{
    /**
     * PK
     * @var integer
     */
    private $codProcessoFilho;

    /**
     * PK
     * @var string
     */
    private $exercicioFilho;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestampApensamento;

    /**
     * @var integer
     */
    private $codProcessoPai;

    /**
     * @var string
     */
    private $exercicioPai;

    /**
     * @var \DateTime
     */
    private $timestampDesapensamento;

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
        $this->timestampApensamento = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codProcessoFilho
     *
     * @param integer $codProcessoFilho
     * @return SwProcessoApensado
     */
    public function setCodProcessoFilho($codProcessoFilho)
    {
        $this->codProcessoFilho = $codProcessoFilho;
        return $this;
    }

    /**
     * Get codProcessoFilho
     *
     * @return integer
     */
    public function getCodProcessoFilho()
    {
        return $this->codProcessoFilho;
    }

    /**
     * Set exercicioFilho
     *
     * @param string $exercicioFilho
     * @return SwProcessoApensado
     */
    public function setExercicioFilho($exercicioFilho)
    {
        $this->exercicioFilho = $exercicioFilho;
        return $this;
    }

    /**
     * Get exercicioFilho
     *
     * @return string
     */
    public function getExercicioFilho()
    {
        return $this->exercicioFilho;
    }

    /**
     * Set timestampApensamento
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestampApensamento
     * @return SwProcessoApensado
     */
    public function setTimestampApensamento(\Urbem\CoreBundle\Helper\DateTimePK $timestampApensamento)
    {
        $this->timestampApensamento = $timestampApensamento;
        return $this;
    }

    /**
     * Get timestampApensamento
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestampApensamento()
    {
        return $this->timestampApensamento;
    }

    /**
     * Set codProcessoPai
     *
     * @param integer $codProcessoPai
     * @return SwProcessoApensado
     */
    public function setCodProcessoPai($codProcessoPai)
    {
        $this->codProcessoPai = $codProcessoPai;
        return $this;
    }

    /**
     * Get codProcessoPai
     *
     * @return integer
     */
    public function getCodProcessoPai()
    {
        return $this->codProcessoPai;
    }

    /**
     * Set exercicioPai
     *
     * @param string $exercicioPai
     * @return SwProcessoApensado
     */
    public function setExercicioPai($exercicioPai)
    {
        $this->exercicioPai = $exercicioPai;
        return $this;
    }

    /**
     * Get exercicioPai
     *
     * @return string
     */
    public function getExercicioPai()
    {
        return $this->exercicioPai;
    }

    /**
     * Set timestampDesapensamento
     *
     * @param \DateTime $timestampDesapensamento
     * @return SwProcessoApensado
     */
    public function setTimestampDesapensamento(\DateTime $timestampDesapensamento = null)
    {
        $this->timestampDesapensamento = $timestampDesapensamento;
        return $this;
    }

    /**
     * Get timestampDesapensamento
     *
     * @return \DateTime
     */
    public function getTimestampDesapensamento()
    {
        return $this->timestampDesapensamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     * @return SwProcessoApensado
     */
    public function setFkSwProcesso(\Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso)
    {
        $this->codProcessoFilho = $fkSwProcesso->getCodProcesso();
        $this->exercicioFilho = $fkSwProcesso->getAnoExercicio();
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
}
