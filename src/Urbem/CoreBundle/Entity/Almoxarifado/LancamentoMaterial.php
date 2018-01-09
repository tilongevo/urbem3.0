<?php

namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * LancamentoMaterial
 */
class LancamentoMaterial
{
    /**
     * PK
     * @var integer
     */
    private $codLancamento;

    /**
     * PK
     * @var integer
     */
    private $codItem;

    /**
     * PK
     * @var integer
     */
    private $codMarca;

    /**
     * PK
     * @var integer
     */
    private $codAlmoxarifado;

    /**
     * PK
     * @var integer
     */
    private $codCentro;

    /**
     * @var string
     */
    private $exercicioLancamento;

    /**
     * @var integer
     */
    private $numLancamento;

    /**
     * @var integer
     */
    private $codNatureza;

    /**
     * @var string
     */
    private $tipoNatureza;

    /**
     * @var integer
     */
    private $quantidade;

    /**
     * @var string
     */
    private $complemento;

    /**
     * @var integer
     */
    private $valorMercado = 0;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\DoacaoEmprestimo
     */
    private $fkAlmoxarifadoDoacaoEmprestimo;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoAutorizacao
     */
    private $fkAlmoxarifadoLancamentoAutorizacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoManutencaoFrota
     */
    private $fkAlmoxarifadoLancamentoManutencaoFrota;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoPerecivel
     */
    private $fkAlmoxarifadoLancamentoPerecivel;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\AtributoEstoqueMaterialValor
     */
    private $fkAlmoxarifadoAtributoEstoqueMaterialValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoBem
     */
    private $fkAlmoxarifadoLancamentoBens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoInventarioItens
     */
    private $fkAlmoxarifadoLancamentoInventarioItens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterialEstorno
     */
    private $fkAlmoxarifadoLancamentoMaterialEstornos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterialEstorno
     */
    private $fkAlmoxarifadoLancamentoMaterialEstornos1;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoOrdem
     */
    private $fkAlmoxarifadoLancamentoOrdens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoRequisicao
     */
    private $fkAlmoxarifadoLancamentoRequisicoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\SaidaDiversa
     */
    private $fkAlmoxarifadoSaidaDiversas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\TransferenciaAlmoxarifadoItemDestino
     */
    private $fkAlmoxarifadoTransferenciaAlmoxarifadoItemDestinos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\TransferenciaAlmoxarifadoItem
     */
    private $fkAlmoxarifadoTransferenciaAlmoxarifadoItens;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial
     */
    private $fkAlmoxarifadoEstoqueMaterial;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem
     */
    private $fkAlmoxarifadoCatalogoItem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\NaturezaLancamento
     */
    private $fkAlmoxarifadoNaturezaLancamento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
        $this->fkAlmoxarifadoAtributoEstoqueMaterialValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoLancamentoBens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoLancamentoInventarioItens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoLancamentoMaterialEstornos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoLancamentoMaterialEstornos1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoLancamentoOrdens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoLancamentoRequisicoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoSaidaDiversas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoTransferenciaAlmoxarifadoItemDestinos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoTransferenciaAlmoxarifadoItens = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codLancamento
     *
     * @param integer $codLancamento
     * @return LancamentoMaterial
     */
    public function setCodLancamento($codLancamento)
    {
        $this->codLancamento = $codLancamento;
        return $this;
    }

    /**
     * Get codLancamento
     *
     * @return integer
     */
    public function getCodLancamento()
    {
        return $this->codLancamento;
    }

    /**
     * Set codItem
     *
     * @param integer $codItem
     * @return LancamentoMaterial
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
     * Set codMarca
     *
     * @param integer $codMarca
     * @return LancamentoMaterial
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
     * Set codAlmoxarifado
     *
     * @param integer $codAlmoxarifado
     * @return LancamentoMaterial
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
     * Set codCentro
     *
     * @param integer $codCentro
     * @return LancamentoMaterial
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
     * Set exercicioLancamento
     *
     * @param string $exercicioLancamento
     * @return LancamentoMaterial
     */
    public function setExercicioLancamento($exercicioLancamento)
    {
        $this->exercicioLancamento = $exercicioLancamento;
        return $this;
    }

    /**
     * Get exercicioLancamento
     *
     * @return string
     */
    public function getExercicioLancamento()
    {
        return $this->exercicioLancamento;
    }

