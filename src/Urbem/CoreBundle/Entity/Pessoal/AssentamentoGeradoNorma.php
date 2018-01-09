<?php

namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * AssentamentoGeradoNorma
 */
class AssentamentoGeradoNorma
{
    /**
     * PK
     * @var integer
     */
    private $codAssentamentoGerado;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codNorma;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\AssentamentoGerado
     */
    private $fkPessoalAssentamentoGerado;

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
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codAssentamentoGerado
     *
     * @param integer $codAssentamentoGerado
     * @return AssentamentoGeradoNorma
     */
    public function setCodAssentamentoGerado($codAssentamentoGerado)
    {
        $this->codAssentamentoGerado = $codAssentamentoGerado;
        return $this;
    }

    /**
     * Get codAssentamentoGerado
     *
     * @return integer
     */
    public function getCodAssentamentoGerado()
    {
        return $this->codAssentamentoGerado;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return AssentamentoGeradoNorma
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
     * Set codNorma
     *
     * @param integer $codNorma
     * @return AssentamentoGeradoNorma
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
     * Set fkPessoalAssentamentoGerado
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoGerado $fkPessoalAssentamentoGerado
     * @return AssentamentoGeradoNorma
     */
    public function setFkPessoalAssentamentoGerado(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoGerado $fkPessoalAssentamentoGerado)
    {
        $this->timestamp = $fkPessoalAssentamentoGerado->getTimestamp();
        $this->codAssentamentoGerado = $fkPessoalAssentamentoGerado->getCodAssentamentoGerado();
        $this->fkPessoalAssentamentoGerado = $fkPessoalAssentamentoGerado;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalAssentamentoGerado
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\AssentamentoGerado
     */
    public function getFkPessoalAssentamentoGerado()
    {
        return $this->fkPessoalAssentamentoGerado;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return AssentamentoGeradoNorma
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

    public function __toString()
    {
        return $this->getFkNormasNorma()->getCodNorma() . " - " . $this->getFkNormasNorma()->getNomNorma();
    }
}
