<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * CompraDireta
 */
class CompraDireta
{
    /**
     * PK
     * @var integer
     */
    private $codCompraDireta;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $exercicioEntidade;

    /**
     * PK
     * @var integer
     */
    private $codModalidade;

    /**
     * @var integer
     */
    private $codObjeto;

    /**
     * @var string
     */
    private $exercicioMapa;

    /**
     * @var integer
     */
    private $codMapa;

    /**
     * @var integer
     */
    private $codTipoObjeto;

    /**
     * @var \DateTime
     */
    private $dtEntregaProposta;

    /**
     * @var \DateTime
     */
    private $dtValidadeProposta;

    /**
     * @var string
     */
    private $condicoesPagamento;

    /**
     * @var integer
     */
    private $prazoEntrega;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Compras\JustificativaRazao
     */
    private $fkComprasJustificativaRazao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Compras\CompraDiretaAnulacao
     */
    private $fkComprasCompraDiretaAnulacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Compras\CompraDiretaProcesso
     */
    private $fkComprasCompraDiretaProcesso;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\PublicacaoCompraDireta
     */
    private $fkComprasPublicacaoCompraDiretas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ContratoCompraDireta
     */
    private $fkLicitacaoContratoCompraDiretas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\Homologacao
     */
    private $fkComprasHomologacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\Modalidade
     */
    private $fkComprasModalidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\Objeto
     */
    private $fkComprasObjeto;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\Mapa
     */
    private $fkComprasMapa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\TipoObjeto
     */
    private $fkComprasTipoObjeto;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkComprasPublicacaoCompraDiretas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoContratoCompraDiretas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasHomologacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codCompraDireta
     *
     * @param integer $codCompraDireta
     * @return CompraDireta
     */
    public function setCodCompraDireta($codCompraDireta)
    {
        $this->codCompraDireta = $codCompraDireta;
        return $this;
    }

