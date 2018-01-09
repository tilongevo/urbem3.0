<?php
 
namespace Urbem\CoreBundle\Entity\Tceal;

/**
 * PagamentoCodigoTipoDocumento
 */
class PagamentoCodigoTipoDocumento
{
    /**
     * PK
     * @var integer
     */
    private $codTipoDocumento;

    /**
     * @var string
     */
    private $nomTipoDocumento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceal\PagamentoTipoDocumento
     */
    private $fkTcealPagamentoTipoDocumentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcealPagamentoTipoDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoDocumento
     *
     * @param integer $codTipoDocumento
     * @return PagamentoCodigoTipoDocumento
     */
    public function setCodTipoDocumento($codTipoDocumento)
    {
        $this->codTipoDocumento = $codTipoDocumento;
        return $this;
    }

    /**
     * Get codTipoDocumento
     *
     * @return integer
     */
    public function getCodTipoDocumento()
    {
        return $this->codTipoDocumento;
    }

    /**
     * Set nomTipoDocumento
     *
     * @param string $nomTipoDocumento
     * @return PagamentoCodigoTipoDocumento
     */
    public function setNomTipoDocumento($nomTipoDocumento)
    {
        $this->nomTipoDocumento = $nomTipoDocumento;
        return $this;
    }

    /**
     * Get nomTipoDocumento
     *
     * @return string
     */
    public function getNomTipoDocumento()
    {
        return $this->nomTipoDocumento;
    }

    /**
     * OneToMany (owning side)
     * Add TcealPagamentoTipoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\PagamentoTipoDocumento $fkTcealPagamentoTipoDocumento
     * @return PagamentoCodigoTipoDocumento
     */
    public function addFkTcealPagamentoTipoDocumentos(\Urbem\CoreBundle\Entity\Tceal\PagamentoTipoDocumento $fkTcealPagamentoTipoDocumento)
    {
        if (false === $this->fkTcealPagamentoTipoDocumentos->contains($fkTcealPagamentoTipoDocumento)) {
            $fkTcealPagamentoTipoDocumento->setFkTcealPagamentoCodigoTipoDocumento($this);
            $this->fkTcealPagamentoTipoDocumentos->add($fkTcealPagamentoTipoDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcealPagamentoTipoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\PagamentoTipoDocumento $fkTcealPagamentoTipoDocumento
     */
    public function removeFkTcealPagamentoTipoDocumentos(\Urbem\CoreBundle\Entity\Tceal\PagamentoTipoDocumento $fkTcealPagamentoTipoDocumento)
    {
        $this->fkTcealPagamentoTipoDocumentos->removeElement($fkTcealPagamentoTipoDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcealPagamentoTipoDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceal\PagamentoTipoDocumento
     */
    public function getFkTcealPagamentoTipoDocumentos()
    {
        return $this->fkTcealPagamentoTipoDocumentos;
    }
}
