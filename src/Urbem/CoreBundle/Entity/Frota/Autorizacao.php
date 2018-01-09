<?php
 
namespace Urbem\CoreBundle\Entity\Frota;

use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;

/**
 * Autorizacao
 */
class Autorizacao
{
    /**
     * PK
     * @var integer
     */
    private $codAutorizacao;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codItem;

    /**
     * @var integer
     */
    private $cgmRespAutorizacao;

    /**
     * @var integer
     */
    private $cgmFornecedor;

    /**
     * @var integer
     */
    private $codVeiculo;

    /**
     * @var DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $quantidade;

    /**
     * @var integer
     */
    private $valor;

    /**
     * @var string
     */
    private $observacao;

    /**
     * @var integer
     */
    private $cgmMotorista;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoAutorizacao
     */
    private $fkAlmoxarifadoLancamentoAutorizacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Efetivacao
     */
    private $fkFrotaEfetivacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Frota\Item
     */
    private $fkFrotaItem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Frota\Veiculo
     */
    private $fkFrotaVeiculo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm1;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm2;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAlmoxarifadoLancamentoAutorizacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaEfetivacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codAutorizacao
     *
     * @param integer $codAutorizacao
     * @return Autorizacao
     */
    public function setCodAutorizacao($codAutorizacao)
    {
        $this->codAutorizacao = $codAutorizacao;
        return $this;
    }

