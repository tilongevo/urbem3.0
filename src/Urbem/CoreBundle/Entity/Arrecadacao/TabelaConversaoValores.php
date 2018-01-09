<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * TabelaConversaoValores
 */
class TabelaConversaoValores
{
    /**
     * PK
     * @var integer
     */
    private $codTabela;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var string
     */
    private $parametro1;

    /**
     * PK
     * @var string
     */
    private $parametro2;

    /**
     * PK
     * @var string
     */
    private $parametro3;

    /**
     * PK
     * @var string
     */
    private $parametro4;

    /**
     * @var string
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\TabelaConversao
     */
    private $fkArrecadacaoTabelaConversao;


    /**
     * Set codTabela
     *
     * @param integer $codTabela
     * @return TabelaConversaoValores
     */
    public function setCodTabela($codTabela)
    {
        $this->codTabela = $codTabela;
        return $this;
    }

    /**
     * Get codTabela
     *
     * @return integer
     */
    public function getCodTabela()
    {
        return $this->codTabela;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return TabelaConversaoValores
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
     * Set parametro1
     *
     * @param string $parametro1
     * @return TabelaConversaoValores
     */
    public function setParametro1($parametro1)
    {
        $this->parametro1 = $parametro1;
        return $this;
    }

    /**
     * Get parametro1
     *
     * @return string
     */
    public function getParametro1()
    {
        return $this->parametro1;
    }

    /**
     * Set parametro2
     *
     * @param string $parametro2
     * @return TabelaConversaoValores
     */
    public function setParametro2($parametro2)
    {
        $this->parametro2 = $parametro2;
        return $this;
    }

    /**
     * Get parametro2
     *
     * @return string
     */
    public function getParametro2()
    {
        return $this->parametro2;
    }

    /**
     * Set parametro3
     *
     * @param string $parametro3
     * @return TabelaConversaoValores
     */
    public function setParametro3($parametro3)
    {
        $this->parametro3 = $parametro3;
        return $this;
    }

    /**
     * Get parametro3
     *
     * @return string
     */
    public function getParametro3()
    {
        return $this->parametro3;
    }

    /**
     * Set parametro4
     *
     * @param string $parametro4
     * @return TabelaConversaoValores
     */
    public function setParametro4($parametro4)
    {
        $this->parametro4 = $parametro4;
        return $this;
    }

    /**
     * Get parametro4
     *
     * @return string
     */
    public function getParametro4()
    {
        return $this->parametro4;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return TabelaConversaoValores
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoTabelaConversao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\TabelaConversao $fkArrecadacaoTabelaConversao
     * @return TabelaConversaoValores
     */
    public function setFkArrecadacaoTabelaConversao(\Urbem\CoreBundle\Entity\Arrecadacao\TabelaConversao $fkArrecadacaoTabelaConversao)
    {
        $this->codTabela = $fkArrecadacaoTabelaConversao->getCodTabela();
        $this->exercicio = $fkArrecadacaoTabelaConversao->getExercicio();
        $this->fkArrecadacaoTabelaConversao = $fkArrecadacaoTabelaConversao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoTabelaConversao
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\TabelaConversao
     */
    public function getFkArrecadacaoTabelaConversao()
    {
        return $this->fkArrecadacaoTabelaConversao;
    }
}
