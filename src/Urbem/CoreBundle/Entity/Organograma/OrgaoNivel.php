<?php
 
namespace Urbem\CoreBundle\Entity\Organograma;

/**
 * OrgaoNivel
 */
class OrgaoNivel
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
    private $codNivel;

    /**
     * PK
     * @var integer
     */
    private $codOrganograma;

    /**
     * @var string
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    private $fkOrganogramaOrgao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Organograma\Nivel
     */
    private $fkOrganogramaNivel;


    /**
     * Set codOrgao
     *
     * @param integer $codOrgao
     * @return OrgaoNivel
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
     * Set codNivel
     *
     * @param integer $codNivel
     * @return OrgaoNivel
     */
    public function setCodNivel($codNivel)
    {
        $this->codNivel = $codNivel;
        return $this;
    }

    /**
     * Get codNivel
     *
     * @return integer
     */
    public function getCodNivel()
    {
        return $this->codNivel;
    }

    /**
     * Set codOrganograma
     *
     * @param integer $codOrganograma
     * @return OrgaoNivel
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
     * Set valor
     *
     * @param string $valor
     * @return OrgaoNivel
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrganogramaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao
     * @return OrgaoNivel
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
     * Set fkOrganogramaNivel
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Nivel $fkOrganogramaNivel
     * @return OrgaoNivel
     */
    public function setFkOrganogramaNivel(\Urbem\CoreBundle\Entity\Organograma\Nivel $fkOrganogramaNivel)
    {
        $this->codNivel = $fkOrganogramaNivel->getCodNivel();
        $this->codOrganograma = $fkOrganogramaNivel->getCodOrganograma();
        $this->fkOrganogramaNivel = $fkOrganogramaNivel;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrganogramaNivel
     *
     * @return \Urbem\CoreBundle\Entity\Organograma\Nivel
     */
    public function getFkOrganogramaNivel()
    {
        return $this->fkOrganogramaNivel;
    }
}
