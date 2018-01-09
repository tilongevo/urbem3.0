<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * CalculoCgm
 */
class CalculoCgm
{
    /**
     * PK
     * @var integer
     */
    private $codCalculo;

    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Calculo
     */
    private $fkArrecadacaoCalculo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;


    /**
     * Set codCalculo
     *
     * @param integer $codCalculo
     * @return CalculoCgm
     */
    public function setCodCalculo($codCalculo)
    {
        $this->codCalculo = $codCalculo;
        return $this;
    }

    /**
     * Get codCalculo
     *
     * @return integer
     */
    public function getCodCalculo()
    {
        return $this->codCalculo;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return CalculoCgm
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
     * Set fkArrecadacaoCalculo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Calculo $fkArrecadacaoCalculo
     * @return CalculoCgm
     */
    public function setFkArrecadacaoCalculo(\Urbem\CoreBundle\Entity\Arrecadacao\Calculo $fkArrecadacaoCalculo)
    {
        $this->codCalculo = $fkArrecadacaoCalculo->getCodCalculo();
        $this->fkArrecadacaoCalculo = $fkArrecadacaoCalculo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoCalculo
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Calculo
     */
    public function getFkArrecadacaoCalculo()
    {
        return $this->fkArrecadacaoCalculo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return CalculoCgm
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
