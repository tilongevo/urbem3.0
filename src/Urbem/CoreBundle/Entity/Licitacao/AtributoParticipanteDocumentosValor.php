<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * AtributoParticipanteDocumentosValor
 */
class AtributoParticipanteDocumentosValor
{
    /**
     * PK
     * @var integer
     */
    private $codLicitacao;

    /**
     * PK
     * @var integer
     */
    private $codDocumento;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DatePK
     */
    private $dtValidade;

    /**
     * PK
     * @var integer
     */
    private $cgmFornecedor;

    /**
     * PK
     * @var integer
     */
    private $codModalidade;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * @var string
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\ParticipanteDocumentos
     */
    private $fkLicitacaoParticipanteDocumentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dtValidade = new \Urbem\CoreBundle\Helper\DatePK;
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codLicitacao
     *
     * @param integer $codLicitacao
     * @return AtributoParticipanteDocumentosValor
     */
    public function setCodLicitacao($codLicitacao)
    {
        $this->codLicitacao = $codLicitacao;
        return $this;
    }

    /**
     * Get codLicitacao
     *
     * @return integer
     */
    public function getCodLicitacao()
    {
        return $this->codLicitacao;
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return AtributoParticipanteDocumentosValor
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
     * Set dtValidade
     *
     * @param \Urbem\CoreBundle\Helper\DatePK $dtValidade
     * @return AtributoParticipanteDocumentosValor
     */
    public function setDtValidade(\Urbem\CoreBundle\Helper\DatePK $dtValidade)
    {
        $this->dtValidade = $dtValidade;
        return $this;
    }

    /**
     * Get dtValidade
     *
     * @return \Urbem\CoreBundle\Helper\DatePK
     */
    public function getDtValidade()
    {
        return $this->dtValidade;
    }

    /**
     * Set cgmFornecedor
     *
     * @param integer $cgmFornecedor
     * @return AtributoParticipanteDocumentosValor
     */
    public function setCgmFornecedor($cgmFornecedor)
    {
        $this->cgmFornecedor = $cgmFornecedor;
        return $this;
    }

    /**
     * Get cgmFornecedor
     *
     * @return integer
     */
    public function getCgmFornecedor()
    {
        return $this->cgmFornecedor;
    }

    /**
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return AtributoParticipanteDocumentosValor
     */
    public function setCodModalidade($codModalidade)
    {
        $this->codModalidade = $codModalidade;
        return $this;
    }

    /**
     * Get codModalidade
     *
     * @return integer
     */
    public function getCodModalidade()
    {
        return $this->codModalidade;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return AtributoParticipanteDocumentosValor
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return AtributoParticipanteDocumentosValor
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return AtributoParticipanteDocumentosValor
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimePK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return AtributoParticipanteDocumentosValor
     */
    public function setValor($valor)
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
     * ManyToOne (inverse side)
     * Set fkLicitacaoParticipanteDocumentos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ParticipanteDocumentos $fkLicitacaoParticipanteDocumentos
     * @return AtributoParticipanteDocumentosValor
     */
    public function setFkLicitacaoParticipanteDocumentos(\Urbem\CoreBundle\Entity\Licitacao\ParticipanteDocumentos $fkLicitacaoParticipanteDocumentos)
    {
        $this->codLicitacao = $fkLicitacaoParticipanteDocumentos->getCodLicitacao();
        $this->codDocumento = $fkLicitacaoParticipanteDocumentos->getCodDocumento();
        $this->dtValidade = $fkLicitacaoParticipanteDocumentos->getDtValidade();
        $this->cgmFornecedor = $fkLicitacaoParticipanteDocumentos->getCgmFornecedor();
        $this->codModalidade = $fkLicitacaoParticipanteDocumentos->getCodModalidade();
        $this->codEntidade = $fkLicitacaoParticipanteDocumentos->getCodEntidade();
        $this->exercicio = $fkLicitacaoParticipanteDocumentos->getExercicio();
        $this->fkLicitacaoParticipanteDocumentos = $fkLicitacaoParticipanteDocumentos;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoParticipanteDocumentos
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\ParticipanteDocumentos
     */
    public function getFkLicitacaoParticipanteDocumentos()
    {
        return $this->fkLicitacaoParticipanteDocumentos;
    }
}
