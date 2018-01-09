<?php

namespace Urbem\CoreBundle\Entity\Economico;

/**
 * CadastroEconRespTecnico
 */
class CadastroEconRespTecnico
{
    /**
     * PK
     * @var integer
     */
    private $inscricaoEconomica;

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
     * PK
     * @var integer
     */
    private $sequencia;

    /**
     * @var boolean
     */
    private $ativo = true;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\CadastroEconomico
     */
    private $fkEconomicoCadastroEconomico;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\Responsavel
     */
    private $fkEconomicoResponsavel;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return CadastroEconRespTecnico
     */
    public function setInscricaoEconomica($inscricaoEconomica)
    {
        $this->inscricaoEconomica = $inscricaoEconomica;
        return $this;
    }

    /**
     * Get inscricaoEconomica
     *
     * @return integer
     */
    public function getInscricaoEconomica()
    {
        return $this->inscricaoEconomica;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return CadastroEconRespTecnico
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
     * @return CadastroEconRespTecnico
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
     * Set sequencia
     *
     * @param integer $sequencia
     * @return CadastroEconRespTecnico
     */
    public function setSequencia($sequencia)
    {
        $this->sequencia = $sequencia;
        return $this;
    }

    /**
     * Get sequencia
     *
     * @return integer
     */
    public function getSequencia()
    {
        return $this->sequencia;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return CadastroEconRespTecnico
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
        return $this;
    }

    /**
     * Get ativo
     *
     * @return boolean
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoCadastroEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconomico $fkEconomicoCadastroEconomico
     * @return CadastroEconRespTecnico
     */
    public function setFkEconomicoCadastroEconomico(\Urbem\CoreBundle\Entity\Economico\CadastroEconomico $fkEconomicoCadastroEconomico)
    {
        $this->inscricaoEconomica = $fkEconomicoCadastroEconomico->getInscricaoEconomica();
        $this->fkEconomicoCadastroEconomico = $fkEconomicoCadastroEconomico;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoCadastroEconomico
     *
     * @return \Urbem\CoreBundle\Entity\Economico\CadastroEconomico
     */
    public function getFkEconomicoCadastroEconomico()
    {
        return $this->fkEconomicoCadastroEconomico;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Responsavel $fkEconomicoResponsavel
     * @return CadastroEconRespTecnico
     */
    public function setFkEconomicoResponsavel(\Urbem\CoreBundle\Entity\Economico\Responsavel $fkEconomicoResponsavel)
    {
        $this->numcgm = $fkEconomicoResponsavel->getNumcgm();
        $this->sequencia = $fkEconomicoResponsavel->getSequencia();
        $this->fkEconomicoResponsavel = $fkEconomicoResponsavel;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoResponsavel
     *
     * @return \Urbem\CoreBundle\Entity\Economico\Responsavel
     */
    public function getFkEconomicoResponsavel()
    {
        return $this->fkEconomicoResponsavel;
    }
}
