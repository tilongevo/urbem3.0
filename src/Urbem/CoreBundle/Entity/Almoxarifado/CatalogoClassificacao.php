<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * CatalogoClassificacao
 */
class CatalogoClassificacao
{
    /**
     * PK
     * @var integer
     */
    private $codClassificacao;

    /**
     * PK
     * @var integer
     */
    private $codCatalogo;

    /**
     * @var string
     */
    private $codEstrutural;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var string
     */
    private $descricaoIng;

    /**
     * @var string
     */
    private $descricaoEsp;

    /**
     * @var string
     */
    private $estruturalMercosul;

    /**
     * @var boolean
     */
    private $importado = false;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoClassificacao
     */
    private $fkAlmoxarifadoAtributoCatalogoClassificacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem
     */
    private $fkAlmoxarifadoCatalogoItens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\ClassificacaoNivel
     */
    private $fkAlmoxarifadoClassificacaoNiveis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\FornecedorClassificacao
     */
    private $fkComprasFornecedorClassificacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoClassificacaoBloqueio
     */
    private $fkAlmoxarifadoCatalogoClassificacaoBloqueios;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\Catalogo
     */
    private $fkAlmoxarifadoCatalogo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAlmoxarifadoAtributoCatalogoClassificacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoCatalogoItens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoClassificacaoNiveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasFornecedorClassificacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoCatalogoClassificacaoBloqueios = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codClassificacao
     *
     * @param integer $codClassificacao
     * @return CatalogoClassificacao
     */
    public function setCodClassificacao($codClassificacao)
    {
        $this->codClassificacao = $codClassificacao;
        return $this;
    }

    /**
     * Get codClassificacao
     *
     * @return integer
     */
    public function getCodClassificacao()
    {
        return $this->codClassificacao;
    }

    /**
     * Set codCatalogo
     *
     * @param integer $codCatalogo
     * @return CatalogoClassificacao
     */
    public function setCodCatalogo($codCatalogo)
    {
        $this->codCatalogo = $codCatalogo;
        return $this;
    }

    /**
     * Get codCatalogo
     *
     * @return integer
     */
    public function getCodCatalogo()
    {
        return $this->codCatalogo;
    }

    /**
     * Set codEstrutural
     *
     * @param string $codEstrutural
     * @return CatalogoClassificacao
     */
    public function setCodEstrutural($codEstrutural)
    {
        $this->codEstrutural = $codEstrutural;
        return $this;
    }