    /**
     * Set numLancamento
     *
     * @param integer $numLancamento
     * @return LancamentoMaterial
     */
    public function setNumLancamento($numLancamento)
    {
        $this->numLancamento = $numLancamento;
        return $this;
    }

    /**
     * Get numLancamento
     *
     * @return integer
     */
    public function getNumLancamento()
    {
        return $this->numLancamento;
    }

    /**
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return LancamentoMaterial
     */
    public function setCodNatureza($codNatureza)
    {
        $this->codNatureza = $codNatureza;
        return $this;
    }

    /**
     * Get codNatureza
     *
     * @return integer
     */
    public function getCodNatureza()
    {
        return $this->codNatureza;
    }

    /**
     * Set tipoNatureza
     *
     * @param string $tipoNatureza
     * @return LancamentoMaterial
     */
    public function setTipoNatureza($tipoNatureza)
    {
        $this->tipoNatureza = $tipoNatureza;
        return $this;
    }

    /**
     * Get tipoNatureza
     *
     * @return string
     */
    public function getTipoNatureza()
    {
        return $this->tipoNatureza;
    }

    /**
     * Set quantidade
     *
     * @param integer $quantidade
     * @return LancamentoMaterial
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
     * Set complemento
     *
     * @param string $complemento
     * @return LancamentoMaterial
     */
    public function setComplemento($complemento = null)
    {
        $this->complemento = $complemento;
        return $this;
    }

    /**
     * Get complemento
     *
     * @return string
     */
    public function getComplemento()
    {
        return $this->complemento;
    }

    /**
     * Set valorMercado
     *
     * @param integer $valorMercado
     * @return LancamentoMaterial
     */
    public function setValorMercado($valorMercado)
    {
        $this->valorMercado = $valorMercado;
        return $this;
    }

