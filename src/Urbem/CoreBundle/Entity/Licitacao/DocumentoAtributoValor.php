<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * DocumentoAtributoValor
 */
class DocumentoAtributoValor
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
    private $codAtributo;

    /**
     * PK
     * @var integer
     */
    private $codCadastro;

    /**
     * PK
     * @var integer
     */
    private $codModulo;

    /**
     * @var string
     */
    private $valor;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Licitacao\DocumentosAtributos
     */
    private $fkLicitacaoDocumentosAtributos;


    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return DocumentoAtributoValor
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
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return DocumentoAtributoValor
     */
    public function setCodAtributo($codAtributo)
    {
        $this->codAtributo = $codAtributo;
        return $this;
    }

    /**
     * Get codAtributo
     *
     * @return integer
     */
    public function getCodAtributo()
    {
        return $this->codAtributo;
    }

    /**
     * Set codCadastro
     *
     * @param integer $codCadastro
     * @return DocumentoAtributoValor
     */
    public function setCodCadastro($codCadastro)
    {
        $this->codCadastro = $codCadastro;
        return $this;
    }

    /**
     * Get codCadastro
     *
     * @return integer
     */
    public function getCodCadastro()
    {
        return $this->codCadastro;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return DocumentoAtributoValor
     */
    public function setCodModulo($codModulo)
    {
        $this->codModulo = $codModulo;
        return $this;
    }

    /**
     * Get codModulo
     *
     * @return integer
     */
    public function getCodModulo()
    {
        return $this->codModulo;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return DocumentoAtributoValor
     */
    public function setValor($valor = null)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * OneToOne (owning side)
     * Set LicitacaoDocumentosAtributos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\DocumentosAtributos $fkLicitacaoDocumentosAtributos
     * @return DocumentoAtributoValor
     */
    public function setFkLicitacaoDocumentosAtributos(\Urbem\CoreBundle\Entity\Licitacao\DocumentosAtributos $fkLicitacaoDocumentosAtributos)
    {
        $this->codDocumento = $fkLicitacaoDocumentosAtributos->getCodDocumento();
        $this->codAtributo = $fkLicitacaoDocumentosAtributos->getCodAtributo();
        $this->codModulo = $fkLicitacaoDocumentosAtributos->getCodModulo();
        $this->codCadastro = $fkLicitacaoDocumentosAtributos->getCodCadastro();
        $this->fkLicitacaoDocumentosAtributos = $fkLicitacaoDocumentosAtributos;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkLicitacaoDocumentosAtributos
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\DocumentosAtributos
     */
    public function getFkLicitacaoDocumentosAtributos()
    {
        return $this->fkLicitacaoDocumentosAtributos;
    }
}
