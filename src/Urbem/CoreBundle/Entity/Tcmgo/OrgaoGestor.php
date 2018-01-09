<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * OrgaoGestor
 */
class OrgaoGestor
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $numOrgao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DatePK
     */
    private $dtInicio;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var \DateTime
     */
    private $dtFim;

    /**
     * @var string
     */
    private $cargo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmgo\Orgao
     */
    private $fkTcmgoOrgao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dtInicio = new \Urbem\CoreBundle\Helper\DatePK;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return OrgaoGestor
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set numOrgao
     *
     * @param integer $numOrgao
     * @return OrgaoGestor
     */
    public function setNumOrgao($numOrgao)
    {
        $this->numOrgao = $numOrgao;
        return $this;
    }

    /**
     * Get numOrgao
     *
     * @return integer
     */
    public function getNumOrgao()
    {
        return $this->numOrgao;
    }

    /**
     * Set dtInicio
     *
     * @param \Urbem\CoreBundle\Helper\DatePK $dtInicio
     * @return OrgaoGestor
     */
    public function setDtInicio(\Urbem\CoreBundle\Helper\DatePK $dtInicio)
    {
        $this->dtInicio = $dtInicio;
        return $this;
    }

    /**
     * Get dtInicio
     *
     * @return \Urbem\CoreBundle\Helper\DatePK
     */
    public function getDtInicio()
    {
        return $this->dtInicio;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return OrgaoGestor
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
     * Set dtFim
     *
     * @param \DateTime $dtFim
     * @return OrgaoGestor
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
     * Set cargo
     *
     * @param string $cargo
     * @return OrgaoGestor
     */
    public function setCargo($cargo = null)
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
     * ManyToOne (inverse side)
     * Set fkTcmgoOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\Orgao $fkTcmgoOrgao
     * @return OrgaoGestor
     */
    public function setFkTcmgoOrgao(\Urbem\CoreBundle\Entity\Tcmgo\Orgao $fkTcmgoOrgao)
    {
        $this->numOrgao = $fkTcmgoOrgao->getNumOrgao();
        $this->exercicio = $fkTcmgoOrgao->getExercicio();
        $this->fkTcmgoOrgao = $fkTcmgoOrgao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmgoOrgao
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\Orgao
     */
    public function getFkTcmgoOrgao()
    {
        return $this->fkTcmgoOrgao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return OrgaoGestor
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgm = $fkSwCgm->getNumcgm();
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
}
