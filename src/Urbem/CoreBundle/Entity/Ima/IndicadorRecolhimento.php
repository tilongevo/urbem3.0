<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * IndicadorRecolhimento
 */
class IndicadorRecolhimento
{
    /**
     * PK
     * @var integer
     */
    private $codIndicador;

    /**
     * @var string
     */
    private $descricao;


    /**
     * Set codIndicador
     *
     * @param integer $codIndicador
     * @return IndicadorRecolhimento
     */
    public function setCodIndicador($codIndicador)
    {
        $this->codIndicador = $codIndicador;
        return $this;
    }

    /**
     * Get codIndicador
     *
     * @return integer
     */
    public function getCodIndicador()
    {
        return $this->codIndicador;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return IndicadorRecolhimento
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
