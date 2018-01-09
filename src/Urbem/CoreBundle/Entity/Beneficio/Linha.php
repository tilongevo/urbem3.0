<?php
 
namespace Urbem\CoreBundle\Entity\Beneficio;

/**
 * Linha
 */
class Linha
{
    /**
     * PK
     * @var integer
     */
    private $codLinha;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\Itinerario
     */
    private $fkBeneficioItinerarios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\Itinerario
     */
    private $fkBeneficioItinerarios1;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkBeneficioItinerarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkBeneficioItinerarios1 = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codLinha
     *
     * @param integer $codLinha
     * @return Linha
     */
    public function setCodLinha($codLinha)
    {
        $this->codLinha = $codLinha;
        return $this;
    }

    /**
     * Get codLinha
     *
     * @return integer
     */
    public function getCodLinha()
    {
        return $this->codLinha;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Linha
     */
    public function setDescricao($descricao = null)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * OneToMany (owning side)
     * Add BeneficioItinerario
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\Itinerario $fkBeneficioItinerario
     * @return Linha
     */
    public function addFkBeneficioItinerarios(\Urbem\CoreBundle\Entity\Beneficio\Itinerario $fkBeneficioItinerario)
    {
        if (false === $this->fkBeneficioItinerarios->contains($fkBeneficioItinerario)) {
            $fkBeneficioItinerario->setFkBeneficioLinha($this);
            $this->fkBeneficioItinerarios->add($fkBeneficioItinerario);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove BeneficioItinerario
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\Itinerario $fkBeneficioItinerario
     */
    public function removeFkBeneficioItinerarios(\Urbem\CoreBundle\Entity\Beneficio\Itinerario $fkBeneficioItinerario)
    {
        $this->fkBeneficioItinerarios->removeElement($fkBeneficioItinerario);
    }

    /**
     * OneToMany (owning side)
     * Get fkBeneficioItinerarios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\Itinerario
     */
    public function getFkBeneficioItinerarios()
    {
        return $this->fkBeneficioItinerarios;
    }

    /**
     * OneToMany (owning side)
     * Add BeneficioItinerario
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\Itinerario $fkBeneficioItinerario
     * @return Linha
     */
    public function addFkBeneficioItinerarios1(\Urbem\CoreBundle\Entity\Beneficio\Itinerario $fkBeneficioItinerario)
    {
        if (false === $this->fkBeneficioItinerarios1->contains($fkBeneficioItinerario)) {
            $fkBeneficioItinerario->setFkBeneficioLinha1($this);
            $this->fkBeneficioItinerarios1->add($fkBeneficioItinerario);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove BeneficioItinerario
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\Itinerario $fkBeneficioItinerario
     */
    public function removeFkBeneficioItinerarios1(\Urbem\CoreBundle\Entity\Beneficio\Itinerario $fkBeneficioItinerario)
    {
        $this->fkBeneficioItinerarios1->removeElement($fkBeneficioItinerario);
    }

    /**
     * OneToMany (owning side)
     * Get fkBeneficioItinerarios1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\Itinerario
     */
    public function getFkBeneficioItinerarios1()
    {
        return $this->fkBeneficioItinerarios1;
    }

    public function __toString()
    {
        return (string) $this->getDescricao();
    }
}
