<?php
 
namespace Urbem\CoreBundle\Entity\Organograma;

/**
 * DeParaOrgaoHistorico
 */
class DeParaOrgaoHistorico
{
    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codOrgao;

    /**
     * PK
     * @var integer
     */
    private $codOrganograma;

    /**
     * @var integer
     */
    private $codOrgaoNew;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    private $fkOrganogramaOrgao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Organograma\Organograma
     */
    private $fkOrganogramaOrganograma;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    private $fkOrganogramaOrgao1;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return DeParaOrgaoHistorico
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimePK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set codOrgao
     *
     * @param integer $codOrgao
     * @return DeParaOrgaoHistorico
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
     * Set codOrganograma
     *
     * @param integer $codOrganograma
     * @return DeParaOrgaoHistorico
     */
    public function setCodOrganograma($codOrganograma)
    {
        $this->codOrganograma = $codOrganograma;
        return $this;
    }

    /**
     * Get codOrganograma
     *
     * @return integer
     */
    public function getCodOrganograma()
    {
        return $this->codOrganograma;
    }

    /**
     * Set codOrgaoNew
     *
     * @param integer $codOrgaoNew
     * @return DeParaOrgaoHistorico
     */
    public function setCodOrgaoNew($codOrgaoNew)
    {
        $this->codOrgaoNew = $codOrgaoNew;
        return $this;
    }

    /**
     * Get codOrgaoNew
     *
     * @return integer
     */
    public function getCodOrgaoNew()
    {
        return $this->codOrgaoNew;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return DeParaOrgaoHistorico
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
     * Set fkOrganogramaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao
     * @return DeParaOrgaoHistorico
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
     * Set fkOrganogramaOrganograma
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Organograma $fkOrganogramaOrganograma
     * @return DeParaOrgaoHistorico
     */
    public function setFkOrganogramaOrganograma(\Urbem\CoreBundle\Entity\Organograma\Organograma $fkOrganogramaOrganograma)
    {
        $this->codOrganograma = $fkOrganogramaOrganograma->getCodOrganograma();
        $this->fkOrganogramaOrganograma = $fkOrganogramaOrganograma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrganogramaOrganograma
     *
     * @return \Urbem\CoreBundle\Entity\Organograma\Organograma
     */
    public function getFkOrganogramaOrganograma()
    {
        return $this->fkOrganogramaOrganograma;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrganogramaOrgao1
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao1
     * @return DeParaOrgaoHistorico
     */
    public function setFkOrganogramaOrgao1(\Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao1)
    {
        $this->codOrgaoNew = $fkOrganogramaOrgao1->getCodOrgao();
        $this->fkOrganogramaOrgao1 = $fkOrganogramaOrgao1;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrganogramaOrgao1
     *
     * @return \Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    public function getFkOrganogramaOrgao1()
    {
        return $this->fkOrganogramaOrgao1;
    }
}