    /**
     * Get codCompraDireta
     *
     * @return integer
     */
    public function getCodCompraDireta()
    {
        return $this->codCompraDireta;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return CompraDireta
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
     * Set exercicioEntidade
     *
     * @param string $exercicioEntidade
     * @return CompraDireta
     */
    public function setExercicioEntidade($exercicioEntidade)
    {
        $this->exercicioEntidade = $exercicioEntidade;
        return $this;
    }

    /**
     * Get exercicioEntidade
     *
     * @return string
     */
    public function getExercicioEntidade()
    {
        return $this->exercicioEntidade;
    }

    /**
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return CompraDireta
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
     * Set codObjeto
     *
     * @param integer $codObjeto
     * @return CompraDireta
     */
    public function setCodObjeto($codObjeto)
    {
        $this->codObjeto = $codObjeto;
        return $this;
    }

    /**
     * Get codObjeto
     *
     * @return integer
     */
    public function getCodObjeto()
    {
        return $this->codObjeto;
    }

    /**
     * Set exercicioMapa
     *
     * @param string $exercicioMapa
     * @return CompraDireta
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
     * @return CompraDireta
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
     * Set codTipoObjeto
     *
     * @param integer $codTipoObjeto
     * @return CompraDireta
     */
    public function setCodTipoObjeto($codTipoObjeto)
    {
        $this->codTipoObjeto = $codTipoObjeto;
        return $this;
    }

    /**
     * Get codTipoObjeto
     *
     * @return integer
     */
    public function getCodTipoObjeto()
    {
        return $this->codTipoObjeto;
    }

    /**
     * Set dtEntregaProposta
     *
     * @param \DateTime $dtEntregaProposta
     * @return CompraDireta
     */
    public function setDtEntregaProposta(\DateTime $dtEntregaProposta = null)
    {
        $this->dtEntregaProposta = $dtEntregaProposta;
        return $this;
    }

    /**
     * Get dtEntregaProposta
     *
     * @return \DateTime
     */
    public function getDtEntregaProposta()
    {
        return $this->dtEntregaProposta;
    }

    /**
     * Set dtValidadeProposta
     *
     * @param \DateTime $dtValidadeProposta
     * @return CompraDireta
     */
    public function setDtValidadeProposta(\DateTime $dtValidadeProposta = null)
    {
        $this->dtValidadeProposta = $dtValidadeProposta;
        return $this;
    }

    /**
     * Get dtValidadeProposta
     *
     * @return \DateTime
     */
    public function getDtValidadeProposta()
    {
        return $this->dtValidadeProposta;
    }

    /**
     * Set condicoesPagamento
     *
     * @param string $condicoesPagamento
     * @return CompraDireta
     */
    public function setCondicoesPagamento($condicoesPagamento = null)
    {
        $this->condicoesPagamento = $condicoesPagamento;
        return $this;
    }

    /**
     * Get condicoesPagamento
     *
     * @return string
     */
    public function getCondicoesPagamento()
    {
        return $this->condicoesPagamento;
    }

    /**
     * Set prazoEntrega
     *
     * @param integer $prazoEntrega
     * @return CompraDireta
     */
    public function setPrazoEntrega($prazoEntrega = null)
    {
        $this->prazoEntrega = $prazoEntrega;
        return $this;
    }

    /**
     * Get prazoEntrega
     *
     * @return integer
     */
    public function getPrazoEntrega()
    {
        return $this->prazoEntrega;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return CompraDireta
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp = null)
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
     * OneToMany (owning side)
     * Add ComprasPublicacaoCompraDireta
     *
     * @param \Urbem\CoreBundle\Entity\Compras\PublicacaoCompraDireta $fkComprasPublicacaoCompraDireta
     * @return CompraDireta
     */
    public function addFkComprasPublicacaoCompraDiretas(\Urbem\CoreBundle\Entity\Compras\PublicacaoCompraDireta $fkComprasPublicacaoCompraDireta)
    {
        if (false === $this->fkComprasPublicacaoCompraDiretas->contains($fkComprasPublicacaoCompraDireta)) {
            $fkComprasPublicacaoCompraDireta->setFkComprasCompraDireta($this);
            $this->fkComprasPublicacaoCompraDiretas->add($fkComprasPublicacaoCompraDireta);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasPublicacaoCompraDireta
     *
     * @param \Urbem\CoreBundle\Entity\Compras\PublicacaoCompraDireta $fkComprasPublicacaoCompraDireta
     */
    public function removeFkComprasPublicacaoCompraDiretas(\Urbem\CoreBundle\Entity\Compras\PublicacaoCompraDireta $fkComprasPublicacaoCompraDireta)
    {
        $this->fkComprasPublicacaoCompraDiretas->removeElement($fkComprasPublicacaoCompraDireta);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasPublicacaoCompraDiretas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\PublicacaoCompraDireta
     */
    public function getFkComprasPublicacaoCompraDiretas()
    {
        return $this->fkComprasPublicacaoCompraDiretas;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoContratoCompraDireta
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ContratoCompraDireta $fkLicitacaoContratoCompraDireta
     * @return CompraDireta
     */
    public function addFkLicitacaoContratoCompraDiretas(\Urbem\CoreBundle\Entity\Licitacao\ContratoCompraDireta $fkLicitacaoContratoCompraDireta)
    {
        if (false === $this->fkLicitacaoContratoCompraDiretas->contains($fkLicitacaoContratoCompraDireta)) {
            $fkLicitacaoContratoCompraDireta->setFkComprasCompraDireta($this);
            $this->fkLicitacaoContratoCompraDiretas->add($fkLicitacaoContratoCompraDireta);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoContratoCompraDireta
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ContratoCompraDireta $fkLicitacaoContratoCompraDireta
     */
    public function removeFkLicitacaoContratoCompraDiretas(\Urbem\CoreBundle\Entity\Licitacao\ContratoCompraDireta $fkLicitacaoContratoCompraDireta)
    {
        $this->fkLicitacaoContratoCompraDiretas->removeElement($fkLicitacaoContratoCompraDireta);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoContratoCompraDiretas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ContratoCompraDireta
     */
    public function getFkLicitacaoContratoCompraDiretas()
    {
        return $this->fkLicitacaoContratoCompraDiretas;
    }

    /**
     * Add ComprasHomologacoes
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Homologacao $fkComprasHomologacoes
     * @return CompraDireta
     */
    public function addFkComprasHomologacoes(\Urbem\CoreBundle\Entity\Compras\Homologacao $fkComprasHomologacoes)
    {
        if (false === $this->fkComprasHomologacoes->contains($fkComprasHomologacoes)) {
            $fkComprasHomologacoes->setFkComprasCompraDireta($this);
            $this->fkComprasHomologacoes->add($fkComprasHomologacoes);
        }

        return $this;
    }

    /**
     * Remove ComprasHomologacoes
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Homologacao $fkComprasHomologacoes
     */
    public function removeFkComprasHomologacoes(\Urbem\CoreBundle\Entity\Compras\Homologacao $fkComprasHomologacoes)
    {
        $this->fkComprasHomologacoes->removeElement($fkComprasHomologacoes);
    }

    /**
     * Get fkComprasHomologacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\Homologacao
     */
    public function getFkComprasHomologacoes()
    {
        return $this->fkComprasHomologacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return CompraDireta
     */
    public function setFkOrcamentoEntidade(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
        $this->exercicioEntidade = $fkOrcamentoEntidade->getExercicio();
        $this->codEntidade = $fkOrcamentoEntidade->getCodEntidade();
        $this->fkOrcamentoEntidade = $fkOrcamentoEntidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoEntidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    public function getFkOrcamentoEntidade()
    {
        return $this->fkOrcamentoEntidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasModalidade
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Modalidade $fkComprasModalidade
     * @return CompraDireta
     */
    public function setFkComprasModalidade(\Urbem\CoreBundle\Entity\Compras\Modalidade $fkComprasModalidade)
    {
        $this->codModalidade = $fkComprasModalidade->getCodModalidade();
        $this->fkComprasModalidade = $fkComprasModalidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasModalidade
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Modalidade
     */
    public function getFkComprasModalidade()
    {
        return $this->fkComprasModalidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasObjeto
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Objeto $fkComprasObjeto
     * @return CompraDireta
     */
    public function setFkComprasObjeto(\Urbem\CoreBundle\Entity\Compras\Objeto $fkComprasObjeto)
    {
        $this->codObjeto = $fkComprasObjeto->getCodObjeto();
        $this->fkComprasObjeto = $fkComprasObjeto;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasObjeto
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Objeto
     */
    public function getFkComprasObjeto()
    {
        return $this->fkComprasObjeto;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasMapa
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Mapa $fkComprasMapa
     * @return CompraDireta
     */
    public function setFkComprasMapa(\Urbem\CoreBundle\Entity\Compras\Mapa $fkComprasMapa)
    {
        $this->exercicioMapa = $fkComprasMapa->getExercicio();
        $this->codMapa = $fkComprasMapa->getCodMapa();
        $this->fkComprasMapa = $fkComprasMapa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasMapa
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Mapa
     */
    public function getFkComprasMapa()
    {
        return $this->fkComprasMapa;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasTipoObjeto
     *
     * @param \Urbem\CoreBundle\Entity\Compras\TipoObjeto $fkComprasTipoObjeto
     * @return CompraDireta
     */
    public function setFkComprasTipoObjeto(\Urbem\CoreBundle\Entity\Compras\TipoObjeto $fkComprasTipoObjeto)
    {
        $this->codTipoObjeto = $fkComprasTipoObjeto->getCodTipoObjeto();
        $this->fkComprasTipoObjeto = $fkComprasTipoObjeto;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasTipoObjeto
     *
     * @return \Urbem\CoreBundle\Entity\Compras\TipoObjeto
     */
    public function getFkComprasTipoObjeto()
    {
        return $this->fkComprasTipoObjeto;
    }

    /**
     * OneToOne (inverse side)
     * Set ComprasJustificativaRazao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\JustificativaRazao $fkComprasJustificativaRazao
     * @return CompraDireta
     */
    public function setFkComprasJustificativaRazao(\Urbem\CoreBundle\Entity\Compras\JustificativaRazao $fkComprasJustificativaRazao)
    {
        $fkComprasJustificativaRazao->setFkComprasCompraDireta($this);
        $this->fkComprasJustificativaRazao = $fkComprasJustificativaRazao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkComprasJustificativaRazao
     *
     * @return \Urbem\CoreBundle\Entity\Compras\JustificativaRazao
     */
    public function getFkComprasJustificativaRazao()
    {
        return $this->fkComprasJustificativaRazao;
    }

    /**
     * OneToOne (inverse side)
     * Set ComprasCompraDiretaAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\CompraDiretaAnulacao $fkComprasCompraDiretaAnulacao
     * @return CompraDireta
     */
    public function setFkComprasCompraDiretaAnulacao(\Urbem\CoreBundle\Entity\Compras\CompraDiretaAnulacao $fkComprasCompraDiretaAnulacao)
    {
        $fkComprasCompraDiretaAnulacao->setFkComprasCompraDireta($this);
        $this->fkComprasCompraDiretaAnulacao = $fkComprasCompraDiretaAnulacao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkComprasCompraDiretaAnulacao
     *
     * @return \Urbem\CoreBundle\Entity\Compras\CompraDiretaAnulacao
     */
    public function getFkComprasCompraDiretaAnulacao()
    {
        return $this->fkComprasCompraDiretaAnulacao;
    }

    /**
     * OneToOne (inverse side)
     * Set ComprasCompraDiretaProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Compras\CompraDiretaProcesso $fkComprasCompraDiretaProcesso
     * @return CompraDireta
     */
    public function setFkComprasCompraDiretaProcesso(\Urbem\CoreBundle\Entity\Compras\CompraDiretaProcesso $fkComprasCompraDiretaProcesso)
    {
        $fkComprasCompraDiretaProcesso->setFkComprasCompraDireta($this);
        $this->fkComprasCompraDiretaProcesso = $fkComprasCompraDiretaProcesso;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkComprasCompraDiretaProcesso
     *
     * @return \Urbem\CoreBundle\Entity\Compras\CompraDiretaProcesso
     */
    public function getFkComprasCompraDiretaProcesso()
    {
        return $this->fkComprasCompraDiretaProcesso;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s/%s', $this->codCompraDireta, $this->exercicioEntidade);
    }
}
