<?php
 
namespace Urbem\CoreBundle\Entity\Organograma;

/**
 * DeParaSetor
 */
class DeParaSetor
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
     * @var integer
     */
    private $codOrgaoOrganograma;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Administracao\Setor
     */
    private $fkAdministracaoSetor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    private $fkOrganogramaOrgao;


    /**
     * Set anoExercicio
     *
     * @param string $anoExercicio
     * @return DeParaSetor
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
     * @return DeParaSetor
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
     * @return DeParaSetor
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
     * @return DeParaSetor
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
     * @return DeParaSetor
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
     * Set codOrgaoOrganograma
     *
     * @param integer $codOrgaoOrganograma
     * @return DeParaSetor
     */
    public function setCodOrgaoOrganograma($codOrgaoOrganograma = null)
    {
        $this->codOrgaoOrganograma = $codOrgaoOrganograma;
        return $this;
    }

    /**
     * Get codOrgaoOrganograma
     *
     * @return integer
     */
    public function getCodOrgaoOrganograma()
    {
        return $this->codOrgaoOrganograma;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrganogramaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao
     * @return DeParaSetor
     */
    public function setFkOrganogramaOrgao(\Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao)
    {
        $this->codOrgaoOrganograma = $fkOrganogramaOrgao->getCodOrgao();
        $this->fkOrganogramaOrgao = $fkOrganogramaOrgao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrganogramaOrgao
     *
     * @return \Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    public function getFkOrganogramaOrgao()
    {
        return $this->fkOrganogramaOrgao;
    }

    /**
     * OneToOne (owning side)
     * Set AdministracaoSetor
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Setor $fkAdministracaoSetor
     * @return DeParaSetor
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
     * OneToOne (owning side)
     * Get fkAdministracaoSetor
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Setor
     */
    public function getFkAdministracaoSetor()
    {
        return $this->fkAdministracaoSetor;
    }
}
