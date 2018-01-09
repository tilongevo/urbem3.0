<?php
 
namespace Urbem\CoreBundle\Entity\Estagio;

/**
 * EntidadeContribuicao
 */
class EntidadeContribuicao
{
    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $percentual;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Estagio\EntidadeIntermediadora
     */
    private $fkEstagioEntidadeIntermediadora;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return EntidadeContribuicao
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return EntidadeContribuicao
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
     * Set percentual
     *
     * @param integer $percentual
     * @return EntidadeContribuicao
     */
    public function setPercentual($percentual)
    {
        $this->percentual = $percentual;
        return $this;
    }

    /**
     * Get percentual
     *
     * @return integer
     */
    public function getPercentual()
    {
        return $this->percentual;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEstagioEntidadeIntermediadora
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EntidadeIntermediadora $fkEstagioEntidadeIntermediadora
     * @return EntidadeContribuicao
     */
    public function setFkEstagioEntidadeIntermediadora(\Urbem\CoreBundle\Entity\Estagio\EntidadeIntermediadora $fkEstagioEntidadeIntermediadora)
    {
        $this->numcgm = $fkEstagioEntidadeIntermediadora->getNumcgm();
        $this->fkEstagioEntidadeIntermediadora = $fkEstagioEntidadeIntermediadora;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEstagioEntidadeIntermediadora
     *
     * @return \Urbem\CoreBundle\Entity\Estagio\EntidadeIntermediadora
     */
    public function getFkEstagioEntidadeIntermediadora()
    {
        return $this->fkEstagioEntidadeIntermediadora;
    }
}
