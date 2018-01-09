<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * TipoBaixa
 */
class TipoBaixa
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $nomBaixa;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\BaixaLicenca
     */
    private $fkEconomicoBaixaLicencas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoBaixaLicencas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nomBaixa
     *
     * @param string $nomBaixa
     * @return TipoBaixa
     */
    public function setNomBaixa($nomBaixa)
    {
        $this->nomBaixa = $nomBaixa;
        return $this;
    }

    /**
     * Get nomBaixa
     *
     * @return string
     */
    public function getNomBaixa()
    {
        return $this->nomBaixa;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoBaixaLicenca
     *
     * @param \Urbem\CoreBundle\Entity\Economico\BaixaLicenca $fkEconomicoBaixaLicenca
     * @return TipoBaixa
     */
    public function addFkEconomicoBaixaLicencas(\Urbem\CoreBundle\Entity\Economico\BaixaLicenca $fkEconomicoBaixaLicenca)
    {
        if (false === $this->fkEconomicoBaixaLicencas->contains($fkEconomicoBaixaLicenca)) {
            $fkEconomicoBaixaLicenca->setFkEconomicoTipoBaixa($this);
            $this->fkEconomicoBaixaLicencas->add($fkEconomicoBaixaLicenca);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoBaixaLicenca
     *
     * @param \Urbem\CoreBundle\Entity\Economico\BaixaLicenca $fkEconomicoBaixaLicenca
     */
    public function removeFkEconomicoBaixaLicencas(\Urbem\CoreBundle\Entity\Economico\BaixaLicenca $fkEconomicoBaixaLicenca)
    {
        $this->fkEconomicoBaixaLicencas->removeElement($fkEconomicoBaixaLicenca);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoBaixaLicencas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\BaixaLicenca
     */
    public function getFkEconomicoBaixaLicencas()
    {
        return $this->fkEconomicoBaixaLicencas;
    }
}
