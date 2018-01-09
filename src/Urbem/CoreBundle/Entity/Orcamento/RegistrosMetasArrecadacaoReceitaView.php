<?php

namespace Urbem\CoreBundle\Entity\Orcamento;

class RegistrosMetasArrecadacaoReceitaView
{
    private $rowNumber;

    private $mascaraClassificacao;

    private $descricao;

    private $codReceita;

    private $codConta;

    private $codRecurso;

    private $dtCriacao;

    private $vlOriginal;

    private $creditoTributario;

    private $exercicio;

    private $numcgm;

    private $codEntidade;

    private $previsoes = [];

    /**
     * @return int
     */
    public function getRowNumber()
    {
        return $this->rowNumber;
    }

    /**
     * @param int $rowNumber
     */
    public function setRowNumber($rowNumber)
    {
        $this->rowNumber = $rowNumber;
    }

    /**
     * @return string
     */
    public function getMascaraClassificacao()
    {
        return $this->mascaraClassificacao;
    }

    /**
     * @param string $mascaraClassificacao
     */
    public function setMascaraClassificacao($mascaraClassificacao)
    {
        $this->mascaraClassificacao = $mascaraClassificacao;
    }

    /**
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param string $descricao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    /**
     * @return int
     */
    public function getCodReceita()
    {
        return $this->codReceita;
    }

    /**
     * @param int $codReceita
     */
    public function setCodReceita($codReceita)
    {
        $this->codReceita = $codReceita;
    }

    /**
     * @return int
     */
    public function getCodConta()
    {
        return $this->codConta;
    }

    /**
     * @param int $codConta
     */
    public function setCodConta($codConta)
    {
        $this->codConta = $codConta;
    }

    /**
     * @return int
     */
    public function getCodRecurso()
    {
        return $this->codRecurso;
    }

    /**
     * @param int $codRecurso
     */
    public function setCodRecurso($codRecurso)
    {
        $this->codRecurso = $codRecurso;
    }

    /**
     * @return \DateTime
     */
    public function getDtCriacao()
    {
        return $this->dtCriacao;
    }

    /**
     * @param \DateTime $dtCriacao
     */
    public function setDtCriacao($dtCriacao)
    {
        $this->dtCriacao = $dtCriacao;
    }

    /**
     * @return decimal
     */
    public function getVlOriginal()
    {
        return $this->vlOriginal;
    }

    /**
     * @param decimal $vlOriginal
     */
    public function setVlOriginal($vlOriginal)
    {
        $this->vlOriginal = $vlOriginal;
    }

    /**
     * @return boolean
     */
    public function isCreditoTributario()
    {
        return $this->creditoTributario;
    }

    /**
     * @param boolean $creditoTributario
     */
    public function setCreditoTributario($creditoTributario)
    {
        $this->creditoTributario = $creditoTributario;
    }

    /**
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * @param string $exercicio
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
    }

    /**
     * @return int
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * @param int $numcgm
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
    }

    /**
     * @return int
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * @param int $codEntidade
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
    }

    /**
     * @return ArrayCollection
     */
    public function getPrevisoes()
    {
        return $this->previsoes;
    }

    /**
     * @param ArrayCollection $previsoes
     */
    public function setPrevisoes($previsoes)
    {
        $this->previsoes = $previsoes;
    }
}
