<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * NormaArtigo
 */
class NormaArtigo
{
    /**
     * PK
     * @var integer
     */
    private $codArtigo;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codNorma;

    /**
     * @var integer
     */
    private $numArtigo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;


    /**
     * Set codArtigo
     *
     * @param integer $codArtigo
     * @return NormaArtigo
     */
    public function setCodArtigo($codArtigo)
    {
        $this->codArtigo = $codArtigo;
        return $this;
    }

    /**
     * Get codArtigo
     *
     * @return integer
     */
    public function getCodArtigo()
    {
        return $this->codArtigo;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return NormaArtigo
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
     * @return NormaArtigo
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
     * Set numArtigo
     *
     * @param integer $numArtigo
     * @return NormaArtigo
     */
    public function setNumArtigo($numArtigo)
    {
        $this->numArtigo = $numArtigo;
        return $this;
    }

    /**
     * Get numArtigo
     *
     * @return integer
     */
    public function getNumArtigo()
    {
        return $this->numArtigo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return NormaArtigo
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return NormaArtigo
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
