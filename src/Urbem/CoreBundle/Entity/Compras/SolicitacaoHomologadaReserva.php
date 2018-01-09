<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * SolicitacaoHomologadaReserva
 */
class SolicitacaoHomologadaReserva
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
    private $codReserva;

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
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologada
     */
    private $fkComprasSolicitacaoHomologada;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\ReservaSaldos
     */
    private $fkOrcamentoReservaSaldos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacao
     */
    private $fkComprasSolicitacaoItemDotacao;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return SolicitacaoHomologadaReserva
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
     * @return SolicitacaoHomologadaReserva
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
     * @return SolicitacaoHomologadaReserva
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
     * Set codCentro
     *
     * @param integer $codCentro
     * @return SolicitacaoHomologadaReserva
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
     * @return SolicitacaoHomologadaReserva
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
     * Set codReserva
     *
     * @param integer $codReserva
     * @return SolicitacaoHomologadaReserva
     */
    public function setCodReserva($codReserva)
    {
        $this->codReserva = $codReserva;
        return $this;
    }

    /**
     * Get codReserva
     *
     * @return integer
     */
    public function getCodReserva()
    {
        return $this->codReserva;
    }

    /**
     * Set codConta
     *
     * @param integer $codConta
     * @return SolicitacaoHomologadaReserva
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
     * @return SolicitacaoHomologadaReserva
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
     * ManyToOne (inverse side)
     * Set fkComprasSolicitacaoHomologada
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologada $fkComprasSolicitacaoHomologada
     * @return SolicitacaoHomologadaReserva
     */
    public function setFkComprasSolicitacaoHomologada(\Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologada $fkComprasSolicitacaoHomologada)
    {
        $this->exercicio = $fkComprasSolicitacaoHomologada->getExercicio();
        $this->codEntidade = $fkComprasSolicitacaoHomologada->getCodEntidade();
        $this->codSolicitacao = $fkComprasSolicitacaoHomologada->getCodSolicitacao();
        $this->fkComprasSolicitacaoHomologada = $fkComprasSolicitacaoHomologada;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasSolicitacaoHomologada
     *
     * @return \Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologada
     */
    public function getFkComprasSolicitacaoHomologada()
    {
        return $this->fkComprasSolicitacaoHomologada;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoReservaSaldos
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ReservaSaldos $fkOrcamentoReservaSaldos
     * @return SolicitacaoHomologadaReserva
     */
    public function setFkOrcamentoReservaSaldos(\Urbem\CoreBundle\Entity\Orcamento\ReservaSaldos $fkOrcamentoReservaSaldos)
    {
        $this->codReserva = $fkOrcamentoReservaSaldos->getCodReserva();
        $this->exercicio = $fkOrcamentoReservaSaldos->getExercicio();
        $this->fkOrcamentoReservaSaldos = $fkOrcamentoReservaSaldos;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoReservaSaldos
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\ReservaSaldos
     */
    public function getFkOrcamentoReservaSaldos()
    {
        return $this->fkOrcamentoReservaSaldos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasSolicitacaoItemDotacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacao $fkComprasSolicitacaoItemDotacao
     * @return SolicitacaoHomologadaReserva
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
}
