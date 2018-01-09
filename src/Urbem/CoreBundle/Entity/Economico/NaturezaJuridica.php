<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * NaturezaJuridica
 */
class NaturezaJuridica
{
    /**
     * PK
     * @var integer
     */
    private $codNatureza;

    /**
     * @var string
     */
    private $nomNatureza;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Economico\BaixaNaturezaJuridica
     */
    private $fkEconomicoBaixaNaturezaJuridica;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\EmpresaDireitoNaturezaJuridica
     */
    private $fkEconomicoEmpresaDireitoNaturezaJuridicas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoEmpresaDireitoNaturezaJuridicas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return NaturezaJuridica
     */
    public function setCodNatureza($codNatureza)
    {
        $this->codNatureza = $codNatureza;
        return $this;
    }

    /**
     * Get codNatureza
     *
     * @return integer
     */
    public function getCodNatureza()
    {
        return $this->codNatureza;
    }

    /**
     * Set nomNatureza
     *
     * @param string $nomNatureza
     * @return NaturezaJuridica
     */
    public function setNomNatureza($nomNatureza)
    {
        $this->nomNatureza = $nomNatureza;
        return $this;
    }

    /**
     * Get nomNatureza
     *
     * @return string
     */
    public function getNomNatureza()
    {
        return $this->nomNatureza;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoEmpresaDireitoNaturezaJuridica
     *
     * @param \Urbem\CoreBundle\Entity\Economico\EmpresaDireitoNaturezaJuridica $fkEconomicoEmpresaDireitoNaturezaJuridica
     * @return NaturezaJuridica
     */
    public function addFkEconomicoEmpresaDireitoNaturezaJuridicas(\Urbem\CoreBundle\Entity\Economico\EmpresaDireitoNaturezaJuridica $fkEconomicoEmpresaDireitoNaturezaJuridica)
    {
        if (false === $this->fkEconomicoEmpresaDireitoNaturezaJuridicas->contains($fkEconomicoEmpresaDireitoNaturezaJuridica)) {
            $fkEconomicoEmpresaDireitoNaturezaJuridica->setFkEconomicoNaturezaJuridica($this);
            $this->fkEconomicoEmpresaDireitoNaturezaJuridicas->add($fkEconomicoEmpresaDireitoNaturezaJuridica);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoEmpresaDireitoNaturezaJuridica
     *
     * @param \Urbem\CoreBundle\Entity\Economico\EmpresaDireitoNaturezaJuridica $fkEconomicoEmpresaDireitoNaturezaJuridica
     */
    public function removeFkEconomicoEmpresaDireitoNaturezaJuridicas(\Urbem\CoreBundle\Entity\Economico\EmpresaDireitoNaturezaJuridica $fkEconomicoEmpresaDireitoNaturezaJuridica)
    {
        $this->fkEconomicoEmpresaDireitoNaturezaJuridicas->removeElement($fkEconomicoEmpresaDireitoNaturezaJuridica);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoEmpresaDireitoNaturezaJuridicas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\EmpresaDireitoNaturezaJuridica
     */
    public function getFkEconomicoEmpresaDireitoNaturezaJuridicas()
    {
        return $this->fkEconomicoEmpresaDireitoNaturezaJuridicas;
    }

    /**
     * OneToOne (inverse side)
     * Set EconomicoBaixaNaturezaJuridica
     *
     * @param \Urbem\CoreBundle\Entity\Economico\BaixaNaturezaJuridica $fkEconomicoBaixaNaturezaJuridica
     * @return NaturezaJuridica
     */
    public function setFkEconomicoBaixaNaturezaJuridica(\Urbem\CoreBundle\Entity\Economico\BaixaNaturezaJuridica $fkEconomicoBaixaNaturezaJuridica)
    {
        $fkEconomicoBaixaNaturezaJuridica->setFkEconomicoNaturezaJuridica($this);
        $this->fkEconomicoBaixaNaturezaJuridica = $fkEconomicoBaixaNaturezaJuridica;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEconomicoBaixaNaturezaJuridica
     *
     * @return \Urbem\CoreBundle\Entity\Economico\BaixaNaturezaJuridica
     */
    public function getFkEconomicoBaixaNaturezaJuridica()
    {
        return $this->fkEconomicoBaixaNaturezaJuridica;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->getCodNatureza(), $this->getNomNatureza());
    }
}
