<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * Guardalivros
 */
class Guardalivros
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codInscricao;

    /**
     * @var integer
     */
    private $numLivro;

    /**
     * @var integer
     */
    private $numFolha;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Guardalivros
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
     * Set codInscricao
     *
     * @param integer $codInscricao
     * @return Guardalivros
     */
    public function setCodInscricao($codInscricao = null)
    {
        $this->codInscricao = $codInscricao;
        return $this;
    }

    /**
     * Get codInscricao
     *
     * @return integer
     */
    public function getCodInscricao()
    {
        return $this->codInscricao;
    }

    /**
     * Set numLivro
     *
     * @param integer $numLivro
     * @return Guardalivros
     */
    public function setNumLivro($numLivro = null)
    {
        $this->numLivro = $numLivro;
        return $this;
    }

    /**
     * Get numLivro
     *
     * @return integer
     */
    public function getNumLivro()
    {
        return $this->numLivro;
    }

    /**
     * Set numFolha
     *
     * @param integer $numFolha
     * @return Guardalivros
     */
    public function setNumFolha($numFolha = null)
    {
        $this->numFolha = $numFolha;
        return $this;
    }

    /**
     * Get numFolha
     *
     * @return integer
     */
    public function getNumFolha()
    {
        return $this->numFolha;
    }
}
