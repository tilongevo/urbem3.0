<?php
 
namespace Urbem\CoreBundle\Entity\Tcern;

/**
 * UnidadeGestoraResponsavel
 */
class UnidadeGestoraResponsavel
{
    /**
     * PK
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $idUnidade;

    /**
     * @var integer
     */
    private $cgmResponsavel;

    /**
     * @var string
     */
    private $cargo;

    /**
     * @var integer
     */
    private $codFuncao;

    /**
     * @var \DateTime
     */
    private $dtInicio;

    /**
     * @var \DateTime
     */
    private $dtFim;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcern\UnidadeGestora
     */
    private $fkTcernUnidadeGestora;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcern\FuncaoGestor
     */
    private $fkTcernFuncaoGestor;


    /**
     * Set id
     *
     * @param integer $id
     * @return UnidadeGestoraResponsavel
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
     * Set idUnidade
     *
     * @param integer $idUnidade
     * @return UnidadeGestoraResponsavel
     */
    public function setIdUnidade($idUnidade)
    {
        $this->idUnidade = $idUnidade;
        return $this;
    }

    /**
     * Get idUnidade
     *
     * @return integer
     */
    public function getIdUnidade()
    {
        return $this->idUnidade;
    }

    /**
     * Set cgmResponsavel
     *
     * @param integer $cgmResponsavel
     * @return UnidadeGestoraResponsavel
     */
    public function setCgmResponsavel($cgmResponsavel)
    {
        $this->cgmResponsavel = $cgmResponsavel;
        return $this;
    }

    /**
     * Get cgmResponsavel
     *
     * @return integer
     */
    public function getCgmResponsavel()
    {
        return $this->cgmResponsavel;
    }

    /**
     * Set cargo
     *
     * @param string $cargo
     * @return UnidadeGestoraResponsavel
     */
    public function setCargo($cargo)
    {
        $this->cargo = $cargo;
        return $this;
    }

    /**
     * Get cargo
     *
     * @return string
     */
    public function getCargo()
    {
        return $this->cargo;
    }

    /**
     * Set codFuncao
     *
     * @param integer $codFuncao
     * @return UnidadeGestoraResponsavel
     */
    public function setCodFuncao($codFuncao)
    {
        $this->codFuncao = $codFuncao;
        return $this;
    }

    /**
     * Get codFuncao
     *
     * @return integer
     */
    public function getCodFuncao()
    {
        return $this->codFuncao;
    }

    /**
     * Set dtInicio
     *
     * @param \DateTime $dtInicio
     * @return UnidadeGestoraResponsavel
     */
    public function setDtInicio(\DateTime $dtInicio)
    {
        $this->dtInicio = $dtInicio;
        return $this;
    }

    /**
     * Get dtInicio
     *
     * @return \DateTime
     */
    public function getDtInicio()
    {
        return $this->dtInicio;
    }

    /**
     * Set dtFim
     *
     * @param \DateTime $dtFim
     * @return UnidadeGestoraResponsavel
     */
    public function setDtFim(\DateTime $dtFim)
    {
        $this->dtFim = $dtFim;
        return $this;
    }

    /**
     * Get dtFim
     *
     * @return \DateTime
     */
    public function getDtFim()
    {
        return $this->dtFim;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcernUnidadeGestora
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\UnidadeGestora $fkTcernUnidadeGestora
     * @return UnidadeGestoraResponsavel
     */
    public function setFkTcernUnidadeGestora(\Urbem\CoreBundle\Entity\Tcern\UnidadeGestora $fkTcernUnidadeGestora)
    {
        $this->idUnidade = $fkTcernUnidadeGestora->getId();
        $this->fkTcernUnidadeGestora = $fkTcernUnidadeGestora;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcernUnidadeGestora
     *
     * @return \Urbem\CoreBundle\Entity\Tcern\UnidadeGestora
     */
    public function getFkTcernUnidadeGestora()
    {
        return $this->fkTcernUnidadeGestora;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return UnidadeGestoraResponsavel
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->cgmResponsavel = $fkSwCgm->getNumcgm();
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
     * Set fkTcernFuncaoGestor
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\FuncaoGestor $fkTcernFuncaoGestor
     * @return UnidadeGestoraResponsavel
     */
    public function setFkTcernFuncaoGestor(\Urbem\CoreBundle\Entity\Tcern\FuncaoGestor $fkTcernFuncaoGestor)
    {
        $this->codFuncao = $fkTcernFuncaoGestor->getCodFuncao();
        $this->fkTcernFuncaoGestor = $fkTcernFuncaoGestor;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcernFuncaoGestor
     *
     * @return \Urbem\CoreBundle\Entity\Tcern\FuncaoGestor
     */
    public function getFkTcernFuncaoGestor()
    {
        return $this->fkTcernFuncaoGestor;
    }
}
