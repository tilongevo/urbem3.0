<?php

namespace Urbem\CoreBundle\Entity\Tesouraria;

use Doctrine\ORM\Mapping as ORM;

/**
 * VwOrcamentariaPagamentoEstorno
 */
class VwOrcamentariaPagamentoEstornoView
{
    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $empenhoPagamento;

    /**
     * @var string
     */
    private $exercicioLiquidacao;

    /**
     * @var string
     */
    private $exercicioEmpenho;

    /**
     * @var integer
     */
    private $codEntidade;

    /**
     * @var integer
     */
    private $codEmpenho;

    /**
     * @var integer
     */
    private $codNota;

    /**
     * @var string
     */
    private $empenho;

    /**
     * @var string
     */
    private $nota;

    /**
     * @var string
     */
    private $ordem;

    /**
     * @var string
     */
    private $beneficiario;

    /**
     * @var string
     */
    private $vlNota;

    /**
     * @var string
     */
    private $vlOrdem;

    /**
     * @var string
     */
    private $vlPrestado;

    /**
     * @var integer
     */
    private $codConta;

    /**
     * @var string
     */
    private $nomConta;

    /**
     * @var boolean
     */
    private $retencao;

    /**
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * @return string
     */
    public function getEmpenhoPagamento()
    {
        return $this->empenhoPagamento;
    }

    /**
     * @return string
     */
    public function getExercicioLiquidacao()
    {
        return $this->exercicioLiquidacao;
    }

    /**
     * @return string
     */
    public function getExercicioEmpenho()
    {
        return $this->exercicioEmpenho;
    }

    /**
     * @return int
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * @return int
     */
    public function getCodEmpenho()
    {
        return $this->codEmpenho;
    }

    /**
     * @return int
     */
    public function getCodNota()
    {
        return $this->codNota;
    }

    /**
     * @return string
     */
    public function getEmpenho()
    {
        $nota = trim($this->getNota());
        $nota = str_replace("\\n", "", $nota);
        $nota = preg_replace("/\s+/", " ", $nota);

        list($empenho, $nota) = explode(' ', $nota);

        return $empenho;
    }

    /**
     * @return string
     */
    public function getLiquidacao()
    {
        $nota = trim($this->getNota());
        $nota = str_replace("\\n", "", $nota);
        $nota = preg_replace("/\s+/", " ", $nota);

        list($empenho, $nota) = explode(' ', $nota);

        return $nota;
    }

    /**
     * @return string
     */
    public function getNota()
    {
        return $this->nota;
    }

    /**
     * @return string
     */
    public function getOrdem()
    {
        return $this->ordem;
    }

    /**
     * @return string
     */
    public function getBeneficiario()
    {
        return $this->beneficiario;
    }

    /**
     * @return string
     */
    public function getVlNota()
    {
        return $this->vlNota;
    }

    /**
     * @return string
     */
    public function getVlOrdem()
    {
        return $this->vlOrdem;
    }

    /**
     * @return string
     */
    public function getVlPrestado()
    {
        return $this->vlPrestado;
    }

    /**
     * @return int
     */
    public function getCodConta()
    {
        return $this->codConta;
    }

    /**
     * @return string
     */
    public function getNomConta()
    {
        return $this->nomConta;
    }

    /**
     * @return boolean
     */
    public function isRetencao()
    {
        return $this->retencao;
    }
}
