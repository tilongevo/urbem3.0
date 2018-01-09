<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * MapaItemReserva
 */
class MapaItemReserva
{
    /**
     * PK
     * @var string
     */
    private $exercicioMapa;

    /**
     * PK
     * @var integer
     */
    private $codMapa;

    /**
     * PK
     * @var string
     */
    private $exercicioSolicitacao;

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
    private $lote;

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
     * @var string
     */
    private $exercicioReserva;

    /**
     * @var integer
     */
    private $codReserva;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Compras\MapaItemDotacao
     */
    private $fkComprasMapaItemDotacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\ReservaSaldos
     */
    private $fkOrcamentoReservaSaldos;


    /**
     * Set exercicioMapa
     *
     * @param string $exercicioMapa
     * @return MapaItemReserva
     */
    public function setExercicioMapa($exercicioMapa)
    {
        $this->exercicioMapa = $exercicioMapa;
        return $this;
    }

    /**
     * Get exercicioMapa
     *
     * @return string
     */
    public function getExercicioMapa()
    {
        return $this->exercicioMapa;
    }

    /**
     * Set codMapa
     *
     * @param integer $codMapa
     * @return MapaItemReserva
     */
    public function setCodMapa($codMapa)
    {
        $this->codMapa = $codMapa;
        return $this;
    }

    /**
     * Get codMapa
     *
     * @return integer
     */
    public function getCodMapa()
    {
        return $this->codMapa;
    }

    /**
     * Set exercicioSolicitacao
     *
     * @param string $exercicioSolicitacao
     * @return MapaItemReserva
     */
    public function setExercicioSolicitacao($exercicioSolicitacao)
    {
        $this->exercicioSolicitacao = $exercicioSolicitacao;
        return $this;
    }

    /**
     * Get exercicioSolicitacao
     *
     * @return string
     */
    public function getExercicioSolicitacao()
    {
        return $this->exercicioSolicitacao;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return MapaItemReserva
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
     * @return MapaItemReserva
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
     * @return MapaItemReserva
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
     * @return MapaItemReserva
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
     * Set lote
     *
     * @param integer $lote
     * @return MapaItemReserva
     */
    public function setLote($lote)
    {
        $this->lote = $lote;
        return $this;
    }

    /**
     * Get lote
     *
     * @return integer
     */
    public function getLote()
    {
        return $this->lote;
    }

    /**
     * Set codConta
     *
     * @param integer $codConta
     * @return MapaItemReserva
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
     * @return MapaItemReserva
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
     * Set exercicioReserva
     *
     * @param string $exercicioReserva
     * @return MapaItemReserva
     */
    public function setExercicioReserva($exercicioReserva)
    {
        $this->exercicioReserva = $exercicioReserva;
        return $this;
    }

    /**
     * Get exercicioReserva
     *
     * @return string
     */
    public function getExercicioReserva()
    {
        return $this->exercicioReserva;
    }

    /**
     * Set codReserva
     *
     * @param integer $codReserva
     * @return MapaItemReserva
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
     * ManyToOne (inverse side)
     * Set fkOrcamentoReservaSaldos
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ReservaSaldos $fkOrcamentoReservaSaldos
     * @return MapaItemReserva
     */
    public function setFkOrcamentoReservaSaldos(\Urbem\CoreBundle\Entity\Orcamento\ReservaSaldos $fkOrcamentoReservaSaldos)
    {
        $this->codReserva = $fkOrcamentoReservaSaldos->getCodReserva();
        $this->exercicioReserva = $fkOrcamentoReservaSaldos->getExercicio();
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
     * OneToOne (owning side)
     * Set ComprasMapaItemDotacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\MapaItemDotacao $fkComprasMapaItemDotacao
     * @return MapaItemReserva
     */
    public function setFkComprasMapaItemDotacao(\Urbem\CoreBundle\Entity\Compras\MapaItemDotacao $fkComprasMapaItemDotacao)
    {
        $this->exercicioMapa = $fkComprasMapaItemDotacao->getExercicio();
        $this->codMapa = $fkComprasMapaItemDotacao->getCodMapa();
        $this->exercicioSolicitacao = $fkComprasMapaItemDotacao->getExercicioSolicitacao();
        $this->codEntidade = $fkComprasMapaItemDotacao->getCodEntidade();
        $this->codSolicitacao = $fkComprasMapaItemDotacao->getCodSolicitacao();
        $this->codCentro = $fkComprasMapaItemDotacao->getCodCentro();
        $this->codItem = $fkComprasMapaItemDotacao->getCodItem();
        $this->lote = $fkComprasMapaItemDotacao->getLote();
        $this->codConta = $fkComprasMapaItemDotacao->getCodConta();
        $this->codDespesa = $fkComprasMapaItemDotacao->getCodDespesa();
        $this->fkComprasMapaItemDotacao = $fkComprasMapaItemDotacao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkComprasMapaItemDotacao
     *
     * @return \Urbem\CoreBundle\Entity\Compras\MapaItemDotacao
     */
    public function getFkComprasMapaItemDotacao()
    {
        return $this->fkComprasMapaItemDotacao;
    }
}
