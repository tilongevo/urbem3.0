<?php
 
namespace Urbem\CoreBundle\Entity\Ppa;

/**
 * PpaPrecisao
 */
class PpaPrecisao
{
    /**
     * PK
     * @var integer
     */
    private $codPpa;

    /**
     * @var integer
     */
    private $codPrecisao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Ppa\Ppa
     */
    private $fkPpaPpa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ppa\Precisao
     */
    private $fkPpaPrecisao;


    /**
     * Set codPpa
     *
     * @param integer $codPpa
     * @return PpaPrecisao
     */
    public function setCodPpa($codPpa)
    {
        $this->codPpa = $codPpa;
        return $this;
    }

    /**
     * Get codPpa
     *
     * @return integer
     */
    public function getCodPpa()
    {
        return $this->codPpa;
    }

    /**
     * Set codPrecisao
     *
     * @param integer $codPrecisao
     * @return PpaPrecisao
     */
    public function setCodPrecisao($codPrecisao)
    {
        $this->codPrecisao = $codPrecisao;
        return $this;
    }

    /**
     * Get codPrecisao
     *
     * @return integer
     */
    public function getCodPrecisao()
    {
        return $this->codPrecisao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPpaPrecisao
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\Precisao $fkPpaPrecisao
     * @return PpaPrecisao
     */
    public function setFkPpaPrecisao(\Urbem\CoreBundle\Entity\Ppa\Precisao $fkPpaPrecisao)
    {
        $this->codPrecisao = $fkPpaPrecisao->getCodPrecisao();
        $this->fkPpaPrecisao = $fkPpaPrecisao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPpaPrecisao
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\Precisao
     */
    public function getFkPpaPrecisao()
    {
        return $this->fkPpaPrecisao;
    }

    /**
     * OneToOne (owning side)
     * Set PpaPpa
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\Ppa $fkPpaPpa
     * @return PpaPrecisao
     */
    public function setFkPpaPpa(\Urbem\CoreBundle\Entity\Ppa\Ppa $fkPpaPpa)
    {
        $this->codPpa = $fkPpaPpa->getCodPpa();
        $this->fkPpaPpa = $fkPpaPpa;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPpaPpa
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\Ppa
     */
    public function getFkPpaPpa()
    {
        return $this->fkPpaPpa;
    }
}
