<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * Consistencia10
 */
class Consistencia10
{
    /**
     * PK
     * @var integer
     */
    private $codConta;

    /**
     * @var integer
     */
    private $codEntidade;

    /**
     * @var integer
     */
    private $codPlano;

    /**
     * @var string
     */
    private $substr;

    /**
     * @var string
     */
    private $naturezaSaldo;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $nome;

    /**
     * @var string
     */
    private $codEstrutural;

    /**
     * @var boolean
     */
    private $tipoSaldo;


    /**
     * Set codConta
     *
     * @param integer $codConta
     * @return Consistencia10
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return Consistencia10
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

    /**
     * Set codPlano
     *
     * @param integer $codPlano
     * @return Consistencia10
     */
    public function setCodPlano($codPlano = null)
    {
        $this->codPlano = $codPlano;
        return $this;
    }

    /**
     * Get codPlano
     *
     * @return integer
     */
    public function getCodPlano()
    {
        return $this->codPlano;
    }

    /**
     * Set substr
     *
     * @param string $substr
     * @return Consistencia10
     */
    public function setSubstr($substr = null)
    {
        $this->substr = $substr;
        return $this;
    }

    /**
     * Get substr
     *
     * @return string
     */
    public function getSubstr()
    {
        return $this->substr;
    }

    /**
     * Set naturezaSaldo
     *
     * @param string $naturezaSaldo
     * @return Consistencia10
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return Consistencia10
     */
    public function setExercicio($exercicio = null)
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
     * Set nome
     *
     * @param string $nome
     * @return Consistencia10
     */
    public function setNome($nome = null)
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set codEstrutural
     *
     * @param string $codEstrutural
     * @return Consistencia10
     */
    public function setCodEstrutural($codEstrutural = null)
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
     * Set tipoSaldo
     *
     * @param boolean $tipoSaldo
     * @return Consistencia10
     */
    public function setTipoSaldo($tipoSaldo = null)
    {
        $this->tipoSaldo = $tipoSaldo;
        return $this;
    }

    /**
     * Get tipoSaldo
     *
     * @return boolean
     */
    public function getTipoSaldo()
    {
        return $this->tipoSaldo;
    }
}
