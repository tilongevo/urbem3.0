<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * RegistroPrecosOrgao
 */
class RegistroPrecosOrgao
{
    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $numeroRegistroPrecos;

    /**
     * PK
     * @var string
     */
    private $exercicioRegistroPrecos;

    /**
     * PK
     * @var boolean
     */
    private $interno;

    /**
     * PK
     * @var integer
     */
    private $numcgmGerenciador;

    /**
     * PK
     * @var string
     */
    private $exercicioUnidade;

    /**
     * PK
     * @var integer
     */
    private $numUnidade;

    /**
     * PK
     * @var integer
     */
    private $numOrgao;

    /**
     * @var boolean
     */
    private $participante = true;

    /**
     * @var string
     */
    private $numeroProcessoAdesao;

    /**
     * @var string
     */
    private $exercicioAdesao;

    /**
     * @var \DateTime
     */
    private $dtPublicacaoAvisoIntencao;

    /**
     * @var \DateTime
     */
    private $dtAdesao;

    /**
     * @var boolean
     */
    private $gerenciador = false;

    /**
     * @var integer
     */
    private $cgmAprovacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosOrgaoItem
     */
    private $fkTcemgRegistroPrecosOrgaoItens;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcemg\RegistroPrecos
     */
    private $fkTcemgRegistroPrecos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Unidade
     */
    private $fkOrcamentoUnidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    private $fkSwCgmPessoaFisica;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcemgRegistroPrecosOrgaoItens = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return RegistroPrecosOrgao
     */
    public function setCodEntidade($codEntidade = null)
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
     * Set numeroRegistroPrecos
     *
     * @param integer $numeroRegistroPrecos
     * @return RegistroPrecosOrgao
     */
    public function setNumeroRegistroPrecos($numeroRegistroPrecos = null)
    {
        $this->numeroRegistroPrecos = $numeroRegistroPrecos;
        return $this;
    }

    /**
     * Get numeroRegistroPrecos
     *
     * @return integer
     */
    public function getNumeroRegistroPrecos()
    {
        return $this->numeroRegistroPrecos;
    }

    /**
     * Set exercicioRegistroPrecos
     *
     * @param string $exercicioRegistroPrecos
     * @return RegistroPrecosOrgao
     */
    public function setExercicioRegistroPrecos($exercicioRegistroPrecos = null)
    {
        $this->exercicioRegistroPrecos = $exercicioRegistroPrecos;
        return $this;
    }

    /**
     * Get exercicioRegistroPrecos
     *
     * @return string
     */
    public function getExercicioRegistroPrecos()
    {
        return $this->exercicioRegistroPrecos;
    }

    /**
     * Set interno
     *
     * @param boolean $interno
     * @return RegistroPrecosOrgao
     */
    public function setInterno($interno = null)
    {
        $this->interno = $interno;
        return $this;
    }

    /**
     * Get interno
     *
     * @return boolean
     */
    public function getInterno()
    {
        return $this->interno;
    }

    /**
     * Set numcgmGerenciador
     *
     * @param integer $numcgmGerenciador
     * @return RegistroPrecosOrgao
     */
    public function setNumcgmGerenciador($numcgmGerenciador = null)
    {
        $this->numcgmGerenciador = $numcgmGerenciador;
        return $this;
    }

    /**
     * Get numcgmGerenciador
     *
     * @return integer
     */
    public function getNumcgmGerenciador()
    {
        return $this->numcgmGerenciador;
    }

    /**
     * Set exercicioUnidade
     *
     * @param string $exercicioUnidade
     * @return RegistroPrecosOrgao
     */
    public function setExercicioUnidade($exercicioUnidade = null)
    {
        $this->exercicioUnidade = $exercicioUnidade;
        return $this;
    }

    /**
     * Get exercicioUnidade
     *
     * @return string
     */
    public function getExercicioUnidade()
    {
        return $this->exercicioUnidade;
    }

    /**
     * Set numUnidade
     *
     * @param integer $numUnidade
     * @return RegistroPrecosOrgao
     */
    public function setNumUnidade($numUnidade = null)
    {
        $this->numUnidade = $numUnidade;
        return $this;
    }

    /**
     * Get numUnidade
     *
     * @return integer
     */
    public function getNumUnidade()
    {
        return $this->numUnidade;
    }

    /**
     * Set numOrgao
     *
     * @param integer $numOrgao
     * @return RegistroPrecosOrgao
     */
    public function setNumOrgao($numOrgao = null)
    {
        $this->numOrgao = $numOrgao;
        return $this;
    }

    /**
     * Get numOrgao
     *
     * @return integer
     */
    public function getNumOrgao()
    {
        return $this->numOrgao;
    }

    /**
     * Set participante
     *
     * @param boolean $participante
     * @return RegistroPrecosOrgao
     */
    public function setParticipante($participante = null)
    {
        $this->participante = $participante;
        return $this;
    }

    /**
     * Get participante
     *
     * @return boolean
     */
    public function getParticipante()
    {
        return $this->participante;
    }

    /**
     * Set numeroProcessoAdesao
     *
     * @param string $numeroProcessoAdesao
     * @return RegistroPrecosOrgao
     */
    public function setNumeroProcessoAdesao($numeroProcessoAdesao = null)
    {
        $this->numeroProcessoAdesao = $numeroProcessoAdesao;
        return $this;
    }

    /**
     * Get numeroProcessoAdesao
     *
     * @return string
     */
    public function getNumeroProcessoAdesao()
    {
        return $this->numeroProcessoAdesao;
    }

    /**
     * Set exercicioAdesao
     *
     * @param string $exercicioAdesao
     * @return RegistroPrecosOrgao
     */
    public function setExercicioAdesao($exercicioAdesao = null)
    {
        $this->exercicioAdesao = $exercicioAdesao;
        return $this;
    }

