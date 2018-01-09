<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

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
     * @var integer
     */
    private $codTipoFiscalizacao;

    /**
     * @var string
     */
    private $nomDocumento;

    /**
     * @var boolean
     */
    private $usoInterno;

    /**
     * @var boolean
     */
    private $ativo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\DocumentoAtividade
     */
    private $fkFiscalizacaoDocumentoAtividades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacaoDocumentos
     */
    private $fkFiscalizacaoInicioFiscalizacaoDocumentos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\TipoFiscalizacao
     */
    private $fkFiscalizacaoTipoFiscalizacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFiscalizacaoDocumentoAtividades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoInicioFiscalizacaoDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set codTipoFiscalizacao
     *
     * @param integer $codTipoFiscalizacao
     * @return Documento
     */
    public function setCodTipoFiscalizacao($codTipoFiscalizacao)
    {
        $this->codTipoFiscalizacao = $codTipoFiscalizacao;
        return $this;
    }

    /**
     * Get codTipoFiscalizacao
     *
     * @return integer
     */
    public function getCodTipoFiscalizacao()
    {
        return $this->codTipoFiscalizacao;
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
     * Set usoInterno
     *
     * @param boolean $usoInterno
     * @return Documento
     */
    public function setUsoInterno($usoInterno)
    {
        $this->usoInterno = $usoInterno;
        return $this;
    }

    /**
     * Get usoInterno
     *
     * @return boolean
     */
    public function getUsoInterno()
    {
        return $this->usoInterno;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return Documento
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
        return $this;
    }

    /**
     * Get ativo
     *
     * @return boolean
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoDocumentoAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\DocumentoAtividade $fkFiscalizacaoDocumentoAtividade
     * @return Documento
     */
    public function addFkFiscalizacaoDocumentoAtividades(\Urbem\CoreBundle\Entity\Fiscalizacao\DocumentoAtividade $fkFiscalizacaoDocumentoAtividade)
    {
        if (false === $this->fkFiscalizacaoDocumentoAtividades->contains($fkFiscalizacaoDocumentoAtividade)) {
            $fkFiscalizacaoDocumentoAtividade->setFkFiscalizacaoDocumento($this);
            $this->fkFiscalizacaoDocumentoAtividades->add($fkFiscalizacaoDocumentoAtividade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoDocumentoAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\DocumentoAtividade $fkFiscalizacaoDocumentoAtividade
     */
    public function removeFkFiscalizacaoDocumentoAtividades(\Urbem\CoreBundle\Entity\Fiscalizacao\DocumentoAtividade $fkFiscalizacaoDocumentoAtividade)
    {
        $this->fkFiscalizacaoDocumentoAtividades->removeElement($fkFiscalizacaoDocumentoAtividade);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoDocumentoAtividades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\DocumentoAtividade
     */
    public function getFkFiscalizacaoDocumentoAtividades()
    {
        return $this->fkFiscalizacaoDocumentoAtividades;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoInicioFiscalizacaoDocumentos
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacaoDocumentos $fkFiscalizacaoInicioFiscalizacaoDocumentos
     * @return Documento
     */
    public function addFkFiscalizacaoInicioFiscalizacaoDocumentos(\Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacaoDocumentos $fkFiscalizacaoInicioFiscalizacaoDocumentos)
    {
        if (false === $this->fkFiscalizacaoInicioFiscalizacaoDocumentos->contains($fkFiscalizacaoInicioFiscalizacaoDocumentos)) {
            $fkFiscalizacaoInicioFiscalizacaoDocumentos->setFkFiscalizacaoDocumento($this);
            $this->fkFiscalizacaoInicioFiscalizacaoDocumentos->add($fkFiscalizacaoInicioFiscalizacaoDocumentos);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoInicioFiscalizacaoDocumentos
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacaoDocumentos $fkFiscalizacaoInicioFiscalizacaoDocumentos
     */
    public function removeFkFiscalizacaoInicioFiscalizacaoDocumentos(\Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacaoDocumentos $fkFiscalizacaoInicioFiscalizacaoDocumentos)
    {
        $this->fkFiscalizacaoInicioFiscalizacaoDocumentos->removeElement($fkFiscalizacaoInicioFiscalizacaoDocumentos);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoInicioFiscalizacaoDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacaoDocumentos
     */
    public function getFkFiscalizacaoInicioFiscalizacaoDocumentos()
    {
        return $this->fkFiscalizacaoInicioFiscalizacaoDocumentos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoTipoFiscalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\TipoFiscalizacao $fkFiscalizacaoTipoFiscalizacao
     * @return Documento
     */
    public function setFkFiscalizacaoTipoFiscalizacao(\Urbem\CoreBundle\Entity\Fiscalizacao\TipoFiscalizacao $fkFiscalizacaoTipoFiscalizacao)
    {
        $this->codTipoFiscalizacao = $fkFiscalizacaoTipoFiscalizacao->getCodTipo();
        $this->fkFiscalizacaoTipoFiscalizacao = $fkFiscalizacaoTipoFiscalizacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoTipoFiscalizacao
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\TipoFiscalizacao
     */
    public function getFkFiscalizacaoTipoFiscalizacao()
    {
        return $this->fkFiscalizacaoTipoFiscalizacao;
    }
}
