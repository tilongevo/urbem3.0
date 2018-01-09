<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * Almoxarifado
 */
class Almoxarifado
{
    const RELATORIO_ITENS_ESTOQUE = 1;
    const RELATORIO_MOVIMENTACAO = 5;

    /**
     * PK
     * @var integer
     */
    private $codAlmoxarifado;

    /**
     * @var integer
     */
    private $cgmResponsavel;

    /**
     * @var integer
     */
    private $cgmAlmoxarifado;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\Inventario
     */
    private $fkAlmoxarifadoInventarios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial
     */
    private $fkAlmoxarifadoEstoqueMateriais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferencia
     */
    private $fkAlmoxarifadoPedidoTransferencias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferencia
     */
    private $fkAlmoxarifadoPedidoTransferencias1;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\LocalizacaoFisica
     */
    private $fkAlmoxarifadoLocalizacaoFisicas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\PermissaoAlmoxarifados
     */
    private $fkAlmoxarifadoPermissaoAlmoxarifados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\Solicitacao
     */
    private $fkComprasSolicitacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\Requisicao
     */
    private $fkAlmoxarifadoRequisicoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    private $fkSwCgmPessoaFisica;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAlmoxarifadoInventarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoEstoqueMateriais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoPedidoTransferencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoPedidoTransferencias1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoLocalizacaoFisicas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoPermissaoAlmoxarifados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasSolicitacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoRequisicoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codAlmoxarifado
     *
     * @param integer $codAlmoxarifado
     * @return Almoxarifado
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
     * Set cgmResponsavel
     *
     * @param integer $cgmResponsavel
     * @return Almoxarifado
     */
    public function setCgmResponsavel($cgmResponsavel)
    {
        $this->cgmResponsavel = $cgmResponsavel;
        return $this;
    }

    /**
     * Get cgmResponsavel
     *
     * @return integer
     */
    public function getCgmResponsavel()
    {
        return $this->cgmResponsavel;
    }

    /**
     * Set cgmAlmoxarifado
     *
     * @param integer $cgmAlmoxarifado
     * @return Almoxarifado
     */
    public function setCgmAlmoxarifado($cgmAlmoxarifado)
    {
        $this->cgmAlmoxarifado = $cgmAlmoxarifado;
        return $this;
    }

