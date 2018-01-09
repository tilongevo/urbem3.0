<?php
 
namespace Urbem\CoreBundle\Entity\Normas;

/**
 * NormaDataTermino
 */
class NormaDataTermino
{
    /**
     * PK
     * @var integer
     */
    private $codNorma;

    /**
     * @var \DateTime
     */
    private $dtTermino;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;


    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return NormaDataTermino
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
     * Set dtTermino
     *
     * @param \DateTime $dtTermino
     * @return NormaDataTermino
     */
    public function setDtTermino(\DateTime $dtTermino = null)
    {
        $this->dtTermino = $dtTermino;
        return $this;
    }

    /**
     * Get dtTermino
     *
     * @return \DateTime
     */
    public function getDtTermino()
    {
        return $this->dtTermino;
    }

    /**
     * OneToOne (owning side)
     * Set NormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return NormaDataTermino
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

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->dtTermino->format('d/m/Y');
    }
}
