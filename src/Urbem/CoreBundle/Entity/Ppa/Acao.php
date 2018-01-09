<?php
 
namespace Urbem\CoreBundle\Entity\Ppa;

/**
 * Acao
 */
class Acao
{
    /**
     * PK
     * @var integer
     */
    private $codAcao;

    /**
     * @var integer
     */
    private $codPrograma;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $ultimoTimestampAcaoDados;

    /**
     * @var boolean
     */
    private $ativo = true;

    /**
     * @var integer
     */
    private $numAcao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tceal\AcaoIdentificadorAcao
     */
    private $fkTcealAcaoIdentificadorAcao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tceto\AcaoIdentificadorAcao
     */
    private $fkTcetoAcaoIdentificadorAcao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\PaoPpaAcao
     */
    private $fkOrcamentoPaoPpaAcoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\AcaoDados
     */
    private $fkPpaAcaoDados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ArquivoIncamp
     */
    private $fkTcemgArquivoIncamps;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\DespesaAcao
     */
    private $fkOrcamentoDespesaAcoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ArquivoAmp
     */
    private $fkTcemgArquivoAmps;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ppa\Programa
     */
    private $fkPpaPrograma;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkOrcamentoPaoPpaAcoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPpaAcaoDados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgArquivoIncamps = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoDespesaAcoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgArquivoAmps = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codAcao
     *
     * @param integer $codAcao
     * @return Acao
     */
    public function setCodAcao($codAcao)
    {
        $this->codAcao = $codAcao;
        return $this;
    }

    /**
     * Get codAcao
     *
     * @return integer
     */
    public function getCodAcao()
    {
        return $this->codAcao;
    }

    /**
     * Set codPrograma
     *
     * @param integer $codPrograma
     * @return Acao
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
     * Set ultimoTimestampAcaoDados
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $ultimoTimestampAcaoDados
     * @return Acao
     */
    public function setUltimoTimestampAcaoDados(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $ultimoTimestampAcaoDados)
    {
        $this->ultimoTimestampAcaoDados = $ultimoTimestampAcaoDados;
        return $this;
    }

    /**
     * Get ultimoTimestampAcaoDados
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getUltimoTimestampAcaoDados()
    {
        return $this->ultimoTimestampAcaoDados;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return Acao
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
     * Set numAcao
     *
     * @param integer $numAcao
     * @return Acao
     */
    public function setNumAcao($numAcao)
    {
        $this->numAcao = $numAcao;
        return $this;
    }