    /**
     * Get cgmAlmoxarifado
     *
     * @return integer
     */
    public function getCgmAlmoxarifado()
    {
        return $this->cgmAlmoxarifado;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoInventario
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Inventario $fkAlmoxarifadoInventario
     * @return Almoxarifado
     */
    public function addFkAlmoxarifadoInventarios(\Urbem\CoreBundle\Entity\Almoxarifado\Inventario $fkAlmoxarifadoInventario)
    {
        if (false === $this->fkAlmoxarifadoInventarios->contains($fkAlmoxarifadoInventario)) {
            $fkAlmoxarifadoInventario->setFkAlmoxarifadoAlmoxarifado($this);
            $this->fkAlmoxarifadoInventarios->add($fkAlmoxarifadoInventario);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoInventario
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Inventario $fkAlmoxarifadoInventario
     */
    public function removeFkAlmoxarifadoInventarios(\Urbem\CoreBundle\Entity\Almoxarifado\Inventario $fkAlmoxarifadoInventario)
    {
        $this->fkAlmoxarifadoInventarios->removeElement($fkAlmoxarifadoInventario);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoInventarios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\Inventario
     */
    public function getFkAlmoxarifadoInventarios()
    {
        return $this->fkAlmoxarifadoInventarios;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoEstoqueMaterial
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial $fkAlmoxarifadoEstoqueMaterial
     * @return Almoxarifado
     */
    public function addFkAlmoxarifadoEstoqueMateriais(\Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial $fkAlmoxarifadoEstoqueMaterial)
    {
        if (false === $this->fkAlmoxarifadoEstoqueMateriais->contains($fkAlmoxarifadoEstoqueMaterial)) {
            $fkAlmoxarifadoEstoqueMaterial->setFkAlmoxarifadoAlmoxarifado($this);
            $this->fkAlmoxarifadoEstoqueMateriais->add($fkAlmoxarifadoEstoqueMaterial);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoEstoqueMaterial
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial $fkAlmoxarifadoEstoqueMaterial
     */
    public function removeFkAlmoxarifadoEstoqueMateriais(\Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial $fkAlmoxarifadoEstoqueMaterial)
    {
        $this->fkAlmoxarifadoEstoqueMateriais->removeElement($fkAlmoxarifadoEstoqueMaterial);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoEstoqueMateriais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial
     */
    public function getFkAlmoxarifadoEstoqueMateriais()
    {
        return $this->fkAlmoxarifadoEstoqueMateriais;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoPedidoTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferencia $fkAlmoxarifadoPedidoTransferencia
     * @return Almoxarifado
     */
    public function addFkAlmoxarifadoPedidoTransferencias(\Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferencia $fkAlmoxarifadoPedidoTransferencia)
    {
        if (false === $this->fkAlmoxarifadoPedidoTransferencias->contains($fkAlmoxarifadoPedidoTransferencia)) {
            $fkAlmoxarifadoPedidoTransferencia->setFkAlmoxarifadoAlmoxarifado($this);
            $this->fkAlmoxarifadoPedidoTransferencias->add($fkAlmoxarifadoPedidoTransferencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoPedidoTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferencia $fkAlmoxarifadoPedidoTransferencia
     */
    public function removeFkAlmoxarifadoPedidoTransferencias(\Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferencia $fkAlmoxarifadoPedidoTransferencia)
    {
        $this->fkAlmoxarifadoPedidoTransferencias->removeElement($fkAlmoxarifadoPedidoTransferencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoPedidoTransferencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferencia
     */
    public function getFkAlmoxarifadoPedidoTransferencias()
    {
        return $this->fkAlmoxarifadoPedidoTransferencias;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoPedidoTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferencia $fkAlmoxarifadoPedidoTransferencia
     * @return Almoxarifado
     */
    public function addFkAlmoxarifadoPedidoTransferencias1(\Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferencia $fkAlmoxarifadoPedidoTransferencia)
    {
        if (false === $this->fkAlmoxarifadoPedidoTransferencias1->contains($fkAlmoxarifadoPedidoTransferencia)) {
            $fkAlmoxarifadoPedidoTransferencia->setFkAlmoxarifadoAlmoxarifado1($this);
            $this->fkAlmoxarifadoPedidoTransferencias1->add($fkAlmoxarifadoPedidoTransferencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoPedidoTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferencia $fkAlmoxarifadoPedidoTransferencia
     */
    public function removeFkAlmoxarifadoPedidoTransferencias1(\Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferencia $fkAlmoxarifadoPedidoTransferencia)
    {
        $this->fkAlmoxarifadoPedidoTransferencias1->removeElement($fkAlmoxarifadoPedidoTransferencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoPedidoTransferencias1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferencia
     */
    public function getFkAlmoxarifadoPedidoTransferencias1()
    {
        return $this->fkAlmoxarifadoPedidoTransferencias1;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoLocalizacaoFisica
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LocalizacaoFisica $fkAlmoxarifadoLocalizacaoFisica
     * @return Almoxarifado
     */
    public function addFkAlmoxarifadoLocalizacaoFisicas(\Urbem\CoreBundle\Entity\Almoxarifado\LocalizacaoFisica $fkAlmoxarifadoLocalizacaoFisica)
    {
        if (false === $this->fkAlmoxarifadoLocalizacaoFisicas->contains($fkAlmoxarifadoLocalizacaoFisica)) {
            $fkAlmoxarifadoLocalizacaoFisica->setFkAlmoxarifadoAlmoxarifado($this);
            $this->fkAlmoxarifadoLocalizacaoFisicas->add($fkAlmoxarifadoLocalizacaoFisica);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoLocalizacaoFisica
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LocalizacaoFisica $fkAlmoxarifadoLocalizacaoFisica
     */
    public function removeFkAlmoxarifadoLocalizacaoFisicas(\Urbem\CoreBundle\Entity\Almoxarifado\LocalizacaoFisica $fkAlmoxarifadoLocalizacaoFisica)
    {
        $this->fkAlmoxarifadoLocalizacaoFisicas->removeElement($fkAlmoxarifadoLocalizacaoFisica);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoLocalizacaoFisicas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\LocalizacaoFisica
     */
    public function getFkAlmoxarifadoLocalizacaoFisicas()
    {
        return $this->fkAlmoxarifadoLocalizacaoFisicas;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoPermissaoAlmoxarifados
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\PermissaoAlmoxarifados $fkAlmoxarifadoPermissaoAlmoxarifados
     * @return Almoxarifado
     */
    public function addFkAlmoxarifadoPermissaoAlmoxarifados(\Urbem\CoreBundle\Entity\Almoxarifado\PermissaoAlmoxarifados $fkAlmoxarifadoPermissaoAlmoxarifados)
    {
        if (false === $this->fkAlmoxarifadoPermissaoAlmoxarifados->contains($fkAlmoxarifadoPermissaoAlmoxarifados)) {
            $fkAlmoxarifadoPermissaoAlmoxarifados->setFkAlmoxarifadoAlmoxarifado($this);
            $this->fkAlmoxarifadoPermissaoAlmoxarifados->add($fkAlmoxarifadoPermissaoAlmoxarifados);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoPermissaoAlmoxarifados
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\PermissaoAlmoxarifados $fkAlmoxarifadoPermissaoAlmoxarifados
     */
    public function removeFkAlmoxarifadoPermissaoAlmoxarifados(\Urbem\CoreBundle\Entity\Almoxarifado\PermissaoAlmoxarifados $fkAlmoxarifadoPermissaoAlmoxarifados)
    {
        $this->fkAlmoxarifadoPermissaoAlmoxarifados->removeElement($fkAlmoxarifadoPermissaoAlmoxarifados);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoPermissaoAlmoxarifados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\PermissaoAlmoxarifados
     */
    public function getFkAlmoxarifadoPermissaoAlmoxarifados()
    {
        return $this->fkAlmoxarifadoPermissaoAlmoxarifados;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasSolicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Solicitacao $fkComprasSolicitacao
     * @return Almoxarifado
     */
    public function addFkComprasSolicitacoes(\Urbem\CoreBundle\Entity\Compras\Solicitacao $fkComprasSolicitacao)
    {
        if (false === $this->fkComprasSolicitacoes->contains($fkComprasSolicitacao)) {
            $fkComprasSolicitacao->setFkAlmoxarifadoAlmoxarifado($this);
            $this->fkComprasSolicitacoes->add($fkComprasSolicitacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasSolicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Solicitacao $fkComprasSolicitacao
     */
    public function removeFkComprasSolicitacoes(\Urbem\CoreBundle\Entity\Compras\Solicitacao $fkComprasSolicitacao)
    {
        $this->fkComprasSolicitacoes->removeElement($fkComprasSolicitacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasSolicitacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\Solicitacao
     */
    public function getFkComprasSolicitacoes()
    {
        return $this->fkComprasSolicitacoes;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoRequisicao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Requisicao $fkAlmoxarifadoRequisicao
     * @return Almoxarifado
     */
    public function addFkAlmoxarifadoRequisicoes(\Urbem\CoreBundle\Entity\Almoxarifado\Requisicao $fkAlmoxarifadoRequisicao)
    {
        if (false === $this->fkAlmoxarifadoRequisicoes->contains($fkAlmoxarifadoRequisicao)) {
            $fkAlmoxarifadoRequisicao->setFkAlmoxarifadoAlmoxarifado($this);
            $this->fkAlmoxarifadoRequisicoes->add($fkAlmoxarifadoRequisicao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoRequisicao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Requisicao $fkAlmoxarifadoRequisicao
     */
    public function removeFkAlmoxarifadoRequisicoes(\Urbem\CoreBundle\Entity\Almoxarifado\Requisicao $fkAlmoxarifadoRequisicao)
    {
        $this->fkAlmoxarifadoRequisicoes->removeElement($fkAlmoxarifadoRequisicao);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoRequisicoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\Requisicao
     */
    public function getFkAlmoxarifadoRequisicoes()
    {
        return $this->fkAlmoxarifadoRequisicoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgmPessoaFisica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica
     * @return Almoxarifado
     */
    public function setFkSwCgmPessoaFisica(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica)
    {
        $this->cgmResponsavel = $fkSwCgmPessoaFisica->getNumcgm();
        $this->fkSwCgmPessoaFisica = $fkSwCgmPessoaFisica;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgmPessoaFisica
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    public function getFkSwCgmPessoaFisica()
    {
        return $this->fkSwCgmPessoaFisica;
    }

    /**
     * OneToOne (owning side)
     * Set SwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return Almoxarifado
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->cgmAlmoxarifado = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (!is_null($this->fkSwCgm)) {
            return sprintf('%d - %s', $this->codAlmoxarifado, strtoupper($this->fkSwCgm->getNomCgm()));
        }
        return 'Almoxarifado';
    }
}
