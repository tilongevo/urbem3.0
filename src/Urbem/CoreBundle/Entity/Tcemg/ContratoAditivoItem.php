<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * ContratoAditivoItem
 */
class ContratoAditivoItem
{
    CONST COD_TIPO_VALOR_ACRESCIMO = ContratoAditivo::COD_TIPO_VALOR_ACRESCIMO;
    CONST COD_TIPO_VALOR_DECRESCIMO = ContratoAditivo::COD_TIPO_VALOR_DECRESCIMO;

    /**
     * PK
     * @var integer
     */
    private $codContratoAditivoItem;

    /**
     * PK
     * @var integer
     */
    private $codContratoAditivo;

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
    private $numItem;

    /**
     * @var integer
     */
    private $codEmpenho;

    /**
     * @var string
     */
    private $exercicioEmpenho;

    /**
     * @var integer
     */
    private $codPreEmpenho;

    /**
     * @var string
     */
    private $exercicioPreEmpenho;

    /**
     * @var integer
     */
    private $quantidade;

    /**
     * @var integer
     */
    private $tipoAcrescDecresc;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcemg\ContratoAditivo
     */
    private $fkTcemgContratoAditivo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    private $fkEmpenhoEmpenho;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\PreEmpenho
     */
    private $fkEmpenhoPreEmpenho;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho
     */
    private $fkEmpenhoItemPreEmpenho;


    /**
     * Set codContratoAditivoItem
     *
     * @param integer $codContratoAditivoItem
     * @return ContratoAditivoItem
     */
    public function setCodContratoAditivoItem($codContratoAditivoItem)
    {
        $this->codContratoAditivoItem = $codContratoAditivoItem;
        return $this;
    }

    /**
     * Get codContratoAditivoItem
     *
     * @return integer
     */
    public function getCodContratoAditivoItem()
    {
        return $this->codContratoAditivoItem;
    }

    /**
     * Set codContratoAditivo
     *
     * @param integer $codContratoAditivo
     * @return ContratoAditivoItem
     */
    public function setCodContratoAditivo($codContratoAditivo)
    {
        $this->codContratoAditivo = $codContratoAditivo;
        return $this;
    }

    /**
     * Get codContratoAditivo
     *
     * @return integer
     */
    public function getCodContratoAditivo()
    {
        return $this->codContratoAditivo;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ContratoAditivoItem
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
     * @return ContratoAditivoItem
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
     * Set numItem
     *
     * @param integer $numItem
     * @return ContratoAditivoItem
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
     * Set codEmpenho
     *
     * @param integer $codEmpenho
     * @return ContratoAditivoItem
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
     * Set exercicioEmpenho
     *
     * @param string $exercicioEmpenho
     * @return ContratoAditivoItem
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
     * Set codPreEmpenho
     *
     * @param integer $codPreEmpenho
     * @return ContratoAditivoItem
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
     * Set exercicioPreEmpenho
     *
     * @param string $exercicioPreEmpenho
     * @return ContratoAditivoItem
     */
    public function setExercicioPreEmpenho($exercicioPreEmpenho)
    {
        $this->exercicioPreEmpenho = $exercicioPreEmpenho;
        return $this;
    }

    /**
     * Get exercicioPreEmpenho
     *
     * @return string
     */
    public function getExercicioPreEmpenho()
    {
        return $this->exercicioPreEmpenho;
    }

    /**
     * Set quantidade
     *
     * @param integer $quantidade
     * @return ContratoAditivoItem
     */
    public function setQuantidade($quantidade)
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
     * Set tipoAcrescDecresc
     *
     * @param integer $tipoAcrescDecresc
     * @return ContratoAditivoItem
     */
    public function setTipoAcrescDecresc($tipoAcrescDecresc = null)
    {
        $this->tipoAcrescDecresc = $tipoAcrescDecresc;
        return $this;
    }

    /**
     * Get tipoAcrescDecresc
     *
     * @return integer
     */
    public function getTipoAcrescDecresc()
    {
        return $this->tipoAcrescDecresc;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcemgContratoAditivo
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContratoAditivo $fkTcemgContratoAditivo
     * @return ContratoAditivoItem
     */
    public function setFkTcemgContratoAditivo(\Urbem\CoreBundle\Entity\Tcemg\ContratoAditivo $fkTcemgContratoAditivo)
    {
        $this->codContratoAditivo = $fkTcemgContratoAditivo->getCodContratoAditivo();
        $this->exercicio = $fkTcemgContratoAditivo->getExercicio();
        $this->codEntidade = $fkTcemgContratoAditivo->getCodEntidade();
        $this->fkTcemgContratoAditivo = $fkTcemgContratoAditivo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgContratoAditivo
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\ContratoAditivo
     */
    public function getFkTcemgContratoAditivo()
    {
        return $this->fkTcemgContratoAditivo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho
     * @return ContratoAditivoItem
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
     * Set fkEmpenhoPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\PreEmpenho $fkEmpenhoPreEmpenho
     * @return ContratoAditivoItem
     */
    public function setFkEmpenhoPreEmpenho(\Urbem\CoreBundle\Entity\Empenho\PreEmpenho $fkEmpenhoPreEmpenho)
    {
        $this->exercicioPreEmpenho = $fkEmpenhoPreEmpenho->getExercicio();
        $this->codPreEmpenho = $fkEmpenhoPreEmpenho->getCodPreEmpenho();
        $this->fkEmpenhoPreEmpenho = $fkEmpenhoPreEmpenho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoPreEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\PreEmpenho
     */
    public function getFkEmpenhoPreEmpenho()
    {
        return $this->fkEmpenhoPreEmpenho;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoItemPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho $fkEmpenhoItemPreEmpenho
     * @return ContratoAditivoItem
     */
    public function setFkEmpenhoItemPreEmpenho(\Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho $fkEmpenhoItemPreEmpenho)
    {
        $this->codPreEmpenho = $fkEmpenhoItemPreEmpenho->getCodPreEmpenho();
        $this->exercicioPreEmpenho = $fkEmpenhoItemPreEmpenho->getExercicio();
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
}
