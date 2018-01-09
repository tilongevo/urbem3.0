<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * NotaLiquidacaoItemAnulado
 */
class NotaLiquidacaoItemAnulado
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
    private $codPreEmpenho;

    /**
     * PK
     * @var integer
     */
    private $numItem;

    /**
     * PK
     * @var string
     */
    private $exercicioItem;

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
     * @var integer
     */
    private $vlAnulado;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoItem
     */
    private $fkEmpenhoNotaLiquidacaoItem;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return NotaLiquidacaoItemAnulado
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
     * Set codPreEmpenho
     *
     * @param integer $codPreEmpenho
     * @return NotaLiquidacaoItemAnulado
     */
    public function setCodPreEmpenho($codPreEmpenho)
    {
        $this->codPreEmpenho = $codPreEmpenho;
        return $this;
    }

    /**
     * Get codPreEmpenho
     *
     * @return integer
     */
    public function getCodPreEmpenho()
    {
        return $this->codPreEmpenho;
    }

    /**
     * Set numItem
     *
     * @param integer $numItem
     * @return NotaLiquidacaoItemAnulado
     */
    public function setNumItem($numItem)
    {
        $this->numItem = $numItem;
        return $this;
    }

    /**
     * Get numItem
     *
     * @return integer
     */
    public function getNumItem()
    {
        return $this->numItem;
    }

    /**
     * Set exercicioItem
     *
     * @param string $exercicioItem
     * @return NotaLiquidacaoItemAnulado
     */
    public function setExercicioItem($exercicioItem)
    {
        $this->exercicioItem = $exercicioItem;
        return $this;
    }

    /**
     * Get exercicioItem
     *
     * @return string
     */
    public function getExercicioItem()
    {
        return $this->exercicioItem;
    }

    /**
     * Set codNota
     *
     * @param integer $codNota
     * @return NotaLiquidacaoItemAnulado
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
     * @return NotaLiquidacaoItemAnulado
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
     * @return NotaLiquidacaoItemAnulado
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
     * Set vlAnulado
     *
     * @param integer $vlAnulado
     * @return NotaLiquidacaoItemAnulado
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
     * ManyToOne (inverse side)
     * Set fkEmpenhoNotaLiquidacaoItem
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoItem $fkEmpenhoNotaLiquidacaoItem
     * @return NotaLiquidacaoItemAnulado
     */
    public function setFkEmpenhoNotaLiquidacaoItem(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoItem $fkEmpenhoNotaLiquidacaoItem)
    {
        $this->exercicio = $fkEmpenhoNotaLiquidacaoItem->getExercicio();
        $this->codNota = $fkEmpenhoNotaLiquidacaoItem->getCodNota();
        $this->numItem = $fkEmpenhoNotaLiquidacaoItem->getNumItem();
        $this->exercicioItem = $fkEmpenhoNotaLiquidacaoItem->getExercicioItem();
        $this->codPreEmpenho = $fkEmpenhoNotaLiquidacaoItem->getCodPreEmpenho();
        $this->codEntidade = $fkEmpenhoNotaLiquidacaoItem->getCodEntidade();
        $this->fkEmpenhoNotaLiquidacaoItem = $fkEmpenhoNotaLiquidacaoItem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoNotaLiquidacaoItem
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoItem
     */
    public function getFkEmpenhoNotaLiquidacaoItem()
    {
        return $this->fkEmpenhoNotaLiquidacaoItem;
    }
}
