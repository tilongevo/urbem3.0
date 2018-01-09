<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * BalancoApbaaaaNatureza
 */
class BalancoApbaaaaNatureza
{
    /**
     * PK
     * @var integer
     */
    private $tipoBem;

    /**
     * PK
     * @var integer
     */
    private $codNatureza;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Patrimonio\Natureza
     */
    private $fkPatrimonioNatureza;


    /**
     * Set tipoBem
     *
     * @param integer $tipoBem
     * @return BalancoApbaaaaNatureza
     */
    public function setTipoBem($tipoBem)
    {
        $this->tipoBem = $tipoBem;
        return $this;
    }

    /**
     * Get tipoBem
     *
     * @return integer
     */
    public function getTipoBem()
    {
        return $this->tipoBem;
    }

    /**
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return BalancoApbaaaaNatureza
     */
    public function setCodNatureza($codNatureza)
    {
        $this->codNatureza = $codNatureza;
        return $this;
    }

    /**
     * Get codNatureza
     *
     * @return integer
     */
    public function getCodNatureza()
    {
        return $this->codNatureza;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPatrimonioNatureza
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Natureza $fkPatrimonioNatureza
     * @return BalancoApbaaaaNatureza
     */
    public function setFkPatrimonioNatureza(\Urbem\CoreBundle\Entity\Patrimonio\Natureza $fkPatrimonioNatureza)
    {
        $this->codNatureza = $fkPatrimonioNatureza->getCodNatureza();
        $this->fkPatrimonioNatureza = $fkPatrimonioNatureza;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPatrimonioNatureza
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\Natureza
     */
    public function getFkPatrimonioNatureza()
    {
        return $this->fkPatrimonioNatureza;
    }
}
