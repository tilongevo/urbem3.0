<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * LicencaObservacao
 */
class LicencaObservacao
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
     * @var string
     */
    private $observacao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Economico\Licenca
     */
    private $fkEconomicoLicenca;


    /**
     * Set codLicenca
     *
     * @param integer $codLicenca
     * @return LicencaObservacao
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
     * @return LicencaObservacao
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
     * Set observacao
     *
     * @param string $observacao
     * @return LicencaObservacao
     */
    public function setObservacao($observacao)
    {
        $this->observacao = $observacao;
        return $this;
    }

    /**
     * Get observacao
     *
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * OneToOne (owning side)
     * Set EconomicoLicenca
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Licenca $fkEconomicoLicenca
     * @return LicencaObservacao
     */
    public function setFkEconomicoLicenca(\Urbem\CoreBundle\Entity\Economico\Licenca $fkEconomicoLicenca)
    {
        $this->codLicenca = $fkEconomicoLicenca->getCodLicenca();
        $this->exercicio = $fkEconomicoLicenca->getExercicio();
        $this->fkEconomicoLicenca = $fkEconomicoLicenca;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkEconomicoLicenca
     *
     * @return \Urbem\CoreBundle\Entity\Economico\Licenca
     */
    public function getFkEconomicoLicenca()
    {
        return $this->fkEconomicoLicenca;
    }
}
