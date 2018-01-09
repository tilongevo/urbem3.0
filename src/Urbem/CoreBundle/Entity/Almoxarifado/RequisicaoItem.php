<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * RequisicaoItem
 */
class RequisicaoItem
{
    const SITUACAO_PENDENTE_AUTORIZACAO = 0;
    const SITUACAO_AUTORIZADA_TOTAL = 1;
    const SITUACAO_AUTORIZADA_PARCIAL = 2;
    const SITUACAO_RECUSADA = 3;

    /**
     * PK
     * @var integer
     */
    private $codAlmoxarifado;

    /**
     * PK
     * @var integer
     */
    private $codRequisicao;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codCentro;

    /**
     * PK
     * @var integer
     */
    private $codMarca;

    /**
     * PK
     * @var integer
     */
    private $codItem;

    /**
     * @var integer
     */
    private $quantidade;

    /**
     * @var integer
     */
    private $quantidadeAprovada = 0;

    /**
     * @var integer
     */
    private $quantidadeRecusada = 0;

    /**
     * @var integer
     */
    private $quantidadePendente = 0;

    /**
     * @var string
     */
    private $observacao;

    /**
     * @var integer
     */
    private $situacao = 0;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\AtributoRequisicaoItem
     */
    private $fkAlmoxarifadoAtributoRequisicaoItens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoRequisicao
     */
    private $fkAlmoxarifadoLancamentoRequisicoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItensAnulacao
     */
    private $fkAlmoxarifadoRequisicaoItensAnulacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial
     */
    private $fkAlmoxarifadoEstoqueMaterial;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\Requisicao
     */
    private $fkAlmoxarifadoRequisicao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAlmoxarifadoAtributoRequisicaoItens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoLancamentoRequisicoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoRequisicaoItensAnulacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codAlmoxarifado
     *
     * @param integer $codAlmoxarifado
     * @return RequisicaoItem
     */
    public function setCodAlmoxarifado($codAlmoxarifado)
    {
        $this->codAlmoxarifado = $codAlmoxarifado;
        return $this;
    }

    /**
     * Get codAlmoxarifado
     *
     * @return integer
     */
    public function getCodAlmoxarifado()
    {
        return $this->codAlmoxarifado;
    }

    /**
     * Set codRequisicao
     *
     * @param integer $codRequisicao
     * @return RequisicaoItem
     */
    public function setCodRequisicao($codRequisicao)
    {
        $this->codRequisicao = $codRequisicao;
        return $this;
    }

    /**
     * Get codRequisicao
     *
     * @return integer
     */
    public function getCodRequisicao()
    {
        return $this->codRequisicao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return RequisicaoItem
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
     * Set codCentro
     *
     * @param integer $codCentro
     * @return RequisicaoItem
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
     * Set codMarca
     *
     * @param integer $codMarca
     * @return RequisicaoItem
     */
    public function setCodMarca($codMarca)
    {
        $this->codMarca = $codMarca;
        return $this;
    }

    /**
     * Get codMarca
     *
     * @return integer
     */
    public function getCodMarca()
    {
        return $this->codMarca;
    }

    /**
     * Set codItem
     *
     * @param integer $codItem
     * @return RequisicaoItem
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
     * Set quantidade
     *
     * @param integer $quantidade
     * @return RequisicaoItem
     */
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
        return $this;
    }

    /**
     * Get quantidade
     *
     * @return integer
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * Set quantidadeAprovada
     *
     * @param integer $quantidadeAprovada
     * @return RequisicaoItem
     */
    public function setQuantidadeAprovada($quantidadeAprovada)
    {
        $this->quantidadeAprovada = $quantidadeAprovada;
        return $this;
    }

    /**
     * Get quantidadeAprovada
     *
     * @return integer
     */
    public function getQuantidadeAprovada()
    {
        return $this->quantidadeAprovada;
    }

    /**
     * Set quantidadeRecusada
     *
     * @param integer $quantidadeRecusada
     * @return RequisicaoItem
     */
    public function setQuantidadeRecusada($quantidadeRecusada)
    {
        $this->quantidadeRecusada = $quantidadeRecusada;
        return $this;
    }

    /**
     * Get quantidadeRecusada
     *
     * @return integer
     */
    public function getQuantidadeRecusada()
    {
        return $this->quantidadeRecusada;
    }

    /**
     * Set quantidadePendente
     *
     * @param integer $quantidadePendente
     * @return RequisicaoItem
     */
    public function setQuantidadePendente($quantidadePendente)
    {
        $this->quantidadePendente = $quantidadePendente;
        return $this;
    }

