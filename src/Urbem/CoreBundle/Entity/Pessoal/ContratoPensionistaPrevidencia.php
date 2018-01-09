<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ContratoPensionistaPrevidencia
 */
class ContratoPensionistaPrevidencia
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
    private $codPrevidencia;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var boolean
     */
    private $boExcluido = false;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista
     */
    private $fkPessoalContratoPensionista;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Previdencia
     */
    private $fkFolhapagamentoPrevidencia;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ContratoPensionistaPrevidencia
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
     * Set codPrevidencia
     *
     * @param integer $codPrevidencia
     * @return ContratoPensionistaPrevidencia
     */
    public function setCodPrevidencia($codPrevidencia)
    {
        $this->codPrevidencia = $codPrevidencia;
        return $this;
    }

    /**
     * Get codPrevidencia
     *
     * @return integer
     */
    public function getCodPrevidencia()
    {
        return $this->codPrevidencia;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ContratoPensionistaPrevidencia
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
     * Set boExcluido
     *
     * @param boolean $boExcluido
     * @return ContratoPensionistaPrevidencia
     */
    public function setBoExcluido($boExcluido)
    {
        $this->boExcluido = $boExcluido;
        return $this;
    }

    /**
     * Get boExcluido
     *
     * @return boolean
     */
    public function getBoExcluido()
    {
        return $this->boExcluido;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalContratoPensionista
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista $fkPessoalContratoPensionista
     * @return ContratoPensionistaPrevidencia
     */
    public function setFkPessoalContratoPensionista(\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista $fkPessoalContratoPensionista)
    {
        $this->codContrato = $fkPessoalContratoPensionista->getCodContrato();
        $this->fkPessoalContratoPensionista = $fkPessoalContratoPensionista;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalContratoPensionista
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista
     */
    public function getFkPessoalContratoPensionista()
    {
        return $this->fkPessoalContratoPensionista;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoPrevidencia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Previdencia $fkFolhapagamentoPrevidencia
     * @return ContratoPensionistaPrevidencia
     */
    public function setFkFolhapagamentoPrevidencia(\Urbem\CoreBundle\Entity\Folhapagamento\Previdencia $fkFolhapagamentoPrevidencia)
    {
        $this->codPrevidencia = $fkFolhapagamentoPrevidencia->getCodPrevidencia();
        $this->fkFolhapagamentoPrevidencia = $fkFolhapagamentoPrevidencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoPrevidencia
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\Previdencia
     */
    public function getFkFolhapagamentoPrevidencia()
    {
        return $this->fkFolhapagamentoPrevidencia;
    }
}
