<?php

namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * Carne
 */
class Carne
{
    /**
     * PK
     * @var string
     */
    private $numeracao;

    /**
     * PK
     * @var integer
     */
    private $codConvenio;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codParcela;

    /**
     * @var integer
     */
    private $codCarteira;

    /**
     * @var boolean
     */
    private $impresso = false;

    /**
     * @var integer
     */
    private $iLancto;

    /**
     * @var integer
     */
    private $iDebito;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\CarneMigracao
     */
    private $fkArrecadacaoCarneMigracao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\CarneLimite
     */
    private $fkArrecadacaoCarneLimites;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\CarneConsolidacao
     */
    private $fkArrecadacaoCarneConsolidacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Pagamento
     */
    private $fkArrecadacaoPagamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoCarne
     */
    private $fkTesourariaArrecadacaoCarnes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\CarneDevolucao
     */
    private $fkArrecadacaoCarneDevolucoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Parcela
     */
    private $fkArrecadacaoParcela;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\Convenio
     */
    private $fkMonetarioConvenio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\Carteira
     */
    private $fkMonetarioCarteira;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoCarneLimites = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoCarneConsolidacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoPagamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaArrecadacaoCarnes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoCarneDevolucoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set numeracao
     *
     * @param string $numeracao
     * @return Carne
     */
    public function setNumeracao($numeracao)
    {
        $this->numeracao = $numeracao;
        return $this;
    }

    /**
     * Get numeracao
     *
     * @return string
     */
    public function getNumeracao()
    {
        return $this->numeracao;
    }

    /**
     * Set codConvenio
     *
     * @param integer $codConvenio
     * @return Carne
     */
    public function setCodConvenio($codConvenio)
    {
        $this->codConvenio = $codConvenio;
        return $this;
    }

