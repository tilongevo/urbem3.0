<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * RelatorioEspelhoPonto
 */
class RelatorioEspelhoPonto
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * PK
     * @var integer
     */
    private $sequencia;

    /**
     * @var string
     */
    private $data;

    /**
     * @var string
     */
    private $dia;

    /**
     * @var string
     */
    private $tipo;

    /**
     * @var string
     */
    private $origem;

    /**
     * @var string
     */
    private $horarios;

    /**
     * @var string
     */
    private $justificativa;

    /**
     * @var string
     */
    private $cargaHoraria;

    /**
     * @var string
     */
    private $hsTrab;

    /**
     * @var string
     */
    private $adNot;

    /**
     * @var string
     */
    private $extras;

    /**
     * @var string
     */
    private $extNot;

    /**
     * @var string
     */
    private $atrasos;

    /**
     * @var string
     */
    private $faltas;

    /**
     * @var string
     */
    private $hsTot;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Contrato
     */
    private $fkPessoalContrato;


    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return RelatorioEspelhoPonto
     */
    public function setCodContrato($codContrato)
    {
        $this->codContrato = $codContrato;
        return $this;
    }

    /**
     * Get codContrato
     *
     * @return integer
     */
    public function getCodContrato()
    {
        return $this->codContrato;
    }

    /**
     * Set sequencia
     *
     * @param integer $sequencia
     * @return RelatorioEspelhoPonto
     */
    public function setSequencia($sequencia)
    {
        $this->sequencia = $sequencia;
        return $this;
    }

    /**
     * Get sequencia
     *
     * @return integer
     */
    public function getSequencia()
    {
        return $this->sequencia;
    }

    /**
     * Set data
     *
     * @param string $data
     * @return RelatorioEspelhoPonto
     */
    public function setData($data = null)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Get data
     *
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set dia
     *
     * @param string $dia
     * @return RelatorioEspelhoPonto
     */
    public function setDia($dia = null)
    {
        $this->dia = $dia;
        return $this;
    }

    /**
     * Get dia
     *
     * @return string
     */
    public function getDia()
    {
        return $this->dia;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return RelatorioEspelhoPonto
     */
    public function setTipo($tipo = null)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set origem
     *
     * @param string $origem
     * @return RelatorioEspelhoPonto
     */
    public function setOrigem($origem = null)
    {
        $this->origem = $origem;
        return $this;
    }

    /**
     * Get origem
     *
     * @return string
     */
    public function getOrigem()
    {
        return $this->origem;
    }

    /**
     * Set horarios
     *
     * @param string $horarios
     * @return RelatorioEspelhoPonto
     */
    public function setHorarios($horarios = null)
    {
        $this->horarios = $horarios;
        return $this;
    }

    /**
     * Get horarios
     *
     * @return string
     */
    public function getHorarios()
    {
        return $this->horarios;
    }

    /**
     * Set justificativa
     *
     * @param string $justificativa
     * @return RelatorioEspelhoPonto
     */
    public function setJustificativa($justificativa = null)
    {
        $this->justificativa = $justificativa;
        return $this;
    }

    /**
     * Get justificativa
     *
     * @return string
     */
    public function getJustificativa()
    {
        return $this->justificativa;
    }

    /**
     * Set cargaHoraria
     *
     * @param string $cargaHoraria
     * @return RelatorioEspelhoPonto
     */
    public function setCargaHoraria($cargaHoraria = null)
    {
        $this->cargaHoraria = $cargaHoraria;
        return $this;
    }

    /**
     * Get cargaHoraria
     *
     * @return string
     */
    public function getCargaHoraria()
    {
        return $this->cargaHoraria;
    }

    /**
     * Set hsTrab
     *
     * @param string $hsTrab
     * @return RelatorioEspelhoPonto
     */
    public function setHsTrab($hsTrab = null)
    {
        $this->hsTrab = $hsTrab;
        return $this;
    }

    /**
     * Get hsTrab
     *
     * @return string
     */
    public function getHsTrab()
    {
        return $this->hsTrab;
    }

    /**
     * Set adNot
     *
     * @param string $adNot
     * @return RelatorioEspelhoPonto
     */
    public function setAdNot($adNot = null)
    {
        $this->adNot = $adNot;
        return $this;
    }

    /**
     * Get adNot
     *
     * @return string
     */
    public function getAdNot()
    {
        return $this->adNot;
    }

    /**
     * Set extras
     *
     * @param string $extras
     * @return RelatorioEspelhoPonto
     */
    public function setExtras($extras = null)
    {
        $this->extras = $extras;
        return $this;
    }

    /**
     * Get extras
     *
     * @return string
     */
    public function getExtras()
    {
        return $this->extras;
    }

    /**
     * Set extNot
     *
     * @param string $extNot
     * @return RelatorioEspelhoPonto
     */
    public function setExtNot($extNot = null)
    {
        $this->extNot = $extNot;
        return $this;
    }

    /**
     * Get extNot
     *
     * @return string
     */
    public function getExtNot()
    {
        return $this->extNot;
    }

    /**
     * Set atrasos
     *
     * @param string $atrasos
     * @return RelatorioEspelhoPonto
     */
    public function setAtrasos($atrasos = null)
    {
        $this->atrasos = $atrasos;
        return $this;
    }

    /**
     * Get atrasos
     *
     * @return string
     */
    public function getAtrasos()
    {
        return $this->atrasos;
    }

    /**
     * Set faltas
     *
     * @param string $faltas
     * @return RelatorioEspelhoPonto
     */
    public function setFaltas($faltas = null)
    {
        $this->faltas = $faltas;
        return $this;
    }

    /**
     * Get faltas
     *
     * @return string
     */
    public function getFaltas()
    {
        return $this->faltas;
    }

    /**
     * Set hsTot
     *
     * @param string $hsTot
     * @return RelatorioEspelhoPonto
     */
    public function setHsTot($hsTot = null)
    {
        $this->hsTot = $hsTot;
        return $this;
    }

    /**
     * Get hsTot
     *
     * @return string
     */
    public function getHsTot()
    {
        return $this->hsTot;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalContrato
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Contrato $fkPessoalContrato
     * @return RelatorioEspelhoPonto
     */
    public function setFkPessoalContrato(\Urbem\CoreBundle\Entity\Pessoal\Contrato $fkPessoalContrato)
    {
        $this->codContrato = $fkPessoalContrato->getCodContrato();
        $this->fkPessoalContrato = $fkPessoalContrato;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalContrato
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Contrato
     */
    public function getFkPessoalContrato()
    {
        return $this->fkPessoalContrato;
    }
}
