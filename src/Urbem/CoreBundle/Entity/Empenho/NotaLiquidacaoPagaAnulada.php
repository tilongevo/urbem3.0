<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * NotaLiquidacaoPagaAnulada
 */
class NotaLiquidacaoPagaAnulada
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
    private $codNota;

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
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampAnulada;

    /**
     * @var integer
     */
    private $vlAnulado;

    /**
     * @var string
     */
    private $observacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAnuladaAuditoria
     */
    private $fkEmpenhoNotaLiquidacaoPagaAnuladaAuditoria;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tesouraria\PagamentoEstornado
     */
    private $fkTesourariaPagamentoEstornado;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\PagamentoEstorno
     */
    private $fkContabilidadePagamentoEstornos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPaga
     */
    private $fkEmpenhoNotaLiquidacaoPaga;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkContabilidadePagamentoEstornos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestampAnulada = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return NotaLiquidacaoPagaAnulada
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
     * Set codNota
     *
     * @param integer $codNota
     * @return NotaLiquidacaoPagaAnulada
     */
    public function setCodNota($codNota)
    {
        $this->codNota = $codNota;
        return $this;
    }

    /**
     * Get codNota
     *
     * @return integer
     */
    public function getCodNota()
    {
        return $this->codNota;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return NotaLiquidacaoPagaAnulada
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
     * @return NotaLiquidacaoPagaAnulada
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
     * Set timestampAnulada
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampAnulada
     * @return NotaLiquidacaoPagaAnulada
     */
    public function setTimestampAnulada(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampAnulada)
    {
        $this->timestampAnulada = $timestampAnulada;
        return $this;
    }

    /**
     * Get timestampAnulada
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampAnulada()
    {
        return $this->timestampAnulada;
    }

    /**
     * Set vlAnulado
     *
     * @param integer $vlAnulado
     * @return NotaLiquidacaoPagaAnulada
     */
    public function setVlAnulado($vlAnulado)
    {
        $this->vlAnulado = $vlAnulado;
        return $this;
    }

    /**
     * Get vlAnulado
     *
     * @return integer
     */
    public function getVlAnulado()
    {
        return $this->vlAnulado;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return NotaLiquidacaoPagaAnulada
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
     * OneToMany (owning side)
     * Add ContabilidadePagamentoEstorno
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PagamentoEstorno $fkContabilidadePagamentoEstorno
     * @return NotaLiquidacaoPagaAnulada
     */
    public function addFkContabilidadePagamentoEstornos(\Urbem\CoreBundle\Entity\Contabilidade\PagamentoEstorno $fkContabilidadePagamentoEstorno)
    {
        if (false === $this->fkContabilidadePagamentoEstornos->contains($fkContabilidadePagamentoEstorno)) {
            $fkContabilidadePagamentoEstorno->setFkEmpenhoNotaLiquidacaoPagaAnulada($this);
            $this->fkContabilidadePagamentoEstornos->add($fkContabilidadePagamentoEstorno);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadePagamentoEstorno
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PagamentoEstorno $fkContabilidadePagamentoEstorno
     */
    public function removeFkContabilidadePagamentoEstornos(\Urbem\CoreBundle\Entity\Contabilidade\PagamentoEstorno $fkContabilidadePagamentoEstorno)
    {
        $this->fkContabilidadePagamentoEstornos->removeElement($fkContabilidadePagamentoEstorno);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadePagamentoEstornos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\PagamentoEstorno
     */
    public function getFkContabilidadePagamentoEstornos()
    {
        return $this->fkContabilidadePagamentoEstornos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoNotaLiquidacaoPaga
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPaga $fkEmpenhoNotaLiquidacaoPaga
     * @return NotaLiquidacaoPagaAnulada
     */
    public function setFkEmpenhoNotaLiquidacaoPaga(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPaga $fkEmpenhoNotaLiquidacaoPaga)
    {
        $this->codEntidade = $fkEmpenhoNotaLiquidacaoPaga->getCodEntidade();
        $this->codNota = $fkEmpenhoNotaLiquidacaoPaga->getCodNota();
        $this->exercicio = $fkEmpenhoNotaLiquidacaoPaga->getExercicio();
        $this->timestamp = $fkEmpenhoNotaLiquidacaoPaga->getTimestamp();
        $this->fkEmpenhoNotaLiquidacaoPaga = $fkEmpenhoNotaLiquidacaoPaga;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoNotaLiquidacaoPaga
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPaga
     */
    public function getFkEmpenhoNotaLiquidacaoPaga()
    {
        return $this->fkEmpenhoNotaLiquidacaoPaga;
    }

    /**
     * OneToOne (inverse side)
     * Set EmpenhoNotaLiquidacaoPagaAnuladaAuditoria
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAnuladaAuditoria $fkEmpenhoNotaLiquidacaoPagaAnuladaAuditoria
     * @return NotaLiquidacaoPagaAnulada
     */
    public function setFkEmpenhoNotaLiquidacaoPagaAnuladaAuditoria(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAnuladaAuditoria $fkEmpenhoNotaLiquidacaoPagaAnuladaAuditoria)
    {
        $fkEmpenhoNotaLiquidacaoPagaAnuladaAuditoria->setFkEmpenhoNotaLiquidacaoPagaAnulada($this);
        $this->fkEmpenhoNotaLiquidacaoPagaAnuladaAuditoria = $fkEmpenhoNotaLiquidacaoPagaAnuladaAuditoria;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEmpenhoNotaLiquidacaoPagaAnuladaAuditoria
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAnuladaAuditoria
     */
    public function getFkEmpenhoNotaLiquidacaoPagaAnuladaAuditoria()
    {
        return $this->fkEmpenhoNotaLiquidacaoPagaAnuladaAuditoria;
    }

    /**
     * OneToOne (inverse side)
     * Set TesourariaPagamentoEstornado
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\PagamentoEstornado $fkTesourariaPagamentoEstornado
     * @return NotaLiquidacaoPagaAnulada
     */
    public function setFkTesourariaPagamentoEstornado(\Urbem\CoreBundle\Entity\Tesouraria\PagamentoEstornado $fkTesourariaPagamentoEstornado)
    {
        $fkTesourariaPagamentoEstornado->setFkEmpenhoNotaLiquidacaoPagaAnulada($this);
        $this->fkTesourariaPagamentoEstornado = $fkTesourariaPagamentoEstornado;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTesourariaPagamentoEstornado
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\PagamentoEstornado
     */
    public function getFkTesourariaPagamentoEstornado()
    {
        return $this->fkTesourariaPagamentoEstornado;
    }
}
