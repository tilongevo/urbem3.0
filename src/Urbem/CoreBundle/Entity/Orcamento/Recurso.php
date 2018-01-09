<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * Recurso
 */
class Recurso
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
    private $codRecurso;

    /**
     * @var string
     */
    private $codFonte;

    /**
     * @var string
     */
    private $nomRecurso;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Orcamento\RecursoDestinacao
     */
    private $fkOrcamentoRecursoDestinacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Orcamento\RecursoDireto
     */
    private $fkOrcamentoRecursoDireto;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Stn\RecursoRreoAnexo14
     */
    private $fkStnRecursoRreoAnexo14;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcepb\Recurso
     */
    private $fkTcepbRecurso;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcerj\Recurso
     */
    private $fkTcerjRecurso;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcepe\CodigoFonteRecurso
     */
    private $fkTcepeCodigoFonteRecurso;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\PlanoRecurso
     */
    private $fkContabilidadePlanoRecursos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\PlanoRecurso
     */
    private $fkContabilidadePlanoRecursos1;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Manad\RecursoModeloLrf
     */
    private $fkManadRecursoModeloLrfs;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\Receita
     */
    private $fkOrcamentoReceitas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\AcaoRecurso
     */
    private $fkPpaAcaoRecursos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\VinculoRecurso
     */
    private $fkStnVinculoRecursos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcers\RecursoModeloLrf
     */
    private $fkTcersRecursoModeloLrfs;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraRecurso
     */
    private $fkTesourariaReciboExtraRecursos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaRecurso
     */
    private $fkTesourariaTransferenciaRecursos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\Despesa
     */
    private $fkOrcamentoDespesas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\ValorLancamentoRecurso
     */
    private $fkContabilidadeValorLancamentoRecursos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkContabilidadePlanoRecursos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadePlanoRecursos1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkManadRecursoModeloLrfs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoReceitas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPpaAcaoRecursos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkStnVinculoRecursos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcersRecursoModeloLrfs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaReciboExtraRecursos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaTransferenciaRecursos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoDespesas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadeValorLancamentoRecursos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Recurso
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
     * Set codRecurso
     *
     * @param integer $codRecurso
     * @return Recurso
     */
    public function setCodRecurso($codRecurso)
    {
        $this->codRecurso = $codRecurso;
        return $this;
    }

    /**
     * Get codRecurso
     *
     * @return integer
     */
    public function getCodRecurso()
    {
        return $this->codRecurso;
    }

    /**
     * Set codFonte
     *
     * @param string $codFonte
     * @return Recurso
     */
    public function setCodFonte($codFonte)
    {
        $this->codFonte = $codFonte;
        return $this;
    }

    /**
     * Get codFonte
     *
     * @return string
     */
    public function getCodFonte()
    {
        return $this->codFonte;
    }

    /**
     * Set nomRecurso
     *
     * @param string $nomRecurso
     * @return Recurso
     */
    public function setNomRecurso($nomRecurso)
    {
        $this->nomRecurso = $nomRecurso;
        return $this;
    }

    /**
     * Get nomRecurso
     *
     * @return string
     */
    public function getNomRecurso()
    {
        return $this->nomRecurso;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadePlanoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoRecurso $fkContabilidadePlanoRecurso
     * @return Recurso
     */
    public function addFkContabilidadePlanoRecursos(\Urbem\CoreBundle\Entity\Contabilidade\PlanoRecurso $fkContabilidadePlanoRecurso)
    {
        if (false === $this->fkContabilidadePlanoRecursos->contains($fkContabilidadePlanoRecurso)) {
            $fkContabilidadePlanoRecurso->setFkOrcamentoRecurso($this);
            $this->fkContabilidadePlanoRecursos->add($fkContabilidadePlanoRecurso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadePlanoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoRecurso $fkContabilidadePlanoRecurso
     */
    public function removeFkContabilidadePlanoRecursos(\Urbem\CoreBundle\Entity\Contabilidade\PlanoRecurso $fkContabilidadePlanoRecurso)
    {
        $this->fkContabilidadePlanoRecursos->removeElement($fkContabilidadePlanoRecurso);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadePlanoRecursos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\PlanoRecurso
     */
    public function getFkContabilidadePlanoRecursos()
    {
        return $this->fkContabilidadePlanoRecursos;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadePlanoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoRecurso $fkContabilidadePlanoRecurso
     * @return Recurso
     */
    public function addFkContabilidadePlanoRecursos1(\Urbem\CoreBundle\Entity\Contabilidade\PlanoRecurso $fkContabilidadePlanoRecurso)
    {
        if (false === $this->fkContabilidadePlanoRecursos1->contains($fkContabilidadePlanoRecurso)) {
            $fkContabilidadePlanoRecurso->setFkOrcamentoRecurso1($this);
            $this->fkContabilidadePlanoRecursos1->add($fkContabilidadePlanoRecurso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadePlanoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoRecurso $fkContabilidadePlanoRecurso
     */
    public function removeFkContabilidadePlanoRecursos1(\Urbem\CoreBundle\Entity\Contabilidade\PlanoRecurso $fkContabilidadePlanoRecurso)
    {
        $this->fkContabilidadePlanoRecursos1->removeElement($fkContabilidadePlanoRecurso);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadePlanoRecursos1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\PlanoRecurso
     */
    public function getFkContabilidadePlanoRecursos1()
    {
        return $this->fkContabilidadePlanoRecursos1;
    }

    /**
     * OneToMany (owning side)
     * Add ManadRecursoModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Manad\RecursoModeloLrf $fkManadRecursoModeloLrf
     * @return Recurso
     */
    public function addFkManadRecursoModeloLrfs(\Urbem\CoreBundle\Entity\Manad\RecursoModeloLrf $fkManadRecursoModeloLrf)
    {
        if (false === $this->fkManadRecursoModeloLrfs->contains($fkManadRecursoModeloLrf)) {
            $fkManadRecursoModeloLrf->setFkOrcamentoRecurso($this);
            $this->fkManadRecursoModeloLrfs->add($fkManadRecursoModeloLrf);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ManadRecursoModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Manad\RecursoModeloLrf $fkManadRecursoModeloLrf
     */
    public function removeFkManadRecursoModeloLrfs(\Urbem\CoreBundle\Entity\Manad\RecursoModeloLrf $fkManadRecursoModeloLrf)
    {
        $this->fkManadRecursoModeloLrfs->removeElement($fkManadRecursoModeloLrf);
    }

    /**
     * OneToMany (owning side)
     * Get fkManadRecursoModeloLrfs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Manad\RecursoModeloLrf
     */
    public function getFkManadRecursoModeloLrfs()
    {
        return $this->fkManadRecursoModeloLrfs;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita
     * @return Recurso
     */
    public function addFkOrcamentoReceitas(\Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita)
    {
        if (false === $this->fkOrcamentoReceitas->contains($fkOrcamentoReceita)) {
            $fkOrcamentoReceita->setFkOrcamentoRecurso($this);
            $this->fkOrcamentoReceitas->add($fkOrcamentoReceita);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita
     */
    public function removeFkOrcamentoReceitas(\Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita)
    {
        $this->fkOrcamentoReceitas->removeElement($fkOrcamentoReceita);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoReceitas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\Receita
     */
    public function getFkOrcamentoReceitas()
    {
        return $this->fkOrcamentoReceitas;
    }

    /**
     * OneToMany (owning side)
     * Add PpaAcaoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\AcaoRecurso $fkPpaAcaoRecurso
     * @return Recurso
     */
    public function addFkPpaAcaoRecursos(\Urbem\CoreBundle\Entity\Ppa\AcaoRecurso $fkPpaAcaoRecurso)
    {
        if (false === $this->fkPpaAcaoRecursos->contains($fkPpaAcaoRecurso)) {
            $fkPpaAcaoRecurso->setFkOrcamentoRecurso($this);
            $this->fkPpaAcaoRecursos->add($fkPpaAcaoRecurso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PpaAcaoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\AcaoRecurso $fkPpaAcaoRecurso
     */
    public function removeFkPpaAcaoRecursos(\Urbem\CoreBundle\Entity\Ppa\AcaoRecurso $fkPpaAcaoRecurso)
    {
        $this->fkPpaAcaoRecursos->removeElement($fkPpaAcaoRecurso);
    }

    /**
     * OneToMany (owning side)
     * Get fkPpaAcaoRecursos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\AcaoRecurso
     */
    public function getFkPpaAcaoRecursos()
    {
        return $this->fkPpaAcaoRecursos;
    }

    /**
     * OneToMany (owning side)
     * Add StnVinculoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Stn\VinculoRecurso $fkStnVinculoRecurso
     * @return Recurso
     */
    public function addFkStnVinculoRecursos(\Urbem\CoreBundle\Entity\Stn\VinculoRecurso $fkStnVinculoRecurso)
    {
        if (false === $this->fkStnVinculoRecursos->contains($fkStnVinculoRecurso)) {
            $fkStnVinculoRecurso->setFkOrcamentoRecurso($this);
            $this->fkStnVinculoRecursos->add($fkStnVinculoRecurso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove StnVinculoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Stn\VinculoRecurso $fkStnVinculoRecurso
     */
    public function removeFkStnVinculoRecursos(\Urbem\CoreBundle\Entity\Stn\VinculoRecurso $fkStnVinculoRecurso)
    {
        $this->fkStnVinculoRecursos->removeElement($fkStnVinculoRecurso);
    }

    /**
     * OneToMany (owning side)
     * Get fkStnVinculoRecursos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\VinculoRecurso
     */
    public function getFkStnVinculoRecursos()
    {
        return $this->fkStnVinculoRecursos;
    }

    /**
     * OneToMany (owning side)
     * Add TcersRecursoModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Tcers\RecursoModeloLrf $fkTcersRecursoModeloLrf
     * @return Recurso
     */
    public function addFkTcersRecursoModeloLrfs(\Urbem\CoreBundle\Entity\Tcers\RecursoModeloLrf $fkTcersRecursoModeloLrf)
    {
        if (false === $this->fkTcersRecursoModeloLrfs->contains($fkTcersRecursoModeloLrf)) {
            $fkTcersRecursoModeloLrf->setFkOrcamentoRecurso($this);
            $this->fkTcersRecursoModeloLrfs->add($fkTcersRecursoModeloLrf);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcersRecursoModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Tcers\RecursoModeloLrf $fkTcersRecursoModeloLrf
     */
    public function removeFkTcersRecursoModeloLrfs(\Urbem\CoreBundle\Entity\Tcers\RecursoModeloLrf $fkTcersRecursoModeloLrf)
    {
        $this->fkTcersRecursoModeloLrfs->removeElement($fkTcersRecursoModeloLrf);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcersRecursoModeloLrfs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcers\RecursoModeloLrf
     */
    public function getFkTcersRecursoModeloLrfs()
    {
        return $this->fkTcersRecursoModeloLrfs;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaReciboExtraRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraRecurso $fkTesourariaReciboExtraRecurso
     * @return Recurso
     */
    public function addFkTesourariaReciboExtraRecursos(\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraRecurso $fkTesourariaReciboExtraRecurso)
    {
        if (false === $this->fkTesourariaReciboExtraRecursos->contains($fkTesourariaReciboExtraRecurso)) {
            $fkTesourariaReciboExtraRecurso->setFkOrcamentoRecurso($this);
            $this->fkTesourariaReciboExtraRecursos->add($fkTesourariaReciboExtraRecurso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaReciboExtraRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraRecurso $fkTesourariaReciboExtraRecurso
     */
    public function removeFkTesourariaReciboExtraRecursos(\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraRecurso $fkTesourariaReciboExtraRecurso)
    {
        $this->fkTesourariaReciboExtraRecursos->removeElement($fkTesourariaReciboExtraRecurso);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaReciboExtraRecursos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtraRecurso
     */
    public function getFkTesourariaReciboExtraRecursos()
    {
        return $this->fkTesourariaReciboExtraRecursos;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaTransferenciaRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransferenciaRecurso $fkTesourariaTransferenciaRecurso
     * @return Recurso
     */
    public function addFkTesourariaTransferenciaRecursos(\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaRecurso $fkTesourariaTransferenciaRecurso)
    {
        if (false === $this->fkTesourariaTransferenciaRecursos->contains($fkTesourariaTransferenciaRecurso)) {
            $fkTesourariaTransferenciaRecurso->setFkOrcamentoRecurso($this);
            $this->fkTesourariaTransferenciaRecursos->add($fkTesourariaTransferenciaRecurso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaTransferenciaRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransferenciaRecurso $fkTesourariaTransferenciaRecurso
     */
    public function removeFkTesourariaTransferenciaRecursos(\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaRecurso $fkTesourariaTransferenciaRecurso)
    {
        $this->fkTesourariaTransferenciaRecursos->removeElement($fkTesourariaTransferenciaRecurso);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaTransferenciaRecursos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaRecurso
     */
    public function getFkTesourariaTransferenciaRecursos()
    {
        return $this->fkTesourariaTransferenciaRecursos;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa
     * @return Recurso
     */
    public function addFkOrcamentoDespesas(\Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa)
    {
        if (false === $this->fkOrcamentoDespesas->contains($fkOrcamentoDespesa)) {
            $fkOrcamentoDespesa->setFkOrcamentoRecurso($this);
            $this->fkOrcamentoDespesas->add($fkOrcamentoDespesa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa
     */
    public function removeFkOrcamentoDespesas(\Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa)
    {
        $this->fkOrcamentoDespesas->removeElement($fkOrcamentoDespesa);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoDespesas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\Despesa
     */
    public function getFkOrcamentoDespesas()
    {
        return $this->fkOrcamentoDespesas;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeValorLancamentoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ValorLancamentoRecurso $fkContabilidadeValorLancamentoRecurso
     * @return Recurso
     */
    public function addFkContabilidadeValorLancamentoRecursos(\Urbem\CoreBundle\Entity\Contabilidade\ValorLancamentoRecurso $fkContabilidadeValorLancamentoRecurso)
    {
        if (false === $this->fkContabilidadeValorLancamentoRecursos->contains($fkContabilidadeValorLancamentoRecurso)) {
            $fkContabilidadeValorLancamentoRecurso->setFkOrcamentoRecurso($this);
            $this->fkContabilidadeValorLancamentoRecursos->add($fkContabilidadeValorLancamentoRecurso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeValorLancamentoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ValorLancamentoRecurso $fkContabilidadeValorLancamentoRecurso
     */
    public function removeFkContabilidadeValorLancamentoRecursos(\Urbem\CoreBundle\Entity\Contabilidade\ValorLancamentoRecurso $fkContabilidadeValorLancamentoRecurso)
    {
        $this->fkContabilidadeValorLancamentoRecursos->removeElement($fkContabilidadeValorLancamentoRecurso);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeValorLancamentoRecursos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\ValorLancamentoRecurso
     */
    public function getFkContabilidadeValorLancamentoRecursos()
    {
        return $this->fkContabilidadeValorLancamentoRecursos;
    }

    /**
     * OneToOne (inverse side)
     * Set OrcamentoRecursoDestinacao
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\RecursoDestinacao $fkOrcamentoRecursoDestinacao
     * @return Recurso
     */
    public function setFkOrcamentoRecursoDestinacao(\Urbem\CoreBundle\Entity\Orcamento\RecursoDestinacao $fkOrcamentoRecursoDestinacao)
    {
        $fkOrcamentoRecursoDestinacao->setFkOrcamentoRecurso($this);
        $this->fkOrcamentoRecursoDestinacao = $fkOrcamentoRecursoDestinacao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkOrcamentoRecursoDestinacao
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\RecursoDestinacao
     */
    public function getFkOrcamentoRecursoDestinacao()
    {
        return $this->fkOrcamentoRecursoDestinacao;
    }

    /**
     * OneToOne (inverse side)
     * Set OrcamentoRecursoDireto
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\RecursoDireto $fkOrcamentoRecursoDireto
     * @return Recurso
     */
    public function setFkOrcamentoRecursoDireto(\Urbem\CoreBundle\Entity\Orcamento\RecursoDireto $fkOrcamentoRecursoDireto)
    {
        $fkOrcamentoRecursoDireto->setFkOrcamentoRecurso($this);
        $this->fkOrcamentoRecursoDireto = $fkOrcamentoRecursoDireto;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkOrcamentoRecursoDireto
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\RecursoDireto
     */
    public function getFkOrcamentoRecursoDireto()
    {
        return $this->fkOrcamentoRecursoDireto;
    }

    /**
     * OneToOne (inverse side)
     * Set StnRecursoRreoAnexo14
     *
     * @param \Urbem\CoreBundle\Entity\Stn\RecursoRreoAnexo14 $fkStnRecursoRreoAnexo14
     * @return Recurso
     */
    public function setFkStnRecursoRreoAnexo14(\Urbem\CoreBundle\Entity\Stn\RecursoRreoAnexo14 $fkStnRecursoRreoAnexo14)
    {
        $fkStnRecursoRreoAnexo14->setFkOrcamentoRecurso($this);
        $this->fkStnRecursoRreoAnexo14 = $fkStnRecursoRreoAnexo14;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkStnRecursoRreoAnexo14
     *
     * @return \Urbem\CoreBundle\Entity\Stn\RecursoRreoAnexo14
     */
    public function getFkStnRecursoRreoAnexo14()
    {
        return $this->fkStnRecursoRreoAnexo14;
    }

    /**
     * OneToOne (inverse side)
     * Set TcepbRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\Recurso $fkTcepbRecurso
     * @return Recurso
     */
    public function setFkTcepbRecurso(\Urbem\CoreBundle\Entity\Tcepb\Recurso $fkTcepbRecurso)
    {
        $fkTcepbRecurso->setFkOrcamentoRecurso($this);
        $this->fkTcepbRecurso = $fkTcepbRecurso;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcepbRecurso
     *
     * @return \Urbem\CoreBundle\Entity\Tcepb\Recurso
     */
    public function getFkTcepbRecurso()
    {
        return $this->fkTcepbRecurso;
    }

    /**
     * OneToOne (inverse side)
     * Set TcerjRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Tcerj\Recurso $fkTcerjRecurso
     * @return Recurso
     */
    public function setFkTcerjRecurso(\Urbem\CoreBundle\Entity\Tcerj\Recurso $fkTcerjRecurso)
    {
        $fkTcerjRecurso->setFkOrcamentoRecurso($this);
        $this->fkTcerjRecurso = $fkTcerjRecurso;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcerjRecurso
     *
     * @return \Urbem\CoreBundle\Entity\Tcerj\Recurso
     */
    public function getFkTcerjRecurso()
    {
        return $this->fkTcerjRecurso;
    }

    /**
     * OneToOne (inverse side)
     * Set TcepeCodigoFonteRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\CodigoFonteRecurso $fkTcepeCodigoFonteRecurso
     * @return Recurso
     */
    public function setFkTcepeCodigoFonteRecurso(\Urbem\CoreBundle\Entity\Tcepe\CodigoFonteRecurso $fkTcepeCodigoFonteRecurso)
    {
        $fkTcepeCodigoFonteRecurso->setFkOrcamentoRecurso($this);
        $this->fkTcepeCodigoFonteRecurso = $fkTcepeCodigoFonteRecurso;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcepeCodigoFonteRecurso
     *
     * @return \Urbem\CoreBundle\Entity\Tcepe\CodigoFonteRecurso
     */
    public function getFkTcepeCodigoFonteRecurso()
    {
        return $this->fkTcepeCodigoFonteRecurso;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->codFonte, $this->nomRecurso);
    }
}
