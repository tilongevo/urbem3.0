<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * CorrigePlanoConta
 */
class CorrigePlanoConta
{
    /**
     * PK
     * @var integer
     */
    private $codConta;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $nomConta;

    /**
     * @var integer
     */
    private $codClassificacao;

    /**
     * @var integer
     */
    private $codSistema;

    /**
     * @var string
     */
    private $codEstrutural;

    /**
     * @var string
     */
    private $escrituracao;

    /**
     * @var string
     */
    private $naturezaSaldo;

    /**
     * @var string
     */
    private $indicadorSuperavit;

    /**
     * @var string
     */
    private $funcao;


    /**
     * Set codConta
     *
     * @param integer $codConta
     * @return CorrigePlanoConta
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return CorrigePlanoConta
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
     * Set nomConta
     *
     * @param string $nomConta
     * @return CorrigePlanoConta
     */
    public function setNomConta($nomConta)
    {
        $this->nomConta = $nomConta;
        return $this;
    }

    /**
     * Get nomConta
     *
     * @return string
     */
    public function getNomConta()
    {
        return $this->nomConta;
    }

    /**
     * Set codClassificacao
     *
     * @param integer $codClassificacao
     * @return CorrigePlanoConta
     */
    public function setCodClassificacao($codClassificacao)
    {
        $this->codClassificacao = $codClassificacao;
        return $this;
    }

    /**
     * Get codClassificacao
     *
     * @return integer
     */
    public function getCodClassificacao()
    {
        return $this->codClassificacao;
    }

    /**
     * Set codSistema
     *
     * @param integer $codSistema
     * @return CorrigePlanoConta
     */
    public function setCodSistema($codSistema)
    {
        $this->codSistema = $codSistema;
        return $this;
    }

    /**
     * Get codSistema
     *
     * @return integer
     */
    public function getCodSistema()
    {
        return $this->codSistema;
    }

    /**
     * Set codEstrutural
     *
     * @param string $codEstrutural
     * @return CorrigePlanoConta
     */
    public function setCodEstrutural($codEstrutural)
    {
        $this->codEstrutural = $codEstrutural;
        return $this;
    }

    /**
     * Get codEstrutural
     *
     * @return string
     */
    public function getCodEstrutural()
    {
        return $this->codEstrutural;
    }

    /**
     * Set escrituracao
     *
     * @param string $escrituracao
     * @return CorrigePlanoConta
     */
    public function setEscrituracao($escrituracao = null)
    {
        $this->escrituracao = $escrituracao;
        return $this;
    }

    /**
     * Get escrituracao
     *
     * @return string
     */
    public function getEscrituracao()
    {
        return $this->escrituracao;
    }

    /**
     * Set naturezaSaldo
     *
     * @param string $naturezaSaldo
     * @return CorrigePlanoConta
     */
    public function setNaturezaSaldo($naturezaSaldo = null)
    {
        $this->naturezaSaldo = $naturezaSaldo;
        return $this;
    }

    /**
     * Get naturezaSaldo
     *
     * @return string
     */
    public function getNaturezaSaldo()
    {
        return $this->naturezaSaldo;
    }

    /**
     * Set indicadorSuperavit
     *
     * @param string $indicadorSuperavit
     * @return CorrigePlanoConta
     */
    public function setIndicadorSuperavit($indicadorSuperavit = null)
    {
        $this->indicadorSuperavit = $indicadorSuperavit;
        return $this;
    }

    /**
     * Get indicadorSuperavit
     *
     * @return string
     */
    public function getIndicadorSuperavit()
    {
        return $this->indicadorSuperavit;
    }

    /**
     * Set funcao
     *
     * @param string $funcao
     * @return CorrigePlanoConta
     */
    public function setFuncao($funcao = null)
    {
        $this->funcao = $funcao;
        return $this;
    }

    /**
     * Get funcao
     *
     * @return string
     */
    public function getFuncao()
    {
        return $this->funcao;
    }
}
