<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * VwRlRelacaoReceitaView
 */
class VwRlRelacaoReceitaView
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codConta;

    /**
     * @var string
     */
    private $classificacao;

    /**
     * @var string
     */
    private $descricaoReceita;

    /**
     * @var string
     */
    private $codRecurso;

    /**
     * @var string
     */
    private $nomRecurso;

    /**
     * @var integer
     */
    private $codReceita;

    /**
     * @var integer
     */
    private $valorPrevisto;

    /**
     * @var integer
     */
    private $codEntidade;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return VwRlRelacaoReceita
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
     * Set codConta
     *
     * @param integer $codConta
     * @return VwRlRelacaoReceita
     */
    public function setCodConta($codConta = null)
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
     * Set classificacao
     *
     * @param string $classificacao
     * @return VwRlRelacaoReceita
     */
    public function setClassificacao($classificacao = null)
    {
        $this->classificacao = $classificacao;
        return $this;
    }

    /**
     * Get classificacao
     *
     * @return string
     */
    public function getClassificacao()
    {
        return $this->classificacao;
    }

    /**
     * Set descricaoReceita
     *
     * @param string $descricaoReceita
     * @return VwRlRelacaoReceita
     */
    public function setDescricaoReceita($descricaoReceita = null)
    {
        $this->descricaoReceita = $descricaoReceita;
        return $this;
    }

    /**
     * Get descricaoReceita
     *
     * @return string
     */
    public function getDescricaoReceita()
    {
        return $this->descricaoReceita;
    }

    /**
     * Set codRecurso
     *
     * @param string $codRecurso
     * @return VwRlRelacaoReceita
     */
    public function setCodRecurso($codRecurso = null)
    {
        $this->codRecurso = $codRecurso;
        return $this;
    }

    /**
     * Get codRecurso
     *
     * @return string
     */
    public function getCodRecurso()
    {
        return $this->codRecurso;
    }

    /**
     * Set nomRecurso
     *
     * @param string $nomRecurso
     * @return VwRlRelacaoReceita
     */
    public function setNomRecurso($nomRecurso = null)
    {
        $this->nomRecurso = $nomRecurso;
        return $this;
    }

    /**
     * Get nomRecurso
     *
     * @return string
     */
    public function getNomRecurso()
    {
        return $this->nomRecurso;
    }

    /**
     * Set codReceita
     *
     * @param integer $codReceita
     * @return VwRlRelacaoReceita
     */
    public function setCodReceita($codReceita = null)
    {
        $this->codReceita = $codReceita;
        return $this;
    }

    /**
     * Get codReceita
     *
     * @return integer
     */
    public function getCodReceita()
    {
        return $this->codReceita;
    }

    /**
     * Set valorPrevisto
     *
     * @param integer $valorPrevisto
     * @return VwRlRelacaoReceita
     */
    public function setValorPrevisto($valorPrevisto = null)
    {
        $this->valorPrevisto = $valorPrevisto;
        return $this;
    }

    /**
     * Get valorPrevisto
     *
     * @return integer
     */
    public function getValorPrevisto()
    {
        return $this->valorPrevisto;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return VwRlRelacaoReceita
     */
    public function setCodEntidade($codEntidade = null)
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
}
