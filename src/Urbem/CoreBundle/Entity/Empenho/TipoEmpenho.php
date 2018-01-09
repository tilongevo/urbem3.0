<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * TipoEmpenho
 */
class TipoEmpenho
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $nomTipo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\PreEmpenho
     */
    private $fkEmpenhoPreEmpenhos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEmpenhoPreEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoEmpenho
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set nomTipo
     *
     * @param string $nomTipo
     * @return TipoEmpenho
     */
    public function setNomTipo($nomTipo)
    {
        $this->nomTipo = $nomTipo;
        return $this;
    }

    /**
     * Get nomTipo
     *
     * @return string
     */
    public function getNomTipo()
    {
        return $this->nomTipo;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\PreEmpenho $fkEmpenhoPreEmpenho
     * @return TipoEmpenho
     */
    public function addFkEmpenhoPreEmpenhos(\Urbem\CoreBundle\Entity\Empenho\PreEmpenho $fkEmpenhoPreEmpenho)
    {
        if (false === $this->fkEmpenhoPreEmpenhos->contains($fkEmpenhoPreEmpenho)) {
            $fkEmpenhoPreEmpenho->setFkEmpenhoTipoEmpenho($this);
            $this->fkEmpenhoPreEmpenhos->add($fkEmpenhoPreEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\PreEmpenho $fkEmpenhoPreEmpenho
     */
    public function removeFkEmpenhoPreEmpenhos(\Urbem\CoreBundle\Entity\Empenho\PreEmpenho $fkEmpenhoPreEmpenho)
    {
        $this->fkEmpenhoPreEmpenhos->removeElement($fkEmpenhoPreEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoPreEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\PreEmpenho
     */
    public function getFkEmpenhoPreEmpenhos()
    {
        return $this->fkEmpenhoPreEmpenhos;
    }
}
