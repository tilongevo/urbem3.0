<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * ItemRegistroPrecos
 */
class ItemRegistroPrecos
{
    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $numeroRegistroPrecos;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * PK
     * @var integer
     */
    private $codItem;

    /**
     * PK
     * @var integer
     */
    private $cgmFornecedor;

    /**
     * PK
     * @var boolean
     */
    private $interno;

    /**
     * PK
     * @var integer
     */
    private $numcgmGerenciador;

    /**
     * @var integer
     */
    private $numItem;

    /**
     * @var \DateTime
     */
    private $dataCotacao;

    /**
     * @var integer
     */
    private $vlCotacaoPrecoUnitario;

    /**
     * @var integer
     */
    private $quantidadeCotacao;

    /**
     * @var integer
     */
    private $precoUnitario;

    /**
     * @var integer
     */
    private $quantidadeLicitada;

    /**
     * @var integer
     */
    private $quantidadeAderida;

    /**
     * @var integer
     */
    private $percentualDesconto;

    /**
     * @var integer
     */
    private $ordemClassificacaoFornecedor;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosOrgaoItem
     */
    private $fkTcemgRegistroPrecosOrgaoItens;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcemg\LoteRegistroPrecos
     */
    private $fkTcemgLoteRegistroPrecos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem
     */
    private $fkAlmoxarifadoCatalogoItem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcemgRegistroPrecosOrgaoItens = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return ItemRegistroPrecos
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
     * Set numeroRegistroPrecos
     *
     * @param integer $numeroRegistroPrecos
     * @return ItemRegistroPrecos
     */
    public function setNumeroRegistroPrecos($numeroRegistroPrecos)
    {
        $this->numeroRegistroPrecos = $numeroRegistroPrecos;
        return $this;
    }

