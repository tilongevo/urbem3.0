<?php
 
namespace Urbem\CoreBundle\Entity\Ppa;

/**
 * PpaEncaminhamento
 */
class PpaEncaminhamento
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
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Ppa\PpaPublicacao
     */
    private $fkPpaPpaPublicacao;

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
     * @return PpaEncaminhamento
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
     * @return PpaEncaminhamento
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
     * Set codPeriodicidade
     *
     * @param integer $codPeriodicidade
     * @return PpaEncaminhamento
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
     * @return PpaEncaminhamento
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
     * @return PpaEncaminhamento
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
     * @return PpaEncaminhamento
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
     * Set fkPpaPeriodicidade
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\Periodicidade $fkPpaPeriodicidade
     * @return PpaEncaminhamento
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

    /**
     * OneToOne (owning side)
     * Set PpaPpaPublicacao
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\PpaPublicacao $fkPpaPpaPublicacao
     * @return PpaEncaminhamento
     */
    public function setFkPpaPpaPublicacao(\Urbem\CoreBundle\Entity\Ppa\PpaPublicacao $fkPpaPpaPublicacao)
    {
        $this->codPpa = $fkPpaPpaPublicacao->getCodPpa();
        $this->timestamp = $fkPpaPpaPublicacao->getTimestamp();
        $this->fkPpaPpaPublicacao = $fkPpaPpaPublicacao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPpaPpaPublicacao
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\PpaPublicacao
     */
    public function getFkPpaPpaPublicacao()
    {
        return $this->fkPpaPpaPublicacao;
    }
}
