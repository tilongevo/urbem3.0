<?php
 
namespace Urbem\CoreBundle\Entity\Frota;

/**
 * Motorista
 */
class Motorista
{
    /**
     * PK
     * @var integer
     */
    private $cgmMotorista;

    /**
     * @var boolean
     */
    private $ativo;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Infracao
     */
    private $fkFrotaInfracoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\UtilizacaoRetorno
     */
    private $fkFrotaUtilizacaoRetornos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Utilizacao
     */
    private $fkFrotaUtilizacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\MotoristaVeiculo
     */
    private $fkFrotaMotoristaVeiculos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFrotaInfracoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaUtilizacaoRetornos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaUtilizacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaMotoristaVeiculos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set cgmMotorista
     *
     * @param integer $cgmMotorista
     * @return Motorista
     */
    public function setCgmMotorista($cgmMotorista)
    {
        $this->cgmMotorista = $cgmMotorista;
        return $this;
    }

    /**
     * Get cgmMotorista
     *
     * @return integer
     */
    public function getCgmMotorista()
    {
        return $this->cgmMotorista;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return Motorista
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
     * Add FrotaInfracao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Infracao $fkFrotaInfracao
     * @return Motorista
     */
    public function addFkFrotaInfracoes(\Urbem\CoreBundle\Entity\Frota\Infracao $fkFrotaInfracao)
    {
        if (false === $this->fkFrotaInfracoes->contains($fkFrotaInfracao)) {
            $fkFrotaInfracao->setFkFrotaMotorista($this);
            $this->fkFrotaInfracoes->add($fkFrotaInfracao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaInfracao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Infracao $fkFrotaInfracao
     */
    public function removeFkFrotaInfracoes(\Urbem\CoreBundle\Entity\Frota\Infracao $fkFrotaInfracao)
    {
        $this->fkFrotaInfracoes->removeElement($fkFrotaInfracao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaInfracoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Infracao
     */
    public function getFkFrotaInfracoes()
    {
        return $this->fkFrotaInfracoes;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaUtilizacaoRetorno
     *
     * @param \Urbem\CoreBundle\Entity\Frota\UtilizacaoRetorno $fkFrotaUtilizacaoRetorno
     * @return Motorista
     */
    public function addFkFrotaUtilizacaoRetornos(\Urbem\CoreBundle\Entity\Frota\UtilizacaoRetorno $fkFrotaUtilizacaoRetorno)
    {
        if (false === $this->fkFrotaUtilizacaoRetornos->contains($fkFrotaUtilizacaoRetorno)) {
            $fkFrotaUtilizacaoRetorno->setFkFrotaMotorista($this);
            $this->fkFrotaUtilizacaoRetornos->add($fkFrotaUtilizacaoRetorno);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaUtilizacaoRetorno
     *
     * @param \Urbem\CoreBundle\Entity\Frota\UtilizacaoRetorno $fkFrotaUtilizacaoRetorno
     */
    public function removeFkFrotaUtilizacaoRetornos(\Urbem\CoreBundle\Entity\Frota\UtilizacaoRetorno $fkFrotaUtilizacaoRetorno)
    {
        $this->fkFrotaUtilizacaoRetornos->removeElement($fkFrotaUtilizacaoRetorno);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaUtilizacaoRetornos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\UtilizacaoRetorno
     */
    public function getFkFrotaUtilizacaoRetornos()
    {
        return $this->fkFrotaUtilizacaoRetornos;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaUtilizacao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Utilizacao $fkFrotaUtilizacao
     * @return Motorista
     */
    public function addFkFrotaUtilizacoes(\Urbem\CoreBundle\Entity\Frota\Utilizacao $fkFrotaUtilizacao)
    {
        if (false === $this->fkFrotaUtilizacoes->contains($fkFrotaUtilizacao)) {
            $fkFrotaUtilizacao->setFkFrotaMotorista($this);
            $this->fkFrotaUtilizacoes->add($fkFrotaUtilizacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaUtilizacao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Utilizacao $fkFrotaUtilizacao
     */
    public function removeFkFrotaUtilizacoes(\Urbem\CoreBundle\Entity\Frota\Utilizacao $fkFrotaUtilizacao)
    {
        $this->fkFrotaUtilizacoes->removeElement($fkFrotaUtilizacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaUtilizacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\Utilizacao
     */
    public function getFkFrotaUtilizacoes()
    {
        return $this->fkFrotaUtilizacoes;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaMotoristaVeiculo
     *
     * @param \Urbem\CoreBundle\Entity\Frota\MotoristaVeiculo $fkFrotaMotoristaVeiculo
     * @return Motorista
     */
    public function addFkFrotaMotoristaVeiculos(\Urbem\CoreBundle\Entity\Frota\MotoristaVeiculo $fkFrotaMotoristaVeiculo)
    {
        if (false === $this->fkFrotaMotoristaVeiculos->contains($fkFrotaMotoristaVeiculo)) {
            $fkFrotaMotoristaVeiculo->setFkFrotaMotorista($this);
            $this->fkFrotaMotoristaVeiculos->add($fkFrotaMotoristaVeiculo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaMotoristaVeiculo
     *
     * @param \Urbem\CoreBundle\Entity\Frota\MotoristaVeiculo $fkFrotaMotoristaVeiculo
     */
    public function removeFkFrotaMotoristaVeiculos(\Urbem\CoreBundle\Entity\Frota\MotoristaVeiculo $fkFrotaMotoristaVeiculo)
    {
        $this->fkFrotaMotoristaVeiculos->removeElement($fkFrotaMotoristaVeiculo);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaMotoristaVeiculos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\MotoristaVeiculo
     */
    public function getFkFrotaMotoristaVeiculos()
    {
        return $this->fkFrotaMotoristaVeiculos;
    }

    /**
     * OneToOne (owning side)
     * Set SwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return Motorista
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->cgmMotorista = $fkSwCgm->getNumcgm();
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
        return (string) $this->fkSwCgm;
    }
}
