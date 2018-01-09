<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * SequenciaCalculoEvento
 */
class SequenciaCalculoEvento
{
    /**
     * PK
     * @var integer
     */
    private $codSequencia;

    /**
     * PK
     * @var integer
     */
    private $codEvento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\SequenciaCalculo
     */
    private $fkFolhapagamentoSequenciaCalculo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    private $fkFolhapagamentoEvento;


    /**
     * Set codSequencia
     *
     * @param integer $codSequencia
     * @return SequenciaCalculoEvento
     */
    public function setCodSequencia($codSequencia)
    {
        $this->codSequencia = $codSequencia;
        return $this;
    }

    /**
     * Get codSequencia
     *
     * @return integer
     */
    public function getCodSequencia()
    {
        return $this->codSequencia;
    }

    /**
     * Set codEvento
     *
     * @param integer $codEvento
     * @return SequenciaCalculoEvento
     */
    public function setCodEvento($codEvento)
    {
        $this->codEvento = $codEvento;
        return $this;
    }

    /**
     * Get codEvento
     *
     * @return integer
     */
    public function getCodEvento()
    {
        return $this->codEvento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoSequenciaCalculo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\SequenciaCalculo $fkFolhapagamentoSequenciaCalculo
     * @return SequenciaCalculoEvento
     */
    public function setFkFolhapagamentoSequenciaCalculo(\Urbem\CoreBundle\Entity\Folhapagamento\SequenciaCalculo $fkFolhapagamentoSequenciaCalculo)
    {
        $this->codSequencia = $fkFolhapagamentoSequenciaCalculo->getCodSequencia();
        $this->fkFolhapagamentoSequenciaCalculo = $fkFolhapagamentoSequenciaCalculo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoSequenciaCalculo
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\SequenciaCalculo
     */
    public function getFkFolhapagamentoSequenciaCalculo()
    {
        return $this->fkFolhapagamentoSequenciaCalculo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento
     * @return SequenciaCalculoEvento
     */
    public function setFkFolhapagamentoEvento(\Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento)
    {
        $this->codEvento = $fkFolhapagamentoEvento->getCodEvento();
        $this->fkFolhapagamentoEvento = $fkFolhapagamentoEvento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoEvento
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    public function getFkFolhapagamentoEvento()
    {
        return $this->fkFolhapagamentoEvento;
    }
}
