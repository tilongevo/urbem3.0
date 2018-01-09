<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * SolicitacaoItemAnulacao
 */
class SolicitacaoItemAnulacao
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
    private $codSolicitacao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codCentro;

    /**
     * PK
     * @var integer
     */
    private $codItem;

    /**
     * @var integer
     */
    private $quantidade;

    /**
     * @var integer
     */
    private $vlTotal;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacaoAnulacao
     */
    private $fkComprasSolicitacaoItemDotacaoAnulacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\SolicitacaoAnulacao
     */
    private $fkComprasSolicitacaoAnulacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\SolicitacaoItem
     */
    private $fkComprasSolicitacaoItem;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkComprasSolicitacaoItemDotacaoAnulacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return SolicitacaoItemAnulacao
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
     * @return SolicitacaoItemAnulacao
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
     * Set codSolicitacao
     *
     * @param integer $codSolicitacao
     * @return SolicitacaoItemAnulacao
     */
    public function setCodSolicitacao($codSolicitacao)
    {
        $this->codSolicitacao = $codSolicitacao;
        return $this;
    }

    /**
     * Get codSolicitacao
     *
     * @return integer
     */
    public function getCodSolicitacao()
    {
        return $this->codSolicitacao;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return SolicitacaoItemAnulacao
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
     * Set codCentro
     *
     * @param integer $codCentro
     * @return SolicitacaoItemAnulacao
     */
    public function setCodCentro($codCentro)
    {
        $this->codCentro = $codCentro;
        return $this;
    }

    /**
     * Get codCentro
     *
     * @return integer
     */
    public function getCodCentro()
    {
        return $this->codCentro;
    }

    /**
     * Set codItem
     *
     * @param integer $codItem
     * @return SolicitacaoItemAnulacao
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
     * Set quantidade
     *
     * @param integer $quantidade
     * @return SolicitacaoItemAnulacao
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
     * Set vlTotal
     *
     * @param integer $vlTotal
     * @return SolicitacaoItemAnulacao
     */
    public function setVlTotal($vlTotal = null)
    {
        $this->vlTotal = $vlTotal;
        return $this;
    }

    /**
     * Get vlTotal
     *
     * @return integer
     */
    public function getVlTotal()
    {
        return $this->vlTotal;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasSolicitacaoItemDotacaoAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacaoAnulacao $fkComprasSolicitacaoItemDotacaoAnulacao
     * @return SolicitacaoItemAnulacao
     */
    public function addFkComprasSolicitacaoItemDotacaoAnulacoes(\Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacaoAnulacao $fkComprasSolicitacaoItemDotacaoAnulacao)
    {
        if (false === $this->fkComprasSolicitacaoItemDotacaoAnulacoes->contains($fkComprasSolicitacaoItemDotacaoAnulacao)) {
            $fkComprasSolicitacaoItemDotacaoAnulacao->setFkComprasSolicitacaoItemAnulacao($this);
            $this->fkComprasSolicitacaoItemDotacaoAnulacoes->add($fkComprasSolicitacaoItemDotacaoAnulacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasSolicitacaoItemDotacaoAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacaoAnulacao $fkComprasSolicitacaoItemDotacaoAnulacao
     */
    public function removeFkComprasSolicitacaoItemDotacaoAnulacoes(\Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacaoAnulacao $fkComprasSolicitacaoItemDotacaoAnulacao)
    {
        $this->fkComprasSolicitacaoItemDotacaoAnulacoes->removeElement($fkComprasSolicitacaoItemDotacaoAnulacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasSolicitacaoItemDotacaoAnulacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacaoAnulacao
     */
    public function getFkComprasSolicitacaoItemDotacaoAnulacoes()
    {
        return $this->fkComprasSolicitacaoItemDotacaoAnulacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasSolicitacaoAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoAnulacao $fkComprasSolicitacaoAnulacao
     * @return SolicitacaoItemAnulacao
     */
    public function setFkComprasSolicitacaoAnulacao(\Urbem\CoreBundle\Entity\Compras\SolicitacaoAnulacao $fkComprasSolicitacaoAnulacao)
    {
        $this->exercicio = $fkComprasSolicitacaoAnulacao->getExercicio();
        $this->codEntidade = $fkComprasSolicitacaoAnulacao->getCodEntidade();
        $this->codSolicitacao = $fkComprasSolicitacaoAnulacao->getCodSolicitacao();
        $this->timestamp = $fkComprasSolicitacaoAnulacao->getTimestamp();
        $this->fkComprasSolicitacaoAnulacao = $fkComprasSolicitacaoAnulacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasSolicitacaoAnulacao
     *
     * @return \Urbem\CoreBundle\Entity\Compras\SolicitacaoAnulacao
     */
    public function getFkComprasSolicitacaoAnulacao()
    {
        return $this->fkComprasSolicitacaoAnulacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasSolicitacaoItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoItem $fkComprasSolicitacaoItem
     * @return SolicitacaoItemAnulacao
     */
    public function setFkComprasSolicitacaoItem(\Urbem\CoreBundle\Entity\Compras\SolicitacaoItem $fkComprasSolicitacaoItem)
    {
        $this->exercicio = $fkComprasSolicitacaoItem->getExercicio();
        $this->codEntidade = $fkComprasSolicitacaoItem->getCodEntidade();
        $this->codSolicitacao = $fkComprasSolicitacaoItem->getCodSolicitacao();
        $this->codCentro = $fkComprasSolicitacaoItem->getCodCentro();
        $this->codItem = $fkComprasSolicitacaoItem->getCodItem();
        $this->fkComprasSolicitacaoItem = $fkComprasSolicitacaoItem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasSolicitacaoItem
     *
     * @return \Urbem\CoreBundle\Entity\Compras\SolicitacaoItem
     */
    public function getFkComprasSolicitacaoItem()
    {
        return $this->fkComprasSolicitacaoItem;
    }
}
