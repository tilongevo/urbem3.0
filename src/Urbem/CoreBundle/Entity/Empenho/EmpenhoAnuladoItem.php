<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * EmpenhoAnuladoItem
 */
class EmpenhoAnuladoItem
{
    /**
     * PK
     * @var integer
     */
    private $numItem;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codPreEmpenho;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codEmpenho;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * @var integer
     */
    private $vlAnulado;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho
     */
    private $fkEmpenhoItemPreEmpenho;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\EmpenhoAnulado
     */
    private $fkEmpenhoEmpenhoAnulado;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set numItem
     *
     * @param integer $numItem
     * @return EmpenhoAnuladoItem
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return EmpenhoAnuladoItem
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
     * Set codPreEmpenho
     *
     * @param integer $codPreEmpenho
     * @return EmpenhoAnuladoItem
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return EmpenhoAnuladoItem
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
     * Set codEmpenho
     *
     * @param integer $codEmpenho
     * @return EmpenhoAnuladoItem
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return EmpenhoAnuladoItem
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
     * Set vlAnulado
     *
     * @param integer $vlAnulado
     * @return EmpenhoAnuladoItem
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
     * Set fkEmpenhoItemPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho $fkEmpenhoItemPreEmpenho
     * @return EmpenhoAnuladoItem
     */
    public function setFkEmpenhoItemPreEmpenho(\Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho $fkEmpenhoItemPreEmpenho)
    {
        $this->codPreEmpenho = $fkEmpenhoItemPreEmpenho->getCodPreEmpenho();
        $this->exercicio = $fkEmpenhoItemPreEmpenho->getExercicio();
        $this->numItem = $fkEmpenhoItemPreEmpenho->getNumItem();
        $this->fkEmpenhoItemPreEmpenho = $fkEmpenhoItemPreEmpenho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoItemPreEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho
     */
    public function getFkEmpenhoItemPreEmpenho()
    {
        return $this->fkEmpenhoItemPreEmpenho;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoEmpenhoAnulado
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\EmpenhoAnulado $fkEmpenhoEmpenhoAnulado
     * @return EmpenhoAnuladoItem
     */
    public function setFkEmpenhoEmpenhoAnulado(\Urbem\CoreBundle\Entity\Empenho\EmpenhoAnulado $fkEmpenhoEmpenhoAnulado)
    {
        $this->exercicio = $fkEmpenhoEmpenhoAnulado->getExercicio();
        $this->codEntidade = $fkEmpenhoEmpenhoAnulado->getCodEntidade();
        $this->codEmpenho = $fkEmpenhoEmpenhoAnulado->getCodEmpenho();
        $this->timestamp = $fkEmpenhoEmpenhoAnulado->getTimestamp();
        $this->fkEmpenhoEmpenhoAnulado = $fkEmpenhoEmpenhoAnulado;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoEmpenhoAnulado
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\EmpenhoAnulado
     */
    public function getFkEmpenhoEmpenhoAnulado()
    {
        return $this->fkEmpenhoEmpenhoAnulado;
    }
}
