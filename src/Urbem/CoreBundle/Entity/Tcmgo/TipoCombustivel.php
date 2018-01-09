<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * TipoCombustivel
 */
class TipoCombustivel
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\Combustivel
     */
    private $fkTcmgoCombustiveis;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmgoCombustiveis = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoCombustivel
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
     * @return TipoCombustivel
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
     * Add TcmgoCombustivel
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\Combustivel $fkTcmgoCombustivel
     * @return TipoCombustivel
     */
    public function addFkTcmgoCombustiveis(\Urbem\CoreBundle\Entity\Tcmgo\Combustivel $fkTcmgoCombustivel)
    {
        if (false === $this->fkTcmgoCombustiveis->contains($fkTcmgoCombustivel)) {
            $fkTcmgoCombustivel->setFkTcmgoTipoCombustivel($this);
            $this->fkTcmgoCombustiveis->add($fkTcmgoCombustivel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoCombustivel
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\Combustivel $fkTcmgoCombustivel
     */
    public function removeFkTcmgoCombustiveis(\Urbem\CoreBundle\Entity\Tcmgo\Combustivel $fkTcmgoCombustivel)
    {
        $this->fkTcmgoCombustiveis->removeElement($fkTcmgoCombustivel);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoCombustiveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\Combustivel
     */
    public function getFkTcmgoCombustiveis()
    {
        return $this->fkTcmgoCombustiveis;
    }
}
