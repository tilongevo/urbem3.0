<?php
 
namespace Urbem\CoreBundle\Entity\Beneficio;

/**
 * ValeTransporte
 */
class ValeTransporte
{
    /**
     * PK
     * @var integer
     */
    private $codValeTransporte;

    /**
     * @var integer
     */
    private $fornecedorValeTransporteFornecedorNumcgm;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Beneficio\Itinerario
     */
    private $fkBeneficioItinerario;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporte
     */
    private $fkBeneficioConcessaoValeTransportes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\Custo
     */
    private $fkBeneficioCustos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\Fornecedor
     */
    private $fkComprasFornecedor;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkBeneficioConcessaoValeTransportes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkBeneficioCustos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codValeTransporte
     *
     * @param integer $codValeTransporte
     * @return ValeTransporte
     */
    public function setCodValeTransporte($codValeTransporte)
    {
        $this->codValeTransporte = $codValeTransporte;
        return $this;
    }

    /**
     * Get codValeTransporte
     *
     * @return integer
     */
    public function getCodValeTransporte()
    {
        return $this->codValeTransporte;
    }

    /**
     * Set fornecedorValeTransporteFornecedorNumcgm
     *
     * @param integer $fornecedorValeTransporteFornecedorNumcgm
     * @return ValeTransporte
     */
    public function setFornecedorValeTransporteFornecedorNumcgm($fornecedorValeTransporteFornecedorNumcgm)
    {
        $this->fornecedorValeTransporteFornecedorNumcgm = $fornecedorValeTransporteFornecedorNumcgm;
        return $this;
    }

    /**
     * Get fornecedorValeTransporteFornecedorNumcgm
     *
     * @return integer
     */
    public function getFornecedorValeTransporteFornecedorNumcgm()
    {
        return $this->fornecedorValeTransporteFornecedorNumcgm;
    }

    /**
     * OneToMany (owning side)
     * Add BeneficioConcessaoValeTransporte
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporte $fkBeneficioConcessaoValeTransporte
     * @return ValeTransporte
     */
    public function addFkBeneficioConcessaoValeTransportes(\Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporte $fkBeneficioConcessaoValeTransporte)
    {
        if (false === $this->fkBeneficioConcessaoValeTransportes->contains($fkBeneficioConcessaoValeTransporte)) {
            $fkBeneficioConcessaoValeTransporte->setFkBeneficioValeTransporte($this);
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

    /**
     * OneToMany (owning side)
     * Add BeneficioCusto
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\Custo $fkBeneficioCusto
     * @return ValeTransporte
     */
    public function addFkBeneficioCustos(\Urbem\CoreBundle\Entity\Beneficio\Custo $fkBeneficioCusto)
    {
        if (false === $this->fkBeneficioCustos->contains($fkBeneficioCusto)) {
            $fkBeneficioCusto->setFkBeneficioValeTransporte($this);
            $this->fkBeneficioCustos->add($fkBeneficioCusto);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove BeneficioCusto
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\Custo $fkBeneficioCusto
     */
    public function removeFkBeneficioCustos(\Urbem\CoreBundle\Entity\Beneficio\Custo $fkBeneficioCusto)
    {
        $this->fkBeneficioCustos->removeElement($fkBeneficioCusto);
    }

    /**
     * OneToMany (owning side)
     * Get fkBeneficioCustos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\Custo
     */
    public function getFkBeneficioCustos()
    {
        return $this->fkBeneficioCustos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasFornecedor
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Fornecedor $fkComprasFornecedor
     * @return ValeTransporte
     */
    public function setFkComprasFornecedor(\Urbem\CoreBundle\Entity\Compras\Fornecedor $fkComprasFornecedor)
    {
        $this->fornecedorValeTransporteFornecedorNumcgm = $fkComprasFornecedor->getCgmFornecedor();
        $this->fkComprasFornecedor = $fkComprasFornecedor;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasFornecedor
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Fornecedor
     */
    public function getFkComprasFornecedor()
    {
        return $this->fkComprasFornecedor;
    }

    /**
     * OneToOne (inverse side)
     * Set BeneficioItinerario
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\Itinerario|null $fkBeneficioItinerario
     * @return ValeTransporte
     */
    public function setFkBeneficioItinerario(\Urbem\CoreBundle\Entity\Beneficio\Itinerario $fkBeneficioItinerario = null)
    {
        if (false == is_null($fkBeneficioItinerario)) {
            $fkBeneficioItinerario->setFkBeneficioValeTransporte($this);
        }
        
        $this->fkBeneficioItinerario = $fkBeneficioItinerario;

        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkBeneficioItinerario
     *
     * @return \Urbem\CoreBundle\Entity\Beneficio\Itinerario
     */
    public function getFkBeneficioItinerario()
    {
        return $this->fkBeneficioItinerario;
    }
    
    public function getOrigem()
    {
        return $this->getFkBeneficioItinerario()->getFkSwMunicipio1()->getNomMunicipio()
        . "/"
        . $this->getFkBeneficioItinerario()->getFkBeneficioLinha1()->getDescricao();
    }
    
    public function getDestino()
    {
        return $this->getFkBeneficioItinerario()->getFkSwMunicipio()->getNomMunicipio()
        . "/"
        . $this->getFkBeneficioItinerario()->getFkBeneficioLinha()->getDescricao();
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->getFkComprasFornecedor()) {
            return (string) $this->getFkComprasFornecedor()->getFkSwCgm()->getNumcgm();
        }
        return "";
    }
}
