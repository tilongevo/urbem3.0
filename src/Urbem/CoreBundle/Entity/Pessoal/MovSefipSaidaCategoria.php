<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * MovSefipSaidaCategoria
 */
class MovSefipSaidaCategoria
{
    /**
     * PK
     * @var integer
     */
    private $codSefipSaida;

    /**
     * PK
     * @var integer
     */
    private $codCategoria;

    /**
     * @var string
     */
    private $indicativo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\MovSefipSaida
     */
    private $fkPessoalMovSefipSaida;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Categoria
     */
    private $fkPessoalCategoria;


    /**
     * Set codSefipSaida
     *
     * @param integer $codSefipSaida
     * @return MovSefipSaidaCategoria
     */
    public function setCodSefipSaida($codSefipSaida)
    {
        $this->codSefipSaida = $codSefipSaida;
        return $this;
    }

    /**
     * Get codSefipSaida
     *
     * @return integer
     */
    public function getCodSefipSaida()
    {
        return $this->codSefipSaida;
    }

    /**
     * Set codCategoria
     *
     * @param integer $codCategoria
     * @return MovSefipSaidaCategoria
     */
    public function setCodCategoria($codCategoria)
    {
        $this->codCategoria = $codCategoria;
        return $this;
    }

    /**
     * Get codCategoria
     *
     * @return integer
     */
    public function getCodCategoria()
    {
        return $this->codCategoria;
    }

    /**
     * Set indicativo
     *
     * @param string $indicativo
     * @return MovSefipSaidaCategoria
     */
    public function setIndicativo($indicativo = null)
    {
        $this->indicativo = $indicativo;
        return $this;
    }

    /**
     * Get indicativo
     *
     * @return string
     */
    public function getIndicativo()
    {
        return $this->indicativo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalMovSefipSaida
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\MovSefipSaida $fkPessoalMovSefipSaida
     * @return MovSefipSaidaCategoria
     */
    public function setFkPessoalMovSefipSaida(\Urbem\CoreBundle\Entity\Pessoal\MovSefipSaida $fkPessoalMovSefipSaida)
    {
        $this->codSefipSaida = $fkPessoalMovSefipSaida->getCodSefipSaida();
        $this->fkPessoalMovSefipSaida = $fkPessoalMovSefipSaida;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalMovSefipSaida
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\MovSefipSaida
     */
    public function getFkPessoalMovSefipSaida()
    {
        return $this->fkPessoalMovSefipSaida;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalCategoria
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Categoria $fkPessoalCategoria
     * @return MovSefipSaidaCategoria
     */
    public function setFkPessoalCategoria(\Urbem\CoreBundle\Entity\Pessoal\Categoria $fkPessoalCategoria)
    {
        $this->codCategoria = $fkPessoalCategoria->getCodCategoria();
        $this->fkPessoalCategoria = $fkPessoalCategoria;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalCategoria
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Categoria
     */
    public function getFkPessoalCategoria()
    {
        return $this->fkPessoalCategoria;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->fkPessoalCategoria;
    }
}
