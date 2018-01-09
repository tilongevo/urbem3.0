<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * PlanoBanco
 */
class PlanoBanco
{
    /**
     * PK
     * @var integer
     */
    private $codPlano;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $contaCorrente;

    /**
     * @var integer
     */
    private $codEntidade = 0;

    /**
     * @var integer
     */
    private $codBanco;

    /**
     * @var integer
     */
    private $codAgencia;

    /**
     * @var integer
     */
    private $codContaCorrente;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tesouraria\SaldoTesouraria
     */
    private $fkTesourariaSaldoTesouraria;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    private $fkContabilidadePlanoAnalitica;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\PlanoBancoTipoContaBanco
     */
    private $fkTcepePlanoBancoTipoContaBancos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\OrgaoPlanoBanco
     */
    private $fkTcmgoOrgaoPlanoBancos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Bordero
     */
    private $fkTesourariaBorderos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Conciliacao
     */
    private $fkTesourariaConciliacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\TransacoesTransferencia
     */
    private $fkTesourariaTransacoesTransferencias;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\ContaCorrente
     */
    private $fkMonetarioContaCorrente;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcepePlanoBancoTipoContaBancos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoOrgaoPlanoBancos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaBorderos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaConciliacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaTransacoesTransferencias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codPlano
     *
     * @param integer $codPlano
     * @return PlanoBanco
     */
    public function setCodPlano($codPlano)
    {
        $this->codPlano = $codPlano;
        return $this;
    }

