<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * OrdemPagamentoRetencao
 */
class OrdemPagamentoRetencao
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
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $codOrdem;

    /**
     * PK
     * @var integer
     */
    private $codPlano;

    /**
     * PK
     * @var integer
     */
    private $sequencial;

    /**
     * @var integer
     */
    private $vlRetencao;

    /**
     * @var integer
     */
    private $codReceita;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\LancamentoRetencao
     */
    private $fkContabilidadeLancamentoRetencoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornadaOrdemPagamentoRetencao
     */
    private $fkTesourariaArrecadacaoEstornadaOrdemPagamentoRetencoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoOrdemPagamentoRetencao
     */
    private $fkTesourariaArrecadacaoOrdemPagamentoRetencoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaOrdemPagamentoRetencao
     */
    private $fkTesourariaTransferenciaOrdemPagamentoRetencoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornadaOrdemPagamentoRetencao
     */
    private $fkTesourariaTransferenciaEstornadaOrdemPagamentoRetencoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Receita
     */
    private $fkOrcamentoReceita;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    private $fkContabilidadePlanoAnalitica;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\OrdemPagamento
     */
    private $fkEmpenhoOrdemPagamento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkContabilidadeLancamentoRetencoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaArrecadacaoEstornadaOrdemPagamentoRetencoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaArrecadacaoOrdemPagamentoRetencoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaTransferenciaOrdemPagamentoRetencoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaTransferenciaEstornadaOrdemPagamentoRetencoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return OrdemPagamentoRetencao
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return OrdemPagamentoRetencao
     */
    public function setCodEntidade($codEntidade)
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
     * Set codOrdem
     *
     * @param integer $codOrdem
     * @return OrdemPagamentoRetencao
     */
    public function setCodOrdem($codOrdem)
    {
        $this->codOrdem = $codOrdem;
        return $this;
    }

    /**
     * Get codOrdem
     *
     * @return integer
     */
    public function getCodOrdem()
    {
        return $this->codOrdem;
    }

    /**
     * Set codPlano
     *
     * @param integer $codPlano
     * @return OrdemPagamentoRetencao
     */
    public function setCodPlano($codPlano)
    {
        $this->codPlano = $codPlano;
        return $this;
    }

    /**
     * Get codPlano
     *
     * @return integer
     */
    public function getCodPlano()
    {
        return $this->codPlano;
    }

    /**
     * Set sequencial
     *
     * @param integer $sequencial
     * @return OrdemPagamentoRetencao
     */
    public function setSequencial($sequencial)
    {
        $this->sequencial = $sequencial;
        return $this;
    }

    /**
     * Get sequencial
     *
     * @return integer
     */
    public function getSequencial()
    {
        return $this->sequencial;
    }

    /**
     * Set vlRetencao
     *
     * @param integer $vlRetencao
     * @return OrdemPagamentoRetencao
     */
    public function setVlRetencao($vlRetencao)
    {
        $this->vlRetencao = $vlRetencao;
        return $this;
    }

    /**
     * Get vlRetencao
     *
     * @return integer
     */
    public function getVlRetencao()
    {
        return $this->vlRetencao;
    }

    /**
     * Set codReceita
     *
     * @param integer $codReceita
     * @return OrdemPagamentoRetencao
     */
    public function setCodReceita($codReceita = null)
    {
        $this->codReceita = $codReceita;
        return $this;
    }

    /**
     * Get codReceita
     *
     * @return integer
     */
    public function getCodReceita()
    {
        return $this->codReceita;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeLancamentoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LancamentoRetencao $fkContabilidadeLancamentoRetencao
     * @return OrdemPagamentoRetencao
     */
    public function addFkContabilidadeLancamentoRetencoes(\Urbem\CoreBundle\Entity\Contabilidade\LancamentoRetencao $fkContabilidadeLancamentoRetencao)
    {
        if (false === $this->fkContabilidadeLancamentoRetencoes->contains($fkContabilidadeLancamentoRetencao)) {
            $fkContabilidadeLancamentoRetencao->setFkEmpenhoOrdemPagamentoRetencao($this);
            $this->fkContabilidadeLancamentoRetencoes->add($fkContabilidadeLancamentoRetencao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeLancamentoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LancamentoRetencao $fkContabilidadeLancamentoRetencao
     */
    public function removeFkContabilidadeLancamentoRetencoes(\Urbem\CoreBundle\Entity\Contabilidade\LancamentoRetencao $fkContabilidadeLancamentoRetencao)
    {
        $this->fkContabilidadeLancamentoRetencoes->removeElement($fkContabilidadeLancamentoRetencao);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeLancamentoRetencoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\LancamentoRetencao
     */
    public function getFkContabilidadeLancamentoRetencoes()
    {
        return $this->fkContabilidadeLancamentoRetencoes;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaArrecadacaoEstornadaOrdemPagamentoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornadaOrdemPagamentoRetencao $fkTesourariaArrecadacaoEstornadaOrdemPagamentoRetencao
     * @return OrdemPagamentoRetencao
     */
    public function addFkTesourariaArrecadacaoEstornadaOrdemPagamentoRetencoes(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornadaOrdemPagamentoRetencao $fkTesourariaArrecadacaoEstornadaOrdemPagamentoRetencao)
    {
        if (false === $this->fkTesourariaArrecadacaoEstornadaOrdemPagamentoRetencoes->contains($fkTesourariaArrecadacaoEstornadaOrdemPagamentoRetencao)) {
            $fkTesourariaArrecadacaoEstornadaOrdemPagamentoRetencao->setFkEmpenhoOrdemPagamentoRetencao($this);
            $this->fkTesourariaArrecadacaoEstornadaOrdemPagamentoRetencoes->add($fkTesourariaArrecadacaoEstornadaOrdemPagamentoRetencao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaArrecadacaoEstornadaOrdemPagamentoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornadaOrdemPagamentoRetencao $fkTesourariaArrecadacaoEstornadaOrdemPagamentoRetencao
     */
    public function removeFkTesourariaArrecadacaoEstornadaOrdemPagamentoRetencoes(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornadaOrdemPagamentoRetencao $fkTesourariaArrecadacaoEstornadaOrdemPagamentoRetencao)
    {
        $this->fkTesourariaArrecadacaoEstornadaOrdemPagamentoRetencoes->removeElement($fkTesourariaArrecadacaoEstornadaOrdemPagamentoRetencao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaArrecadacaoEstornadaOrdemPagamentoRetencoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornadaOrdemPagamentoRetencao
     */
    public function getFkTesourariaArrecadacaoEstornadaOrdemPagamentoRetencoes()
    {
        return $this->fkTesourariaArrecadacaoEstornadaOrdemPagamentoRetencoes;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaArrecadacaoOrdemPagamentoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoOrdemPagamentoRetencao $fkTesourariaArrecadacaoOrdemPagamentoRetencao
     * @return OrdemPagamentoRetencao
     */
    public function addFkTesourariaArrecadacaoOrdemPagamentoRetencoes(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoOrdemPagamentoRetencao $fkTesourariaArrecadacaoOrdemPagamentoRetencao)
    {
        if (false === $this->fkTesourariaArrecadacaoOrdemPagamentoRetencoes->contains($fkTesourariaArrecadacaoOrdemPagamentoRetencao)) {
            $fkTesourariaArrecadacaoOrdemPagamentoRetencao->setFkEmpenhoOrdemPagamentoRetencao($this);
            $this->fkTesourariaArrecadacaoOrdemPagamentoRetencoes->add($fkTesourariaArrecadacaoOrdemPagamentoRetencao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaArrecadacaoOrdemPagamentoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoOrdemPagamentoRetencao $fkTesourariaArrecadacaoOrdemPagamentoRetencao
     */
    public function removeFkTesourariaArrecadacaoOrdemPagamentoRetencoes(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoOrdemPagamentoRetencao $fkTesourariaArrecadacaoOrdemPagamentoRetencao)
    {
        $this->fkTesourariaArrecadacaoOrdemPagamentoRetencoes->removeElement($fkTesourariaArrecadacaoOrdemPagamentoRetencao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaArrecadacaoOrdemPagamentoRetencoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoOrdemPagamentoRetencao
     */
    public function getFkTesourariaArrecadacaoOrdemPagamentoRetencoes()
    {
        return $this->fkTesourariaArrecadacaoOrdemPagamentoRetencoes;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaTransferenciaOrdemPagamentoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransferenciaOrdemPagamentoRetencao $fkTesourariaTransferenciaOrdemPagamentoRetencao
     * @return OrdemPagamentoRetencao
     */
    public function addFkTesourariaTransferenciaOrdemPagamentoRetencoes(\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaOrdemPagamentoRetencao $fkTesourariaTransferenciaOrdemPagamentoRetencao)
    {
        if (false === $this->fkTesourariaTransferenciaOrdemPagamentoRetencoes->contains($fkTesourariaTransferenciaOrdemPagamentoRetencao)) {
            $fkTesourariaTransferenciaOrdemPagamentoRetencao->setFkEmpenhoOrdemPagamentoRetencao($this);
            $this->fkTesourariaTransferenciaOrdemPagamentoRetencoes->add($fkTesourariaTransferenciaOrdemPagamentoRetencao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaTransferenciaOrdemPagamentoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransferenciaOrdemPagamentoRetencao $fkTesourariaTransferenciaOrdemPagamentoRetencao
     */
    public function removeFkTesourariaTransferenciaOrdemPagamentoRetencoes(\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaOrdemPagamentoRetencao $fkTesourariaTransferenciaOrdemPagamentoRetencao)
    {
        $this->fkTesourariaTransferenciaOrdemPagamentoRetencoes->removeElement($fkTesourariaTransferenciaOrdemPagamentoRetencao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaTransferenciaOrdemPagamentoRetencoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaOrdemPagamentoRetencao
     */
    public function getFkTesourariaTransferenciaOrdemPagamentoRetencoes()
    {
        return $this->fkTesourariaTransferenciaOrdemPagamentoRetencoes;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaTransferenciaEstornadaOrdemPagamentoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornadaOrdemPagamentoRetencao $fkTesourariaTransferenciaEstornadaOrdemPagamentoRetencao
     * @return OrdemPagamentoRetencao
     */
    public function addFkTesourariaTransferenciaEstornadaOrdemPagamentoRetencoes(\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornadaOrdemPagamentoRetencao $fkTesourariaTransferenciaEstornadaOrdemPagamentoRetencao)
    {
        if (false === $this->fkTesourariaTransferenciaEstornadaOrdemPagamentoRetencoes->contains($fkTesourariaTransferenciaEstornadaOrdemPagamentoRetencao)) {
            $fkTesourariaTransferenciaEstornadaOrdemPagamentoRetencao->setFkEmpenhoOrdemPagamentoRetencao($this);
            $this->fkTesourariaTransferenciaEstornadaOrdemPagamentoRetencoes->add($fkTesourariaTransferenciaEstornadaOrdemPagamentoRetencao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaTransferenciaEstornadaOrdemPagamentoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornadaOrdemPagamentoRetencao $fkTesourariaTransferenciaEstornadaOrdemPagamentoRetencao
     */
    public function removeFkTesourariaTransferenciaEstornadaOrdemPagamentoRetencoes(\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornadaOrdemPagamentoRetencao $fkTesourariaTransferenciaEstornadaOrdemPagamentoRetencao)
    {
        $this->fkTesourariaTransferenciaEstornadaOrdemPagamentoRetencoes->removeElement($fkTesourariaTransferenciaEstornadaOrdemPagamentoRetencao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaTransferenciaEstornadaOrdemPagamentoRetencoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornadaOrdemPagamentoRetencao
     */
    public function getFkTesourariaTransferenciaEstornadaOrdemPagamentoRetencoes()
    {
        return $this->fkTesourariaTransferenciaEstornadaOrdemPagamentoRetencoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita
     * @return OrdemPagamentoRetencao
     */
    public function setFkOrcamentoReceita(\Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita)
    {
        $this->exercicio = $fkOrcamentoReceita->getExercicio();
        $this->codReceita = $fkOrcamentoReceita->getCodReceita();
        $this->fkOrcamentoReceita = $fkOrcamentoReceita;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoReceita
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Receita
     */
    public function getFkOrcamentoReceita()
    {
        return $this->fkOrcamentoReceita;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadePlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica
     * @return OrdemPagamentoRetencao
     */
    public function setFkContabilidadePlanoAnalitica(\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica)
    {
        $this->codPlano = $fkContabilidadePlanoAnalitica->getCodPlano();
        $this->exercicio = $fkContabilidadePlanoAnalitica->getExercicio();
        $this->fkContabilidadePlanoAnalitica = $fkContabilidadePlanoAnalitica;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadePlanoAnalitica
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    public function getFkContabilidadePlanoAnalitica()
    {
        return $this->fkContabilidadePlanoAnalitica;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoOrdemPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\OrdemPagamento $fkEmpenhoOrdemPagamento
     * @return OrdemPagamentoRetencao
     */
    public function setFkEmpenhoOrdemPagamento(\Urbem\CoreBundle\Entity\Empenho\OrdemPagamento $fkEmpenhoOrdemPagamento)
    {
        $this->codOrdem = $fkEmpenhoOrdemPagamento->getCodOrdem();
        $this->exercicio = $fkEmpenhoOrdemPagamento->getExercicio();
        $this->codEntidade = $fkEmpenhoOrdemPagamento->getCodEntidade();
        $this->fkEmpenhoOrdemPagamento = $fkEmpenhoOrdemPagamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoOrdemPagamento
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\OrdemPagamento
     */
    public function getFkEmpenhoOrdemPagamento()
    {
        return $this->fkEmpenhoOrdemPagamento;
    }
}
