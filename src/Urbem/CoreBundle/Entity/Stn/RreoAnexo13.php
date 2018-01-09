<?php
 
namespace Urbem\CoreBundle\Entity\Stn;

/**
 * RreoAnexo13
 */
class RreoAnexo13
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $ano;

    /**
     * @var integer
     */
    private $vlReceitaPrevidenciaria;

    /**
     * @var integer
     */
    private $vlDespesaPrevidenciaria;

    /**
     * @var integer
     */
    private $vlSaldoFinanceiro;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return RreoAnexo13
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return RreoAnexo13
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
     * Set ano
     *
     * @param string $ano
     * @return RreoAnexo13
     */
    public function setAno($ano)
    {
        $this->ano = $ano;
        return $this;
    }

    /**
     * Get ano
     *
     * @return string
     */
    public function getAno()
    {
        return $this->ano;
    }

    /**
     * Set vlReceitaPrevidenciaria
     *
     * @param integer $vlReceitaPrevidenciaria
     * @return RreoAnexo13
     */
    public function setVlReceitaPrevidenciaria($vlReceitaPrevidenciaria)
    {
        $this->vlReceitaPrevidenciaria = $vlReceitaPrevidenciaria;
        return $this;
    }

    /**
     * Get vlReceitaPrevidenciaria
     *
     * @return integer
     */
    public function getVlReceitaPrevidenciaria()
    {
        return $this->vlReceitaPrevidenciaria;
    }

    /**
     * Set vlDespesaPrevidenciaria
     *
     * @param integer $vlDespesaPrevidenciaria
     * @return RreoAnexo13
     */
    public function setVlDespesaPrevidenciaria($vlDespesaPrevidenciaria)
    {
        $this->vlDespesaPrevidenciaria = $vlDespesaPrevidenciaria;
        return $this;
    }

    /**
     * Get vlDespesaPrevidenciaria
     *
     * @return integer
     */
    public function getVlDespesaPrevidenciaria()
    {
        return $this->vlDespesaPrevidenciaria;
    }

    /**
     * Set vlSaldoFinanceiro
     *
     * @param integer $vlSaldoFinanceiro
     * @return RreoAnexo13
     */
    public function setVlSaldoFinanceiro($vlSaldoFinanceiro)
    {
        $this->vlSaldoFinanceiro = $vlSaldoFinanceiro;
        return $this;
    }

    /**
     * Get vlSaldoFinanceiro
     *
     * @return integer
     */
    public function getVlSaldoFinanceiro()
    {
        return $this->vlSaldoFinanceiro;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return RreoAnexo13
     */
    public function setFkOrcamentoEntidade(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
        $this->exercicio = $fkOrcamentoEntidade->getExercicio();
        $this->codEntidade = $fkOrcamentoEntidade->getCodEntidade();
        $this->fkOrcamentoEntidade = $fkOrcamentoEntidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoEntidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    public function getFkOrcamentoEntidade()
    {
        return $this->fkOrcamentoEntidade;
    }
}
