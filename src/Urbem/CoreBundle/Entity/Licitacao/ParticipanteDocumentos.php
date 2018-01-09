<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * ParticipanteDocumentos
 */
class ParticipanteDocumentos
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
     * @var string
     */
    private $numDocumento;

    /**
     * @var \DateTime
     */
    private $dtEmissao;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\AtributoParticipanteDocumentosValor
     */
    private $fkLicitacaoAtributoParticipanteDocumentosValores;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\Participante
     */
    private $fkLicitacaoParticipante;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\LicitacaoDocumentos
     */
    private $fkLicitacaoLicitacaoDocumentos;

    /**
     * Constructor
     */
    public function __construct(Participante $participante = null, LicitacaoDocumentos $licitacaoDocumentos = null)
    {
        if (isset($participante)) {
            $this->setFkLicitacaoParticipante($participante);
        }

        if (isset($licitacaoDocumentos)) {
            $this->setFkLicitacaoLicitacaoDocumentos($licitacaoDocumentos);
        }

        $this->fkLicitacaoAtributoParticipanteDocumentosValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dtValidade = new \Urbem\CoreBundle\Helper\DatePK;
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codLicitacao
     *
     * @param integer $codLicitacao
     * @return ParticipanteDocumentos
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
     * @return ParticipanteDocumentos
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
     * @return ParticipanteDocumentos
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
     * @return ParticipanteDocumentos
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
     * @return ParticipanteDocumentos
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
     * @return ParticipanteDocumentos
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
     * @return ParticipanteDocumentos
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
     * Set numDocumento
     *
     * @param string $numDocumento
     * @return ParticipanteDocumentos
     */
    public function setNumDocumento($numDocumento)
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
     * @return ParticipanteDocumentos
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ParticipanteDocumentos
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
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
     * OneToMany (owning side)
     * Add LicitacaoAtributoParticipanteDocumentosValor
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\AtributoParticipanteDocumentosValor $fkLicitacaoAtributoParticipanteDocumentosValor
     * @return ParticipanteDocumentos
     */
    public function addFkLicitacaoAtributoParticipanteDocumentosValores(\Urbem\CoreBundle\Entity\Licitacao\AtributoParticipanteDocumentosValor $fkLicitacaoAtributoParticipanteDocumentosValor)
    {
        if (false === $this->fkLicitacaoAtributoParticipanteDocumentosValores->contains($fkLicitacaoAtributoParticipanteDocumentosValor)) {
            $fkLicitacaoAtributoParticipanteDocumentosValor->setFkLicitacaoParticipanteDocumentos($this);
            $this->fkLicitacaoAtributoParticipanteDocumentosValores->add($fkLicitacaoAtributoParticipanteDocumentosValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoAtributoParticipanteDocumentosValor
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\AtributoParticipanteDocumentosValor $fkLicitacaoAtributoParticipanteDocumentosValor
     */
    public function removeFkLicitacaoAtributoParticipanteDocumentosValores(\Urbem\CoreBundle\Entity\Licitacao\AtributoParticipanteDocumentosValor $fkLicitacaoAtributoParticipanteDocumentosValor)
    {
        $this->fkLicitacaoAtributoParticipanteDocumentosValores->removeElement($fkLicitacaoAtributoParticipanteDocumentosValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoAtributoParticipanteDocumentosValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\AtributoParticipanteDocumentosValor
     */
    public function getFkLicitacaoAtributoParticipanteDocumentosValores()
    {
        return $this->fkLicitacaoAtributoParticipanteDocumentosValores;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoParticipante
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Participante $fkLicitacaoParticipante
     * @return ParticipanteDocumentos
     */
    public function setFkLicitacaoParticipante(\Urbem\CoreBundle\Entity\Licitacao\Participante $fkLicitacaoParticipante)
    {
        $this->codLicitacao = $fkLicitacaoParticipante->getCodLicitacao();
        $this->cgmFornecedor = $fkLicitacaoParticipante->getCgmFornecedor();
        $this->codModalidade = $fkLicitacaoParticipante->getCodModalidade();
        $this->codEntidade = $fkLicitacaoParticipante->getCodEntidade();
        $this->exercicio = $fkLicitacaoParticipante->getExercicio();
        $this->fkLicitacaoParticipante = $fkLicitacaoParticipante;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoParticipante
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\Participante
     */
    public function getFkLicitacaoParticipante()
    {
        return $this->fkLicitacaoParticipante;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoLicitacaoDocumentos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\LicitacaoDocumentos $fkLicitacaoLicitacaoDocumentos
     * @return ParticipanteDocumentos
     */
    public function setFkLicitacaoLicitacaoDocumentos(\Urbem\CoreBundle\Entity\Licitacao\LicitacaoDocumentos $fkLicitacaoLicitacaoDocumentos)
    {
        $this->codDocumento = $fkLicitacaoLicitacaoDocumentos->getCodDocumento();
        $this->codLicitacao = $fkLicitacaoLicitacaoDocumentos->getCodLicitacao();
        $this->codModalidade = $fkLicitacaoLicitacaoDocumentos->getCodModalidade();
        $this->codEntidade = $fkLicitacaoLicitacaoDocumentos->getCodEntidade();
        $this->exercicio = $fkLicitacaoLicitacaoDocumentos->getExercicio();
        $this->fkLicitacaoLicitacaoDocumentos = $fkLicitacaoLicitacaoDocumentos;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoLicitacaoDocumentos
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\LicitacaoDocumentos
     */
    public function getFkLicitacaoLicitacaoDocumentos()
    {
        return $this->fkLicitacaoLicitacaoDocumentos;
    }
}
