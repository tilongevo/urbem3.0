<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * BasesEventoCriado
 */
class BasesEventoCriado
{
    /**
     * PK
     * @var integer
     */
    private $codBase;

    /**
     * PK
     * @var integer
     */
    private $codEvento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Bases
     */
    private $fkFolhapagamentoBases;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    private $fkFolhapagamentoEvento;


    /**
     * Set codBase
     *
     * @param integer $codBase
     * @return BasesEventoCriado
     */
    public function setCodBase($codBase)
    {
        $this->codBase = $codBase;
        return $this;
    }

    /**
     * Get codBase
     *
     * @return integer
     */
    public function getCodBase()
    {
        return $this->codBase;
    }

    /**
     * Set codEvento
     *
     * @param integer $codEvento
     * @return BasesEventoCriado
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
     * Set fkFolhapagamentoBases
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Bases $fkFolhapagamentoBases
     * @return BasesEventoCriado
     */
    public function setFkFolhapagamentoBases(\Urbem\CoreBundle\Entity\Folhapagamento\Bases $fkFolhapagamentoBases)
    {
        $this->codBase = $fkFolhapagamentoBases->getCodBase();
        $this->fkFolhapagamentoBases = $fkFolhapagamentoBases;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoBases
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\Bases
     */
    public function getFkFolhapagamentoBases()
    {
        return $this->fkFolhapagamentoBases;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento
     * @return BasesEventoCriado
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
