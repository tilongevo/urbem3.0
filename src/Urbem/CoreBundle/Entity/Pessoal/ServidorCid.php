<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ServidorCid
 */
class ServidorCid
{
    /**
     * PK
     * @var integer
     */
    private $codServidor;

    /**
     * PK
     * @var integer
     */
    private $codCid;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var \DateTime
     */
    private $dataLaudo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Servidor
     */
    private $fkPessoalServidor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Cid
     */
    private $fkPessoalCid;

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
     * @return ServidorCid
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
     * Set codCid
     *
     * @param integer $codCid
     * @return ServidorCid
     */
    public function setCodCid($codCid)
    {
        $this->codCid = $codCid;
        return $this;
    }

    /**
     * Get codCid
     *
     * @return integer
     */
    public function getCodCid()
    {
        return $this->codCid;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ServidorCid
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
     * Set dataLaudo
     *
     * @param \DateTime $dataLaudo
     * @return ServidorCid
     */
    public function setDataLaudo(\DateTime $dataLaudo = null)
    {
        $this->dataLaudo = $dataLaudo;
        return $this;
    }

    /**
     * Get dataLaudo
     *
     * @return \DateTime
     */
    public function getDataLaudo()
    {
        return $this->dataLaudo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Servidor $fkPessoalServidor
     * @return ServidorCid
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

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalCid
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Cid $fkPessoalCid
     * @return ServidorCid
     */
    public function setFkPessoalCid(\Urbem\CoreBundle\Entity\Pessoal\Cid $fkPessoalCid)
    {
        $this->codCid = $fkPessoalCid->getCodCid();
        $this->fkPessoalCid = $fkPessoalCid;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalCid
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Cid
     */
    public function getFkPessoalCid()
    {
        return $this->fkPessoalCid;
    }
}
