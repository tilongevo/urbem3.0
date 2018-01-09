<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * Documento
 */
class Documento
{
    /**
     * PK
     * @var integer
     */
    private $codDocumento;

    /**
     * @var string
     */
    private $nomDocumento;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\CertificacaoDocumentos
     */
    private $fkLicitacaoCertificacaoDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ContratoDocumento
     */
    private $fkLicitacaoContratoDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ModalidadeDocumentos
     */
    private $fkLicitacaoModalidadeDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\DocumentosAtributos
     */
    private $fkLicitacaoDocumentosAtributos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\DeParaDocumento
     */
    private $fkTcemgDeParaDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcesc\TipoCertidaoEsfinge
     */
    private $fkTcescTipoCertidaoEsfinges;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\DocumentoDePara
     */
    private $fkTcmbaDocumentoDeParas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\DocumentoDePara
     */
    private $fkTcmgoDocumentoDeParas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceam\TipoCertidaoDocumento
     */
    private $fkTceamTipoCertidaoDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\LicitacaoDocumentos
     */
    private $fkLicitacaoLicitacaoDocumentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkLicitacaoCertificacaoDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoContratoDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoModalidadeDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoDocumentosAtributos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgDeParaDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcescTipoCertidaoEsfinges = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmbaDocumentoDeParas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoDocumentoDeParas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTceamTipoCertidaoDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoLicitacaoDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return Documento
     */
    public function setCodDocumento($codDocumento)
    {
        $this->codDocumento = $codDocumento;
        return $this;
    }

    /**
     * Get codDocumento
     *
     * @return integer
     */
    public function getCodDocumento()
    {
        return $this->codDocumento;
    }

    /**
     * Set nomDocumento
     *
     * @param string $nomDocumento
     * @return Documento
     */
    public function setNomDocumento($nomDocumento)
    {
        $this->nomDocumento = $nomDocumento;
        return $this;
    }

