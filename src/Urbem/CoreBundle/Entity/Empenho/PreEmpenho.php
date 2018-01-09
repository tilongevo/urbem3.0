<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * PreEmpenho
 */
class PreEmpenho
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
    private $codPreEmpenho;

    /**
     * @var integer
     */
    private $codHistorico;

    /**
     * @var integer
     */
    private $cgmBeneficiario;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * @var integer
     */
    private $cgmUsuario;

    /**
     * @var boolean
     */
    private $implantado = false;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    private $fkEmpenhoEmpenho;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Empenho\PreEmpenhoDespesa
     */
    private $fkEmpenhoPreEmpenhoDespesa;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Empenho\RestosPreEmpenho
     */
    private $fkEmpenhoRestosPreEmpenho;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\AtributoEmpenhoValor
     */
    private $fkEmpenhoAtributoEmpenhoValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho
     */
    private $fkEmpenhoItemPreEmpenhos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ContratoAditivoItem
     */
    private $fkTcemgContratoAditivoItens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho
     */
    private $fkEmpenhoAutorizacaoEmpenhos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\Historico
     */
    private $fkEmpenhoHistorico;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\TipoEmpenho
     */
    private $fkEmpenhoTipoEmpenho;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEmpenhoAtributoEmpenhoValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoItemPreEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgContratoAditivoItens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoAutorizacaoEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return PreEmpenho
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
     * Set codPreEmpenho
     *
     * @param integer $codPreEmpenho
     * @return PreEmpenho
     */
    public function setCodPreEmpenho($codPreEmpenho)
    {
        $this->codPreEmpenho = $codPreEmpenho;
        return $this;
    }

    /**
     * Get codPreEmpenho
     *
     * @return integer
     */
    public function getCodPreEmpenho()
    {
        return $this->codPreEmpenho;
    }

    /**
     * Set codHistorico
     *
     * @param integer $codHistorico
     * @return PreEmpenho
     */
    public function setCodHistorico($codHistorico)
    {
        $this->codHistorico = $codHistorico;
        return $this;
    }

    /**
     * Get codHistorico
     *
     * @return integer
     */
    public function getCodHistorico()
    {
        return $this->codHistorico;
    }

    /**
     * Set cgmBeneficiario
     *
     * @param integer $cgmBeneficiario
     * @return PreEmpenho
     */
    public function setCgmBeneficiario($cgmBeneficiario)
    {
        $this->cgmBeneficiario = $cgmBeneficiario;
        return $this;
    }

    /**
     * Get cgmBeneficiario
     *
     * @return integer
     */
    public function getCgmBeneficiario()
    {
        return $this->cgmBeneficiario;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return PreEmpenho
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
     * Set cgmUsuario
     *
     * @param integer $cgmUsuario
     * @return PreEmpenho
     */
    public function setCgmUsuario($cgmUsuario)
    {
        $this->cgmUsuario = $cgmUsuario;
        return $this;
    }

    /**
     * Get cgmUsuario
     *
     * @return integer
     */
    public function getCgmUsuario()
    {
        return $this->cgmUsuario;
    }

    /**
     * Set implantado
     *
     * @param boolean $implantado
     * @return PreEmpenho
     */
    public function setImplantado($implantado = null)
    {
        $this->implantado = $implantado;
        return $this;
    }

    /**
     * Get implantado
     *
     * @return boolean
     */
    public function getImplantado()
    {
        return $this->implantado;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return PreEmpenho
     */
    public function setDescricao($descricao = null)
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
     * OneToMany (owning side)
     * Add EmpenhoAtributoEmpenhoValor
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\AtributoEmpenhoValor $fkEmpenhoAtributoEmpenhoValor
     * @return PreEmpenho
     */
    public function addFkEmpenhoAtributoEmpenhoValores(\Urbem\CoreBundle\Entity\Empenho\AtributoEmpenhoValor $fkEmpenhoAtributoEmpenhoValor)
    {
        if (false === $this->fkEmpenhoAtributoEmpenhoValores->contains($fkEmpenhoAtributoEmpenhoValor)) {
            $fkEmpenhoAtributoEmpenhoValor->setFkEmpenhoPreEmpenho($this);
            $this->fkEmpenhoAtributoEmpenhoValores->add($fkEmpenhoAtributoEmpenhoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoAtributoEmpenhoValor
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\AtributoEmpenhoValor $fkEmpenhoAtributoEmpenhoValor
     */
    public function removeFkEmpenhoAtributoEmpenhoValores(\Urbem\CoreBundle\Entity\Empenho\AtributoEmpenhoValor $fkEmpenhoAtributoEmpenhoValor)
    {
        $this->fkEmpenhoAtributoEmpenhoValores->removeElement($fkEmpenhoAtributoEmpenhoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoAtributoEmpenhoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\AtributoEmpenhoValor
     */
    public function getFkEmpenhoAtributoEmpenhoValores()
    {
        return $this->fkEmpenhoAtributoEmpenhoValores;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoItemPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho $fkEmpenhoItemPreEmpenho
     * @return PreEmpenho
     */
    public function addFkEmpenhoItemPreEmpenhos(\Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho $fkEmpenhoItemPreEmpenho)
    {
        if (false === $this->fkEmpenhoItemPreEmpenhos->contains($fkEmpenhoItemPreEmpenho)) {
            $fkEmpenhoItemPreEmpenho->setFkEmpenhoPreEmpenho($this);
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
     * Add TcemgContratoAditivoItem
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContratoAditivoItem $fkTcemgContratoAditivoItem
     * @return PreEmpenho
     */
    public function addFkTcemgContratoAditivoItens(\Urbem\CoreBundle\Entity\Tcemg\ContratoAditivoItem $fkTcemgContratoAditivoItem)
    {
        if (false === $this->fkTcemgContratoAditivoItens->contains($fkTcemgContratoAditivoItem)) {
            $fkTcemgContratoAditivoItem->setFkEmpenhoPreEmpenho($this);
            $this->fkTcemgContratoAditivoItens->add($fkTcemgContratoAditivoItem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgContratoAditivoItem
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContratoAditivoItem $fkTcemgContratoAditivoItem
     */
    public function removeFkTcemgContratoAditivoItens(\Urbem\CoreBundle\Entity\Tcemg\ContratoAditivoItem $fkTcemgContratoAditivoItem)
    {
        $this->fkTcemgContratoAditivoItens->removeElement($fkTcemgContratoAditivoItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgContratoAditivoItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ContratoAditivoItem
     */
    public function getFkTcemgContratoAditivoItens()
    {
        return $this->fkTcemgContratoAditivoItens;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoAutorizacaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho $fkEmpenhoAutorizacaoEmpenho
     * @return PreEmpenho
     */
    public function addFkEmpenhoAutorizacaoEmpenhos(\Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho $fkEmpenhoAutorizacaoEmpenho)
    {
        if (false === $this->fkEmpenhoAutorizacaoEmpenhos->contains($fkEmpenhoAutorizacaoEmpenho)) {
            $fkEmpenhoAutorizacaoEmpenho->setFkEmpenhoPreEmpenho($this);
            $this->fkEmpenhoAutorizacaoEmpenhos->add($fkEmpenhoAutorizacaoEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoAutorizacaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho $fkEmpenhoAutorizacaoEmpenho
     */
    public function removeFkEmpenhoAutorizacaoEmpenhos(\Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho $fkEmpenhoAutorizacaoEmpenho)
    {
        $this->fkEmpenhoAutorizacaoEmpenhos->removeElement($fkEmpenhoAutorizacaoEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoAutorizacaoEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho
     */
    public function getFkEmpenhoAutorizacaoEmpenhos()
    {
        return $this->fkEmpenhoAutorizacaoEmpenhos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoHistorico
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\Historico $fkEmpenhoHistorico
     * @return PreEmpenho
     */
    public function setFkEmpenhoHistorico(\Urbem\CoreBundle\Entity\Empenho\Historico $fkEmpenhoHistorico)
    {
        $this->codHistorico = $fkEmpenhoHistorico->getCodHistorico();
        $this->exercicio = $fkEmpenhoHistorico->getExercicio();
        $this->fkEmpenhoHistorico = $fkEmpenhoHistorico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoHistorico
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\Historico
     */
    public function getFkEmpenhoHistorico()
    {
        return $this->fkEmpenhoHistorico;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return PreEmpenho
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->cgmBeneficiario = $fkSwCgm->getNumcgm();
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

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoTipoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\TipoEmpenho $fkEmpenhoTipoEmpenho
     * @return PreEmpenho
     */
    public function setFkEmpenhoTipoEmpenho(\Urbem\CoreBundle\Entity\Empenho\TipoEmpenho $fkEmpenhoTipoEmpenho)
    {
        $this->codTipo = $fkEmpenhoTipoEmpenho->getCodTipo();
        $this->fkEmpenhoTipoEmpenho = $fkEmpenhoTipoEmpenho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoTipoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\TipoEmpenho
     */
    public function getFkEmpenhoTipoEmpenho()
    {
        return $this->fkEmpenhoTipoEmpenho;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return PreEmpenho
     */
    public function setFkAdministracaoUsuario(\Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario)
    {
        $this->cgmUsuario = $fkAdministracaoUsuario->getNumcgm();
        $this->fkAdministracaoUsuario = $fkAdministracaoUsuario;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoUsuario
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    public function getFkAdministracaoUsuario()
    {
        return $this->fkAdministracaoUsuario;
    }

    /**
     * OneToOne (inverse side)
     * Set EmpenhoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho
     * @return PreEmpenho
     */
    public function setFkEmpenhoEmpenho(\Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho)
    {
        $fkEmpenhoEmpenho->setFkEmpenhoPreEmpenho($this);
        $this->fkEmpenhoEmpenho = $fkEmpenhoEmpenho;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEmpenhoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    public function getFkEmpenhoEmpenho()
    {
        return $this->fkEmpenhoEmpenho;
    }

    /**
     * OneToOne (inverse side)
     * Set EmpenhoPreEmpenhoDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\PreEmpenhoDespesa $fkEmpenhoPreEmpenhoDespesa
     * @return PreEmpenho
     */
    public function setFkEmpenhoPreEmpenhoDespesa(\Urbem\CoreBundle\Entity\Empenho\PreEmpenhoDespesa $fkEmpenhoPreEmpenhoDespesa)
    {
        $fkEmpenhoPreEmpenhoDespesa->setFkEmpenhoPreEmpenho($this);
        $this->fkEmpenhoPreEmpenhoDespesa = $fkEmpenhoPreEmpenhoDespesa;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEmpenhoPreEmpenhoDespesa
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\PreEmpenhoDespesa
     */
    public function getFkEmpenhoPreEmpenhoDespesa()
    {
        return $this->fkEmpenhoPreEmpenhoDespesa;
    }

    /**
     * OneToOne (inverse side)
     * Set EmpenhoRestosPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\RestosPreEmpenho $fkEmpenhoRestosPreEmpenho
     * @return PreEmpenho
     */
    public function setFkEmpenhoRestosPreEmpenho(\Urbem\CoreBundle\Entity\Empenho\RestosPreEmpenho $fkEmpenhoRestosPreEmpenho)
    {
        $fkEmpenhoRestosPreEmpenho->setFkEmpenhoPreEmpenho($this);
        $this->fkEmpenhoRestosPreEmpenho = $fkEmpenhoRestosPreEmpenho;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEmpenhoRestosPreEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\RestosPreEmpenho
     */
    public function getFkEmpenhoRestosPreEmpenho()
    {
        return $this->fkEmpenhoRestosPreEmpenho;
    }

    /**
     * @return int|null
     */
    public function getCodEntidade()
    {
        if (0 < $this->getFkEmpenhoAutorizacaoEmpenhos()->count()) {
            return $this->getFkEmpenhoAutorizacaoEmpenhos()->last()->getCodEntidade();
        }

        if (null !== $this->getFkEmpenhoEmpenho()) {
            return $this->getFkEmpenhoEmpenho()->getCodEntidade();
        }

        return null;
    }

    /**
     * @return string|null
     */
    public function getAutorizacao()
    {
        /** @var $autorizacaoEmpenho AutorizacaoEmpenho */
        $autorizacaoEmpenho = $this->getFkEmpenhoAutorizacaoEmpenhos()->last();

        if (null !== $autorizacaoEmpenho) {
            if (!empty($autorizacaoEmpenho)) {
                return sprintf('%s/%s', $autorizacaoEmpenho->getCodAutorizacao(), $autorizacaoEmpenho->getExercicio());
            }
        }

        return null;
    }

    /**
     * @return string
     */
    public function getEmpenhoExercicio()
    {
        return (string) $this->getFkEmpenhoEmpenho();
    }

    /**
     * @return string|null
     */
    public function getDtAutorizacao()
    {
        /** @var $autorizacaoEmpenho AutorizacaoEmpenho */
        $autorizacaoEmpenho = $this->getFkEmpenhoAutorizacaoEmpenhos()->last();

        if (null !== $autorizacaoEmpenho) {
            if (!empty($autorizacaoEmpenho)) {
                return $autorizacaoEmpenho->getDtAutorizacao()->format('d/m/Y');
            }
        }

        return null;
    }

    /**
     * @return \DateTime|null
     */
    public function getDtEmpenho()
    {
        if (null !== $this->getFkEmpenhoEmpenho()) {
            return $this->getFkEmpenhoEmpenho()->getDtEmpenho();
        }

        return null;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->codPreEmpenho;
    }
}
