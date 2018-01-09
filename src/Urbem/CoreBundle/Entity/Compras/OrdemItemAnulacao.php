<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * OrdemItemAnulacao
 */
class OrdemItemAnulacao
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
     * @var integer
     */
    private $codOrdem;

    /**
     * PK
     * @var integer
     */
    private $codPreEmpenho;

    /**
     * PK
     * @var integer
     */
    private $numItem;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var string
     */
    private $tipo;

    /**
     * PK
     * @var string
     */
    private $exercicioPreEmpenho;

    /**
     * @var integer
     */
    private $quantidade;

    /**
     * @var integer
     */
    private $vlTotal;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\OrdemItem
     */
    private $fkComprasOrdemItem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\OrdemAnulacao
     */
    private $fkComprasOrdemAnulacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return OrdemItemAnulacao
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
     * @return OrdemItemAnulacao
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
     * @return OrdemItemAnulacao
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
     * Set codPreEmpenho
     *
     * @param integer $codPreEmpenho
     * @return OrdemItemAnulacao
     */
    public function setCodPreEmpenho($codPreEmpenho)
    {
        $this->codPreEmpenho = $codPreEmpenho;
        return $this;
    }

    /**
     * Get codPreEmpenho
     *
     * @return integer
     */
    public function getCodPreEmpenho()
    {
        return $this->codPreEmpenho;
    }

    /**
     * Set numItem
     *
     * @param integer $numItem
     * @return OrdemItemAnulacao
     */
    public function setNumItem($numItem)
    {
        $this->numItem = $numItem;
        return $this;
    }

    /**
     * Get numItem
     *
     * @return integer
     */
    public function getNumItem()
    {
        return $this->numItem;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return OrdemItemAnulacao
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return OrdemItemAnulacao
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
     * Set exercicioPreEmpenho
     *
     * @param string $exercicioPreEmpenho
     * @return OrdemItemAnulacao
     */
    public function setExercicioPreEmpenho($exercicioPreEmpenho)
    {
        $this->exercicioPreEmpenho = $exercicioPreEmpenho;
        return $this;
    }

    /**
     * Get exercicioPreEmpenho
     *
     * @return string
     */
    public function getExercicioPreEmpenho()
    {
        return $this->exercicioPreEmpenho;
    }

    /**
     * Set quantidade
     *
     * @param integer $quantidade
     * @return OrdemItemAnulacao
     */
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
        return $this;
    }

    /**
     * Get quantidade
     *
     * @return integer
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * Set vlTotal
     *
     * @param integer $vlTotal
     * @return OrdemItemAnulacao
     */
    public function setVlTotal($vlTotal = null)
    {
        $this->vlTotal = $vlTotal;
        return $this;
    }

    /**
     * Get vlTotal
     *
     * @return integer
     */
    public function getVlTotal()
    {
        return $this->vlTotal;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasOrdemItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\OrdemItem $fkComprasOrdemItem
     * @return OrdemItemAnulacao
     */
    public function setFkComprasOrdemItem(\Urbem\CoreBundle\Entity\Compras\OrdemItem $fkComprasOrdemItem)
    {
        $this->exercicio = $fkComprasOrdemItem->getExercicio();
        $this->codEntidade = $fkComprasOrdemItem->getCodEntidade();
        $this->codOrdem = $fkComprasOrdemItem->getCodOrdem();
        $this->codPreEmpenho = $fkComprasOrdemItem->getCodPreEmpenho();
        $this->numItem = $fkComprasOrdemItem->getNumItem();
        $this->tipo = $fkComprasOrdemItem->getTipo();
        $this->exercicioPreEmpenho = $fkComprasOrdemItem->getExercicioPreEmpenho();
        $this->fkComprasOrdemItem = $fkComprasOrdemItem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasOrdemItem
     *
     * @return \Urbem\CoreBundle\Entity\Compras\OrdemItem
     */
    public function getFkComprasOrdemItem()
    {
        return $this->fkComprasOrdemItem;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasOrdemAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\OrdemAnulacao $fkComprasOrdemAnulacao
     * @return OrdemItemAnulacao
     */
    public function setFkComprasOrdemAnulacao(\Urbem\CoreBundle\Entity\Compras\OrdemAnulacao $fkComprasOrdemAnulacao)
    {
        $this->exercicio = $fkComprasOrdemAnulacao->getExercicio();
        $this->codEntidade = $fkComprasOrdemAnulacao->getCodEntidade();
        $this->codOrdem = $fkComprasOrdemAnulacao->getCodOrdem();
        $this->timestamp = $fkComprasOrdemAnulacao->getTimestamp();
        $this->tipo = $fkComprasOrdemAnulacao->getTipo();
        $this->fkComprasOrdemAnulacao = $fkComprasOrdemAnulacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasOrdemAnulacao
     *
     * @return \Urbem\CoreBundle\Entity\Compras\OrdemAnulacao
     */
    public function getFkComprasOrdemAnulacao()
    {
        return $this->fkComprasOrdemAnulacao;
    }
}
