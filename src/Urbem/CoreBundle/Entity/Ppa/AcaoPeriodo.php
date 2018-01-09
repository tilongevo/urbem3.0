<?php
 
namespace Urbem\CoreBundle\Entity\Ppa;

/**
 * AcaoPeriodo
 */
class AcaoPeriodo
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
     * @var \DateTime
     */
    private $dataInicio;

    /**
     * @var \DateTime
     */
    private $dataTermino;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Ppa\AcaoDados
     */
    private $fkPpaAcaoDados;

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
     * @return AcaoPeriodo
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
     * @return AcaoPeriodo
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
     * Set dataInicio
     *
     * @param \DateTime $dataInicio
     * @return AcaoPeriodo
     */
    public function setDataInicio(\DateTime $dataInicio)
    {
        $this->dataInicio = $dataInicio;
        return $this;
    }

    /**
     * Get dataInicio
     *
     * @return \DateTime
     */
    public function getDataInicio()
    {
        return $this->dataInicio;
    }

    /**
     * Set dataTermino
     *
     * @param \DateTime $dataTermino
     * @return AcaoPeriodo
     */
    public function setDataTermino(\DateTime $dataTermino)
    {
        $this->dataTermino = $dataTermino;
        return $this;
    }

    /**
     * Get dataTermino
     *
     * @return \DateTime
     */
    public function getDataTermino()
    {
        return $this->dataTermino;
    }

    /**
     * OneToOne (owning side)
     * Set PpaAcaoDados
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\AcaoDados $fkPpaAcaoDados
     * @return AcaoPeriodo
     */
    public function setFkPpaAcaoDados(\Urbem\CoreBundle\Entity\Ppa\AcaoDados $fkPpaAcaoDados)
    {
        $this->codAcao = $fkPpaAcaoDados->getCodAcao();
        $this->timestampAcaoDados = $fkPpaAcaoDados->getTimestampAcaoDados();
        $this->fkPpaAcaoDados = $fkPpaAcaoDados;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPpaAcaoDados
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\AcaoDados
     */
    public function getFkPpaAcaoDados()
    {
        return $this->fkPpaAcaoDados;
    }
}
