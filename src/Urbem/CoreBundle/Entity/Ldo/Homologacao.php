<?php
 
namespace Urbem\CoreBundle\Entity\Ldo;

/**
 * Homologacao
 */
class Homologacao
{
    /**
     * PK
     * @var integer
     */
    private $codPpa;

    /**
     * PK
     * @var string
     */
    private $ano;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codNorma;

    /**
     * @var integer
     */
    private $numcgmVeiculo;

    /**
     * @var integer
     */
    private $codPeriodicidade;

    /**
     * @var \DateTime
     */
    private $dtEncaminhamento;

    /**
     * @var \DateTime
     */
    private $dtDevolucao;

    /**
     * @var string
     */
    private $nroProtocolo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ldo\Ldo
     */
    private $fkLdoLdo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade
     */
    private $fkLicitacaoVeiculosPublicidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ppa\Periodicidade
     */
    private $fkPpaPeriodicidade;

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
     * @return Homologacao
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
     * Set ano
     *
     * @param string $ano
     * @return Homologacao
     */
    public function setAno($ano)
    {
        $this->ano = $ano;
        return $this;
    }

    /**
     * Get ano
     *
     * @return string
     */
    public function getAno()
    {
        return $this->ano;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return Homologacao
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
     * @return Homologacao
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
     * Set numcgmVeiculo
     *
     * @param integer $numcgmVeiculo
     * @return Homologacao
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
     * Set codPeriodicidade
     *
     * @param integer $codPeriodicidade
     * @return Homologacao
     */
    public function setCodPeriodicidade($codPeriodicidade)
    {
        $this->codPeriodicidade = $codPeriodicidade;
        return $this;
    }

    /**
     * Get codPeriodicidade
     *
     * @return integer
     */
    public function getCodPeriodicidade()
    {
        return $this->codPeriodicidade;
    }

    /**
     * Set dtEncaminhamento
     *
     * @param \DateTime $dtEncaminhamento
     * @return Homologacao
     */
    public function setDtEncaminhamento(\DateTime $dtEncaminhamento)
    {
        $this->dtEncaminhamento = $dtEncaminhamento;
        return $this;
    }

    /**
     * Get dtEncaminhamento
     *
     * @return \DateTime
     */
    public function getDtEncaminhamento()
    {
        return $this->dtEncaminhamento;
    }

    /**
     * Set dtDevolucao
     *
     * @param \DateTime $dtDevolucao
     * @return Homologacao
     */
    public function setDtDevolucao(\DateTime $dtDevolucao)
    {
        $this->dtDevolucao = $dtDevolucao;
        return $this;
    }

    /**
     * Get dtDevolucao
     *
     * @return \DateTime
     */
    public function getDtDevolucao()
    {
        return $this->dtDevolucao;
    }

    /**
     * Set nroProtocolo
     *
     * @param string $nroProtocolo
     * @return Homologacao
     */
    public function setNroProtocolo($nroProtocolo)
    {
        $this->nroProtocolo = $nroProtocolo;
        return $this;
    }

    /**
     * Get nroProtocolo
     *
     * @return string
     */
    public function getNroProtocolo()
    {
        return $this->nroProtocolo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLdoLdo
     *
     * @param \Urbem\CoreBundle\Entity\Ldo\Ldo $fkLdoLdo
     * @return Homologacao
     */
    public function setFkLdoLdo(\Urbem\CoreBundle\Entity\Ldo\Ldo $fkLdoLdo)
    {
        $this->codPpa = $fkLdoLdo->getCodPpa();
        $this->ano = $fkLdoLdo->getAno();
        $this->fkLdoLdo = $fkLdoLdo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLdoLdo
     *
     * @return \Urbem\CoreBundle\Entity\Ldo\Ldo
     */
    public function getFkLdoLdo()
    {
        return $this->fkLdoLdo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return Homologacao
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
     * ManyToOne (inverse side)
     * Set fkLicitacaoVeiculosPublicidade
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade $fkLicitacaoVeiculosPublicidade
     * @return Homologacao
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
     * Set fkPpaPeriodicidade
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\Periodicidade $fkPpaPeriodicidade
     * @return Homologacao
     */
    public function setFkPpaPeriodicidade(\Urbem\CoreBundle\Entity\Ppa\Periodicidade $fkPpaPeriodicidade)
    {
        $this->codPeriodicidade = $fkPpaPeriodicidade->getCodPeriodicidade();
        $this->fkPpaPeriodicidade = $fkPpaPeriodicidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPpaPeriodicidade
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\Periodicidade
     */
    public function getFkPpaPeriodicidade()
    {
        return $this->fkPpaPeriodicidade;
    }
}
