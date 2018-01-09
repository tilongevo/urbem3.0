<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * FornecedorConta
 */
class FornecedorConta
{
    /**
     * PK
     * @var string
     */
    private $numConta;

    /**
     * PK
     * @var integer
     */
    private $codBanco;

    /**
     * PK
     * @var integer
     */
    private $codAgencia;

    /**
     * PK
     * @var integer
     */
    private $cgmFornecedor;

    /**
     * @var boolean
     */
    private $padrao = false;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\Agencia
     */
    private $fkMonetarioAgencia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\Fornecedor
     */
    private $fkComprasFornecedor;


    /**
     * Set numConta
     *
     * @param string $numConta
     * @return FornecedorConta
     */
    public function setNumConta($numConta)
    {
        $this->numConta = $numConta;
        return $this;
    }

    /**
     * Get numConta
     *
     * @return string
     */
    public function getNumConta()
    {
        return $this->numConta;
    }

    /**
     * Set codBanco
     *
     * @param integer $codBanco
     * @return FornecedorConta
     */
    public function setCodBanco($codBanco)
    {
        $this->codBanco = $codBanco;
        return $this;
    }

    /**
     * Get codBanco
     *
     * @return integer
     */
    public function getCodBanco()
    {
        return $this->codBanco;
    }

    /**
     * Set codAgencia
     *
     * @param integer $codAgencia
     * @return FornecedorConta
     */
    public function setCodAgencia($codAgencia)
    {
        $this->codAgencia = $codAgencia;
        return $this;
    }

    /**
     * Get codAgencia
     *
     * @return integer
     */
    public function getCodAgencia()
    {
        return $this->codAgencia;
    }

    /**
     * Set cgmFornecedor
     *
     * @param integer $cgmFornecedor
     * @return FornecedorConta
     */
    public function setCgmFornecedor($cgmFornecedor)
    {
        $this->cgmFornecedor = $cgmFornecedor;
        return $this;
    }

    /**
     * Get cgmFornecedor
     *
     * @return integer
     */
    public function getCgmFornecedor()
    {
        return $this->cgmFornecedor;
    }

    /**
     * Set padrao
     *
     * @param boolean $padrao
     * @return FornecedorConta
     */
    public function setPadrao($padrao)
    {
        $this->padrao = $padrao;
        return $this;
    }

    /**
     * Get padrao
     *
     * @return boolean
     */
    public function getPadrao()
    {
        return $this->padrao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioAgencia
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Agencia $fkMonetarioAgencia
     * @return FornecedorConta
     */
    public function setFkMonetarioAgencia(\Urbem\CoreBundle\Entity\Monetario\Agencia $fkMonetarioAgencia)
    {
        $this->codBanco = $fkMonetarioAgencia->getCodBanco();
        $this->codAgencia = $fkMonetarioAgencia->getCodAgencia();
        $this->fkMonetarioAgencia = $fkMonetarioAgencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioAgencia
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\Agencia
     */
    public function getFkMonetarioAgencia()
    {
        return $this->fkMonetarioAgencia;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasFornecedor
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Fornecedor $fkComprasFornecedor
     * @return FornecedorConta
     */
    public function setFkComprasFornecedor(\Urbem\CoreBundle\Entity\Compras\Fornecedor $fkComprasFornecedor)
    {
        $this->cgmFornecedor = $fkComprasFornecedor->getCgmFornecedor();
        $this->fkComprasFornecedor = $fkComprasFornecedor;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasFornecedor
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Fornecedor
     */
    public function getFkComprasFornecedor()
    {
        return $this->fkComprasFornecedor;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if($this->fkMonetarioAgencia){
            return (string) html_entity_decode("Conta: " . $this->getNumConta(). ", Ag&ecirc;ncia: ". $this->getFkMonetarioAgencia()->getNumAgencia() . " - " . $this->getFkMonetarioAgencia()->getNomAgencia());
        }
        return "Conta";

    }
}
