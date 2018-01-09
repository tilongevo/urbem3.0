<?php
 
namespace Urbem\CoreBundle\Entity\Frota;

/**
 * Combustivel
 */
class Combustivel
{
    /**
     * PK
     * @var integer
     */
    private $codCombustivel;

    /**
     * @var string
     */
    private $nomCombustivel;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\CombustivelItem
     */
    private $fkFrotaCombustivelItens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\VeiculoCombustivel
     */
    private $fkFrotaVeiculoCombustiveis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\TipoCombustivelVinculo
     */
    private $fkTcmbaTipoCombustivelVinculos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Abastecimento
     */
    private $fkFrotaAbastecimentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFrotaCombustivelItens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaVeiculoCombustiveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmbaTipoCombustivelVinculos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaAbastecimentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codCombustivel
     *
     * @param integer $codCombustivel
     * @return Combustivel
     */
    public function setCodCombustivel($codCombustivel)
    {
        $this->codCombustivel = $codCombustivel;
        return $this;
    }

    /**
     * Get codCombustivel
     *
     * @return integer
     */
    public function getCodCombustivel()
    {
        return $this->codCombustivel;
    }

    /**
     * Set nomCombustivel
     *
     * @param string $nomCombustivel
     * @return Combustivel
     */
    public function setNomCombustivel($nomCombustivel)
    {
        $this->nomCombustivel = $nomCombustivel;
        return $this;
    }

    /**
     * Get nomCombustivel
     *
     * @return string
     */
    public function getNomCombustivel()
    {
        return $this->nomCombustivel;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaCombustivelItem
     *
     * @param \Urbem\CoreBundle\Entity\Frota\CombustivelItem $fkFrotaCombustivelItem
     * @return Combustivel
     */
    public function addFkFrotaCombustivelItens(\Urbem\CoreBundle\Entity\Frota\CombustivelItem $fkFrotaCombustivelItem)
    {
        if (false === $this->fkFrotaCombustivelItens->contains($fkFrotaCombustivelItem)) {
            $fkFrotaCombustivelItem->setFkFrotaCombustivel($this);
            $this->fkFrotaCombustivelItens->add($fkFrotaCombustivelItem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaCombustivelItem
     *
     * @param \Urbem\CoreBundle\Entity\Frota\CombustivelItem $fkFrotaCombustivelItem
     */
    public function removeFkFrotaCombustivelItens(\Urbem\CoreBundle\Entity\Frota\CombustivelItem $fkFrotaCombustivelItem)
    {
        $this->fkFrotaCombustivelItens->removeElement($fkFrotaCombustivelItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaCombustivelItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\CombustivelItem
     */
    public function getFkFrotaCombustivelItens()
    {
        return $this->fkFrotaCombustivelItens;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaVeiculoCombustivel
     *
     * @param \Urbem\CoreBundle\Entity\Frota\VeiculoCombustivel $fkFrotaVeiculoCombustivel
     * @return Combustivel
     */
    public function addFkFrotaVeiculoCombustiveis(\Urbem\CoreBundle\Entity\Frota\VeiculoCombustivel $fkFrotaVeiculoCombustivel)
    {
        if (false === $this->fkFrotaVeiculoCombustiveis->contains($fkFrotaVeiculoCombustivel)) {
            $fkFrotaVeiculoCombustivel->setFkFrotaCombustivel($this);
            $this->fkFrotaVeiculoCombustiveis->add($fkFrotaVeiculoCombustivel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaVeiculoCombustivel
     *
     * @param \Urbem\CoreBundle\Entity\Frota\VeiculoCombustivel $fkFrotaVeiculoCombustivel
     */
    public function removeFkFrotaVeiculoCombustiveis(\Urbem\CoreBundle\Entity\Frota\VeiculoCombustivel $fkFrotaVeiculoCombustivel)
    {
        $this->fkFrotaVeiculoCombustiveis->removeElement($fkFrotaVeiculoCombustivel);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaVeiculoCombustiveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\VeiculoCombustivel
     */
    public function getFkFrotaVeiculoCombustiveis()
    {
        return $this->fkFrotaVeiculoCombustiveis;
    }

    /**
     * OneToMany (owning side)
     * Add TcmbaTipoCombustivelVinculo
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\TipoCombustivelVinculo $fkTcmbaTipoCombustivelVinculo
     * @return Combustivel
     */
    public function addFkTcmbaTipoCombustivelVinculos(\Urbem\CoreBundle\Entity\Tcmba\TipoCombustivelVinculo $fkTcmbaTipoCombustivelVinculo)
    {
        if (false === $this->fkTcmbaTipoCombustivelVinculos->contains($fkTcmbaTipoCombustivelVinculo)) {
            $fkTcmbaTipoCombustivelVinculo->setFkFrotaCombustivel($this);
            $this->fkTcmbaTipoCombustivelVinculos->add($fkTcmbaTipoCombustivelVinculo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaTipoCombustivelVinculo
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\TipoCombustivelVinculo $fkTcmbaTipoCombustivelVinculo
     */
    public function removeFkTcmbaTipoCombustivelVinculos(\Urbem\CoreBundle\Entity\Tcmba\TipoCombustivelVinculo $fkTcmbaTipoCombustivelVinculo)
    {
        $this->fkTcmbaTipoCombustivelVinculos->removeElement($fkTcmbaTipoCombustivelVinculo);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaTipoCombustivelVinculos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\TipoCombustivelVinculo
     */
    public function getFkTcmbaTipoCombustivelVinculos()
    {
        return $this->fkTcmbaTipoCombustivelVinculos;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaAbastecimento
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Abastecimento $fkFrotaAbastecimento
     * @return Combustivel
     */
    public function addFkFrotaAbastecimentos(\Urbem\CoreBundle\Entity\Frota\Abastecimento $fkFrotaAbastecimento)
    {
        if (false === $this->fkFrotaAbastecimentos->contains($fkFrotaAbastecimento)) {
            $fkFrotaAbastecimento->setFkFrotaCombustivel($this);
            $this->fkFrotaAbastecimentos->add($fkFrotaAbastecimento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaAbastecimento
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Abastecimento $fkFrotaAbastecimento
     */
    public function removeFkFrotaAbastecimentos(\Urbem\CoreBundle\Entity\Frota\Abastecimento $fkFrotaAbastecimento)
    {
        $this->fkFrotaAbastecimentos->removeElement($fkFrotaAbastecimento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaAbastecimentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Abastecimento
     */
    public function getFkFrotaAbastecimentos()
    {
        return $this->fkFrotaAbastecimentos;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->codCombustivel.' - '.$this->nomCombustivel;
    }
}
