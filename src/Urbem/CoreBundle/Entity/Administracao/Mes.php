<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * Mes
 */
class Mes
{
    /**
     * PK
     * @var integer
     */
    private $codMes;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporte
     */
    private $fkBeneficioConcessaoValeTransportes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\CursoInstituicaoEnsinoMes
     */
    private $fkEstagioCursoInstituicaoEnsinoMeses;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\TransporteEscolar
     */
    private $fkFrotaTransporteEscolares;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ExecucaoVariacao
     */
    private $fkTcemgExecucaoVariacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Medidas
     */
    private $fkTcemgMedidas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkBeneficioConcessaoValeTransportes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEstagioCursoInstituicaoEnsinoMeses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaTransporteEscolares = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgExecucaoVariacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgMedidas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codMes
     *
     * @param integer $codMes
     * @return Mes
     */
    public function setCodMes($codMes)
    {
        $this->codMes = $codMes;
        return $this;
    }

    /**
     * Get codMes
     *
     * @return integer
     */
    public function getCodMes()
    {
        return $this->codMes;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Mes
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
     * OneToMany (owning side)
     * Add BeneficioConcessaoValeTransporte
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporte $fkBeneficioConcessaoValeTransporte
     * @return Mes
     */
    public function addFkBeneficioConcessaoValeTransportes(\Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporte $fkBeneficioConcessaoValeTransporte)
    {
        if (false === $this->fkBeneficioConcessaoValeTransportes->contains($fkBeneficioConcessaoValeTransporte)) {
            $fkBeneficioConcessaoValeTransporte->setFkAdministracaoMes($this);
            $this->fkBeneficioConcessaoValeTransportes->add($fkBeneficioConcessaoValeTransporte);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove BeneficioConcessaoValeTransporte
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporte $fkBeneficioConcessaoValeTransporte
     */
    public function removeFkBeneficioConcessaoValeTransportes(\Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporte $fkBeneficioConcessaoValeTransporte)
    {
        $this->fkBeneficioConcessaoValeTransportes->removeElement($fkBeneficioConcessaoValeTransporte);
    }

    /**
     * OneToMany (owning side)
     * Get fkBeneficioConcessaoValeTransportes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporte
     */
    public function getFkBeneficioConcessaoValeTransportes()
    {
        return $this->fkBeneficioConcessaoValeTransportes;
    }

    /**
     * OneToMany (owning side)
     * Add EstagioCursoInstituicaoEnsinoMes
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\CursoInstituicaoEnsinoMes $fkEstagioCursoInstituicaoEnsinoMes
     * @return Mes
     */
    public function addFkEstagioCursoInstituicaoEnsinoMeses(\Urbem\CoreBundle\Entity\Estagio\CursoInstituicaoEnsinoMes $fkEstagioCursoInstituicaoEnsinoMes)
    {
        if (false === $this->fkEstagioCursoInstituicaoEnsinoMeses->contains($fkEstagioCursoInstituicaoEnsinoMes)) {
            $fkEstagioCursoInstituicaoEnsinoMes->setFkAdministracaoMes($this);
            $this->fkEstagioCursoInstituicaoEnsinoMeses->add($fkEstagioCursoInstituicaoEnsinoMes);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EstagioCursoInstituicaoEnsinoMes
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\CursoInstituicaoEnsinoMes $fkEstagioCursoInstituicaoEnsinoMes
     */
    public function removeFkEstagioCursoInstituicaoEnsinoMeses(\Urbem\CoreBundle\Entity\Estagio\CursoInstituicaoEnsinoMes $fkEstagioCursoInstituicaoEnsinoMes)
    {
        $this->fkEstagioCursoInstituicaoEnsinoMeses->removeElement($fkEstagioCursoInstituicaoEnsinoMes);
    }

    /**
     * OneToMany (owning side)
     * Get fkEstagioCursoInstituicaoEnsinoMeses
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\CursoInstituicaoEnsinoMes
     */
    public function getFkEstagioCursoInstituicaoEnsinoMeses()
    {
        return $this->fkEstagioCursoInstituicaoEnsinoMeses;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaTransporteEscolar
     *
     * @param \Urbem\CoreBundle\Entity\Frota\TransporteEscolar $fkFrotaTransporteEscolar
     * @return Mes
     */
    public function addFkFrotaTransporteEscolares(\Urbem\CoreBundle\Entity\Frota\TransporteEscolar $fkFrotaTransporteEscolar)
    {
        if (false === $this->fkFrotaTransporteEscolares->contains($fkFrotaTransporteEscolar)) {
            $fkFrotaTransporteEscolar->setFkAdministracaoMes($this);
            $this->fkFrotaTransporteEscolares->add($fkFrotaTransporteEscolar);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaTransporteEscolar
     *
     * @param \Urbem\CoreBundle\Entity\Frota\TransporteEscolar $fkFrotaTransporteEscolar
     */
    public function removeFkFrotaTransporteEscolares(\Urbem\CoreBundle\Entity\Frota\TransporteEscolar $fkFrotaTransporteEscolar)
    {
        $this->fkFrotaTransporteEscolares->removeElement($fkFrotaTransporteEscolar);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaTransporteEscolares
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\TransporteEscolar
     */
    public function getFkFrotaTransporteEscolares()
    {
        return $this->fkFrotaTransporteEscolares;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgExecucaoVariacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ExecucaoVariacao $fkTcemgExecucaoVariacao
     * @return Mes
     */
    public function addFkTcemgExecucaoVariacoes(\Urbem\CoreBundle\Entity\Tcemg\ExecucaoVariacao $fkTcemgExecucaoVariacao)
    {
        if (false === $this->fkTcemgExecucaoVariacoes->contains($fkTcemgExecucaoVariacao)) {
            $fkTcemgExecucaoVariacao->setFkAdministracaoMes($this);
            $this->fkTcemgExecucaoVariacoes->add($fkTcemgExecucaoVariacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgExecucaoVariacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ExecucaoVariacao $fkTcemgExecucaoVariacao
     */
    public function removeFkTcemgExecucaoVariacoes(\Urbem\CoreBundle\Entity\Tcemg\ExecucaoVariacao $fkTcemgExecucaoVariacao)
    {
        $this->fkTcemgExecucaoVariacoes->removeElement($fkTcemgExecucaoVariacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgExecucaoVariacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ExecucaoVariacao
     */
    public function getFkTcemgExecucaoVariacoes()
    {
        return $this->fkTcemgExecucaoVariacoes;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgMedidas
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Medidas $fkTcemgMedidas
     * @return Mes
     */
    public function addFkTcemgMedidas(\Urbem\CoreBundle\Entity\Tcemg\Medidas $fkTcemgMedidas)
    {
        if (false === $this->fkTcemgMedidas->contains($fkTcemgMedidas)) {
            $fkTcemgMedidas->setFkAdministracaoMes($this);
            $this->fkTcemgMedidas->add($fkTcemgMedidas);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgMedidas
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Medidas $fkTcemgMedidas
     */
    public function removeFkTcemgMedidas(\Urbem\CoreBundle\Entity\Tcemg\Medidas $fkTcemgMedidas)
    {
        $this->fkTcemgMedidas->removeElement($fkTcemgMedidas);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgMedidas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Medidas
     */
    public function getFkTcemgMedidas()
    {
        return $this->fkTcemgMedidas;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '%s - %s',
            $this->codMes,
            $this->descricao
        );
    }
}