    /**
     * Get codPlano
     *
     * @return integer
     */
    public function getCodPlano()
    {
        return $this->codPlano;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return PlanoBanco
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
     * Set contaCorrente
     *
     * @param string $contaCorrente
     * @return PlanoBanco
     */
    public function setContaCorrente($contaCorrente)
    {
        $this->contaCorrente = $contaCorrente;
        return $this;
    }

    /**
     * Get contaCorrente
     *
     * @return string
     */
    public function getContaCorrente()
    {
        return $this->contaCorrente;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return PlanoBanco
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
     * Set codBanco
     *
     * @param integer $codBanco
     * @return PlanoBanco
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
     * Set codAgencia
     *
     * @param integer $codAgencia
     * @return PlanoBanco
     */
    public function setCodAgencia($codAgencia)
    {
        $this->codAgencia = $codAgencia;
        return $this;
    }

    /**
     * Get codAgencia
     *
     * @return integer
     */
    public function getCodAgencia()
    {
        return $this->codAgencia;
    }

    /**
     * Set codContaCorrente
     *
     * @param integer $codContaCorrente
     * @return PlanoBanco
     */
    public function setCodContaCorrente($codContaCorrente)
    {
        $this->codContaCorrente = $codContaCorrente;
        return $this;
    }

    /**
     * Get codContaCorrente
     *
     * @return integer
     */
    public function getCodContaCorrente()
    {
        return $this->codContaCorrente;
    }

    /**
     * OneToMany (owning side)
     * Add TcepePlanoBancoTipoContaBanco
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\PlanoBancoTipoContaBanco $fkTcepePlanoBancoTipoContaBanco
     * @return PlanoBanco
     */
    public function addFkTcepePlanoBancoTipoContaBancos(\Urbem\CoreBundle\Entity\Tcepe\PlanoBancoTipoContaBanco $fkTcepePlanoBancoTipoContaBanco)
    {
        if (false === $this->fkTcepePlanoBancoTipoContaBancos->contains($fkTcepePlanoBancoTipoContaBanco)) {
            $fkTcepePlanoBancoTipoContaBanco->setFkContabilidadePlanoBanco($this);
            $this->fkTcepePlanoBancoTipoContaBancos->add($fkTcepePlanoBancoTipoContaBanco);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepePlanoBancoTipoContaBanco
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\PlanoBancoTipoContaBanco $fkTcepePlanoBancoTipoContaBanco
     */
    public function removeFkTcepePlanoBancoTipoContaBancos(\Urbem\CoreBundle\Entity\Tcepe\PlanoBancoTipoContaBanco $fkTcepePlanoBancoTipoContaBanco)
    {
        $this->fkTcepePlanoBancoTipoContaBancos->removeElement($fkTcepePlanoBancoTipoContaBanco);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepePlanoBancoTipoContaBancos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\PlanoBancoTipoContaBanco
     */
    public function getFkTcepePlanoBancoTipoContaBancos()
    {
        return $this->fkTcepePlanoBancoTipoContaBancos;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoOrgaoPlanoBanco
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\OrgaoPlanoBanco $fkTcmgoOrgaoPlanoBanco
     * @return PlanoBanco
     */
    public function addFkTcmgoOrgaoPlanoBancos(\Urbem\CoreBundle\Entity\Tcmgo\OrgaoPlanoBanco $fkTcmgoOrgaoPlanoBanco)
    {
        if (false === $this->fkTcmgoOrgaoPlanoBancos->contains($fkTcmgoOrgaoPlanoBanco)) {
            $fkTcmgoOrgaoPlanoBanco->setFkContabilidadePlanoBanco($this);
            $this->fkTcmgoOrgaoPlanoBancos->add($fkTcmgoOrgaoPlanoBanco);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoOrgaoPlanoBanco
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\OrgaoPlanoBanco $fkTcmgoOrgaoPlanoBanco
     */
    public function removeFkTcmgoOrgaoPlanoBancos(\Urbem\CoreBundle\Entity\Tcmgo\OrgaoPlanoBanco $fkTcmgoOrgaoPlanoBanco)
    {
        $this->fkTcmgoOrgaoPlanoBancos->removeElement($fkTcmgoOrgaoPlanoBanco);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoOrgaoPlanoBancos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\OrgaoPlanoBanco
     */
    public function getFkTcmgoOrgaoPlanoBancos()
    {
        return $this->fkTcmgoOrgaoPlanoBancos;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaBordero
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Bordero $fkTesourariaBordero
     * @return PlanoBanco
     */
    public function addFkTesourariaBorderos(\Urbem\CoreBundle\Entity\Tesouraria\Bordero $fkTesourariaBordero)
    {
        if (false === $this->fkTesourariaBorderos->contains($fkTesourariaBordero)) {
            $fkTesourariaBordero->setFkContabilidadePlanoBanco($this);
            $this->fkTesourariaBorderos->add($fkTesourariaBordero);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaBordero
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Bordero $fkTesourariaBordero
     */
    public function removeFkTesourariaBorderos(\Urbem\CoreBundle\Entity\Tesouraria\Bordero $fkTesourariaBordero)
    {
        $this->fkTesourariaBorderos->removeElement($fkTesourariaBordero);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaBorderos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Bordero
     */
    public function getFkTesourariaBorderos()
    {
        return $this->fkTesourariaBorderos;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaConciliacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Conciliacao $fkTesourariaConciliacao
     * @return PlanoBanco
     */
    public function addFkTesourariaConciliacoes(\Urbem\CoreBundle\Entity\Tesouraria\Conciliacao $fkTesourariaConciliacao)
    {
        if (false === $this->fkTesourariaConciliacoes->contains($fkTesourariaConciliacao)) {
            $fkTesourariaConciliacao->setFkContabilidadePlanoBanco($this);
            $this->fkTesourariaConciliacoes->add($fkTesourariaConciliacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaConciliacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Conciliacao $fkTesourariaConciliacao
     */
    public function removeFkTesourariaConciliacoes(\Urbem\CoreBundle\Entity\Tesouraria\Conciliacao $fkTesourariaConciliacao)
    {
        $this->fkTesourariaConciliacoes->removeElement($fkTesourariaConciliacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaConciliacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Conciliacao
     */
    public function getFkTesourariaConciliacoes()
    {
        return $this->fkTesourariaConciliacoes;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaTransacoesTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransacoesTransferencia $fkTesourariaTransacoesTransferencia
     * @return PlanoBanco
     */
    public function addFkTesourariaTransacoesTransferencias(\Urbem\CoreBundle\Entity\Tesouraria\TransacoesTransferencia $fkTesourariaTransacoesTransferencia)
    {
        if (false === $this->fkTesourariaTransacoesTransferencias->contains($fkTesourariaTransacoesTransferencia)) {
            $fkTesourariaTransacoesTransferencia->setFkContabilidadePlanoBanco($this);
            $this->fkTesourariaTransacoesTransferencias->add($fkTesourariaTransacoesTransferencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaTransacoesTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransacoesTransferencia $fkTesourariaTransacoesTransferencia
     */
    public function removeFkTesourariaTransacoesTransferencias(\Urbem\CoreBundle\Entity\Tesouraria\TransacoesTransferencia $fkTesourariaTransacoesTransferencia)
    {
        $this->fkTesourariaTransacoesTransferencias->removeElement($fkTesourariaTransacoesTransferencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaTransacoesTransferencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\TransacoesTransferencia
     */
    public function getFkTesourariaTransacoesTransferencias()
    {
        return $this->fkTesourariaTransacoesTransferencias;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioContaCorrente
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\ContaCorrente $fkMonetarioContaCorrente
     * @return PlanoBanco
     */
    public function setFkMonetarioContaCorrente(\Urbem\CoreBundle\Entity\Monetario\ContaCorrente $fkMonetarioContaCorrente)
    {
        $this->codBanco = $fkMonetarioContaCorrente->getCodBanco();
        $this->codAgencia = $fkMonetarioContaCorrente->getCodAgencia();
        $this->codContaCorrente = $fkMonetarioContaCorrente->getCodContaCorrente();
        $this->fkMonetarioContaCorrente = $fkMonetarioContaCorrente;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioContaCorrente
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\ContaCorrente
     */
    public function getFkMonetarioContaCorrente()
    {
        return $this->fkMonetarioContaCorrente;
    }

    /**
     * OneToOne (inverse side)
     * Set TesourariaSaldoTesouraria
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\SaldoTesouraria $fkTesourariaSaldoTesouraria
     * @return PlanoBanco
     */
    public function setFkTesourariaSaldoTesouraria(\Urbem\CoreBundle\Entity\Tesouraria\SaldoTesouraria $fkTesourariaSaldoTesouraria)
    {
        $fkTesourariaSaldoTesouraria->setFkContabilidadePlanoBanco($this);
        $this->fkTesourariaSaldoTesouraria = $fkTesourariaSaldoTesouraria;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTesourariaSaldoTesouraria
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\SaldoTesouraria
     */
    public function getFkTesourariaSaldoTesouraria()
    {
        return $this->fkTesourariaSaldoTesouraria;
    }

    /**
     * OneToOne (owning side)
     * Set ContabilidadePlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica
     * @return PlanoBanco
     */
    public function setFkContabilidadePlanoAnalitica(\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica)
    {
        $this->codPlano = $fkContabilidadePlanoAnalitica->getCodPlano();
        $this->exercicio = $fkContabilidadePlanoAnalitica->getExercicio();
        $this->fkContabilidadePlanoAnalitica = $fkContabilidadePlanoAnalitica;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkContabilidadePlanoAnalitica
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    public function getFkContabilidadePlanoAnalitica()
    {
        return $this->fkContabilidadePlanoAnalitica;
    }
}
