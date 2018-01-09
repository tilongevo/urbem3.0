<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * OrganogramaNivel
 */
class OrganogramaNivel
{
    /**
     * PK
     * @var integer
     */
    private $codOrganograma;

    /**
     * PK
     * @var integer
     */
    private $codNivel;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * @var string
     */
    private $tipo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Organograma\Organograma
     */
    private $fkOrganogramaOrganograma;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Organograma\Nivel
     */
    private $fkOrganogramaNivel;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codOrganograma
     *
     * @param integer $codOrganograma
     * @return OrganogramaNivel
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
     * Set codNivel
     *
     * @param integer $codNivel
     * @return OrganogramaNivel
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return OrganogramaNivel
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
     * Set tipo
     *
     * @param string $tipo
     * @return OrganogramaNivel
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrganogramaOrganograma
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Organograma $fkOrganogramaOrganograma
     * @return OrganogramaNivel
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
     * Set fkOrganogramaNivel
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Nivel $fkOrganogramaNivel
     * @return OrganogramaNivel
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
