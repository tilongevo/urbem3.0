<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * TipoLancamento
 */
class TipoLancamento
{
    /**
     * PK
     * @var integer
     */
    private $codLancamento;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\DividaConsolidada
     */
    private $fkTcmgoDividaConsolidadas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmgoDividaConsolidadas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codLancamento
     *
     * @param integer $codLancamento
     * @return TipoLancamento
     */
    public function setCodLancamento($codLancamento)
    {
        $this->codLancamento = $codLancamento;
        return $this;
    }

    /**
     * Get codLancamento
     *
     * @return integer
     */
    public function getCodLancamento()
    {
        return $this->codLancamento;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoLancamento
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
     * Add TcmgoDividaConsolidada
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\DividaConsolidada $fkTcmgoDividaConsolidada
     * @return TipoLancamento
     */
    public function addFkTcmgoDividaConsolidadas(\Urbem\CoreBundle\Entity\Tcmgo\DividaConsolidada $fkTcmgoDividaConsolidada)
    {
        if (false === $this->fkTcmgoDividaConsolidadas->contains($fkTcmgoDividaConsolidada)) {
            $fkTcmgoDividaConsolidada->setFkTcmgoTipoLancamento($this);
            $this->fkTcmgoDividaConsolidadas->add($fkTcmgoDividaConsolidada);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoDividaConsolidada
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\DividaConsolidada $fkTcmgoDividaConsolidada
     */
    public function removeFkTcmgoDividaConsolidadas(\Urbem\CoreBundle\Entity\Tcmgo\DividaConsolidada $fkTcmgoDividaConsolidada)
    {
        $this->fkTcmgoDividaConsolidadas->removeElement($fkTcmgoDividaConsolidada);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoDividaConsolidadas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\DividaConsolidada
     */
    public function getFkTcmgoDividaConsolidadas()
    {
        return $this->fkTcmgoDividaConsolidadas;
    }
}
