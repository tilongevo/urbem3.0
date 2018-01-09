<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * SalarioFamiliaEvento
 */
class SalarioFamiliaEvento
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codRegimePrevidencia;

    /**
     * @var integer
     */
    private $codEvento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoSalarioFamilia
     */
    private $fkFolhapagamentoTipoEventoSalarioFamilia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamilia
     */
    private $fkFolhapagamentoSalarioFamilia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    private $fkFolhapagamentoEvento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return SalarioFamiliaEvento
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return SalarioFamiliaEvento
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
     * Set codRegimePrevidencia
     *
     * @param integer $codRegimePrevidencia
     * @return SalarioFamiliaEvento
     */
    public function setCodRegimePrevidencia($codRegimePrevidencia)
    {
        $this->codRegimePrevidencia = $codRegimePrevidencia;
        return $this;
    }

    /**
     * Get codRegimePrevidencia
     *
     * @return integer
     */
    public function getCodRegimePrevidencia()
    {
        return $this->codRegimePrevidencia;
    }

    /**
     * Set codEvento
     *
     * @param integer $codEvento
     * @return SalarioFamiliaEvento
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
     * Set fkFolhapagamentoTipoEventoSalarioFamilia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoSalarioFamilia $fkFolhapagamentoTipoEventoSalarioFamilia
     * @return SalarioFamiliaEvento
     */
    public function setFkFolhapagamentoTipoEventoSalarioFamilia(\Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoSalarioFamilia $fkFolhapagamentoTipoEventoSalarioFamilia)
    {
        $this->codTipo = $fkFolhapagamentoTipoEventoSalarioFamilia->getCodTipo();
        $this->fkFolhapagamentoTipoEventoSalarioFamilia = $fkFolhapagamentoTipoEventoSalarioFamilia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoTipoEventoSalarioFamilia
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoSalarioFamilia
     */
    public function getFkFolhapagamentoTipoEventoSalarioFamilia()
    {
        return $this->fkFolhapagamentoTipoEventoSalarioFamilia;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoSalarioFamilia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamilia $fkFolhapagamentoSalarioFamilia
     * @return SalarioFamiliaEvento
     */
    public function setFkFolhapagamentoSalarioFamilia(\Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamilia $fkFolhapagamentoSalarioFamilia)
    {
        $this->codRegimePrevidencia = $fkFolhapagamentoSalarioFamilia->getCodRegimePrevidencia();
        $this->timestamp = $fkFolhapagamentoSalarioFamilia->getTimestamp();
        $this->fkFolhapagamentoSalarioFamilia = $fkFolhapagamentoSalarioFamilia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoSalarioFamilia
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamilia
     */
    public function getFkFolhapagamentoSalarioFamilia()
    {
        return $this->fkFolhapagamentoSalarioFamilia;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento
     * @return SalarioFamiliaEvento
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
