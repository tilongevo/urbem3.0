<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * FonteRecurso
 */
class FonteRecurso
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
    private $codFonte;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var integer
     */
    private $codRecurso;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return FonteRecurso
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
     * Set codFonte
     *
     * @param integer $codFonte
     * @return FonteRecurso
     */
    public function setCodFonte($codFonte)
    {
        $this->codFonte = $codFonte;
        return $this;
    }

    /**
     * Get codFonte
     *
     * @return integer
     */
    public function getCodFonte()
    {
        return $this->codFonte;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return FonteRecurso
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
     * Set codRecurso
     *
     * @param integer $codRecurso
     * @return FonteRecurso
     */
    public function setCodRecurso($codRecurso = null)
    {
        $this->codRecurso = $codRecurso;
        return $this;
    }

    /**
     * Get codRecurso
     *
     * @return integer
     */
    public function getCodRecurso()
    {
        return $this->codRecurso;
    }
}
