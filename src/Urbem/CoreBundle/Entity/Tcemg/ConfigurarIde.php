<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * ConfigurarIde
 */
class ConfigurarIde
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codMunicipio;

    /**
     * @var integer
     */
    private $opcaoSemestralidade;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConfigurarIde
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
     * Set codMunicipio
     *
     * @param integer $codMunicipio
     * @return ConfigurarIde
     */
    public function setCodMunicipio($codMunicipio)
    {
        $this->codMunicipio = $codMunicipio;
        return $this;
    }

    /**
     * Get codMunicipio
     *
     * @return integer
     */
    public function getCodMunicipio()
    {
        return $this->codMunicipio;
    }

    /**
     * Set opcaoSemestralidade
     *
     * @param integer $opcaoSemestralidade
     * @return ConfigurarIde
     */
    public function setOpcaoSemestralidade($opcaoSemestralidade = null)
    {
        $this->opcaoSemestralidade = $opcaoSemestralidade;
        return $this;
    }

    /**
     * Get opcaoSemestralidade
     *
     * @return integer
     */
    public function getOpcaoSemestralidade()
    {
        return $this->opcaoSemestralidade;
    }
}
