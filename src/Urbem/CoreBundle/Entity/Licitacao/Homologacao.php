<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * Homologacao
 */
class Homologacao
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
     * @var integer
     */
    private $numAdjudicacao;

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
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codTipoDocumento;

    /**
     * @var integer
     */
    private $codDocumento;

    /**
     * @var boolean
     */
    private $homologado;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Licitacao\HomologacaoAnulada
     */
    private $fkLicitacaoHomologacaoAnulada;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\Adjudicacao
     */
    private $fkLicitacaoAdjudicacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento
     */
    private $fkAdministracaoModeloDocumento;

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
     * @return Homologacao
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
     * Set codLicitacao
     *
     * @param integer $codLicitacao
     * @return Homologacao
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
     * @return Homologacao
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
     * @return Homologacao
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
     * Set numAdjudicacao
     *
     * @param integer $numAdjudicacao
     * @return Homologacao
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
     * Set exercicioLicitacao
     *
     * @param string $exercicioLicitacao
     * @return Homologacao
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
     * @return Homologacao
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
     * @return Homologacao
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
     * @return Homologacao
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
     * @return Homologacao
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
     * @return Homologacao
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
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return Homologacao
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
     * Set codTipoDocumento
     *
     * @param integer $codTipoDocumento
     * @return Homologacao
     */
    public function setCodTipoDocumento($codTipoDocumento)
    {
        $this->codTipoDocumento = $codTipoDocumento;
        return $this;
    }

    /**
     * Get codTipoDocumento
     *
     * @return integer
     */
    public function getCodTipoDocumento()
    {
        return $this->codTipoDocumento;
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return Homologacao
     */
    public function setCodDocumento($codDocumento)
    {
        $this->codDocumento = $codDocumento;
        return $this;
    }

    /**
     * Get codDocumento
     *
     * @return integer
     */
    public function getCodDocumento()
    {
        return $this->codDocumento;
    }

    /**
     * Set homologado
     *
     * @param boolean $homologado
     * @return Homologacao
     */
    public function setHomologado($homologado)
    {
        $this->homologado = $homologado;
        return $this;
    }

    /**
     * Get homologado
     *
     * @return boolean
     */
    public function getHomologado()
    {
        return $this->homologado;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoAdjudicacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Adjudicacao $fkLicitacaoAdjudicacao
     * @return Homologacao
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
     * ManyToOne (inverse side)
     * Get fkLicitacaoAdjudicacao
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\Adjudicacao
     */
    public function getFkLicitacaoAdjudicacao()
    {
        return $this->fkLicitacaoAdjudicacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoModeloDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento
     * @return Homologacao
     */
    public function setFkAdministracaoModeloDocumento(\Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento)
    {
        $this->codDocumento = $fkAdministracaoModeloDocumento->getCodDocumento();
        $this->codTipoDocumento = $fkAdministracaoModeloDocumento->getCodTipoDocumento();
        $this->fkAdministracaoModeloDocumento = $fkAdministracaoModeloDocumento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoModeloDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento
     */
    public function getFkAdministracaoModeloDocumento()
    {
        return $this->fkAdministracaoModeloDocumento;
    }

    /**
     * OneToOne (inverse side)
     * Set LicitacaoHomologacaoAnulada
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\HomologacaoAnulada $fkLicitacaoHomologacaoAnulada
     * @return Homologacao
     */
    public function setFkLicitacaoHomologacaoAnulada(\Urbem\CoreBundle\Entity\Licitacao\HomologacaoAnulada $fkLicitacaoHomologacaoAnulada)
    {
        $fkLicitacaoHomologacaoAnulada->setFkLicitacaoHomologacao($this);
        $this->fkLicitacaoHomologacaoAnulada = $fkLicitacaoHomologacaoAnulada;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkLicitacaoHomologacaoAnulada
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\HomologacaoAnulada
     */
    public function getFkLicitacaoHomologacaoAnulada()
    {
        return $this->fkLicitacaoHomologacaoAnulada;
    }
}
