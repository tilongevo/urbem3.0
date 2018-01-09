<?php
 
namespace Urbem\CoreBundle\Entity\Ppa;

use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;

/**
 * Programa
 */
class Programa
{
    /**
     * PK
     * @var integer
     */
    private $codPrograma;

    /**
     * @var integer
     */
    private $codSetorial;

    /**
     * @var DateTimeMicrosecondPK
     */
    private $ultimoTimestampProgramaDados;

    /**
     * @var boolean
     */
    private $ativo = true;

    /**
     * @var integer
     */
    private $numPrograma;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\ProgramaPpaPrograma
     */
    private $fkOrcamentoProgramaPpaProgramas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\Acao
     */
    private $fkPpaAcoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\RegistrosArquivoPrograma
     */
    private $fkTcemgRegistrosArquivoProgramas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\RegistrosArquivoInclusaoPrograma
     */
    private $fkTcemgRegistrosArquivoInclusaoProgramas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\ProgramaDados
     */
    private $fkPpaProgramaDados;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ppa\ProgramaSetorial
     */
    private $fkPpaProgramaSetorial;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkOrcamentoProgramaPpaProgramas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPpaAcoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgRegistrosArquivoProgramas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgRegistrosArquivoInclusaoProgramas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPpaProgramaDados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ultimoTimestampProgramaDados = new DateTimeMicrosecondPK();
    }

    /**
     * Set codPrograma
     *
     * @param integer $codPrograma
     * @return Programa
     */
    public function setCodPrograma($codPrograma)
    {
        $this->codPrograma = $codPrograma;
        return $this;
    }

    /**
     * Get codPrograma
     *
     * @return integer
     */
    public function getCodPrograma()
    {
        return $this->codPrograma;
    }

    /**
     * Set codSetorial
     *
     * @param integer $codSetorial
     * @return Programa
     */
    public function setCodSetorial($codSetorial)
    {
        $this->codSetorial = $codSetorial;
        return $this;
    }

    /**
     * Get codSetorial
     *
     * @return integer
     */
    public function getCodSetorial()
    {
        return $this->codSetorial;
    }

    /**
     * Set ultimoTimestampProgramaDados
     *
     * @param DateTimeMicrosecondPK $ultimoTimestampProgramaDados
     * @return Programa
     */
    public function setUltimoTimestampProgramaDados(DateTimeMicrosecondPK $ultimoTimestampProgramaDados)
    {
        $this->ultimoTimestampProgramaDados = $ultimoTimestampProgramaDados;
        return $this;
    }

    /**
     * Get ultimoTimestampProgramaDados
     *
     * @return DateTimeMicrosecondPK
     */
    public function getUltimoTimestampProgramaDados()
    {
        return $this->ultimoTimestampProgramaDados;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return Programa
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
        return $this;
    }

    /**
     * Get ativo
     *
     * @return boolean
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * Set numPrograma
     *
     * @param integer $numPrograma
     * @return Programa
     */
    public function setNumPrograma($numPrograma)
    {
        $this->numPrograma = $numPrograma;
        return $this;
    }

    /**
     * Get numPrograma
     *
     * @return integer
     */
    public function getNumPrograma()
    {
        return $this->numPrograma;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoProgramaPpaPrograma
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ProgramaPpaPrograma $fkOrcamentoProgramaPpaPrograma
     * @return Programa
     */
    public function addFkOrcamentoProgramaPpaProgramas(\Urbem\CoreBundle\Entity\Orcamento\ProgramaPpaPrograma $fkOrcamentoProgramaPpaPrograma)
    {
        if (false === $this->fkOrcamentoProgramaPpaProgramas->contains($fkOrcamentoProgramaPpaPrograma)) {
            $fkOrcamentoProgramaPpaPrograma->setFkPpaPrograma($this);
            $this->fkOrcamentoProgramaPpaProgramas->add($fkOrcamentoProgramaPpaPrograma);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoProgramaPpaPrograma
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ProgramaPpaPrograma $fkOrcamentoProgramaPpaPrograma
     */
    public function removeFkOrcamentoProgramaPpaProgramas(\Urbem\CoreBundle\Entity\Orcamento\ProgramaPpaPrograma $fkOrcamentoProgramaPpaPrograma)
    {
        $this->fkOrcamentoProgramaPpaProgramas->removeElement($fkOrcamentoProgramaPpaPrograma);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoProgramaPpaProgramas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\ProgramaPpaPrograma
     */
    public function getFkOrcamentoProgramaPpaProgramas()
    {
        return $this->fkOrcamentoProgramaPpaProgramas;
    }

    /**
     * OneToMany (owning side)
     * Add PpaAcao
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\Acao $fkPpaAcao
     * @return Programa
     */
    public function addFkPpaAcoes(\Urbem\CoreBundle\Entity\Ppa\Acao $fkPpaAcao)
    {
        if (false === $this->fkPpaAcoes->contains($fkPpaAcao)) {
            $fkPpaAcao->setFkPpaPrograma($this);
            $this->fkPpaAcoes->add($fkPpaAcao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PpaAcao
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\Acao $fkPpaAcao
     */
    public function removeFkPpaAcoes(\Urbem\CoreBundle\Entity\Ppa\Acao $fkPpaAcao)
    {
        $this->fkPpaAcoes->removeElement($fkPpaAcao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPpaAcoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\Acao
     */
    public function getFkPpaAcoes()
    {
        return $this->fkPpaAcoes;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgRegistrosArquivoPrograma
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\RegistrosArquivoPrograma $fkTcemgRegistrosArquivoPrograma
     * @return Programa
     */
    public function addFkTcemgRegistrosArquivoProgramas(\Urbem\CoreBundle\Entity\Tcemg\RegistrosArquivoPrograma $fkTcemgRegistrosArquivoPrograma)
    {
        if (false === $this->fkTcemgRegistrosArquivoProgramas->contains($fkTcemgRegistrosArquivoPrograma)) {
            $fkTcemgRegistrosArquivoPrograma->setFkPpaPrograma($this);
            $this->fkTcemgRegistrosArquivoProgramas->add($fkTcemgRegistrosArquivoPrograma);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgRegistrosArquivoPrograma
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\RegistrosArquivoPrograma $fkTcemgRegistrosArquivoPrograma
     */
    public function removeFkTcemgRegistrosArquivoProgramas(\Urbem\CoreBundle\Entity\Tcemg\RegistrosArquivoPrograma $fkTcemgRegistrosArquivoPrograma)
    {
        $this->fkTcemgRegistrosArquivoProgramas->removeElement($fkTcemgRegistrosArquivoPrograma);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgRegistrosArquivoProgramas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\RegistrosArquivoPrograma
     */
    public function getFkTcemgRegistrosArquivoProgramas()
    {
        return $this->fkTcemgRegistrosArquivoProgramas;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgRegistrosArquivoInclusaoPrograma
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\RegistrosArquivoInclusaoPrograma $fkTcemgRegistrosArquivoInclusaoPrograma
     * @return Programa
     */
    public function addFkTcemgRegistrosArquivoInclusaoProgramas(\Urbem\CoreBundle\Entity\Tcemg\RegistrosArquivoInclusaoPrograma $fkTcemgRegistrosArquivoInclusaoPrograma)
    {
        if (false === $this->fkTcemgRegistrosArquivoInclusaoProgramas->contains($fkTcemgRegistrosArquivoInclusaoPrograma)) {
            $fkTcemgRegistrosArquivoInclusaoPrograma->setFkPpaPrograma($this);
            $this->fkTcemgRegistrosArquivoInclusaoProgramas->add($fkTcemgRegistrosArquivoInclusaoPrograma);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgRegistrosArquivoInclusaoPrograma
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\RegistrosArquivoInclusaoPrograma $fkTcemgRegistrosArquivoInclusaoPrograma
     */
    public function removeFkTcemgRegistrosArquivoInclusaoProgramas(\Urbem\CoreBundle\Entity\Tcemg\RegistrosArquivoInclusaoPrograma $fkTcemgRegistrosArquivoInclusaoPrograma)
    {
        $this->fkTcemgRegistrosArquivoInclusaoProgramas->removeElement($fkTcemgRegistrosArquivoInclusaoPrograma);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgRegistrosArquivoInclusaoProgramas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\RegistrosArquivoInclusaoPrograma
     */
    public function getFkTcemgRegistrosArquivoInclusaoProgramas()
    {
        return $this->fkTcemgRegistrosArquivoInclusaoProgramas;
    }

    /**
     * OneToMany (owning side)
     * Add PpaProgramaDados
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\ProgramaDados $fkPpaProgramaDados
     * @return Programa
     */
    public function addFkPpaProgramaDados(\Urbem\CoreBundle\Entity\Ppa\ProgramaDados $fkPpaProgramaDados)
    {
        if (false === $this->fkPpaProgramaDados->contains($fkPpaProgramaDados)) {
            $fkPpaProgramaDados->setFkPpaPrograma($this);
            $this->fkPpaProgramaDados->add($fkPpaProgramaDados);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PpaProgramaDados
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\ProgramaDados $fkPpaProgramaDados
     */
    public function removeFkPpaProgramaDados(\Urbem\CoreBundle\Entity\Ppa\ProgramaDados $fkPpaProgramaDados)
    {
        $this->fkPpaProgramaDados->removeElement($fkPpaProgramaDados);
    }

    /**
     * OneToMany (owning side)
     * Get fkPpaProgramaDados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\ProgramaDados
     */
    public function getFkPpaProgramaDados()
    {
        return $this->fkPpaProgramaDados;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPpaProgramaSetorial
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\ProgramaSetorial $fkPpaProgramaSetorial
     * @return Programa
     */
    public function setFkPpaProgramaSetorial(\Urbem\CoreBundle\Entity\Ppa\ProgramaSetorial $fkPpaProgramaSetorial)
    {
        $this->codSetorial = $fkPpaProgramaSetorial->getCodSetorial();
        $this->fkPpaProgramaSetorial = $fkPpaProgramaSetorial;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPpaProgramaSetorial
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\ProgramaSetorial
     */
    public function getFkPpaProgramaSetorial()
    {
        return $this->fkPpaProgramaSetorial;
    }

    /**
     * @return mixed
     */
    public function getIdentificacao()
    {
        if (!$this->fkPpaProgramaDados->isEmpty()) {
            return $this->fkPpaProgramaDados->first()->getIdentificacao();
        }
    }

    /**
     * @return null | string
     */
    public function getNaturezaTemporalLabel()
    {
        if (!$this->fkPpaProgramaDados->isEmpty()) {
            return ($this->fkPpaProgramaDados->first()->getContinuo() ? 'label.programas.choices.boNatureza.continuo' : 'label.programas.choices.boNatureza.temporario');
        }
    }

    /**
     * @return string
     */
    public function getNumProgramaFormatado()
    {
        return str_pad($this->numPrograma, 4, "0", STR_PAD_LEFT);
    }

    /**
     * @return mixed
     */
    public function getProgramaDados()
    {
        return $this->getFkPpaProgramaDados()->filter(
            function ($entry) {
                if ($entry->getTimestampProgramaDados() == $this->ultimoTimestampProgramaDados) {
                    return $entry;
                }
            }
        )->first();
    }

    /**
     * @return mixed
     */
    public function getTipoPrograma()
    {
        return $this->getProgramaDados()->getFkPpaTipoPrograma()->getDescricao();
    }

    /**
     * @return mixed
     */
    public function getJustificativa()
    {
        return $this->getProgramaDados()->getJustificativa();
    }

    /**
     * @return mixed
     */
    public function getDiagnostico()
    {
        return $this->getProgramaDados()->getDiagnostico();
    }

    /**
     * @return mixed
     */
    public function getObjetivo()
    {
        return $this->getProgramaDados()->getObjetivo();
    }

    /**
     * @return mixed
     */
    public function getDiretriz()
    {
        return $this->getProgramaDados()->getDiretriz();
    }

    /**
     * @return mixed
     */
    public function getPublicoAlvo()
    {
        return $this->getProgramaDados()->getPublicoAlvo();
    }

    /**
     * @return string
     */
    public function getContinuo()
    {
        return (!empty($this->getProgramaDados()->getContinuo()) ? 'label.programas.choices.boNatureza.continuo' : 'label.programas.choices.boNatureza.temporario');
    }

    /**
     * @return mixed
     */
    public function getOrgao()
    {
        return $this->getProgramaDados()->getFkOrcamentoUnidade()->getFkOrcamentoOrgao()->getNomOrgao();
    }

    /**
     * @return mixed
     */
    public function getUnidade()
    {
        return $this->getProgramaDados()->getFkOrcamentoUnidade();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->codPrograma;
    }
}
