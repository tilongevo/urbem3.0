<?php
 
namespace Urbem\CoreBundle\Entity\Ppa;

/**
 * PpaPublicacao
 */
class PpaPublicacao
{
    /**
     * PK
     * @var integer
     */
    private $codPpa;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $numcgmVeiculo;

    /**
     * @var integer
     */
    private $codNorma;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ppa\PpaEncaminhamento
     */
    private $fkPpaPpaEncaminhamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ppa\Ppa
     */
    private $fkPpaPpa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade
     */
    private $fkLicitacaoVeiculosPublicidade;

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
     * Set codPpa
     *
     * @param integer $codPpa
     * @return PpaPublicacao
     */
    public function setCodPpa($codPpa)
    {
        $this->codPpa = $codPpa;
        return $this;
    }

    /**
     * Get codPpa
     *
     * @return integer
     */
    public function getCodPpa()
    {
        return $this->codPpa;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return PpaPublicacao
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
     * Set numcgmVeiculo
     *
     * @param integer $numcgmVeiculo
     * @return PpaPublicacao
     */
    public function setNumcgmVeiculo($numcgmVeiculo)
    {
        $this->numcgmVeiculo = $numcgmVeiculo;
        return $this;
    }

    /**
     * Get numcgmVeiculo
     *
     * @return integer
     */
    public function getNumcgmVeiculo()
    {
        return $this->numcgmVeiculo;
    }

    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return PpaPublicacao
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
     * Set fkPpaPpa
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\Ppa $fkPpaPpa
     * @return PpaPublicacao
     */
    public function setFkPpaPpa(\Urbem\CoreBundle\Entity\Ppa\Ppa $fkPpaPpa)
    {
        $this->codPpa = $fkPpaPpa->getCodPpa();
        $this->fkPpaPpa = $fkPpaPpa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPpaPpa
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\Ppa
     */
    public function getFkPpaPpa()
    {
        return $this->fkPpaPpa;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoVeiculosPublicidade
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade $fkLicitacaoVeiculosPublicidade
     * @return PpaPublicacao
     */
    public function setFkLicitacaoVeiculosPublicidade(\Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade $fkLicitacaoVeiculosPublicidade)
    {
        $this->numcgmVeiculo = $fkLicitacaoVeiculosPublicidade->getNumcgm();
        $this->fkLicitacaoVeiculosPublicidade = $fkLicitacaoVeiculosPublicidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoVeiculosPublicidade
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade
     */
    public function getFkLicitacaoVeiculosPublicidade()
    {
        return $this->fkLicitacaoVeiculosPublicidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return PpaPublicacao
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

    /**
     * OneToOne (inverse side)
     * Set PpaPpaEncaminhamento
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\PpaEncaminhamento $fkPpaPpaEncaminhamento
     * @return PpaPublicacao
     */
    public function setFkPpaPpaEncaminhamento(\Urbem\CoreBundle\Entity\Ppa\PpaEncaminhamento $fkPpaPpaEncaminhamento)
    {
        $fkPpaPpaEncaminhamento->setFkPpaPpaPublicacao($this);
        $this->fkPpaPpaEncaminhamento = $fkPpaPpaEncaminhamento;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPpaPpaEncaminhamento
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\PpaEncaminhamento
     */
    public function getFkPpaPpaEncaminhamento()
    {
        return $this->fkPpaPpaEncaminhamento;
    }
}
