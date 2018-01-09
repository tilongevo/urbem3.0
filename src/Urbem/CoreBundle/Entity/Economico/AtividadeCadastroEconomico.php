<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * AtividadeCadastroEconomico
 */
class AtividadeCadastroEconomico
{
    /**
     * PK
     * @var integer
     */
    private $inscricaoEconomica;

    /**
     * PK
     * @var integer
     */
    private $codAtividade;

    /**
     * PK
     * @var integer
     */
    private $ocorrenciaAtividade;

    /**
     * @var boolean
     */
    private $principal = false;

    /**
     * @var \DateTime
     */
    private $dtInicio;

    /**
     * @var \DateTime
     */
    private $dtTermino;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\CadastroEconomicoModalidadeLancamento
     */
    private $fkEconomicoCadastroEconomicoModalidadeLancamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\LicencaAtividade
     */
    private $fkEconomicoLicencaAtividades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\LicencaEspecial
     */
    private $fkEconomicoLicencaEspeciais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ElementoAtivCadEconomico
     */
    private $fkEconomicoElementoAtivCadEconomicos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\CadastroEconomico
     */
    private $fkEconomicoCadastroEconomico;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\Atividade
     */
    private $fkEconomicoAtividade;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoCadastroEconomicoModalidadeLancamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoLicencaAtividades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoLicencaEspeciais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoElementoAtivCadEconomicos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dtInicio = new \DateTime;
    }

    /**
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return AtividadeCadastroEconomico
     */
    public function setInscricaoEconomica($inscricaoEconomica)
    {
        $this->inscricaoEconomica = $inscricaoEconomica;
        return $this;
    }

    /**
     * Get inscricaoEconomica
     *
     * @return integer
     */
    public function getInscricaoEconomica()
    {
        return $this->inscricaoEconomica;
    }

    /**
     * Set codAtividade
     *
     * @param integer $codAtividade
     * @return AtividadeCadastroEconomico
     */
    public function setCodAtividade($codAtividade)
    {
        $this->codAtividade = $codAtividade;
        return $this;
    }

    /**
     * Get codAtividade
     *
     * @return integer
     */
    public function getCodAtividade()
    {
        return $this->codAtividade;
    }

    /**
     * Set ocorrenciaAtividade
     *
     * @param integer $ocorrenciaAtividade
     * @return AtividadeCadastroEconomico
     */
    public function setOcorrenciaAtividade($ocorrenciaAtividade)
    {
        $this->ocorrenciaAtividade = $ocorrenciaAtividade;
        return $this;
    }

    /**
     * Get ocorrenciaAtividade
     *
     * @return integer
     */
    public function getOcorrenciaAtividade()
    {
        return $this->ocorrenciaAtividade;
    }

    /**
     * Set principal
     *
     * @param boolean $principal
     * @return AtividadeCadastroEconomico
     */
    public function setPrincipal($principal)
    {
        $this->principal = $principal;
        return $this;
    }

    /**
     * Get principal
     *
     * @return boolean
     */
    public function getPrincipal()
    {
        return $this->principal;
    }

    /**
     * Set dtInicio
     *
     * @param \DateTime $dtInicio
     * @return AtividadeCadastroEconomico
     */
    public function setDtInicio(\DateTime $dtInicio)
    {
        $this->dtInicio = $dtInicio;
        return $this;
    }

    /**
     * Get dtInicio
     *
     * @return \DateTime
     */
    public function getDtInicio()
    {
        return $this->dtInicio;
    }

    /**
     * Set dtTermino
     *
     * @param \DateTime $dtTermino
     * @return AtividadeCadastroEconomico
     */
    public function setDtTermino(\DateTime $dtTermino = null)
    {
        $this->dtTermino = $dtTermino;
        return $this;
    }

    /**
     * Get dtTermino
     *
     * @return \DateTime
     */
    public function getDtTermino()
    {
        return $this->dtTermino;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoCadastroEconomicoModalidadeLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconomicoModalidadeLancamento $fkEconomicoCadastroEconomicoModalidadeLancamento
     * @return AtividadeCadastroEconomico
     */
    public function addFkEconomicoCadastroEconomicoModalidadeLancamentos(\Urbem\CoreBundle\Entity\Economico\CadastroEconomicoModalidadeLancamento $fkEconomicoCadastroEconomicoModalidadeLancamento)
    {
        if (false === $this->fkEconomicoCadastroEconomicoModalidadeLancamentos->contains($fkEconomicoCadastroEconomicoModalidadeLancamento)) {
            $fkEconomicoCadastroEconomicoModalidadeLancamento->setFkEconomicoAtividadeCadastroEconomico($this);
            $this->fkEconomicoCadastroEconomicoModalidadeLancamentos->add($fkEconomicoCadastroEconomicoModalidadeLancamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoCadastroEconomicoModalidadeLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconomicoModalidadeLancamento $fkEconomicoCadastroEconomicoModalidadeLancamento
     */
    public function removeFkEconomicoCadastroEconomicoModalidadeLancamentos(\Urbem\CoreBundle\Entity\Economico\CadastroEconomicoModalidadeLancamento $fkEconomicoCadastroEconomicoModalidadeLancamento)
    {
        $this->fkEconomicoCadastroEconomicoModalidadeLancamentos->removeElement($fkEconomicoCadastroEconomicoModalidadeLancamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoCadastroEconomicoModalidadeLancamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\CadastroEconomicoModalidadeLancamento
     */
    public function getFkEconomicoCadastroEconomicoModalidadeLancamentos()
    {
        return $this->fkEconomicoCadastroEconomicoModalidadeLancamentos;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoLicencaAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\LicencaAtividade $fkEconomicoLicencaAtividade
     * @return AtividadeCadastroEconomico
     */
    public function addFkEconomicoLicencaAtividades(\Urbem\CoreBundle\Entity\Economico\LicencaAtividade $fkEconomicoLicencaAtividade)
    {
        if (false === $this->fkEconomicoLicencaAtividades->contains($fkEconomicoLicencaAtividade)) {
            $fkEconomicoLicencaAtividade->setFkEconomicoAtividadeCadastroEconomico($this);
            $this->fkEconomicoLicencaAtividades->add($fkEconomicoLicencaAtividade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoLicencaAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\LicencaAtividade $fkEconomicoLicencaAtividade
     */
    public function removeFkEconomicoLicencaAtividades(\Urbem\CoreBundle\Entity\Economico\LicencaAtividade $fkEconomicoLicencaAtividade)
    {
        $this->fkEconomicoLicencaAtividades->removeElement($fkEconomicoLicencaAtividade);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoLicencaAtividades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\LicencaAtividade
     */
    public function getFkEconomicoLicencaAtividades()
    {
        return $this->fkEconomicoLicencaAtividades;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoLicencaEspecial
     *
     * @param \Urbem\CoreBundle\Entity\Economico\LicencaEspecial $fkEconomicoLicencaEspecial
     * @return AtividadeCadastroEconomico
     */
    public function addFkEconomicoLicencaEspeciais(\Urbem\CoreBundle\Entity\Economico\LicencaEspecial $fkEconomicoLicencaEspecial)
    {
        if (false === $this->fkEconomicoLicencaEspeciais->contains($fkEconomicoLicencaEspecial)) {
            $fkEconomicoLicencaEspecial->setFkEconomicoAtividadeCadastroEconomico($this);
            $this->fkEconomicoLicencaEspeciais->add($fkEconomicoLicencaEspecial);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoLicencaEspecial
     *
     * @param \Urbem\CoreBundle\Entity\Economico\LicencaEspecial $fkEconomicoLicencaEspecial
     */
    public function removeFkEconomicoLicencaEspeciais(\Urbem\CoreBundle\Entity\Economico\LicencaEspecial $fkEconomicoLicencaEspecial)
    {
        $this->fkEconomicoLicencaEspeciais->removeElement($fkEconomicoLicencaEspecial);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoLicencaEspeciais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\LicencaEspecial
     */
    public function getFkEconomicoLicencaEspeciais()
    {
        return $this->fkEconomicoLicencaEspeciais;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoElementoAtivCadEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ElementoAtivCadEconomico $fkEconomicoElementoAtivCadEconomico
     * @return AtividadeCadastroEconomico
     */
    public function addFkEconomicoElementoAtivCadEconomicos(\Urbem\CoreBundle\Entity\Economico\ElementoAtivCadEconomico $fkEconomicoElementoAtivCadEconomico)
    {
        if (false === $this->fkEconomicoElementoAtivCadEconomicos->contains($fkEconomicoElementoAtivCadEconomico)) {
            $fkEconomicoElementoAtivCadEconomico->setFkEconomicoAtividadeCadastroEconomico($this);
            $this->fkEconomicoElementoAtivCadEconomicos->add($fkEconomicoElementoAtivCadEconomico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoElementoAtivCadEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ElementoAtivCadEconomico $fkEconomicoElementoAtivCadEconomico
     */
    public function removeFkEconomicoElementoAtivCadEconomicos(\Urbem\CoreBundle\Entity\Economico\ElementoAtivCadEconomico $fkEconomicoElementoAtivCadEconomico)
    {
        $this->fkEconomicoElementoAtivCadEconomicos->removeElement($fkEconomicoElementoAtivCadEconomico);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoElementoAtivCadEconomicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ElementoAtivCadEconomico
     */
    public function getFkEconomicoElementoAtivCadEconomicos()
    {
        return $this->fkEconomicoElementoAtivCadEconomicos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoCadastroEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconomico $fkEconomicoCadastroEconomico
     * @return AtividadeCadastroEconomico
     */
    public function setFkEconomicoCadastroEconomico(\Urbem\CoreBundle\Entity\Economico\CadastroEconomico $fkEconomicoCadastroEconomico)
    {
        $this->inscricaoEconomica = $fkEconomicoCadastroEconomico->getInscricaoEconomica();
        $this->fkEconomicoCadastroEconomico = $fkEconomicoCadastroEconomico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoCadastroEconomico
     *
     * @return \Urbem\CoreBundle\Entity\Economico\CadastroEconomico
     */
    public function getFkEconomicoCadastroEconomico()
    {
        return $this->fkEconomicoCadastroEconomico;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Atividade $fkEconomicoAtividade
     * @return AtividadeCadastroEconomico
     */
    public function setFkEconomicoAtividade(\Urbem\CoreBundle\Entity\Economico\Atividade $fkEconomicoAtividade)
    {
        $this->codAtividade = $fkEconomicoAtividade->getCodAtividade();
        $this->fkEconomicoAtividade = $fkEconomicoAtividade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoAtividade
     *
     * @return \Urbem\CoreBundle\Entity\Economico\Atividade
     */
    public function getFkEconomicoAtividade()
    {
        return $this->fkEconomicoAtividade;
    }
}
