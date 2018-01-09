<?php
 
namespace Urbem\CoreBundle\Entity\Patrimonio;

/**
 * ApoliceBem
 */
class ApoliceBem
{
    /**
     * PK
     * @var integer
     */
    private $codApolice;

    /**
     * PK
     * @var integer
     */
    private $codBem;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Patrimonio\Apolice
     */
    private $fkPatrimonioApolice;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Patrimonio\Bem
     */
    private $fkPatrimonioBem;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codApolice
     *
     * @param integer $codApolice
     * @return ApoliceBem
     */
    public function setCodApolice($codApolice)
    {
        $this->codApolice = $codApolice;
        return $this;
    }

    /**
     * Get codApolice
     *
     * @return integer
     */
    public function getCodApolice()
    {
        return $this->codApolice;
    }

    /**
     * Set codBem
     *
     * @param integer $codBem
     * @return ApoliceBem
     */
    public function setCodBem($codBem)
    {
        $this->codBem = $codBem;
        return $this;
    }

    /**
     * Get codBem
     *
     * @return integer
     */
    public function getCodBem()
    {
        return $this->codBem;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return ApoliceBem
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimePK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPatrimonioApolice
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Apolice $fkPatrimonioApolice
     * @return ApoliceBem
     */
    public function setFkPatrimonioApolice(\Urbem\CoreBundle\Entity\Patrimonio\Apolice $fkPatrimonioApolice)
    {
        $this->codApolice = $fkPatrimonioApolice->getCodApolice();
        $this->fkPatrimonioApolice = $fkPatrimonioApolice;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPatrimonioApolice
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\Apolice
     */
    public function getFkPatrimonioApolice()
    {
        return $this->fkPatrimonioApolice;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPatrimonioBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Bem $fkPatrimonioBem
     * @return ApoliceBem
     */
    public function setFkPatrimonioBem(\Urbem\CoreBundle\Entity\Patrimonio\Bem $fkPatrimonioBem)
    {
        $this->codBem = $fkPatrimonioBem->getCodBem();
        $this->fkPatrimonioBem = $fkPatrimonioBem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPatrimonioBem
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\Bem
     */
    public function getFkPatrimonioBem()
    {
        return $this->fkPatrimonioBem;
    }
}
