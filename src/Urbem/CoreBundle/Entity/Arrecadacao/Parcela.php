<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * Parcela
 */
class Parcela
{
    /**
     * PK
     * @var integer
     */
    private $codParcela;

    /**
     * @var integer
     */
    private $codLancamento;

    /**
     * @var integer
     */
    private $nrParcela;

    /**
     * @var \DateTime
     */
    private $vencimento;

    /**
     * @var integer
     */
    private $valor;

    /**
     * @var integer
     */
    private $iDebito;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\ParcelaDesconto
     */
    private $fkArrecadacaoParcelaDesconto;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Carne
     */
    private $fkArrecadacaoCarnes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ParcelaDocumento
     */
    private $fkArrecadacaoParcelaDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ParcelaReemissao
     */
    private $fkArrecadacaoParcelaReemissoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ParcelaOrigem
     */
    private $fkDividaParcelaOrigens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ParcelaProrrogacao
     */
    private $fkArrecadacaoParcelaProrrogacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Lancamento
     */
    private $fkArrecadacaoLancamento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoCarnes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoParcelaDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoParcelaReemissoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaParcelaOrigens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoParcelaProrrogacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codParcela
     *
     * @param integer $codParcela
     * @return Parcela
     */
    public function setCodParcela($codParcela)
    {
        $this->codParcela = $codParcela;
        return $this;
    }

    /**
     * Get codParcela
     *
     * @return integer
     */
    public function getCodParcela()
    {
        return $this->codParcela;
    }

    /**
     * Set codLancamento
     *
     * @param integer $codLancamento
     * @return Parcela
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
     * Set nrParcela
     *
     * @param integer $nrParcela
     * @return Parcela
     */
    public function setNrParcela($nrParcela)
    {
        $this->nrParcela = $nrParcela;
        return $this;
    }

    /**
     * Get nrParcela
     *
     * @return integer
     */
    public function getNrParcela()
    {
        return $this->nrParcela;
    }

    /**
     * Set vencimento
     *
     * @param \DateTime $vencimento
     * @return Parcela
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
     * Set valor
     *
     * @param integer $valor
     * @return Parcela
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
     * Set iDebito
     *
     * @param integer $iDebito
     * @return Parcela
     */
    public function setIDebito($iDebito = null)
    {
        $this->iDebito = $iDebito;
        return $this;
    }