    /**
     * Get codConvenio
     *
     * @return integer
     */
    public function getCodConvenio()
    {
        return $this->codConvenio;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Carne
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return Carne
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set codParcela
     *
     * @param integer $codParcela
     * @return Carne
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
     * Set codCarteira
     *
     * @param integer $codCarteira
     * @return Carne
     */
    public function setCodCarteira($codCarteira = null)
    {
        $this->codCarteira = $codCarteira;
        return $this;
    }

    /**
     * Get codCarteira
     *
     * @return integer
     */
    public function getCodCarteira()
    {
        return $this->codCarteira;
    }

    /**
     * Set impresso
     *
     * @param boolean $impresso
     * @return Carne
     */
    public function setImpresso($impresso = null)
    {
        $this->impresso = $impresso;
        return $this;
    }

    /**
     * Get impresso
     *
     * @return boolean
     */
    public function getImpresso()
    {
        return $this->impresso;
    }

    /**
     * Set iLancto
     *
     * @param integer $iLancto
     * @return Carne
     */
    public function setILancto($iLancto = null)
    {
        $this->iLancto = $iLancto;
        return $this;
    }

    /**
     * Get iLancto
     *
     * @return integer
     */
    public function getILancto()
    {
        return $this->iLancto;
    }

    /**
     * Set iDebito
     *
     * @param integer $iDebito
     * @return Carne
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
     * Add ArrecadacaoCarneLimite
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\CarneLimite $fkArrecadacaoCarneLimite
     * @return Carne
     */
    public function addFkArrecadacaoCarneLimites(\Urbem\CoreBundle\Entity\Arrecadacao\CarneLimite $fkArrecadacaoCarneLimite)
    {
        if (false === $this->fkArrecadacaoCarneLimites->contains($fkArrecadacaoCarneLimite)) {
            $fkArrecadacaoCarneLimite->setFkArrecadacaoCarne($this);
            $this->fkArrecadacaoCarneLimites->add($fkArrecadacaoCarneLimite);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoCarneLimite
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\CarneLimite $fkArrecadacaoCarneLimite
     */
    public function removeFkArrecadacaoCarneLimites(\Urbem\CoreBundle\Entity\Arrecadacao\CarneLimite $fkArrecadacaoCarneLimite)
    {
        $this->fkArrecadacaoCarneLimites->removeElement($fkArrecadacaoCarneLimite);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoCarneLimites
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\CarneLimite
     */
    public function getFkArrecadacaoCarneLimites()
    {
        return $this->fkArrecadacaoCarneLimites;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoCarneConsolidacao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\CarneConsolidacao $fkArrecadacaoCarneConsolidacao
     * @return Carne
     */
    public function addFkArrecadacaoCarneConsolidacoes(\Urbem\CoreBundle\Entity\Arrecadacao\CarneConsolidacao $fkArrecadacaoCarneConsolidacao)
    {
        if (false === $this->fkArrecadacaoCarneConsolidacoes->contains($fkArrecadacaoCarneConsolidacao)) {
            $fkArrecadacaoCarneConsolidacao->setFkArrecadacaoCarne($this);
            $this->fkArrecadacaoCarneConsolidacoes->add($fkArrecadacaoCarneConsolidacao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoCarneConsolidacao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\CarneConsolidacao $fkArrecadacaoCarneConsolidacao
     */
    public function removeFkArrecadacaoCarneConsolidacoes(\Urbem\CoreBundle\Entity\Arrecadacao\CarneConsolidacao $fkArrecadacaoCarneConsolidacao)
    {
        $this->fkArrecadacaoCarneConsolidacoes->removeElement($fkArrecadacaoCarneConsolidacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoCarneConsolidacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\CarneConsolidacao
     */
    public function getFkArrecadacaoCarneConsolidacoes()
    {
        return $this->fkArrecadacaoCarneConsolidacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Pagamento $fkArrecadacaoPagamento
     * @return Carne
     */
    public function addFkArrecadacaoPagamentos(\Urbem\CoreBundle\Entity\Arrecadacao\Pagamento $fkArrecadacaoPagamento)
    {
        if (false === $this->fkArrecadacaoPagamentos->contains($fkArrecadacaoPagamento)) {
            $fkArrecadacaoPagamento->setFkArrecadacaoCarne($this);
            $this->fkArrecadacaoPagamentos->add($fkArrecadacaoPagamento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Pagamento $fkArrecadacaoPagamento
     */
    public function removeFkArrecadacaoPagamentos(\Urbem\CoreBundle\Entity\Arrecadacao\Pagamento $fkArrecadacaoPagamento)
    {
        $this->fkArrecadacaoPagamentos->removeElement($fkArrecadacaoPagamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoPagamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Pagamento
     */
    public function getFkArrecadacaoPagamentos()
    {
        return $this->fkArrecadacaoPagamentos;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaArrecadacaoCarne
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoCarne $fkTesourariaArrecadacaoCarne
     * @return Carne
     */
    public function addFkTesourariaArrecadacaoCarnes(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoCarne $fkTesourariaArrecadacaoCarne)
    {
        if (false === $this->fkTesourariaArrecadacaoCarnes->contains($fkTesourariaArrecadacaoCarne)) {
            $fkTesourariaArrecadacaoCarne->setFkArrecadacaoCarne($this);
            $this->fkTesourariaArrecadacaoCarnes->add($fkTesourariaArrecadacaoCarne);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaArrecadacaoCarne
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoCarne $fkTesourariaArrecadacaoCarne
     */
    public function removeFkTesourariaArrecadacaoCarnes(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoCarne $fkTesourariaArrecadacaoCarne)
    {
        $this->fkTesourariaArrecadacaoCarnes->removeElement($fkTesourariaArrecadacaoCarne);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaArrecadacaoCarnes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoCarne
     */
    public function getFkTesourariaArrecadacaoCarnes()
    {
        return $this->fkTesourariaArrecadacaoCarnes;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoCarneDevolucao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\CarneDevolucao $fkArrecadacaoCarneDevolucao
     * @return Carne
     */
    public function addFkArrecadacaoCarneDevolucoes(\Urbem\CoreBundle\Entity\Arrecadacao\CarneDevolucao $fkArrecadacaoCarneDevolucao)
    {
        if (false === $this->fkArrecadacaoCarneDevolucoes->contains($fkArrecadacaoCarneDevolucao)) {
            $fkArrecadacaoCarneDevolucao->setFkArrecadacaoCarne($this);
            $this->fkArrecadacaoCarneDevolucoes->add($fkArrecadacaoCarneDevolucao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoCarneDevolucao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\CarneDevolucao $fkArrecadacaoCarneDevolucao
     */
    public function removeFkArrecadacaoCarneDevolucoes(\Urbem\CoreBundle\Entity\Arrecadacao\CarneDevolucao $fkArrecadacaoCarneDevolucao)
    {
        $this->fkArrecadacaoCarneDevolucoes->removeElement($fkArrecadacaoCarneDevolucao);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoCarneDevolucoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\CarneDevolucao
     */
    public function getFkArrecadacaoCarneDevolucoes()
    {
        return $this->fkArrecadacaoCarneDevolucoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoParcela
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Parcela $fkArrecadacaoParcela
     * @return Carne
     */
    public function setFkArrecadacaoParcela(\Urbem\CoreBundle\Entity\Arrecadacao\Parcela $fkArrecadacaoParcela)
    {
        $this->codParcela = $fkArrecadacaoParcela->getCodParcela();
        $this->fkArrecadacaoParcela = $fkArrecadacaoParcela;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoParcela
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Parcela
     */
    public function getFkArrecadacaoParcela()
    {
        return $this->fkArrecadacaoParcela;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Convenio $fkMonetarioConvenio
     * @return Carne
     */
    public function setFkMonetarioConvenio(\Urbem\CoreBundle\Entity\Monetario\Convenio $fkMonetarioConvenio)
    {
        $this->codConvenio = $fkMonetarioConvenio->getCodConvenio();
        $this->fkMonetarioConvenio = $fkMonetarioConvenio;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioConvenio
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\Convenio
     */
    public function getFkMonetarioConvenio()
    {
        return $this->fkMonetarioConvenio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioCarteira
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Carteira $fkMonetarioCarteira
     * @return Carne
     */
    public function setFkMonetarioCarteira(\Urbem\CoreBundle\Entity\Monetario\Carteira $fkMonetarioCarteira)
    {
        $this->codConvenio = $fkMonetarioCarteira->getCodConvenio();
        $this->codCarteira = $fkMonetarioCarteira->getCodCarteira();
        $this->fkMonetarioCarteira = $fkMonetarioCarteira;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioCarteira
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\Carteira
     */
    public function getFkMonetarioCarteira()
    {
        return $this->fkMonetarioCarteira;
    }

    /**
     * OneToOne (inverse side)
     * Set ArrecadacaoCarneMigracao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\CarneMigracao $fkArrecadacaoCarneMigracao
     * @return Carne
     */
    public function setFkArrecadacaoCarneMigracao(\Urbem\CoreBundle\Entity\Arrecadacao\CarneMigracao $fkArrecadacaoCarneMigracao)
    {
        $fkArrecadacaoCarneMigracao->setFkArrecadacaoCarne($this);
        $this->fkArrecadacaoCarneMigracao = $fkArrecadacaoCarneMigracao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkArrecadacaoCarneMigracao
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\CarneMigracao
     */
    public function getFkArrecadacaoCarneMigracao()
    {
        return $this->fkArrecadacaoCarneMigracao;
    }
}
