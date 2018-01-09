<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * NotaLiquidacaoPagaAnuladaAuditoria
 */
class NotaLiquidacaoPagaAnuladaAuditoria
{
    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $codNota;

    /**
     * PK
     * @var string
     */
    private $exercicio;

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
    private $numcgm;

    /**
     * @var \DateTime
     */
    private $timestampAtual;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAnulada
     */
    private $fkEmpenhoNotaLiquidacaoPagaAnulada;

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
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestampAnulada = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestampAtual = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return NotaLiquidacaoPagaAnuladaAuditoria
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
     * Set codNota
     *
     * @param integer $codNota
     * @return NotaLiquidacaoPagaAnuladaAuditoria
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return NotaLiquidacaoPagaAnuladaAuditoria
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
     * @return NotaLiquidacaoPagaAnuladaAuditoria
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
     * @return NotaLiquidacaoPagaAnuladaAuditoria
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
     * Set numcgm
     *
     * @param integer $numcgm
     * @return NotaLiquidacaoPagaAnuladaAuditoria
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set timestampAtual
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampAtual
     * @return NotaLiquidacaoPagaAnuladaAuditoria
     */
    public function setTimestampAtual(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampAtual)
    {
        $this->timestampAtual = $timestampAtual;
        return $this;
    }

    /**
     * Get timestampAtual
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampAtual()
    {
        return $this->timestampAtual;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return NotaLiquidacaoPagaAnuladaAuditoria
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgm = $fkSwCgm->getNumcgm();
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
     * OneToOne (owning side)
     * Set EmpenhoNotaLiquidacaoPagaAnulada
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAnulada $fkEmpenhoNotaLiquidacaoPagaAnulada
     * @return NotaLiquidacaoPagaAnuladaAuditoria
     */
    public function setFkEmpenhoNotaLiquidacaoPagaAnulada(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAnulada $fkEmpenhoNotaLiquidacaoPagaAnulada)
    {
        $this->exercicio = $fkEmpenhoNotaLiquidacaoPagaAnulada->getExercicio();
        $this->codNota = $fkEmpenhoNotaLiquidacaoPagaAnulada->getCodNota();
        $this->codEntidade = $fkEmpenhoNotaLiquidacaoPagaAnulada->getCodEntidade();
        $this->timestamp = $fkEmpenhoNotaLiquidacaoPagaAnulada->getTimestamp();
        $this->timestampAnulada = $fkEmpenhoNotaLiquidacaoPagaAnulada->getTimestampAnulada();
        $this->fkEmpenhoNotaLiquidacaoPagaAnulada = $fkEmpenhoNotaLiquidacaoPagaAnulada;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkEmpenhoNotaLiquidacaoPagaAnulada
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAnulada
     */
    public function getFkEmpenhoNotaLiquidacaoPagaAnulada()
    {
        return $this->fkEmpenhoNotaLiquidacaoPagaAnulada;
    }
}
