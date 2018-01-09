<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * NotaFiscalFornecedor
 */
class NotaFiscalFornecedor
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
    private $tipoNatureza;

    /**
     * @var integer
     */
    private $codNatureza;

    /**
     * @var integer
     */
    private $numLancamento;

    /**
     * @var string
     */
    private $exercicioLancamento;

    /**
     * @var string
     */
    private $numSerie;

    /**
     * @var integer
     */
    private $numNota;

    /**
     * @var \DateTime
     */
    private $dtNota;

    /**
     * @var string
     */
    private $observacao;

    /**
     * @var string
     */
    private $tipo = 'C';

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Compras\NotaFiscalFornecedorOrdem
     */
    private $fkComprasNotaFiscalFornecedorOrdem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\Fornecedor
     */
    private $fkComprasFornecedor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\NaturezaLancamento
     */
    private $fkAlmoxarifadoNaturezaLancamento;


    /**
     * Set cgmFornecedor
     *
     * @param integer $cgmFornecedor
     * @return NotaFiscalFornecedor
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
     * @return NotaFiscalFornecedor
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
     * Set tipoNatureza
     *
     * @param string $tipoNatureza
     * @return NotaFiscalFornecedor
     */
    public function setTipoNatureza($tipoNatureza)
    {
        $this->tipoNatureza = $tipoNatureza;
        return $this;
    }

    /**
     * Get tipoNatureza
     *
     * @return string
     */
    public function getTipoNatureza()
    {
        return $this->tipoNatureza;
    }

    /**
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return NotaFiscalFornecedor
     */
    public function setCodNatureza($codNatureza)
    {
        $this->codNatureza = $codNatureza;
        return $this;
    }

    /**
     * Get codNatureza
     *
     * @return integer
     */
    public function getCodNatureza()
    {
        return $this->codNatureza;
    }

    /**
     * Set numLancamento
     *
     * @param integer $numLancamento
     * @return NotaFiscalFornecedor
     */
    public function setNumLancamento($numLancamento)
    {
        $this->numLancamento = $numLancamento;
        return $this;
    }

    /**
     * Get numLancamento
     *
     * @return integer
     */
    public function getNumLancamento()
    {
        return $this->numLancamento;
    }

    /**
     * Set exercicioLancamento
     *
     * @param string $exercicioLancamento
     * @return NotaFiscalFornecedor
     */
    public function setExercicioLancamento($exercicioLancamento)
    {
        $this->exercicioLancamento = $exercicioLancamento;
        return $this;
    }

    /**
     * Get exercicioLancamento
     *
     * @return string
     */
    public function getExercicioLancamento()
    {
        return $this->exercicioLancamento;
    }

    /**
     * Set numSerie
     *
     * @param string $numSerie
     * @return NotaFiscalFornecedor
     */
    public function setNumSerie($numSerie)
    {
        $this->numSerie = $numSerie;
        return $this;
    }

    /**
     * Get numSerie
     *
     * @return string
     */
    public function getNumSerie()
    {
        return $this->numSerie;
    }

    /**
     * Set numNota
     *
     * @param integer $numNota
     * @return NotaFiscalFornecedor
     */
    public function setNumNota($numNota)
    {
        $this->numNota = $numNota;
        return $this;
    }

    /**
     * Get numNota
     *
     * @return integer
     */
    public function getNumNota()
    {
        return $this->numNota;
    }

    /**
     * Set dtNota
     *
     * @param \DateTime $dtNota
     * @return NotaFiscalFornecedor
     */
    public function setDtNota(\DateTime $dtNota = null)
    {
        $this->dtNota = $dtNota;
        return $this;
    }

    /**
     * Get dtNota
     *
     * @return \DateTime
     */
    public function getDtNota()
    {
        return $this->dtNota;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return NotaFiscalFornecedor
     */
    public function setObservacao($observacao = null)
    {
        $this->observacao = $observacao;
        return $this;
    }

    /**
     * Get observacao
     *
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return NotaFiscalFornecedor
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
     * Set fkComprasFornecedor
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Fornecedor $fkComprasFornecedor
     * @return NotaFiscalFornecedor
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
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoNaturezaLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\NaturezaLancamento $fkAlmoxarifadoNaturezaLancamento
     * @return NotaFiscalFornecedor
     */
    public function setFkAlmoxarifadoNaturezaLancamento(\Urbem\CoreBundle\Entity\Almoxarifado\NaturezaLancamento $fkAlmoxarifadoNaturezaLancamento)
    {
        $this->exercicioLancamento = $fkAlmoxarifadoNaturezaLancamento->getExercicioLancamento();
        $this->numLancamento = $fkAlmoxarifadoNaturezaLancamento->getNumLancamento();
        $this->codNatureza = $fkAlmoxarifadoNaturezaLancamento->getCodNatureza();
        $this->tipoNatureza = $fkAlmoxarifadoNaturezaLancamento->getTipoNatureza();
        $this->fkAlmoxarifadoNaturezaLancamento = $fkAlmoxarifadoNaturezaLancamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoNaturezaLancamento
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\NaturezaLancamento
     */
    public function getFkAlmoxarifadoNaturezaLancamento()
    {
        return $this->fkAlmoxarifadoNaturezaLancamento;
    }

    /**
     * OneToOne (inverse side)
     * Set ComprasNotaFiscalFornecedorOrdem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\NotaFiscalFornecedorOrdem $fkComprasNotaFiscalFornecedorOrdem
     * @return NotaFiscalFornecedor
     */
    public function setFkComprasNotaFiscalFornecedorOrdem(\Urbem\CoreBundle\Entity\Compras\NotaFiscalFornecedorOrdem $fkComprasNotaFiscalFornecedorOrdem)
    {
        $fkComprasNotaFiscalFornecedorOrdem->setFkComprasNotaFiscalFornecedor($this);
        $this->fkComprasNotaFiscalFornecedorOrdem = $fkComprasNotaFiscalFornecedorOrdem;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkComprasNotaFiscalFornecedorOrdem
     *
     * @return \Urbem\CoreBundle\Entity\Compras\NotaFiscalFornecedorOrdem
     */
    public function getFkComprasNotaFiscalFornecedorOrdem()
    {
        return $this->fkComprasNotaFiscalFornecedorOrdem;
    }
}
