<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

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
    private $percentualSuplementacao;

    /**
     * @var integer
     */
    private $percentualCreditoInterna;

    /**
     * @var integer
     */
    private $percentualCreditoAntecipacaoReceita;

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
     * Set percentualSuplementacao
     *
     * @param integer $percentualSuplementacao
     * @return ConfiguracaoLoa
     */
    public function setPercentualSuplementacao($percentualSuplementacao = null)
    {
        $this->percentualSuplementacao = $percentualSuplementacao;
        return $this;
    }

    /**
     * Get percentualSuplementacao
     *
     * @return integer
     */
    public function getPercentualSuplementacao()
    {
        return $this->percentualSuplementacao;
    }

    /**
     * Set percentualCreditoInterna
     *
     * @param integer $percentualCreditoInterna
     * @return ConfiguracaoLoa
     */
    public function setPercentualCreditoInterna($percentualCreditoInterna = null)
    {
        $this->percentualCreditoInterna = $percentualCreditoInterna;
        return $this;
    }

    /**
     * Get percentualCreditoInterna
     *
     * @return integer
     */
    public function getPercentualCreditoInterna()
    {
        return $this->percentualCreditoInterna;
    }

    /**
     * Set percentualCreditoAntecipacaoReceita
     *
     * @param integer $percentualCreditoAntecipacaoReceita
     * @return ConfiguracaoLoa
     */
    public function setPercentualCreditoAntecipacaoReceita($percentualCreditoAntecipacaoReceita = null)
    {
        $this->percentualCreditoAntecipacaoReceita = $percentualCreditoAntecipacaoReceita;
        return $this;
    }

    /**
     * Get percentualCreditoAntecipacaoReceita
     *
     * @return integer
     */
    public function getPercentualCreditoAntecipacaoReceita()
    {
        return $this->percentualCreditoAntecipacaoReceita;
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
