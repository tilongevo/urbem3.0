<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\CombustivelVinculo
     */
    private $fkTcmgoCombustivelVinculos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmgo\TipoCombustivel
     */
    private $fkTcmgoTipoCombustivel;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmgoCombustivelVinculos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return Combustivel
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
     * @return Combustivel
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
     * Add TcmgoCombustivelVinculo
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\CombustivelVinculo $fkTcmgoCombustivelVinculo
     * @return Combustivel
     */
    public function addFkTcmgoCombustivelVinculos(\Urbem\CoreBundle\Entity\Tcmgo\CombustivelVinculo $fkTcmgoCombustivelVinculo)
    {
        if (false === $this->fkTcmgoCombustivelVinculos->contains($fkTcmgoCombustivelVinculo)) {
            $fkTcmgoCombustivelVinculo->setFkTcmgoCombustivel($this);
            $this->fkTcmgoCombustivelVinculos->add($fkTcmgoCombustivelVinculo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoCombustivelVinculo
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\CombustivelVinculo $fkTcmgoCombustivelVinculo
     */
    public function removeFkTcmgoCombustivelVinculos(\Urbem\CoreBundle\Entity\Tcmgo\CombustivelVinculo $fkTcmgoCombustivelVinculo)
    {
        $this->fkTcmgoCombustivelVinculos->removeElement($fkTcmgoCombustivelVinculo);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoCombustivelVinculos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\CombustivelVinculo
     */
    public function getFkTcmgoCombustivelVinculos()
    {
        return $this->fkTcmgoCombustivelVinculos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcmgoTipoCombustivel
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\TipoCombustivel $fkTcmgoTipoCombustivel
     * @return Combustivel
     */
    public function setFkTcmgoTipoCombustivel(\Urbem\CoreBundle\Entity\Tcmgo\TipoCombustivel $fkTcmgoTipoCombustivel)
    {
        $this->codTipo = $fkTcmgoTipoCombustivel->getCodTipo();
        $this->fkTcmgoTipoCombustivel = $fkTcmgoTipoCombustivel;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmgoTipoCombustivel
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\TipoCombustivel
     */
    public function getFkTcmgoTipoCombustivel()
    {
        return $this->fkTcmgoTipoCombustivel;
    }
}
