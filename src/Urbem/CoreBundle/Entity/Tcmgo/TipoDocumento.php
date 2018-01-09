<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * TipoDocumento
 */
class TipoDocumento
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\PagamentoTipoDocumento
     */
    private $fkTesourariaPagamentoTipoDocumentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTesourariaPagamentoTipoDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoDocumento
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
     * @return TipoDocumento
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
     * Add TesourariaPagamentoTipoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\PagamentoTipoDocumento $fkTesourariaPagamentoTipoDocumento
     * @return TipoDocumento
     */
    public function addFkTesourariaPagamentoTipoDocumentos(\Urbem\CoreBundle\Entity\Tesouraria\PagamentoTipoDocumento $fkTesourariaPagamentoTipoDocumento)
    {
        if (false === $this->fkTesourariaPagamentoTipoDocumentos->contains($fkTesourariaPagamentoTipoDocumento)) {
            $fkTesourariaPagamentoTipoDocumento->setFkTcmgoTipoDocumento($this);
            $this->fkTesourariaPagamentoTipoDocumentos->add($fkTesourariaPagamentoTipoDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaPagamentoTipoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\PagamentoTipoDocumento $fkTesourariaPagamentoTipoDocumento
     */
    public function removeFkTesourariaPagamentoTipoDocumentos(\Urbem\CoreBundle\Entity\Tesouraria\PagamentoTipoDocumento $fkTesourariaPagamentoTipoDocumento)
    {
        $this->fkTesourariaPagamentoTipoDocumentos->removeElement($fkTesourariaPagamentoTipoDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaPagamentoTipoDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\PagamentoTipoDocumento
     */
    public function getFkTesourariaPagamentoTipoDocumentos()
    {
        return $this->fkTesourariaPagamentoTipoDocumentos;
    }
}