    /**
     * Get quantidadePendente
     *
     * @return integer
     */
    public function getQuantidadePendente()
    {
        return $this->quantidadePendente;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return RequisicaoItem
     */
    public function setObservacao($observacao = null)
    {
        $this->observacao = $observacao;
        return $this;
    }

    /**
     * Get observacao
     *
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * Get situacao
     *
     * @return integer
     */
    public function getSituacao()
    {
        return $this->situacao;
    }

    /**
     * Set observacao
     *
     * @param integer $situacao
     * @return RequisicaoItem
     */
    public function setSituacao($situacao)
    {
        $this->situacao = $situacao;
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoAtributoRequisicaoItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoRequisicaoItem $fkAlmoxarifadoAtributoRequisicaoItem
     * @return RequisicaoItem
     */
    public function addFkAlmoxarifadoAtributoRequisicaoItens(\Urbem\CoreBundle\Entity\Almoxarifado\AtributoRequisicaoItem $fkAlmoxarifadoAtributoRequisicaoItem)
    {
        if (false === $this->fkAlmoxarifadoAtributoRequisicaoItens->contains($fkAlmoxarifadoAtributoRequisicaoItem)) {
            $fkAlmoxarifadoAtributoRequisicaoItem->setFkAlmoxarifadoRequisicaoItem($this);
            $this->fkAlmoxarifadoAtributoRequisicaoItens->add($fkAlmoxarifadoAtributoRequisicaoItem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoAtributoRequisicaoItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoRequisicaoItem $fkAlmoxarifadoAtributoRequisicaoItem
     */
    public function removeFkAlmoxarifadoAtributoRequisicaoItens(\Urbem\CoreBundle\Entity\Almoxarifado\AtributoRequisicaoItem $fkAlmoxarifadoAtributoRequisicaoItem)
    {
        $this->fkAlmoxarifadoAtributoRequisicaoItens->removeElement($fkAlmoxarifadoAtributoRequisicaoItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoAtributoRequisicaoItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\AtributoRequisicaoItem
     */
    public function getFkAlmoxarifadoAtributoRequisicaoItens()
    {
        return $this->fkAlmoxarifadoAtributoRequisicaoItens;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoLancamentoRequisicao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoRequisicao $fkAlmoxarifadoLancamentoRequisicao
     * @return RequisicaoItem
     */
    public function addFkAlmoxarifadoLancamentoRequisicoes(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoRequisicao $fkAlmoxarifadoLancamentoRequisicao)
    {
        if (false === $this->fkAlmoxarifadoLancamentoRequisicoes->contains($fkAlmoxarifadoLancamentoRequisicao)) {
            $fkAlmoxarifadoLancamentoRequisicao->setFkAlmoxarifadoRequisicaoItem($this);
            $this->fkAlmoxarifadoLancamentoRequisicoes->add($fkAlmoxarifadoLancamentoRequisicao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoLancamentoRequisicao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoRequisicao $fkAlmoxarifadoLancamentoRequisicao
     */
    public function removeFkAlmoxarifadoLancamentoRequisicoes(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoRequisicao $fkAlmoxarifadoLancamentoRequisicao)
    {
        $this->fkAlmoxarifadoLancamentoRequisicoes->removeElement($fkAlmoxarifadoLancamentoRequisicao);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoLancamentoRequisicoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoRequisicao
     */
    public function getFkAlmoxarifadoLancamentoRequisicoes()
    {
        return $this->fkAlmoxarifadoLancamentoRequisicoes;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoRequisicaoItensAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItensAnulacao $fkAlmoxarifadoRequisicaoItensAnulacao
     * @return RequisicaoItem
     */
    public function addFkAlmoxarifadoRequisicaoItensAnulacoes(\Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItensAnulacao $fkAlmoxarifadoRequisicaoItensAnulacao)
    {
        if (false === $this->fkAlmoxarifadoRequisicaoItensAnulacoes->contains($fkAlmoxarifadoRequisicaoItensAnulacao)) {
            $fkAlmoxarifadoRequisicaoItensAnulacao->setFkAlmoxarifadoRequisicaoItem($this);
            $this->fkAlmoxarifadoRequisicaoItensAnulacoes->add($fkAlmoxarifadoRequisicaoItensAnulacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoRequisicaoItensAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItensAnulacao $fkAlmoxarifadoRequisicaoItensAnulacao
     */
    public function removeFkAlmoxarifadoRequisicaoItensAnulacoes(\Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItensAnulacao $fkAlmoxarifadoRequisicaoItensAnulacao)
    {
        $this->fkAlmoxarifadoRequisicaoItensAnulacoes->removeElement($fkAlmoxarifadoRequisicaoItensAnulacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoRequisicaoItensAnulacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItensAnulacao
     */
    public function getFkAlmoxarifadoRequisicaoItensAnulacoes()
    {
        return $this->fkAlmoxarifadoRequisicaoItensAnulacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoEstoqueMaterial
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial $fkAlmoxarifadoEstoqueMaterial
     * @return RequisicaoItem
     */
    public function setFkAlmoxarifadoEstoqueMaterial(\Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial $fkAlmoxarifadoEstoqueMaterial)
    {
        $this->codItem = $fkAlmoxarifadoEstoqueMaterial->getCodItem();
        $this->codMarca = $fkAlmoxarifadoEstoqueMaterial->getCodMarca();
        $this->codAlmoxarifado = $fkAlmoxarifadoEstoqueMaterial->getCodAlmoxarifado();
        $this->codCentro = $fkAlmoxarifadoEstoqueMaterial->getCodCentro();
        $this->fkAlmoxarifadoEstoqueMaterial = $fkAlmoxarifadoEstoqueMaterial;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoEstoqueMaterial
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial
     */
    public function getFkAlmoxarifadoEstoqueMaterial()
    {
        return $this->fkAlmoxarifadoEstoqueMaterial;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoRequisicao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Requisicao $fkAlmoxarifadoRequisicao
     * @return RequisicaoItem
     */
    public function setFkAlmoxarifadoRequisicao(\Urbem\CoreBundle\Entity\Almoxarifado\Requisicao $fkAlmoxarifadoRequisicao)
    {
        $this->exercicio = $fkAlmoxarifadoRequisicao->getExercicio();
        $this->codRequisicao = $fkAlmoxarifadoRequisicao->getCodRequisicao();
        $this->codAlmoxarifado = $fkAlmoxarifadoRequisicao->getCodAlmoxarifado();
        $this->fkAlmoxarifadoRequisicao = $fkAlmoxarifadoRequisicao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoRequisicao
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\Requisicao
     */
    public function getFkAlmoxarifadoRequisicao()
    {
        return $this->fkAlmoxarifadoRequisicao;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $objectToString = 'Item da Requisição';

        if (false == is_null($this->codItem)) {
            $objectToString .= " {$this->codItem}";
        }

        return (string) $objectToString;
    }
}
