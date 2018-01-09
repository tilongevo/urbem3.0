<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * FundamentacaoProrrogacao
 */
class FundamentacaoProrrogacao
{
    /**
     * PK
     * @var integer
     */
    private $codDesoneracao;

    /**
     * PK
     * @var integer
     */
    private $codNorma;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao
     */
    private $fkArrecadacaoDesoneracao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;


    /**
     * Set codDesoneracao
     *
     * @param integer $codDesoneracao
     * @return FundamentacaoProrrogacao
     */
    public function setCodDesoneracao($codDesoneracao)
    {
        $this->codDesoneracao = $codDesoneracao;
        return $this;
    }

    /**
     * Get codDesoneracao
     *
     * @return integer
     */
    public function getCodDesoneracao()
    {
        return $this->codDesoneracao;
    }

    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return FundamentacaoProrrogacao
     */
    public function setCodNorma($codNorma)
    {
        $this->codNorma = $codNorma;
        return $this;
    }

    /**
     * Get codNorma
     *
     * @return integer
     */
    public function getCodNorma()
    {
        return $this->codNorma;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoDesoneracao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao $fkArrecadacaoDesoneracao
     * @return FundamentacaoProrrogacao
     */
    public function setFkArrecadacaoDesoneracao(\Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao $fkArrecadacaoDesoneracao)
    {
        $this->codDesoneracao = $fkArrecadacaoDesoneracao->getCodDesoneracao();
        $this->fkArrecadacaoDesoneracao = $fkArrecadacaoDesoneracao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoDesoneracao
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao
     */
    public function getFkArrecadacaoDesoneracao()
    {
        return $this->fkArrecadacaoDesoneracao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return FundamentacaoProrrogacao
     */
    public function setFkNormasNorma(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        $this->codNorma = $fkNormasNorma->getCodNorma();
        $this->fkNormasNorma = $fkNormasNorma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNorma()
    {
        return $this->fkNormasNorma;
    }
}
