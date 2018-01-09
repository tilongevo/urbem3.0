<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * Orgao
 */
class Orgao
{
    /**
     * PK
     * @var integer
     */
    private $numOrgao;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $nomOrgao;


    /**
     * Set numOrgao
     *
     * @param integer $numOrgao
     * @return Orgao
     */
    public function setNumOrgao($numOrgao)
    {
        $this->numOrgao = $numOrgao;
        return $this;
    }

    /**
     * Get numOrgao
     *
     * @return integer
     */
    public function getNumOrgao()
    {
        return $this->numOrgao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Orgao
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
     * Set nomOrgao
     *
     * @param string $nomOrgao
     * @return Orgao
     */
    public function setNomOrgao($nomOrgao)
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
     * @return string
     */
    public function __toString()
    {
        return (string) $this->nomOrgao;
    }
}
