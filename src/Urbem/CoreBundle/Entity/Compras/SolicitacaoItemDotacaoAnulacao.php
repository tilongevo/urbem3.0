<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * SolicitacaoItemDotacaoAnulacao
 */
class SolicitacaoItemDotacaoAnulacao
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
    private $codSolicitacao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codCentro;

    /**
     * PK
     * @var integer
     */
    private $codItem;

    /**
     * PK
     * @var integer
     */
    private $codConta;

    /**
     * PK
     * @var integer
     */
    private $codDespesa;

    /**
     * @var integer
     */
    private $quantidade;

    /**
     * @var integer
     */
    private $vlAnulacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacao
     */
    private $fkComprasSolicitacaoItemDotacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\SolicitacaoItemAnulacao
     */
    private $fkComprasSolicitacaoItemAnulacao;

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
     * @return SolicitacaoItemDotacaoAnulacao
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
     * @return SolicitacaoItemDotacaoAnulacao
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
     * Set codSolicitacao
     *
     * @param integer $codSolicitacao
     * @return SolicitacaoItemDotacaoAnulacao
     */
    public function setCodSolicitacao($codSolicitacao)
    {
        $this->codSolicitacao = $codSolicitacao;
        return $this;
    }

    /**
     * Get codSolicitacao
     *
     * @return integer
     */
    public function getCodSolicitacao()
    {
        return $this->codSolicitacao;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return SolicitacaoItemDotacaoAnulacao
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
     * Set codCentro
     *
     * @param integer $codCentro
     * @return SolicitacaoItemDotacaoAnulacao
     */
    public function setCodCentro($codCentro)
    {
        $this->codCentro = $codCentro;
        return $this;
    }

    /**
     * Get codCentro
     *
     * @return integer
     */
    public function getCodCentro()
    {
        return $this->codCentro;
    }

    /**
     * Set codItem
     *
     * @param integer $codItem
     * @return SolicitacaoItemDotacaoAnulacao
     */
    public function setCodItem($codItem)
    {
        $this->codItem = $codItem;
        return $this;
    }

    /**
     * Get codItem
     *
     * @return integer
     */
    public function getCodItem()
    {
        return $this->codItem;
    }

    /**
     * Set codConta
     *
     * @param integer $codConta
     * @return SolicitacaoItemDotacaoAnulacao
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
     * Set codDespesa
     *
     * @param integer $codDespesa
     * @return SolicitacaoItemDotacaoAnulacao
     */
    public function setCodDespesa($codDespesa)
    {
        $this->codDespesa = $codDespesa;
        return $this;
    }

    /**
     * Get codDespesa
     *
     * @return integer
     */
    public function getCodDespesa()
    {
        return $this->codDespesa;
    }

    /**
     * Set quantidade
     *
     * @param integer $quantidade
     * @return SolicitacaoItemDotacaoAnulacao
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
     * Set vlAnulacao
     *
     * @param integer $vlAnulacao
     * @return SolicitacaoItemDotacaoAnulacao
     */
    public function setVlAnulacao($vlAnulacao)
    {
        $this->vlAnulacao = $vlAnulacao;
        return $this;
    }

    /**
     * Get vlAnulacao
     *
     * @return integer
     */
    public function getVlAnulacao()
    {
        return $this->vlAnulacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasSolicitacaoItemDotacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacao $fkComprasSolicitacaoItemDotacao
     * @return SolicitacaoItemDotacaoAnulacao
     */
    public function setFkComprasSolicitacaoItemDotacao(\Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacao $fkComprasSolicitacaoItemDotacao)
    {
        $this->exercicio = $fkComprasSolicitacaoItemDotacao->getExercicio();
        $this->codEntidade = $fkComprasSolicitacaoItemDotacao->getCodEntidade();
        $this->codSolicitacao = $fkComprasSolicitacaoItemDotacao->getCodSolicitacao();
        $this->codCentro = $fkComprasSolicitacaoItemDotacao->getCodCentro();
        $this->codItem = $fkComprasSolicitacaoItemDotacao->getCodItem();
        $this->codConta = $fkComprasSolicitacaoItemDotacao->getCodConta();
        $this->codDespesa = $fkComprasSolicitacaoItemDotacao->getCodDespesa();
        $this->fkComprasSolicitacaoItemDotacao = $fkComprasSolicitacaoItemDotacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasSolicitacaoItemDotacao
     *
     * @return \Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacao
     */
    public function getFkComprasSolicitacaoItemDotacao()
    {
        return $this->fkComprasSolicitacaoItemDotacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasSolicitacaoItemAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoItemAnulacao $fkComprasSolicitacaoItemAnulacao
     * @return SolicitacaoItemDotacaoAnulacao
     */
    public function setFkComprasSolicitacaoItemAnulacao(\Urbem\CoreBundle\Entity\Compras\SolicitacaoItemAnulacao $fkComprasSolicitacaoItemAnulacao)
    {
        $this->exercicio = $fkComprasSolicitacaoItemAnulacao->getExercicio();
        $this->codEntidade = $fkComprasSolicitacaoItemAnulacao->getCodEntidade();
        $this->codSolicitacao = $fkComprasSolicitacaoItemAnulacao->getCodSolicitacao();
        $this->timestamp = $fkComprasSolicitacaoItemAnulacao->getTimestamp();
        $this->codCentro = $fkComprasSolicitacaoItemAnulacao->getCodCentro();
        $this->codItem = $fkComprasSolicitacaoItemAnulacao->getCodItem();
        $this->fkComprasSolicitacaoItemAnulacao = $fkComprasSolicitacaoItemAnulacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasSolicitacaoItemAnulacao
     *
     * @return \Urbem\CoreBundle\Entity\Compras\SolicitacaoItemAnulacao
     */
    public function getFkComprasSolicitacaoItemAnulacao()
    {
        return $this->fkComprasSolicitacaoItemAnulacao;
    }
}
