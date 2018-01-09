<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * PatrimonioBemObra
 */
class PatrimonioBemObra
{
    /**
     * PK
     * @var integer
     */
    private $codBem;

    /**
     * PK
     * @var integer
     */
    private $codObra;

    /**
     * PK
     * @var integer
     */
    private $anoObra;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Patrimonio\Bem
     */
    private $fkPatrimonioBem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmgo\Obra
     */
    private $fkTcmgoObra;


    /**
     * Set codBem
     *
     * @param integer $codBem
     * @return PatrimonioBemObra
     */
    public function setCodBem($codBem)
    {
        $this->codBem = $codBem;
        return $this;
    }

    /**
     * Get codBem
     *
     * @return integer
     */
    public function getCodBem()
    {
        return $this->codBem;
    }

    /**
     * Set codObra
     *
     * @param integer $codObra
     * @return PatrimonioBemObra
     */
    public function setCodObra($codObra)
    {
        $this->codObra = $codObra;
        return $this;
    }

    /**
     * Get codObra
     *
     * @return integer
     */
    public function getCodObra()
    {
        return $this->codObra;
    }

    /**
     * Set anoObra
     *
     * @param integer $anoObra
     * @return PatrimonioBemObra
     */
    public function setAnoObra($anoObra)
    {
        $this->anoObra = $anoObra;
        return $this;
    }

    /**
     * Get anoObra
     *
     * @return integer
     */
    public function getAnoObra()
    {
        return $this->anoObra;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPatrimonioBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Bem $fkPatrimonioBem
     * @return PatrimonioBemObra
     */
    public function setFkPatrimonioBem(\Urbem\CoreBundle\Entity\Patrimonio\Bem $fkPatrimonioBem)
    {
        $this->codBem = $fkPatrimonioBem->getCodBem();
        $this->fkPatrimonioBem = $fkPatrimonioBem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPatrimonioBem
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\Bem
     */
    public function getFkPatrimonioBem()
    {
        return $this->fkPatrimonioBem;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcmgoObra
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\Obra $fkTcmgoObra
     * @return PatrimonioBemObra
     */
    public function setFkTcmgoObra(\Urbem\CoreBundle\Entity\Tcmgo\Obra $fkTcmgoObra)
    {
        $this->codObra = $fkTcmgoObra->getCodObra();
        $this->anoObra = $fkTcmgoObra->getAnoObra();
        $this->fkTcmgoObra = $fkTcmgoObra;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmgoObra
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\Obra
     */
    public function getFkTcmgoObra()
    {
        return $this->fkTcmgoObra;
    }
}
