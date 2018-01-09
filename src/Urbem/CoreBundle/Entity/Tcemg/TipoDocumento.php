<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\PagamentoTipoDocumento
     */
    private $fkTcemgPagamentoTipoDocumentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcemgPagamentoTipoDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add TcemgPagamentoTipoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\PagamentoTipoDocumento $fkTcemgPagamentoTipoDocumento
     * @return TipoDocumento
     */
    public function addFkTcemgPagamentoTipoDocumentos(\Urbem\CoreBundle\Entity\Tcemg\PagamentoTipoDocumento $fkTcemgPagamentoTipoDocumento)
    {
        if (false === $this->fkTcemgPagamentoTipoDocumentos->contains($fkTcemgPagamentoTipoDocumento)) {
            $fkTcemgPagamentoTipoDocumento->setFkTcemgTipoDocumento($this);
            $this->fkTcemgPagamentoTipoDocumentos->add($fkTcemgPagamentoTipoDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgPagamentoTipoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\PagamentoTipoDocumento $fkTcemgPagamentoTipoDocumento
     */
    public function removeFkTcemgPagamentoTipoDocumentos(\Urbem\CoreBundle\Entity\Tcemg\PagamentoTipoDocumento $fkTcemgPagamentoTipoDocumento)
    {
        $this->fkTcemgPagamentoTipoDocumentos->removeElement($fkTcemgPagamentoTipoDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgPagamentoTipoDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\PagamentoTipoDocumento
     */
    public function getFkTcemgPagamentoTipoDocumentos()
    {
        return $this->fkTcemgPagamentoTipoDocumentos;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->codTipo, $this->descricao);
    }
}
