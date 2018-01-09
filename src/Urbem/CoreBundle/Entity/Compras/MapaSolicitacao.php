<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * MapaSolicitacao
 */
class MapaSolicitacao
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
    private $codMapa;

    /**
     * PK
     * @var string
     */
    private $exercicioSolicitacao;

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
     * @var \DateTime
     */
    private $timestamp;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\MapaSolicitacaoAnulacao
     */
    private $fkComprasMapaSolicitacaoAnulacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\MapaItem
     */
    private $fkComprasMapaItens;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\Mapa
     */
    private $fkComprasMapa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologada
     */
    private $fkComprasSolicitacaoHomologada;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkComprasMapaSolicitacaoAnulacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasMapaItens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return MapaSolicitacao
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
     * Set codMapa
     *
     * @param integer $codMapa
     * @return MapaSolicitacao
     */
    public function setCodMapa($codMapa)
    {
        $this->codMapa = $codMapa;
        return $this;
    }

    /**
     * Get codMapa
     *
     * @return integer
     */
    public function getCodMapa()
    {
        return $this->codMapa;
    }

    /**
     * Set exercicioSolicitacao
     *
     * @param string $exercicioSolicitacao
     * @return MapaSolicitacao
     */
    public function setExercicioSolicitacao($exercicioSolicitacao)
    {
        $this->exercicioSolicitacao = $exercicioSolicitacao;
        return $this;
    }

    /**
     * Get exercicioSolicitacao
     *
     * @return string
     */
    public function getExercicioSolicitacao()
    {
        return $this->exercicioSolicitacao;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return MapaSolicitacao
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
     * @return MapaSolicitacao
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
     * @return MapaSolicitacao
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
     * OneToMany (owning side)
     * Add ComprasMapaSolicitacaoAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\MapaSolicitacaoAnulacao $fkComprasMapaSolicitacaoAnulacao
     * @return MapaSolicitacao
     */
    public function addFkComprasMapaSolicitacaoAnulacoes(\Urbem\CoreBundle\Entity\Compras\MapaSolicitacaoAnulacao $fkComprasMapaSolicitacaoAnulacao)
    {
        if (false === $this->fkComprasMapaSolicitacaoAnulacoes->contains($fkComprasMapaSolicitacaoAnulacao)) {
            $fkComprasMapaSolicitacaoAnulacao->setFkComprasMapaSolicitacao($this);
            $this->fkComprasMapaSolicitacaoAnulacoes->add($fkComprasMapaSolicitacaoAnulacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasMapaSolicitacaoAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\MapaSolicitacaoAnulacao $fkComprasMapaSolicitacaoAnulacao
     */
    public function removeFkComprasMapaSolicitacaoAnulacoes(\Urbem\CoreBundle\Entity\Compras\MapaSolicitacaoAnulacao $fkComprasMapaSolicitacaoAnulacao)
    {
        $this->fkComprasMapaSolicitacaoAnulacoes->removeElement($fkComprasMapaSolicitacaoAnulacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasMapaSolicitacaoAnulacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\MapaSolicitacaoAnulacao
     */
    public function getFkComprasMapaSolicitacaoAnulacoes()
    {
        return $this->fkComprasMapaSolicitacaoAnulacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasMapaItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\MapaItem $fkComprasMapaItem
     * @return MapaSolicitacao
     */
    public function addFkComprasMapaItens(\Urbem\CoreBundle\Entity\Compras\MapaItem $fkComprasMapaItem)
    {
        if (false === $this->fkComprasMapaItens->contains($fkComprasMapaItem)) {
            $fkComprasMapaItem->setFkComprasMapaSolicitacao($this);
            $this->fkComprasMapaItens->add($fkComprasMapaItem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasMapaItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\MapaItem $fkComprasMapaItem
     */
    public function removeFkComprasMapaItens(\Urbem\CoreBundle\Entity\Compras\MapaItem $fkComprasMapaItem)
    {
        $this->fkComprasMapaItens->removeElement($fkComprasMapaItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasMapaItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\MapaItem
     */
    public function getFkComprasMapaItens()
    {
        return $this->fkComprasMapaItens;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasMapa
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Mapa $fkComprasMapa
     * @return MapaSolicitacao
     */
    public function setFkComprasMapa(\Urbem\CoreBundle\Entity\Compras\Mapa $fkComprasMapa)
    {
        $this->exercicio = $fkComprasMapa->getExercicio();
        $this->codMapa = $fkComprasMapa->getCodMapa();
        $this->fkComprasMapa = $fkComprasMapa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasMapa
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Mapa
     */
    public function getFkComprasMapa()
    {
        return $this->fkComprasMapa;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasSolicitacaoHomologada
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologada $fkComprasSolicitacaoHomologada
     * @return MapaSolicitacao
     */
    public function setFkComprasSolicitacaoHomologada(\Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologada $fkComprasSolicitacaoHomologada)
    {
        $this->exercicioSolicitacao = $fkComprasSolicitacaoHomologada->getExercicio();
        $this->codEntidade = $fkComprasSolicitacaoHomologada->getCodEntidade();
        $this->codSolicitacao = $fkComprasSolicitacaoHomologada->getCodSolicitacao();
        $this->fkComprasSolicitacaoHomologada = $fkComprasSolicitacaoHomologada;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasSolicitacaoHomologada
     *
     * @return \Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologada
     */
    public function getFkComprasSolicitacaoHomologada()
    {
        return $this->fkComprasSolicitacaoHomologada;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (!is_null($this->fkComprasMapaSolicitacaoAnulacoes)) {
            return sprintf('%s/%s', $this->codSolicitacao, $this->exercicioSolicitacao);
        }
        return 'Solicitações do Mapa';
    }
}
