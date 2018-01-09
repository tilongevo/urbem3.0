<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * NotaFiscalFornecedorOrdem
 */
class NotaFiscalFornecedorOrdem
{
    /**
     * PK
     * @var integer
     */
    private $cgmFornecedor;

    /**
     * PK
     * @var integer
     */
    private $codNota;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codEntidade;

    /**
     * @var integer
     */
    private $codOrdem;

    /**
     * @var string
     */
    private $tipo;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Compras\NotaFiscalFornecedor
     */
    private $fkComprasNotaFiscalFornecedor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\Ordem
     */
    private $fkComprasOrdem;


    /**
     * Set cgmFornecedor
     *
     * @param integer $cgmFornecedor
     * @return NotaFiscalFornecedorOrdem
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
     * Set codNota
     *
     * @param integer $codNota
     * @return NotaFiscalFornecedorOrdem
     */
    public function setCodNota($codNota)
    {
        $this->codNota = $codNota;
        return $this;
    }

    /**
     * Get codNota
     *
     * @return integer
     */
    public function getCodNota()
    {
        return $this->codNota;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return NotaFiscalFornecedorOrdem
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
     * @return NotaFiscalFornecedorOrdem
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
     * Set codOrdem
     *
     * @param integer $codOrdem
     * @return NotaFiscalFornecedorOrdem
     */
    public function setCodOrdem($codOrdem)
    {
        $this->codOrdem = $codOrdem;
        return $this;
    }

    /**
     * Get codOrdem
     *
     * @return integer
     */
    public function getCodOrdem()
    {
        return $this->codOrdem;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return NotaFiscalFornecedorOrdem
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasOrdem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Ordem $fkComprasOrdem
     * @return NotaFiscalFornecedorOrdem
     */
    public function setFkComprasOrdem(\Urbem\CoreBundle\Entity\Compras\Ordem $fkComprasOrdem)
    {
        $this->exercicio = $fkComprasOrdem->getExercicio();
        $this->codEntidade = $fkComprasOrdem->getCodEntidade();
        $this->codOrdem = $fkComprasOrdem->getCodOrdem();
        $this->tipo = $fkComprasOrdem->getTipo();
        $this->fkComprasOrdem = $fkComprasOrdem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasOrdem
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Ordem
     */
    public function getFkComprasOrdem()
    {
        return $this->fkComprasOrdem;
    }

    /**
     * OneToOne (owning side)
     * Set ComprasNotaFiscalFornecedor
     *
     * @param \Urbem\CoreBundle\Entity\Compras\NotaFiscalFornecedor $fkComprasNotaFiscalFornecedor
     * @return NotaFiscalFornecedorOrdem
     */
    public function setFkComprasNotaFiscalFornecedor(\Urbem\CoreBundle\Entity\Compras\NotaFiscalFornecedor $fkComprasNotaFiscalFornecedor)
    {
        $this->cgmFornecedor = $fkComprasNotaFiscalFornecedor->getCgmFornecedor();
        $this->codNota = $fkComprasNotaFiscalFornecedor->getCodNota();
        $this->fkComprasNotaFiscalFornecedor = $fkComprasNotaFiscalFornecedor;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkComprasNotaFiscalFornecedor
     *
     * @return \Urbem\CoreBundle\Entity\Compras\NotaFiscalFornecedor
     */
    public function getFkComprasNotaFiscalFornecedor()
    {
        return $this->fkComprasNotaFiscalFornecedor;
    }
}
