<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * Lancamento
 */
class Lancamento
{
    /**
     * PK
     * @var integer
     */
    private $codLancamento;

    /**
     * @var \DateTime
     */
    private $vencimento;

    /**
     * @var integer
     */
    private $totalParcelas;

    /**
     * @var boolean
     */
    private $ativo;

    /**
     * @var string
     */
    private $observacao;

    /**
     * @var integer
     */
    private $valor;

    /**
     * @var string
     */
    private $observacaoSistema;

    /**
     * @var boolean
     */
    private $divida = false;

    /**
     * @var string
     */
    private $situacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Divida\RelatorioRemissaoCredito
     */
    private $fkDividaRelatorioRemissaoCredito;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\LancamentoCalculo
     */
    private $fkArrecadacaoLancamentoCalculos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\LancamentoDesconto
     */
    private $fkArrecadacaoLancamentoDescontos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\LancamentoProcesso
     */
    private $fkArrecadacaoLancamentoProcessos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Parcela
     */
    private $fkArrecadacaoParcelas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Suspensao
     */
    private $fkArrecadacaoSuspensoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoLancamentoCalculos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoLancamentoDescontos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoLancamentoProcessos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoParcelas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoSuspensoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codLancamento
     *
     * @param integer $codLancamento
     * @return Lancamento
     */
    public function setCodLancamento($codLancamento)
    {
        $this->codLancamento = $codLancamento;
        return $this;
    }

    /**
     * Get codLancamento
     *
     * @return integer
     */
    public function getCodLancamento()
    {
        return $this->codLancamento;
    }

    /**
     * Set vencimento
     *
     * @param \DateTime $vencimento
     * @return Lancamento
     */
    public function setVencimento(\DateTime $vencimento)
    {
        $this->vencimento = $vencimento;
        return $this;
    }

    /**
     * Get vencimento
     *
     * @return \DateTime
     */
    public function getVencimento()
    {
        return $this->vencimento;
    }

    /**
     * Set totalParcelas
     *
     * @param integer $totalParcelas
     * @return Lancamento
     */
    public function setTotalParcelas($totalParcelas)
    {
        $this->totalParcelas = $totalParcelas;
        return $this;
    }

