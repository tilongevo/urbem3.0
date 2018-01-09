<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * TipoDocumentoTcm
 */
class TipoDocumentoTcm
{
    /**
     * PK
     * @var integer
     */
    private $codDocumentoTcm;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\DocumentoDePara
     */
    private $fkTcmbaDocumentoDeParas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmbaDocumentoDeParas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codDocumentoTcm
     *
     * @param integer $codDocumentoTcm
     * @return TipoDocumentoTcm
     */
    public function setCodDocumentoTcm($codDocumentoTcm)
    {
        $this->codDocumentoTcm = $codDocumentoTcm;
        return $this;
    }

    /**
     * Get codDocumentoTcm
     *
     * @return integer
     */
    public function getCodDocumentoTcm()
    {
        return $this->codDocumentoTcm;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoDocumentoTcm
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
     * Add TcmbaDocumentoDePara
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\DocumentoDePara $fkTcmbaDocumentoDePara
     * @return TipoDocumentoTcm
     */
    public function addFkTcmbaDocumentoDeParas(\Urbem\CoreBundle\Entity\Tcmba\DocumentoDePara $fkTcmbaDocumentoDePara)
    {
        if (false === $this->fkTcmbaDocumentoDeParas->contains($fkTcmbaDocumentoDePara)) {
            $fkTcmbaDocumentoDePara->setFkTcmbaTipoDocumentoTcm($this);
            $this->fkTcmbaDocumentoDeParas->add($fkTcmbaDocumentoDePara);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaDocumentoDePara
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\DocumentoDePara $fkTcmbaDocumentoDePara
     */
    public function removeFkTcmbaDocumentoDeParas(\Urbem\CoreBundle\Entity\Tcmba\DocumentoDePara $fkTcmbaDocumentoDePara)
    {
        $this->fkTcmbaDocumentoDeParas->removeElement($fkTcmbaDocumentoDePara);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaDocumentoDeParas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\DocumentoDePara
     */
    public function getFkTcmbaDocumentoDeParas()
    {
        return $this->fkTcmbaDocumentoDeParas;
    }
}
