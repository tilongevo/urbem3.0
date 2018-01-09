<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * Categoria
 */
class Categoria
{
    /**
     * PK
     * @var integer
     */
    private $codCategoria;

    /**
     * @var string
     */
    private $nomCategoria;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaDireito
     */
    private $fkEconomicoCadastroEconomicoEmpresaDireitos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoCadastroEconomicoEmpresaDireitos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codCategoria
     *
     * @param integer $codCategoria
     * @return Categoria
     */
    public function setCodCategoria($codCategoria)
    {
        $this->codCategoria = $codCategoria;
        return $this;
    }

    /**
     * Get codCategoria
     *
     * @return integer
     */
    public function getCodCategoria()
    {
        return $this->codCategoria;
    }

    /**
     * Set nomCategoria
     *
     * @param string $nomCategoria
     * @return Categoria
     */
    public function setNomCategoria($nomCategoria)
    {
        $this->nomCategoria = $nomCategoria;
        return $this;
    }

    /**
     * Get nomCategoria
     *
     * @return string
     */
    public function getNomCategoria()
    {
        return $this->nomCategoria;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoCadastroEconomicoEmpresaDireito
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaDireito $fkEconomicoCadastroEconomicoEmpresaDireito
     * @return Categoria
     */
    public function addFkEconomicoCadastroEconomicoEmpresaDireitos(\Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaDireito $fkEconomicoCadastroEconomicoEmpresaDireito)
    {
        if (false === $this->fkEconomicoCadastroEconomicoEmpresaDireitos->contains($fkEconomicoCadastroEconomicoEmpresaDireito)) {
            $fkEconomicoCadastroEconomicoEmpresaDireito->setFkEconomicoCategoria($this);
            $this->fkEconomicoCadastroEconomicoEmpresaDireitos->add($fkEconomicoCadastroEconomicoEmpresaDireito);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoCadastroEconomicoEmpresaDireito
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaDireito $fkEconomicoCadastroEconomicoEmpresaDireito
     */
    public function removeFkEconomicoCadastroEconomicoEmpresaDireitos(\Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaDireito $fkEconomicoCadastroEconomicoEmpresaDireito)
    {
        $this->fkEconomicoCadastroEconomicoEmpresaDireitos->removeElement($fkEconomicoCadastroEconomicoEmpresaDireito);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoCadastroEconomicoEmpresaDireitos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaDireito
     */
    public function getFkEconomicoCadastroEconomicoEmpresaDireitos()
    {
        return $this->fkEconomicoCadastroEconomicoEmpresaDireitos;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) ($this->nomCategoria ? $this->nomCategoria : $this->codCategoria);
    }
}
