<?php
 
namespace Urbem\CoreBundle\Entity\Calendario;

/**
 * CalendarioCadastro
 */
class CalendarioCadastro
{
    /**
     * PK
     * @var integer
     */
    private $codCalendar;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Calendario\CalendarioPontoFacultativo
     */
    private $fkCalendarioCalendarioPontoFacultativos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Calendario\CalendarioDiaCompensado
     */
    private $fkCalendarioCalendarioDiaCompensados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporteCalendario
     */
    private $fkBeneficioConcessaoValeTransporteCalendarios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Calendario\CalendarioFeriadoVariavel
     */
    private $fkCalendarioCalendarioFeriadoVariaveis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\EstagiarioValeTransporte
     */
    private $fkEstagioEstagiarioValeTransportes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    private $fkOrganogramaOrgoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\CalendarioPonto
     */
    private $fkPontoCalendarioPontos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkCalendarioCalendarioPontoFacultativos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkCalendarioCalendarioDiaCompensados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkBeneficioConcessaoValeTransporteCalendarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkCalendarioCalendarioFeriadoVariaveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEstagioEstagiarioValeTransportes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrganogramaOrgoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPontoCalendarioPontos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codCalendar
     *
     * @param integer $codCalendar
     * @return CalendarioCadastro
     */
    public function setCodCalendar($codCalendar)
    {
        $this->codCalendar = $codCalendar;
        return $this;
    }

