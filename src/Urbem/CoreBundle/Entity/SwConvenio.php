<?php

namespace Urbem\CoreBundle\Entity;

/**
 * SwConvenio
 */
class SwConvenio
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codConvenio;

    /**
     * @var string
     */
    private $nomConvenio;

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return SwConvenio
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
     * Set codConvenio
     *
     * @param integer $codConvenio
     * @return SwConvenio
     */
    public function setCodConvenio($codConvenio)
    {
        $this->codConvenio = $codConvenio;
        return $this;
    }

    /**
     * Get codConvenio
     *
     * @return integer
     */
    public function getCodConvenio()
    {
        return $this->codConvenio;
    }

    /**
     * Set nomConvenio
     *
     * @param string $nomConvenio
     * @return SwConvenio
     */
    public function setNomConvenio($nomConvenio)
    {
        $this->nomConvenio = $nomConvenio;
        return $this;
    }

    /**
     * Get nomConvenio
     *
     * @return string
     */
    public function getNomConvenio()
    {
        return $this->nomConvenio;
    }
}
