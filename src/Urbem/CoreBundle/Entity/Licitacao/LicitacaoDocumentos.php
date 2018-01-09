<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * LicitacaoDocumentos
 */
class LicitacaoDocumentos
{
    /**
     * PK
     * @var integer
     */
    private $codDocumento;

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
    private $exercicio;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ParticipanteDocumentos
     */
    private $fkLicitacaoParticipanteDocumentos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\Documento
     */
    private $fkLicitacaoDocumento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\Licitacao
     */
    private $fkLicitacaoLicitacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkLicitacaoParticipanteDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return LicitacaoDocumentos
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
     * Set codLicitacao
     *
     * @param integer $codLicitacao
     * @return LicitacaoDocumentos
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
     * @return LicitacaoDocumentos
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
     * @return LicitacaoDocumentos
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
     * @return LicitacaoDocumentos
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
     * OneToMany (owning side)
     * Add LicitacaoParticipanteDocumentos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ParticipanteDocumentos $fkLicitacaoParticipanteDocumentos
     * @return LicitacaoDocumentos
     */
    public function addFkLicitacaoParticipanteDocumentos(\Urbem\CoreBundle\Entity\Licitacao\ParticipanteDocumentos $fkLicitacaoParticipanteDocumentos)
    {
        if (false === $this->fkLicitacaoParticipanteDocumentos->contains($fkLicitacaoParticipanteDocumentos)) {
            $fkLicitacaoParticipanteDocumentos->setFkLicitacaoLicitacaoDocumentos($this);
            $this->fkLicitacaoParticipanteDocumentos->add($fkLicitacaoParticipanteDocumentos);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoParticipanteDocumentos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ParticipanteDocumentos $fkLicitacaoParticipanteDocumentos
     */
    public function removeFkLicitacaoParticipanteDocumentos(\Urbem\CoreBundle\Entity\Licitacao\ParticipanteDocumentos $fkLicitacaoParticipanteDocumentos)
    {
        $this->fkLicitacaoParticipanteDocumentos->removeElement($fkLicitacaoParticipanteDocumentos);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoParticipanteDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ParticipanteDocumentos
     */
    public function getFkLicitacaoParticipanteDocumentos()
    {
        return $this->fkLicitacaoParticipanteDocumentos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Documento $fkLicitacaoDocumento
     * @return LicitacaoDocumentos
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
     * ManyToOne (inverse side)
     * Set fkLicitacaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao
     * @return LicitacaoDocumentos
     */
    public function setFkLicitacaoLicitacao(\Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao)
    {
        $this->codLicitacao = $fkLicitacaoLicitacao->getCodLicitacao();
        $this->codModalidade = $fkLicitacaoLicitacao->getCodModalidade();
        $this->codEntidade = $fkLicitacaoLicitacao->getCodEntidade();
        $this->exercicio = $fkLicitacaoLicitacao->getExercicio();
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

    /**
     * @return string
     */
    public function __toString()
    {
        return "{$this->fkLicitacaoDocumento}";
    }
}