    /**
     * Get iDebito
     *
     * @return integer
     */
    public function getIDebito()
    {
        return $this->iDebito;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoCarne
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Carne $fkArrecadacaoCarne
     * @return Parcela
     */
    public function addFkArrecadacaoCarnes(\Urbem\CoreBundle\Entity\Arrecadacao\Carne $fkArrecadacaoCarne)
    {
        if (false === $this->fkArrecadacaoCarnes->contains($fkArrecadacaoCarne)) {
            $fkArrecadacaoCarne->setFkArrecadacaoParcela($this);
            $this->fkArrecadacaoCarnes->add($fkArrecadacaoCarne);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoCarne
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Carne $fkArrecadacaoCarne
     */
    public function removeFkArrecadacaoCarnes(\Urbem\CoreBundle\Entity\Arrecadacao\Carne $fkArrecadacaoCarne)
    {
        $this->fkArrecadacaoCarnes->removeElement($fkArrecadacaoCarne);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoCarnes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Carne
     */
    public function getFkArrecadacaoCarnes()
    {
        return $this->fkArrecadacaoCarnes;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoParcelaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ParcelaDocumento $fkArrecadacaoParcelaDocumento
     * @return Parcela
     */
    public function addFkArrecadacaoParcelaDocumentos(\Urbem\CoreBundle\Entity\Arrecadacao\ParcelaDocumento $fkArrecadacaoParcelaDocumento)
    {
        if (false === $this->fkArrecadacaoParcelaDocumentos->contains($fkArrecadacaoParcelaDocumento)) {
            $fkArrecadacaoParcelaDocumento->setFkArrecadacaoParcela($this);
            $this->fkArrecadacaoParcelaDocumentos->add($fkArrecadacaoParcelaDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoParcelaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ParcelaDocumento $fkArrecadacaoParcelaDocumento
     */
    public function removeFkArrecadacaoParcelaDocumentos(\Urbem\CoreBundle\Entity\Arrecadacao\ParcelaDocumento $fkArrecadacaoParcelaDocumento)
    {
        $this->fkArrecadacaoParcelaDocumentos->removeElement($fkArrecadacaoParcelaDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoParcelaDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ParcelaDocumento
     */
    public function getFkArrecadacaoParcelaDocumentos()
    {
        return $this->fkArrecadacaoParcelaDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoParcelaReemissao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ParcelaReemissao $fkArrecadacaoParcelaReemissao
     * @return Parcela
     */
    public function addFkArrecadacaoParcelaReemissoes(\Urbem\CoreBundle\Entity\Arrecadacao\ParcelaReemissao $fkArrecadacaoParcelaReemissao)
    {
        if (false === $this->fkArrecadacaoParcelaReemissoes->contains($fkArrecadacaoParcelaReemissao)) {
            $fkArrecadacaoParcelaReemissao->setFkArrecadacaoParcela($this);
            $this->fkArrecadacaoParcelaReemissoes->add($fkArrecadacaoParcelaReemissao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoParcelaReemissao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ParcelaReemissao $fkArrecadacaoParcelaReemissao
     */
    public function removeFkArrecadacaoParcelaReemissoes(\Urbem\CoreBundle\Entity\Arrecadacao\ParcelaReemissao $fkArrecadacaoParcelaReemissao)
    {
        $this->fkArrecadacaoParcelaReemissoes->removeElement($fkArrecadacaoParcelaReemissao);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoParcelaReemissoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ParcelaReemissao
     */
    public function getFkArrecadacaoParcelaReemissoes()
    {
        return $this->fkArrecadacaoParcelaReemissoes;
    }

    /**
     * OneToMany (owning side)
     * Add DividaParcelaOrigem
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ParcelaOrigem $fkDividaParcelaOrigem
     * @return Parcela
     */
    public function addFkDividaParcelaOrigens(\Urbem\CoreBundle\Entity\Divida\ParcelaOrigem $fkDividaParcelaOrigem)
    {
        if (false === $this->fkDividaParcelaOrigens->contains($fkDividaParcelaOrigem)) {
            $fkDividaParcelaOrigem->setFkArrecadacaoParcela($this);
            $this->fkDividaParcelaOrigens->add($fkDividaParcelaOrigem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaParcelaOrigem
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ParcelaOrigem $fkDividaParcelaOrigem
     */
    public function removeFkDividaParcelaOrigens(\Urbem\CoreBundle\Entity\Divida\ParcelaOrigem $fkDividaParcelaOrigem)
    {
        $this->fkDividaParcelaOrigens->removeElement($fkDividaParcelaOrigem);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaParcelaOrigens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ParcelaOrigem
     */
    public function getFkDividaParcelaOrigens()
    {
        return $this->fkDividaParcelaOrigens;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoParcelaProrrogacao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ParcelaProrrogacao $fkArrecadacaoParcelaProrrogacao
     * @return Parcela
     */
    public function addFkArrecadacaoParcelaProrrogacoes(\Urbem\CoreBundle\Entity\Arrecadacao\ParcelaProrrogacao $fkArrecadacaoParcelaProrrogacao)
    {
        if (false === $this->fkArrecadacaoParcelaProrrogacoes->contains($fkArrecadacaoParcelaProrrogacao)) {
            $fkArrecadacaoParcelaProrrogacao->setFkArrecadacaoParcela($this);
            $this->fkArrecadacaoParcelaProrrogacoes->add($fkArrecadacaoParcelaProrrogacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoParcelaProrrogacao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ParcelaProrrogacao $fkArrecadacaoParcelaProrrogacao
     */
    public function removeFkArrecadacaoParcelaProrrogacoes(\Urbem\CoreBundle\Entity\Arrecadacao\ParcelaProrrogacao $fkArrecadacaoParcelaProrrogacao)
    {
        $this->fkArrecadacaoParcelaProrrogacoes->removeElement($fkArrecadacaoParcelaProrrogacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoParcelaProrrogacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ParcelaProrrogacao
     */
    public function getFkArrecadacaoParcelaProrrogacoes()
    {
        return $this->fkArrecadacaoParcelaProrrogacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Lancamento $fkArrecadacaoLancamento
     * @return Parcela
     */
    public function setFkArrecadacaoLancamento(\Urbem\CoreBundle\Entity\Arrecadacao\Lancamento $fkArrecadacaoLancamento)
    {
        $this->codLancamento = $fkArrecadacaoLancamento->getCodLancamento();
        $this->fkArrecadacaoLancamento = $fkArrecadacaoLancamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoLancamento
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Lancamento
     */
    public function getFkArrecadacaoLancamento()
    {
        return $this->fkArrecadacaoLancamento;
    }

    /**
     * OneToOne (inverse side)
     * Set ArrecadacaoParcelaDesconto
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ParcelaDesconto $fkArrecadacaoParcelaDesconto
     * @return Parcela
     */
    public function setFkArrecadacaoParcelaDesconto(\Urbem\CoreBundle\Entity\Arrecadacao\ParcelaDesconto $fkArrecadacaoParcelaDesconto)
    {
        $fkArrecadacaoParcelaDesconto->setFkArrecadacaoParcela($this);
        $this->fkArrecadacaoParcelaDesconto = $fkArrecadacaoParcelaDesconto;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkArrecadacaoParcelaDesconto
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\ParcelaDesconto
     */
    public function getFkArrecadacaoParcelaDesconto()
    {
        return $this->fkArrecadacaoParcelaDesconto;
    }
}
