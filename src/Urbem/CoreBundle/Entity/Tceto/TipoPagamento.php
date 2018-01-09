<?php
 
namespace Urbem\CoreBundle\Entity\Tceto;

/**
 * TipoPagamento
 */
class TipoPagamento
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceto\TransferenciaTipoPagamento
     */
    private $fkTcetoTransferenciaTipoPagamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceto\PagamentoTipoPagamento
     */
    private $fkTcetoPagamentoTipoPagamentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcetoTransferenciaTipoPagamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcetoPagamentoTipoPagamentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoPagamento
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
     * @return TipoPagamento
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
     * Add TcetoTransferenciaTipoPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\TransferenciaTipoPagamento $fkTcetoTransferenciaTipoPagamento
     * @return TipoPagamento
     */
    public function addFkTcetoTransferenciaTipoPagamentos(\Urbem\CoreBundle\Entity\Tceto\TransferenciaTipoPagamento $fkTcetoTransferenciaTipoPagamento)
    {
        if (false === $this->fkTcetoTransferenciaTipoPagamentos->contains($fkTcetoTransferenciaTipoPagamento)) {
            $fkTcetoTransferenciaTipoPagamento->setFkTcetoTipoPagamento($this);
            $this->fkTcetoTransferenciaTipoPagamentos->add($fkTcetoTransferenciaTipoPagamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcetoTransferenciaTipoPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\TransferenciaTipoPagamento $fkTcetoTransferenciaTipoPagamento
     */
    public function removeFkTcetoTransferenciaTipoPagamentos(\Urbem\CoreBundle\Entity\Tceto\TransferenciaTipoPagamento $fkTcetoTransferenciaTipoPagamento)
    {
        $this->fkTcetoTransferenciaTipoPagamentos->removeElement($fkTcetoTransferenciaTipoPagamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcetoTransferenciaTipoPagamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceto\TransferenciaTipoPagamento
     */
    public function getFkTcetoTransferenciaTipoPagamentos()
    {
        return $this->fkTcetoTransferenciaTipoPagamentos;
    }

    /**
     * OneToMany (owning side)
     * Add TcetoPagamentoTipoPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\PagamentoTipoPagamento $fkTcetoPagamentoTipoPagamento
     * @return TipoPagamento
     */
    public function addFkTcetoPagamentoTipoPagamentos(\Urbem\CoreBundle\Entity\Tceto\PagamentoTipoPagamento $fkTcetoPagamentoTipoPagamento)
    {
        if (false === $this->fkTcetoPagamentoTipoPagamentos->contains($fkTcetoPagamentoTipoPagamento)) {
            $fkTcetoPagamentoTipoPagamento->setFkTcetoTipoPagamento($this);
            $this->fkTcetoPagamentoTipoPagamentos->add($fkTcetoPagamentoTipoPagamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcetoPagamentoTipoPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\PagamentoTipoPagamento $fkTcetoPagamentoTipoPagamento
     */
    public function removeFkTcetoPagamentoTipoPagamentos(\Urbem\CoreBundle\Entity\Tceto\PagamentoTipoPagamento $fkTcetoPagamentoTipoPagamento)
    {
        $this->fkTcetoPagamentoTipoPagamentos->removeElement($fkTcetoPagamentoTipoPagamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcetoPagamentoTipoPagamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceto\PagamentoTipoPagamento
     */
    public function getFkTcetoPagamentoTipoPagamentos()
    {
        return $this->fkTcetoPagamentoTipoPagamentos;
    }
}
