<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\DocumentoDePara
     */
    private $fkTcmgoDocumentoDeParas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmgoDocumentoDeParas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add TcmgoDocumentoDePara
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\DocumentoDePara $fkTcmgoDocumentoDePara
     * @return TipoDocumentoTcm
     */
    public function addFkTcmgoDocumentoDeParas(\Urbem\CoreBundle\Entity\Tcmgo\DocumentoDePara $fkTcmgoDocumentoDePara)
    {
        if (false === $this->fkTcmgoDocumentoDeParas->contains($fkTcmgoDocumentoDePara)) {
            $fkTcmgoDocumentoDePara->setFkTcmgoTipoDocumentoTcm($this);
            $this->fkTcmgoDocumentoDeParas->add($fkTcmgoDocumentoDePara);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoDocumentoDePara
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\DocumentoDePara $fkTcmgoDocumentoDePara
     */
    public function removeFkTcmgoDocumentoDeParas(\Urbem\CoreBundle\Entity\Tcmgo\DocumentoDePara $fkTcmgoDocumentoDePara)
    {
        $this->fkTcmgoDocumentoDeParas->removeElement($fkTcmgoDocumentoDePara);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoDocumentoDeParas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\DocumentoDePara
     */
    public function getFkTcmgoDocumentoDeParas()
    {
        return $this->fkTcmgoDocumentoDeParas;
    }
}
