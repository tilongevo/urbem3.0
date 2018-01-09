<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ServidorPisPasep
 */
class ServidorPisPasep
{
    /**
     * PK
     * @var integer
     */
    private $codServidor;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var \DateTime
     */
    private $dtPisPasep;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Servidor
     */
    private $fkPessoalServidor;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codServidor
     *
     * @param integer $codServidor
     * @return ServidorPisPasep
     */
    public function setCodServidor($codServidor)
    {
        $this->codServidor = $codServidor;
        return $this;
    }

    /**
     * Get codServidor
     *
     * @return integer
     */
    public function getCodServidor()
    {
        return $this->codServidor;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ServidorPisPasep
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
     * Set dtPisPasep
     *
     * @param \DateTime $dtPisPasep
     * @return ServidorPisPasep
     */
    public function setDtPisPasep(\DateTime $dtPisPasep = null)
    {
        $this->dtPisPasep = $dtPisPasep;
        return $this;
    }

    /**
     * Get dtPisPasep
     *
     * @return \DateTime
     */
    public function getDtPisPasep()
    {
        return $this->dtPisPasep;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Servidor $fkPessoalServidor
     * @return ServidorPisPasep
     */
    public function setFkPessoalServidor(\Urbem\CoreBundle\Entity\Pessoal\Servidor $fkPessoalServidor)
    {
        $this->codServidor = $fkPessoalServidor->getCodServidor();
        $this->fkPessoalServidor = $fkPessoalServidor;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalServidor
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Servidor
     */
    public function getFkPessoalServidor()
    {
        return $this->fkPessoalServidor;
    }
}
