<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * FiscalProcessoFiscal
 */
class FiscalProcessoFiscal
{
    /**
     * PK
     * @var integer
     */
    private $codProcesso;

    /**
     * PK
     * @var integer
     */
    private $codFiscal;

    /**
     * @var string
     */
    private $status;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\AutoFiscalizacao
     */
    private $fkFiscalizacaoAutoFiscalizacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\DocumentosEntrega
     */
    private $fkFiscalizacaoDocumentosEntregas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacao
     */
    private $fkFiscalizacaoInicioFiscalizacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoTermo
     */
    private $fkFiscalizacaoNotificacaoTermos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\TerminoFiscalizacao
     */
    private $fkFiscalizacaoTerminoFiscalizacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoFiscalizacao
     */
    private $fkFiscalizacaoNotificacaoFiscalizacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal
     */
    private $fkFiscalizacaoProcessoFiscal;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\Fiscal
     */
    private $fkFiscalizacaoFiscal;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFiscalizacaoAutoFiscalizacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoDocumentosEntregas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoInicioFiscalizacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoNotificacaoTermos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoTerminoFiscalizacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoNotificacaoFiscalizacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return FiscalProcessoFiscal
     */
    public function setCodProcesso($codProcesso)
    {
        $this->codProcesso = $codProcesso;
        return $this;
    }

    /**
     * Get codProcesso
     *
     * @return integer
     */
    public function getCodProcesso()
    {
        return $this->codProcesso;
    }

    /**
     * Set codFiscal
     *
     * @param integer $codFiscal
     * @return FiscalProcessoFiscal
     */
    public function setCodFiscal($codFiscal)
    {
        $this->codFiscal = $codFiscal;
        return $this;
    }

