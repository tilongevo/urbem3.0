<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * CorrigeClassificacaoPlano
 */
class CorrigeClassificacaoPlano
{
    /**
     * PK
     * @var integer
     */
    private $codClassificacao;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codConta;

    /**
     * @var integer
     */
    private $codPosicao;


    /**
     * Set codClassificacao
     *
     * @param integer $codClassificacao
     * @return CorrigeClassificacaoPlano
     */
    public function setCodClassificacao($codClassificacao)
    {
        $this->codClassificacao = $codClassificacao;
        return $this;
    }

    /**
     * Get codClassificacao
     *
     * @return integer
     */
    public function getCodClassificacao()
    {
        return $this->codClassificacao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return CorrigeClassificacaoPlano
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
     * Set codConta
     *
     * @param integer $codConta
     * @return CorrigeClassificacaoPlano
     */
    public function setCodConta($codConta)
    {
        $this->codConta = $codConta;
        return $this;
    }

    /**
     * Get codConta
     *
     * @return integer
     */
    public function getCodConta()
    {
        return $this->codConta;
    }

    /**
     * Set codPosicao
     *
     * @param integer $codPosicao
     * @return CorrigeClassificacaoPlano
     */
    public function setCodPosicao($codPosicao)
    {
        $this->codPosicao = $codPosicao;
        return $this;
    }

    /**
     * Get codPosicao
     *
     * @return integer
     */
    public function getCodPosicao()
    {
        return $this->codPosicao;
    }
}