    /**
     * Get nomDocumento
     *
     * @return string
     */
    public function getNomDocumento()
    {
        return $this->nomDocumento;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return Documento
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoCertificacaoDocumentos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\CertificacaoDocumentos $fkLicitacaoCertificacaoDocumentos
     * @return Documento
     */
    public function addFkLicitacaoCertificacaoDocumentos(\Urbem\CoreBundle\Entity\Licitacao\CertificacaoDocumentos $fkLicitacaoCertificacaoDocumentos)
    {
        if (false === $this->fkLicitacaoCertificacaoDocumentos->contains($fkLicitacaoCertificacaoDocumentos)) {
            $fkLicitacaoCertificacaoDocumentos->setFkLicitacaoDocumento($this);
            $this->fkLicitacaoCertificacaoDocumentos->add($fkLicitacaoCertificacaoDocumentos);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoCertificacaoDocumentos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\CertificacaoDocumentos $fkLicitacaoCertificacaoDocumentos
     */
    public function removeFkLicitacaoCertificacaoDocumentos(\Urbem\CoreBundle\Entity\Licitacao\CertificacaoDocumentos $fkLicitacaoCertificacaoDocumentos)
    {
        $this->fkLicitacaoCertificacaoDocumentos->removeElement($fkLicitacaoCertificacaoDocumentos);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoCertificacaoDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\CertificacaoDocumentos
     */
    public function getFkLicitacaoCertificacaoDocumentos()
    {
        return $this->fkLicitacaoCertificacaoDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoContratoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ContratoDocumento $fkLicitacaoContratoDocumento
     * @return Documento
     */
    public function addFkLicitacaoContratoDocumentos(\Urbem\CoreBundle\Entity\Licitacao\ContratoDocumento $fkLicitacaoContratoDocumento)
    {
        if (false === $this->fkLicitacaoContratoDocumentos->contains($fkLicitacaoContratoDocumento)) {
            $fkLicitacaoContratoDocumento->setFkLicitacaoDocumento($this);
            $this->fkLicitacaoContratoDocumentos->add($fkLicitacaoContratoDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoContratoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ContratoDocumento $fkLicitacaoContratoDocumento
     */
    public function removeFkLicitacaoContratoDocumentos(\Urbem\CoreBundle\Entity\Licitacao\ContratoDocumento $fkLicitacaoContratoDocumento)
    {
        $this->fkLicitacaoContratoDocumentos->removeElement($fkLicitacaoContratoDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoContratoDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ContratoDocumento
     */
    public function getFkLicitacaoContratoDocumentos()
    {
        return $this->fkLicitacaoContratoDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoModalidadeDocumentos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ModalidadeDocumentos $fkLicitacaoModalidadeDocumentos
     * @return Documento
     */
    public function addFkLicitacaoModalidadeDocumentos(\Urbem\CoreBundle\Entity\Licitacao\ModalidadeDocumentos $fkLicitacaoModalidadeDocumentos)
    {
        if (false === $this->fkLicitacaoModalidadeDocumentos->contains($fkLicitacaoModalidadeDocumentos)) {
            $fkLicitacaoModalidadeDocumentos->setFkLicitacaoDocumento($this);
            $this->fkLicitacaoModalidadeDocumentos->add($fkLicitacaoModalidadeDocumentos);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoModalidadeDocumentos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ModalidadeDocumentos $fkLicitacaoModalidadeDocumentos
     */
    public function removeFkLicitacaoModalidadeDocumentos(\Urbem\CoreBundle\Entity\Licitacao\ModalidadeDocumentos $fkLicitacaoModalidadeDocumentos)
    {
        $this->fkLicitacaoModalidadeDocumentos->removeElement($fkLicitacaoModalidadeDocumentos);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoModalidadeDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ModalidadeDocumentos
     */
    public function getFkLicitacaoModalidadeDocumentos()
    {
        return $this->fkLicitacaoModalidadeDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoDocumentosAtributos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\DocumentosAtributos $fkLicitacaoDocumentosAtributos
     * @return Documento
     */
    public function addFkLicitacaoDocumentosAtributos(\Urbem\CoreBundle\Entity\Licitacao\DocumentosAtributos $fkLicitacaoDocumentosAtributos)
    {
        if (false === $this->fkLicitacaoDocumentosAtributos->contains($fkLicitacaoDocumentosAtributos)) {
            $fkLicitacaoDocumentosAtributos->setFkLicitacaoDocumento($this);
            $this->fkLicitacaoDocumentosAtributos->add($fkLicitacaoDocumentosAtributos);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoDocumentosAtributos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\DocumentosAtributos $fkLicitacaoDocumentosAtributos
     */
    public function removeFkLicitacaoDocumentosAtributos(\Urbem\CoreBundle\Entity\Licitacao\DocumentosAtributos $fkLicitacaoDocumentosAtributos)
    {
        $this->fkLicitacaoDocumentosAtributos->removeElement($fkLicitacaoDocumentosAtributos);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoDocumentosAtributos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\DocumentosAtributos
     */
    public function getFkLicitacaoDocumentosAtributos()
    {
        return $this->fkLicitacaoDocumentosAtributos;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgDeParaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\DeParaDocumento $fkTcemgDeParaDocumento
     * @return Documento
     */
    public function addFkTcemgDeParaDocumentos(\Urbem\CoreBundle\Entity\Tcemg\DeParaDocumento $fkTcemgDeParaDocumento)
    {
        if (false === $this->fkTcemgDeParaDocumentos->contains($fkTcemgDeParaDocumento)) {
            $fkTcemgDeParaDocumento->setFkLicitacaoDocumento($this);
            $this->fkTcemgDeParaDocumentos->add($fkTcemgDeParaDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgDeParaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\DeParaDocumento $fkTcemgDeParaDocumento
     */
    public function removeFkTcemgDeParaDocumentos(\Urbem\CoreBundle\Entity\Tcemg\DeParaDocumento $fkTcemgDeParaDocumento)
    {
        $this->fkTcemgDeParaDocumentos->removeElement($fkTcemgDeParaDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgDeParaDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\DeParaDocumento
     */
    public function getFkTcemgDeParaDocumentos()
    {
        return $this->fkTcemgDeParaDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add TcescTipoCertidaoEsfinge
     *
     * @param \Urbem\CoreBundle\Entity\Tcesc\TipoCertidaoEsfinge $fkTcescTipoCertidaoEsfinge
     * @return Documento
     */
    public function addFkTcescTipoCertidaoEsfinges(\Urbem\CoreBundle\Entity\Tcesc\TipoCertidaoEsfinge $fkTcescTipoCertidaoEsfinge)
    {
        if (false === $this->fkTcescTipoCertidaoEsfinges->contains($fkTcescTipoCertidaoEsfinge)) {
            $fkTcescTipoCertidaoEsfinge->setFkLicitacaoDocumento($this);
            $this->fkTcescTipoCertidaoEsfinges->add($fkTcescTipoCertidaoEsfinge);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcescTipoCertidaoEsfinge
     *
     * @param \Urbem\CoreBundle\Entity\Tcesc\TipoCertidaoEsfinge $fkTcescTipoCertidaoEsfinge
     */
    public function removeFkTcescTipoCertidaoEsfinges(\Urbem\CoreBundle\Entity\Tcesc\TipoCertidaoEsfinge $fkTcescTipoCertidaoEsfinge)
    {
        $this->fkTcescTipoCertidaoEsfinges->removeElement($fkTcescTipoCertidaoEsfinge);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcescTipoCertidaoEsfinges
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcesc\TipoCertidaoEsfinge
     */
    public function getFkTcescTipoCertidaoEsfinges()
    {
        return $this->fkTcescTipoCertidaoEsfinges;
    }

    /**
     * OneToMany (owning side)
     * Add TcmbaDocumentoDePara
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\DocumentoDePara $fkTcmbaDocumentoDePara
     * @return Documento
     */
    public function addFkTcmbaDocumentoDeParas(\Urbem\CoreBundle\Entity\Tcmba\DocumentoDePara $fkTcmbaDocumentoDePara)
    {
        if (false === $this->fkTcmbaDocumentoDeParas->contains($fkTcmbaDocumentoDePara)) {
            $fkTcmbaDocumentoDePara->setFkLicitacaoDocumento($this);
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

    /**
     * OneToMany (owning side)
     * Add TcmgoDocumentoDePara
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\DocumentoDePara $fkTcmgoDocumentoDePara
     * @return Documento
     */
    public function addFkTcmgoDocumentoDeParas(\Urbem\CoreBundle\Entity\Tcmgo\DocumentoDePara $fkTcmgoDocumentoDePara)
    {
        if (false === $this->fkTcmgoDocumentoDeParas->contains($fkTcmgoDocumentoDePara)) {
            $fkTcmgoDocumentoDePara->setFkLicitacaoDocumento($this);
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

    /**
     * OneToMany (owning side)
     * Add TceamTipoCertidaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tceam\TipoCertidaoDocumento $fkTceamTipoCertidaoDocumento
     * @return Documento
     */
    public function addFkTceamTipoCertidaoDocumentos(\Urbem\CoreBundle\Entity\Tceam\TipoCertidaoDocumento $fkTceamTipoCertidaoDocumento)
    {
        if (false === $this->fkTceamTipoCertidaoDocumentos->contains($fkTceamTipoCertidaoDocumento)) {
            $fkTceamTipoCertidaoDocumento->setFkLicitacaoDocumento($this);
            $this->fkTceamTipoCertidaoDocumentos->add($fkTceamTipoCertidaoDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TceamTipoCertidaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tceam\TipoCertidaoDocumento $fkTceamTipoCertidaoDocumento
     */
    public function removeFkTceamTipoCertidaoDocumentos(\Urbem\CoreBundle\Entity\Tceam\TipoCertidaoDocumento $fkTceamTipoCertidaoDocumento)
    {
        $this->fkTceamTipoCertidaoDocumentos->removeElement($fkTceamTipoCertidaoDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTceamTipoCertidaoDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceam\TipoCertidaoDocumento
     */
    public function getFkTceamTipoCertidaoDocumentos()
    {
        return $this->fkTceamTipoCertidaoDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoLicitacaoDocumentos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\LicitacaoDocumentos $fkLicitacaoLicitacaoDocumentos
     * @return Documento
     */
    public function addFkLicitacaoLicitacaoDocumentos(\Urbem\CoreBundle\Entity\Licitacao\LicitacaoDocumentos $fkLicitacaoLicitacaoDocumentos)
    {
        if (false === $this->fkLicitacaoLicitacaoDocumentos->contains($fkLicitacaoLicitacaoDocumentos)) {
            $fkLicitacaoLicitacaoDocumentos->setFkLicitacaoDocumento($this);
            $this->fkLicitacaoLicitacaoDocumentos->add($fkLicitacaoLicitacaoDocumentos);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoLicitacaoDocumentos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\LicitacaoDocumentos $fkLicitacaoLicitacaoDocumentos
     */
    public function removeFkLicitacaoLicitacaoDocumentos(\Urbem\CoreBundle\Entity\Licitacao\LicitacaoDocumentos $fkLicitacaoLicitacaoDocumentos)
    {
        $this->fkLicitacaoLicitacaoDocumentos->removeElement($fkLicitacaoLicitacaoDocumentos);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoLicitacaoDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\LicitacaoDocumentos
     */
    public function getFkLicitacaoLicitacaoDocumentos()
    {
        return $this->fkLicitacaoLicitacaoDocumentos;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->codDocumento, $this->nomDocumento);
    }
}
