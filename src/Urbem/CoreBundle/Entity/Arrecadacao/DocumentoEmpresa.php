<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * DocumentoEmpresa
 */
class DocumentoEmpresa
{
    /**
     * PK
     * @var integer
     */
    private $inscricaoEconomica;

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
     * @var \Urbem\CoreBundle\Entity\Economico\CadastroEconomico
     */
    private $fkEconomicoCadastroEconomico;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmissao
     */
    private $fkArrecadacaoDocumentoEmissao;


    /**
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return DocumentoEmpresa
     */
    public function setInscricaoEconomica($inscricaoEconomica)
    {
        $this->inscricaoEconomica = $inscricaoEconomica;
        return $this;
    }

    /**
     * Get inscricaoEconomica
     *
     * @return integer
     */
    public function getInscricaoEconomica()
    {
        return $this->inscricaoEconomica;
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return DocumentoEmpresa
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
     * @return DocumentoEmpresa
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
     * @return DocumentoEmpresa
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
     * Set fkEconomicoCadastroEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconomico $fkEconomicoCadastroEconomico
     * @return DocumentoEmpresa
     */
    public function setFkEconomicoCadastroEconomico(\Urbem\CoreBundle\Entity\Economico\CadastroEconomico $fkEconomicoCadastroEconomico)
    {
        $this->inscricaoEconomica = $fkEconomicoCadastroEconomico->getInscricaoEconomica();
        $this->fkEconomicoCadastroEconomico = $fkEconomicoCadastroEconomico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoCadastroEconomico
     *
     * @return \Urbem\CoreBundle\Entity\Economico\CadastroEconomico
     */
    public function getFkEconomicoCadastroEconomico()
    {
        return $this->fkEconomicoCadastroEconomico;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoDocumentoEmissao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmissao $fkArrecadacaoDocumentoEmissao
     * @return DocumentoEmpresa
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
        return (string) $this->getInscricaoEconomica();
    }
}
