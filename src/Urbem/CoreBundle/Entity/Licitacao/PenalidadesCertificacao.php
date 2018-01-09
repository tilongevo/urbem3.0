<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * PenalidadesCertificacao
 */
class PenalidadesCertificacao
{
    /**
     * PK
     * @var integer
     */
    private $codPenalidade;

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
    private $cgmFornecedor;

    /**
     * @var string
     */
    private $anoExercicio;

    /**
     * @var integer
     */
    private $codProcesso;

    /**
     * @var integer
     */
    private $valor;

    /**
     * @var \DateTime
     */
    private $dtPublicacao;

    /**
     * @var \DateTime
     */
    private $dtValidade;

    /**
     * @var string
     */
    private $observacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\Penalidade
     */
    private $fkLicitacaoPenalidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacaoPenalidade
     */
    private $fkLicitacaoParticipanteCertificacaoPenalidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwProcesso
     */
    private $fkSwProcesso;


    /**
     * Set codPenalidade
     *
     * @param integer $codPenalidade
     * @return PenalidadesCertificacao
     */
    public function setCodPenalidade($codPenalidade)
    {
        $this->codPenalidade = $codPenalidade;
        return $this;
    }

    /**
     * Get codPenalidade
     *
     * @return integer
     */
    public function getCodPenalidade()
    {
        return $this->codPenalidade;
    }

    /**
     * Set numCertificacao
     *
     * @param integer $numCertificacao
     * @return PenalidadesCertificacao
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
     * @return PenalidadesCertificacao
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
     * Set cgmFornecedor
     *
     * @param integer $cgmFornecedor
     * @return PenalidadesCertificacao
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
     * Set anoExercicio
     *
     * @param string $anoExercicio
     * @return PenalidadesCertificacao
     */
    public function setAnoExercicio($anoExercicio)
    {
        $this->anoExercicio = $anoExercicio;
        return $this;
    }

    /**
     * Get anoExercicio
     *
     * @return string
     */
    public function getAnoExercicio()
    {
        return $this->anoExercicio;
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return PenalidadesCertificacao
     */
    public function setCodProcesso($codProcesso)
    {
        $this->codProcesso = $codProcesso;
        return $this;
    }

    /**
     * Get codProcesso
     *
     * @return integer
     */
    public function getCodProcesso()
    {
        return $this->codProcesso;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return PenalidadesCertificacao
     */
    public function setValor($valor = null)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set dtPublicacao
     *
     * @param \DateTime $dtPublicacao
     * @return PenalidadesCertificacao
     */
    public function setDtPublicacao(\DateTime $dtPublicacao)
    {
        $this->dtPublicacao = $dtPublicacao;
        return $this;
    }

    /**
     * Get dtPublicacao
     *
     * @return \DateTime
     */
    public function getDtPublicacao()
    {
        return $this->dtPublicacao;
    }

    /**
     * Set dtValidade
     *
     * @param \DateTime $dtValidade
     * @return PenalidadesCertificacao
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
     * Set observacao
     *
     * @param string $observacao
     * @return PenalidadesCertificacao
     */
    public function setObservacao($observacao = null)
    {
        $this->observacao = $observacao;
        return $this;
    }

    /**
     * Get observacao
     *
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoPenalidade
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Penalidade $fkLicitacaoPenalidade
     * @return PenalidadesCertificacao
     */
    public function setFkLicitacaoPenalidade(\Urbem\CoreBundle\Entity\Licitacao\Penalidade $fkLicitacaoPenalidade)
    {
        $this->codPenalidade = $fkLicitacaoPenalidade->getCodPenalidade();
        $this->fkLicitacaoPenalidade = $fkLicitacaoPenalidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoPenalidade
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\Penalidade
     */
    public function getFkLicitacaoPenalidade()
    {
        return $this->fkLicitacaoPenalidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoParticipanteCertificacaoPenalidade
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacaoPenalidade $fkLicitacaoParticipanteCertificacaoPenalidade
     * @return PenalidadesCertificacao
     */
    public function setFkLicitacaoParticipanteCertificacaoPenalidade(\Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacaoPenalidade $fkLicitacaoParticipanteCertificacaoPenalidade)
    {
        $this->exercicio = $fkLicitacaoParticipanteCertificacaoPenalidade->getExercicio();
        $this->numCertificacao = $fkLicitacaoParticipanteCertificacaoPenalidade->getNumCertificacao();
        $this->cgmFornecedor = $fkLicitacaoParticipanteCertificacaoPenalidade->getCgmFornecedor();
        $this->fkLicitacaoParticipanteCertificacaoPenalidade = $fkLicitacaoParticipanteCertificacaoPenalidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoParticipanteCertificacaoPenalidade
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacaoPenalidade
     */
    public function getFkLicitacaoParticipanteCertificacaoPenalidade()
    {
        return $this->fkLicitacaoParticipanteCertificacaoPenalidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     * @return PenalidadesCertificacao
     */
    public function setFkSwProcesso(\Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso)
    {
        $this->codProcesso = $fkSwProcesso->getCodProcesso();
        $this->anoExercicio = $fkSwProcesso->getAnoExercicio();
        $this->fkSwProcesso = $fkSwProcesso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwProcesso
     *
     * @return \Urbem\CoreBundle\Entity\SwProcesso
     */
    public function getFkSwProcesso()
    {
        return $this->fkSwProcesso;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->fkLicitacaoPenalidade;
    }
}
