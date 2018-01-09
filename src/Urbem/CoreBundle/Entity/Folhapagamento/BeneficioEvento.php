<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * BeneficioEvento
 */
class BeneficioEvento
{
    /**
     * PK
     * @var integer
     */
    private $codConfiguracao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var integer
     */
    private $codEvento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoBeneficio
     */
    private $fkFolhapagamentoConfiguracaoBeneficio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoBeneficio
     */
    private $fkFolhapagamentoTipoEventoBeneficio;

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
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return BeneficioEvento
     */
    public function setCodConfiguracao($codConfiguracao)
    {
        $this->codConfiguracao = $codConfiguracao;
        return $this;
    }

    /**
     * Get codConfiguracao
     *
     * @return integer
     */
    public function getCodConfiguracao()
    {
        return $this->codConfiguracao;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return BeneficioEvento
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return BeneficioEvento
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
     * @return BeneficioEvento
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
     * Set fkFolhapagamentoConfiguracaoBeneficio
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoBeneficio $fkFolhapagamentoConfiguracaoBeneficio
     * @return BeneficioEvento
     */
    public function setFkFolhapagamentoConfiguracaoBeneficio(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoBeneficio $fkFolhapagamentoConfiguracaoBeneficio)
    {
        $this->codConfiguracao = $fkFolhapagamentoConfiguracaoBeneficio->getCodConfiguracao();
        $this->timestamp = $fkFolhapagamentoConfiguracaoBeneficio->getTimestamp();
        $this->fkFolhapagamentoConfiguracaoBeneficio = $fkFolhapagamentoConfiguracaoBeneficio;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoConfiguracaoBeneficio
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoBeneficio
     */
    public function getFkFolhapagamentoConfiguracaoBeneficio()
    {
        return $this->fkFolhapagamentoConfiguracaoBeneficio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoTipoEventoBeneficio
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoBeneficio $fkFolhapagamentoTipoEventoBeneficio
     * @return BeneficioEvento
     */
    public function setFkFolhapagamentoTipoEventoBeneficio(\Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoBeneficio $fkFolhapagamentoTipoEventoBeneficio)
    {
        $this->codTipo = $fkFolhapagamentoTipoEventoBeneficio->getCodTipo();
        $this->fkFolhapagamentoTipoEventoBeneficio = $fkFolhapagamentoTipoEventoBeneficio;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoTipoEventoBeneficio
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoBeneficio
     */
    public function getFkFolhapagamentoTipoEventoBeneficio()
    {
        return $this->fkFolhapagamentoTipoEventoBeneficio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento
     * @return BeneficioEvento
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
    
    public function __toString()
    {
        return $this->fkFolhapagamentoEvento->getCodigo()
        . " - " . $this->fkFolhapagamentoEvento->getDescricao();
    }
}
