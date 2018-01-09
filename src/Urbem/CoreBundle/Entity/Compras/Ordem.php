<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * Ordem
 */
class Ordem
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
     * @var string
     */
    private $tipo;

    /**
     * @var string
     */
    private $exercicioEmpenho;

    /**
     * @var integer
     */
    private $codEmpenho;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var string
     */
    private $observacao;

    /**
     * @var integer
     */
    private $numcgmEntrega;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\NotaFiscalFornecedorOrdem
     */
    private $fkComprasNotaFiscalFornecedorOrdens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\OrdemItem
     */
    private $fkComprasOrdemItens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\OrdemAnulacao
     */
    private $fkComprasOrdemAnulacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    private $fkEmpenhoEmpenho;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkComprasNotaFiscalFornecedorOrdens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasOrdemItens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasOrdemAnulacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Ordem
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
     * @return Ordem
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
     * @return Ordem
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
     * Set tipo
     *
     * @param string $tipo
     * @return Ordem
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set exercicioEmpenho
     *
     * @param string $exercicioEmpenho
     * @return Ordem
     */
    public function setExercicioEmpenho($exercicioEmpenho)
    {
        $this->exercicioEmpenho = $exercicioEmpenho;
        return $this;
    }

    /**
     * Get exercicioEmpenho
     *
     * @return string
     */
    public function getExercicioEmpenho()
    {
        return $this->exercicioEmpenho;
    }

    /**
     * Set codEmpenho
     *
     * @param integer $codEmpenho
     * @return Ordem
     */
    public function setCodEmpenho($codEmpenho)
    {
        $this->codEmpenho = $codEmpenho;
        return $this;
    }

    /**
     * Get codEmpenho
     *
     * @return integer
     */
    public function getCodEmpenho()
    {
        return $this->codEmpenho;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return Ordem
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp = null)
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
     * Set observacao
     *
     * @param string $observacao
     * @return Ordem
     */
    public function setObservacao($observacao)
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
     * Set numcgmEntrega
     *
     * @param integer $numcgmEntrega
     * @return Ordem
     */
    public function setNumcgmEntrega($numcgmEntrega = null)
    {
        $this->numcgmEntrega = $numcgmEntrega;
        return $this;
    }

    /**
     * Get numcgmEntrega
     *
     * @return integer
     */
    public function getNumcgmEntrega()
    {
        return $this->numcgmEntrega;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasNotaFiscalFornecedorOrdem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\NotaFiscalFornecedorOrdem $fkComprasNotaFiscalFornecedorOrdem
     * @return Ordem
     */
    public function addFkComprasNotaFiscalFornecedorOrdens(\Urbem\CoreBundle\Entity\Compras\NotaFiscalFornecedorOrdem $fkComprasNotaFiscalFornecedorOrdem)
    {
        if (false === $this->fkComprasNotaFiscalFornecedorOrdens->contains($fkComprasNotaFiscalFornecedorOrdem)) {
            $fkComprasNotaFiscalFornecedorOrdem->setFkComprasOrdem($this);
            $this->fkComprasNotaFiscalFornecedorOrdens->add($fkComprasNotaFiscalFornecedorOrdem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasNotaFiscalFornecedorOrdem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\NotaFiscalFornecedorOrdem $fkComprasNotaFiscalFornecedorOrdem
     */
    public function removeFkComprasNotaFiscalFornecedorOrdens(\Urbem\CoreBundle\Entity\Compras\NotaFiscalFornecedorOrdem $fkComprasNotaFiscalFornecedorOrdem)
    {
        $this->fkComprasNotaFiscalFornecedorOrdens->removeElement($fkComprasNotaFiscalFornecedorOrdem);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasNotaFiscalFornecedorOrdens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\NotaFiscalFornecedorOrdem
     */
    public function getFkComprasNotaFiscalFornecedorOrdens()
    {
        return $this->fkComprasNotaFiscalFornecedorOrdens;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasOrdemItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\OrdemItem $fkComprasOrdemItem
     * @return Ordem
     */
    public function addFkComprasOrdemItens(OrdemItem $fkComprasOrdemItem)
    {
        if (false === $this->fkComprasOrdemItens->contains($fkComprasOrdemItem)) {
            $fkComprasOrdemItem->setFkComprasOrdem($this);
            $this->fkComprasOrdemItens->add($fkComprasOrdemItem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasOrdemItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\OrdemItem $fkComprasOrdemItem
     */
    public function removeFkComprasOrdemItens(\Urbem\CoreBundle\Entity\Compras\OrdemItem $fkComprasOrdemItem)
    {
        $this->fkComprasOrdemItens->removeElement($fkComprasOrdemItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasOrdemItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\OrdemItem
     */
    public function getFkComprasOrdemItens()
    {
        return $this->fkComprasOrdemItens;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasOrdemAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\OrdemAnulacao $fkComprasOrdemAnulacao
     * @return Ordem
     */
    public function addFkComprasOrdemAnulacoes(\Urbem\CoreBundle\Entity\Compras\OrdemAnulacao $fkComprasOrdemAnulacao)
    {
        if (false === $this->fkComprasOrdemAnulacoes->contains($fkComprasOrdemAnulacao)) {
            $fkComprasOrdemAnulacao->setFkComprasOrdem($this);
            $this->fkComprasOrdemAnulacoes->add($fkComprasOrdemAnulacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasOrdemAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\OrdemAnulacao $fkComprasOrdemAnulacao
     */
    public function removeFkComprasOrdemAnulacoes(\Urbem\CoreBundle\Entity\Compras\OrdemAnulacao $fkComprasOrdemAnulacao)
    {
        $this->fkComprasOrdemAnulacoes->removeElement($fkComprasOrdemAnulacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasOrdemAnulacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\OrdemAnulacao
     */
    public function getFkComprasOrdemAnulacoes()
    {
        return $this->fkComprasOrdemAnulacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho
     * @return Ordem
     */
    public function setFkEmpenhoEmpenho(\Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho)
    {
        $this->codEmpenho = $fkEmpenhoEmpenho->getCodEmpenho();
        $this->exercicioEmpenho = $fkEmpenhoEmpenho->getExercicio();
        $this->codEntidade = $fkEmpenhoEmpenho->getCodEntidade();
        $this->fkEmpenhoEmpenho = $fkEmpenhoEmpenho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    public function getFkEmpenhoEmpenho()
    {
        return $this->fkEmpenhoEmpenho;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return Ordem
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgmEntrega = $fkSwCgm->getNumcgm();
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
     * @return string
     */
    public function getNomTipo()
    {
        return strtoupper(trim($this->tipo)) === 'C' ? 'Compra' : 'Serviço';
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s/%s', $this->codOrdem, $this->exercicio);
    }
}
