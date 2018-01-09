<?php
 
namespace Urbem\CoreBundle\Entity\Stn;

/**
 * DespesaPessoal
 */
class DespesaPessoal
{
    /**
     * PK
     * @var integer
     */
    private $mes;

    /**
     * PK
     * @var string
     */
    private $ano;

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
     * @var integer
     */
    private $valor;

    /**
     * @var integer
     */
    private $valorPessoalAtivo;

    /**
     * @var integer
     */
    private $valorPessoalInativo;

    /**
     * @var integer
     */
    private $valorTerceirizacao;

    /**
     * @var integer
     */
    private $valorIndenizacoes;

    /**
     * @var integer
     */
    private $valorDecisaoJudicial;

    /**
     * @var integer
     */
    private $valorExerciciosAnteriores;

    /**
     * @var integer
     */
    private $valorInativosPensionistas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;


    /**
     * Set mes
     *
     * @param integer $mes
     * @return DespesaPessoal
     */
    public function setMes($mes)
    {
        $this->mes = $mes;
        return $this;
    }

    /**
     * Get mes
     *
     * @return integer
     */
    public function getMes()
    {
        return $this->mes;
    }

    /**
     * Set ano
     *
     * @param string $ano
     * @return DespesaPessoal
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return DespesaPessoal
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
     * @return DespesaPessoal
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
     * Set valor
     *
     * @param integer $valor
     * @return DespesaPessoal
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set valorPessoalAtivo
     *
     * @param integer $valorPessoalAtivo
     * @return DespesaPessoal
     */
    public function setValorPessoalAtivo($valorPessoalAtivo = null)
    {
        $this->valorPessoalAtivo = $valorPessoalAtivo;
        return $this;
    }

    /**
     * Get valorPessoalAtivo
     *
     * @return integer
     */
    public function getValorPessoalAtivo()
    {
        return $this->valorPessoalAtivo;
    }

    /**
     * Set valorPessoalInativo
     *
     * @param integer $valorPessoalInativo
     * @return DespesaPessoal
     */
    public function setValorPessoalInativo($valorPessoalInativo = null)
    {
        $this->valorPessoalInativo = $valorPessoalInativo;
        return $this;
    }

    /**
     * Get valorPessoalInativo
     *
     * @return integer
     */
    public function getValorPessoalInativo()
    {
        return $this->valorPessoalInativo;
    }

    /**
     * Set valorTerceirizacao
     *
     * @param integer $valorTerceirizacao
     * @return DespesaPessoal
     */
    public function setValorTerceirizacao($valorTerceirizacao = null)
    {
        $this->valorTerceirizacao = $valorTerceirizacao;
        return $this;
    }

    /**
     * Get valorTerceirizacao
     *
     * @return integer
     */
    public function getValorTerceirizacao()
    {
        return $this->valorTerceirizacao;
    }

    /**
     * Set valorIndenizacoes
     *
     * @param integer $valorIndenizacoes
     * @return DespesaPessoal
     */
    public function setValorIndenizacoes($valorIndenizacoes = null)
    {
        $this->valorIndenizacoes = $valorIndenizacoes;
        return $this;
    }

    /**
     * Get valorIndenizacoes
     *
     * @return integer
     */
    public function getValorIndenizacoes()
    {
        return $this->valorIndenizacoes;
    }

    /**
     * Set valorDecisaoJudicial
     *
     * @param integer $valorDecisaoJudicial
     * @return DespesaPessoal
     */
    public function setValorDecisaoJudicial($valorDecisaoJudicial = null)
    {
        $this->valorDecisaoJudicial = $valorDecisaoJudicial;
        return $this;
    }

    /**
     * Get valorDecisaoJudicial
     *
     * @return integer
     */
    public function getValorDecisaoJudicial()
    {
        return $this->valorDecisaoJudicial;
    }

    /**
     * Set valorExerciciosAnteriores
     *
     * @param integer $valorExerciciosAnteriores
     * @return DespesaPessoal
     */
    public function setValorExerciciosAnteriores($valorExerciciosAnteriores = null)
    {
        $this->valorExerciciosAnteriores = $valorExerciciosAnteriores;
        return $this;
    }

    /**
     * Get valorExerciciosAnteriores
     *
     * @return integer
     */
    public function getValorExerciciosAnteriores()
    {
        return $this->valorExerciciosAnteriores;
    }

    /**
     * Set valorInativosPensionistas
     *
     * @param integer $valorInativosPensionistas
     * @return DespesaPessoal
     */
    public function setValorInativosPensionistas($valorInativosPensionistas = null)
    {
        $this->valorInativosPensionistas = $valorInativosPensionistas;
        return $this;
    }

    /**
     * Get valorInativosPensionistas
     *
     * @return integer
     */
    public function getValorInativosPensionistas()
    {
        return $this->valorInativosPensionistas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return DespesaPessoal
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
