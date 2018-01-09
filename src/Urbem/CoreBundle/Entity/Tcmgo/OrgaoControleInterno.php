<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * OrgaoControleInterno
 */
class OrgaoControleInterno
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
     * @var integer
     */
    private $numcgm;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Tcmgo\Orgao
     */
    private $fkTcmgoOrgao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return OrgaoControleInterno
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
     * @return OrgaoControleInterno
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
     * Set numcgm
     *
     * @param integer $numcgm
     * @return OrgaoControleInterno
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
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return OrgaoControleInterno
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

    /**
     * OneToOne (owning side)
     * Set TcmgoOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\Orgao $fkTcmgoOrgao
     * @return OrgaoControleInterno
     */
    public function setFkTcmgoOrgao(\Urbem\CoreBundle\Entity\Tcmgo\Orgao $fkTcmgoOrgao)
    {
        $this->numOrgao = $fkTcmgoOrgao->getNumOrgao();
        $this->exercicio = $fkTcmgoOrgao->getExercicio();
        $this->fkTcmgoOrgao = $fkTcmgoOrgao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkTcmgoOrgao
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\Orgao
     */
    public function getFkTcmgoOrgao()
    {
        return $this->fkTcmgoOrgao;
    }
}
