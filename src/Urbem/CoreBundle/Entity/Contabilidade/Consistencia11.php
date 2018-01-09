<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * Consistencia11
 */
class Consistencia11
{
    /**
     * PK
     * @var string
     */
    private $vlSaldoAnterior;

    /**
     * @var string
     */
    private $vlSaldoDebitos;

    /**
     * @var string
     */
    private $vlSaldoCreditos;

    /**
     * @var string
     */
    private $vlSaldoAtual;

    /**
     * @var string
     */
    private $nomConta;

    /**
     * @var integer
     */
    private $codPlano;

    /**
     * @var string
     */
    private $naturezaSaldo;

    /**
     * @var integer
     */
    private $codEntidade;

    /**
     * @var string
     */
    private $naturezaAtual;

    /**
     * @var integer
     */
    private $codClassificacao;


    /**
     * Set vlSaldoAnterior
     *
     * @param string $vlSaldoAnterior
     * @return Consistencia11
     */
    public function setVlSaldoAnterior($vlSaldoAnterior)
    {
        $this->vlSaldoAnterior = $vlSaldoAnterior;
        return $this;
    }

    /**
     * Get vlSaldoAnterior
     *
     * @return string
     */
    public function getVlSaldoAnterior()
    {
        return $this->vlSaldoAnterior;
    }

    /**
     * Set vlSaldoDebitos
     *
     * @param string $vlSaldoDebitos
     * @return Consistencia11
     */
    public function setVlSaldoDebitos($vlSaldoDebitos = null)
    {
        $this->vlSaldoDebitos = $vlSaldoDebitos;
        return $this;
    }

    /**
     * Get vlSaldoDebitos
     *
     * @return string
     */
    public function getVlSaldoDebitos()
    {
        return $this->vlSaldoDebitos;
    }

    /**
     * Set vlSaldoCreditos
     *
     * @param string $vlSaldoCreditos
     * @return Consistencia11
     */
    public function setVlSaldoCreditos($vlSaldoCreditos = null)
    {
        $this->vlSaldoCreditos = $vlSaldoCreditos;
        return $this;
    }

    /**
     * Get vlSaldoCreditos
     *
     * @return string
     */
    public function getVlSaldoCreditos()
    {
        return $this->vlSaldoCreditos;
    }

    /**
     * Set vlSaldoAtual
     *
     * @param string $vlSaldoAtual
     * @return Consistencia11
     */
    public function setVlSaldoAtual($vlSaldoAtual = null)
    {
        $this->vlSaldoAtual = $vlSaldoAtual;
        return $this;
    }

    /**
     * Get vlSaldoAtual
     *
     * @return string
     */
    public function getVlSaldoAtual()
    {
        return $this->vlSaldoAtual;
    }

    /**
     * Set nomConta
     *
     * @param string $nomConta
     * @return Consistencia11
     */
    public function setNomConta($nomConta = null)
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
     * Set codPlano
     *
     * @param integer $codPlano
     * @return Consistencia11
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
     * Set naturezaSaldo
     *
     * @param string $naturezaSaldo
     * @return Consistencia11
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return Consistencia11
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
     * Set naturezaAtual
     *
     * @param string $naturezaAtual
     * @return Consistencia11
     */
    public function setNaturezaAtual($naturezaAtual = null)
    {
        $this->naturezaAtual = $naturezaAtual;
        return $this;
    }

    /**
     * Get naturezaAtual
     *
     * @return string
     */
    public function getNaturezaAtual()
    {
        return $this->naturezaAtual;
    }

    /**
     * Set codClassificacao
     *
     * @param integer $codClassificacao
     * @return Consistencia11
     */
    public function setCodClassificacao($codClassificacao = null)
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
}
