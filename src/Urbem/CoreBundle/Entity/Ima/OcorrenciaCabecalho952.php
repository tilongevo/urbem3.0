<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * OcorrenciaCabecalho952
 */
class OcorrenciaCabecalho952
{
    /**
     * PK
     * @var integer
     */
    private $numOcorrencia;

    /**
     * @var integer
     */
    private $posicao;

    /**
     * @var string
     */
    private $descricao;


    /**
     * Set numOcorrencia
     *
     * @param integer $numOcorrencia
     * @return OcorrenciaCabecalho952
     */
    public function setNumOcorrencia($numOcorrencia)
    {
        $this->numOcorrencia = $numOcorrencia;
        return $this;
    }

    /**
     * Get numOcorrencia
     *
     * @return integer
     */
    public function getNumOcorrencia()
    {
        return $this->numOcorrencia;
    }

    /**
     * Set posicao
     *
     * @param integer $posicao
     * @return OcorrenciaCabecalho952
     */
    public function setPosicao($posicao)
    {
        $this->posicao = $posicao;
        return $this;
    }

    /**
     * Get posicao
     *
     * @return integer
     */
    public function getPosicao()
    {
        return $this->posicao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return OcorrenciaCabecalho952
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
