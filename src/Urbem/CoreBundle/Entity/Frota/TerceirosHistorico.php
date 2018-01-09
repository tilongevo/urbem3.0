<?php
 
namespace Urbem\CoreBundle\Entity\Frota;

/**
 * TerceirosHistorico
 */
class TerceirosHistorico
{
    /**
     * PK
     * @var integer
     */
    private $codVeiculo;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codOrgao;

    /**
     * @var integer
     */
    private $codLocal;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Frota\Terceiros
     */
    private $fkFrotaTerceiros;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    private $fkOrganogramaOrgao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Organograma\Local
     */
    private $fkOrganogramaLocal;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codVeiculo
     *
     * @param integer $codVeiculo
     * @return TerceirosHistorico
     */
    public function setCodVeiculo($codVeiculo)
    {
        $this->codVeiculo = $codVeiculo;
        return $this;
    }

    /**
     * Get codVeiculo
     *
     * @return integer
     */
    public function getCodVeiculo()
    {
        return $this->codVeiculo;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return TerceirosHistorico
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
     * Set codOrgao
     *
     * @param integer $codOrgao
     * @return TerceirosHistorico
     */
    public function setCodOrgao($codOrgao)
    {
        $this->codOrgao = $codOrgao;
        return $this;
    }

    /**
     * Get codOrgao
     *
     * @return integer
     */
    public function getCodOrgao()
    {
        return $this->codOrgao;
    }

    /**
     * Set codLocal
     *
     * @param integer $codLocal
     * @return TerceirosHistorico
     */
    public function setCodLocal($codLocal)
    {
        $this->codLocal = $codLocal;
        return $this;
    }

    /**
     * Get codLocal
     *
     * @return integer
     */
    public function getCodLocal()
    {
        return $this->codLocal;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrganogramaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao
     * @return TerceirosHistorico
     */
    public function setFkOrganogramaOrgao(\Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao)
    {
        $this->codOrgao = $fkOrganogramaOrgao->getCodOrgao();
        $this->fkOrganogramaOrgao = $fkOrganogramaOrgao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrganogramaOrgao
     *
     * @return \Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    public function getFkOrganogramaOrgao()
    {
        return $this->fkOrganogramaOrgao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrganogramaLocal
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Local $fkOrganogramaLocal
     * @return TerceirosHistorico
     */
    public function setFkOrganogramaLocal(\Urbem\CoreBundle\Entity\Organograma\Local $fkOrganogramaLocal)
    {
        $this->codLocal = $fkOrganogramaLocal->getCodLocal();
        $this->fkOrganogramaLocal = $fkOrganogramaLocal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrganogramaLocal
     *
     * @return \Urbem\CoreBundle\Entity\Organograma\Local
     */
    public function getFkOrganogramaLocal()
    {
        return $this->fkOrganogramaLocal;
    }

    /**
     * OneToOne (owning side)
     * Set FrotaTerceiros
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Terceiros $fkFrotaTerceiros
     * @return TerceirosHistorico
     */
    public function setFkFrotaTerceiros(\Urbem\CoreBundle\Entity\Frota\Terceiros $fkFrotaTerceiros)
    {
        $this->codVeiculo = $fkFrotaTerceiros->getCodVeiculo();
        $this->timestamp = $fkFrotaTerceiros->getTimestamp();
        $this->fkFrotaTerceiros = $fkFrotaTerceiros;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFrotaTerceiros
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Terceiros
     */
    public function getFkFrotaTerceiros()
    {
        return $this->fkFrotaTerceiros;
    }
}
