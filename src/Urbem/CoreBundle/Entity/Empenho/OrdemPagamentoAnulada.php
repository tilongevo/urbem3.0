<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * OrdemPagamentoAnulada
 */
class OrdemPagamentoAnulada
{
    /**
     * PK
     * @var integer
     */
    private $codOrdem;

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
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var string
     */
    private $motivo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoLiquidacaoAnulada
     */
    private $fkEmpenhoOrdemPagamentoLiquidacaoAnuladas;

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
        $this->fkEmpenhoOrdemPagamentoLiquidacaoAnuladas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codOrdem
     *
     * @param integer $codOrdem
     * @return OrdemPagamentoAnulada
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return OrdemPagamentoAnulada
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
     * @return OrdemPagamentoAnulada
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return OrdemPagamentoAnulada
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
     * @return OrdemPagamentoAnulada
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
     * Add EmpenhoOrdemPagamentoLiquidacaoAnulada
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoLiquidacaoAnulada $fkEmpenhoOrdemPagamentoLiquidacaoAnulada
     * @return OrdemPagamentoAnulada
     */
    public function addFkEmpenhoOrdemPagamentoLiquidacaoAnuladas(\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoLiquidacaoAnulada $fkEmpenhoOrdemPagamentoLiquidacaoAnulada)
    {
        if (false === $this->fkEmpenhoOrdemPagamentoLiquidacaoAnuladas->contains($fkEmpenhoOrdemPagamentoLiquidacaoAnulada)) {
            $fkEmpenhoOrdemPagamentoLiquidacaoAnulada->setFkEmpenhoOrdemPagamentoAnulada($this);
            $this->fkEmpenhoOrdemPagamentoLiquidacaoAnuladas->add($fkEmpenhoOrdemPagamentoLiquidacaoAnulada);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoOrdemPagamentoLiquidacaoAnulada
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoLiquidacaoAnulada $fkEmpenhoOrdemPagamentoLiquidacaoAnulada
     */
    public function removeFkEmpenhoOrdemPagamentoLiquidacaoAnuladas(\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoLiquidacaoAnulada $fkEmpenhoOrdemPagamentoLiquidacaoAnulada)
    {
        $this->fkEmpenhoOrdemPagamentoLiquidacaoAnuladas->removeElement($fkEmpenhoOrdemPagamentoLiquidacaoAnulada);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoOrdemPagamentoLiquidacaoAnuladas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoLiquidacaoAnulada
     */
    public function getFkEmpenhoOrdemPagamentoLiquidacaoAnuladas()
    {
        return $this->fkEmpenhoOrdemPagamentoLiquidacaoAnuladas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoOrdemPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\OrdemPagamento $fkEmpenhoOrdemPagamento
     * @return OrdemPagamentoAnulada
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

    /**
     * @return int|null
     */
    public function getVlAnulacao()
    {
        $vlAnulado = null;

        /** @var $liquidacaoAnulada OrdemPagamentoLiquidacaoAnulada */
        foreach ($this->getFkEmpenhoOrdemPagamentoLiquidacaoAnuladas() as $liquidacaoAnulada) {
            $vlAnulado += $liquidacaoAnulada->getVlAnulado();
        }

        return $vlAnulado;
    }
}
