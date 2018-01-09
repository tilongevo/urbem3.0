<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * ParticipanteCertificacao
 */
class ParticipanteCertificacao
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
     * @var \DateTime
     */
    private $dtRegistro;

    /**
     * @var \DateTime
     */
    private $finalVigencia;

    /**
     * @var string
     */
    private $observacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacaoPenalidade
     */
    private $fkLicitacaoParticipanteCertificacaoPenalidade;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\CertificacaoDocumentos
     */
    private $fkLicitacaoCertificacaoDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacaoLicitacao
     */
    private $fkLicitacaoParticipanteCertificacaoLicitacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ParticipanteConvenio
     */
    private $fkLicitacaoParticipanteConvenios;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento
     */
    private $fkAdministracaoModeloDocumento;

    /**
     * Propriedade criada para aplicar a regra de negócio dessa amarração
     * @var ParticipanteCertificacaoLicitacao $licitacao
     */
    private $participanteCertificacaoLicitacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkLicitacaoCertificacaoDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoParticipanteCertificacaoLicitacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoParticipanteConvenios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dtRegistro = new \DateTime;

        /* Forçado o valor zerado, como no sistema antigo. Essas colunas, possivelmente, são legado. */
        $this->codDocumento = 0;
        $this->codTipoDocumento = 0;
    }

    /**
     * Set numCertificacao
     *
     * @param integer $numCertificacao
     * @return ParticipanteCertificacao
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
     * @return ParticipanteCertificacao
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
     * @return ParticipanteCertificacao
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
     * @return ParticipanteCertificacao
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
     * @return ParticipanteCertificacao
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
     * Set dtRegistro
     *
     * @param \DateTime $dtRegistro
     * @return ParticipanteCertificacao
     */
    public function setDtRegistro(\DateTime $dtRegistro)
    {
        $this->dtRegistro = $dtRegistro;
        return $this;
    }

    /**
     * Get dtRegistro
     *
     * @return \DateTime
     */
    public function getDtRegistro()
    {
        return $this->dtRegistro;
    }

    /**
     * Set finalVigencia
     *
     * @param \DateTime $finalVigencia
     * @return ParticipanteCertificacao
     */
    public function setFinalVigencia(\DateTime $finalVigencia = null)
    {
        $this->finalVigencia = $finalVigencia;
        return $this;
    }

    /**
     * Get finalVigencia
     *
     * @return \DateTime
     */
    public function getFinalVigencia()
    {
        return $this->finalVigencia;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return ParticipanteCertificacao
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
     * OneToMany (owning side)
     * Add LicitacaoCertificacaoDocumentos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\CertificacaoDocumentos $fkLicitacaoCertificacaoDocumentos
     * @return ParticipanteCertificacao
     */
    public function addFkLicitacaoCertificacaoDocumentos(\Urbem\CoreBundle\Entity\Licitacao\CertificacaoDocumentos $fkLicitacaoCertificacaoDocumentos)
    {
        if (false === $this->fkLicitacaoCertificacaoDocumentos->contains($fkLicitacaoCertificacaoDocumentos)) {
            $fkLicitacaoCertificacaoDocumentos->setFkLicitacaoParticipanteCertificacao($this);
            $this->fkLicitacaoCertificacaoDocumentos->add($fkLicitacaoCertificacaoDocumentos);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoCertificacaoDocumentos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\CertificacaoDocumentos $fkLicitacaoCertificacaoDocumentos
     */
    public function removeFkLicitacaoCertificacaoDocumentos(\Urbem\CoreBundle\Entity\Licitacao\CertificacaoDocumentos $fkLicitacaoCertificacaoDocumentos)
    {
        $this->fkLicitacaoCertificacaoDocumentos->removeElement($fkLicitacaoCertificacaoDocumentos);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoCertificacaoDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\CertificacaoDocumentos
     */
    public function getFkLicitacaoCertificacaoDocumentos()
    {
        return $this->fkLicitacaoCertificacaoDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoParticipanteCertificacaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacaoLicitacao $fkLicitacaoParticipanteCertificacaoLicitacao
     * @return ParticipanteCertificacao
     */
    public function addFkLicitacaoParticipanteCertificacaoLicitacoes(\Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacaoLicitacao $fkLicitacaoParticipanteCertificacaoLicitacao)
    {
        if (false === $this->fkLicitacaoParticipanteCertificacaoLicitacoes->contains($fkLicitacaoParticipanteCertificacaoLicitacao)) {
            $fkLicitacaoParticipanteCertificacaoLicitacao->setFkLicitacaoParticipanteCertificacao($this);
            $this->fkLicitacaoParticipanteCertificacaoLicitacoes->add($fkLicitacaoParticipanteCertificacaoLicitacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoParticipanteCertificacaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacaoLicitacao $fkLicitacaoParticipanteCertificacaoLicitacao
     */
    public function removeFkLicitacaoParticipanteCertificacaoLicitacoes(\Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacaoLicitacao $fkLicitacaoParticipanteCertificacaoLicitacao)
    {
        $this->fkLicitacaoParticipanteCertificacaoLicitacoes->removeElement($fkLicitacaoParticipanteCertificacaoLicitacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoParticipanteCertificacaoLicitacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacaoLicitacao
     */
    public function getFkLicitacaoParticipanteCertificacaoLicitacoes()
    {
        return $this->fkLicitacaoParticipanteCertificacaoLicitacoes;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoParticipanteConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ParticipanteConvenio $fkLicitacaoParticipanteConvenio
     * @return ParticipanteCertificacao
     */
    public function addFkLicitacaoParticipanteConvenios(\Urbem\CoreBundle\Entity\Licitacao\ParticipanteConvenio $fkLicitacaoParticipanteConvenio)
    {
        if (false === $this->fkLicitacaoParticipanteConvenios->contains($fkLicitacaoParticipanteConvenio)) {
            $fkLicitacaoParticipanteConvenio->setFkLicitacaoParticipanteCertificacao($this);
            $this->fkLicitacaoParticipanteConvenios->add($fkLicitacaoParticipanteConvenio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoParticipanteConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ParticipanteConvenio $fkLicitacaoParticipanteConvenio
     */
    public function removeFkLicitacaoParticipanteConvenios(\Urbem\CoreBundle\Entity\Licitacao\ParticipanteConvenio $fkLicitacaoParticipanteConvenio)
    {
        $this->fkLicitacaoParticipanteConvenios->removeElement($fkLicitacaoParticipanteConvenio);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoParticipanteConvenios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ParticipanteConvenio
     */
    public function getFkLicitacaoParticipanteConvenios()
    {
        return $this->fkLicitacaoParticipanteConvenios;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return ParticipanteCertificacao
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->cgmFornecedor = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoModeloDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento
     * @return ParticipanteCertificacao
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
     * OneToOne (inverse side)
     * Set LicitacaoParticipanteCertificacaoPenalidade
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacaoPenalidade $fkLicitacaoParticipanteCertificacaoPenalidade
     * @return ParticipanteCertificacao
     */
    public function setFkLicitacaoParticipanteCertificacaoPenalidade(\Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacaoPenalidade $fkLicitacaoParticipanteCertificacaoPenalidade)
    {
        $fkLicitacaoParticipanteCertificacaoPenalidade->setFkLicitacaoParticipanteCertificacao($this);
        $this->fkLicitacaoParticipanteCertificacaoPenalidade = $fkLicitacaoParticipanteCertificacaoPenalidade;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkLicitacaoParticipanteCertificacaoPenalidade
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacaoPenalidade
     */
    public function getFkLicitacaoParticipanteCertificacaoPenalidade()
    {
        return $this->fkLicitacaoParticipanteCertificacaoPenalidade;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '%s/%s - %s',
            $this->numCertificacao,
            $this->exercicio,
            $this->fkSwCgm
        );
    }

    /**
     * @return ParticipanteCertificacaoLicitacao
     */
    public function getParticipanteCertificacaoLicitacao()
    {
        return $this->fkLicitacaoParticipanteCertificacaoLicitacoes->last();
    }
}