    /**
     * Get totalParcelas
     *
     * @return integer
     */
    public function getTotalParcelas()
    {
        return $this->totalParcelas;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return Lancamento
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
     * Set observacao
     *
     * @param string $observacao
     * @return Lancamento
     */
    public function setObservacao($observacao = null)
    {
        $this->observacao = $observacao;
        return $this;
    }

    /**
     * Get observacao
     *
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return Lancamento
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set observacaoSistema
     *
     * @param string $observacaoSistema
     * @return Lancamento
     */
    public function setObservacaoSistema($observacaoSistema = null)
    {
        $this->observacaoSistema = $observacaoSistema;
        return $this;
    }

    /**
     * Get observacaoSistema
     *
     * @return string
     */
    public function getObservacaoSistema()
    {
        return $this->observacaoSistema;
    }

    /**
     * Set divida
     *
     * @param boolean $divida
     * @return Lancamento
     */
    public function setDivida($divida)
    {
        $this->divida = $divida;
        return $this;
    }

    /**
     * Get divida
     *
     * @return boolean
     */
    public function getDivida()
    {
        return $this->divida;
    }

    /**
     * Set situacao
     *
     * @param string $situacao
     * @return Lancamento
     */
    public function setSituacao($situacao = null)
    {
        $this->situacao = $situacao;
        return $this;
    }

    /**
     * Get situacao
     *
     * @return string
     */
    public function getSituacao()
    {
        return $this->situacao;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoLancamentoCalculo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\LancamentoCalculo $fkArrecadacaoLancamentoCalculo
     * @return Lancamento
     */
    public function addFkArrecadacaoLancamentoCalculos(\Urbem\CoreBundle\Entity\Arrecadacao\LancamentoCalculo $fkArrecadacaoLancamentoCalculo)
    {
        if (false === $this->fkArrecadacaoLancamentoCalculos->contains($fkArrecadacaoLancamentoCalculo)) {
            $fkArrecadacaoLancamentoCalculo->setFkArrecadacaoLancamento($this);
            $this->fkArrecadacaoLancamentoCalculos->add($fkArrecadacaoLancamentoCalculo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoLancamentoCalculo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\LancamentoCalculo $fkArrecadacaoLancamentoCalculo
     */
    public function removeFkArrecadacaoLancamentoCalculos(\Urbem\CoreBundle\Entity\Arrecadacao\LancamentoCalculo $fkArrecadacaoLancamentoCalculo)
    {
        $this->fkArrecadacaoLancamentoCalculos->removeElement($fkArrecadacaoLancamentoCalculo);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoLancamentoCalculos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\LancamentoCalculo
     */
    public function getFkArrecadacaoLancamentoCalculos()
    {
        return $this->fkArrecadacaoLancamentoCalculos;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoLancamentoDesconto
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\LancamentoDesconto $fkArrecadacaoLancamentoDesconto
     * @return Lancamento
     */
    public function addFkArrecadacaoLancamentoDescontos(\Urbem\CoreBundle\Entity\Arrecadacao\LancamentoDesconto $fkArrecadacaoLancamentoDesconto)
    {
        if (false === $this->fkArrecadacaoLancamentoDescontos->contains($fkArrecadacaoLancamentoDesconto)) {
            $fkArrecadacaoLancamentoDesconto->setFkArrecadacaoLancamento($this);
            $this->fkArrecadacaoLancamentoDescontos->add($fkArrecadacaoLancamentoDesconto);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoLancamentoDesconto
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\LancamentoDesconto $fkArrecadacaoLancamentoDesconto
     */
    public function removeFkArrecadacaoLancamentoDescontos(\Urbem\CoreBundle\Entity\Arrecadacao\LancamentoDesconto $fkArrecadacaoLancamentoDesconto)
    {
        $this->fkArrecadacaoLancamentoDescontos->removeElement($fkArrecadacaoLancamentoDesconto);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoLancamentoDescontos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\LancamentoDesconto
     */
    public function getFkArrecadacaoLancamentoDescontos()
    {
        return $this->fkArrecadacaoLancamentoDescontos;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoLancamentoProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\LancamentoProcesso $fkArrecadacaoLancamentoProcesso
     * @return Lancamento
     */
    public function addFkArrecadacaoLancamentoProcessos(\Urbem\CoreBundle\Entity\Arrecadacao\LancamentoProcesso $fkArrecadacaoLancamentoProcesso)
    {
        if (false === $this->fkArrecadacaoLancamentoProcessos->contains($fkArrecadacaoLancamentoProcesso)) {
            $fkArrecadacaoLancamentoProcesso->setFkArrecadacaoLancamento($this);
            $this->fkArrecadacaoLancamentoProcessos->add($fkArrecadacaoLancamentoProcesso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoLancamentoProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\LancamentoProcesso $fkArrecadacaoLancamentoProcesso
     */
    public function removeFkArrecadacaoLancamentoProcessos(\Urbem\CoreBundle\Entity\Arrecadacao\LancamentoProcesso $fkArrecadacaoLancamentoProcesso)
    {
        $this->fkArrecadacaoLancamentoProcessos->removeElement($fkArrecadacaoLancamentoProcesso);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoLancamentoProcessos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\LancamentoProcesso
     */
    public function getFkArrecadacaoLancamentoProcessos()
    {
        return $this->fkArrecadacaoLancamentoProcessos;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoParcela
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Parcela $fkArrecadacaoParcela
     * @return Lancamento
     */
    public function addFkArrecadacaoParcelas(\Urbem\CoreBundle\Entity\Arrecadacao\Parcela $fkArrecadacaoParcela)
    {
        if (false === $this->fkArrecadacaoParcelas->contains($fkArrecadacaoParcela)) {
            $fkArrecadacaoParcela->setFkArrecadacaoLancamento($this);
            $this->fkArrecadacaoParcelas->add($fkArrecadacaoParcela);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoParcela
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Parcela $fkArrecadacaoParcela
     */
    public function removeFkArrecadacaoParcelas(\Urbem\CoreBundle\Entity\Arrecadacao\Parcela $fkArrecadacaoParcela)
    {
        $this->fkArrecadacaoParcelas->removeElement($fkArrecadacaoParcela);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoParcelas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Parcela
     */
    public function getFkArrecadacaoParcelas()
    {
        return $this->fkArrecadacaoParcelas;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoSuspensao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Suspensao $fkArrecadacaoSuspensao
     * @return Lancamento
     */
    public function addFkArrecadacaoSuspensoes(\Urbem\CoreBundle\Entity\Arrecadacao\Suspensao $fkArrecadacaoSuspensao)
    {
        if (false === $this->fkArrecadacaoSuspensoes->contains($fkArrecadacaoSuspensao)) {
            $fkArrecadacaoSuspensao->setFkArrecadacaoLancamento($this);
            $this->fkArrecadacaoSuspensoes->add($fkArrecadacaoSuspensao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoSuspensao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Suspensao $fkArrecadacaoSuspensao
     */
    public function removeFkArrecadacaoSuspensoes(\Urbem\CoreBundle\Entity\Arrecadacao\Suspensao $fkArrecadacaoSuspensao)
    {
        $this->fkArrecadacaoSuspensoes->removeElement($fkArrecadacaoSuspensao);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoSuspensoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Suspensao
     */
    public function getFkArrecadacaoSuspensoes()
    {
        return $this->fkArrecadacaoSuspensoes;
    }

    /**
     * OneToOne (inverse side)
     * Set DividaRelatorioRemissaoCredito
     *
     * @param \Urbem\CoreBundle\Entity\Divida\RelatorioRemissaoCredito $fkDividaRelatorioRemissaoCredito
     * @return Lancamento
     */
    public function setFkDividaRelatorioRemissaoCredito(\Urbem\CoreBundle\Entity\Divida\RelatorioRemissaoCredito $fkDividaRelatorioRemissaoCredito)
    {
        $fkDividaRelatorioRemissaoCredito->setFkArrecadacaoLancamento($this);
        $this->fkDividaRelatorioRemissaoCredito = $fkDividaRelatorioRemissaoCredito;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkDividaRelatorioRemissaoCredito
     *
     * @return \Urbem\CoreBundle\Entity\Divida\RelatorioRemissaoCredito
     */
    public function getFkDividaRelatorioRemissaoCredito()
    {
        return $this->fkDividaRelatorioRemissaoCredito;
    }
}
