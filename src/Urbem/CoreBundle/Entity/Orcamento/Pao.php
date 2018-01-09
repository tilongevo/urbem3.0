<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * Pao
 */
class Pao
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
    private $numPao;

    /**
     * @var string
     */
    private $nomPao;

    /**
     * @var string
     */
    private $detalhamento;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Orcamento\PaoPpaAcao
     */
    private $fkOrcamentoPaoPpaAcao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaAtributoValor
     */
    private $fkFolhapagamentoConfiguracaoEmpenhoLlaAtributoValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLocal
     */
    private $fkFolhapagamentoConfiguracaoEmpenhoLlaLocais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLotacao
     */
    private $fkFolhapagamentoConfiguracaoEmpenhoLlaLotacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenho
     */
    private $fkFolhapagamentoConfiguracaoEmpenhos;

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
        $this->fkFolhapagamentoConfiguracaoEmpenhoLlaAtributoValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoEmpenhoLlaLocais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoEmpenhoLlaLotacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoDespesas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Pao
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
     * Set numPao
     *
     * @param integer $numPao
     * @return Pao
     */
    public function setNumPao($numPao)
    {
        $this->numPao = $numPao;
        return $this;
    }

    /**
     * Get numPao
     *
     * @return integer
     */
    public function getNumPao()
    {
        return $this->numPao;
    }

    /**
     * Set nomPao
     *
     * @param string $nomPao
     * @return Pao
     */
    public function setNomPao($nomPao)
    {
        $this->nomPao = $nomPao;
        return $this;
    }

    /**
     * Get nomPao
     *
     * @return string
     */
    public function getNomPao()
    {
        return $this->nomPao;
    }

    /**
     * Set detalhamento
     *
     * @param string $detalhamento
     * @return Pao
     */
    public function setDetalhamento($detalhamento)
    {
        $this->detalhamento = $detalhamento;
        return $this;
    }

    /**
     * Get detalhamento
     *
     * @return string
     */
    public function getDetalhamento()
    {
        return $this->detalhamento;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoEmpenhoLlaAtributoValor
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaAtributoValor $fkFolhapagamentoConfiguracaoEmpenhoLlaAtributoValor
     * @return Pao
     */
    public function addFkFolhapagamentoConfiguracaoEmpenhoLlaAtributoValores(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaAtributoValor $fkFolhapagamentoConfiguracaoEmpenhoLlaAtributoValor)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEmpenhoLlaAtributoValores->contains($fkFolhapagamentoConfiguracaoEmpenhoLlaAtributoValor)) {
            $fkFolhapagamentoConfiguracaoEmpenhoLlaAtributoValor->setFkOrcamentoPao($this);
            $this->fkFolhapagamentoConfiguracaoEmpenhoLlaAtributoValores->add($fkFolhapagamentoConfiguracaoEmpenhoLlaAtributoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEmpenhoLlaAtributoValor
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaAtributoValor $fkFolhapagamentoConfiguracaoEmpenhoLlaAtributoValor
     */
    public function removeFkFolhapagamentoConfiguracaoEmpenhoLlaAtributoValores(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaAtributoValor $fkFolhapagamentoConfiguracaoEmpenhoLlaAtributoValor)
    {
        $this->fkFolhapagamentoConfiguracaoEmpenhoLlaAtributoValores->removeElement($fkFolhapagamentoConfiguracaoEmpenhoLlaAtributoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEmpenhoLlaAtributoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaAtributoValor
     */
    public function getFkFolhapagamentoConfiguracaoEmpenhoLlaAtributoValores()
    {
        return $this->fkFolhapagamentoConfiguracaoEmpenhoLlaAtributoValores;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoEmpenhoLlaLocal
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLocal $fkFolhapagamentoConfiguracaoEmpenhoLlaLocal
     * @return Pao
     */
    public function addFkFolhapagamentoConfiguracaoEmpenhoLlaLocais(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLocal $fkFolhapagamentoConfiguracaoEmpenhoLlaLocal)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEmpenhoLlaLocais->contains($fkFolhapagamentoConfiguracaoEmpenhoLlaLocal)) {
            $fkFolhapagamentoConfiguracaoEmpenhoLlaLocal->setFkOrcamentoPao($this);
            $this->fkFolhapagamentoConfiguracaoEmpenhoLlaLocais->add($fkFolhapagamentoConfiguracaoEmpenhoLlaLocal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEmpenhoLlaLocal
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLocal $fkFolhapagamentoConfiguracaoEmpenhoLlaLocal
     */
    public function removeFkFolhapagamentoConfiguracaoEmpenhoLlaLocais(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLocal $fkFolhapagamentoConfiguracaoEmpenhoLlaLocal)
    {
        $this->fkFolhapagamentoConfiguracaoEmpenhoLlaLocais->removeElement($fkFolhapagamentoConfiguracaoEmpenhoLlaLocal);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEmpenhoLlaLocais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLocal
     */
    public function getFkFolhapagamentoConfiguracaoEmpenhoLlaLocais()
    {
        return $this->fkFolhapagamentoConfiguracaoEmpenhoLlaLocais;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoEmpenhoLlaLotacao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLotacao $fkFolhapagamentoConfiguracaoEmpenhoLlaLotacao
     * @return Pao
     */
    public function addFkFolhapagamentoConfiguracaoEmpenhoLlaLotacoes(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLotacao $fkFolhapagamentoConfiguracaoEmpenhoLlaLotacao)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEmpenhoLlaLotacoes->contains($fkFolhapagamentoConfiguracaoEmpenhoLlaLotacao)) {
            $fkFolhapagamentoConfiguracaoEmpenhoLlaLotacao->setFkOrcamentoPao($this);
            $this->fkFolhapagamentoConfiguracaoEmpenhoLlaLotacoes->add($fkFolhapagamentoConfiguracaoEmpenhoLlaLotacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEmpenhoLlaLotacao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLotacao $fkFolhapagamentoConfiguracaoEmpenhoLlaLotacao
     */
    public function removeFkFolhapagamentoConfiguracaoEmpenhoLlaLotacoes(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLotacao $fkFolhapagamentoConfiguracaoEmpenhoLlaLotacao)
    {
        $this->fkFolhapagamentoConfiguracaoEmpenhoLlaLotacoes->removeElement($fkFolhapagamentoConfiguracaoEmpenhoLlaLotacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEmpenhoLlaLotacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLotacao
     */
    public function getFkFolhapagamentoConfiguracaoEmpenhoLlaLotacoes()
    {
        return $this->fkFolhapagamentoConfiguracaoEmpenhoLlaLotacoes;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenho $fkFolhapagamentoConfiguracaoEmpenho
     * @return Pao
     */
    public function addFkFolhapagamentoConfiguracaoEmpenhos(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenho $fkFolhapagamentoConfiguracaoEmpenho)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEmpenhos->contains($fkFolhapagamentoConfiguracaoEmpenho)) {
            $fkFolhapagamentoConfiguracaoEmpenho->setFkOrcamentoPao($this);
            $this->fkFolhapagamentoConfiguracaoEmpenhos->add($fkFolhapagamentoConfiguracaoEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenho $fkFolhapagamentoConfiguracaoEmpenho
     */
    public function removeFkFolhapagamentoConfiguracaoEmpenhos(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenho $fkFolhapagamentoConfiguracaoEmpenho)
    {
        $this->fkFolhapagamentoConfiguracaoEmpenhos->removeElement($fkFolhapagamentoConfiguracaoEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenho
     */
    public function getFkFolhapagamentoConfiguracaoEmpenhos()
    {
        return $this->fkFolhapagamentoConfiguracaoEmpenhos;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa
     * @return Pao
     */
    public function addFkOrcamentoDespesas(\Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa)
    {
        if (false === $this->fkOrcamentoDespesas->contains($fkOrcamentoDespesa)) {
            $fkOrcamentoDespesa->setFkOrcamentoPao($this);
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
     * OneToOne (inverse side)
     * Set OrcamentoPaoPpaAcao
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\PaoPpaAcao $fkOrcamentoPaoPpaAcao
     * @return Pao
     */
    public function setFkOrcamentoPaoPpaAcao(\Urbem\CoreBundle\Entity\Orcamento\PaoPpaAcao $fkOrcamentoPaoPpaAcao)
    {
        $fkOrcamentoPaoPpaAcao->setFkOrcamentoPao($this);
        $this->fkOrcamentoPaoPpaAcao = $fkOrcamentoPaoPpaAcao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkOrcamentoPaoPpaAcao
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\PaoPpaAcao
     */
    public function getFkOrcamentoPaoPpaAcao()
    {
        return $this->fkOrcamentoPaoPpaAcao;
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->numPao, $this->nomPao);
    }
}
