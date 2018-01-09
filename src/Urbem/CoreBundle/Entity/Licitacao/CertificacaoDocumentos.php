<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * CertificacaoDocumentos
 */
class CertificacaoDocumentos
{
    /**
     * PK
     * @var integer
     */
    private $numCertificacao;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codDocumento;

    /**
     * PK
     * @var integer
     */
    private $cgmFornecedor;

    /**
     * @var string
     */
    private $numDocumento;

    /**
     * @var \DateTime
     */
    private $dtEmissao;

    /**
     * @var \DateTime
     */
    private $dtValidade;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacao
     */
    private $fkLicitacaoParticipanteCertificacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\Documento
     */
    private $fkLicitacaoDocumento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set numCertificacao
     *
     * @param integer $numCertificacao
     * @return CertificacaoDocumentos
     */
    public function setNumCertificacao($numCertificacao)
    {
        $this->numCertificacao = $numCertificacao;
        return $this;
    }

    /**
     * Get numCertificacao
     *
     * @return integer
     */
    public function getNumCertificacao()
    {
        return $this->numCertificacao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return CertificacaoDocumentos
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
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return CertificacaoDocumentos
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
     * Set cgmFornecedor
     *
     * @param integer $cgmFornecedor
     * @return CertificacaoDocumentos
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
     * Set numDocumento
     *
     * @param string $numDocumento
     * @return CertificacaoDocumentos
     */
    public function setNumDocumento($numDocumento = null)
    {
        $this->numDocumento = $numDocumento;
        return $this;
    }

    /**
     * Get numDocumento
     *
     * @return string
     */
    public function getNumDocumento()
    {
        return $this->numDocumento;
    }

    /**
     * Set dtEmissao
     *
     * @param \DateTime $dtEmissao
     * @return CertificacaoDocumentos
     */
    public function setDtEmissao(\DateTime $dtEmissao)
    {
        $this->dtEmissao = $dtEmissao;
        return $this;
    }

    /**
     * Get dtEmissao
     *
     * @return \DateTime
     */
    public function getDtEmissao()
    {
        return $this->dtEmissao;
    }

    /**
     * Set dtValidade
     *
     * @param \DateTime $dtValidade
     * @return CertificacaoDocumentos
     */
    public function setDtValidade(\DateTime $dtValidade)
    {
        $this->dtValidade = $dtValidade;
        return $this;
    }

    /**
     * Get dtValidade
     *
     * @return \DateTime
     */
    public function getDtValidade()
    {
        return $this->dtValidade;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return CertificacaoDocumentos
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp = null)
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
     * ManyToOne (inverse side)
     * Set fkLicitacaoParticipanteCertificacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacao $fkLicitacaoParticipanteCertificacao
     * @return CertificacaoDocumentos
     */
    public function setFkLicitacaoParticipanteCertificacao(\Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacao $fkLicitacaoParticipanteCertificacao)
    {
        $this->numCertificacao = $fkLicitacaoParticipanteCertificacao->getNumCertificacao();
        $this->exercicio = $fkLicitacaoParticipanteCertificacao->getExercicio();
        $this->cgmFornecedor = $fkLicitacaoParticipanteCertificacao->getCgmFornecedor();
        $this->fkLicitacaoParticipanteCertificacao = $fkLicitacaoParticipanteCertificacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoParticipanteCertificacao
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacao
     */
    public function getFkLicitacaoParticipanteCertificacao()
    {
        return $this->fkLicitacaoParticipanteCertificacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Documento $fkLicitacaoDocumento
     * @return CertificacaoDocumentos
     */
    public function setFkLicitacaoDocumento(\Urbem\CoreBundle\Entity\Licitacao\Documento $fkLicitacaoDocumento)
    {
        $this->codDocumento = $fkLicitacaoDocumento->getCodDocumento();
        $this->fkLicitacaoDocumento = $fkLicitacaoDocumento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\Documento
     */
    public function getFkLicitacaoDocumento()
    {
        return $this->fkLicitacaoDocumento;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->codDocumento) {
            return $this->codDocumento.' - '.$this->fkLicitacaoDocumento->getNomDocumento();
        }

        return '';
    }
}
