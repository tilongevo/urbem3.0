<?php
 
namespace Urbem\CoreBundle\Entity\Monetario;

/**
 * Banco
 */
class Banco
{
    /**
     * PK
     * @var integer
     */
    private $codBanco;

    /**
     * @var string
     */
    private $nomBanco;

    /**
     * @var string
     */
    private $numBanco;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tesouraria\BancoChequeLayout
     */
    private $fkTesourariaBancoChequeLayout;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaEmprestimoConsignado
     */
    private $fkFolhapagamentoTcmbaEmprestimoConsignados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBb
     */
    private $fkImaConfiguracaoConvenioBbs;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBanrisul
     */
    private $fkImaConfiguracaoConvenioBanrisuis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBesc
     */
    private $fkImaConfiguracaoConvenioBescs;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioHsbc
     */
    private $fkImaConfiguracaoConvenioHsbcs;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcBancos
     */
    private $fkImaConfiguracaoHsbcBancos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\Agencia
     */
    private $fkMonetarioAgencias;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoTcmbaEmprestimoConsignados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoConvenioBbs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoConvenioBanrisuis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoConvenioBescs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoConvenioHsbcs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoHsbcBancos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkMonetarioAgencias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codBanco
     *
     * @param integer $codBanco
     * @return Banco
     */
    public function setCodBanco($codBanco)
    {
        $this->codBanco = $codBanco;
        return $this;
    }

    /**
     * Get codBanco
     *
     * @return integer
     */
    public function getCodBanco()
    {
        return $this->codBanco;
    }

    /**
     * Set nomBanco
     *
     * @param string $nomBanco
     * @return Banco
     */
    public function setNomBanco($nomBanco)
    {
        $this->nomBanco = $nomBanco;
        return $this;
    }

    /**
     * Get nomBanco
     *
     * @return string
     */
    public function getNomBanco()
    {
        return $this->nomBanco;
    }

    /**
     * Set numBanco
     *
     * @param string $numBanco
     * @return Banco
     */
    public function setNumBanco($numBanco)
    {
        $this->numBanco = $numBanco;
        return $this;
    }

