<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * ConfiguracaoLoa
 */
class ConfiguracaoLoa
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codNorma;

    /**
     * @var integer
     */
    private $percentualAberturaCredito;

    /**
     * @var integer
     */
    private $percentualContratacaoCredito;

    /**
     * @var integer
     */
    private $percentualContratacaoCreditoReceita;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConfiguracaoLoa
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
     * Set codNorma
     *
     * @param integer $codNorma
     * @return ConfiguracaoLoa
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
     * Set percentualAberturaCredito
     *
     * @param integer $percentualAberturaCredito
     * @return ConfiguracaoLoa
     */
    public function setPercentualAberturaCredito($percentualAberturaCredito = null)
    {
        $this->percentualAberturaCredito = $percentualAberturaCredito;
        return $this;
    }

    /**
     * Get percentualAberturaCredito
     *
     * @return integer
     */
    public function getPercentualAberturaCredito()
    {
        return $this->percentualAberturaCredito;
    }

    /**
     * Set percentualContratacaoCredito
     *
     * @param integer $percentualContratacaoCredito
     * @return ConfiguracaoLoa
     */
    public function setPercentualContratacaoCredito($percentualContratacaoCredito = null)
    {
        $this->percentualContratacaoCredito = $percentualContratacaoCredito;
        return $this;
    }

    /**
     * Get percentualContratacaoCredito
     *
     * @return integer
     */
    public function getPercentualContratacaoCredito()
    {
        return $this->percentualContratacaoCredito;
    }

    /**
     * Set percentualContratacaoCreditoReceita
     *
     * @param integer $percentualContratacaoCreditoReceita
     * @return ConfiguracaoLoa
     */
    public function setPercentualContratacaoCreditoReceita($percentualContratacaoCreditoReceita = null)
    {
        $this->percentualContratacaoCreditoReceita = $percentualContratacaoCreditoReceita;
        return $this;
    }

    /**
     * Get percentualContratacaoCreditoReceita
     *
     * @return integer
     */
    public function getPercentualContratacaoCreditoReceita()
    {
        return $this->percentualContratacaoCreditoReceita;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return ConfiguracaoLoa
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
