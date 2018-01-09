<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * TipoBaixa
 */
class TipoBaixa
{
    const TIPO_BAIXA_BAIXA = 1;
    const TIPO_BAIXA_SUSPENSAO = 2;
    const TIPO_BAIXA_CASSACAO = 3;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaBaixa
     */
    private $fkImobiliarioLicencaBaixas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImobiliarioLicencaBaixas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoBaixa
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
     * @return TipoBaixa
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
     * Add ImobiliarioLicencaBaixa
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaBaixa $fkImobiliarioLicencaBaixa
     * @return TipoBaixa
     */
    public function addFkImobiliarioLicencaBaixas(\Urbem\CoreBundle\Entity\Imobiliario\LicencaBaixa $fkImobiliarioLicencaBaixa)
    {
        if (false === $this->fkImobiliarioLicencaBaixas->contains($fkImobiliarioLicencaBaixa)) {
            $fkImobiliarioLicencaBaixa->setFkImobiliarioTipoBaixa($this);
            $this->fkImobiliarioLicencaBaixas->add($fkImobiliarioLicencaBaixa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioLicencaBaixa
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaBaixa $fkImobiliarioLicencaBaixa
     */
    public function removeFkImobiliarioLicencaBaixas(\Urbem\CoreBundle\Entity\Imobiliario\LicencaBaixa $fkImobiliarioLicencaBaixa)
    {
        $this->fkImobiliarioLicencaBaixas->removeElement($fkImobiliarioLicencaBaixa);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioLicencaBaixas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaBaixa
     */
    public function getFkImobiliarioLicencaBaixas()
    {
        return $this->fkImobiliarioLicencaBaixas;
    }
}