    /**
     * Get exercicioAdesao
     *
     * @return string
     */
    public function getExercicioAdesao()
    {
        return $this->exercicioAdesao;
    }

    /**
     * Set dtPublicacaoAvisoIntencao
     *
     * @param \DateTime $dtPublicacaoAvisoIntencao
     * @return RegistroPrecosOrgao
     */
    public function setDtPublicacaoAvisoIntencao(\DateTime $dtPublicacaoAvisoIntencao = null)
    {
        $this->dtPublicacaoAvisoIntencao = $dtPublicacaoAvisoIntencao;
        return $this;
    }

    /**
     * Get dtPublicacaoAvisoIntencao
     *
     * @return \DateTime
     */
    public function getDtPublicacaoAvisoIntencao()
    {
        return $this->dtPublicacaoAvisoIntencao;
    }

    /**
     * Set dtAdesao
     *
     * @param \DateTime $dtAdesao
     * @return RegistroPrecosOrgao
     */
    public function setDtAdesao(\DateTime $dtAdesao = null)
    {
        $this->dtAdesao = $dtAdesao;
        return $this;
    }

    /**
     * Get dtAdesao
     *
     * @return \DateTime
     */
    public function getDtAdesao()
    {
        return $this->dtAdesao;
    }

    /**
     * Set gerenciador
     *
     * @param boolean $gerenciador
     * @return RegistroPrecosOrgao
     */
    public function setGerenciador($gerenciador = null)
    {
        $this->gerenciador = $gerenciador;
        return $this;
    }

    /**
     * Get gerenciador
     *
     * @return boolean
     */
    public function getGerenciador()
    {
        return $this->gerenciador;
    }

    /**
     * Set cgmAprovacao
     *
     * @param integer $cgmAprovacao
     * @return RegistroPrecosOrgao
     */
    public function setCgmAprovacao($cgmAprovacao = null)
    {
        $this->cgmAprovacao = $cgmAprovacao;
        return $this;
    }

    /**
     * Get cgmAprovacao
     *
     * @return integer
     */
    public function getCgmAprovacao()
    {
        return $this->cgmAprovacao;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgRegistroPrecosOrgaoItem
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosOrgaoItem $fkTcemgRegistroPrecosOrgaoItem
     * @return RegistroPrecosOrgao
     */
    public function addFkTcemgRegistroPrecosOrgaoItens(\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosOrgaoItem $fkTcemgRegistroPrecosOrgaoItem)
    {
        if (false === $this->fkTcemgRegistroPrecosOrgaoItens->contains($fkTcemgRegistroPrecosOrgaoItem)) {
            $fkTcemgRegistroPrecosOrgaoItem->setFkTcemgRegistroPrecosOrgao($this);
            $this->fkTcemgRegistroPrecosOrgaoItens->add($fkTcemgRegistroPrecosOrgaoItem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgRegistroPrecosOrgaoItem
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosOrgaoItem $fkTcemgRegistroPrecosOrgaoItem
     */
    public function removeFkTcemgRegistroPrecosOrgaoItens(\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosOrgaoItem $fkTcemgRegistroPrecosOrgaoItem)
    {
        $this->fkTcemgRegistroPrecosOrgaoItens->removeElement($fkTcemgRegistroPrecosOrgaoItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgRegistroPrecosOrgaoItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosOrgaoItem
     */
    public function getFkTcemgRegistroPrecosOrgaoItens()
    {
        return $this->fkTcemgRegistroPrecosOrgaoItens;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcemgRegistroPrecos
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\RegistroPrecos $fkTcemgRegistroPrecos
     * @return RegistroPrecosOrgao
     */
    public function setFkTcemgRegistroPrecos(\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecos $fkTcemgRegistroPrecos)
    {
        $this->codEntidade = $fkTcemgRegistroPrecos->getCodEntidade();
        $this->numeroRegistroPrecos = $fkTcemgRegistroPrecos->getNumeroRegistroPrecos();
        $this->exercicioRegistroPrecos = $fkTcemgRegistroPrecos->getExercicio();
        $this->numcgmGerenciador = $fkTcemgRegistroPrecos->getNumcgmGerenciador();
        $this->interno = $fkTcemgRegistroPrecos->getInterno();
        $this->fkTcemgRegistroPrecos = $fkTcemgRegistroPrecos;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgRegistroPrecos
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\RegistroPrecos
     */
    public function getFkTcemgRegistroPrecos()
    {
        return $this->fkTcemgRegistroPrecos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoUnidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidade
     * @return RegistroPrecosOrgao
     */
    public function setFkOrcamentoUnidade(\Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidade)
    {
        $this->exercicioUnidade = $fkOrcamentoUnidade->getExercicio();
        $this->numUnidade = $fkOrcamentoUnidade->getNumUnidade();
        $this->numOrgao = $fkOrcamentoUnidade->getNumOrgao();
        $this->fkOrcamentoUnidade = $fkOrcamentoUnidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoUnidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Unidade
     */
    public function getFkOrcamentoUnidade()
    {
        return $this->fkOrcamentoUnidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgmPessoaFisica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica
     * @return RegistroPrecosOrgao
     */
    public function setFkSwCgmPessoaFisica(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica)
    {
        $this->cgmAprovacao = $fkSwCgmPessoaFisica->getNumcgm();
        $this->fkSwCgmPessoaFisica = $fkSwCgmPessoaFisica;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgmPessoaFisica
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    public function getFkSwCgmPessoaFisica()
    {
        return $this->fkSwCgmPessoaFisica;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->fkOrcamentoUnidade;
    }
}
