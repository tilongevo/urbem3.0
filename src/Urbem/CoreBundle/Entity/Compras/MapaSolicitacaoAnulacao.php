<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * MapaSolicitacaoAnulacao
 */
class MapaSolicitacaoAnulacao
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
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var string
     */
    private $motivo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\MapaItemAnulacao
     */
    private $fkComprasMapaItemAnulacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\MapaSolicitacao
     */
    private $fkComprasMapaSolicitacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkComprasMapaItemAnulacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return MapaSolicitacaoAnulacao
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
     * @return MapaSolicitacaoAnulacao
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
     * @return MapaSolicitacaoAnulacao
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
     * @return MapaSolicitacaoAnulacao
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
     * @return MapaSolicitacaoAnulacao
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
     * @return MapaSolicitacaoAnulacao
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
     * Set motivo
     *
     * @param string $motivo
     * @return MapaSolicitacaoAnulacao
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;
        return $this;
    }

    /**
     * Get motivo
     *
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasMapaItemAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\MapaItemAnulacao $fkComprasMapaItemAnulacao
     * @return MapaSolicitacaoAnulacao
     */
    public function addFkComprasMapaItemAnulacoes(\Urbem\CoreBundle\Entity\Compras\MapaItemAnulacao $fkComprasMapaItemAnulacao)
    {
        if (false === $this->fkComprasMapaItemAnulacoes->contains($fkComprasMapaItemAnulacao)) {
            $fkComprasMapaItemAnulacao->setFkComprasMapaSolicitacaoAnulacao($this);
            $this->fkComprasMapaItemAnulacoes->add($fkComprasMapaItemAnulacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasMapaItemAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\MapaItemAnulacao $fkComprasMapaItemAnulacao
     */
    public function removeFkComprasMapaItemAnulacoes(\Urbem\CoreBundle\Entity\Compras\MapaItemAnulacao $fkComprasMapaItemAnulacao)
    {
        $this->fkComprasMapaItemAnulacoes->removeElement($fkComprasMapaItemAnulacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasMapaItemAnulacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\MapaItemAnulacao
     */
    public function getFkComprasMapaItemAnulacoes()
    {
        return $this->fkComprasMapaItemAnulacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasMapaSolicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\MapaSolicitacao $fkComprasMapaSolicitacao
     * @return MapaSolicitacaoAnulacao
     */
    public function setFkComprasMapaSolicitacao(\Urbem\CoreBundle\Entity\Compras\MapaSolicitacao $fkComprasMapaSolicitacao)
    {
        $this->exercicio = $fkComprasMapaSolicitacao->getExercicio();
        $this->codMapa = $fkComprasMapaSolicitacao->getCodMapa();
        $this->exercicioSolicitacao = $fkComprasMapaSolicitacao->getExercicioSolicitacao();
        $this->codEntidade = $fkComprasMapaSolicitacao->getCodEntidade();
        $this->codSolicitacao = $fkComprasMapaSolicitacao->getCodSolicitacao();
        $this->fkComprasMapaSolicitacao = $fkComprasMapaSolicitacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasMapaSolicitacao
     *
     * @return \Urbem\CoreBundle\Entity\Compras\MapaSolicitacao
     */
    public function getFkComprasMapaSolicitacao()
    {
        return $this->fkComprasMapaSolicitacao;
    }
}