    /**
     * Get codEstrutural
     *
     * @return string
     */
    public function getCodEstrutural()
    {
        return $this->codEstrutural;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return CatalogoClassificacao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set descricaoIng
     *
     * @param string $descricaoIng
     * @return CatalogoClassificacao
     */
    public function setDescricaoIng($descricaoIng = null)
    {
        $this->descricaoIng = $descricaoIng;
        return $this;
    }

    /**
     * Get descricaoIng
     *
     * @return string
     */
    public function getDescricaoIng()
    {
        return $this->descricaoIng;
    }

    /**
     * Set descricaoEsp
     *
     * @param string $descricaoEsp
     * @return CatalogoClassificacao
     */
    public function setDescricaoEsp($descricaoEsp = null)
    {
        $this->descricaoEsp = $descricaoEsp;
        return $this;
    }

    /**
     * Get descricaoEsp
     *
     * @return string
     */
    public function getDescricaoEsp()
    {
        return $this->descricaoEsp;
    }

    /**
     * Set estruturalMercosul
     *
     * @param string $estruturalMercosul
     * @return CatalogoClassificacao
     */
    public function setEstruturalMercosul($estruturalMercosul = null)
    {
        $this->estruturalMercosul = $estruturalMercosul;
        return $this;
    }

    /**
     * Get estruturalMercosul
     *
     * @return string
     */
    public function getEstruturalMercosul()
    {
        return $this->estruturalMercosul;
    }

    /**
     * Set importado
     *
     * @param boolean $importado
     * @return CatalogoClassificacao
     */
    public function setImportado($importado)
    {
        $this->importado = $importado;
        return $this;
    }

    /**
     * Get importado
     *
     * @return boolean
     */
    public function getImportado()
    {
        return $this->importado;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoAtributoCatalogoClassificacao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoClassificacao $fkAlmoxarifadoAtributoCatalogoClassificacao
     * @return CatalogoClassificacao
     */
    public function addFkAlmoxarifadoAtributoCatalogoClassificacoes(\Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoClassificacao $fkAlmoxarifadoAtributoCatalogoClassificacao)
    {
        if (false === $this->fkAlmoxarifadoAtributoCatalogoClassificacoes->contains($fkAlmoxarifadoAtributoCatalogoClassificacao)) {
            $fkAlmoxarifadoAtributoCatalogoClassificacao->setFkAlmoxarifadoCatalogoClassificacao($this);
            $this->fkAlmoxarifadoAtributoCatalogoClassificacoes->add($fkAlmoxarifadoAtributoCatalogoClassificacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoAtributoCatalogoClassificacao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoClassificacao $fkAlmoxarifadoAtributoCatalogoClassificacao
     */
    public function removeFkAlmoxarifadoAtributoCatalogoClassificacoes(\Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoClassificacao $fkAlmoxarifadoAtributoCatalogoClassificacao)
    {
        $this->fkAlmoxarifadoAtributoCatalogoClassificacoes->removeElement($fkAlmoxarifadoAtributoCatalogoClassificacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoAtributoCatalogoClassificacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoClassificacao
     */
    public function getFkAlmoxarifadoAtributoCatalogoClassificacoes()
    {
        return $this->fkAlmoxarifadoAtributoCatalogoClassificacoes;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoCatalogoItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem $fkAlmoxarifadoCatalogoItem
     * @return CatalogoClassificacao
     */
    public function addFkAlmoxarifadoCatalogoItens(\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem $fkAlmoxarifadoCatalogoItem)
    {
        if (false === $this->fkAlmoxarifadoCatalogoItens->contains($fkAlmoxarifadoCatalogoItem)) {
            $fkAlmoxarifadoCatalogoItem->setFkAlmoxarifadoCatalogoClassificacao($this);
            $this->fkAlmoxarifadoCatalogoItens->add($fkAlmoxarifadoCatalogoItem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoCatalogoItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem $fkAlmoxarifadoCatalogoItem
     */
    public function removeFkAlmoxarifadoCatalogoItens(\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem $fkAlmoxarifadoCatalogoItem)
    {
        $this->fkAlmoxarifadoCatalogoItens->removeElement($fkAlmoxarifadoCatalogoItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoCatalogoItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem
     */
    public function getFkAlmoxarifadoCatalogoItens()
    {
        return $this->fkAlmoxarifadoCatalogoItens;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoClassificacaoNivel
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\ClassificacaoNivel $fkAlmoxarifadoClassificacaoNivel
     * @return CatalogoClassificacao
     */
    public function addFkAlmoxarifadoClassificacaoNiveis(\Urbem\CoreBundle\Entity\Almoxarifado\ClassificacaoNivel $fkAlmoxarifadoClassificacaoNivel)
    {
        if (false === $this->fkAlmoxarifadoClassificacaoNiveis->contains($fkAlmoxarifadoClassificacaoNivel)) {
            $fkAlmoxarifadoClassificacaoNivel->setFkAlmoxarifadoCatalogoClassificacao($this);
            $this->fkAlmoxarifadoClassificacaoNiveis->add($fkAlmoxarifadoClassificacaoNivel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoClassificacaoNivel
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\ClassificacaoNivel $fkAlmoxarifadoClassificacaoNivel
     */
    public function removeFkAlmoxarifadoClassificacaoNiveis(\Urbem\CoreBundle\Entity\Almoxarifado\ClassificacaoNivel $fkAlmoxarifadoClassificacaoNivel)
    {
        $this->fkAlmoxarifadoClassificacaoNiveis->removeElement($fkAlmoxarifadoClassificacaoNivel);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoClassificacaoNiveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\ClassificacaoNivel
     */
    public function getFkAlmoxarifadoClassificacaoNiveis()
    {
        return $this->fkAlmoxarifadoClassificacaoNiveis;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasFornecedorClassificacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\FornecedorClassificacao $fkComprasFornecedorClassificacao
     * @return CatalogoClassificacao
     */
    public function addFkComprasFornecedorClassificacoes(\Urbem\CoreBundle\Entity\Compras\FornecedorClassificacao $fkComprasFornecedorClassificacao)
    {
        if (false === $this->fkComprasFornecedorClassificacoes->contains($fkComprasFornecedorClassificacao)) {
            $fkComprasFornecedorClassificacao->setFkAlmoxarifadoCatalogoClassificacao($this);
            $this->fkComprasFornecedorClassificacoes->add($fkComprasFornecedorClassificacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasFornecedorClassificacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\FornecedorClassificacao $fkComprasFornecedorClassificacao
     */
    public function removeFkComprasFornecedorClassificacoes(\Urbem\CoreBundle\Entity\Compras\FornecedorClassificacao $fkComprasFornecedorClassificacao)
    {
        $this->fkComprasFornecedorClassificacoes->removeElement($fkComprasFornecedorClassificacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasFornecedorClassificacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\FornecedorClassificacao
     */
    public function getFkComprasFornecedorClassificacoes()
    {
        return $this->fkComprasFornecedorClassificacoes;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoCatalogoClassificacaoBloqueio
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoClassificacaoBloqueio $fkAlmoxarifadoCatalogoClassificacaoBloqueio
     * @return CatalogoClassificacao
     */
    public function addFkAlmoxarifadoCatalogoClassificacaoBloqueios(\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoClassificacaoBloqueio $fkAlmoxarifadoCatalogoClassificacaoBloqueio)
    {
        if (false === $this->fkAlmoxarifadoCatalogoClassificacaoBloqueios->contains($fkAlmoxarifadoCatalogoClassificacaoBloqueio)) {
            $fkAlmoxarifadoCatalogoClassificacaoBloqueio->setFkAlmoxarifadoCatalogoClassificacao($this);
            $this->fkAlmoxarifadoCatalogoClassificacaoBloqueios->add($fkAlmoxarifadoCatalogoClassificacaoBloqueio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoCatalogoClassificacaoBloqueio
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoClassificacaoBloqueio $fkAlmoxarifadoCatalogoClassificacaoBloqueio
     */
    public function removeFkAlmoxarifadoCatalogoClassificacaoBloqueios(\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoClassificacaoBloqueio $fkAlmoxarifadoCatalogoClassificacaoBloqueio)
    {
        $this->fkAlmoxarifadoCatalogoClassificacaoBloqueios->removeElement($fkAlmoxarifadoCatalogoClassificacaoBloqueio);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoCatalogoClassificacaoBloqueios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoClassificacaoBloqueio
     */
    public function getFkAlmoxarifadoCatalogoClassificacaoBloqueios()
    {
        return $this->fkAlmoxarifadoCatalogoClassificacaoBloqueios;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoCatalogo
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Catalogo $fkAlmoxarifadoCatalogo
     * @return CatalogoClassificacao
     */
    public function setFkAlmoxarifadoCatalogo(\Urbem\CoreBundle\Entity\Almoxarifado\Catalogo $fkAlmoxarifadoCatalogo)
    {
        $this->codCatalogo = $fkAlmoxarifadoCatalogo->getCodCatalogo();
        $this->fkAlmoxarifadoCatalogo = $fkAlmoxarifadoCatalogo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoCatalogo
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\Catalogo
     */
    public function getFkAlmoxarifadoCatalogo()
    {
        return $this->fkAlmoxarifadoCatalogo;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (!is_null($this->fkAlmoxarifadoAtributoCatalogoClassificacoes)) {
            return (string) $this->descricao;
        }
        return 'Catálogo';
    }
}