    /**
     * Get valorMercado
     *
     * @return integer
     */
    public function getValorMercado()
    {
        return $this->valorMercado;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return LancamentoMaterial
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimePK $timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoAtributoEstoqueMaterialValor
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoEstoqueMaterialValor $fkAlmoxarifadoAtributoEstoqueMaterialValor
     * @return LancamentoMaterial
     */
    public function addFkAlmoxarifadoAtributoEstoqueMaterialValores(\Urbem\CoreBundle\Entity\Almoxarifado\AtributoEstoqueMaterialValor $fkAlmoxarifadoAtributoEstoqueMaterialValor)
    {
        if (false === $this->fkAlmoxarifadoAtributoEstoqueMaterialValores->contains($fkAlmoxarifadoAtributoEstoqueMaterialValor)) {
            $fkAlmoxarifadoAtributoEstoqueMaterialValor->setFkAlmoxarifadoLancamentoMaterial($this);
            $this->fkAlmoxarifadoAtributoEstoqueMaterialValores->add($fkAlmoxarifadoAtributoEstoqueMaterialValor);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoAtributoEstoqueMaterialValor
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoEstoqueMaterialValor $fkAlmoxarifadoAtributoEstoqueMaterialValor
     */
    public function removeFkAlmoxarifadoAtributoEstoqueMaterialValores(\Urbem\CoreBundle\Entity\Almoxarifado\AtributoEstoqueMaterialValor $fkAlmoxarifadoAtributoEstoqueMaterialValor)
    {
        $this->fkAlmoxarifadoAtributoEstoqueMaterialValores->removeElement($fkAlmoxarifadoAtributoEstoqueMaterialValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoAtributoEstoqueMaterialValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\AtributoEstoqueMaterialValor
     */
    public function getFkAlmoxarifadoAtributoEstoqueMaterialValores()
    {
        return $this->fkAlmoxarifadoAtributoEstoqueMaterialValores;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoLancamentoBem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoBem $fkAlmoxarifadoLancamentoBem
     * @return LancamentoMaterial
     */
    public function addFkAlmoxarifadoLancamentoBens(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoBem $fkAlmoxarifadoLancamentoBem)
    {
        if (false === $this->fkAlmoxarifadoLancamentoBens->contains($fkAlmoxarifadoLancamentoBem)) {
            $fkAlmoxarifadoLancamentoBem->setFkAlmoxarifadoLancamentoMaterial($this);
            $this->fkAlmoxarifadoLancamentoBens->add($fkAlmoxarifadoLancamentoBem);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoLancamentoBem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoBem $fkAlmoxarifadoLancamentoBem
     */
    public function removeFkAlmoxarifadoLancamentoBens(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoBem $fkAlmoxarifadoLancamentoBem)
    {
        $this->fkAlmoxarifadoLancamentoBens->removeElement($fkAlmoxarifadoLancamentoBem);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoLancamentoBens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoBem
     */
    public function getFkAlmoxarifadoLancamentoBens()
    {
        return $this->fkAlmoxarifadoLancamentoBens;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoLancamentoInventarioItens
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoInventarioItens $fkAlmoxarifadoLancamentoInventarioItens
     * @return LancamentoMaterial
     */
    public function addFkAlmoxarifadoLancamentoInventarioItens(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoInventarioItens $fkAlmoxarifadoLancamentoInventarioItens)
    {
        if (false === $this->fkAlmoxarifadoLancamentoInventarioItens->contains($fkAlmoxarifadoLancamentoInventarioItens)) {
            $fkAlmoxarifadoLancamentoInventarioItens->setFkAlmoxarifadoLancamentoMaterial($this);
            $this->fkAlmoxarifadoLancamentoInventarioItens->add($fkAlmoxarifadoLancamentoInventarioItens);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoLancamentoInventarioItens
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoInventarioItens $fkAlmoxarifadoLancamentoInventarioItens
     */
    public function removeFkAlmoxarifadoLancamentoInventarioItens(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoInventarioItens $fkAlmoxarifadoLancamentoInventarioItens)
    {
        $this->fkAlmoxarifadoLancamentoInventarioItens->removeElement($fkAlmoxarifadoLancamentoInventarioItens);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoLancamentoInventarioItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoInventarioItens
     */
    public function getFkAlmoxarifadoLancamentoInventarioItens()
    {
        return $this->fkAlmoxarifadoLancamentoInventarioItens;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoLancamentoMaterialEstorno
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterialEstorno $fkAlmoxarifadoLancamentoMaterialEstorno
     * @return LancamentoMaterial
     */
    public function addFkAlmoxarifadoLancamentoMaterialEstornos(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterialEstorno $fkAlmoxarifadoLancamentoMaterialEstorno)
    {
        if (false === $this->fkAlmoxarifadoLancamentoMaterialEstornos->contains($fkAlmoxarifadoLancamentoMaterialEstorno)) {
            $fkAlmoxarifadoLancamentoMaterialEstorno->setFkAlmoxarifadoLancamentoMaterial($this);
            $this->fkAlmoxarifadoLancamentoMaterialEstornos->add($fkAlmoxarifadoLancamentoMaterialEstorno);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoLancamentoMaterialEstorno
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterialEstorno $fkAlmoxarifadoLancamentoMaterialEstorno
     */
    public function removeFkAlmoxarifadoLancamentoMaterialEstornos(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterialEstorno $fkAlmoxarifadoLancamentoMaterialEstorno)
    {
        $this->fkAlmoxarifadoLancamentoMaterialEstornos->removeElement($fkAlmoxarifadoLancamentoMaterialEstorno);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoLancamentoMaterialEstornos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterialEstorno
     */
    public function getFkAlmoxarifadoLancamentoMaterialEstornos()
    {
        return $this->fkAlmoxarifadoLancamentoMaterialEstornos;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoLancamentoMaterialEstorno
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterialEstorno $fkAlmoxarifadoLancamentoMaterialEstorno
     * @return LancamentoMaterial
     */
    public function addFkAlmoxarifadoLancamentoMaterialEstornos1(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterialEstorno $fkAlmoxarifadoLancamentoMaterialEstorno)
    {
        if (false === $this->fkAlmoxarifadoLancamentoMaterialEstornos1->contains($fkAlmoxarifadoLancamentoMaterialEstorno)) {
            $fkAlmoxarifadoLancamentoMaterialEstorno->setFkAlmoxarifadoLancamentoMaterial1($this);
            $this->fkAlmoxarifadoLancamentoMaterialEstornos1->add($fkAlmoxarifadoLancamentoMaterialEstorno);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoLancamentoMaterialEstorno
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterialEstorno $fkAlmoxarifadoLancamentoMaterialEstorno
     */
    public function removeFkAlmoxarifadoLancamentoMaterialEstornos1(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterialEstorno $fkAlmoxarifadoLancamentoMaterialEstorno)
    {
        $this->fkAlmoxarifadoLancamentoMaterialEstornos1->removeElement($fkAlmoxarifadoLancamentoMaterialEstorno);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoLancamentoMaterialEstornos1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterialEstorno
     */
    public function getFkAlmoxarifadoLancamentoMaterialEstornos1()
    {
        return $this->fkAlmoxarifadoLancamentoMaterialEstornos1;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoLancamentoOrdem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoOrdem $fkAlmoxarifadoLancamentoOrdem
     * @return LancamentoMaterial
     */
    public function addFkAlmoxarifadoLancamentoOrdens(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoOrdem $fkAlmoxarifadoLancamentoOrdem)
    {
        if (false === $this->fkAlmoxarifadoLancamentoOrdens->contains($fkAlmoxarifadoLancamentoOrdem)) {
            $fkAlmoxarifadoLancamentoOrdem->setFkAlmoxarifadoLancamentoMaterial($this);
            $this->fkAlmoxarifadoLancamentoOrdens->add($fkAlmoxarifadoLancamentoOrdem);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoLancamentoOrdem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoOrdem $fkAlmoxarifadoLancamentoOrdem
     */
    public function removeFkAlmoxarifadoLancamentoOrdens(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoOrdem $fkAlmoxarifadoLancamentoOrdem)
    {
        $this->fkAlmoxarifadoLancamentoOrdens->removeElement($fkAlmoxarifadoLancamentoOrdem);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoLancamentoOrdens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoOrdem
     */
    public function getFkAlmoxarifadoLancamentoOrdens()
    {
        return $this->fkAlmoxarifadoLancamentoOrdens;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoLancamentoRequisicao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoRequisicao $fkAlmoxarifadoLancamentoRequisicao
     * @return LancamentoMaterial
     */
    public function addFkAlmoxarifadoLancamentoRequisicoes(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoRequisicao $fkAlmoxarifadoLancamentoRequisicao)
    {
        if (false === $this->fkAlmoxarifadoLancamentoRequisicoes->contains($fkAlmoxarifadoLancamentoRequisicao)) {
            $fkAlmoxarifadoLancamentoRequisicao->setFkAlmoxarifadoLancamentoMaterial($this);
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
     * Add AlmoxarifadoSaidaDiversa
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\SaidaDiversa $fkAlmoxarifadoSaidaDiversa
     * @return LancamentoMaterial
     */
    public function addFkAlmoxarifadoSaidaDiversas(\Urbem\CoreBundle\Entity\Almoxarifado\SaidaDiversa $fkAlmoxarifadoSaidaDiversa)
    {
        if (false === $this->fkAlmoxarifadoSaidaDiversas->contains($fkAlmoxarifadoSaidaDiversa)) {
            $fkAlmoxarifadoSaidaDiversa->setFkAlmoxarifadoLancamentoMaterial($this);
            $this->fkAlmoxarifadoSaidaDiversas->add($fkAlmoxarifadoSaidaDiversa);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoSaidaDiversa
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\SaidaDiversa $fkAlmoxarifadoSaidaDiversa
     */
    public function removeFkAlmoxarifadoSaidaDiversas(\Urbem\CoreBundle\Entity\Almoxarifado\SaidaDiversa $fkAlmoxarifadoSaidaDiversa)
    {
        $this->fkAlmoxarifadoSaidaDiversas->removeElement($fkAlmoxarifadoSaidaDiversa);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoSaidaDiversas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\SaidaDiversa
     */
    public function getFkAlmoxarifadoSaidaDiversas()
    {
        return $this->fkAlmoxarifadoSaidaDiversas;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoTransferenciaAlmoxarifadoItemDestino
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\TransferenciaAlmoxarifadoItemDestino $fkAlmoxarifadoTransferenciaAlmoxarifadoItemDestino
     * @return LancamentoMaterial
     */
    public function addFkAlmoxarifadoTransferenciaAlmoxarifadoItemDestinos(\Urbem\CoreBundle\Entity\Almoxarifado\TransferenciaAlmoxarifadoItemDestino $fkAlmoxarifadoTransferenciaAlmoxarifadoItemDestino)
    {
        if (false === $this->fkAlmoxarifadoTransferenciaAlmoxarifadoItemDestinos->contains($fkAlmoxarifadoTransferenciaAlmoxarifadoItemDestino)) {
            $fkAlmoxarifadoTransferenciaAlmoxarifadoItemDestino->setFkAlmoxarifadoLancamentoMaterial($this);
            $this->fkAlmoxarifadoTransferenciaAlmoxarifadoItemDestinos->add($fkAlmoxarifadoTransferenciaAlmoxarifadoItemDestino);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoTransferenciaAlmoxarifadoItemDestino
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\TransferenciaAlmoxarifadoItemDestino $fkAlmoxarifadoTransferenciaAlmoxarifadoItemDestino
     */
    public function removeFkAlmoxarifadoTransferenciaAlmoxarifadoItemDestinos(\Urbem\CoreBundle\Entity\Almoxarifado\TransferenciaAlmoxarifadoItemDestino $fkAlmoxarifadoTransferenciaAlmoxarifadoItemDestino)
    {
        $this->fkAlmoxarifadoTransferenciaAlmoxarifadoItemDestinos->removeElement($fkAlmoxarifadoTransferenciaAlmoxarifadoItemDestino);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoTransferenciaAlmoxarifadoItemDestinos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\TransferenciaAlmoxarifadoItemDestino
     */
    public function getFkAlmoxarifadoTransferenciaAlmoxarifadoItemDestinos()
    {
        return $this->fkAlmoxarifadoTransferenciaAlmoxarifadoItemDestinos;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoTransferenciaAlmoxarifadoItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\TransferenciaAlmoxarifadoItem $fkAlmoxarifadoTransferenciaAlmoxarifadoItem
     * @return LancamentoMaterial
     */
    public function addFkAlmoxarifadoTransferenciaAlmoxarifadoItens(\Urbem\CoreBundle\Entity\Almoxarifado\TransferenciaAlmoxarifadoItem $fkAlmoxarifadoTransferenciaAlmoxarifadoItem)
    {
        if (false === $this->fkAlmoxarifadoTransferenciaAlmoxarifadoItens->contains($fkAlmoxarifadoTransferenciaAlmoxarifadoItem)) {
            $fkAlmoxarifadoTransferenciaAlmoxarifadoItem->setFkAlmoxarifadoLancamentoMaterial($this);
            $this->fkAlmoxarifadoTransferenciaAlmoxarifadoItens->add($fkAlmoxarifadoTransferenciaAlmoxarifadoItem);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoTransferenciaAlmoxarifadoItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\TransferenciaAlmoxarifadoItem $fkAlmoxarifadoTransferenciaAlmoxarifadoItem
     */
    public function removeFkAlmoxarifadoTransferenciaAlmoxarifadoItens(\Urbem\CoreBundle\Entity\Almoxarifado\TransferenciaAlmoxarifadoItem $fkAlmoxarifadoTransferenciaAlmoxarifadoItem)
    {
        $this->fkAlmoxarifadoTransferenciaAlmoxarifadoItens->removeElement($fkAlmoxarifadoTransferenciaAlmoxarifadoItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoTransferenciaAlmoxarifadoItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\TransferenciaAlmoxarifadoItem
     */
    public function getFkAlmoxarifadoTransferenciaAlmoxarifadoItens()
    {
        return $this->fkAlmoxarifadoTransferenciaAlmoxarifadoItens;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoEstoqueMaterial
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial $fkAlmoxarifadoEstoqueMaterial
     * @return LancamentoMaterial
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
     * Set fkAlmoxarifadoCatalogoItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem $fkAlmoxarifadoCatalogoItem
     * @return LancamentoMaterial
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
     * Set fkAlmoxarifadoNaturezaLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\NaturezaLancamento $fkAlmoxarifadoNaturezaLancamento
     * @return LancamentoMaterial
     */
    public function setFkAlmoxarifadoNaturezaLancamento(\Urbem\CoreBundle\Entity\Almoxarifado\NaturezaLancamento $fkAlmoxarifadoNaturezaLancamento)
    {
        $this->exercicioLancamento = $fkAlmoxarifadoNaturezaLancamento->getExercicioLancamento();
        $this->numLancamento = $fkAlmoxarifadoNaturezaLancamento->getNumLancamento();
        $this->codNatureza = $fkAlmoxarifadoNaturezaLancamento->getCodNatureza();
        $this->tipoNatureza = $fkAlmoxarifadoNaturezaLancamento->getTipoNatureza();
        $this->fkAlmoxarifadoNaturezaLancamento = $fkAlmoxarifadoNaturezaLancamento;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoNaturezaLancamento
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\NaturezaLancamento
     */
    public function getFkAlmoxarifadoNaturezaLancamento()
    {
        return $this->fkAlmoxarifadoNaturezaLancamento;
    }

    /**
     * OneToOne (inverse side)
     * Set AlmoxarifadoDoacaoEmprestimo
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\DoacaoEmprestimo $fkAlmoxarifadoDoacaoEmprestimo
     * @return LancamentoMaterial
     */
    public function setFkAlmoxarifadoDoacaoEmprestimo(\Urbem\CoreBundle\Entity\Almoxarifado\DoacaoEmprestimo $fkAlmoxarifadoDoacaoEmprestimo)
    {
        $fkAlmoxarifadoDoacaoEmprestimo->setFkAlmoxarifadoLancamentoMaterial($this);
        $this->fkAlmoxarifadoDoacaoEmprestimo = $fkAlmoxarifadoDoacaoEmprestimo;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkAlmoxarifadoDoacaoEmprestimo
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\DoacaoEmprestimo
     */
    public function getFkAlmoxarifadoDoacaoEmprestimo()
    {
        return $this->fkAlmoxarifadoDoacaoEmprestimo;
    }

    /**
     * OneToOne (inverse side)
     * Set AlmoxarifadoLancamentoAutorizacao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoAutorizacao $fkAlmoxarifadoLancamentoAutorizacao
     * @return LancamentoMaterial
     */
    public function setFkAlmoxarifadoLancamentoAutorizacao(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoAutorizacao $fkAlmoxarifadoLancamentoAutorizacao)
    {
        $fkAlmoxarifadoLancamentoAutorizacao->setFkAlmoxarifadoLancamentoMaterial($this);
        $this->fkAlmoxarifadoLancamentoAutorizacao = $fkAlmoxarifadoLancamentoAutorizacao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkAlmoxarifadoLancamentoAutorizacao
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoAutorizacao
     */
    public function getFkAlmoxarifadoLancamentoAutorizacao()
    {
        return $this->fkAlmoxarifadoLancamentoAutorizacao;
    }

    /**
     * OneToOne (inverse side)
     * Set AlmoxarifadoLancamentoManutencaoFrota
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoManutencaoFrota $fkAlmoxarifadoLancamentoManutencaoFrota
     * @return LancamentoMaterial
     */
    public function setFkAlmoxarifadoLancamentoManutencaoFrota(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoManutencaoFrota $fkAlmoxarifadoLancamentoManutencaoFrota)
    {
        $fkAlmoxarifadoLancamentoManutencaoFrota->setFkAlmoxarifadoLancamentoMaterial($this);
        $this->fkAlmoxarifadoLancamentoManutencaoFrota = $fkAlmoxarifadoLancamentoManutencaoFrota;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkAlmoxarifadoLancamentoManutencaoFrota
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoManutencaoFrota
     */
    public function getFkAlmoxarifadoLancamentoManutencaoFrota()
    {
        return $this->fkAlmoxarifadoLancamentoManutencaoFrota;
    }

    /**
     * OneToOne (inverse side)
     * Set AlmoxarifadoLancamentoPerecivel
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoPerecivel $fkAlmoxarifadoLancamentoPerecivel
     * @return LancamentoMaterial
     */
    public function setFkAlmoxarifadoLancamentoPerecivel(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoPerecivel $fkAlmoxarifadoLancamentoPerecivel)
    {
        $fkAlmoxarifadoLancamentoPerecivel->setFkAlmoxarifadoLancamentoMaterial($this);
        $this->fkAlmoxarifadoLancamentoPerecivel = $fkAlmoxarifadoLancamentoPerecivel;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkAlmoxarifadoLancamentoPerecivel
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoPerecivel
     */
    public function getFkAlmoxarifadoLancamentoPerecivel()
    {
        return $this->fkAlmoxarifadoLancamentoPerecivel;
    }

    /**
     * PrePersist
     * @param \Doctrine\Common\Persistence\Event\LifecycleEventArgs $args
     */
    public function generatePkSequence(\Doctrine\Common\Persistence\Event\LifecycleEventArgs $args)
    {
        $this->codLancamento = (new \Doctrine\ORM\Id\SequenceGenerator('almoxarifado.cod_lancamento_seq', 1))
            ->generate($args->getObjectManager(), $this);
    }
}
