<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * Subfuncao
 */
class Subfuncao
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
    private $codSubfuncao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\AcaoDados
     */
    private $fkPpaAcaoDados;

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
        $this->fkPpaAcaoDados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoDespesas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Subfuncao
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
     * Set codSubfuncao
     *
     * @param integer $codSubfuncao
     * @return Subfuncao
     */
    public function setCodSubfuncao($codSubfuncao)
    {
        $this->codSubfuncao = $codSubfuncao;
        return $this;
    }

    /**
     * Get codSubfuncao
     *
     * @return integer
     */
    public function getCodSubfuncao()
    {
        return $this->codSubfuncao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Subfuncao
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
     * Add PpaAcaoDados
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\AcaoDados $fkPpaAcaoDados
     * @return Subfuncao
     */
    public function addFkPpaAcaoDados(\Urbem\CoreBundle\Entity\Ppa\AcaoDados $fkPpaAcaoDados)
    {
        if (false === $this->fkPpaAcaoDados->contains($fkPpaAcaoDados)) {
            $fkPpaAcaoDados->setFkOrcamentoSubfuncao($this);
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
     * Add OrcamentoDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa
     * @return Subfuncao
     */
    public function addFkOrcamentoDespesas(\Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa)
    {
        if (false === $this->fkOrcamentoDespesas->contains($fkOrcamentoDespesa)) {
            $fkOrcamentoDespesa->setFkOrcamentoSubfuncao($this);
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
     * @return string
     */
    public function getCodigoSubfuncao()
    {
        return str_pad($this->codSubfuncao, 3, '0', STR_PAD_LEFT);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->getCodigoSubfuncao(), $this->descricao);
    }
}
