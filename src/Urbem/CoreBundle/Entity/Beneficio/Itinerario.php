<?php
 
namespace Urbem\CoreBundle\Entity\Beneficio;

/**
 * Itinerario
 */
class Itinerario
{
    /**
     * PK
     * @var integer
     */
    private $valeTransporteCodValeTransporte;

    /**
     * @var integer
     */
    private $codLinhaDestino;

    /**
     * @var integer
     */
    private $codLinhaOrigem;

    /**
     * @var integer
     */
    private $municipioDestino;

    /**
     * @var integer
     */
    private $ufDestino;

    /**
     * @var integer
     */
    private $municipioOrigem;

    /**
     * @var integer
     */
    private $ufOrigem;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Beneficio\ValeTransporte
     */
    private $fkBeneficioValeTransporte;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Beneficio\Linha
     */
    private $fkBeneficioLinha;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwMunicipio
     */
    private $fkSwMunicipio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Beneficio\Linha
     */
    private $fkBeneficioLinha1;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwMunicipio
     */
    private $fkSwMunicipio1;


    /**
     * Set valeTransporteCodValeTransporte
     *
     * @param integer $valeTransporteCodValeTransporte
     * @return Itinerario
     */
    public function setValeTransporteCodValeTransporte($valeTransporteCodValeTransporte)
    {
        $this->valeTransporteCodValeTransporte = $valeTransporteCodValeTransporte;
        return $this;
    }

    /**
     * Get valeTransporteCodValeTransporte
     *
     * @return integer
     */
    public function getValeTransporteCodValeTransporte()
    {
        return $this->valeTransporteCodValeTransporte;
    }

    /**
     * Set codLinhaDestino
     *
     * @param integer $codLinhaDestino
     * @return Itinerario
     */
    public function setCodLinhaDestino($codLinhaDestino)
    {
        $this->codLinhaDestino = $codLinhaDestino;
        return $this;
    }

    /**
     * Get codLinhaDestino
     *
     * @return integer
     */
    public function getCodLinhaDestino()
    {
        return $this->codLinhaDestino;
    }

    /**
     * Set codLinhaOrigem
     *
     * @param integer $codLinhaOrigem
     * @return Itinerario
     */
    public function setCodLinhaOrigem($codLinhaOrigem)
    {
        $this->codLinhaOrigem = $codLinhaOrigem;
        return $this;
    }

    /**
     * Get codLinhaOrigem
     *
     * @return integer
     */
    public function getCodLinhaOrigem()
    {
        return $this->codLinhaOrigem;
    }

    /**
     * Set municipioDestino
     *
     * @param integer $municipioDestino
     * @return Itinerario
     */
    public function setMunicipioDestino($municipioDestino)
    {
        $this->municipioDestino = $municipioDestino;
        return $this;
    }

    /**
     * Get municipioDestino
     *
     * @return integer
     */
    public function getMunicipioDestino()
    {
        return $this->municipioDestino;
    }

    /**
     * Set ufDestino
     *
     * @param integer $ufDestino
     * @return Itinerario
     */
    public function setUfDestino($ufDestino)
    {
        $this->ufDestino = $ufDestino;
        return $this;
    }

    /**
     * Get ufDestino
     *
     * @return integer
     */
    public function getUfDestino()
    {
        return $this->ufDestino;
    }

    /**
     * Set municipioOrigem
     *
     * @param integer $municipioOrigem
     * @return Itinerario
     */
    public function setMunicipioOrigem($municipioOrigem)
    {
        $this->municipioOrigem = $municipioOrigem;
        return $this;
    }

    /**
     * Get municipioOrigem
     *
     * @return integer
     */
    public function getMunicipioOrigem()
    {
        return $this->municipioOrigem;
    }

    /**
     * Set ufOrigem
     *
     * @param integer $ufOrigem
     * @return Itinerario
     */
    public function setUfOrigem($ufOrigem)
    {
        $this->ufOrigem = $ufOrigem;
        return $this;
    }

    /**
     * Get ufOrigem
     *
     * @return integer
     */
    public function getUfOrigem()
    {
        return $this->ufOrigem;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkBeneficioLinha
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\Linha $fkBeneficioLinha
     * @return Itinerario
     */
    public function setFkBeneficioLinha(\Urbem\CoreBundle\Entity\Beneficio\Linha $fkBeneficioLinha)
    {
        $this->codLinhaDestino = $fkBeneficioLinha->getCodLinha();
        $this->fkBeneficioLinha = $fkBeneficioLinha;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkBeneficioLinha
     *
     * @return \Urbem\CoreBundle\Entity\Beneficio\Linha
     */
    public function getFkBeneficioLinha()
    {
        return $this->fkBeneficioLinha;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwMunicipio
     *
     * @param \Urbem\CoreBundle\Entity\SwMunicipio $fkSwMunicipio
     * @return Itinerario
     */
    public function setFkSwMunicipio(\Urbem\CoreBundle\Entity\SwMunicipio $fkSwMunicipio)
    {
        $this->municipioDestino = $fkSwMunicipio->getCodMunicipio();
        $this->ufDestino = $fkSwMunicipio->getCodUf();
        $this->fkSwMunicipio = $fkSwMunicipio;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwMunicipio
     *
     * @return \Urbem\CoreBundle\Entity\SwMunicipio
     */
    public function getFkSwMunicipio()
    {
        return $this->fkSwMunicipio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkBeneficioLinha1
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\Linha $fkBeneficioLinha1
     * @return Itinerario
     */
    public function setFkBeneficioLinha1(\Urbem\CoreBundle\Entity\Beneficio\Linha $fkBeneficioLinha1)
    {
        $this->codLinhaOrigem = $fkBeneficioLinha1->getCodLinha();
        $this->fkBeneficioLinha1 = $fkBeneficioLinha1;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkBeneficioLinha1
     *
     * @return \Urbem\CoreBundle\Entity\Beneficio\Linha
     */
    public function getFkBeneficioLinha1()
    {
        return $this->fkBeneficioLinha1;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwMunicipio1
     *
     * @param \Urbem\CoreBundle\Entity\SwMunicipio $fkSwMunicipio1
     * @return Itinerario
     */
    public function setFkSwMunicipio1(\Urbem\CoreBundle\Entity\SwMunicipio $fkSwMunicipio1)
    {
        $this->municipioOrigem = $fkSwMunicipio1->getCodMunicipio();
        $this->ufOrigem = $fkSwMunicipio1->getCodUf();
        $this->fkSwMunicipio1 = $fkSwMunicipio1;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwMunicipio1
     *
     * @return \Urbem\CoreBundle\Entity\SwMunicipio
     */
    public function getFkSwMunicipio1()
    {
        return $this->fkSwMunicipio1;
    }

    /**
     * OneToOne (owning side)
     * Set BeneficioValeTransporte
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\ValeTransporte $fkBeneficioValeTransporte
     * @return Itinerario
     */
    public function setFkBeneficioValeTransporte(\Urbem\CoreBundle\Entity\Beneficio\ValeTransporte $fkBeneficioValeTransporte)
    {
        $this->valeTransporteCodValeTransporte = $fkBeneficioValeTransporte->getCodValeTransporte();
        $this->fkBeneficioValeTransporte = $fkBeneficioValeTransporte;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkBeneficioValeTransporte
     *
     * @return \Urbem\CoreBundle\Entity\Beneficio\ValeTransporte
     */
    public function getFkBeneficioValeTransporte()
    {
        return $this->fkBeneficioValeTransporte;
    }
}
