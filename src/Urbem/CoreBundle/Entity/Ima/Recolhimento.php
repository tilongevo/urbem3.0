<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * Recolhimento
 */
class Recolhimento
{
    /**
     * PK
     * @var integer
     */
    private $codRecolhimento;

    /**
     * @var string
     */
    private $descricao;


    /**
     * Set codRecolhimento
     *
     * @param integer $codRecolhimento
     * @return Recolhimento
     */
    public function setCodRecolhimento($codRecolhimento)
    {
        $this->codRecolhimento = $codRecolhimento;
        return $this;
    }

    /**
     * Get codRecolhimento
     *
     * @return integer
     */
    public function getCodRecolhimento()
    {
        return $this->codRecolhimento;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Recolhimento
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
}