    /**
     * Get codCalendar
     *
     * @return integer
     */
    public function getCodCalendar()
    {
        return $this->codCalendar;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return CalendarioCadastro
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
     * Add CalendarioCalendarioPontoFacultativo
     *
     * @param \Urbem\CoreBundle\Entity\Calendario\CalendarioPontoFacultativo $fkCalendarioCalendarioPontoFacultativo
     * @return CalendarioCadastro
     */
    public function addFkCalendarioCalendarioPontoFacultativos(\Urbem\CoreBundle\Entity\Calendario\CalendarioPontoFacultativo $fkCalendarioCalendarioPontoFacultativo)
    {
        if (false === $this->fkCalendarioCalendarioPontoFacultativos->contains($fkCalendarioCalendarioPontoFacultativo)) {
            $fkCalendarioCalendarioPontoFacultativo->setFkCalendarioCalendarioCadastro($this);
            $this->fkCalendarioCalendarioPontoFacultativos->add($fkCalendarioCalendarioPontoFacultativo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CalendarioCalendarioPontoFacultativo
     *
     * @param \Urbem\CoreBundle\Entity\Calendario\CalendarioPontoFacultativo $fkCalendarioCalendarioPontoFacultativo
     */
    public function removeFkCalendarioCalendarioPontoFacultativos(\Urbem\CoreBundle\Entity\Calendario\CalendarioPontoFacultativo $fkCalendarioCalendarioPontoFacultativo)
    {
        $this->fkCalendarioCalendarioPontoFacultativos->removeElement($fkCalendarioCalendarioPontoFacultativo);
    }

    /**
     * OneToMany (owning side)
     * Get fkCalendarioCalendarioPontoFacultativos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Calendario\CalendarioPontoFacultativo
     */
    public function getFkCalendarioCalendarioPontoFacultativos()
    {
        return $this->fkCalendarioCalendarioPontoFacultativos;
    }

    /**
     * OneToMany (owning side)
     * Add CalendarioCalendarioDiaCompensado
     *
     * @param \Urbem\CoreBundle\Entity\Calendario\CalendarioDiaCompensado $fkCalendarioCalendarioDiaCompensado
     * @return CalendarioCadastro
     */
    public function addFkCalendarioCalendarioDiaCompensados(\Urbem\CoreBundle\Entity\Calendario\CalendarioDiaCompensado $fkCalendarioCalendarioDiaCompensado)
    {
        if (false === $this->fkCalendarioCalendarioDiaCompensados->contains($fkCalendarioCalendarioDiaCompensado)) {
            $fkCalendarioCalendarioDiaCompensado->setFkCalendarioCalendarioCadastro($this);
            $this->fkCalendarioCalendarioDiaCompensados->add($fkCalendarioCalendarioDiaCompensado);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CalendarioCalendarioDiaCompensado
     *
     * @param \Urbem\CoreBundle\Entity\Calendario\CalendarioDiaCompensado $fkCalendarioCalendarioDiaCompensado
     */
    public function removeFkCalendarioCalendarioDiaCompensados(\Urbem\CoreBundle\Entity\Calendario\CalendarioDiaCompensado $fkCalendarioCalendarioDiaCompensado)
    {
        $this->fkCalendarioCalendarioDiaCompensados->removeElement($fkCalendarioCalendarioDiaCompensado);
    }

    /**
     * OneToMany (owning side)
     * Get fkCalendarioCalendarioDiaCompensados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Calendario\CalendarioDiaCompensado
     */
    public function getFkCalendarioCalendarioDiaCompensados()
    {
        return $this->fkCalendarioCalendarioDiaCompensados;
    }

    /**
     * OneToMany (owning side)
     * Add BeneficioConcessaoValeTransporteCalendario
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporteCalendario $fkBeneficioConcessaoValeTransporteCalendario
     * @return CalendarioCadastro
     */
    public function addFkBeneficioConcessaoValeTransporteCalendarios(\Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporteCalendario $fkBeneficioConcessaoValeTransporteCalendario)
    {
        if (false === $this->fkBeneficioConcessaoValeTransporteCalendarios->contains($fkBeneficioConcessaoValeTransporteCalendario)) {
            $fkBeneficioConcessaoValeTransporteCalendario->setFkCalendarioCalendarioCadastro($this);
            $this->fkBeneficioConcessaoValeTransporteCalendarios->add($fkBeneficioConcessaoValeTransporteCalendario);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove BeneficioConcessaoValeTransporteCalendario
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporteCalendario $fkBeneficioConcessaoValeTransporteCalendario
     */
    public function removeFkBeneficioConcessaoValeTransporteCalendarios(\Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporteCalendario $fkBeneficioConcessaoValeTransporteCalendario)
    {
        $this->fkBeneficioConcessaoValeTransporteCalendarios->removeElement($fkBeneficioConcessaoValeTransporteCalendario);
    }

    /**
     * OneToMany (owning side)
     * Get fkBeneficioConcessaoValeTransporteCalendarios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporteCalendario
     */
    public function getFkBeneficioConcessaoValeTransporteCalendarios()
    {
        return $this->fkBeneficioConcessaoValeTransporteCalendarios;
    }

    /**
     * OneToMany (owning side)
     * Add CalendarioCalendarioFeriadoVariavel
     *
     * @param \Urbem\CoreBundle\Entity\Calendario\CalendarioFeriadoVariavel $fkCalendarioCalendarioFeriadoVariavel
     * @return CalendarioCadastro
     */
    public function addFkCalendarioCalendarioFeriadoVariaveis(\Urbem\CoreBundle\Entity\Calendario\CalendarioFeriadoVariavel $fkCalendarioCalendarioFeriadoVariavel)
    {
        if (false === $this->fkCalendarioCalendarioFeriadoVariaveis->contains($fkCalendarioCalendarioFeriadoVariavel)) {
            $fkCalendarioCalendarioFeriadoVariavel->setFkCalendarioCalendarioCadastro($this);
            $this->fkCalendarioCalendarioFeriadoVariaveis->add($fkCalendarioCalendarioFeriadoVariavel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CalendarioCalendarioFeriadoVariavel
     *
     * @param \Urbem\CoreBundle\Entity\Calendario\CalendarioFeriadoVariavel $fkCalendarioCalendarioFeriadoVariavel
     */
    public function removeFkCalendarioCalendarioFeriadoVariaveis(\Urbem\CoreBundle\Entity\Calendario\CalendarioFeriadoVariavel $fkCalendarioCalendarioFeriadoVariavel)
    {
        $this->fkCalendarioCalendarioFeriadoVariaveis->removeElement($fkCalendarioCalendarioFeriadoVariavel);
    }

    /**
     * OneToMany (owning side)
     * Get fkCalendarioCalendarioFeriadoVariaveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Calendario\CalendarioFeriadoVariavel
     */
    public function getFkCalendarioCalendarioFeriadoVariaveis()
    {
        return $this->fkCalendarioCalendarioFeriadoVariaveis;
    }

    /**
     * OneToMany (owning side)
     * Add EstagioEstagiarioValeTransporte
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EstagiarioValeTransporte $fkEstagioEstagiarioValeTransporte
     * @return CalendarioCadastro
     */
    public function addFkEstagioEstagiarioValeTransportes(\Urbem\CoreBundle\Entity\Estagio\EstagiarioValeTransporte $fkEstagioEstagiarioValeTransporte)
    {
        if (false === $this->fkEstagioEstagiarioValeTransportes->contains($fkEstagioEstagiarioValeTransporte)) {
            $fkEstagioEstagiarioValeTransporte->setFkCalendarioCalendarioCadastro($this);
            $this->fkEstagioEstagiarioValeTransportes->add($fkEstagioEstagiarioValeTransporte);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EstagioEstagiarioValeTransporte
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EstagiarioValeTransporte $fkEstagioEstagiarioValeTransporte
     */
    public function removeFkEstagioEstagiarioValeTransportes(\Urbem\CoreBundle\Entity\Estagio\EstagiarioValeTransporte $fkEstagioEstagiarioValeTransporte)
    {
        $this->fkEstagioEstagiarioValeTransportes->removeElement($fkEstagioEstagiarioValeTransporte);
    }

    /**
     * OneToMany (owning side)
     * Get fkEstagioEstagiarioValeTransportes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\EstagiarioValeTransporte
     */
    public function getFkEstagioEstagiarioValeTransportes()
    {
        return $this->fkEstagioEstagiarioValeTransportes;
    }

    /**
     * OneToMany (owning side)
     * Add OrganogramaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao
     * @return CalendarioCadastro
     */
    public function addFkOrganogramaOrgoes(\Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao)
    {
        if (false === $this->fkOrganogramaOrgoes->contains($fkOrganogramaOrgao)) {
            $fkOrganogramaOrgao->setFkCalendarioCalendarioCadastro($this);
            $this->fkOrganogramaOrgoes->add($fkOrganogramaOrgao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrganogramaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao
     */
    public function removeFkOrganogramaOrgoes(\Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao)
    {
        $this->fkOrganogramaOrgoes->removeElement($fkOrganogramaOrgao);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrganogramaOrgoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    public function getFkOrganogramaOrgoes()
    {
        return $this->fkOrganogramaOrgoes;
    }

    /**
     * OneToMany (owning side)
     * Add PontoCalendarioPonto
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\CalendarioPonto $fkPontoCalendarioPonto
     * @return CalendarioCadastro
     */
    public function addFkPontoCalendarioPontos(\Urbem\CoreBundle\Entity\Ponto\CalendarioPonto $fkPontoCalendarioPonto)
    {
        if (false === $this->fkPontoCalendarioPontos->contains($fkPontoCalendarioPonto)) {
            $fkPontoCalendarioPonto->setFkCalendarioCalendarioCadastro($this);
            $this->fkPontoCalendarioPontos->add($fkPontoCalendarioPonto);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoCalendarioPonto
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\CalendarioPonto $fkPontoCalendarioPonto
     */
    public function removeFkPontoCalendarioPontos(\Urbem\CoreBundle\Entity\Ponto\CalendarioPonto $fkPontoCalendarioPonto)
    {
        $this->fkPontoCalendarioPontos->removeElement($fkPontoCalendarioPonto);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoCalendarioPontos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\CalendarioPonto
     */
    public function getFkPontoCalendarioPontos()
    {
        return $this->fkPontoCalendarioPontos;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%d - %s', $this->getCodCalendar(), $this->getDescricao());
    }
}
