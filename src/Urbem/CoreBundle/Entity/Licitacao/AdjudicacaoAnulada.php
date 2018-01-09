<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * AdjudicacaoAnulada
 */
class AdjudicacaoAnulada
{
    /**
     * PK
     * @var integer
     */
    private $numAdjudicacao;

    /**
     * PK
     * @var integer
     */
    private $codLicitacao;

    /**
     * PK
     * @var integer
     */
    private $codModalidade;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $exercicioLicitacao;

    /**
     * PK
     * @var integer
     */
    private $lote;

    /**
     * PK
     * @var integer
     */
    private $codCotacao;

    /**
     * PK
     * @var integer
     */
    private $codItem;

    /**
     * PK
     * @var string
     */
    private $exercicioCotacao;

    /**
     * PK
     * @var integer
     */
    private $cgmFornecedor;

    /**
     * @var string
     */
    private $motivo;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Licitacao\Adjudicacao
     */
    private $fkLicitacaoAdjudicacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \DateTime;
    }

    /**
     * Set numAdjudicacao
     *
     * @param integer $numAdjudicacao
     * @return AdjudicacaoAnulada
     */
    public function setNumAdjudicacao($numAdjudicacao)
    {
        $this->numAdjudicacao = $numAdjudicacao;
        return $this;
    }

    /**
     * Get numAdjudicacao
     *
     * @return integer
     */
    public function getNumAdjudicacao()
    {
        return $this->numAdjudicacao;
    }

    /**
     * Set codLicitacao
     *
     * @param integer $codLicitacao
     * @return AdjudicacaoAnulada
     */
    public function setCodLicitacao($codLicitacao)
    {
        $this->codLicitacao = $codLicitacao;
        return $this;
    }

    /**
     * Get codLicitacao
     *
     * @return integer
     */
    public function getCodLicitacao()
    {
        return $this->codLicitacao;
    }

    /**
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return AdjudicacaoAnulada
     */
    public function setCodModalidade($codModalidade)
    {
        $this->codModalidade = $codModalidade;
        return $this;
    }

    /**
     * Get codModalidade
     *
     * @return integer
     */
    public function getCodModalidade()
    {
        return $this->codModalidade;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return AdjudicacaoAnulada
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
     * Set exercicioLicitacao
     *
     * @param string $exercicioLicitacao
     * @return AdjudicacaoAnulada
     */
    public function setExercicioLicitacao($exercicioLicitacao)
    {
        $this->exercicioLicitacao = $exercicioLicitacao;
        return $this;
    }

    /**
     * Get exercicioLicitacao
     *
     * @return string
     */
    public function getExercicioLicitacao()
    {
        return $this->exercicioLicitacao;
    }

    /**
     * Set lote
     *
     * @param integer $lote
     * @return AdjudicacaoAnulada
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
     * Set codCotacao
     *
     * @param integer $codCotacao
     * @return AdjudicacaoAnulada
     */
    public function setCodCotacao($codCotacao)
    {
        $this->codCotacao = $codCotacao;
        return $this;
    }

    /**
     * Get codCotacao
     *
     * @return integer
     */
    public function getCodCotacao()
    {
        return $this->codCotacao;
    }

    /**
     * Set codItem
     *
     * @param integer $codItem
     * @return AdjudicacaoAnulada
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
     * Set exercicioCotacao
     *
     * @param string $exercicioCotacao
     * @return AdjudicacaoAnulada
     */
    public function setExercicioCotacao($exercicioCotacao)
    {
        $this->exercicioCotacao = $exercicioCotacao;
        return $this;
    }

    /**
     * Get exercicioCotacao
     *
     * @return string
     */
    public function getExercicioCotacao()
    {
        return $this->exercicioCotacao;
    }

    /**
     * Set cgmFornecedor
     *
     * @param integer $cgmFornecedor
     * @return AdjudicacaoAnulada
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
     * Set motivo
     *
     * @param string $motivo
     * @return AdjudicacaoAnulada
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;
        return $this;
    }

    /**
     * Get motivo
     *
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return AdjudicacaoAnulada
     */
    public function setTimestamp(\DateTime $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * OneToOne (owning side)
     * Set LicitacaoAdjudicacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Adjudicacao $fkLicitacaoAdjudicacao
     * @return AdjudicacaoAnulada
     */
    public function setFkLicitacaoAdjudicacao(\Urbem\CoreBundle\Entity\Licitacao\Adjudicacao $fkLicitacaoAdjudicacao)
    {
        $this->numAdjudicacao = $fkLicitacaoAdjudicacao->getNumAdjudicacao();
        $this->codEntidade = $fkLicitacaoAdjudicacao->getCodEntidade();
        $this->codModalidade = $fkLicitacaoAdjudicacao->getCodModalidade();
        $this->codLicitacao = $fkLicitacaoAdjudicacao->getCodLicitacao();
        $this->exercicioLicitacao = $fkLicitacaoAdjudicacao->getExercicioLicitacao();
        $this->codItem = $fkLicitacaoAdjudicacao->getCodItem();
        $this->codCotacao = $fkLicitacaoAdjudicacao->getCodCotacao();
        $this->lote = $fkLicitacaoAdjudicacao->getLote();
        $this->exercicioCotacao = $fkLicitacaoAdjudicacao->getExercicioCotacao();
        $this->cgmFornecedor = $fkLicitacaoAdjudicacao->getCgmFornecedor();
        $this->fkLicitacaoAdjudicacao = $fkLicitacaoAdjudicacao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkLicitacaoAdjudicacao
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\Adjudicacao
     */
    public function getFkLicitacaoAdjudicacao()
    {
        return $this->fkLicitacaoAdjudicacao;
    }
}
