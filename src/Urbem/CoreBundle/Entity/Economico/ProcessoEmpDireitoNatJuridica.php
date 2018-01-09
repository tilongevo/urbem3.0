<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * ProcessoEmpDireitoNatJuridica
 */
class ProcessoEmpDireitoNatJuridica
{
    /**
     * PK
     * @var integer
     */
    private $inscricaoEconomica;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var string
     */
    private $anoExercicio;

    /**
     * PK
     * @var integer
     */
    private $codProcesso;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampProc;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\EmpresaDireitoNaturezaJuridica
     */
    private $fkEconomicoEmpresaDireitoNaturezaJuridica;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwProcesso
     */
    private $fkSwProcesso;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestampProc = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return ProcessoEmpDireitoNatJuridica
     */
    public function setInscricaoEconomica($inscricaoEconomica)
    {
        $this->inscricaoEconomica = $inscricaoEconomica;
        return $this;
    }

    /**
     * Get inscricaoEconomica
     *
     * @return integer
     */
    public function getInscricaoEconomica()
    {
        return $this->inscricaoEconomica;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ProcessoEmpDireitoNatJuridica
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
     * Set anoExercicio
     *
     * @param string $anoExercicio
     * @return ProcessoEmpDireitoNatJuridica
     */
    public function setAnoExercicio($anoExercicio)
    {
        $this->anoExercicio = $anoExercicio;
        return $this;
    }

    /**
     * Get anoExercicio
     *
     * @return string
     */
    public function getAnoExercicio()
    {
        return $this->anoExercicio;
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return ProcessoEmpDireitoNatJuridica
     */
    public function setCodProcesso($codProcesso)
    {
        $this->codProcesso = $codProcesso;
        return $this;
    }

    /**
     * Get codProcesso
     *
     * @return integer
     */
    public function getCodProcesso()
    {
        return $this->codProcesso;
    }

    /**
     * Set timestampProc
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampProc
     * @return ProcessoEmpDireitoNatJuridica
     */
    public function setTimestampProc(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampProc)
    {
        $this->timestampProc = $timestampProc;
        return $this;
    }

    /**
     * Get timestampProc
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampProc()
    {
        return $this->timestampProc;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoEmpresaDireitoNaturezaJuridica
     *
     * @param \Urbem\CoreBundle\Entity\Economico\EmpresaDireitoNaturezaJuridica $fkEconomicoEmpresaDireitoNaturezaJuridica
     * @return ProcessoEmpDireitoNatJuridica
     */
    public function setFkEconomicoEmpresaDireitoNaturezaJuridica(\Urbem\CoreBundle\Entity\Economico\EmpresaDireitoNaturezaJuridica $fkEconomicoEmpresaDireitoNaturezaJuridica)
    {
        $this->inscricaoEconomica = $fkEconomicoEmpresaDireitoNaturezaJuridica->getInscricaoEconomica();
        $this->timestamp = $fkEconomicoEmpresaDireitoNaturezaJuridica->getTimestamp();
        $this->fkEconomicoEmpresaDireitoNaturezaJuridica = $fkEconomicoEmpresaDireitoNaturezaJuridica;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoEmpresaDireitoNaturezaJuridica
     *
     * @return \Urbem\CoreBundle\Entity\Economico\EmpresaDireitoNaturezaJuridica
     */
    public function getFkEconomicoEmpresaDireitoNaturezaJuridica()
    {
        return $this->fkEconomicoEmpresaDireitoNaturezaJuridica;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     * @return ProcessoEmpDireitoNatJuridica
     */
    public function setFkSwProcesso(\Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso)
    {
        $this->codProcesso = $fkSwProcesso->getCodProcesso();
        $this->anoExercicio = $fkSwProcesso->getAnoExercicio();
        $this->fkSwProcesso = $fkSwProcesso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwProcesso
     *
     * @return \Urbem\CoreBundle\Entity\SwProcesso
     */
    public function getFkSwProcesso()
    {
        return $this->fkSwProcesso;
    }
}