    /**
     * Get codFiscal
     *
     * @return integer
     */
    public function getCodFiscal()
    {
        return $this->codFiscal;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return FiscalProcessoFiscal
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoAutoFiscalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\AutoFiscalizacao $fkFiscalizacaoAutoFiscalizacao
     * @return FiscalProcessoFiscal
     */
    public function addFkFiscalizacaoAutoFiscalizacoes(\Urbem\CoreBundle\Entity\Fiscalizacao\AutoFiscalizacao $fkFiscalizacaoAutoFiscalizacao)
    {
        if (false === $this->fkFiscalizacaoAutoFiscalizacoes->contains($fkFiscalizacaoAutoFiscalizacao)) {
            $fkFiscalizacaoAutoFiscalizacao->setFkFiscalizacaoFiscalProcessoFiscal($this);
            $this->fkFiscalizacaoAutoFiscalizacoes->add($fkFiscalizacaoAutoFiscalizacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoAutoFiscalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\AutoFiscalizacao $fkFiscalizacaoAutoFiscalizacao
     */
    public function removeFkFiscalizacaoAutoFiscalizacoes(\Urbem\CoreBundle\Entity\Fiscalizacao\AutoFiscalizacao $fkFiscalizacaoAutoFiscalizacao)
    {
        $this->fkFiscalizacaoAutoFiscalizacoes->removeElement($fkFiscalizacaoAutoFiscalizacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoAutoFiscalizacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\AutoFiscalizacao
     */
    public function getFkFiscalizacaoAutoFiscalizacoes()
    {
        return $this->fkFiscalizacaoAutoFiscalizacoes;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoDocumentosEntrega
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\DocumentosEntrega $fkFiscalizacaoDocumentosEntrega
     * @return FiscalProcessoFiscal
     */
    public function addFkFiscalizacaoDocumentosEntregas(\Urbem\CoreBundle\Entity\Fiscalizacao\DocumentosEntrega $fkFiscalizacaoDocumentosEntrega)
    {
        if (false === $this->fkFiscalizacaoDocumentosEntregas->contains($fkFiscalizacaoDocumentosEntrega)) {
            $fkFiscalizacaoDocumentosEntrega->setFkFiscalizacaoFiscalProcessoFiscal($this);
            $this->fkFiscalizacaoDocumentosEntregas->add($fkFiscalizacaoDocumentosEntrega);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoDocumentosEntrega
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\DocumentosEntrega $fkFiscalizacaoDocumentosEntrega
     */
    public function removeFkFiscalizacaoDocumentosEntregas(\Urbem\CoreBundle\Entity\Fiscalizacao\DocumentosEntrega $fkFiscalizacaoDocumentosEntrega)
    {
        $this->fkFiscalizacaoDocumentosEntregas->removeElement($fkFiscalizacaoDocumentosEntrega);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoDocumentosEntregas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\DocumentosEntrega
     */
    public function getFkFiscalizacaoDocumentosEntregas()
    {
        return $this->fkFiscalizacaoDocumentosEntregas;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoInicioFiscalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacao $fkFiscalizacaoInicioFiscalizacao
     * @return FiscalProcessoFiscal
     */
    public function addFkFiscalizacaoInicioFiscalizacoes(\Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacao $fkFiscalizacaoInicioFiscalizacao)
    {
        if (false === $this->fkFiscalizacaoInicioFiscalizacoes->contains($fkFiscalizacaoInicioFiscalizacao)) {
            $fkFiscalizacaoInicioFiscalizacao->setFkFiscalizacaoFiscalProcessoFiscal($this);
            $this->fkFiscalizacaoInicioFiscalizacoes->add($fkFiscalizacaoInicioFiscalizacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoInicioFiscalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacao $fkFiscalizacaoInicioFiscalizacao
     */
    public function removeFkFiscalizacaoInicioFiscalizacoes(\Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacao $fkFiscalizacaoInicioFiscalizacao)
    {
        $this->fkFiscalizacaoInicioFiscalizacoes->removeElement($fkFiscalizacaoInicioFiscalizacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoInicioFiscalizacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacao
     */
    public function getFkFiscalizacaoInicioFiscalizacoes()
    {
        return $this->fkFiscalizacaoInicioFiscalizacoes;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoNotificacaoTermo
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoTermo $fkFiscalizacaoNotificacaoTermo
     * @return FiscalProcessoFiscal
     */
    public function addFkFiscalizacaoNotificacaoTermos(\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoTermo $fkFiscalizacaoNotificacaoTermo)
    {
        if (false === $this->fkFiscalizacaoNotificacaoTermos->contains($fkFiscalizacaoNotificacaoTermo)) {
            $fkFiscalizacaoNotificacaoTermo->setFkFiscalizacaoFiscalProcessoFiscal($this);
            $this->fkFiscalizacaoNotificacaoTermos->add($fkFiscalizacaoNotificacaoTermo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoNotificacaoTermo
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoTermo $fkFiscalizacaoNotificacaoTermo
     */
    public function removeFkFiscalizacaoNotificacaoTermos(\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoTermo $fkFiscalizacaoNotificacaoTermo)
    {
        $this->fkFiscalizacaoNotificacaoTermos->removeElement($fkFiscalizacaoNotificacaoTermo);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoNotificacaoTermos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoTermo
     */
    public function getFkFiscalizacaoNotificacaoTermos()
    {
        return $this->fkFiscalizacaoNotificacaoTermos;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoTerminoFiscalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\TerminoFiscalizacao $fkFiscalizacaoTerminoFiscalizacao
     * @return FiscalProcessoFiscal
     */
    public function addFkFiscalizacaoTerminoFiscalizacoes(\Urbem\CoreBundle\Entity\Fiscalizacao\TerminoFiscalizacao $fkFiscalizacaoTerminoFiscalizacao)
    {
        if (false === $this->fkFiscalizacaoTerminoFiscalizacoes->contains($fkFiscalizacaoTerminoFiscalizacao)) {
            $fkFiscalizacaoTerminoFiscalizacao->setFkFiscalizacaoFiscalProcessoFiscal($this);
            $this->fkFiscalizacaoTerminoFiscalizacoes->add($fkFiscalizacaoTerminoFiscalizacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoTerminoFiscalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\TerminoFiscalizacao $fkFiscalizacaoTerminoFiscalizacao
     */
    public function removeFkFiscalizacaoTerminoFiscalizacoes(\Urbem\CoreBundle\Entity\Fiscalizacao\TerminoFiscalizacao $fkFiscalizacaoTerminoFiscalizacao)
    {
        $this->fkFiscalizacaoTerminoFiscalizacoes->removeElement($fkFiscalizacaoTerminoFiscalizacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoTerminoFiscalizacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\TerminoFiscalizacao
     */
    public function getFkFiscalizacaoTerminoFiscalizacoes()
    {
        return $this->fkFiscalizacaoTerminoFiscalizacoes;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoNotificacaoFiscalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoFiscalizacao $fkFiscalizacaoNotificacaoFiscalizacao
     * @return FiscalProcessoFiscal
     */
    public function addFkFiscalizacaoNotificacaoFiscalizacoes(\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoFiscalizacao $fkFiscalizacaoNotificacaoFiscalizacao)
    {
        if (false === $this->fkFiscalizacaoNotificacaoFiscalizacoes->contains($fkFiscalizacaoNotificacaoFiscalizacao)) {
            $fkFiscalizacaoNotificacaoFiscalizacao->setFkFiscalizacaoFiscalProcessoFiscal($this);
            $this->fkFiscalizacaoNotificacaoFiscalizacoes->add($fkFiscalizacaoNotificacaoFiscalizacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoNotificacaoFiscalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoFiscalizacao $fkFiscalizacaoNotificacaoFiscalizacao
     */
    public function removeFkFiscalizacaoNotificacaoFiscalizacoes(\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoFiscalizacao $fkFiscalizacaoNotificacaoFiscalizacao)
    {
        $this->fkFiscalizacaoNotificacaoFiscalizacoes->removeElement($fkFiscalizacaoNotificacaoFiscalizacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoNotificacaoFiscalizacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoFiscalizacao
     */
    public function getFkFiscalizacaoNotificacaoFiscalizacoes()
    {
        return $this->fkFiscalizacaoNotificacaoFiscalizacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoProcessoFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal $fkFiscalizacaoProcessoFiscal
     * @return FiscalProcessoFiscal
     */
    public function setFkFiscalizacaoProcessoFiscal(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal $fkFiscalizacaoProcessoFiscal)
    {
        $this->codProcesso = $fkFiscalizacaoProcessoFiscal->getCodProcesso();
        $this->fkFiscalizacaoProcessoFiscal = $fkFiscalizacaoProcessoFiscal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoProcessoFiscal
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal
     */
    public function getFkFiscalizacaoProcessoFiscal()
    {
        return $this->fkFiscalizacaoProcessoFiscal;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\Fiscal $fkFiscalizacaoFiscal
     * @return FiscalProcessoFiscal
     */
    public function setFkFiscalizacaoFiscal(\Urbem\CoreBundle\Entity\Fiscalizacao\Fiscal $fkFiscalizacaoFiscal)
    {
        $this->codFiscal = $fkFiscalizacaoFiscal->getCodFiscal();
        $this->fkFiscalizacaoFiscal = $fkFiscalizacaoFiscal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoFiscal
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\Fiscal
     */
    public function getFkFiscalizacaoFiscal()
    {
        return $this->fkFiscalizacaoFiscal;
    }
}
