<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * TipoDocumentoPagamento
 */
class TipoDocumentoPagamento
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\PagamentoTipoDocumentoPagamento
     */
    private $fkTcmbaPagamentoTipoDocumentoPagamentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmbaPagamentoTipoDocumentoPagamentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoDocumentoPagamento
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
     * @return TipoDocumentoPagamento
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
     * Add TcmbaPagamentoTipoDocumentoPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\PagamentoTipoDocumentoPagamento $fkTcmbaPagamentoTipoDocumentoPagamento
     * @return TipoDocumentoPagamento
     */
    public function addFkTcmbaPagamentoTipoDocumentoPagamentos(\Urbem\CoreBundle\Entity\Tcmba\PagamentoTipoDocumentoPagamento $fkTcmbaPagamentoTipoDocumentoPagamento)
    {
        if (false === $this->fkTcmbaPagamentoTipoDocumentoPagamentos->contains($fkTcmbaPagamentoTipoDocumentoPagamento)) {
            $fkTcmbaPagamentoTipoDocumentoPagamento->setFkTcmbaTipoDocumentoPagamento($this);
            $this->fkTcmbaPagamentoTipoDocumentoPagamentos->add($fkTcmbaPagamentoTipoDocumentoPagamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaPagamentoTipoDocumentoPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\PagamentoTipoDocumentoPagamento $fkTcmbaPagamentoTipoDocumentoPagamento
     */
    public function removeFkTcmbaPagamentoTipoDocumentoPagamentos(\Urbem\CoreBundle\Entity\Tcmba\PagamentoTipoDocumentoPagamento $fkTcmbaPagamentoTipoDocumentoPagamento)
    {
        $this->fkTcmbaPagamentoTipoDocumentoPagamentos->removeElement($fkTcmbaPagamentoTipoDocumentoPagamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaPagamentoTipoDocumentoPagamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\PagamentoTipoDocumentoPagamento
     */
    public function getFkTcmbaPagamentoTipoDocumentoPagamentos()
    {
        return $this->fkTcmbaPagamentoTipoDocumentoPagamentos;
    }
}
