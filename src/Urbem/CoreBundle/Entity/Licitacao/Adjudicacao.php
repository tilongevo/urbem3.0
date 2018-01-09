<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * Adjudicacao
 */
class Adjudicacao
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
    private $adjudicado = false;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Licitacao\AdjudicacaoAnulada
     */
    private $fkLicitacaoAdjudicacaoAnulada;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Homologacao
     */
    private $fkLicitacaoHomologacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\CotacaoLicitacao
     */
    private $fkLicitacaoCotacaoLicitacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento
     */
    private $fkAdministracaoModeloDocumento;

    /**
     * OneToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\Licitacao
     */
    private $fkLicitacaoLicitacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkLicitacaoHomologacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \DateTime;
    }

    /**
     * Set numAdjudicacao
     *
     * @param integer $numAdjudicacao
     * @return Adjudicacao
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
     * @return Adjudicacao
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
     * @return Adjudicacao
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
     * @return Adjudicacao
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
     * @return Adjudicacao
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
     * @return Adjudicacao
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
     * @return Adjudicacao
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
     * @return Adjudicacao
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
     * @return Adjudicacao
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
     * @return Adjudicacao
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
     * @return Adjudicacao
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
     * @return Adjudicacao
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
     * @return Adjudicacao
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
     * Set adjudicado
     *
     * @param boolean $adjudicado
     * @return Adjudicacao
     */
    public function setAdjudicado($adjudicado)
    {
        $this->adjudicado = $adjudicado;
        return $this;
    }

    /**
     * Get adjudicado
     *
     * @return boolean
     */
    public function getAdjudicado()
    {
        return $this->adjudicado;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoHomologacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Homologacao $fkLicitacaoHomologacao
     * @return Adjudicacao
     */
    public function addFkLicitacaoHomologacoes(\Urbem\CoreBundle\Entity\Licitacao\Homologacao $fkLicitacaoHomologacao)
    {
        if (false === $this->fkLicitacaoHomologacoes->contains($fkLicitacaoHomologacao)) {
            $fkLicitacaoHomologacao->setFkLicitacaoAdjudicacao($this);
            $this->fkLicitacaoHomologacoes->add($fkLicitacaoHomologacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoHomologacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Homologacao $fkLicitacaoHomologacao
     */
    public function removeFkLicitacaoHomologacoes(\Urbem\CoreBundle\Entity\Licitacao\Homologacao $fkLicitacaoHomologacao)
    {
        $this->fkLicitacaoHomologacoes->removeElement($fkLicitacaoHomologacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoHomologacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Homologacao
     */
    public function getFkLicitacaoHomologacoes()
    {
        return $this->fkLicitacaoHomologacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoCotacaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\CotacaoLicitacao $fkLicitacaoCotacaoLicitacao
     * @return Adjudicacao
     */
    public function setFkLicitacaoCotacaoLicitacao(\Urbem\CoreBundle\Entity\Licitacao\CotacaoLicitacao $fkLicitacaoCotacaoLicitacao)
    {
        $this->codLicitacao = $fkLicitacaoCotacaoLicitacao->getCodLicitacao();
        $this->codModalidade = $fkLicitacaoCotacaoLicitacao->getCodModalidade();
        $this->codEntidade = $fkLicitacaoCotacaoLicitacao->getCodEntidade();
        $this->exercicioLicitacao = $fkLicitacaoCotacaoLicitacao->getExercicioLicitacao();
        $this->lote = $fkLicitacaoCotacaoLicitacao->getLote();
        $this->codCotacao = $fkLicitacaoCotacaoLicitacao->getCodCotacao();
        $this->cgmFornecedor = $fkLicitacaoCotacaoLicitacao->getCgmFornecedor();
        $this->codItem = $fkLicitacaoCotacaoLicitacao->getCodItem();
        $this->exercicioCotacao = $fkLicitacaoCotacaoLicitacao->getExercicioCotacao();
        $this->fkLicitacaoCotacaoLicitacao = $fkLicitacaoCotacaoLicitacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoCotacaoLicitacao
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\CotacaoLicitacao
     */
    public function getFkLicitacaoCotacaoLicitacao()
    {
        return $this->fkLicitacaoCotacaoLicitacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoModeloDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento
     * @return Adjudicacao
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
     * Set LicitacaoAdjudicacaoAnulada
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\AdjudicacaoAnulada $fkLicitacaoAdjudicacaoAnulada
     * @return Adjudicacao
     */
    public function setFkLicitacaoAdjudicacaoAnulada(\Urbem\CoreBundle\Entity\Licitacao\AdjudicacaoAnulada $fkLicitacaoAdjudicacaoAnulada)
    {
        $fkLicitacaoAdjudicacaoAnulada->setFkLicitacaoAdjudicacao($this);
        $this->fkLicitacaoAdjudicacaoAnulada = $fkLicitacaoAdjudicacaoAnulada;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkLicitacaoAdjudicacaoAnulada
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\AdjudicacaoAnulada
     */
    public function getFkLicitacaoAdjudicacaoAnulada()
    {
        return $this->fkLicitacaoAdjudicacaoAnulada;
    }

    /**
     * @return Licitacao
     */
    public function getFkLicitacaoLicitacao()
    {
        return $this->fkLicitacaoLicitacao;
    }

    /**
     * @param Licitacao $fkLicitacaoLicitacao
     */
    public function setFkLicitacaoLicitacao($fkLicitacaoLicitacao)
    {
        $this->fkLicitacaoLicitacao = $fkLicitacaoLicitacao;
    }
}
