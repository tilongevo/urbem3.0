<?php
 
namespace Urbem\CoreBundle\Entity\Organograma;

/**
 * DeParaLocal
 */
class DeParaLocal
{
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
    private $codUnidade;

    /**
     * PK
     * @var integer
     */
    private $codDepartamento;

    /**
     * PK
     * @var integer
     */
    private $codSetor;

    /**
     * PK
     * @var integer
     */
    private $codLocal;

    /**
     * @var integer
     */
    private $codLocalOrganograma;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Administracao\Local
     */
    private $fkAdministracaoLocal;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Organograma\Local
     */
    private $fkOrganogramaLocal;


    /**
     * Set anoExercicio
     *
     * @param string $anoExercicio
     * @return DeParaLocal
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
     * @return DeParaLocal
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
     * Set codUnidade
     *
     * @param integer $codUnidade
     * @return DeParaLocal
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
     * Set codDepartamento
     *
     * @param integer $codDepartamento
     * @return DeParaLocal
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
     * Set codSetor
     *
     * @param integer $codSetor
     * @return DeParaLocal
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
     * Set codLocal
     *
     * @param integer $codLocal
     * @return DeParaLocal
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
     * Set codLocalOrganograma
     *
     * @param integer $codLocalOrganograma
     * @return DeParaLocal
     */
    public function setCodLocalOrganograma($codLocalOrganograma = null)
    {
        $this->codLocalOrganograma = $codLocalOrganograma;
        return $this;
    }

    /**
     * Get codLocalOrganograma
     *
     * @return integer
     */
    public function getCodLocalOrganograma()
    {
        return $this->codLocalOrganograma;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrganogramaLocal
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Local $fkOrganogramaLocal
     * @return DeParaLocal
     */
    public function setFkOrganogramaLocal(\Urbem\CoreBundle\Entity\Organograma\Local $fkOrganogramaLocal)
    {
        $this->codLocalOrganograma = $fkOrganogramaLocal->getCodLocal();
        $this->fkOrganogramaLocal = $fkOrganogramaLocal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrganogramaLocal
     *
     * @return \Urbem\CoreBundle\Entity\Organograma\Local
     */
    public function getFkOrganogramaLocal()
    {
        return $this->fkOrganogramaLocal;
    }

    /**
     * OneToOne (owning side)
     * Set AdministracaoLocal
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Local $fkAdministracaoLocal
     * @return DeParaLocal
     */
    public function setFkAdministracaoLocal(\Urbem\CoreBundle\Entity\Administracao\Local $fkAdministracaoLocal)
    {
        $this->codLocal = $fkAdministracaoLocal->getCodLocal();
        $this->codDepartamento = $fkAdministracaoLocal->getCodDepartamento();
        $this->codOrgao = $fkAdministracaoLocal->getCodOrgao();
        $this->anoExercicio = $fkAdministracaoLocal->getAnoExercicio();
        $this->codUnidade = $fkAdministracaoLocal->getCodUnidade();
        $this->codSetor = $fkAdministracaoLocal->getCodSetor();
        $this->fkAdministracaoLocal = $fkAdministracaoLocal;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkAdministracaoLocal
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Local
     */
    public function getFkAdministracaoLocal()
    {
        return $this->fkAdministracaoLocal;
    }
}
