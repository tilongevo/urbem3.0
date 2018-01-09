<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * Departamento
 */
class Departamento
{
    /**
     * PK
     * @var integer
     */
    private $codDepartamento;

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
     * PK
     * @var integer
     */
    private $codUnidade;

    /**
     * @var integer
     */
    private $usuarioResponsavel;

    /**
     * @var string
     */
    private $nomDepartamento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Setor
     */
    private $fkAdministracaoSetores;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Unidade
     */
    private $fkAdministracaoUnidade;

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
        $this->fkAdministracaoSetores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codDepartamento
     *
     * @param integer $codDepartamento
     * @return Departamento
     */
    public function setCodDepartamento($codDepartamento)
    {
        $this->codDepartamento = $codDepartamento;
        return $this;
    }

    /**
     * Get codDepartamento
     *
     * @return integer
     */
    public function getCodDepartamento()
    {
        return $this->codDepartamento;
    }

    /**
     * Set codOrgao
     *
     * @param integer $codOrgao
     * @return Departamento
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
     * @return Departamento
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
     * Set codUnidade
     *
     * @param integer $codUnidade
     * @return Departamento
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
     * Set usuarioResponsavel
     *
     * @param integer $usuarioResponsavel
     * @return Departamento
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
     * Set nomDepartamento
     *
     * @param string $nomDepartamento
     * @return Departamento
     */
    public function setNomDepartamento($nomDepartamento)
    {
        $this->nomDepartamento = $nomDepartamento;
        return $this;
    }

    /**
     * Get nomDepartamento
     *
     * @return string
     */
    public function getNomDepartamento()
    {
        return $this->nomDepartamento;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoSetor
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Setor $fkAdministracaoSetor
     * @return Departamento
     */
    public function addFkAdministracaoSetores(\Urbem\CoreBundle\Entity\Administracao\Setor $fkAdministracaoSetor)
    {
        if (false === $this->fkAdministracaoSetores->contains($fkAdministracaoSetor)) {
            $fkAdministracaoSetor->setFkAdministracaoDepartamento($this);
            $this->fkAdministracaoSetores->add($fkAdministracaoSetor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoSetor
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Setor $fkAdministracaoSetor
     */
    public function removeFkAdministracaoSetores(\Urbem\CoreBundle\Entity\Administracao\Setor $fkAdministracaoSetor)
    {
        $this->fkAdministracaoSetores->removeElement($fkAdministracaoSetor);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoSetores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Setor
     */
    public function getFkAdministracaoSetores()
    {
        return $this->fkAdministracaoSetores;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUnidade
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Unidade $fkAdministracaoUnidade
     * @return Departamento
     */
    public function setFkAdministracaoUnidade(\Urbem\CoreBundle\Entity\Administracao\Unidade $fkAdministracaoUnidade)
    {
        $this->codUnidade = $fkAdministracaoUnidade->getCodUnidade();
        $this->anoExercicio = $fkAdministracaoUnidade->getAnoExercicio();
        $this->codOrgao = $fkAdministracaoUnidade->getCodOrgao();
        $this->fkAdministracaoUnidade = $fkAdministracaoUnidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoUnidade
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Unidade
     */
    public function getFkAdministracaoUnidade()
    {
        return $this->fkAdministracaoUnidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return Departamento
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
