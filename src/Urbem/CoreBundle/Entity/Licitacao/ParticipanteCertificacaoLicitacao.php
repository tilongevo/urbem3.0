<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * ParticipanteCertificacaoLicitacao
 */
class ParticipanteCertificacaoLicitacao
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
    private $exercicioCertificacao;

    /**
     * PK
     * @var integer
     */
    private $cgmFornecedor;

    /**
     * PK
     * @var integer
     */
    private $codLicitacao;

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
    private $exercicioLicitacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacao
     */
    private $fkLicitacaoParticipanteCertificacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\Licitacao
     */
    private $fkLicitacaoLicitacao;


    /**
     * Set numCertificacao
     *
     * @param integer $numCertificacao
     * @return ParticipanteCertificacaoLicitacao
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
     * Set exercicioCertificacao
     *
     * @param string $exercicioCertificacao
     * @return ParticipanteCertificacaoLicitacao
     */
    public function setExercicioCertificacao($exercicioCertificacao)
    {
        $this->exercicioCertificacao = $exercicioCertificacao;
        return $this;
    }

    /**
     * Get exercicioCertificacao
     *
     * @return string
     */
    public function getExercicioCertificacao()
    {
        return $this->exercicioCertificacao;
    }

    /**
     * Set cgmFornecedor
     *
     * @param integer $cgmFornecedor
     * @return ParticipanteCertificacaoLicitacao
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
     * Set codLicitacao
     *
     * @param integer $codLicitacao
     * @return ParticipanteCertificacaoLicitacao
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
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return ParticipanteCertificacaoLicitacao
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
     * @return ParticipanteCertificacaoLicitacao
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
     * Set exercicioLicitacao
     *
     * @param string $exercicioLicitacao
     * @return ParticipanteCertificacaoLicitacao
     */
    public function setExercicioLicitacao($exercicioLicitacao)
    {
        $this->exercicioLicitacao = $exercicioLicitacao;
        return $this;
    }

    /**
     * Get exercicioLicitacao
     *
     * @return string
     */
    public function getExercicioLicitacao()
    {
        return $this->exercicioLicitacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoParticipanteCertificacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacao $fkLicitacaoParticipanteCertificacao
     * @return ParticipanteCertificacaoLicitacao
     */
    public function setFkLicitacaoParticipanteCertificacao(\Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacao $fkLicitacaoParticipanteCertificacao)
    {
        $this->numCertificacao = $fkLicitacaoParticipanteCertificacao->getNumCertificacao();
        $this->exercicioCertificacao = $fkLicitacaoParticipanteCertificacao->getExercicio();
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
     * Set fkLicitacaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao
     * @return ParticipanteCertificacaoLicitacao
     */
    public function setFkLicitacaoLicitacao(\Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao)
    {
        $this->codLicitacao = $fkLicitacaoLicitacao->getCodLicitacao();
        $this->codModalidade = $fkLicitacaoLicitacao->getCodModalidade();
        $this->codEntidade = $fkLicitacaoLicitacao->getCodEntidade();
        $this->exercicioLicitacao = $fkLicitacaoLicitacao->getExercicio();
        $this->fkLicitacaoLicitacao = $fkLicitacaoLicitacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoLicitacao
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\Licitacao
     */
    public function getFkLicitacaoLicitacao()
    {
        return $this->fkLicitacaoLicitacao;
    }
}
