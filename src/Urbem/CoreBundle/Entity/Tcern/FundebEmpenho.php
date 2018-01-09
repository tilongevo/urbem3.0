<?php
 
namespace Urbem\CoreBundle\Entity\Tcern;

/**
 * FundebEmpenho
 */
class FundebEmpenho
{
    /**
     * PK
     * @var integer
     */
    private $codEmpenho;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codFundeb;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    private $fkEmpenhoEmpenho;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcern\Fundeb
     */
    private $fkTcernFundeb;


    /**
     * Set codEmpenho
     *
     * @param integer $codEmpenho
     * @return FundebEmpenho
     */
    public function setCodEmpenho($codEmpenho)
    {
        $this->codEmpenho = $codEmpenho;
        return $this;
    }

    /**
     * Get codEmpenho
     *
     * @return integer
     */
    public function getCodEmpenho()
    {
        return $this->codEmpenho;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return FundebEmpenho
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return FundebEmpenho
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set codFundeb
     *
     * @param integer $codFundeb
     * @return FundebEmpenho
     */
    public function setCodFundeb($codFundeb)
    {
        $this->codFundeb = $codFundeb;
        return $this;
    }

    /**
     * Get codFundeb
     *
     * @return integer
     */
    public function getCodFundeb()
    {
        return $this->codFundeb;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho
     * @return FundebEmpenho
     */
    public function setFkEmpenhoEmpenho(\Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho)
    {
        $this->codEmpenho = $fkEmpenhoEmpenho->getCodEmpenho();
        $this->exercicio = $fkEmpenhoEmpenho->getExercicio();
        $this->codEntidade = $fkEmpenhoEmpenho->getCodEntidade();
        $this->fkEmpenhoEmpenho = $fkEmpenhoEmpenho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    public function getFkEmpenhoEmpenho()
    {
        return $this->fkEmpenhoEmpenho;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcernFundeb
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\Fundeb $fkTcernFundeb
     * @return FundebEmpenho
     */
    public function setFkTcernFundeb(\Urbem\CoreBundle\Entity\Tcern\Fundeb $fkTcernFundeb)
    {
        $this->codFundeb = $fkTcernFundeb->getCodFundeb();
        $this->fkTcernFundeb = $fkTcernFundeb;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcernFundeb
     *
     * @return \Urbem\CoreBundle\Entity\Tcern\Fundeb
     */
    public function getFkTcernFundeb()
    {
        return $this->fkTcernFundeb;
    }
}
