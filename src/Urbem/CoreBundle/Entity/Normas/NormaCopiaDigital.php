<?php
 
namespace Urbem\CoreBundle\Entity\Normas;

/**
 * NormaCopiaDigital
 */
class NormaCopiaDigital
{
    /**
     * PK
     * @var integer
     */
    private $codNorma;

    /**
     * @var integer
     */
    private $codCopia;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\CopiaDigital
     */
    private $fkNormasCopiaDigital;


    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return NormaCopiaDigital
     */
    public function setCodNorma($codNorma)
    {
        $this->codNorma = $codNorma;
        return $this;
    }

    /**
     * Get codNorma
     *
     * @return integer
     */
    public function getCodNorma()
    {
        return $this->codNorma;
    }

    /**
     * Set codCopia
     *
     * @param integer $codCopia
     * @return NormaCopiaDigital
     */
    public function setCodCopia($codCopia)
    {
        $this->codCopia = $codCopia;
        return $this;
    }

    /**
     * Get codCopia
     *
     * @return integer
     */
    public function getCodCopia()
    {
        return $this->codCopia;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasCopiaDigital
     *
     * @param \Urbem\CoreBundle\Entity\Normas\CopiaDigital $fkNormasCopiaDigital
     * @return NormaCopiaDigital
     */
    public function setFkNormasCopiaDigital(\Urbem\CoreBundle\Entity\Normas\CopiaDigital $fkNormasCopiaDigital)
    {
        $this->codCopia = $fkNormasCopiaDigital->getCodCopia();
        $this->fkNormasCopiaDigital = $fkNormasCopiaDigital;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasCopiaDigital
     *
     * @return \Urbem\CoreBundle\Entity\Normas\CopiaDigital
     */
    public function getFkNormasCopiaDigital()
    {
        return $this->fkNormasCopiaDigital;
    }

    /**
     * OneToOne (owning side)
     * Set NormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return NormaCopiaDigital
     */
    public function setFkNormasNorma(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        $this->codNorma = $fkNormasNorma->getCodNorma();
        $this->fkNormasNorma = $fkNormasNorma;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkNormasNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNorma()
    {
        return $this->fkNormasNorma;
    }
}
