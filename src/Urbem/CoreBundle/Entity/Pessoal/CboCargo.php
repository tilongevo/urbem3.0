<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * CboCargo
 */
class CboCargo
{
    /**
     * PK
     * @var integer
     */
    private $codCbo;

    /**
     * PK
     * @var integer
     */
    private $codCargo;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Cbo
     */
    private $fkPessoalCbo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Cargo
     */
    private $fkPessoalCargo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codCbo
     *
     * @param integer $codCbo
     * @return CboCargo
     */
    public function setCodCbo($codCbo)
    {
        $this->codCbo = $codCbo;
        return $this;
    }

    /**
     * Get codCbo
     *
     * @return integer
     */
    public function getCodCbo()
    {
        return $this->codCbo;
    }

    /**
     * Set codCargo
     *
     * @param integer $codCargo
     * @return CboCargo
     */
    public function setCodCargo($codCargo)
    {
        $this->codCargo = $codCargo;
        return $this;
    }

    /**
     * Get codCargo
     *
     * @return integer
     */
    public function getCodCargo()
    {
        return $this->codCargo;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return CboCargo
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
     * ManyToOne (inverse side)
     * Set fkPessoalCbo
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Cbo $fkPessoalCbo
     * @return CboCargo
     */
    public function setFkPessoalCbo(\Urbem\CoreBundle\Entity\Pessoal\Cbo $fkPessoalCbo)
    {
        $this->codCbo = $fkPessoalCbo->getCodCbo();
        $this->fkPessoalCbo = $fkPessoalCbo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalCbo
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Cbo
     */
    public function getFkPessoalCbo()
    {
        return $this->fkPessoalCbo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalCargo
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Cargo $fkPessoalCargo
     * @return CboCargo
     */
    public function setFkPessoalCargo(\Urbem\CoreBundle\Entity\Pessoal\Cargo $fkPessoalCargo)
    {
        $this->codCargo = $fkPessoalCargo->getCodCargo();
        $this->fkPessoalCargo = $fkPessoalCargo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalCargo
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Cargo
     */
    public function getFkPessoalCargo()
    {
        return $this->fkPessoalCargo;
    }
}
