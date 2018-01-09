<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * EventoHorasExtras
 */
class EventoHorasExtras
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
    private $codEvento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ima\ConfiguracaoRais
     */
    private $fkImaConfiguracaoRais;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    private $fkFolhapagamentoEvento;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return EventoHorasExtras
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
     * Set codEvento
     *
     * @param integer $codEvento
     * @return EventoHorasExtras
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
     * Set fkImaConfiguracaoRais
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoRais $fkImaConfiguracaoRais
     * @return EventoHorasExtras
     */
    public function setFkImaConfiguracaoRais(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoRais $fkImaConfiguracaoRais)
    {
        $this->exercicio = $fkImaConfiguracaoRais->getExercicio();
        $this->fkImaConfiguracaoRais = $fkImaConfiguracaoRais;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImaConfiguracaoRais
     *
     * @return \Urbem\CoreBundle\Entity\Ima\ConfiguracaoRais
     */
    public function getFkImaConfiguracaoRais()
    {
        return $this->fkImaConfiguracaoRais;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento
     * @return EventoHorasExtras
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
