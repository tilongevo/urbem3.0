<?php
 
namespace Urbem\CoreBundle\Entity\Beneficio;

/**
 * TipoConcessaoValeTransporte
 */
class TipoConcessaoValeTransporte
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporte
     */
    private $fkBeneficioConcessaoValeTransportes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkBeneficioConcessaoValeTransportes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoConcessaoValeTransporte
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
     * Set descricao
     *
     * @param string $descricao
     * @return TipoConcessaoValeTransporte
     */
    public function setDescricao($descricao)
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
     * Add BeneficioConcessaoValeTransporte
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporte $fkBeneficioConcessaoValeTransporte
     * @return TipoConcessaoValeTransporte
     */
    public function addFkBeneficioConcessaoValeTransportes(\Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporte $fkBeneficioConcessaoValeTransporte)
    {
        if (false === $this->fkBeneficioConcessaoValeTransportes->contains($fkBeneficioConcessaoValeTransporte)) {
            $fkBeneficioConcessaoValeTransporte->setFkBeneficioTipoConcessaoValeTransporte($this);
            $this->fkBeneficioConcessaoValeTransportes->add($fkBeneficioConcessaoValeTransporte);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove BeneficioConcessaoValeTransporte
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporte $fkBeneficioConcessaoValeTransporte
     */
    public function removeFkBeneficioConcessaoValeTransportes(\Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporte $fkBeneficioConcessaoValeTransporte)
    {
        $this->fkBeneficioConcessaoValeTransportes->removeElement($fkBeneficioConcessaoValeTransporte);
    }

    /**
     * OneToMany (owning side)
     * Get fkBeneficioConcessaoValeTransportes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporte
     */
    public function getFkBeneficioConcessaoValeTransportes()
    {
        return $this->fkBeneficioConcessaoValeTransportes;
    }
}
