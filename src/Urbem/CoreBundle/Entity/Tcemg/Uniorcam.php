<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * Uniorcam
 */
class Uniorcam
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
    private $numUnidade;

    /**
     * PK
     * @var integer
     */
    private $numOrgao;

    /**
     * @var integer
     */
    private $identificador;

    /**
     * @var integer
     */
    private $cgmOrdenador;

    /**
     * @var string
     */
    private $exercicioAtual;

    /**
     * @var integer
     */
    private $numOrgaoAtual;

    /**
     * @var integer
     */
    private $numUnidadeAtual;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ArquivoIuoc
     */
    private $fkTcemgArquivoIuocs;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\CronogramaExecucaoMensalDesembolso
     */
    private $fkTcemgCronogramaExecucaoMensalDesembolsos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ArquivoUoc
     */
    private $fkTcemgArquivoUocs;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Unidade
     */
    private $fkOrcamentoUnidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Unidade
     */
    private $fkOrcamentoUnidadeAtual;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Orgao
     */
    private $fkOrcamentoOrgao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Orgao
     */
    private $fkOrcamentoOrgaoAtual;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcemgArquivoIuocs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgCronogramaExecucaoMensalDesembolsos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgArquivoUocs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Uniorcam
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
     * Set numUnidade
     *
     * @param integer $numUnidade
     * @return Uniorcam
     */
    public function setNumUnidade($numUnidade)
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
     * @return Uniorcam
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
     * Set identificador
     *
     * @param integer $identificador
     * @return Uniorcam
     */
    public function setIdentificador($identificador)
    {
        $this->identificador = $identificador;
        return $this;
    }

    /**
     * Get identificador
     *
     * @return integer
     */
    public function getIdentificador()
    {
        return $this->identificador;
    }

    /**
     * Set cgmOrdenador
     *
     * @param integer $cgmOrdenador
     * @return Uniorcam
     */
    public function setCgmOrdenador($cgmOrdenador = null)
    {
        $this->cgmOrdenador = $cgmOrdenador;
        return $this;
    }

    /**
     * Get cgmOrdenador
     *
     * @return integer
     */
    public function getCgmOrdenador()
    {
        return $this->cgmOrdenador;
    }

    /**
     * Set exercicioAtual
     *
     * @param string $exercicioAtual
     * @return Uniorcam
     */
    public function setExercicioAtual($exercicioAtual = null)
    {
        $this->exercicioAtual = $exercicioAtual;
        return $this;
    }

    /**
     * Get exercicioAtual
     *
     * @return string
     */
    public function getExercicioAtual()
    {
        return $this->exercicioAtual;
    }

    /**
     * Set numOrgaoAtual
     *
     * @param integer $numOrgaoAtual
     * @return Uniorcam
     */
    public function setNumOrgaoAtual($numOrgaoAtual = null)
    {
        $this->numOrgaoAtual = $numOrgaoAtual;
        return $this;
    }

    /**
     * Get numOrgaoAtual
     *
     * @return integer
     */
    public function getNumOrgaoAtual()
    {
        return $this->numOrgaoAtual;
    }

    /**
     * Set numUnidadeAtual
     *
     * @param integer $numUnidadeAtual
     * @return Uniorcam
     */
    public function setNumUnidadeAtual($numUnidadeAtual = null)
    {
        $this->numUnidadeAtual = $numUnidadeAtual;
        return $this;
    }

    /**
     * Get numUnidadeAtual
     *
     * @return integer
     */
    public function getNumUnidadeAtual()
    {
        return $this->numUnidadeAtual;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgArquivoIuoc
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ArquivoIuoc $fkTcemgArquivoIuoc
     * @return Uniorcam
     */
    public function addFkTcemgArquivoIuocs(\Urbem\CoreBundle\Entity\Tcemg\ArquivoIuoc $fkTcemgArquivoIuoc)
    {
        if (false === $this->fkTcemgArquivoIuocs->contains($fkTcemgArquivoIuoc)) {
            $fkTcemgArquivoIuoc->setFkTcemgUniorcam($this);
            $this->fkTcemgArquivoIuocs->add($fkTcemgArquivoIuoc);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgArquivoIuoc
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ArquivoIuoc $fkTcemgArquivoIuoc
     */
    public function removeFkTcemgArquivoIuocs(\Urbem\CoreBundle\Entity\Tcemg\ArquivoIuoc $fkTcemgArquivoIuoc)
    {
        $this->fkTcemgArquivoIuocs->removeElement($fkTcemgArquivoIuoc);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgArquivoIuocs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ArquivoIuoc
     */
    public function getFkTcemgArquivoIuocs()
    {
        return $this->fkTcemgArquivoIuocs;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgCronogramaExecucaoMensalDesembolso
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\CronogramaExecucaoMensalDesembolso $fkTcemgCronogramaExecucaoMensalDesembolso
     * @return Uniorcam
     */
    public function addFkTcemgCronogramaExecucaoMensalDesembolsos(\Urbem\CoreBundle\Entity\Tcemg\CronogramaExecucaoMensalDesembolso $fkTcemgCronogramaExecucaoMensalDesembolso)
    {
        if (false === $this->fkTcemgCronogramaExecucaoMensalDesembolsos->contains($fkTcemgCronogramaExecucaoMensalDesembolso)) {
            $fkTcemgCronogramaExecucaoMensalDesembolso->setFkTcemgUniorcam($this);
            $this->fkTcemgCronogramaExecucaoMensalDesembolsos->add($fkTcemgCronogramaExecucaoMensalDesembolso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgCronogramaExecucaoMensalDesembolso
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\CronogramaExecucaoMensalDesembolso $fkTcemgCronogramaExecucaoMensalDesembolso
     */
    public function removeFkTcemgCronogramaExecucaoMensalDesembolsos(\Urbem\CoreBundle\Entity\Tcemg\CronogramaExecucaoMensalDesembolso $fkTcemgCronogramaExecucaoMensalDesembolso)
    {
        $this->fkTcemgCronogramaExecucaoMensalDesembolsos->removeElement($fkTcemgCronogramaExecucaoMensalDesembolso);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgCronogramaExecucaoMensalDesembolsos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\CronogramaExecucaoMensalDesembolso
     */
    public function getFkTcemgCronogramaExecucaoMensalDesembolsos()
    {
        return $this->fkTcemgCronogramaExecucaoMensalDesembolsos;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgArquivoUoc
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ArquivoUoc $fkTcemgArquivoUoc
     * @return Uniorcam
     */
    public function addFkTcemgArquivoUocs(\Urbem\CoreBundle\Entity\Tcemg\ArquivoUoc $fkTcemgArquivoUoc)
    {
        if (false === $this->fkTcemgArquivoUocs->contains($fkTcemgArquivoUoc)) {
            $fkTcemgArquivoUoc->setFkTcemgUniorcam($this);
            $this->fkTcemgArquivoUocs->add($fkTcemgArquivoUoc);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgArquivoUoc
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ArquivoUoc $fkTcemgArquivoUoc
     */
    public function removeFkTcemgArquivoUocs(\Urbem\CoreBundle\Entity\Tcemg\ArquivoUoc $fkTcemgArquivoUoc)
    {
        $this->fkTcemgArquivoUocs->removeElement($fkTcemgArquivoUoc);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgArquivoUocs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ArquivoUoc
     */
    public function getFkTcemgArquivoUocs()
    {
        return $this->fkTcemgArquivoUocs;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return Uniorcam
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->cgmOrdenador = $fkSwCgm->getNumcgm();
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
     * Set fkOrcamentoUnidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidade
     * @return Uniorcam
     */
    public function setFkOrcamentoUnidade(\Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidade)
    {
        $this->exercicio = $fkOrcamentoUnidade->getExercicio();
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
     * Set fkOrcamentoUnidadeAtual
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidade
     * @return Uniorcam
     */
    public function setFkOrcamentoUnidadeAtual(\Urbem\CoreBundle\Entity\Orcamento\Unidade $fkOrcamentoUnidadeAtual)
    {
        $this->exercicioAtual = $fkOrcamentoUnidadeAtual->getExercicio();
        $this->numUnidadeAtual = $fkOrcamentoUnidadeAtual->getNumUnidade();
        $this->numOrgaoAtual = $fkOrcamentoUnidadeAtual->getNumOrgao();
        $this->fkOrcamentoUnidadeAtual = $fkOrcamentoUnidadeAtual;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoUnidadeAtual
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Unidade
     */
    public function getFkOrcamentoUnidadeAtual()
    {
        return $this->fkOrcamentoUnidadeAtual;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Orgao $fkOrcamentoOrgao
     * @return Uniorcam
     */
    public function setFkOrcamentoOrgao(\Urbem\CoreBundle\Entity\Orcamento\Orgao $fkOrcamentoOrgao)
    {
        $this->exercicio = $fkOrcamentoOrgao->getExercicio();
        $this->numOrgao = $fkOrcamentoOrgao->getNumOrgao();
        $this->fkOrcamentoOrgao = $fkOrcamentoOrgao;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoOrgao
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Orgao
     */
    public function getFkOrcamentoOrgao()
    {
        return $this->fkOrcamentoOrgao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoOrgaoAtual
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Orgao $fkOrcamentoOrgao
     * @return Uniorcam
     */
    public function setFkOrcamentoOrgaoAtual(\Urbem\CoreBundle\Entity\Orcamento\Orgao $fkOrcamentoOrgaoAtual)
    {
        $this->exercicioAtual = $fkOrcamentoOrgaoAtual->getExercicio();
        $this->numOrgaoAtual = $fkOrcamentoOrgaoAtual->getNumOrgao();
        $this->fkOrcamentoOrgaoAtual = $fkOrcamentoOrgaoAtual;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoOrgaoAtual
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Orgao
     */
    public function getFkOrcamentoOrgaoAtual()
    {
        return $this->fkOrcamentoOrgaoAtual;
    }
}
