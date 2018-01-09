<?php

namespace Urbem\CoreBundle\Entity\Tesouraria;

use Doctrine\ORM\Mapping as ORM;

/**
 * VwOrcamentariaEstornoRegistrosView
 *
 * @ORM\Table(name="tesouraria.vw_orcamentaria_pagamentos_estorno_registros")
 * @ORM\Entity
 */
class VwOrcamentariaPagamentosEstornoRegistrosView
{
    /**
     * @var integer
     *
     * @ORM\Column(name="cod_empenho", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $codEmpenho;
    
    /**
     * @var string
     *
     * @ORM\Column(name="ex_empenho", type="string", nullable=false)
     */
    private $exEmpenho;
    
    /**
     * @var string
     *
     * @ORM\Column(name="dt_empenho", type="string", nullable=false)
     */
    private $dtEmpenho;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="cod_nota", type="integer", nullable=false)
     */
    private $codNota;
    
    /**
     * @var string
     *
     * @ORM\Column(name="ex_nota", type="string", nullable=false)
     */
    private $exNota;
    
    /**
     * @var string
     *
     * @ORM\Column(name="dt_nota", type="string", nullable=false)
     */
    private $dtNota;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="cod_entidade", type="integer", nullable=false)
     */
    private $codEntidade;
    
    /**
     * @var decimal
     *
     * @ORM\Column(name="vl_pago", type="decimal", nullable=false)
     */
    private $vlPago;
    
    /**
     * @var decimal
     *
     * @ORM\Column(name="vl_pagonaoprestado", type="decimal", nullable=false)
     */
    private $vlPagonaoprestado;
    
    /**
     * @var decimal
     *
     * @ORM\Column(name="vl_prestado", type="decimal", nullable=false)
     */
    private $vlPrestado;
    
    /**
     * @var datetime
     *
     * @ORM\Column(name="timestamp", type="datetime", nullable=false)
     */
    private $timestamp;
    
    /**
     * @var string
     *
     * @ORM\Column(name="dt_pagamento", type="string", nullable=false)
     */
    private $dtPagamento;
    
    /**
     * @var decimal
     *
     * @ORM\Column(name="vl_pagamento", type="decimal", nullable=false)
     */
    private $vlPagamento;
    
    /**
     * @var decimal
     *
     * @ORM\Column(name="vl_anulado", type="decimal", nullable=false)
     */
    private $vlAnulado;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="cod_recurso", type="integer", nullable=false)
     */
    private $codRecurso;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="cod_plano", type="integer", nullable=false)
     */
    private $codPlano;
    
    /**
     * @var string
     *
     * @ORM\Column(name="exercicio_plano", type="string", nullable=false)
     */
    private $exercicioPlano;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="cod_ordem", type="integer", nullable=false)
     */
    private $codOrdem;
    
    /**
     * @var string
     *
     * @ORM\Column(name="exercicio", type="string", nullable=false)
     */
    private $exercicio;

    /**
     * Get the value of Cod Empenho
     *
     * @return integer
     */
    public function getCodEmpenho()
    {
        return $this->codEmpenho;
    }

    /**
     * Get the value of Ex Empenho
     *
     * @return string
     */
    public function getExEmpenho()
    {
        return $this->exEmpenho;
    }

    /**
     * Get the value of Dt Empenho
     *
     * @return string
     */
    public function getDtEmpenho()
    {
        return $this->dtEmpenho;
    }

    /**
     * Get the value of Cod Nota
     *
     * @return integer
     */
    public function getCodNota()
    {
        return $this->codNota;
    }

    /**
     * Get the value of Ex Nota
     *
     * @return string
     */
    public function getExNota()
    {
        return $this->exNota;
    }

    /**
     * Get the value of Dt Nota
     *
     * @return string
     */
    public function getDtNota()
    {
        return $this->dtNota;
    }

    /**
     * Get the value of Cod Entidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Get the value of Vl Pago
     *
     * @return decimal
     */
    public function getVlPago()
    {
        return $this->vlPago;
    }

    /**
     * Get the value of Vl Pagonaoprestado
     *
     * @return decimal
     */
    public function getVlPagonaoprestado()
    {
        return $this->vlPagonaoprestado;
    }

    /**
     * Get the value of Vl Prestado
     *
     * @return decimal
     */
    public function getVlPrestado()
    {
        return $this->vlPrestado;
    }

    /**
     * Get the value of Timestamp
     *
     * @return datetime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Get the value of Dt Pagamento
     *
     * @return string
     */
    public function getDtPagamento()
    {
        return $this->dtPagamento;
    }

    /**
     * Get the value of Vl Pagamento
     *
     * @return decimal
     */
    public function getVlPagamento()
    {
        return $this->vlPagamento;
    }

    /**
     * Get the value of Vl Anulado
     *
     * @return decimal
     */
    public function getVlAnulado()
    {
        return $this->vlAnulado;
    }

    /**
     * Get the value of Cod Recurso
     *
     * @return integer
     */
    public function getCodRecurso()
    {
        return $this->codRecurso;
    }

    /**
     * Get the value of Cod Plano
     *
     * @return integer
     */
    public function getCodPlano()
    {
        return $this->codPlano;
    }

    /**
     * Get the value of Exercicio Plano
     *
     * @return string
     */
    public function getExercicioPlano()
    {
        return $this->exercicioPlano;
    }

    /**
     * Get the value of Cod Ordem
     *
     * @return integer
     */
    public function getCodOrdem()
    {
        return $this->codOrdem;
    }

    /**
     * Get the value of Exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }
}
