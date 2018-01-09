<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * Orgao
 */
class Orgao
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
    private $numOrgao;

    /**
     * @var string
     */
    private $nomOrgao;

    /**
     * @var integer
     */
    private $usuarioResponsavel;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcmgo\Orgao
     */
    private $fkTcmgoOrgao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\Unidade
     */
    private $fkOrcamentoUnidades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\DeParaLotacaoOrgao
     */
    private $fkPessoalDeParaLotacaoOrgoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Contrato
     */
    private $fkTcemgContratos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ProjecaoAtuarial
     */
    private $fkTcmgoProjecaoAtuariais;

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
        $this->fkOrcamentoUnidades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalDeParaLotacaoOrgoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgContratos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoProjecaoAtuariais = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Orgao
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
     * Set numOrgao
     *
     * @param integer $numOrgao
     * @return Orgao
     */
    public function setNumOrgao($numOrgao)
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
     * Set nomOrgao
     *
     * @param string $nomOrgao
     * @return Orgao
     */
    public function setNomOrgao($nomOrgao)
    {
        $this->nomOrgao = $nomOrgao;
        return $this;
    }

    /**
     * Get nomOrgao
     *
     * @return string
     */
    public function getNomOrgao()
    {
        return $this->nomOrgao;
    }

    /**
     * Set usuarioResponsavel
     *
     * @param integer $usuarioResponsavel
     * @return Orgao
     */
    public function setUsuarioResponsavel($usuarioResponsavel)
    {
        $this->usuarioResponsavel = $usuarioResponsavel;
        return $this;
    }

    /**
     * Get usuarioResponsavel
     *
     * @return integer
     */
    public function getUsuarioResponsavel()
    {
        return $this->usuarioResponsavel;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoUnidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidade
     * @return Orgao
     */
    public function addFkOrcamentoUnidades(\Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidade)
    {
        if (false === $this->fkOrcamentoUnidades->contains($fkOrcamentoUnidade)) {
            $fkOrcamentoUnidade->setFkOrcamentoOrgao($this);
            $this->fkOrcamentoUnidades->add($fkOrcamentoUnidade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoUnidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidade
     */
    public function removeFkOrcamentoUnidades(\Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidade)
    {
        $this->fkOrcamentoUnidades->removeElement($fkOrcamentoUnidade);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoUnidades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\Unidade
     */
    public function getFkOrcamentoUnidades()
    {
        return $this->fkOrcamentoUnidades;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalDeParaLotacaoOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\DeParaLotacaoOrgao $fkPessoalDeParaLotacaoOrgao
     * @return Orgao
     */
    public function addFkPessoalDeParaLotacaoOrgoes(\Urbem\CoreBundle\Entity\Pessoal\DeParaLotacaoOrgao $fkPessoalDeParaLotacaoOrgao)
    {
        if (false === $this->fkPessoalDeParaLotacaoOrgoes->contains($fkPessoalDeParaLotacaoOrgao)) {
            $fkPessoalDeParaLotacaoOrgao->setFkOrcamentoOrgao($this);
            $this->fkPessoalDeParaLotacaoOrgoes->add($fkPessoalDeParaLotacaoOrgao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalDeParaLotacaoOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\DeParaLotacaoOrgao $fkPessoalDeParaLotacaoOrgao
     */
    public function removeFkPessoalDeParaLotacaoOrgoes(\Urbem\CoreBundle\Entity\Pessoal\DeParaLotacaoOrgao $fkPessoalDeParaLotacaoOrgao)
    {
        $this->fkPessoalDeParaLotacaoOrgoes->removeElement($fkPessoalDeParaLotacaoOrgao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalDeParaLotacaoOrgoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\DeParaLotacaoOrgao
     */
    public function getFkPessoalDeParaLotacaoOrgoes()
    {
        return $this->fkPessoalDeParaLotacaoOrgoes;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgContrato
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Contrato $fkTcemgContrato
     * @return Orgao
     */
    public function addFkTcemgContratos(\Urbem\CoreBundle\Entity\Tcemg\Contrato $fkTcemgContrato)
    {
        if (false === $this->fkTcemgContratos->contains($fkTcemgContrato)) {
            $fkTcemgContrato->setFkOrcamentoOrgao($this);
            $this->fkTcemgContratos->add($fkTcemgContrato);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgContrato
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Contrato $fkTcemgContrato
     */
    public function removeFkTcemgContratos(\Urbem\CoreBundle\Entity\Tcemg\Contrato $fkTcemgContrato)
    {
        $this->fkTcemgContratos->removeElement($fkTcemgContrato);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgContratos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Contrato
     */
    public function getFkTcemgContratos()
    {
        return $this->fkTcemgContratos;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoProjecaoAtuarial
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ProjecaoAtuarial $fkTcmgoProjecaoAtuarial
     * @return Orgao
     */
    public function addFkTcmgoProjecaoAtuariais(\Urbem\CoreBundle\Entity\Tcmgo\ProjecaoAtuarial $fkTcmgoProjecaoAtuarial)
    {
        if (false === $this->fkTcmgoProjecaoAtuariais->contains($fkTcmgoProjecaoAtuarial)) {
            $fkTcmgoProjecaoAtuarial->setFkOrcamentoOrgao($this);
            $this->fkTcmgoProjecaoAtuariais->add($fkTcmgoProjecaoAtuarial);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoProjecaoAtuarial
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ProjecaoAtuarial $fkTcmgoProjecaoAtuarial
     */
    public function removeFkTcmgoProjecaoAtuariais(\Urbem\CoreBundle\Entity\Tcmgo\ProjecaoAtuarial $fkTcmgoProjecaoAtuarial)
    {
        $this->fkTcmgoProjecaoAtuariais->removeElement($fkTcmgoProjecaoAtuarial);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoProjecaoAtuariais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ProjecaoAtuarial
     */
    public function getFkTcmgoProjecaoAtuariais()
    {
        return $this->fkTcmgoProjecaoAtuariais;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return Orgao
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->usuarioResponsavel = $fkSwCgm->getNumcgm();
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
     * OneToOne (inverse side)
     * Set TcmgoOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\Orgao $fkTcmgoOrgao
     * @return Orgao
     */
    public function setFkTcmgoOrgao(\Urbem\CoreBundle\Entity\Tcmgo\Orgao $fkTcmgoOrgao)
    {
        $fkTcmgoOrgao->setFkOrcamentoOrgao($this);
        $this->fkTcmgoOrgao = $fkTcmgoOrgao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcmgoOrgao
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\Orgao
     */
    public function getFkTcmgoOrgao()
    {
        return $this->fkTcmgoOrgao;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->numOrgao, $this->nomOrgao);
    }
}
