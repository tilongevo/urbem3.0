<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

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
    private $descricao;

    /**
     * @var integer
     */
    private $codModeloDocumento;

    /**
     * @var integer
     */
    private $codTipoDocumento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmissao
     */
    private $fkArrecadacaoDocumentoEmissoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento
     */
    private $fkAdministracaoModeloDocumento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoDocumentoEmissoes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set descricao
     *
     * @param string $descricao
     * @return Documento
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
     * Set codModeloDocumento
     *
     * @param integer $codModeloDocumento
     * @return Documento
     */
    public function setCodModeloDocumento($codModeloDocumento)
    {
        $this->codModeloDocumento = $codModeloDocumento;
        return $this;
    }

    /**
     * Get codModeloDocumento
     *
     * @return integer
     */
    public function getCodModeloDocumento()
    {
        return $this->codModeloDocumento;
    }

    /**
     * Set codTipoDocumento
     *
     * @param integer $codTipoDocumento
     * @return Documento
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
     * OneToMany (owning side)
     * Add ArrecadacaoDocumentoEmissao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmissao $fkArrecadacaoDocumentoEmissao
     * @return Documento
     */
    public function addFkArrecadacaoDocumentoEmissoes(\Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmissao $fkArrecadacaoDocumentoEmissao)
    {
        if (false === $this->fkArrecadacaoDocumentoEmissoes->contains($fkArrecadacaoDocumentoEmissao)) {
            $fkArrecadacaoDocumentoEmissao->setFkArrecadacaoDocumento($this);
            $this->fkArrecadacaoDocumentoEmissoes->add($fkArrecadacaoDocumentoEmissao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoDocumentoEmissao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmissao $fkArrecadacaoDocumentoEmissao
     */
    public function removeFkArrecadacaoDocumentoEmissoes(\Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmissao $fkArrecadacaoDocumentoEmissao)
    {
        $this->fkArrecadacaoDocumentoEmissoes->removeElement($fkArrecadacaoDocumentoEmissao);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoDocumentoEmissoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmissao
     */
    public function getFkArrecadacaoDocumentoEmissoes()
    {
        return $this->fkArrecadacaoDocumentoEmissoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoModeloDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento
     * @return Documento
     */
    public function setFkAdministracaoModeloDocumento(\Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento)
    {
        $this->codModeloDocumento = $fkAdministracaoModeloDocumento->getCodDocumento();
        $this->codTipoDocumento = $fkAdministracaoModeloDocumento->getCodTipoDocumento();
        $this->fkAdministracaoModeloDocumento = $fkAdministracaoModeloDocumento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoModeloDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento
     */
    public function getFkAdministracaoModeloDocumento()
    {
        return $this->fkAdministracaoModeloDocumento;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getCodDocumento().' - '.$this->getDescricao();
    }
}
