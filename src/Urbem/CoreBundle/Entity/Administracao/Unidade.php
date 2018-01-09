<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * Unidade
 */
class Unidade
{
    /**
     * PK
     * @var integer
     */
    private $codUnidade;

    /**
     * PK
     * @var string
     */
    private $anoExercicio;

    /**
     * PK
     * @var integer
     */
    private $codOrgao;

    /**
     * @var integer
     */
    private $usuarioResponsavel;

    /**
     * @var string
     */
    private $nomUnidade;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Departamento
     */
    private $fkAdministracaoDepartamentos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Orgao
     */
    private $fkAdministracaoOrgao;

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
        $this->fkAdministracaoDepartamentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codUnidade
     *
     * @param integer $codUnidade
     * @return Unidade
     */
    public function setCodUnidade($codUnidade)
    {
        $this->codUnidade = $codUnidade;
        return $this;
    }

    /**
     * Get codUnidade
     *
     * @return integer
     */
    public function getCodUnidade()
    {
        return $this->codUnidade;
    }

    /**
     * Set anoExercicio
     *
     * @param string $anoExercicio
     * @return Unidade
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
     * Set codOrgao
     *
     * @param integer $codOrgao
     * @return Unidade
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
     * Set usuarioResponsavel
     *
     * @param integer $usuarioResponsavel
     * @return Unidade
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
     * Set nomUnidade
     *
     * @param string $nomUnidade
     * @return Unidade
     */
    public function setNomUnidade($nomUnidade)
    {
        $this->nomUnidade = $nomUnidade;
        return $this;
    }

    /**
     * Get nomUnidade
     *
     * @return string
     */
    public function getNomUnidade()
    {
        return $this->nomUnidade;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoDepartamento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Departamento $fkAdministracaoDepartamento
     * @return Unidade
     */
    public function addFkAdministracaoDepartamentos(\Urbem\CoreBundle\Entity\Administracao\Departamento $fkAdministracaoDepartamento)
    {
        if (false === $this->fkAdministracaoDepartamentos->contains($fkAdministracaoDepartamento)) {
            $fkAdministracaoDepartamento->setFkAdministracaoUnidade($this);
            $this->fkAdministracaoDepartamentos->add($fkAdministracaoDepartamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoDepartamento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Departamento $fkAdministracaoDepartamento
     */
    public function removeFkAdministracaoDepartamentos(\Urbem\CoreBundle\Entity\Administracao\Departamento $fkAdministracaoDepartamento)
    {
        $this->fkAdministracaoDepartamentos->removeElement($fkAdministracaoDepartamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoDepartamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Departamento
     */
    public function getFkAdministracaoDepartamentos()
    {
        return $this->fkAdministracaoDepartamentos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Orgao $fkAdministracaoOrgao
     * @return Unidade
     */
    public function setFkAdministracaoOrgao(\Urbem\CoreBundle\Entity\Administracao\Orgao $fkAdministracaoOrgao)
    {
        $this->codOrgao = $fkAdministracaoOrgao->getCodOrgao();
        $this->anoExercicio = $fkAdministracaoOrgao->getAnoExercicio();
        $this->fkAdministracaoOrgao = $fkAdministracaoOrgao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoOrgao
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Orgao
     */
    public function getFkAdministracaoOrgao()
    {
        return $this->fkAdministracaoOrgao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return Unidade
     */
    public function setFkAdministracaoUsuario(\Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario)
    {
        $this->usuarioResponsavel = $fkAdministracaoUsuario->getNumcgm();
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
}
