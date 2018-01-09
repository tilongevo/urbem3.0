<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * TcemgEntidadeRemuneracao
 */
class TcemgEntidadeRemuneracao
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
    private $codTipo;

    /**
     * PK
     * @var integer
     */
    private $codEvento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcemg\TipoRemuneracao
     */
    private $fkTcemgTipoRemuneracao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    private $fkFolhapagamentoEvento;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return TcemgEntidadeRemuneracao
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TcemgEntidadeRemuneracao
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set codEvento
     *
     * @param integer $codEvento
     * @return TcemgEntidadeRemuneracao
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
     * Set fkTcemgTipoRemuneracao
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\TipoRemuneracao $fkTcemgTipoRemuneracao
     * @return TcemgEntidadeRemuneracao
     */
    public function setFkTcemgTipoRemuneracao(\Urbem\CoreBundle\Entity\Tcemg\TipoRemuneracao $fkTcemgTipoRemuneracao)
    {
        $this->codTipo = $fkTcemgTipoRemuneracao->getCodTipo();
        $this->fkTcemgTipoRemuneracao = $fkTcemgTipoRemuneracao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgTipoRemuneracao
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\TipoRemuneracao
     */
    public function getFkTcemgTipoRemuneracao()
    {
        return $this->fkTcemgTipoRemuneracao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento
     * @return TcemgEntidadeRemuneracao
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
