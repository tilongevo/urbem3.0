<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * LicencaDiasSemana
 */
class LicencaDiasSemana
{
    /**
     * PK
     * @var integer
     */
    private $codLicenca;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codDia;

    /**
     * @var \DateTime
     */
    private $hrInicio;

    /**
     * @var \DateTime
     */
    private $hrTermino;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\Licenca
     */
    private $fkEconomicoLicenca;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\DiasSemana
     */
    private $fkAdministracaoDiasSemana;


    /**
     * Set codLicenca
     *
     * @param integer $codLicenca
     * @return LicencaDiasSemana
     */
    public function setCodLicenca($codLicenca)
    {
        $this->codLicenca = $codLicenca;
        return $this;
    }

    /**
     * Get codLicenca
     *
     * @return integer
     */
    public function getCodLicenca()
    {
        return $this->codLicenca;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return LicencaDiasSemana
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
     * Set codDia
     *
     * @param integer $codDia
     * @return LicencaDiasSemana
     */
    public function setCodDia($codDia)
    {
        $this->codDia = $codDia;
        return $this;
    }

    /**
     * Get codDia
     *
     * @return integer
     */
    public function getCodDia()
    {
        return $this->codDia;
    }

    /**
     * Set hrInicio
     *
     * @param \DateTime $hrInicio
     * @return LicencaDiasSemana
     */
    public function setHrInicio(\DateTime $hrInicio)
    {
        $this->hrInicio = $hrInicio;
        return $this;
    }

    /**
     * Get hrInicio
     *
     * @return \DateTime
     */
    public function getHrInicio()
    {
        return $this->hrInicio;
    }

    /**
     * Set hrTermino
     *
     * @param \DateTime $hrTermino
     * @return LicencaDiasSemana
     */
    public function setHrTermino(\DateTime $hrTermino)
    {
        $this->hrTermino = $hrTermino;
        return $this;
    }

    /**
     * Get hrTermino
     *
     * @return \DateTime
     */
    public function getHrTermino()
    {
        return $this->hrTermino;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoLicenca
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Licenca $fkEconomicoLicenca
     * @return LicencaDiasSemana
     */
    public function setFkEconomicoLicenca(\Urbem\CoreBundle\Entity\Economico\Licenca $fkEconomicoLicenca)
    {
        $this->codLicenca = $fkEconomicoLicenca->getCodLicenca();
        $this->exercicio = $fkEconomicoLicenca->getExercicio();
        $this->fkEconomicoLicenca = $fkEconomicoLicenca;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoLicenca
     *
     * @return \Urbem\CoreBundle\Entity\Economico\Licenca
     */
    public function getFkEconomicoLicenca()
    {
        return $this->fkEconomicoLicenca;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoDiasSemana
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\DiasSemana $fkAdministracaoDiasSemana
     * @return LicencaDiasSemana
     */
    public function setFkAdministracaoDiasSemana(\Urbem\CoreBundle\Entity\Administracao\DiasSemana $fkAdministracaoDiasSemana)
    {
        $this->codDia = $fkAdministracaoDiasSemana->getCodDia();
        $this->fkAdministracaoDiasSemana = $fkAdministracaoDiasSemana;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoDiasSemana
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\DiasSemana
     */
    public function getFkAdministracaoDiasSemana()
    {
        return $this->fkAdministracaoDiasSemana;
    }
}
