<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * ContaReceita
 */
class ContaReceita
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
    private $codConta;

    /**
     * @var integer
     */
    private $codNorma;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var string
     */
    private $codEstrutural;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfIrrfContaReceita
     */
    private $fkImaConfiguracaoDirfIrrfContaReceita;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcerj\ContaReceita
     */
    private $fkTcerjContaReceita;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoReceita
     */
    private $fkContabilidadeConfiguracaoLancamentoReceitas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\ClassificacaoReceita
     */
    private $fkOrcamentoClassificacaoReceitas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\Receita
     */
    private $fkOrcamentoReceitas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkContabilidadeConfiguracaoLancamentoReceitas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoClassificacaoReceitas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoReceitas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ContaReceita
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
     * Set codConta
     *
     * @param integer $codConta
     * @return ContaReceita
     */
    public function setCodConta($codConta)
    {
        $this->codConta = $codConta;
        return $this;
    }

    /**
     * Get codConta
     *
     * @return integer
     */
    public function getCodConta()
    {
        return $this->codConta;
    }

    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return ContaReceita
     */
    public function setCodNorma($codNorma = null)
    {
        $this->codNorma = $codNorma;
        return $this;
    }

    /**
     * Get codNorma
     *
     * @return integer
     */
    public function getCodNorma()
    {
        return $this->codNorma;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return ContaReceita
     */
    public function setDescricao($descricao = null)
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
     * Set codEstrutural
     *
     * @param string $codEstrutural
     * @return ContaReceita
     */
    public function setCodEstrutural($codEstrutural)
    {
        $this->codEstrutural = $codEstrutural;
        return $this;
    }

    /**
     * Get codEstrutural
     *
     * @return string
     */
    public function getCodEstrutural()
    {
        return $this->codEstrutural;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeConfiguracaoLancamentoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoReceita $fkContabilidadeConfiguracaoLancamentoReceita
     * @return ContaReceita
     */
    public function addFkContabilidadeConfiguracaoLancamentoReceitas(\Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoReceita $fkContabilidadeConfiguracaoLancamentoReceita)
    {
        if (false === $this->fkContabilidadeConfiguracaoLancamentoReceitas->contains($fkContabilidadeConfiguracaoLancamentoReceita)) {
            $fkContabilidadeConfiguracaoLancamentoReceita->setFkOrcamentoContaReceita($this);
            $this->fkContabilidadeConfiguracaoLancamentoReceitas->add($fkContabilidadeConfiguracaoLancamentoReceita);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeConfiguracaoLancamentoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoReceita $fkContabilidadeConfiguracaoLancamentoReceita
     */
    public function removeFkContabilidadeConfiguracaoLancamentoReceitas(\Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoReceita $fkContabilidadeConfiguracaoLancamentoReceita)
    {
        $this->fkContabilidadeConfiguracaoLancamentoReceitas->removeElement($fkContabilidadeConfiguracaoLancamentoReceita);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeConfiguracaoLancamentoReceitas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoReceita
     */
    public function getFkContabilidadeConfiguracaoLancamentoReceitas()
    {
        return $this->fkContabilidadeConfiguracaoLancamentoReceitas;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoClassificacaoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ClassificacaoReceita $fkOrcamentoClassificacaoReceita
     * @return ContaReceita
     */
    public function addFkOrcamentoClassificacaoReceitas(\Urbem\CoreBundle\Entity\Orcamento\ClassificacaoReceita $fkOrcamentoClassificacaoReceita)
    {
        if (false === $this->fkOrcamentoClassificacaoReceitas->contains($fkOrcamentoClassificacaoReceita)) {
            $fkOrcamentoClassificacaoReceita->setFkOrcamentoContaReceita($this);
            $this->fkOrcamentoClassificacaoReceitas->add($fkOrcamentoClassificacaoReceita);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoClassificacaoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ClassificacaoReceita $fkOrcamentoClassificacaoReceita
     */
    public function removeFkOrcamentoClassificacaoReceitas(\Urbem\CoreBundle\Entity\Orcamento\ClassificacaoReceita $fkOrcamentoClassificacaoReceita)
    {
        $this->fkOrcamentoClassificacaoReceitas->removeElement($fkOrcamentoClassificacaoReceita);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoClassificacaoReceitas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\ClassificacaoReceita
     */
    public function getFkOrcamentoClassificacaoReceitas()
    {
        return $this->fkOrcamentoClassificacaoReceitas;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita
     * @return ContaReceita
     */
    public function addFkOrcamentoReceitas(\Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita)
    {
        if (false === $this->fkOrcamentoReceitas->contains($fkOrcamentoReceita)) {
            $fkOrcamentoReceita->setFkOrcamentoContaReceita($this);
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
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return ContaReceita
     */
    public function setFkNormasNorma(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        $this->codNorma = $fkNormasNorma->getCodNorma();
        $this->fkNormasNorma = $fkNormasNorma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNorma()
    {
        return $this->fkNormasNorma;
    }

    /**
     * OneToOne (inverse side)
     * Set ImaConfiguracaoDirfIrrfContaReceita
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfIrrfContaReceita $fkImaConfiguracaoDirfIrrfContaReceita
     * @return ContaReceita
     */
    public function setFkImaConfiguracaoDirfIrrfContaReceita(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfIrrfContaReceita $fkImaConfiguracaoDirfIrrfContaReceita)
    {
        $fkImaConfiguracaoDirfIrrfContaReceita->setFkOrcamentoContaReceita($this);
        $this->fkImaConfiguracaoDirfIrrfContaReceita = $fkImaConfiguracaoDirfIrrfContaReceita;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkImaConfiguracaoDirfIrrfContaReceita
     *
     * @return \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfIrrfContaReceita
     */
    public function getFkImaConfiguracaoDirfIrrfContaReceita()
    {
        return $this->fkImaConfiguracaoDirfIrrfContaReceita;
    }

    /**
     * OneToOne (inverse side)
     * Set TcerjContaReceita
     *
     * @param \Urbem\CoreBundle\Entity\Tcerj\ContaReceita $fkTcerjContaReceita
     * @return ContaReceita
     */
    public function setFkTcerjContaReceita(\Urbem\CoreBundle\Entity\Tcerj\ContaReceita $fkTcerjContaReceita)
    {
        $fkTcerjContaReceita->setFkOrcamentoContaReceita($this);
        $this->fkTcerjContaReceita = $fkTcerjContaReceita;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcerjContaReceita
     *
     * @return \Urbem\CoreBundle\Entity\Tcerj\ContaReceita
     */
    public function getFkTcerjContaReceita()
    {
        return $this->fkTcerjContaReceita;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->codEstrutural, $this->descricao);
    }
}
