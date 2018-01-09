<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * PensaoIncidencia
 */
class PensaoIncidencia
{
    /**
     * PK
     * @var integer
     */
    private $codPensao;

    /**
     * PK
     * @var integer
     */
    private $codIncidencia;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Pensao
     */
    private $fkPessoalPensao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Incidencia
     */
    private $fkPessoalIncidencia;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codPensao
     *
     * @param integer $codPensao
     * @return PensaoIncidencia
     */
    public function setCodPensao($codPensao)
    {
        $this->codPensao = $codPensao;
        return $this;
    }

    /**
     * Get codPensao
     *
     * @return integer
     */
    public function getCodPensao()
    {
        return $this->codPensao;
    }

    /**
     * Set codIncidencia
     *
     * @param integer $codIncidencia
     * @return PensaoIncidencia
     */
    public function setCodIncidencia($codIncidencia)
    {
        $this->codIncidencia = $codIncidencia;
        return $this;
    }

    /**
     * Get codIncidencia
     *
     * @return integer
     */
    public function getCodIncidencia()
    {
        return $this->codIncidencia;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return PensaoIncidencia
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
     * Set fkPessoalPensao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Pensao $fkPessoalPensao
     * @return PensaoIncidencia
     */
    public function setFkPessoalPensao(\Urbem\CoreBundle\Entity\Pessoal\Pensao $fkPessoalPensao)
    {
        $this->codPensao = $fkPessoalPensao->getCodPensao();
        $this->timestamp = $fkPessoalPensao->getTimestamp();
        $this->fkPessoalPensao = $fkPessoalPensao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalPensao
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Pensao
     */
    public function getFkPessoalPensao()
    {
        return $this->fkPessoalPensao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalIncidencia
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Incidencia $fkPessoalIncidencia
     * @return PensaoIncidencia
     */
    public function setFkPessoalIncidencia(\Urbem\CoreBundle\Entity\Pessoal\Incidencia $fkPessoalIncidencia)
    {
        $this->codIncidencia = $fkPessoalIncidencia->getCodIncidencia();
        $this->fkPessoalIncidencia = $fkPessoalIncidencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalIncidencia
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Incidencia
     */
    public function getFkPessoalIncidencia()
    {
        return $this->fkPessoalIncidencia;
    }
}
