<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * DocumentoEmissao
 */
class DocumentoEmissao
{
    /**
     * PK
     * @var integer
     */
    private $codDocumento;

    /**
     * PK
     * @var integer
     */
    private $numDocumento;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\DocumentoCgm
     */
    private $fkArrecadacaoDocumentoCgns;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\DocumentoImovel
     */
    private $fkArrecadacaoDocumentoImoveis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmpresa
     */
    private $fkArrecadacaoDocumentoEmpresas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ParcelaDocumento
     */
    private $fkArrecadacaoParcelaDocumentos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Documento
     */
    private $fkArrecadacaoDocumento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoDocumentoCgns = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoDocumentoImoveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoDocumentoEmpresas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoParcelaDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return DocumentoEmissao
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
     * Set numDocumento
     *
     * @param integer $numDocumento
     * @return DocumentoEmissao
     */
    public function setNumDocumento($numDocumento)
    {
        $this->numDocumento = $numDocumento;
        return $this;
    }

    /**
     * Get numDocumento
     *
     * @return integer
     */
    public function getNumDocumento()
    {
        return $this->numDocumento;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return DocumentoEmissao
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return DocumentoEmissao
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return DocumentoEmissao
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
     * Add ArrecadacaoDocumentoCgm
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\DocumentoCgm $fkArrecadacaoDocumentoCgm
     * @return DocumentoEmissao
     */
    public function addFkArrecadacaoDocumentoCgns(\Urbem\CoreBundle\Entity\Arrecadacao\DocumentoCgm $fkArrecadacaoDocumentoCgm)
    {
        if (false === $this->fkArrecadacaoDocumentoCgns->contains($fkArrecadacaoDocumentoCgm)) {
            $fkArrecadacaoDocumentoCgm->setFkArrecadacaoDocumentoEmissao($this);
            $this->fkArrecadacaoDocumentoCgns->add($fkArrecadacaoDocumentoCgm);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoDocumentoCgm
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\DocumentoCgm $fkArrecadacaoDocumentoCgm
     */
    public function removeFkArrecadacaoDocumentoCgns(\Urbem\CoreBundle\Entity\Arrecadacao\DocumentoCgm $fkArrecadacaoDocumentoCgm)
    {
        $this->fkArrecadacaoDocumentoCgns->removeElement($fkArrecadacaoDocumentoCgm);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoDocumentoCgns
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\DocumentoCgm
     */
    public function getFkArrecadacaoDocumentoCgns()
    {
        return $this->fkArrecadacaoDocumentoCgns;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoDocumentoImovel
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\DocumentoImovel $fkArrecadacaoDocumentoImovel
     * @return DocumentoEmissao
     */
    public function addFkArrecadacaoDocumentoImoveis(\Urbem\CoreBundle\Entity\Arrecadacao\DocumentoImovel $fkArrecadacaoDocumentoImovel)
    {
        if (false === $this->fkArrecadacaoDocumentoImoveis->contains($fkArrecadacaoDocumentoImovel)) {
            $fkArrecadacaoDocumentoImovel->setFkArrecadacaoDocumentoEmissao($this);
            $this->fkArrecadacaoDocumentoImoveis->add($fkArrecadacaoDocumentoImovel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoDocumentoImovel
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\DocumentoImovel $fkArrecadacaoDocumentoImovel
     */
    public function removeFkArrecadacaoDocumentoImoveis(\Urbem\CoreBundle\Entity\Arrecadacao\DocumentoImovel $fkArrecadacaoDocumentoImovel)
    {
        $this->fkArrecadacaoDocumentoImoveis->removeElement($fkArrecadacaoDocumentoImovel);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoDocumentoImoveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\DocumentoImovel
     */
    public function getFkArrecadacaoDocumentoImoveis()
    {
        return $this->fkArrecadacaoDocumentoImoveis;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoDocumentoEmpresa
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmpresa $fkArrecadacaoDocumentoEmpresa
     * @return DocumentoEmissao
     */
    public function addFkArrecadacaoDocumentoEmpresas(\Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmpresa $fkArrecadacaoDocumentoEmpresa)
    {
        if (false === $this->fkArrecadacaoDocumentoEmpresas->contains($fkArrecadacaoDocumentoEmpresa)) {
            $fkArrecadacaoDocumentoEmpresa->setFkArrecadacaoDocumentoEmissao($this);
            $this->fkArrecadacaoDocumentoEmpresas->add($fkArrecadacaoDocumentoEmpresa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoDocumentoEmpresa
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmpresa $fkArrecadacaoDocumentoEmpresa
     */
    public function removeFkArrecadacaoDocumentoEmpresas(\Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmpresa $fkArrecadacaoDocumentoEmpresa)
    {
        $this->fkArrecadacaoDocumentoEmpresas->removeElement($fkArrecadacaoDocumentoEmpresa);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoDocumentoEmpresas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmpresa
     */
    public function getFkArrecadacaoDocumentoEmpresas()
    {
        return $this->fkArrecadacaoDocumentoEmpresas;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoParcelaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ParcelaDocumento $fkArrecadacaoParcelaDocumento
     * @return DocumentoEmissao
     */
    public function addFkArrecadacaoParcelaDocumentos(\Urbem\CoreBundle\Entity\Arrecadacao\ParcelaDocumento $fkArrecadacaoParcelaDocumento)
    {
        if (false === $this->fkArrecadacaoParcelaDocumentos->contains($fkArrecadacaoParcelaDocumento)) {
            $fkArrecadacaoParcelaDocumento->setFkArrecadacaoDocumentoEmissao($this);
            $this->fkArrecadacaoParcelaDocumentos->add($fkArrecadacaoParcelaDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoParcelaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ParcelaDocumento $fkArrecadacaoParcelaDocumento
     */
    public function removeFkArrecadacaoParcelaDocumentos(\Urbem\CoreBundle\Entity\Arrecadacao\ParcelaDocumento $fkArrecadacaoParcelaDocumento)
    {
        $this->fkArrecadacaoParcelaDocumentos->removeElement($fkArrecadacaoParcelaDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoParcelaDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ParcelaDocumento
     */
    public function getFkArrecadacaoParcelaDocumentos()
    {
        return $this->fkArrecadacaoParcelaDocumentos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Documento $fkArrecadacaoDocumento
     * @return DocumentoEmissao
     */
    public function setFkArrecadacaoDocumento(\Urbem\CoreBundle\Entity\Arrecadacao\Documento $fkArrecadacaoDocumento)
    {
        $this->codDocumento = $fkArrecadacaoDocumento->getCodDocumento();
        $this->fkArrecadacaoDocumento = $fkArrecadacaoDocumento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Documento
     */
    public function getFkArrecadacaoDocumento()
    {
        return $this->fkArrecadacaoDocumento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return DocumentoEmissao
     */
    public function setFkAdministracaoUsuario(\Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario)
    {
        $this->numcgm = $fkAdministracaoUsuario->getNumcgm();
        $this->fkAdministracaoUsuario = $fkAdministracaoUsuario;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoUsuario
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    public function getFkAdministracaoUsuario()
    {
        return $this->fkAdministracaoUsuario;
    }
}
