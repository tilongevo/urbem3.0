<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * ConfiguracaoArquivoDmr
 */
class ConfiguracaoArquivoDmr
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
    private $codNorma;

    /**
     * @var integer
     */
    private $codTipoDecreto;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConfiguracaoArquivoDmr
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
     * Set codNorma
     *
     * @param integer $codNorma
     * @return ConfiguracaoArquivoDmr
     */
    public function setCodNorma($codNorma)
    {
        $this->codNorma = $codNorma;
        return $this;
    }

    /**
     * Get codNorma
     *
     * @return integer
     */
    public function getCodNorma()
    {
        return $this->codNorma;
    }

    /**
     * Set codTipoDecreto
     *
     * @param integer $codTipoDecreto
     * @return ConfiguracaoArquivoDmr
     */
    public function setCodTipoDecreto($codTipoDecreto)
    {
        $this->codTipoDecreto = $codTipoDecreto;
        return $this;
    }

    /**
     * Get codTipoDecreto
     *
     * @return integer
     */
    public function getCodTipoDecreto()
    {
        return $this->codTipoDecreto;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return ConfiguracaoArquivoDmr
     */
    public function setFkNormasNorma(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        $this->codNorma = $fkNormasNorma->getCodNorma();
        $this->fkNormasNorma = $fkNormasNorma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNorma()
    {
        return $this->fkNormasNorma;
    }
}
