<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwDocumentoProcesso
 */
class SwDocumentoProcesso
{
    /**
     * PK
     * @var integer
     */
    private $codDocumento;

    /**
     * PK
     * @var integer
     */
    private $codProcesso;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCopiaDigital
     */
    private $fkSwCopiaDigitais;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwDocumento
     */
    private $fkSwDocumento;

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
        $this->fkSwCopiaDigitais = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return SwDocumentoProcesso
     */
    public function setCodDocumento($codDocumento)
    {
        $this->codDocumento = $codDocumento;
        return $this;
    }

    /**
     * Get codDocumento
     *
     * @return integer
     */
    public function getCodDocumento()
    {
        return $this->codDocumento;
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return SwDocumentoProcesso
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
     * @return SwDocumentoProcesso
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
     * OneToMany (owning side)
     * Add SwCopiaDigital
     *
     * @param \Urbem\CoreBundle\Entity\SwCopiaDigital $fkSwCopiaDigital
     * @return SwDocumentoProcesso
     */
    public function addFkSwCopiaDigitais(\Urbem\CoreBundle\Entity\SwCopiaDigital $fkSwCopiaDigital)
    {
        if (false === $this->fkSwCopiaDigitais->contains($fkSwCopiaDigital)) {
            $fkSwCopiaDigital->setFkSwDocumentoProcesso($this);
            $this->fkSwCopiaDigitais->add($fkSwCopiaDigital);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwCopiaDigital
     *
     * @param \Urbem\CoreBundle\Entity\SwCopiaDigital $fkSwCopiaDigital
     */
    public function removeFkSwCopiaDigitais(\Urbem\CoreBundle\Entity\SwCopiaDigital $fkSwCopiaDigital)
    {
        $this->fkSwCopiaDigitais->removeElement($fkSwCopiaDigital);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwCopiaDigitais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCopiaDigital
     */
    public function getFkSwCopiaDigitais()
    {
        return $this->fkSwCopiaDigitais;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwDocumento
     *
     * @param \Urbem\CoreBundle\Entity\SwDocumento $fkSwDocumento
     * @return SwDocumentoProcesso
     */
    public function setFkSwDocumento(\Urbem\CoreBundle\Entity\SwDocumento $fkSwDocumento)
    {
        $this->codDocumento = $fkSwDocumento->getCodDocumento();
        $this->fkSwDocumento = $fkSwDocumento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwDocumento
     *
     * @return \Urbem\CoreBundle\Entity\SwDocumento
     */
    public function getFkSwDocumento()
    {
        return $this->fkSwDocumento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     * @return SwDocumentoProcesso
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
}
