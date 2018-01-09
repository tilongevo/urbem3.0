<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

use Doctrine\Common\Collections\Collection;

/**
 * Participante
 */
class Participante
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
     * @var integer
     */
    private $numcgmRepresentante;

    /**
     * @var \DateTime
     */
    private $dtInclusao;

    /**
     * @var boolean
     */
    private $renunciaRecurso = true;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ParticipanteDocumentos
     */
    private $fkLicitacaoParticipanteDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ParticipanteConsorcio
     */
    private $fkLicitacaoParticipanteConsorcios;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\Licitacao
     */
    private $fkLicitacaoLicitacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\Fornecedor
     */
    private $fkComprasFornecedor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkLicitacaoParticipanteDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoParticipanteConsorcios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dtInclusao = new \DateTime;
    }

    /**
     * Set codLicitacao
     *
     * @param integer $codLicitacao
     * @return Participante
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
     * Set cgmFornecedor
     *
     * @param integer $cgmFornecedor
     * @return Participante
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
     * @return Participante
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
     * @return Participante
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
     * @return Participante
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
     * Set numcgmRepresentante
     *
     * @param integer $numcgmRepresentante
     * @return Participante
     */
    public function setNumcgmRepresentante($numcgmRepresentante)
    {
        $this->numcgmRepresentante = $numcgmRepresentante;
        return $this;
    }

    /**
     * Get numcgmRepresentante
     *
     * @return integer
     */
    public function getNumcgmRepresentante()
    {
        return $this->numcgmRepresentante;
    }

    /**
     * Set dtInclusao
     *
     * @param \DateTime $dtInclusao
     * @return Participante
     */
    public function setDtInclusao(\DateTime $dtInclusao)
    {
        $this->dtInclusao = $dtInclusao;
        return $this;
    }

    /**
     * Get dtInclusao
     *
     * @return \DateTime
     */
    public function getDtInclusao()
    {
        return $this->dtInclusao;
    }

    /**
     * Set renunciaRecurso
     *
     * @param boolean $renunciaRecurso
     * @return Participante
     */
    public function setRenunciaRecurso($renunciaRecurso)
    {
        $this->renunciaRecurso = $renunciaRecurso;
        return $this;
    }

    /**
     * Get renunciaRecurso
     *
     * @return boolean
     */
    public function getRenunciaRecurso()
    {
        return $this->renunciaRecurso;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoParticipanteDocumentos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ParticipanteDocumentos $fkLicitacaoParticipanteDocumentos
     * @return Participante
     */
    public function addFkLicitacaoParticipanteDocumentos(ParticipanteDocumentos $fkLicitacaoParticipanteDocumentos)
    {
        if (false === $this->fkLicitacaoParticipanteDocumentos->contains($fkLicitacaoParticipanteDocumentos)) {
            $fkLicitacaoParticipanteDocumentos->setFkLicitacaoParticipante($this);
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
    public function removeFkLicitacaoParticipanteDocumentos(ParticipanteDocumentos $fkLicitacaoParticipanteDocumentos)
    {
        $this->fkLicitacaoParticipanteDocumentos->removeElement($fkLicitacaoParticipanteDocumentos);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoParticipanteDocumentos
     *
     * @return Collection|ParticipanteDocumentos
     */
    public function getFkLicitacaoParticipanteDocumentos()
    {
        return $this->fkLicitacaoParticipanteDocumentos;
    }

    /**
     * @param Collection $fkLicitacaoParticipanteDocumentos
     * @return $this
     */
    public function setFkLicitacaoParticipanteDocumentos(Collection $fkLicitacaoParticipanteDocumentos)
    {
        $this->fkLicitacaoParticipanteDocumentos = $fkLicitacaoParticipanteDocumentos;
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoParticipanteConsorcio
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ParticipanteConsorcio $fkLicitacaoParticipanteConsorcio
     * @return Participante
     */
    public function addFkLicitacaoParticipanteConsorcios(\Urbem\CoreBundle\Entity\Licitacao\ParticipanteConsorcio $fkLicitacaoParticipanteConsorcio)
    {
        if (false === $this->fkLicitacaoParticipanteConsorcios->contains($fkLicitacaoParticipanteConsorcio)) {
            $fkLicitacaoParticipanteConsorcio->setFkLicitacaoParticipante($this);
            $this->fkLicitacaoParticipanteConsorcios->add($fkLicitacaoParticipanteConsorcio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoParticipanteConsorcio
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ParticipanteConsorcio $fkLicitacaoParticipanteConsorcio
     */
    public function removeFkLicitacaoParticipanteConsorcios(\Urbem\CoreBundle\Entity\Licitacao\ParticipanteConsorcio $fkLicitacaoParticipanteConsorcio)
    {
        $this->fkLicitacaoParticipanteConsorcios->removeElement($fkLicitacaoParticipanteConsorcio);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoParticipanteConsorcios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ParticipanteConsorcio
     */
    public function getFkLicitacaoParticipanteConsorcios()
    {
        return $this->fkLicitacaoParticipanteConsorcios;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao
     * @return Participante
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
     * ManyToOne (inverse side)
     * Set fkComprasFornecedor
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Fornecedor $fkComprasFornecedor
     * @return Participante
     */
    public function setFkComprasFornecedor(\Urbem\CoreBundle\Entity\Compras\Fornecedor $fkComprasFornecedor)
    {
        $this->cgmFornecedor = $fkComprasFornecedor->getCgmFornecedor();
        $this->fkComprasFornecedor = $fkComprasFornecedor;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasFornecedor
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Fornecedor
     */
    public function getFkComprasFornecedor()
    {
        return $this->fkComprasFornecedor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return Participante
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgmRepresentante = $fkSwCgm->getNumcgm();
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
     * @return string
     */
    public function __toString()
    {
        return (string) $this->fkSwCgm;
    }
}
