<?php
 
namespace Urbem\CoreBundle\Entity\Organograma;

/**
 * OrgaoCgm
 */
class OrgaoCgm
{
    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * PK
     * @var integer
     */
    private $codOrgao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    private $fkOrganogramaOrgao;


    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return OrgaoCgm
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
     * Set codOrgao
     *
     * @param integer $codOrgao
     * @return OrgaoCgm
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
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return OrgaoCgm
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
     * ManyToOne (inverse side)
     * Set fkOrganogramaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao
     * @return OrgaoCgm
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
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getFkSwCgm();
    }
}
