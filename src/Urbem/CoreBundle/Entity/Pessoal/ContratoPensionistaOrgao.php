<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ContratoPensionistaOrgao
 */
class ContratoPensionistaOrgao
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * PK
     * @var integer
     */
    private $codOrgao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista
     */
    private $fkPessoalContratoPensionista;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    private $fkOrganogramaOrgao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ContratoPensionistaOrgao
     */
    public function setCodContrato($codContrato)
    {
        $this->codContrato = $codContrato;
        return $this;
    }

    /**
     * Get codContrato
     *
     * @return integer
     */
    public function getCodContrato()
    {
        return $this->codContrato;
    }

    /**
     * Set codOrgao
     *
     * @param integer $codOrgao
     * @return ContratoPensionistaOrgao
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ContratoPensionistaOrgao
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
     * ManyToOne (inverse side)
     * Set fkPessoalContratoPensionista
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista $fkPessoalContratoPensionista
     * @return ContratoPensionistaOrgao
     */
    public function setFkPessoalContratoPensionista(\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista $fkPessoalContratoPensionista)
    {
        $this->codContrato = $fkPessoalContratoPensionista->getCodContrato();
        $this->fkPessoalContratoPensionista = $fkPessoalContratoPensionista;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalContratoPensionista
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista
     */
    public function getFkPessoalContratoPensionista()
    {
        return $this->fkPessoalContratoPensionista;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrganogramaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao
     * @return ContratoPensionistaOrgao
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
}
