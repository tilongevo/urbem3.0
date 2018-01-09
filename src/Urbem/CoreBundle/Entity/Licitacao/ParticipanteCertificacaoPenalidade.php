<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * ParticipanteCertificacaoPenalidade
 */
class ParticipanteCertificacaoPenalidade
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
    private $numCertificacao;

    /**
     * PK
     * @var integer
     */
    private $cgmFornecedor;

    /**
     * @var integer
     */
    private $codTipoDocumento;

    /**
     * @var integer
     */
    private $codDocumento;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacao
     */
    private $fkLicitacaoParticipanteCertificacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\PenalidadesCertificacao
     */
    private $fkLicitacaoPenalidadesCertificacoes;

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
        $this->fkLicitacaoPenalidadesCertificacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ParticipanteCertificacaoPenalidade
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
     * Set numCertificacao
     *
     * @param integer $numCertificacao
     * @return ParticipanteCertificacaoPenalidade
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
     * Set cgmFornecedor
     *
     * @param integer $cgmFornecedor
     * @return ParticipanteCertificacaoPenalidade
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
     * Set codTipoDocumento
     *
     * @param integer $codTipoDocumento
     * @return ParticipanteCertificacaoPenalidade
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
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return ParticipanteCertificacaoPenalidade
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
     * OneToMany (owning side)
     * Add LicitacaoPenalidadesCertificacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\PenalidadesCertificacao $fkLicitacaoPenalidadesCertificacao
     * @return ParticipanteCertificacaoPenalidade
     */
    public function addFkLicitacaoPenalidadesCertificacoes(\Urbem\CoreBundle\Entity\Licitacao\PenalidadesCertificacao $fkLicitacaoPenalidadesCertificacao)
    {
        if (false === $this->fkLicitacaoPenalidadesCertificacoes->contains($fkLicitacaoPenalidadesCertificacao)) {
            $fkLicitacaoPenalidadesCertificacao->setFkLicitacaoParticipanteCertificacaoPenalidade($this);
            $this->fkLicitacaoPenalidadesCertificacoes->add($fkLicitacaoPenalidadesCertificacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoPenalidadesCertificacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\PenalidadesCertificacao $fkLicitacaoPenalidadesCertificacao
     */
    public function removeFkLicitacaoPenalidadesCertificacoes(\Urbem\CoreBundle\Entity\Licitacao\PenalidadesCertificacao $fkLicitacaoPenalidadesCertificacao)
    {
        $this->fkLicitacaoPenalidadesCertificacoes->removeElement($fkLicitacaoPenalidadesCertificacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoPenalidadesCertificacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\PenalidadesCertificacao
     */
    public function getFkLicitacaoPenalidadesCertificacoes()
    {
        return $this->fkLicitacaoPenalidadesCertificacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoModeloDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento
     * @return ParticipanteCertificacaoPenalidade
     */
    public function setFkAdministracaoModeloDocumento(\Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento)
    {
        $this->codDocumento = $fkAdministracaoModeloDocumento->getCodDocumento();
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
     * OneToOne (owning side)
     * Set LicitacaoParticipanteCertificacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacao $fkLicitacaoParticipanteCertificacao
     * @return ParticipanteCertificacaoPenalidade
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
     * OneToOne (owning side)
     * Get fkLicitacaoParticipanteCertificacao
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacao
     */
    public function getFkLicitacaoParticipanteCertificacao()
    {
        return $this->fkLicitacaoParticipanteCertificacao;
    }
}
