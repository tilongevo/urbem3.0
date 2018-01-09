<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * Orgao
 */
class Orgao
{
    /**
     * PK
     * @var integer
     */
    private $codOrgao;

    /**
     * PK
     * @var string
     */
    private $anoExercicio;

    /**
     * @var integer
     */
    private $usuarioResponsavel;

    /**
     * @var string
     */
    private $nomOrgao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Unidade
     */
    private $fkAdministracaoUnidades;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAdministracaoUnidades = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codOrgao
     *
     * @param integer $codOrgao
     * @return Orgao
     */
    public function setCodOrgao($codOrgao)
    {
        $this->codOrgao = $codOrgao;
        return $this;
    }

    /**
     * Get codOrgao
     *
     * @return integer
     */
    public function getCodOrgao()
    {
        return $this->codOrgao;
    }

    /**
     * Set anoExercicio
     *
     * @param string $anoExercicio
     * @return Orgao
     */
    public function setAnoExercicio($anoExercicio)
    {
        $this->anoExercicio = $anoExercicio;
        return $this;
    }

    /**
     * Get anoExercicio
     *
     * @return string
     */
    public function getAnoExercicio()
    {
        return $this->anoExercicio;
    }

    /**
     * Set usuarioResponsavel
     *
     * @param integer $usuarioResponsavel
     * @return Orgao
     */
    public function setUsuarioResponsavel($usuarioResponsavel)
    {
        $this->usuarioResponsavel = $usuarioResponsavel;
        return $this;
    }

    /**
     * Get usuarioResponsavel
     *
     * @return integer
     */
    public function getUsuarioResponsavel()
    {
        return $this->usuarioResponsavel;
    }

    /**
     * Set nomOrgao
     *
     * @param string $nomOrgao
     * @return Orgao
     */
    public function setNomOrgao($nomOrgao = null)
    {
        $this->nomOrgao = $nomOrgao;
        return $this;
    }

    /**
     * Get nomOrgao
     *
     * @return string
     */
    public function getNomOrgao()
    {
        return $this->nomOrgao;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoUnidade
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Unidade $fkAdministracaoUnidade
     * @return Orgao
     */
    public function addFkAdministracaoUnidades(\Urbem\CoreBundle\Entity\Administracao\Unidade $fkAdministracaoUnidade)
    {
        if (false === $this->fkAdministracaoUnidades->contains($fkAdministracaoUnidade)) {
            $fkAdministracaoUnidade->setFkAdministracaoOrgao($this);
            $this->fkAdministracaoUnidades->add($fkAdministracaoUnidade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoUnidade
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Unidade $fkAdministracaoUnidade
     */
    public function removeFkAdministracaoUnidades(\Urbem\CoreBundle\Entity\Administracao\Unidade $fkAdministracaoUnidade)
    {
        $this->fkAdministracaoUnidades->removeElement($fkAdministracaoUnidade);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoUnidades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Unidade
     */
    public function getFkAdministracaoUnidades()
    {
        return $this->fkAdministracaoUnidades;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return Orgao
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->usuarioResponsavel = $fkSwCgm->getNumcgm();
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
     * @return string
     */
    public function __toString()
    {
        return "{$this->codOrgao} - {$this->nomOrgao}";
    }
}
