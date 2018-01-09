<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * Setor
 */
class Setor
{
    /**
     * PK
     * @var integer
     */
    private $codSetor;

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
     * PK
     * @var integer
     */
    private $codDepartamento;

    /**
     * @var integer
     */
    private $usuarioResponsavel;

    /**
     * @var string
     */
    private $nomSetor;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Organograma\DeParaSetor
     */
    private $fkOrganogramaDeParaSetor;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Local
     */
    private $fkAdministracaoLocais;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Departamento
     */
    private $fkAdministracaoDepartamento;

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
        $this->fkAdministracaoLocais = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codSetor
     *
     * @param integer $codSetor
     * @return Setor
     */
    public function setCodSetor($codSetor)
    {
        $this->codSetor = $codSetor;
        return $this;
    }

    /**
     * Get codSetor
     *
     * @return integer
     */
    public function getCodSetor()
    {
        return $this->codSetor;
    }

    /**
     * Set codUnidade
     *
     * @param integer $codUnidade
     * @return Setor
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
     * @return Setor
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
     * @return Setor
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
     * Set codDepartamento
     *
     * @param integer $codDepartamento
     * @return Setor
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
     * Set usuarioResponsavel
     *
     * @param integer $usuarioResponsavel
     * @return Setor
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
     * Set nomSetor
     *
     * @param string $nomSetor
     * @return Setor
     */
    public function setNomSetor($nomSetor)
    {
        $this->nomSetor = $nomSetor;
        return $this;
    }

    /**
     * Get nomSetor
     *
     * @return string
     */
    public function getNomSetor()
    {
        return $this->nomSetor;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoLocal
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Local $fkAdministracaoLocal
     * @return Setor
     */
    public function addFkAdministracaoLocais(\Urbem\CoreBundle\Entity\Administracao\Local $fkAdministracaoLocal)
    {
        if (false === $this->fkAdministracaoLocais->contains($fkAdministracaoLocal)) {
            $fkAdministracaoLocal->setFkAdministracaoSetor($this);
            $this->fkAdministracaoLocais->add($fkAdministracaoLocal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoLocal
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Local $fkAdministracaoLocal
     */
    public function removeFkAdministracaoLocais(\Urbem\CoreBundle\Entity\Administracao\Local $fkAdministracaoLocal)
    {
        $this->fkAdministracaoLocais->removeElement($fkAdministracaoLocal);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoLocais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Local
     */
    public function getFkAdministracaoLocais()
    {
        return $this->fkAdministracaoLocais;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoDepartamento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Departamento $fkAdministracaoDepartamento
     * @return Setor
     */
    public function setFkAdministracaoDepartamento(\Urbem\CoreBundle\Entity\Administracao\Departamento $fkAdministracaoDepartamento)
    {
        $this->codDepartamento = $fkAdministracaoDepartamento->getCodDepartamento();
        $this->codOrgao = $fkAdministracaoDepartamento->getCodOrgao();
        $this->anoExercicio = $fkAdministracaoDepartamento->getAnoExercicio();
        $this->codUnidade = $fkAdministracaoDepartamento->getCodUnidade();
        $this->fkAdministracaoDepartamento = $fkAdministracaoDepartamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoDepartamento
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Departamento
     */
    public function getFkAdministracaoDepartamento()
    {
        return $this->fkAdministracaoDepartamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return Setor
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

    /**
     * OneToOne (inverse side)
     * Set OrganogramaDeParaSetor
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\DeParaSetor $fkOrganogramaDeParaSetor
     * @return Setor
     */
    public function setFkOrganogramaDeParaSetor(\Urbem\CoreBundle\Entity\Organograma\DeParaSetor $fkOrganogramaDeParaSetor)
    {
        $fkOrganogramaDeParaSetor->setFkAdministracaoSetor($this);
        $this->fkOrganogramaDeParaSetor = $fkOrganogramaDeParaSetor;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkOrganogramaDeParaSetor
     *
     * @return \Urbem\CoreBundle\Entity\Organograma\DeParaSetor
     */
    public function getFkOrganogramaDeParaSetor()
    {
        return $this->fkOrganogramaDeParaSetor;
    }
}