    /**
     * Get numBanco
     *
     * @return string
     */
    public function getNumBanco()
    {
        return $this->numBanco;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoTcmbaEmprestimoConsignado
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaEmprestimoConsignado $fkFolhapagamentoTcmbaEmprestimoConsignado
     * @return Banco
     */
    public function addFkFolhapagamentoTcmbaEmprestimoConsignados(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaEmprestimoConsignado $fkFolhapagamentoTcmbaEmprestimoConsignado)
    {
        if (false === $this->fkFolhapagamentoTcmbaEmprestimoConsignados->contains($fkFolhapagamentoTcmbaEmprestimoConsignado)) {
            $fkFolhapagamentoTcmbaEmprestimoConsignado->setFkMonetarioBanco($this);
            $this->fkFolhapagamentoTcmbaEmprestimoConsignados->add($fkFolhapagamentoTcmbaEmprestimoConsignado);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTcmbaEmprestimoConsignado
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaEmprestimoConsignado $fkFolhapagamentoTcmbaEmprestimoConsignado
     */
    public function removeFkFolhapagamentoTcmbaEmprestimoConsignados(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaEmprestimoConsignado $fkFolhapagamentoTcmbaEmprestimoConsignado)
    {
        $this->fkFolhapagamentoTcmbaEmprestimoConsignados->removeElement($fkFolhapagamentoTcmbaEmprestimoConsignado);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTcmbaEmprestimoConsignados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaEmprestimoConsignado
     */
    public function getFkFolhapagamentoTcmbaEmprestimoConsignados()
    {
        return $this->fkFolhapagamentoTcmbaEmprestimoConsignados;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoConvenioBb
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBb $fkImaConfiguracaoConvenioBb
     * @return Banco
     */
    public function addFkImaConfiguracaoConvenioBbs(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBb $fkImaConfiguracaoConvenioBb)
    {
        if (false === $this->fkImaConfiguracaoConvenioBbs->contains($fkImaConfiguracaoConvenioBb)) {
            $fkImaConfiguracaoConvenioBb->setFkMonetarioBanco($this);
            $this->fkImaConfiguracaoConvenioBbs->add($fkImaConfiguracaoConvenioBb);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoConvenioBb
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBb $fkImaConfiguracaoConvenioBb
     */
    public function removeFkImaConfiguracaoConvenioBbs(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBb $fkImaConfiguracaoConvenioBb)
    {
        $this->fkImaConfiguracaoConvenioBbs->removeElement($fkImaConfiguracaoConvenioBb);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoConvenioBbs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBb
     */
    public function getFkImaConfiguracaoConvenioBbs()
    {
        return $this->fkImaConfiguracaoConvenioBbs;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoConvenioBanrisul
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBanrisul $fkImaConfiguracaoConvenioBanrisul
     * @return Banco
     */
    public function addFkImaConfiguracaoConvenioBanrisuis(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBanrisul $fkImaConfiguracaoConvenioBanrisul)
    {
        if (false === $this->fkImaConfiguracaoConvenioBanrisuis->contains($fkImaConfiguracaoConvenioBanrisul)) {
            $fkImaConfiguracaoConvenioBanrisul->setFkMonetarioBanco($this);
            $this->fkImaConfiguracaoConvenioBanrisuis->add($fkImaConfiguracaoConvenioBanrisul);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoConvenioBanrisul
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBanrisul $fkImaConfiguracaoConvenioBanrisul
     */
    public function removeFkImaConfiguracaoConvenioBanrisuis(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBanrisul $fkImaConfiguracaoConvenioBanrisul)
    {
        $this->fkImaConfiguracaoConvenioBanrisuis->removeElement($fkImaConfiguracaoConvenioBanrisul);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoConvenioBanrisuis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBanrisul
     */
    public function getFkImaConfiguracaoConvenioBanrisuis()
    {
        return $this->fkImaConfiguracaoConvenioBanrisuis;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoConvenioBesc
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBesc $fkImaConfiguracaoConvenioBesc
     * @return Banco
     */
    public function addFkImaConfiguracaoConvenioBescs(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBesc $fkImaConfiguracaoConvenioBesc)
    {
        if (false === $this->fkImaConfiguracaoConvenioBescs->contains($fkImaConfiguracaoConvenioBesc)) {
            $fkImaConfiguracaoConvenioBesc->setFkMonetarioBanco($this);
            $this->fkImaConfiguracaoConvenioBescs->add($fkImaConfiguracaoConvenioBesc);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoConvenioBesc
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBesc $fkImaConfiguracaoConvenioBesc
     */
    public function removeFkImaConfiguracaoConvenioBescs(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBesc $fkImaConfiguracaoConvenioBesc)
    {
        $this->fkImaConfiguracaoConvenioBescs->removeElement($fkImaConfiguracaoConvenioBesc);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoConvenioBescs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBesc
     */
    public function getFkImaConfiguracaoConvenioBescs()
    {
        return $this->fkImaConfiguracaoConvenioBescs;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoConvenioHsbc
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioHsbc $fkImaConfiguracaoConvenioHsbc
     * @return Banco
     */
    public function addFkImaConfiguracaoConvenioHsbcs(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioHsbc $fkImaConfiguracaoConvenioHsbc)
    {
        if (false === $this->fkImaConfiguracaoConvenioHsbcs->contains($fkImaConfiguracaoConvenioHsbc)) {
            $fkImaConfiguracaoConvenioHsbc->setFkMonetarioBanco($this);
            $this->fkImaConfiguracaoConvenioHsbcs->add($fkImaConfiguracaoConvenioHsbc);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoConvenioHsbc
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioHsbc $fkImaConfiguracaoConvenioHsbc
     */
    public function removeFkImaConfiguracaoConvenioHsbcs(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioHsbc $fkImaConfiguracaoConvenioHsbc)
    {
        $this->fkImaConfiguracaoConvenioHsbcs->removeElement($fkImaConfiguracaoConvenioHsbc);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoConvenioHsbcs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioHsbc
     */
    public function getFkImaConfiguracaoConvenioHsbcs()
    {
        return $this->fkImaConfiguracaoConvenioHsbcs;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoHsbcBancos
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcBancos $fkImaConfiguracaoHsbcBancos
     * @return Banco
     */
    public function addFkImaConfiguracaoHsbcBancos(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcBancos $fkImaConfiguracaoHsbcBancos)
    {
        if (false === $this->fkImaConfiguracaoHsbcBancos->contains($fkImaConfiguracaoHsbcBancos)) {
            $fkImaConfiguracaoHsbcBancos->setFkMonetarioBanco($this);
            $this->fkImaConfiguracaoHsbcBancos->add($fkImaConfiguracaoHsbcBancos);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoHsbcBancos
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcBancos $fkImaConfiguracaoHsbcBancos
     */
    public function removeFkImaConfiguracaoHsbcBancos(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcBancos $fkImaConfiguracaoHsbcBancos)
    {
        $this->fkImaConfiguracaoHsbcBancos->removeElement($fkImaConfiguracaoHsbcBancos);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoHsbcBancos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcBancos
     */
    public function getFkImaConfiguracaoHsbcBancos()
    {
        return $this->fkImaConfiguracaoHsbcBancos;
    }

    /**
     * OneToMany (owning side)
     * Add MonetarioAgencia
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Agencia $fkMonetarioAgencia
     * @return Banco
     */
    public function addFkMonetarioAgencias(\Urbem\CoreBundle\Entity\Monetario\Agencia $fkMonetarioAgencia)
    {
        if (false === $this->fkMonetarioAgencias->contains($fkMonetarioAgencia)) {
            $fkMonetarioAgencia->setFkMonetarioBanco($this);
            $this->fkMonetarioAgencias->add($fkMonetarioAgencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove MonetarioAgencia
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Agencia $fkMonetarioAgencia
     */
    public function removeFkMonetarioAgencias(\Urbem\CoreBundle\Entity\Monetario\Agencia $fkMonetarioAgencia)
    {
        $this->fkMonetarioAgencias->removeElement($fkMonetarioAgencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkMonetarioAgencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\Agencia
     */
    public function getFkMonetarioAgencias()
    {
        return $this->fkMonetarioAgencias;
    }

    /**
     * OneToOne (inverse side)
     * Set TesourariaBancoChequeLayout
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BancoChequeLayout $fkTesourariaBancoChequeLayout
     * @return Banco
     */
    public function setFkTesourariaBancoChequeLayout(\Urbem\CoreBundle\Entity\Tesouraria\BancoChequeLayout $fkTesourariaBancoChequeLayout)
    {
        $fkTesourariaBancoChequeLayout->setFkMonetarioBanco($this);
        $this->fkTesourariaBancoChequeLayout = $fkTesourariaBancoChequeLayout;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTesourariaBancoChequeLayout
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\BancoChequeLayout
     */
    public function getFkTesourariaBancoChequeLayout()
    {
        return $this->fkTesourariaBancoChequeLayout;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->nomBanco;
    }
}
