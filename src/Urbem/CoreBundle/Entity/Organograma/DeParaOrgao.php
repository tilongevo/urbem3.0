<?php
 
namespace Urbem\CoreBundle\Entity\Organograma;

/**
 * DeParaOrgao
 */
class DeParaOrgao
{
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
     * Set codOrgao
     *
     * @param integer $codOrgao
     * @return DeParaOrgao
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
     * @return DeParaOrgao
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
     * @return DeParaOrgao
     */
    public function setCodOrgaoNew($codOrgaoNew = null)
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
     * ManyToOne (inverse side)
     * Set fkOrganogramaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao
     * @return DeParaOrgao
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
     * @return DeParaOrgao
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
     * @return DeParaOrgao
     */
    public function setFkOrganogramaOrgao1(\Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao1 = null)
    {
        if (!empty($fkOrganogramaOrgao1)) {
            $this->codOrgaoNew = $fkOrganogramaOrgao1->getCodOrgao();
            $this->fkOrganogramaOrgao1 = $fkOrganogramaOrgao1;
        }
        
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

    /**
     * @return string
     */
    public function getcodOrgaoComposto()
    {
        return $this->fkOrganogramaOrgao->getCodigoComposto() . ' - ' . $this->fkOrganogramaOrgao->getFkOrganogramaOrgaoDescricoes()->last();
    }

    /**
     * @return string
     */
    public function getcodOrgaoNewComposto()
    {
        $codigoComposto = $this->fkOrganogramaOrgao1;

        return empty($codigoComposto) ? '' : $this->fkOrganogramaOrgao1->getCodigoComposto() . ' - ' . $this->fkOrganogramaOrgao1->getFkOrganogramaOrgaoDescricoes()->last();
    }
}
