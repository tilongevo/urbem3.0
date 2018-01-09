<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * DocumentoImovel
 */
class DocumentoImovel
{
    /**
     * PK
     * @var integer
     */
    private $inscricaoMunicipal;

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
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Imovel
     */
    private $fkImobiliarioImovel;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmissao
     */
    private $fkArrecadacaoDocumentoEmissao;


    /**
     * Set inscricaoMunicipal
     *
     * @param integer $inscricaoMunicipal
     * @return DocumentoImovel
     */
    public function setInscricaoMunicipal($inscricaoMunicipal)
    {
        $this->inscricaoMunicipal = $inscricaoMunicipal;
        return $this;
    }

    /**
     * Get inscricaoMunicipal
     *
     * @return integer
     */
    public function getInscricaoMunicipal()
    {
        return $this->inscricaoMunicipal;
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return DocumentoImovel
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
     * @return DocumentoImovel
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
     * @return DocumentoImovel
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
     * ManyToOne (inverse side)
     * Set fkImobiliarioImovel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Imovel $fkImobiliarioImovel
     * @return DocumentoImovel
     */
    public function setFkImobiliarioImovel(\Urbem\CoreBundle\Entity\Imobiliario\Imovel $fkImobiliarioImovel)
    {
        $this->inscricaoMunicipal = $fkImobiliarioImovel->getInscricaoMunicipal();
        $this->fkImobiliarioImovel = $fkImobiliarioImovel;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioImovel
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Imovel
     */
    public function getFkImobiliarioImovel()
    {
        return $this->fkImobiliarioImovel;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoDocumentoEmissao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmissao $fkArrecadacaoDocumentoEmissao
     * @return DocumentoImovel
     */
    public function setFkArrecadacaoDocumentoEmissao(\Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmissao $fkArrecadacaoDocumentoEmissao)
    {
        $this->codDocumento = $fkArrecadacaoDocumentoEmissao->getCodDocumento();
        $this->numDocumento = $fkArrecadacaoDocumentoEmissao->getNumDocumento();
        $this->exercicio = $fkArrecadacaoDocumentoEmissao->getExercicio();
        $this->fkArrecadacaoDocumentoEmissao = $fkArrecadacaoDocumentoEmissao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoDocumentoEmissao
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmissao
     */
    public function getFkArrecadacaoDocumentoEmissao()
    {
        return $this->fkArrecadacaoDocumentoEmissao;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getInscricaoMunicipal();
    }
}
