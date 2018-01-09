<?php
 
namespace Urbem\CoreBundle\Entity\Cgm;

/**
 * ContaCgm
 */
class ContaCgm
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
    private $codBanco;

    /**
     * PK
     * @var integer
     */
    private $codAgencia;

    /**
     * PK
     * @var integer
     */
    private $codConta;

    /**
     * @var boolean
     */
    private $titular;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cgm\Conta
     */
    private $fkCgmConta;


    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return ContaCgm
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
     * Set codBanco
     *
     * @param integer $codBanco
     * @return ContaCgm
     */
    public function setCodBanco($codBanco)
    {
        $this->codBanco = $codBanco;
        return $this;
    }

    /**
     * Get codBanco
     *
     * @return integer
     */
    public function getCodBanco()
    {
        return $this->codBanco;
    }

    /**
     * Set codAgencia
     *
     * @param integer $codAgencia
     * @return ContaCgm
     */
    public function setCodAgencia($codAgencia)
    {
        $this->codAgencia = $codAgencia;
        return $this;
    }

    /**
     * Get codAgencia
     *
     * @return integer
     */
    public function getCodAgencia()
    {
        return $this->codAgencia;
    }

    /**
     * Set codConta
     *
     * @param integer $codConta
     * @return ContaCgm
     */
    public function setCodConta($codConta)
    {
        $this->codConta = $codConta;
        return $this;
    }

    /**
     * Get codConta
     *
     * @return integer
     */
    public function getCodConta()
    {
        return $this->codConta;
    }

    /**
     * Set titular
     *
     * @param boolean $titular
     * @return ContaCgm
     */
    public function setTitular($titular)
    {
        $this->titular = $titular;
        return $this;
    }

    /**
     * Get titular
     *
     * @return boolean
     */
    public function getTitular()
    {
        return $this->titular;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return ContaCgm
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
     * Set fkCgmConta
     *
     * @param \Urbem\CoreBundle\Entity\Cgm\Conta $fkCgmConta
     * @return ContaCgm
     */
    public function setFkCgmConta(\Urbem\CoreBundle\Entity\Cgm\Conta $fkCgmConta)
    {
        $this->codConta = $fkCgmConta->getCodConta();
        $this->codAgencia = $fkCgmConta->getCodAgencia();
        $this->codBanco = $fkCgmConta->getCodBanco();
        $this->fkCgmConta = $fkCgmConta;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCgmConta
     *
     * @return \Urbem\CoreBundle\Entity\Cgm\Conta
     */
    public function getFkCgmConta()
    {
        return $this->fkCgmConta;
    }
}
