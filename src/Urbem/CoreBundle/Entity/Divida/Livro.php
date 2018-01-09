<?php
 
namespace Urbem\CoreBundle\Entity\Divida;

/**
 * Livro
 */
class Livro
{
    /**
     * PK
     * @var integer
     */
    private $numLivro;

    /**
     * PK
     * @var string
     */
    private $exercicio;


    /**
     * Set numLivro
     *
     * @param integer $numLivro
     * @return Livro
     */
    public function setNumLivro($numLivro)
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return Livro
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
}
