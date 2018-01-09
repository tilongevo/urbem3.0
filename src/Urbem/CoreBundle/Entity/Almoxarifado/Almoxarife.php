<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * Almoxarife
 */
class Almoxarife
{
    /**
     * PK
     * @var integer
     */
    private $cgmAlmoxarife;

    /**
     * @var boolean
     */
    private $ativo = true;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\NaturezaLancamento
     */
    private $fkAlmoxarifadoNaturezaLancamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferencia
     */
    private $fkAlmoxarifadoPedidoTransferencias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\PermissaoAlmoxarifados
     */
    private $fkAlmoxarifadoPermissaoAlmoxarifados;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAlmoxarifadoNaturezaLancamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoPedidoTransferencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoPermissaoAlmoxarifados = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set cgmAlmoxarife
     *
     * @param integer $cgmAlmoxarife
     * @return Almoxarife
     */
    public function setCgmAlmoxarife($cgmAlmoxarife)
    {
        $this->cgmAlmoxarife = $cgmAlmoxarife;
        return $this;
    }

    /**
     * Get cgmAlmoxarife
     *
     * @return integer
     */
    public function getCgmAlmoxarife()
    {
        return $this->cgmAlmoxarife;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return Almoxarife
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
     * OneToMany (owning side)
     * Add AlmoxarifadoNaturezaLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\NaturezaLancamento $fkAlmoxarifadoNaturezaLancamento
     * @return Almoxarife
     */
    public function addFkAlmoxarifadoNaturezaLancamentos(\Urbem\CoreBundle\Entity\Almoxarifado\NaturezaLancamento $fkAlmoxarifadoNaturezaLancamento)
    {
        if (false === $this->fkAlmoxarifadoNaturezaLancamentos->contains($fkAlmoxarifadoNaturezaLancamento)) {
            $fkAlmoxarifadoNaturezaLancamento->setFkAlmoxarifadoAlmoxarife($this);
            $this->fkAlmoxarifadoNaturezaLancamentos->add($fkAlmoxarifadoNaturezaLancamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoNaturezaLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\NaturezaLancamento $fkAlmoxarifadoNaturezaLancamento
     */
    public function removeFkAlmoxarifadoNaturezaLancamentos(\Urbem\CoreBundle\Entity\Almoxarifado\NaturezaLancamento $fkAlmoxarifadoNaturezaLancamento)
    {
        $this->fkAlmoxarifadoNaturezaLancamentos->removeElement($fkAlmoxarifadoNaturezaLancamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoNaturezaLancamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\NaturezaLancamento
     */
    public function getFkAlmoxarifadoNaturezaLancamentos()
    {
        return $this->fkAlmoxarifadoNaturezaLancamentos;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoPedidoTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferencia $fkAlmoxarifadoPedidoTransferencia
     * @return Almoxarife
     */
    public function addFkAlmoxarifadoPedidoTransferencias(\Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferencia $fkAlmoxarifadoPedidoTransferencia)
    {
        if (false === $this->fkAlmoxarifadoPedidoTransferencias->contains($fkAlmoxarifadoPedidoTransferencia)) {
            $fkAlmoxarifadoPedidoTransferencia->setFkAlmoxarifadoAlmoxarife($this);
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
     * Add AlmoxarifadoPermissaoAlmoxarifados
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\PermissaoAlmoxarifados $fkAlmoxarifadoPermissaoAlmoxarifados
     * @return Almoxarife
     */
    public function addFkAlmoxarifadoPermissaoAlmoxarifados(\Urbem\CoreBundle\Entity\Almoxarifado\PermissaoAlmoxarifados $fkAlmoxarifadoPermissaoAlmoxarifados)
    {
        if (false === $this->fkAlmoxarifadoPermissaoAlmoxarifados->contains($fkAlmoxarifadoPermissaoAlmoxarifados)) {
            $fkAlmoxarifadoPermissaoAlmoxarifados->setFkAlmoxarifadoAlmoxarife($this);
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
     * Set fkAlmoxarifadoPermissaoAlmoxarifados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\PermissaoAlmoxarifados
     */
    public function setFkAlmoxarifadoPermissaoAlmoxarifados($permissaoAlmoxarifados)
    {
        return $this->fkAlmoxarifadoPermissaoAlmoxarifados = $permissaoAlmoxarifados;
    }

    /**
     * OneToOne (owning side)
     * Set AdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return Almoxarife
     */
    public function setFkAdministracaoUsuario(\Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario)
    {
        $this->cgmAlmoxarife = $fkAdministracaoUsuario->getNumcgm();
        $this->fkAdministracaoUsuario = $fkAdministracaoUsuario;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkAdministracaoUsuario
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    public function getFkAdministracaoUsuario()
    {
        return $this->fkAdministracaoUsuario;
    }

    /**
     * @return \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    public function __toString()
    {
        if ($this->getFkAdministracaoUsuario()) {
            return (string) $this->getFkAdministracaoUsuario()->getFkSwCgm();
        } else {
            return (string) "Almoxarife";
        }
    }
}
