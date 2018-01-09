<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * Mapa
 */
class Mapa
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
    private $codMapa;

    /**
     * @var integer
     */
    private $codObjeto;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codTipoLicitacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Compras\MapaModalidade
     */
    private $fkComprasMapaModalidade;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tceam\ConfiguracaoArquivoLicitacao
     */
    private $fkTceamConfiguracaoArquivoLicitacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\CompraDireta
     */
    private $fkComprasCompraDiretas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\MapaCotacao
     */
    private $fkComprasMapaCotacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\MapaSolicitacao
     */
    private $fkComprasMapaSolicitacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Licitacao
     */
    private $fkLicitacaoLicitacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\Objeto
     */
    private $fkComprasObjeto;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\TipoLicitacao
     */
    private $fkComprasTipoLicitacao;

    private $codMapaExercicio;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkComprasCompraDiretas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasMapaCotacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasMapaSolicitacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoLicitacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Mapa
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
     * Set codMapa
     *
     * @param integer $codMapa
     * @return Mapa
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
     * Set codObjeto
     *
     * @param integer $codObjeto
     * @return Mapa
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return Mapa
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
     * Set codTipoLicitacao
     *
     * @param integer $codTipoLicitacao
     * @return Mapa
     */
    public function setCodTipoLicitacao($codTipoLicitacao)
    {
        $this->codTipoLicitacao = $codTipoLicitacao;
        return $this;
    }

    /**
     * Get codTipoLicitacao
     *
     * @return integer
     */
    public function getCodTipoLicitacao()
    {
        return $this->codTipoLicitacao;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasCompraDireta
     *
     * @param \Urbem\CoreBundle\Entity\Compras\CompraDireta $fkComprasCompraDireta
     * @return Mapa
     */
    public function addFkComprasCompraDiretas(\Urbem\CoreBundle\Entity\Compras\CompraDireta $fkComprasCompraDireta)
    {
        if (false === $this->fkComprasCompraDiretas->contains($fkComprasCompraDireta)) {
            $fkComprasCompraDireta->setFkComprasMapa($this);
            $this->fkComprasCompraDiretas->add($fkComprasCompraDireta);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasCompraDireta
     *
     * @param \Urbem\CoreBundle\Entity\Compras\CompraDireta $fkComprasCompraDireta
     */
    public function removeFkComprasCompraDiretas(\Urbem\CoreBundle\Entity\Compras\CompraDireta $fkComprasCompraDireta)
    {
        $this->fkComprasCompraDiretas->removeElement($fkComprasCompraDireta);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasCompraDiretas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\CompraDireta
     */
    public function getFkComprasCompraDiretas()
    {
        return $this->fkComprasCompraDiretas;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasMapaCotacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\MapaCotacao $fkComprasMapaCotacao
     * @return Mapa
     */
    public function addFkComprasMapaCotacoes(\Urbem\CoreBundle\Entity\Compras\MapaCotacao $fkComprasMapaCotacao)
    {
        if (false === $this->fkComprasMapaCotacoes->contains($fkComprasMapaCotacao)) {
            $fkComprasMapaCotacao->setFkComprasMapa($this);
            $this->fkComprasMapaCotacoes->add($fkComprasMapaCotacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasMapaCotacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\MapaCotacao $fkComprasMapaCotacao
     */
    public function removeFkComprasMapaCotacoes(\Urbem\CoreBundle\Entity\Compras\MapaCotacao $fkComprasMapaCotacao)
    {
        $this->fkComprasMapaCotacoes->removeElement($fkComprasMapaCotacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasMapaCotacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\MapaCotacao
     */
    public function getFkComprasMapaCotacoes()
    {
        return $this->fkComprasMapaCotacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasMapaSolicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\MapaSolicitacao $fkComprasMapaSolicitacao
     * @return Mapa
     */
    public function addFkComprasMapaSolicitacoes(\Urbem\CoreBundle\Entity\Compras\MapaSolicitacao $fkComprasMapaSolicitacao)
    {
        if (false === $this->fkComprasMapaSolicitacoes->contains($fkComprasMapaSolicitacao)) {
            $fkComprasMapaSolicitacao->setFkComprasMapa($this);
            $this->fkComprasMapaSolicitacoes->add($fkComprasMapaSolicitacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasMapaSolicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\MapaSolicitacao $fkComprasMapaSolicitacao
     */
    public function removeFkComprasMapaSolicitacoes(\Urbem\CoreBundle\Entity\Compras\MapaSolicitacao $fkComprasMapaSolicitacao)
    {
        $this->fkComprasMapaSolicitacoes->removeElement($fkComprasMapaSolicitacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasMapaSolicitacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\MapaSolicitacao
     */
    public function getFkComprasMapaSolicitacoes()
    {
        return $this->fkComprasMapaSolicitacoes;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao
     * @return Mapa
     */
    public function addFkLicitacaoLicitacoes(\Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao)
    {
        if (false === $this->fkLicitacaoLicitacoes->contains($fkLicitacaoLicitacao)) {
            $fkLicitacaoLicitacao->setFkComprasMapa($this);
            $this->fkLicitacaoLicitacoes->add($fkLicitacaoLicitacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao
     */
    public function removeFkLicitacaoLicitacoes(\Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao)
    {
        $this->fkLicitacaoLicitacoes->removeElement($fkLicitacaoLicitacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoLicitacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Licitacao
     */
    public function getFkLicitacaoLicitacoes()
    {
        return $this->fkLicitacaoLicitacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasObjeto
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Objeto $fkComprasObjeto
     * @return Mapa
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
     * Set fkComprasTipoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\TipoLicitacao $fkComprasTipoLicitacao
     * @return Mapa
     */
    public function setFkComprasTipoLicitacao(\Urbem\CoreBundle\Entity\Compras\TipoLicitacao $fkComprasTipoLicitacao)
    {
        $this->codTipoLicitacao = $fkComprasTipoLicitacao->getCodTipoLicitacao();
        $this->fkComprasTipoLicitacao = $fkComprasTipoLicitacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasTipoLicitacao
     *
     * @return \Urbem\CoreBundle\Entity\Compras\TipoLicitacao
     */
    public function getFkComprasTipoLicitacao()
    {
        return $this->fkComprasTipoLicitacao;
    }


    /**
     * OneToOne (inverse side)
     * Set ComprasMapaModalidade
     *
     * @param \Urbem\CoreBundle\Entity\Compras\MapaModalidade $fkComprasMapaModalidade
     * @return Mapa
     */
    public function setFkComprasMapaModalidade(\Urbem\CoreBundle\Entity\Compras\MapaModalidade $fkComprasMapaModalidade)
    {
        $fkComprasMapaModalidade->setFkComprasMapa($this);
        $this->fkComprasMapaModalidade = $fkComprasMapaModalidade;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkComprasMapaModalidade
     *
     * @return \Urbem\CoreBundle\Entity\Compras\MapaModalidade
     */
    public function getFkComprasMapaModalidade()
    {
        return $this->fkComprasMapaModalidade;
    }

    /**
     * OneToOne (inverse side)
     * Set TceamConfiguracaoArquivoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Tceam\ConfiguracaoArquivoLicitacao $fkTceamConfiguracaoArquivoLicitacao
     * @return Mapa
     */
    public function setFkTceamConfiguracaoArquivoLicitacao(\Urbem\CoreBundle\Entity\Tceam\ConfiguracaoArquivoLicitacao $fkTceamConfiguracaoArquivoLicitacao)
    {
        $fkTceamConfiguracaoArquivoLicitacao->setFkComprasMapa($this);
        $this->fkTceamConfiguracaoArquivoLicitacao = $fkTceamConfiguracaoArquivoLicitacao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTceamConfiguracaoArquivoLicitacao
     *
     * @return \Urbem\CoreBundle\Entity\Tceam\ConfiguracaoArquivoLicitacao
     */
    public function getFkTceamConfiguracaoArquivoLicitacao()
    {
        return $this->fkTceamConfiguracaoArquivoLicitacao;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s/%s', $this->codMapa, $this->exercicio);
    }

    /**
     * @return string
     */
    public function getCodMapaExercicio()
    {
        return sprintf('%s/%s', $this->codMapa, $this->exercicio);
    }
}
