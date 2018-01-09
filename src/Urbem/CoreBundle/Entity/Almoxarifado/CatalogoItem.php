<?php

namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * CatalogoItem
 */
class CatalogoItem
{
    const PRIORIDADE_IMPRESCINDIVEL = 'imprescindivel';
    const PRIORIDADE_IMPORTANTE = 'importante';
    const PRIORIDADE_INTERMEDIARIA = 'intermediaria';
    const PRIORIDADE_MODERADA = 'moderada';
    const PRIORIDADE_POUCA_IMPORTANCIA = 'pouca-importancia';
    const PRIORIDADES_LIST = [
        self::PRIORIDADE_IMPRESCINDIVEL => 'Imprescindível',
        self::PRIORIDADE_IMPORTANTE => 'Importante',
        self::PRIORIDADE_INTERMEDIARIA => 'Importância Intermediária',
        self::PRIORIDADE_MODERADA => 'Moderada',
        self::PRIORIDADE_POUCA_IMPORTANCIA => 'Pouca Importância',
    ];

    /**
     * PK
     * @var integer
     */
    private $codItem;

    /**
     * @var integer
     */
    private $codCatalogo;

    /**
     * @var integer
     */
    private $codClassificacao;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * @var integer
     */
    private $codUnidade;

    /**
     * @var integer
     */
    private $codGrandeza;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var string
     */
    private $descricaoResumida;

    /**
     * @var boolean
     */
    private $ativo = true;

    /**
     * @var string
     */
    private $codItemExterno;

    /**
     * @var integer
     */
    private $material;

    /**
     * @var integer
     */
    private $classe;

    /**
     * @var string
     */
    private $descricaoIng;

    /**
     * @var string
     */
    private $descricaoEsp;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampInclusao;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampAlteracao;

    /**
     * @var string
     */
    private $prioridade;

    /**
     * @var bool
     */
    private $divisivel = false;

    /**
     * @var integer
     */
    private $codUnidadeCompra;

    /**
     * @var integer
     */
    private $codGrandezaCompra;

    /**
     * @var bool
     */
    private $desmembravel = false;

    /**
     * @var string
     */
    private $descricaoCompletaNomeArquivo;

    /**
     * @var string
     */
    private $foto;

