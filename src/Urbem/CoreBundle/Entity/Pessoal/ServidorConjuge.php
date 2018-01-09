<?php

namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ServidorConjuge
 */
class ServidorConjuge
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
     * @var integer
     */
    private $numcgm;

    /**
     * @var boolean
     */
    private $boExcluido = false;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Servidor
     */
    private $fkPessoalServidor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    private $fkSwCgmPessoaFisica;

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
     * @return ServidorConjuge
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
     * @return ServidorConjuge
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
     * Set numcgm
     *
     * @param integer $numcgm
     * @return ServidorConjuge
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
     * Set boExcluido
     *
     * @param boolean $boExcluido
     * @return ServidorConjuge
     */
    public function setBoExcluido($boExcluido = null)
    {
        $this->boExcluido = $boExcluido;
        return $this;
    }

    /**
     * Get boExcluido
     *
     * @return boolean
     */
    public function getBoExcluido()
    {
        return $this->boExcluido;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Servidor $fkPessoalServidor
     * @return ServidorConjuge
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
     * Set fkSwCgmPessoaFisica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica
     * @return ServidorConjuge
     */
    public function setFkSwCgmPessoaFisica(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica)
    {
        $this->numcgm = $fkSwCgmPessoaFisica->getNumcgm();
        $this->fkSwCgmPessoaFisica = $fkSwCgmPessoaFisica;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgmPessoaFisica
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    public function getFkSwCgmPessoaFisica()
    {
        return $this->fkSwCgmPessoaFisica;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '%d - %s',
            $this->fkSwCgmPessoaFisica->getNumcgm(),
            $this->fkSwCgmPessoaFisica->getFkSwCgm()->getNomCgm()
        );
    }
}
