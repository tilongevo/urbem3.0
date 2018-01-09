<?php
 
namespace Urbem\CoreBundle\Entity\Tceto;

/**
 * AlteracaoLeiPpa
 */
class AlteracaoLeiPpa
{
    /**
     * PK
     * @var integer
     */
    private $codNorma;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DatePK
     */
    private $dataAlteracao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dataAlteracao = new \Urbem\CoreBundle\Helper\DatePK;
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return AlteracaoLeiPpa
     */
    public function setCodNorma($codNorma)
    {
        $this->codNorma = $codNorma;
        return $this;
    }

    /**
     * Get codNorma
     *
     * @return integer
     */
    public function getCodNorma()
    {
        return $this->codNorma;
    }

    /**
     * Set dataAlteracao
     *
     * @param \Urbem\CoreBundle\Helper\DatePK $dataAlteracao
     * @return AlteracaoLeiPpa
     */
    public function setDataAlteracao(\Urbem\CoreBundle\Helper\DatePK $dataAlteracao)
    {
        $this->dataAlteracao = $dataAlteracao;
        return $this;
    }

    /**
     * Get dataAlteracao
     *
     * @return \Urbem\CoreBundle\Helper\DatePK
     */
    public function getDataAlteracao()
    {
        return $this->dataAlteracao;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return AlteracaoLeiPpa
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
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return AlteracaoLeiPpa
     */
    public function setFkNormasNorma(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        $this->codNorma = $fkNormasNorma->getCodNorma();
        $this->fkNormasNorma = $fkNormasNorma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNorma()
    {
        return $this->fkNormasNorma;
    }
}
