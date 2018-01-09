<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * VwCidadaoProgramaView
 */
class VwCidadaoProgramaView
{
    /**
     * PK
     * @var integer
     */
    private $codCidadao;

    /**
     * @var string
     */
    private $nomCidadao;

    /**
     * @var integer
     */
    private $codPrograma;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $nomPrograma;


    /**
     * Set codCidadao
     *
     * @param integer $codCidadao
     * @return VwCidadaoPrograma
     */
    public function setCodCidadao($codCidadao)
    {
        $this->codCidadao = $codCidadao;
        return $this;
    }

    /**
     * Get codCidadao
     *
     * @return integer
     */
    public function getCodCidadao()
    {
        return $this->codCidadao;
    }

    /**
     * Set nomCidadao
     *
     * @param string $nomCidadao
     * @return VwCidadaoPrograma
     */
    public function setNomCidadao($nomCidadao = null)
    {
        $this->nomCidadao = $nomCidadao;
        return $this;
    }

    /**
     * Get nomCidadao
     *
     * @return string
     */
    public function getNomCidadao()
    {
        return $this->nomCidadao;
    }

    /**
     * Set codPrograma
     *
     * @param integer $codPrograma
     * @return VwCidadaoPrograma
     */
    public function setCodPrograma($codPrograma = null)
    {
        $this->codPrograma = $codPrograma;
        return $this;
    }

    /**
     * Get codPrograma
     *
     * @return integer
     */
    public function getCodPrograma()
    {
        return $this->codPrograma;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return VwCidadaoPrograma
     */
    public function setExercicio($exercicio = null)
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
     * Set nomPrograma
     *
     * @param string $nomPrograma
     * @return VwCidadaoPrograma
     */
    public function setNomPrograma($nomPrograma = null)
    {
        $this->nomPrograma = $nomPrograma;
        return $this;
    }

    /**
     * Get nomPrograma
     *
     * @return string
     */
    public function getNomPrograma()
    {
        return $this->nomPrograma;
    }
}