    /**
     * @var string
     */
    private $descricaoFoto;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\ControleEstoque
     */
    private $fkAlmoxarifadoControleEstoque;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcemg\ArquivoItem
     */
    private $fkTcemgArquivoItem;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Frota\Item
     */
    private $fkFrotaItem;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoItem
     */
    private $fkAlmoxarifadoAtributoCatalogoItens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItem
     */
    private $fkAlmoxarifadoPedidoTransferenciaItens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\SolicitacaoItem
     */
    private $fkComprasSolicitacaoItens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoContaDespesaItem
     */
    private $fkContabilidadeConfiguracaoLancamentoContaDespesaItens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho
     */
    private $fkEmpenhoItemPreEmpenhos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ItemRegistroPrecos
     */
    private $fkTcemgItemRegistroPrecos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial
     */
    private $fkAlmoxarifadoLancamentoMateriais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\CotacaoItem
     */
    private $fkComprasCotacaoItens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoClassificacaoItemValor
     */
    private $fkAlmoxarifadoAtributoCatalogoClassificacaoItemValores;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoClassificacao
     */
    private $fkAlmoxarifadoCatalogoClassificacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\TipoItem
     */
    private $fkAlmoxarifadoTipoItem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\UnidadeMedida
     */
    private $fkAdministracaoUnidadeMedida;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\UnidadeMedida
     */
    private $fkAdministracaoUnidadeMedidaCompra;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAlmoxarifadoAtributoCatalogoItens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoPedidoTransferenciaItens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasSolicitacaoItens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadeConfiguracaoLancamentoContaDespesaItens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoItemPreEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgItemRegistroPrecos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoLancamentoMateriais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasCotacaoItens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoAtributoCatalogoClassificacaoItemValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestampInclusao = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK();
        $this->timestampAlteracao = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK();
    }

    /**
     * Set codItem
     *
     * @param integer $codItem
     * @return CatalogoItem
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
     * Set codCatalogo
     *
     * @param integer $codCatalogo
     * @return CatalogoItem
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
     * Set codClassificacao
     *
     * @param integer $codClassificacao
     * @return CatalogoItem
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return CatalogoItem
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set codUnidade
     *
     * @param integer $codUnidade
     * @return CatalogoItem
     */
    public function setCodUnidade($codUnidade)
    {
        $this->codUnidade = $codUnidade;
        return $this;
    }

    /**
     * Get codUnidade
     *
     * @return integer
     */
    public function getCodUnidade()
    {
        return $this->codUnidade;
    }

    /**
     * Set codGrandeza
     *
     * @param integer $codGrandeza
     * @return CatalogoItem
     */
    public function setCodGrandeza($codGrandeza)
    {
        $this->codGrandeza = $codGrandeza;
        return $this;
    }

    /**
     * Get codGrandeza
     *
     * @return integer
     */
    public function getCodGrandeza()
    {
        return $this->codGrandeza;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return CatalogoItem
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
     * Set descricaoResumida
     *
     * @param string $descricaoResumida
     * @return CatalogoItem
     */
    public function setDescricaoResumida($descricaoResumida)
    {
        $this->descricaoResumida = $descricaoResumida;
        return $this;
    }

    /**
     * Get descricaoResumida
     *
     * @return string
     */
    public function getDescricaoResumida()
    {
        return $this->descricaoResumida;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return CatalogoItem
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
        return $this;
    }

    /**
     * Get ativo
     *
     * @return boolean
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * Set codItemExterno
     *
     * @param string $codItemExterno
     * @return CatalogoItem
     */
    public function setCodItemExterno($codItemExterno = null)
    {
        $this->codItemExterno = $codItemExterno;
        return $this;
    }

    /**
     * Get codItemExterno
     *
     * @return string
     */
    public function getCodItemExterno()
    {
        return $this->codItemExterno;
    }

    /**
     * Set material
     *
     * @param integer $material
     * @return CatalogoItem
     */
    public function setMaterial($material = null)
    {
        $this->material = $material;
        return $this;
    }

    /**
     * Get material
     *
     * @return integer
     */
    public function getMaterial()
    {
        return $this->material;
    }

    /**
     * Set classe
     *
     * @param integer $classe
     * @return CatalogoItem
     */
    public function setClasse($classe = null)
    {
        $this->classe = $classe;
        return $this;
    }

    /**
     * Get classe
     *
     * @return integer
     */
    public function getClasse()
    {
        return $this->classe;
    }

    /**
     * Set descricaoIng
     *
     * @param string $descricaoIng
     * @return CatalogoItem
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
     * @return CatalogoItem
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
     * Set timestampInclusao
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampInclusao
     * @return CatalogoItem
     */
    public function setTimestampInclusao(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampInclusao)
    {
        $this->timestampInclusao = $timestampInclusao;
        return $this;
    }

    /**
     * Get timestampInclusao
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampInclusao()
    {
        return $this->timestampInclusao;
    }

    /**
     * Set timestampAlteracao
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampAlteracao
     * @return CatalogoItem
     */
    public function setTimestampAlteracao(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampAlteracao)
    {
        $this->timestampAlteracao = $timestampAlteracao;
        return $this;
    }

    /**
     * Get timestampAlteracao
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampAlteracao()
    {
        return $this->timestampAlteracao;
    }

    /**
     * Set prioridade
     *
     * @param string $prioridade
     * @return CatalogoItem
     */
    public function setPrioridade($prioridade)
    {
        $this->prioridade = $prioridade;

        return $this;
    }

    /**
     * Get prioridade
     *
     * @return string
     */
    public function getPrioridade()
    {
        return $this->prioridade;
    }

    /**
     * Set divisivel
     *
     * @param bool $divisivel
     * @return CatalogoItem
     */
    public function setDivisivel($divisivel)
    {
        $this->divisivel = $divisivel;

        return $this;
    }

    /**
     * Get divisivel
     *
     * @return bool
     */
    public function getDivisivel()
    {
        return $this->divisivel;
    }

    /**
     * Set codUnidadeCompra
     *
     * @param integer $codUnidadeCompra
     * @return CatalogoItem
     */
    public function setCodUnidadeCompra($codUnidadeCompra)
    {
        $this->codUnidadeCompra = $codUnidadeCompra;

        return $this;
    }

    /**
     * Get codUnidadeCompra
     *
     * @return integer
     */
    public function getCodUnidadeCompra()
    {
        return $this->codUnidadeCompra;
    }

    /**
     * Set codGrandezaCompra
     *
     * @param integer $codGrandezaCompra
     * @return CatalogoItem
     */
    public function setCodGrandezaCompra($codGrandezaCompra)
    {
        $this->codGrandezaCompra = $codGrandezaCompra;

        return $this;
    }

    /**
     * Get codGrandezaCompra
     *
     * @return integer
     */
    public function getCodGrandezaCompra()
    {
        return $this->codGrandezaCompra;
    }

    /**
     * Set desmembravel
     *
     * @param bool $desmembravel
     * @return CatalogoItem
     */
    public function setDesmembravel($desmembravel)
    {
        $this->desmembravel = $desmembravel;

        return $this;
    }

    /**
     * Get desmembravel
     *
     * @return bool
     */
    public function getDesmembravel()
    {
        return $this->desmembravel;
    }

    /**
     * Set descricaoCompletaNomeArquivo
     *
     * @param string $descricaoCompletaNomeArquivo
     * @return CatalogoItem
     */
    public function setDescricaoCompletaNomeArquivo($descricaoCompletaNomeArquivo)
    {
        $this->descricaoCompletaNomeArquivo = $descricaoCompletaNomeArquivo;

        return $this;
    }

    /**
     * Get descricaoCompletaNomeArquivo
     *
     * @return string
     */
    public function getDescricaoCompletaNomeArquivo()
    {
        return $this->descricaoCompletaNomeArquivo;
    }

    /**
     * Set foto
     *
     * @param string $foto
     * @return CatalogoItem
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;

        return $this;
    }

    /**
     * Get foto
     *
     * @return string
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * Set DescricaoFoto
     *
     * @param string $foto
     * @return CatalogoItem
     */
    public function setDescricaoFoto($descricaoFoto)
    {
        $this->descricaoFoto = $descricaoFoto;

        return $this;
    }

    /**
     * Get DescricaoFoto
     *
     * @return string
     */
    public function getDescricaoFoto()
    {
        return $this->descricaoFoto;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoAtributoCatalogoItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoItem $fkAlmoxarifadoAtributoCatalogoItem
     * @return CatalogoItem
     */
    public function addFkAlmoxarifadoAtributoCatalogoItens(\Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoItem $fkAlmoxarifadoAtributoCatalogoItem)
    {
        if (false === $this->fkAlmoxarifadoAtributoCatalogoItens->contains($fkAlmoxarifadoAtributoCatalogoItem)) {
            $fkAlmoxarifadoAtributoCatalogoItem->setFkAlmoxarifadoCatalogoItem($this);
            $this->fkAlmoxarifadoAtributoCatalogoItens->add($fkAlmoxarifadoAtributoCatalogoItem);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoAtributoCatalogoItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoItem $fkAlmoxarifadoAtributoCatalogoItem
     */
    public function removeFkAlmoxarifadoAtributoCatalogoItens(\Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoItem $fkAlmoxarifadoAtributoCatalogoItem)
    {
        $this->fkAlmoxarifadoAtributoCatalogoItens->removeElement($fkAlmoxarifadoAtributoCatalogoItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoAtributoCatalogoItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoItem
     */
    public function getFkAlmoxarifadoAtributoCatalogoItens()
    {
        return $this->fkAlmoxarifadoAtributoCatalogoItens;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoPedidoTransferenciaItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItem $fkAlmoxarifadoPedidoTransferenciaItem
     * @return CatalogoItem
     */
    public function addFkAlmoxarifadoPedidoTransferenciaItens(\Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItem $fkAlmoxarifadoPedidoTransferenciaItem)
    {
        if (false === $this->fkAlmoxarifadoPedidoTransferenciaItens->contains($fkAlmoxarifadoPedidoTransferenciaItem)) {
            $fkAlmoxarifadoPedidoTransferenciaItem->setFkAlmoxarifadoCatalogoItem($this);
            $this->fkAlmoxarifadoPedidoTransferenciaItens->add($fkAlmoxarifadoPedidoTransferenciaItem);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoPedidoTransferenciaItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItem $fkAlmoxarifadoPedidoTransferenciaItem
     */
    public function removeFkAlmoxarifadoPedidoTransferenciaItens(\Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItem $fkAlmoxarifadoPedidoTransferenciaItem)
    {
        $this->fkAlmoxarifadoPedidoTransferenciaItens->removeElement($fkAlmoxarifadoPedidoTransferenciaItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoPedidoTransferenciaItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItem
     */
    public function getFkAlmoxarifadoPedidoTransferenciaItens()
    {
        return $this->fkAlmoxarifadoPedidoTransferenciaItens;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasSolicitacaoItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoItem $fkComprasSolicitacaoItem
     * @return CatalogoItem
     */
    public function addFkComprasSolicitacaoItens(\Urbem\CoreBundle\Entity\Compras\SolicitacaoItem $fkComprasSolicitacaoItem)
    {
        if (false === $this->fkComprasSolicitacaoItens->contains($fkComprasSolicitacaoItem)) {
            $fkComprasSolicitacaoItem->setFkAlmoxarifadoCatalogoItem($this);
            $this->fkComprasSolicitacaoItens->add($fkComprasSolicitacaoItem);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasSolicitacaoItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoItem $fkComprasSolicitacaoItem
     */
    public function removeFkComprasSolicitacaoItens(\Urbem\CoreBundle\Entity\Compras\SolicitacaoItem $fkComprasSolicitacaoItem)
    {
        $this->fkComprasSolicitacaoItens->removeElement($fkComprasSolicitacaoItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasSolicitacaoItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\SolicitacaoItem
     */
    public function getFkComprasSolicitacaoItens()
    {
        return $this->fkComprasSolicitacaoItens;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeConfiguracaoLancamentoContaDespesaItem
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoContaDespesaItem $fkContabilidadeConfiguracaoLancamentoContaDespesaItem
     * @return CatalogoItem
     */
    public function addFkContabilidadeConfiguracaoLancamentoContaDespesaItens(\Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoContaDespesaItem $fkContabilidadeConfiguracaoLancamentoContaDespesaItem)
    {
        if (false === $this->fkContabilidadeConfiguracaoLancamentoContaDespesaItens->contains($fkContabilidadeConfiguracaoLancamentoContaDespesaItem)) {
            $fkContabilidadeConfiguracaoLancamentoContaDespesaItem->setFkAlmoxarifadoCatalogoItem($this);
            $this->fkContabilidadeConfiguracaoLancamentoContaDespesaItens->add($fkContabilidadeConfiguracaoLancamentoContaDespesaItem);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeConfiguracaoLancamentoContaDespesaItem
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoContaDespesaItem $fkContabilidadeConfiguracaoLancamentoContaDespesaItem
     */
    public function removeFkContabilidadeConfiguracaoLancamentoContaDespesaItens(\Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoContaDespesaItem $fkContabilidadeConfiguracaoLancamentoContaDespesaItem)
    {
        $this->fkContabilidadeConfiguracaoLancamentoContaDespesaItens->removeElement($fkContabilidadeConfiguracaoLancamentoContaDespesaItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeConfiguracaoLancamentoContaDespesaItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\ConfiguracaoLancamentoContaDespesaItem
     */
    public function getFkContabilidadeConfiguracaoLancamentoContaDespesaItens()
    {
        return $this->fkContabilidadeConfiguracaoLancamentoContaDespesaItens;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoItemPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho $fkEmpenhoItemPreEmpenho
     * @return CatalogoItem
     */
    public function addFkEmpenhoItemPreEmpenhos(\Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho $fkEmpenhoItemPreEmpenho)
    {
        if (false === $this->fkEmpenhoItemPreEmpenhos->contains($fkEmpenhoItemPreEmpenho)) {
            $fkEmpenhoItemPreEmpenho->setFkAlmoxarifadoCatalogoItem($this);
            $this->fkEmpenhoItemPreEmpenhos->add($fkEmpenhoItemPreEmpenho);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoItemPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho $fkEmpenhoItemPreEmpenho
     */
    public function removeFkEmpenhoItemPreEmpenhos(\Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho $fkEmpenhoItemPreEmpenho)
    {
        $this->fkEmpenhoItemPreEmpenhos->removeElement($fkEmpenhoItemPreEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoItemPreEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho
     */
    public function getFkEmpenhoItemPreEmpenhos()
    {
        return $this->fkEmpenhoItemPreEmpenhos;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgItemRegistroPrecos
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ItemRegistroPrecos $fkTcemgItemRegistroPrecos
     * @return CatalogoItem
     */
    public function addFkTcemgItemRegistroPrecos(\Urbem\CoreBundle\Entity\Tcemg\ItemRegistroPrecos $fkTcemgItemRegistroPrecos)
    {
        if (false === $this->fkTcemgItemRegistroPrecos->contains($fkTcemgItemRegistroPrecos)) {
            $fkTcemgItemRegistroPrecos->setFkAlmoxarifadoCatalogoItem($this);
            $this->fkTcemgItemRegistroPrecos->add($fkTcemgItemRegistroPrecos);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgItemRegistroPrecos
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ItemRegistroPrecos $fkTcemgItemRegistroPrecos
     */
    public function removeFkTcemgItemRegistroPrecos(\Urbem\CoreBundle\Entity\Tcemg\ItemRegistroPrecos $fkTcemgItemRegistroPrecos)
    {
        $this->fkTcemgItemRegistroPrecos->removeElement($fkTcemgItemRegistroPrecos);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgItemRegistroPrecos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ItemRegistroPrecos
     */
    public function getFkTcemgItemRegistroPrecos()
    {
        return $this->fkTcemgItemRegistroPrecos;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoLancamentoMaterial
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial $fkAlmoxarifadoLancamentoMaterial
     * @return CatalogoItem
     */
    public function addFkAlmoxarifadoLancamentoMateriais(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial $fkAlmoxarifadoLancamentoMaterial)
    {
        if (false === $this->fkAlmoxarifadoLancamentoMateriais->contains($fkAlmoxarifadoLancamentoMaterial)) {
            $fkAlmoxarifadoLancamentoMaterial->setFkAlmoxarifadoCatalogoItem($this);
            $this->fkAlmoxarifadoLancamentoMateriais->add($fkAlmoxarifadoLancamentoMaterial);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoLancamentoMaterial
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial $fkAlmoxarifadoLancamentoMaterial
     */
    public function removeFkAlmoxarifadoLancamentoMateriais(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial $fkAlmoxarifadoLancamentoMaterial)
    {
        $this->fkAlmoxarifadoLancamentoMateriais->removeElement($fkAlmoxarifadoLancamentoMaterial);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoLancamentoMateriais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial
     */
    public function getFkAlmoxarifadoLancamentoMateriais()
    {
        return $this->fkAlmoxarifadoLancamentoMateriais;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasCotacaoItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\CotacaoItem $fkComprasCotacaoItem
     * @return CatalogoItem
     */
    public function addFkComprasCotacaoItens(\Urbem\CoreBundle\Entity\Compras\CotacaoItem $fkComprasCotacaoItem)
    {
        if (false === $this->fkComprasCotacaoItens->contains($fkComprasCotacaoItem)) {
            $fkComprasCotacaoItem->setFkAlmoxarifadoCatalogoItem($this);
            $this->fkComprasCotacaoItens->add($fkComprasCotacaoItem);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasCotacaoItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\CotacaoItem $fkComprasCotacaoItem
     */
    public function removeFkComprasCotacaoItens(\Urbem\CoreBundle\Entity\Compras\CotacaoItem $fkComprasCotacaoItem)
    {
        $this->fkComprasCotacaoItens->removeElement($fkComprasCotacaoItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasCotacaoItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\CotacaoItem
     */
    public function getFkComprasCotacaoItens()
    {
        return $this->fkComprasCotacaoItens;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoCatalogoClassificacao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoClassificacao $fkAlmoxarifadoCatalogoClassificacao
     * @return CatalogoItem
     */
    public function setFkAlmoxarifadoCatalogoClassificacao(\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoClassificacao $fkAlmoxarifadoCatalogoClassificacao)
    {
        $this->codClassificacao = $fkAlmoxarifadoCatalogoClassificacao->getCodClassificacao();
        $this->codCatalogo = $fkAlmoxarifadoCatalogoClassificacao->getCodCatalogo();
        $this->fkAlmoxarifadoCatalogoClassificacao = $fkAlmoxarifadoCatalogoClassificacao;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoCatalogoClassificacao
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoClassificacao
     */
    public function getFkAlmoxarifadoCatalogoClassificacao()
    {
        return $this->fkAlmoxarifadoCatalogoClassificacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoTipoItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\TipoItem $fkAlmoxarifadoTipoItem
     * @return CatalogoItem
     */
    public function setFkAlmoxarifadoTipoItem(\Urbem\CoreBundle\Entity\Almoxarifado\TipoItem $fkAlmoxarifadoTipoItem)
    {
        $this->codTipo = $fkAlmoxarifadoTipoItem->getCodTipo();
        $this->fkAlmoxarifadoTipoItem = $fkAlmoxarifadoTipoItem;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoTipoItem
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\TipoItem
     */
    public function getFkAlmoxarifadoTipoItem()
    {
        return $this->fkAlmoxarifadoTipoItem;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUnidadeMedida
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\UnidadeMedida $fkAdministracaoUnidadeMedida
     * @return CatalogoItem
     */
    public function setFkAdministracaoUnidadeMedida(\Urbem\CoreBundle\Entity\Administracao\UnidadeMedida $fkAdministracaoUnidadeMedida)
    {
        $this->codUnidade = $fkAdministracaoUnidadeMedida->getCodUnidade();
        $this->codGrandeza = $fkAdministracaoUnidadeMedida->getCodGrandeza();
        $this->fkAdministracaoUnidadeMedida = $fkAdministracaoUnidadeMedida;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoUnidadeMedida
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\UnidadeMedida
     */
    public function getFkAdministracaoUnidadeMedida()
    {
        return $this->fkAdministracaoUnidadeMedida;
    }

    /**
     * OneToOne (inverse side)
     * Set AlmoxarifadoControleEstoque
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\ControleEstoque $fkAlmoxarifadoControleEstoque
     * @return CatalogoItem
     */
    public function setFkAlmoxarifadoControleEstoque(\Urbem\CoreBundle\Entity\Almoxarifado\ControleEstoque $fkAlmoxarifadoControleEstoque)
    {
        $fkAlmoxarifadoControleEstoque->setFkAlmoxarifadoCatalogoItem($this);
        $this->fkAlmoxarifadoControleEstoque = $fkAlmoxarifadoControleEstoque;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkAlmoxarifadoControleEstoque
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\ControleEstoque
     */
    public function getFkAlmoxarifadoControleEstoque()
    {
        return $this->fkAlmoxarifadoControleEstoque;
    }

    /**
     * OneToOne (inverse side)
     * Set TcemgArquivoItem
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ArquivoItem $fkTcemgArquivoItem
     * @return CatalogoItem
     */
    public function setFkTcemgArquivoItem(\Urbem\CoreBundle\Entity\Tcemg\ArquivoItem $fkTcemgArquivoItem)
    {
        $fkTcemgArquivoItem->setFkAlmoxarifadoCatalogoItem($this);
        $this->fkTcemgArquivoItem = $fkTcemgArquivoItem;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcemgArquivoItem
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\ArquivoItem
     */
    public function getFkTcemgArquivoItem()
    {
        return $this->fkTcemgArquivoItem;
    }

    /**
     * OneToOne (inverse side)
     * Set FrotaItem
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Item $fkFrotaItem
     * @return CatalogoItem
     */
    public function setFkFrotaItem(\Urbem\CoreBundle\Entity\Frota\Item $fkFrotaItem)
    {
        $fkFrotaItem->setFkAlmoxarifadoCatalogoItem($this);
        $this->fkFrotaItem = $fkFrotaItem;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFrotaItem
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Item
     */
    public function getFkFrotaItem()
    {
        return $this->fkFrotaItem;
    }

    /**
     * @return bool
     */
    public function isPerecivel()
    {
        return 2 == $this->fkAlmoxarifadoTipoItem->getCodTipo();
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoAtributoCatalogoClassificacaoItemValor
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoClassificacaoItemValor $fkAlmoxarifadoAtributoCatalogoClassificacaoItemValor
     * @return CatalogoItem
     */
    public function addFkAlmoxarifadoAtributoCatalogoClassificacaoItemValores(\Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoClassificacaoItemValor $fkAlmoxarifadoAtributoCatalogoClassificacaoItemValor)
    {
        if (false === $this->fkAlmoxarifadoAtributoCatalogoClassificacaoItemValores->contains($fkAlmoxarifadoAtributoCatalogoClassificacaoItemValor)) {
            $fkAlmoxarifadoAtributoCatalogoClassificacaoItemValor->setFkAlmoxarifadoCatalogoItem($this);
            $this->fkAlmoxarifadoAtributoCatalogoClassificacaoItemValores->add($fkAlmoxarifadoAtributoCatalogoClassificacaoItemValor);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoAtributoCatalogoClassificacaoItemValor
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoClassificacaoItemValor $fkAlmoxarifadoAtributoCatalogoClassificacaoItemValor
     */
    public function removeFkAlmoxarifadoAtributoCatalogoClassificacaoItemValores(\Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoClassificacaoItemValor $fkAlmoxarifadoAtributoCatalogoClassificacaoItemValor)
    {
        $this->fkAlmoxarifadoAtributoCatalogoClassificacaoItemValores->removeElement($fkAlmoxarifadoAtributoCatalogoClassificacaoItemValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoAtributoCatalogoClassificacaoItemValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoClassificacaoItemValor
     */
    public function getFkAlmoxarifadoAtributoCatalogoClassificacaoItemValores()
    {
        return $this->fkAlmoxarifadoAtributoCatalogoClassificacaoItemValores;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUnidadeMedidaCompra
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\UnidadeMedida $fkAdministracaoUnidadeMedidaCompra
     * @return CatalogoItem
     */
    public function setFkAdministracaoUnidadeMedidaCompra(\Urbem\CoreBundle\Entity\Administracao\UnidadeMedida $fkAdministracaoUnidadeMedidaCompra)
    {
        $this->codUnidadeCompra = $fkAdministracaoUnidadeMedidaCompra->getCodUnidade();
        $this->codGrandezaCompra = $fkAdministracaoUnidadeMedidaCompra->getCodGrandeza();
        $this->fkAdministracaoUnidadeMedidaCompra = $fkAdministracaoUnidadeMedidaCompra;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoUnidadeMedidaCompra
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\UnidadeMedida
     */
    public function getFkAdministracaoUnidadeMedidaCompra()
    {
        return $this->fkAdministracaoUnidadeMedidaCompra;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s (%s)', $this->codItem, trim($this->descricao), $this->fkAdministracaoUnidadeMedida);
    }
}
