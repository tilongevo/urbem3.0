<?php
 
namespace Urbem\CoreBundle\Entity\Tcern;

/**
 * ObraAcompanhamento
 */
class ObraAcompanhamento
{
    /**
     * PK
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $obraContratoId;

    /**
     * @var \DateTime
     */
    private $dtEvento;

    /**
     * @var integer
     */
    private $numcgmResponsavel;

    /**
     * @var integer
     */
    private $codSituacao;

    /**
     * @var string
     */
    private $justificativa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcern\ObraContrato
     */
    private $fkTcernObraContrato;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcern\ObraAcompanhamentoSituacao
     */
    private $fkTcernObraAcompanhamentoSituacao;


    /**
     * Set id
     *
     * @param integer $id
     * @return ObraAcompanhamento
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set obraContratoId
     *
     * @param integer $obraContratoId
     * @return ObraAcompanhamento
     */
    public function setObraContratoId($obraContratoId)
    {
        $this->obraContratoId = $obraContratoId;
        return $this;
    }

    /**
     * Get obraContratoId
     *
     * @return integer
     */
    public function getObraContratoId()
    {
        return $this->obraContratoId;
    }

    /**
     * Set dtEvento
     *
     * @param \DateTime $dtEvento
     * @return ObraAcompanhamento
     */
    public function setDtEvento(\DateTime $dtEvento)
    {
        $this->dtEvento = $dtEvento;
        return $this;
    }

    /**
     * Get dtEvento
     *
     * @return \DateTime
     */
    public function getDtEvento()
    {
        return $this->dtEvento;
    }

    /**
     * Set numcgmResponsavel
     *
     * @param integer $numcgmResponsavel
     * @return ObraAcompanhamento
     */
    public function setNumcgmResponsavel($numcgmResponsavel)
    {
        $this->numcgmResponsavel = $numcgmResponsavel;
        return $this;
    }

    /**
     * Get numcgmResponsavel
     *
     * @return integer
     */
    public function getNumcgmResponsavel()
    {
        return $this->numcgmResponsavel;
    }

    /**
     * Set codSituacao
     *
     * @param integer $codSituacao
     * @return ObraAcompanhamento
     */
    public function setCodSituacao($codSituacao)
    {
        $this->codSituacao = $codSituacao;
        return $this;
    }

    /**
     * Get codSituacao
     *
     * @return integer
     */
    public function getCodSituacao()
    {
        return $this->codSituacao;
    }

    /**
     * Set justificativa
     *
     * @param string $justificativa
     * @return ObraAcompanhamento
     */
    public function setJustificativa($justificativa)
    {
        $this->justificativa = $justificativa;
        return $this;
    }

    /**
     * Get justificativa
     *
     * @return string
     */
    public function getJustificativa()
    {
        return $this->justificativa;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcernObraContrato
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\ObraContrato $fkTcernObraContrato
     * @return ObraAcompanhamento
     */
    public function setFkTcernObraContrato(\Urbem\CoreBundle\Entity\Tcern\ObraContrato $fkTcernObraContrato)
    {
        $this->obraContratoId = $fkTcernObraContrato->getId();
        $this->fkTcernObraContrato = $fkTcernObraContrato;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcernObraContrato
     *
     * @return \Urbem\CoreBundle\Entity\Tcern\ObraContrato
     */
    public function getFkTcernObraContrato()
    {
        return $this->fkTcernObraContrato;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return ObraAcompanhamento
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgmResponsavel = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcernObraAcompanhamentoSituacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\ObraAcompanhamentoSituacao $fkTcernObraAcompanhamentoSituacao
     * @return ObraAcompanhamento
     */
    public function setFkTcernObraAcompanhamentoSituacao(\Urbem\CoreBundle\Entity\Tcern\ObraAcompanhamentoSituacao $fkTcernObraAcompanhamentoSituacao)
    {
        $this->codSituacao = $fkTcernObraAcompanhamentoSituacao->getCodSituacao();
        $this->fkTcernObraAcompanhamentoSituacao = $fkTcernObraAcompanhamentoSituacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcernObraAcompanhamentoSituacao
     *
     * @return \Urbem\CoreBundle\Entity\Tcern\ObraAcompanhamentoSituacao
     */
    public function getFkTcernObraAcompanhamentoSituacao()
    {
        return $this->fkTcernObraAcompanhamentoSituacao;
    }
}
