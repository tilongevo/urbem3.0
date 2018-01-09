<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * Programa
 */
class Programa
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
    private $codPrograma;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcepb\ProgramaObjetivoMilenio
     */
    private $fkTcepbProgramaObjetivoMilenio;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\ProgramaPpaPrograma
     */
    private $fkOrcamentoProgramaPpaProgramas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\Despesa
     */
    private $fkOrcamentoDespesas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkOrcamentoProgramaPpaProgramas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoDespesas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Programa
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
     * Set descricao
     *
     * @param string $descricao
     * @return Programa
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
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
            $fkOrcamentoProgramaPpaPrograma->setFkOrcamentoPrograma($this);
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
     * @param $fkOrcamentoProgramaPpaPrograma
     */
    public function setFkOrcamentoProgramaPpaProgramas($fkOrcamentoProgramaPpaPrograma)
    {
        $this->fkOrcamentoProgramaPpaProgramas = $fkOrcamentoProgramaPpaPrograma;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa
     * @return Programa
     */
    public function addFkOrcamentoDespesas(\Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa)
    {
        if (false === $this->fkOrcamentoDespesas->contains($fkOrcamentoDespesa)) {
            $fkOrcamentoDespesa->setFkOrcamentoPrograma($this);
            $this->fkOrcamentoDespesas->add($fkOrcamentoDespesa);
        }
        
        return $this;
    }

    /**
     * @param $fkOrcamentoDespesa
     */
    public function setFkOrcamentoDespesas($fkOrcamentoDespesa)
    {
        $this->fkOrcamentoDespesas = $fkOrcamentoDespesa;
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
     * OneToOne (inverse side)
     * Set TcepbProgramaObjetivoMilenio
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\ProgramaObjetivoMilenio $fkTcepbProgramaObjetivoMilenio
     * @return Programa
     */
    public function setFkTcepbProgramaObjetivoMilenio(\Urbem\CoreBundle\Entity\Tcepb\ProgramaObjetivoMilenio $fkTcepbProgramaObjetivoMilenio)
    {
        $fkTcepbProgramaObjetivoMilenio->setFkOrcamentoPrograma($this);
        $this->fkTcepbProgramaObjetivoMilenio = $fkTcepbProgramaObjetivoMilenio;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcepbProgramaObjetivoMilenio
     *
     * @return \Urbem\CoreBundle\Entity\Tcepb\ProgramaObjetivoMilenio
     */
    public function getFkTcepbProgramaObjetivoMilenio()
    {
        return $this->fkTcepbProgramaObjetivoMilenio;
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->codPrograma, $this->descricao);
    }
}
