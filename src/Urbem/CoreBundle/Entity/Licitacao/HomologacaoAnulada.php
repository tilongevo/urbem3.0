<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * HomologacaoAnulada
 */
class HomologacaoAnulada
{
    /**
     * PK
     * @var integer
     */
    private $numHomologacao;

    /**
     * PK
     * @var integer
     */
    private $numAdjudicacao;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $codModalidade;

    /**
     * PK
     * @var integer
     */
    private $codLicitacao;

    /**
     * PK
     * @var string
     */
    private $exercicioLicitacao;

    /**
     * PK
     * @var integer
     */
    private $codItem;

    /**
     * PK
     * @var integer
     */
    private $codCotacao;

    /**
     * PK
     * @var integer
     */
    private $lote;

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
     * @var boolean
     */
    private $revogacao = false;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Licitacao\Homologacao
     */
    private $fkLicitacaoHomologacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \DateTime;
    }

    /**
     * Set numHomologacao
     *
     * @param integer $numHomologacao
     * @return HomologacaoAnulada
     */
    public function setNumHomologacao($numHomologacao)
    {
        $this->numHomologacao = $numHomologacao;
        return $this;
    }

    /**
     * Get numHomologacao
     *
     * @return integer
     */
    public function getNumHomologacao()
    {
        return $this->numHomologacao;
    }

    /**
     * Set numAdjudicacao
     *
     * @param integer $numAdjudicacao
     * @return HomologacaoAnulada
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return HomologacaoAnulada
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
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return HomologacaoAnulada
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
     * Set codLicitacao
     *
     * @param integer $codLicitacao
     * @return HomologacaoAnulada
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
     * Set exercicioLicitacao
     *
     * @param string $exercicioLicitacao
     * @return HomologacaoAnulada
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
     * Set codItem
     *
     * @param integer $codItem
     * @return HomologacaoAnulada
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
     * Set codCotacao
     *
     * @param integer $codCotacao
     * @return HomologacaoAnulada
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
     * Set lote
     *
     * @param integer $lote
     * @return HomologacaoAnulada
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
     * Set exercicioCotacao
     *
     * @param string $exercicioCotacao
     * @return HomologacaoAnulada
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
     * @return HomologacaoAnulada
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
     * @return HomologacaoAnulada
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
     * @return HomologacaoAnulada
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
     * Set revogacao
     *
     * @param boolean $revogacao
     * @return HomologacaoAnulada
     */
    public function setRevogacao($revogacao)
    {
        $this->revogacao = $revogacao;
        return $this;
    }

    /**
     * Get revogacao
     *
     * @return boolean
     */
    public function getRevogacao()
    {
        return $this->revogacao;
    }

    /**
     * OneToOne (owning side)
     * Set LicitacaoHomologacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Homologacao $fkLicitacaoHomologacao
     * @return HomologacaoAnulada
     */
    public function setFkLicitacaoHomologacao(\Urbem\CoreBundle\Entity\Licitacao\Homologacao $fkLicitacaoHomologacao)
    {
        $this->numHomologacao = $fkLicitacaoHomologacao->getNumHomologacao();
        $this->codLicitacao = $fkLicitacaoHomologacao->getCodLicitacao();
        $this->codModalidade = $fkLicitacaoHomologacao->getCodModalidade();
        $this->codEntidade = $fkLicitacaoHomologacao->getCodEntidade();
        $this->numAdjudicacao = $fkLicitacaoHomologacao->getNumAdjudicacao();
        $this->exercicioLicitacao = $fkLicitacaoHomologacao->getExercicioLicitacao();
        $this->lote = $fkLicitacaoHomologacao->getLote();
        $this->codCotacao = $fkLicitacaoHomologacao->getCodCotacao();
        $this->codItem = $fkLicitacaoHomologacao->getCodItem();
        $this->exercicioCotacao = $fkLicitacaoHomologacao->getExercicioCotacao();
        $this->cgmFornecedor = $fkLicitacaoHomologacao->getCgmFornecedor();
        $this->fkLicitacaoHomologacao = $fkLicitacaoHomologacao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkLicitacaoHomologacao
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\Homologacao
     */
    public function getFkLicitacaoHomologacao()
    {
        return $this->fkLicitacaoHomologacao;
    }
}
