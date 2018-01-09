<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * ParticipanteConvenio
 */
class ParticipanteConvenio
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $numConvenio;

    /**
     * PK
     * @var integer
     */
    private $cgmFornecedor;

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
     * @var integer
     */
    private $codTipoParticipante;

    /**
     * @var integer
     */
    private $valorParticipacao;

    /**
     * @var integer
     */
    private $percentualParticipacao;

    /**
     * @var string
     */
    private $funcao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\Convenio
     */
    private $fkLicitacaoConvenio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacao
     */
    private $fkLicitacaoParticipanteCertificacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\TipoParticipante
     */
    private $fkLicitacaoTipoParticipante;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ParticipanteConvenio
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
     * Set numConvenio
     *
     * @param integer $numConvenio
     * @return ParticipanteConvenio
     */
    public function setNumConvenio($numConvenio)
    {
        $this->numConvenio = $numConvenio;
        return $this;
    }

    /**
     * Get numConvenio
     *
     * @return integer
     */
    public function getNumConvenio()
    {
        return $this->numConvenio;
    }

    /**
     * Set cgmFornecedor
     *
     * @param integer $cgmFornecedor
     * @return ParticipanteConvenio
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
     * Set numCertificacao
     *
     * @param integer $numCertificacao
     * @return ParticipanteConvenio
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
     * @return ParticipanteConvenio
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
     * Set codTipoParticipante
     *
     * @param integer $codTipoParticipante
     * @return ParticipanteConvenio
     */
    public function setCodTipoParticipante($codTipoParticipante)
    {
        $this->codTipoParticipante = $codTipoParticipante;
        return $this;
    }

    /**
     * Get codTipoParticipante
     *
     * @return integer
     */
    public function getCodTipoParticipante()
    {
        return $this->codTipoParticipante;
    }

    /**
     * Set valorParticipacao
     *
     * @param integer $valorParticipacao
     * @return ParticipanteConvenio
     */
    public function setValorParticipacao($valorParticipacao)
    {
        $this->valorParticipacao = $valorParticipacao;
        return $this;
    }

    /**
     * Get valorParticipacao
     *
     * @return integer
     */
    public function getValorParticipacao()
    {
        return $this->valorParticipacao;
    }

    /**
     * Set percentualParticipacao
     *
     * @param integer $percentualParticipacao
     * @return ParticipanteConvenio
     */
    public function setPercentualParticipacao($percentualParticipacao)
    {
        $this->percentualParticipacao = $percentualParticipacao;
        return $this;
    }

    /**
     * Get percentualParticipacao
     *
     * @return integer
     */
    public function getPercentualParticipacao()
    {
        return $this->percentualParticipacao;
    }

    /**
     * Set funcao
     *
     * @param string $funcao
     * @return ParticipanteConvenio
     */
    public function setFuncao($funcao)
    {
        $this->funcao = $funcao;
        return $this;
    }

    /**
     * Get funcao
     *
     * @return string
     */
    public function getFuncao()
    {
        return $this->funcao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Convenio $fkLicitacaoConvenio
     * @return ParticipanteConvenio
     */
    public function setFkLicitacaoConvenio(\Urbem\CoreBundle\Entity\Licitacao\Convenio $fkLicitacaoConvenio)
    {
        $this->numConvenio = $fkLicitacaoConvenio->getNumConvenio();
        $this->exercicio = $fkLicitacaoConvenio->getExercicio();
        $this->fkLicitacaoConvenio = $fkLicitacaoConvenio;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoConvenio
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\Convenio
     */
    public function getFkLicitacaoConvenio()
    {
        return $this->fkLicitacaoConvenio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoParticipanteCertificacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacao $fkLicitacaoParticipanteCertificacao
     * @return ParticipanteConvenio
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
     * Set fkLicitacaoTipoParticipante
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\TipoParticipante $fkLicitacaoTipoParticipante
     * @return ParticipanteConvenio
     */
    public function setFkLicitacaoTipoParticipante(\Urbem\CoreBundle\Entity\Licitacao\TipoParticipante $fkLicitacaoTipoParticipante)
    {
        $this->codTipoParticipante = $fkLicitacaoTipoParticipante->getCodTipoParticipante();
        $this->fkLicitacaoTipoParticipante = $fkLicitacaoTipoParticipante;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoTipoParticipante
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\TipoParticipante
     */
    public function getFkLicitacaoTipoParticipante()
    {
        return $this->fkLicitacaoTipoParticipante;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (!is_null($this->fkLicitacaoParticipanteCertificacao)) {
            return (string) $this->fkLicitacaoParticipanteCertificacao->getFkSwCgm();
        }

        return 'Participante Convênio';
    }
}
