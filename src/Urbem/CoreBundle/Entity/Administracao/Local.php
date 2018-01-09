<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * Local
 */
class Local
{
    /**
     * PK
     * @var integer
     */
    private $codLocal;

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
     * PK
     * @var integer
     */
    private $codSetor;

    /**
     * @var integer
     */
    private $usuarioResponsavel;

    /**
     * @var string
     */
    private $nomLocal;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Organograma\DeParaLocal
     */
    private $fkOrganogramaDeParaLocal;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Setor
     */
    private $fkAdministracaoSetor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;


    /**
     * Set codLocal
     *
     * @param integer $codLocal
     * @return Local
     */
    public function setCodLocal($codLocal)
    {
        $this->codLocal = $codLocal;
        return $this;
    }

    /**
     * Get codLocal
     *
     * @return integer
     */
    public function getCodLocal()
    {
        return $this->codLocal;
    }

    /**
     * Set codDepartamento
     *
     * @param integer $codDepartamento
     * @return Local
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
     * @return Local
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
     * @return Local
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
     * @return Local
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
     * Set codSetor
     *
     * @param integer $codSetor
     * @return Local
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
     * Set usuarioResponsavel
     *
     * @param integer $usuarioResponsavel
     * @return Local
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
     * Set nomLocal
     *
     * @param string $nomLocal
     * @return Local
     */
    public function setNomLocal($nomLocal)
    {
        $this->nomLocal = $nomLocal;
        return $this;
    }

    /**
     * Get nomLocal
     *
     * @return string
     */
    public function getNomLocal()
    {
        return $this->nomLocal;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoSetor
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Setor $fkAdministracaoSetor
     * @return Local
     */
    public function setFkAdministracaoSetor(\Urbem\CoreBundle\Entity\Administracao\Setor $fkAdministracaoSetor)
    {
        $this->codSetor = $fkAdministracaoSetor->getCodSetor();
        $this->codUnidade = $fkAdministracaoSetor->getCodUnidade();
        $this->anoExercicio = $fkAdministracaoSetor->getAnoExercicio();
        $this->codOrgao = $fkAdministracaoSetor->getCodOrgao();
        $this->codDepartamento = $fkAdministracaoSetor->getCodDepartamento();
        $this->fkAdministracaoSetor = $fkAdministracaoSetor;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoSetor
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Setor
     */
    public function getFkAdministracaoSetor()
    {
        return $this->fkAdministracaoSetor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return Local
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
     * Set OrganogramaDeParaLocal
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\DeParaLocal $fkOrganogramaDeParaLocal
     * @return Local
     */
    public function setFkOrganogramaDeParaLocal(\Urbem\CoreBundle\Entity\Organograma\DeParaLocal $fkOrganogramaDeParaLocal)
    {
        $fkOrganogramaDeParaLocal->setFkAdministracaoLocal($this);
        $this->fkOrganogramaDeParaLocal = $fkOrganogramaDeParaLocal;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkOrganogramaDeParaLocal
     *
     * @return \Urbem\CoreBundle\Entity\Organograma\DeParaLocal
     */
    public function getFkOrganogramaDeParaLocal()
    {
        return $this->fkOrganogramaDeParaLocal;
    }
}
