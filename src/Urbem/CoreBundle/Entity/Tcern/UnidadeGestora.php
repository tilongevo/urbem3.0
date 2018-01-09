<?php
 
namespace Urbem\CoreBundle\Entity\Tcern;

/**
 * UnidadeGestora
 */
class UnidadeGestora
{
    /**
     * PK
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $codInstitucional;

    /**
     * @var integer
     */
    private $cgmUnidade;

    /**
     * @var integer
     */
    private $personalidade;

    /**
     * @var integer
     */
    private $administracao;

    /**
     * @var integer
     */
    private $natureza;

    /**
     * @var integer
     */
    private $codNorma;

    /**
     * @var boolean
     */
    private $situacao;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\UnidadeGestoraResponsavel
     */
    private $fkTcernUnidadeGestoraResponsaveis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\UnidadeOrcamentaria
     */
    private $fkTcernUnidadeOrcamentarias;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcern\NaturezaJuridica
     */
    private $fkTcernNaturezaJuridica;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcernUnidadeGestoraResponsaveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcernUnidadeOrcamentarias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return UnidadeGestora
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set codInstitucional
     *
     * @param integer $codInstitucional
     * @return UnidadeGestora
     */
    public function setCodInstitucional($codInstitucional)
    {
        $this->codInstitucional = $codInstitucional;
        return $this;
    }

    /**
     * Get codInstitucional
     *
     * @return integer
     */
    public function getCodInstitucional()
    {
        return $this->codInstitucional;
    }

    /**
     * Set cgmUnidade
     *
     * @param integer $cgmUnidade
     * @return UnidadeGestora
     */
    public function setCgmUnidade($cgmUnidade)
    {
        $this->cgmUnidade = $cgmUnidade;
        return $this;
    }

    /**
     * Get cgmUnidade
     *
     * @return integer
     */
    public function getCgmUnidade()
    {
        return $this->cgmUnidade;
    }

    /**
     * Set personalidade
     *
     * @param integer $personalidade
     * @return UnidadeGestora
     */
    public function setPersonalidade($personalidade)
    {
        $this->personalidade = $personalidade;
        return $this;
    }

    /**
     * Get personalidade
     *
     * @return integer
     */
    public function getPersonalidade()
    {
        return $this->personalidade;
    }

    /**
     * Set administracao
     *
     * @param integer $administracao
     * @return UnidadeGestora
     */
    public function setAdministracao($administracao)
    {
        $this->administracao = $administracao;
        return $this;
    }

    /**
     * Get administracao
     *
     * @return integer
     */
    public function getAdministracao()
    {
        return $this->administracao;
    }

    /**
     * Set natureza
     *
     * @param integer $natureza
     * @return UnidadeGestora
     */
    public function setNatureza($natureza)
    {
        $this->natureza = $natureza;
        return $this;
    }

    /**
     * Get natureza
     *
     * @return integer
     */
    public function getNatureza()
    {
        return $this->natureza;
    }

    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return UnidadeGestora
     */
    public function setCodNorma($codNorma)
    {
        $this->codNorma = $codNorma;
        return $this;
    }

    /**
     * Get codNorma
     *
     * @return integer
     */
    public function getCodNorma()
    {
        return $this->codNorma;
    }

    /**
     * Set situacao
     *
     * @param boolean $situacao
     * @return UnidadeGestora
     */
    public function setSituacao($situacao)
    {
        $this->situacao = $situacao;
        return $this;
    }

    /**
     * Get situacao
     *
     * @return boolean
     */
    public function getSituacao()
    {
        return $this->situacao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return UnidadeGestora
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
     * OneToMany (owning side)
     * Add TcernUnidadeGestoraResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\UnidadeGestoraResponsavel $fkTcernUnidadeGestoraResponsavel
     * @return UnidadeGestora
     */
    public function addFkTcernUnidadeGestoraResponsaveis(\Urbem\CoreBundle\Entity\Tcern\UnidadeGestoraResponsavel $fkTcernUnidadeGestoraResponsavel)
    {
        if (false === $this->fkTcernUnidadeGestoraResponsaveis->contains($fkTcernUnidadeGestoraResponsavel)) {
            $fkTcernUnidadeGestoraResponsavel->setFkTcernUnidadeGestora($this);
            $this->fkTcernUnidadeGestoraResponsaveis->add($fkTcernUnidadeGestoraResponsavel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcernUnidadeGestoraResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\UnidadeGestoraResponsavel $fkTcernUnidadeGestoraResponsavel
     */
    public function removeFkTcernUnidadeGestoraResponsaveis(\Urbem\CoreBundle\Entity\Tcern\UnidadeGestoraResponsavel $fkTcernUnidadeGestoraResponsavel)
    {
        $this->fkTcernUnidadeGestoraResponsaveis->removeElement($fkTcernUnidadeGestoraResponsavel);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcernUnidadeGestoraResponsaveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\UnidadeGestoraResponsavel
     */
    public function getFkTcernUnidadeGestoraResponsaveis()
    {
        return $this->fkTcernUnidadeGestoraResponsaveis;
    }

    /**
     * OneToMany (owning side)
     * Add TcernUnidadeOrcamentaria
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\UnidadeOrcamentaria $fkTcernUnidadeOrcamentaria
     * @return UnidadeGestora
     */
    public function addFkTcernUnidadeOrcamentarias(\Urbem\CoreBundle\Entity\Tcern\UnidadeOrcamentaria $fkTcernUnidadeOrcamentaria)
    {
        if (false === $this->fkTcernUnidadeOrcamentarias->contains($fkTcernUnidadeOrcamentaria)) {
            $fkTcernUnidadeOrcamentaria->setFkTcernUnidadeGestora($this);
            $this->fkTcernUnidadeOrcamentarias->add($fkTcernUnidadeOrcamentaria);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcernUnidadeOrcamentaria
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\UnidadeOrcamentaria $fkTcernUnidadeOrcamentaria
     */
    public function removeFkTcernUnidadeOrcamentarias(\Urbem\CoreBundle\Entity\Tcern\UnidadeOrcamentaria $fkTcernUnidadeOrcamentaria)
    {
        $this->fkTcernUnidadeOrcamentarias->removeElement($fkTcernUnidadeOrcamentaria);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcernUnidadeOrcamentarias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\UnidadeOrcamentaria
     */
    public function getFkTcernUnidadeOrcamentarias()
    {
        return $this->fkTcernUnidadeOrcamentarias;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return UnidadeGestora
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->cgmUnidade = $fkSwCgm->getNumcgm();
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
     * Set fkTcernNaturezaJuridica
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\NaturezaJuridica $fkTcernNaturezaJuridica
     * @return UnidadeGestora
     */
    public function setFkTcernNaturezaJuridica(\Urbem\CoreBundle\Entity\Tcern\NaturezaJuridica $fkTcernNaturezaJuridica)
    {
        $this->natureza = $fkTcernNaturezaJuridica->getCodNatureza();
        $this->fkTcernNaturezaJuridica = $fkTcernNaturezaJuridica;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcernNaturezaJuridica
     *
     * @return \Urbem\CoreBundle\Entity\Tcern\NaturezaJuridica
     */
    public function getFkTcernNaturezaJuridica()
    {
        return $this->fkTcernNaturezaJuridica;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return UnidadeGestora
     */
    public function setFkNormasNorma(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        $this->codNorma = $fkNormasNorma->getCodNorma();
        $this->fkNormasNorma = $fkNormasNorma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNorma()
    {
        return $this->fkNormasNorma;
    }
}