    /**
     * Get numeroRegistroPrecos
     *
     * @return integer
     */
    public function getNumeroRegistroPrecos()
    {
        return $this->numeroRegistroPrecos;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ItemRegistroPrecos
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
     * Set codLote
     *
     * @param integer $codLote
     * @return ItemRegistroPrecos
     */
    public function setCodLote($codLote)
    {
        $this->codLote = $codLote;
        return $this;
    }

    /**
     * Get codLote
     *
     * @return integer
     */
    public function getCodLote()
    {
        return $this->codLote;
    }

    /**
     * Set codItem
     *
     * @param integer $codItem
     * @return ItemRegistroPrecos
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
     * Set cgmFornecedor
     *
     * @param integer $cgmFornecedor
     * @return ItemRegistroPrecos
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
     * Set interno
     *
     * @param boolean $interno
     * @return ItemRegistroPrecos
     */
    public function setInterno($interno)
    {
        $this->interno = $interno;
        return $this;
    }

    /**
     * Get interno
     *
     * @return boolean
     */
    public function getInterno()
    {
        return $this->interno;
    }

    /**
     * Set numcgmGerenciador
     *
     * @param integer $numcgmGerenciador
     * @return ItemRegistroPrecos
     */
    public function setNumcgmGerenciador($numcgmGerenciador)
    {
        $this->numcgmGerenciador = $numcgmGerenciador;
        return $this;
    }

    /**
     * Get numcgmGerenciador
     *
     * @return integer
     */
    public function getNumcgmGerenciador()
    {
        return $this->numcgmGerenciador;
    }

    /**
     * Set numItem
     *
     * @param integer $numItem
     * @return ItemRegistroPrecos
     */
    public function setNumItem($numItem)
    {
        $this->numItem = $numItem;
        return $this;
    }

    /**
     * Get numItem
     *
     * @return integer
     */
    public function getNumItem()
    {
        return $this->numItem;
    }

    /**
     * Set dataCotacao
     *
     * @param \DateTime $dataCotacao
     * @return ItemRegistroPrecos
     */
    public function setDataCotacao(\DateTime $dataCotacao = null)
    {
        $this->dataCotacao = $dataCotacao;
        return $this;
    }

    /**
     * Get dataCotacao
     *
     * @return \DateTime
     */
    public function getDataCotacao()
    {
        return $this->dataCotacao;
    }

    /**
     * Set vlCotacaoPrecoUnitario
     *
     * @param integer $vlCotacaoPrecoUnitario
     * @return ItemRegistroPrecos
     */
    public function setVlCotacaoPrecoUnitario($vlCotacaoPrecoUnitario)
    {
        $this->vlCotacaoPrecoUnitario = $vlCotacaoPrecoUnitario;
        return $this;
    }

    /**
     * Get vlCotacaoPrecoUnitario
     *
     * @return integer
     */
    public function getVlCotacaoPrecoUnitario()
    {
        return $this->vlCotacaoPrecoUnitario;
    }

    /**
     * Set quantidadeCotacao
     *
     * @param integer $quantidadeCotacao
     * @return ItemRegistroPrecos
     */
    public function setQuantidadeCotacao($quantidadeCotacao)
    {
        $this->quantidadeCotacao = $quantidadeCotacao;
        return $this;
    }

    /**
     * Get quantidadeCotacao
     *
     * @return integer
     */
    public function getQuantidadeCotacao()
    {
        return $this->quantidadeCotacao;
    }

    /**
     * Set precoUnitario
     *
     * @param integer $precoUnitario
     * @return ItemRegistroPrecos
     */
    public function setPrecoUnitario($precoUnitario)
    {
        $this->precoUnitario = $precoUnitario;
        return $this;
    }

    /**
     * Get precoUnitario
     *
     * @return integer
     */
    public function getPrecoUnitario()
    {
        return $this->precoUnitario;
    }

    /**
     * Set quantidadeLicitada
     *
     * @param integer $quantidadeLicitada
     * @return ItemRegistroPrecos
     */
    public function setQuantidadeLicitada($quantidadeLicitada)
    {
        $this->quantidadeLicitada = $quantidadeLicitada;
        return $this;
    }

    /**
     * Get quantidadeLicitada
     *
     * @return integer
     */
    public function getQuantidadeLicitada()
    {
        return $this->quantidadeLicitada;
    }

    /**
     * Set quantidadeAderida
     *
     * @param integer $quantidadeAderida
     * @return ItemRegistroPrecos
     */
    public function setQuantidadeAderida($quantidadeAderida)
    {
        $this->quantidadeAderida = $quantidadeAderida;
        return $this;
    }

    /**
     * Get quantidadeAderida
     *
     * @return integer
     */
    public function getQuantidadeAderida()
    {
        return $this->quantidadeAderida;
    }

    /**
     * Set percentualDesconto
     *
     * @param integer $percentualDesconto
     * @return ItemRegistroPrecos
     */
    public function setPercentualDesconto($percentualDesconto)
    {
        $this->percentualDesconto = $percentualDesconto;
        return $this;
    }

    /**
     * Get percentualDesconto
     *
     * @return integer
     */
    public function getPercentualDesconto()
    {
        return $this->percentualDesconto;
    }

    /**
     * Set ordemClassificacaoFornecedor
     *
     * @param integer $ordemClassificacaoFornecedor
     * @return ItemRegistroPrecos
     */
    public function setOrdemClassificacaoFornecedor($ordemClassificacaoFornecedor)
    {
        $this->ordemClassificacaoFornecedor = $ordemClassificacaoFornecedor;
        return $this;
    }

    /**
     * Get ordemClassificacaoFornecedor
     *
     * @return integer
     */
    public function getOrdemClassificacaoFornecedor()
    {
        return $this->ordemClassificacaoFornecedor;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgRegistroPrecosOrgaoItem
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosOrgaoItem $fkTcemgRegistroPrecosOrgaoItem
     * @return ItemRegistroPrecos
     */
    public function addFkTcemgRegistroPrecosOrgaoItens(\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosOrgaoItem $fkTcemgRegistroPrecosOrgaoItem)
    {
        if (false === $this->fkTcemgRegistroPrecosOrgaoItens->contains($fkTcemgRegistroPrecosOrgaoItem)) {
            $fkTcemgRegistroPrecosOrgaoItem->setFkTcemgItemRegistroPrecos($this);
            $this->fkTcemgRegistroPrecosOrgaoItens->add($fkTcemgRegistroPrecosOrgaoItem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgRegistroPrecosOrgaoItem
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosOrgaoItem $fkTcemgRegistroPrecosOrgaoItem
     */
    public function removeFkTcemgRegistroPrecosOrgaoItens(\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosOrgaoItem $fkTcemgRegistroPrecosOrgaoItem)
    {
        $this->fkTcemgRegistroPrecosOrgaoItens->removeElement($fkTcemgRegistroPrecosOrgaoItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgRegistroPrecosOrgaoItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\RegistroPrecosOrgaoItem
     */
    public function getFkTcemgRegistroPrecosOrgaoItens()
    {
        return $this->fkTcemgRegistroPrecosOrgaoItens;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcemgLoteRegistroPrecos
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\LoteRegistroPrecos $fkTcemgLoteRegistroPrecos
     * @return ItemRegistroPrecos
     */
    public function setFkTcemgLoteRegistroPrecos(\Urbem\CoreBundle\Entity\Tcemg\LoteRegistroPrecos $fkTcemgLoteRegistroPrecos)
    {
        $this->codEntidade = $fkTcemgLoteRegistroPrecos->getCodEntidade();
        $this->numeroRegistroPrecos = $fkTcemgLoteRegistroPrecos->getNumeroRegistroPrecos();
        $this->exercicio = $fkTcemgLoteRegistroPrecos->getExercicio();
        $this->codLote = $fkTcemgLoteRegistroPrecos->getCodLote();
        $this->interno = $fkTcemgLoteRegistroPrecos->getInterno();
        $this->numcgmGerenciador = $fkTcemgLoteRegistroPrecos->getNumcgmGerenciador();
        $this->fkTcemgLoteRegistroPrecos = $fkTcemgLoteRegistroPrecos;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgLoteRegistroPrecos
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\LoteRegistroPrecos
     */
    public function getFkTcemgLoteRegistroPrecos()
    {
        return $this->fkTcemgLoteRegistroPrecos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoCatalogoItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem $fkAlmoxarifadoCatalogoItem
     * @return ItemRegistroPrecos
     */
    public function setFkAlmoxarifadoCatalogoItem(\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem $fkAlmoxarifadoCatalogoItem)
    {
        $this->codItem = $fkAlmoxarifadoCatalogoItem->getCodItem();
        $this->fkAlmoxarifadoCatalogoItem = $fkAlmoxarifadoCatalogoItem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoCatalogoItem
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem
     */
    public function getFkAlmoxarifadoCatalogoItem()
    {
        return $this->fkAlmoxarifadoCatalogoItem;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return ItemRegistroPrecos
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->cgmFornecedor = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }
}
