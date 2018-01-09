<?php
 
namespace Urbem\CoreBundle\Entity\Ppa;

/**
 * AcaoNorma
 */
class AcaoNorma
{
    /**
     * PK
     * @var integer
     */
    private $codAcao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampAcaoDados;

    /**
     * PK
     * @var integer
     */
    private $codNorma;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ppa\AcaoDados
     */
    private $fkPpaAcaoDados;

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
        $this->timestampAcaoDados = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codAcao
     *
     * @param integer $codAcao
     * @return AcaoNorma
     */
    public function setCodAcao($codAcao)
    {
        $this->codAcao = $codAcao;
        return $this;
    }

    /**
     * Get codAcao
     *
     * @return integer
     */
    public function getCodAcao()
    {
        return $this->codAcao;
    }

    /**
     * Set timestampAcaoDados
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampAcaoDados
     * @return AcaoNorma
     */
    public function setTimestampAcaoDados(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampAcaoDados)
    {
        $this->timestampAcaoDados = $timestampAcaoDados;
        return $this;
    }

    /**
     * Get timestampAcaoDados
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampAcaoDados()
    {
        return $this->timestampAcaoDados;
    }

    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return AcaoNorma
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
     * ManyToOne (inverse side)
     * Set fkPpaAcaoDados
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\AcaoDados $fkPpaAcaoDados
     * @return AcaoNorma
     */
    public function setFkPpaAcaoDados(\Urbem\CoreBundle\Entity\Ppa\AcaoDados $fkPpaAcaoDados)
    {
        $this->codAcao = $fkPpaAcaoDados->getCodAcao();
        $this->timestampAcaoDados = $fkPpaAcaoDados->getTimestampAcaoDados();
        $this->fkPpaAcaoDados = $fkPpaAcaoDados;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPpaAcaoDados
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\AcaoDados
     */
    public function getFkPpaAcaoDados()
    {
        return $this->fkPpaAcaoDados;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return AcaoNorma
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