    /**
     * Get numAcao
     *
     * @return integer
     */
    public function getNumAcao()
    {
        return $this->numAcao;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoPaoPpaAcao
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\PaoPpaAcao $fkOrcamentoPaoPpaAcao
     * @return Acao
     */
    public function addFkOrcamentoPaoPpaAcoes(\Urbem\CoreBundle\Entity\Orcamento\PaoPpaAcao $fkOrcamentoPaoPpaAcao)
    {
        if (false === $this->fkOrcamentoPaoPpaAcoes->contains($fkOrcamentoPaoPpaAcao)) {
            $fkOrcamentoPaoPpaAcao->setFkPpaAcao($this);
            $this->fkOrcamentoPaoPpaAcoes->add($fkOrcamentoPaoPpaAcao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoPaoPpaAcao
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\PaoPpaAcao $fkOrcamentoPaoPpaAcao
     */
    public function removeFkOrcamentoPaoPpaAcoes(\Urbem\CoreBundle\Entity\Orcamento\PaoPpaAcao $fkOrcamentoPaoPpaAcao)
    {
        $this->fkOrcamentoPaoPpaAcoes->removeElement($fkOrcamentoPaoPpaAcao);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoPaoPpaAcoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\PaoPpaAcao
     */
    public function getFkOrcamentoPaoPpaAcoes()
    {
        return $this->fkOrcamentoPaoPpaAcoes;
    }

    /**
     * OneToMany (owning side)
     * Add PpaAcaoDados
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\AcaoDados $fkPpaAcaoDados
     * @return Acao
     */
    public function addFkPpaAcaoDados(\Urbem\CoreBundle\Entity\Ppa\AcaoDados $fkPpaAcaoDados)
    {
        if (false === $this->fkPpaAcaoDados->contains($fkPpaAcaoDados)) {
            $fkPpaAcaoDados->setFkPpaAcao($this);
            $this->fkPpaAcaoDados->add($fkPpaAcaoDados);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PpaAcaoDados
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\AcaoDados $fkPpaAcaoDados
     */
    public function removeFkPpaAcaoDados(\Urbem\CoreBundle\Entity\Ppa\AcaoDados $fkPpaAcaoDados)
    {
        $this->fkPpaAcaoDados->removeElement($fkPpaAcaoDados);
    }

    /**
     * OneToMany (owning side)
     * Get fkPpaAcaoDados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\AcaoDados
     */
    public function getFkPpaAcaoDados()
    {
        return $this->fkPpaAcaoDados;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgArquivoIncamp
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ArquivoIncamp $fkTcemgArquivoIncamp
     * @return Acao
     */
    public function addFkTcemgArquivoIncamps(\Urbem\CoreBundle\Entity\Tcemg\ArquivoIncamp $fkTcemgArquivoIncamp)
    {
        if (false === $this->fkTcemgArquivoIncamps->contains($fkTcemgArquivoIncamp)) {
            $fkTcemgArquivoIncamp->setFkPpaAcao($this);
            $this->fkTcemgArquivoIncamps->add($fkTcemgArquivoIncamp);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgArquivoIncamp
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ArquivoIncamp $fkTcemgArquivoIncamp
     */
    public function removeFkTcemgArquivoIncamps(\Urbem\CoreBundle\Entity\Tcemg\ArquivoIncamp $fkTcemgArquivoIncamp)
    {
        $this->fkTcemgArquivoIncamps->removeElement($fkTcemgArquivoIncamp);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgArquivoIncamps
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ArquivoIncamp
     */
    public function getFkTcemgArquivoIncamps()
    {
        return $this->fkTcemgArquivoIncamps;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoDespesaAcao
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\DespesaAcao $fkOrcamentoDespesaAcao
     * @return Acao
     */
    public function addFkOrcamentoDespesaAcoes(\Urbem\CoreBundle\Entity\Orcamento\DespesaAcao $fkOrcamentoDespesaAcao)
    {
        if (false === $this->fkOrcamentoDespesaAcoes->contains($fkOrcamentoDespesaAcao)) {
            $fkOrcamentoDespesaAcao->setFkPpaAcao($this);
            $this->fkOrcamentoDespesaAcoes->add($fkOrcamentoDespesaAcao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoDespesaAcao
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\DespesaAcao $fkOrcamentoDespesaAcao
     */
    public function removeFkOrcamentoDespesaAcoes(\Urbem\CoreBundle\Entity\Orcamento\DespesaAcao $fkOrcamentoDespesaAcao)
    {
        $this->fkOrcamentoDespesaAcoes->removeElement($fkOrcamentoDespesaAcao);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoDespesaAcoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\DespesaAcao
     */
    public function getFkOrcamentoDespesaAcoes()
    {
        return $this->fkOrcamentoDespesaAcoes;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgArquivoAmp
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ArquivoAmp $fkTcemgArquivoAmp
     * @return Acao
     */
    public function addFkTcemgArquivoAmps(\Urbem\CoreBundle\Entity\Tcemg\ArquivoAmp $fkTcemgArquivoAmp)
    {
        if (false === $this->fkTcemgArquivoAmps->contains($fkTcemgArquivoAmp)) {
            $fkTcemgArquivoAmp->setFkPpaAcao($this);
            $this->fkTcemgArquivoAmps->add($fkTcemgArquivoAmp);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgArquivoAmp
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ArquivoAmp $fkTcemgArquivoAmp
     */
    public function removeFkTcemgArquivoAmps(\Urbem\CoreBundle\Entity\Tcemg\ArquivoAmp $fkTcemgArquivoAmp)
    {
        $this->fkTcemgArquivoAmps->removeElement($fkTcemgArquivoAmp);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgArquivoAmps
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ArquivoAmp
     */
    public function getFkTcemgArquivoAmps()
    {
        return $this->fkTcemgArquivoAmps;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPpaPrograma
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\Programa $fkPpaPrograma
     * @return Acao
     */
    public function setFkPpaPrograma(\Urbem\CoreBundle\Entity\Ppa\Programa $fkPpaPrograma)
    {
        $this->codPrograma = $fkPpaPrograma->getCodPrograma();
        $this->fkPpaPrograma = $fkPpaPrograma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPpaPrograma
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\Programa
     */
    public function getFkPpaPrograma()
    {
        return $this->fkPpaPrograma;
    }

    /**
     * OneToOne (inverse side)
     * Set TcealAcaoIdentificadorAcao
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\AcaoIdentificadorAcao $fkTcealAcaoIdentificadorAcao
     * @return Acao
     */
    public function setFkTcealAcaoIdentificadorAcao(\Urbem\CoreBundle\Entity\Tceal\AcaoIdentificadorAcao $fkTcealAcaoIdentificadorAcao)
    {
        $fkTcealAcaoIdentificadorAcao->setFkPpaAcao($this);
        $this->fkTcealAcaoIdentificadorAcao = $fkTcealAcaoIdentificadorAcao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcealAcaoIdentificadorAcao
     *
     * @return \Urbem\CoreBundle\Entity\Tceal\AcaoIdentificadorAcao
     */
    public function getFkTcealAcaoIdentificadorAcao()
    {
        return $this->fkTcealAcaoIdentificadorAcao;
    }

    /**
     * OneToOne (inverse side)
     * Set TcetoAcaoIdentificadorAcao
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\AcaoIdentificadorAcao $fkTcetoAcaoIdentificadorAcao
     * @return Acao
     */
    public function setFkTcetoAcaoIdentificadorAcao(\Urbem\CoreBundle\Entity\Tceto\AcaoIdentificadorAcao $fkTcetoAcaoIdentificadorAcao)
    {
        $fkTcetoAcaoIdentificadorAcao->setFkPpaAcao($this);
        $this->fkTcetoAcaoIdentificadorAcao = $fkTcetoAcaoIdentificadorAcao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcetoAcaoIdentificadorAcao
     *
     * @return \Urbem\CoreBundle\Entity\Tceto\AcaoIdentificadorAcao
     */
    public function getFkTcetoAcaoIdentificadorAcao()
    {
        return $this->fkTcetoAcaoIdentificadorAcao;
    }

    /**
     * @return AcaoDados object|null
     */
    public function getAcaoDados()
    {
        return $this->getFkPpaAcaoDados()->filter(
            function ($entry) {
                if ($entry->getTimestampAcaoDados() == $this->ultimoTimestampAcaoDados) {
                    return $entry;
                }
            }
        )->first();
    }

    /**
     * @return string|null
     */
    public function getTipoAcao()
    {
        return $this->getAcaoDados()
            ? $this->getAcaoDados()->getFkPpaTipoAcao()->getDescricao()
            : null;
    }

    /**
     * @return string|null
     */
    public function getDescricao()
    {
        return $this->getAcaoDados()
            ? $this->getAcaoDados()->getDescricao()
            : null;
    }

    /**
     * @return float
     */
    public function getValor()
    {
        $valor = 0.0;
        if ($this->getAcaoDados()) {
            foreach ($this->getAcaoDados()->getFkPpaAcaoRecursos() as $acaoRecurso) {
                $valor += $acaoRecurso->getValor();
            }
        }
        return $valor;
    }

    /**
     * @return string
     */
    public function getCodigoComposto()
    {
        return str_pad($this->numAcao, 4, '0', STR_PAD_LEFT);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->numAcao;
    }
}