    /**
     * Get codAutorizacao
     *
     * @return integer
     */
    public function getCodAutorizacao()
    {
        return $this->codAutorizacao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Autorizacao
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
     * Set codItem
     *
     * @param integer $codItem
     * @return Autorizacao
     */
    public function setCodItem($codItem)
    {
        $this->codItem = $codItem;
        return $this;
    }

    /**
     * Get codItem
     *
     * @return integer
     */
    public function getCodItem()
    {
        return $this->codItem;
    }

    /**
     * Set cgmRespAutorizacao
     *
     * @param integer $cgmRespAutorizacao
     * @return Autorizacao
     */
    public function setCgmRespAutorizacao($cgmRespAutorizacao)
    {
        $this->cgmRespAutorizacao = $cgmRespAutorizacao;
        return $this;
    }

    /**
     * Get cgmRespAutorizacao
     *
     * @return integer
     */
    public function getCgmRespAutorizacao()
    {
        return $this->cgmRespAutorizacao;
    }

    /**
     * Set cgmFornecedor
     *
     * @param integer $cgmFornecedor
     * @return Autorizacao
     */
    public function setCgmFornecedor($cgmFornecedor)
    {
        $this->cgmFornecedor = $cgmFornecedor;
        return $this;
    }

    /**
     * Get cgmFornecedor
     *
     * @return integer
     */
    public function getCgmFornecedor()
    {
        return $this->cgmFornecedor;
    }

    /**
     * Set codVeiculo
     *
     * @param integer $codVeiculo
     * @return Autorizacao
     */
    public function setCodVeiculo($codVeiculo)
    {
        $this->codVeiculo = $codVeiculo;
        return $this;
    }

    /**
     * Get codVeiculo
     *
     * @return integer
     */
    public function getCodVeiculo()
    {
        return $this->codVeiculo;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return Autorizacao
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
     * Set quantidade
     *
     * @param integer $quantidade
     * @return Autorizacao
     */
    public function setQuantidade($quantidade = null)
    {
        $this->quantidade = $quantidade;
        return $this;
    }

    /**
     * Get quantidade
     *
     * @return integer
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return Autorizacao
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
     * Set observacao
     *
     * @param string $observacao
     * @return Autorizacao
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
     * Set cgmMotorista
     *
     * @param integer $cgmMotorista
     * @return Autorizacao
     */
    public function setCgmMotorista($cgmMotorista)
    {
        $this->cgmMotorista = $cgmMotorista;
        return $this;
    }

    /**
     * Get cgmMotorista
     *
     * @return integer
     */
    public function getCgmMotorista()
    {
        return $this->cgmMotorista;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoLancamentoAutorizacao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoAutorizacao $fkAlmoxarifadoLancamentoAutorizacao
     * @return Autorizacao
     */
    public function addFkAlmoxarifadoLancamentoAutorizacoes(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoAutorizacao $fkAlmoxarifadoLancamentoAutorizacao)
    {
        if (false === $this->fkAlmoxarifadoLancamentoAutorizacoes->contains($fkAlmoxarifadoLancamentoAutorizacao)) {
            $fkAlmoxarifadoLancamentoAutorizacao->setFkFrotaAutorizacao($this);
            $this->fkAlmoxarifadoLancamentoAutorizacoes->add($fkAlmoxarifadoLancamentoAutorizacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoLancamentoAutorizacao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoAutorizacao $fkAlmoxarifadoLancamentoAutorizacao
     */
    public function removeFkAlmoxarifadoLancamentoAutorizacoes(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoAutorizacao $fkAlmoxarifadoLancamentoAutorizacao)
    {
        $this->fkAlmoxarifadoLancamentoAutorizacoes->removeElement($fkAlmoxarifadoLancamentoAutorizacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoLancamentoAutorizacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoAutorizacao
     */
    public function getFkAlmoxarifadoLancamentoAutorizacoes()
    {
        return $this->fkAlmoxarifadoLancamentoAutorizacoes;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaEfetivacao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Efetivacao $fkFrotaEfetivacao
     * @return Autorizacao
     */
    public function addFkFrotaEfetivacoes(\Urbem\CoreBundle\Entity\Frota\Efetivacao $fkFrotaEfetivacao)
    {
        if (false === $this->fkFrotaEfetivacoes->contains($fkFrotaEfetivacao)) {
            $fkFrotaEfetivacao->setFkFrotaAutorizacao($this);
            $this->fkFrotaEfetivacoes->add($fkFrotaEfetivacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaEfetivacao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Efetivacao $fkFrotaEfetivacao
     */
    public function removeFkFrotaEfetivacoes(\Urbem\CoreBundle\Entity\Frota\Efetivacao $fkFrotaEfetivacao)
    {
        $this->fkFrotaEfetivacoes->removeElement($fkFrotaEfetivacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaEfetivacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Efetivacao
     */
    public function getFkFrotaEfetivacoes()
    {
        return $this->fkFrotaEfetivacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFrotaItem
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Item $fkFrotaItem
     * @return Autorizacao
     */
    public function setFkFrotaItem(\Urbem\CoreBundle\Entity\Frota\Item $fkFrotaItem)
    {
        $this->codItem = $fkFrotaItem->getCodItem();
        $this->fkFrotaItem = $fkFrotaItem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFrotaItem
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Item
     */
    public function getFkFrotaItem()
    {
        return $this->fkFrotaItem;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return Autorizacao
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->cgmRespAutorizacao = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFrotaVeiculo
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Veiculo $fkFrotaVeiculo
     * @return Autorizacao
     */
    public function setFkFrotaVeiculo(\Urbem\CoreBundle\Entity\Frota\Veiculo $fkFrotaVeiculo)
    {
        $this->codVeiculo = $fkFrotaVeiculo->getCodVeiculo();
        $this->fkFrotaVeiculo = $fkFrotaVeiculo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFrotaVeiculo
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Veiculo
     */
    public function getFkFrotaVeiculo()
    {
        return $this->fkFrotaVeiculo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm1
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm1
     * @return Autorizacao
     */
    public function setFkSwCgm1(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm1)
    {
        $this->cgmFornecedor = $fkSwCgm1->getNumcgm();
        $this->fkSwCgm1 = $fkSwCgm1;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm1
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm1()
    {
        return $this->fkSwCgm1;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm2
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm2
     * @return Autorizacao
     */
    public function setFkSwCgm2(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm2)
    {
        $this->cgmMotorista = $fkSwCgm2->getNumcgm();
        $this->fkSwCgm2 = $fkSwCgm2;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm2
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm2()
    {
        return $this->fkSwCgm2;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '%s/%s para %s',
            $this->codAutorizacao,
            $this->exercicio,
            $this->fkFrotaVeiculo
        );
    }
}
