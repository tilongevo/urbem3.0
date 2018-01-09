<?php

namespace Urbem\CoreBundle\Entity\Tesouraria;

use Doctrine\ORM\Mapping as ORM;

/**
 * VwOrcamentariaEstorno
 */
class VwOrcamentariaPagamentosView
{
    /**
     * @var integer
     */
    private $codOrdem;
    
    /**
     * @var string
     */
    private $exercicio;
    
    /**
     * @var integer
     */
    private $codEntidade;
    
    /**
     * @var string
     */
    private $dtEmissao;
    
    /**
     * @var string
     */
    private $dtVencimento;
    
    /**
     * @var string
     */
    private $observacao;
    
    /**
     * @var string
     */
    private $entidade;
    
    /**
     * @var integer
     */
    private $codRecurso;
    
    /**
     * @var string
     */
    private $mascRecursoRed;
    
    /**
     * @var integer
     */
    private $codDetalhamento;
    
    /**
     * @var integer
     */
    private $cgmBeneficiario;
    
    /**
     * @var boolean
     */
    private $implantado;
    
    /**
     * @var string
     */
    private $beneficiario;
    
    /**
     * @var integer
     */
    private $numExercicioEmpenho;
    
    /**
     * @var string
     */
    private $exercicioEmpenho;
    
    /**
     * @var string
     */
    private $dtEstorno;
    
    /**
     * @var string
     */
    private $valorPagamento;
    
    /**
     * @var string
     */
    private $valorAnulada;
    
    /**
     * @var string
     */
    private $saldoPagamento;
    
    /**
     * @var string
     */
    private $notaEmpenho;
    
    /**
     * @var string
     */
    private $vlNota;
    
    /**
     * @var string
     */
    private $vlNotaAnulacoes;
    
    /**
     * @var string
     */
    private $vlNotaOriginal;
    
    /**
     * @var string
     */
    private $situacao;
    
    /**
     * @var string
     */
    private $pagamentoEstornado;
    
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
     * Get the value of Dt Emissao
     *
     * @return string
     */
    public function getDtEmissao()
    {
        return $this->dtEmissao;
    }

    /**
     * Get the value of Dt Vencimento
     *
     * @return string
     */
    public function getDtVencimento()
    {
        return $this->dtVencimento;
    }

    /**
     * Get the value of Observacao
     *
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * Get the value of Entidade
     *
     * @return string
     */
    public function getEntidade()
    {
        return $this->entidade;
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
     * Get the value of Masc Recurso Red
     *
     * @return string
     */
    public function getMascRecursoRed()
    {
        return $this->mascRecursoRed;
    }

    /**
     * Get the value of Cod Detalhamento
     *
     * @return integer
     */
    public function getCodDetalhamento()
    {
        return $this->codDetalhamento;
    }

    /**
     * Get the value of Cgm Beneficiario
     *
     * @return integer
     */
    public function getCgmBeneficiario()
    {
        return $this->cgmBeneficiario;
    }

    /**
     * Get the value of Implantado
     *
     * @return boolean
     */
    public function getImplantado()
    {
        return $this->implantado;
    }

    /**
     * Get the value of Beneficiario
     *
     * @return string
     */
    public function getBeneficiario()
    {
        return $this->beneficiario;
    }

    /**
     * Get the value of Num Exercicio Empenho
     *
     * @return integer
     */
    public function getNumExercicioEmpenho()
    {
        return $this->numExercicioEmpenho;
    }

    /**
     * Get the value of Exercicio Empenho
     *
     * @return string
     */
    public function getExercicioEmpenho()
    {
        return $this->exercicioEmpenho;
    }

    /**
     * Get the value of Dt Estorno
     *
     * @return string
     */
    public function getDtEstorno()
    {
        return $this->dtEstorno;
    }

    /**
     * Get the value of Valor Pagamento
     *
     * @return string
     */
    public function getValorPagamento()
    {
        return $this->valorPagamento;
    }

    /**
     * Get the value of Valor Anulada
     *
     * @return string
     */
    public function getValorAnulada()
    {
        return $this->valorAnulada;
    }

    /**
     * Get the value of Saldo Pagamento
     *
     * @return string
     */
    public function getSaldoPagamento()
    {
        return $this->saldoPagamento;
    }

    /**
     * Get the value of Nota Empenho
     *
     * @return string
     */
    public function getNotaEmpenho()
    {
        return $this->notaEmpenho;
    }

    /**
     * Get the value of Vl Nota
     *
     * @return string
     */
    public function getVlNota()
    {
        return $this->vlNota;
    }

    /**
     * Get the value of Vl Nota Anulacoes
     *
     * @return string
     */
    public function getVlNotaAnulacoes()
    {
        return $this->vlNotaAnulacoes;
    }

    /**
     * Get the value of Vl Nota Original
     *
     * @return string
     */
    public function getVlNotaOriginal()
    {
        return $this->vlNotaOriginal;
    }

    /**
     * Get the value of Situacao
     *
     * @return string
     */
    public function getSituacao()
    {
        return $this->situacao;
    }

    /**
     * Get the value of Pagamento Estornado
     *
     * @return string
     */
    public function getPagamentoEstornado()
    {
        return $this->pagamentoEstornado;
    }
    
    public function getNrEmpenho()
    {
        $pattern = "/(\d+\/\d{4})/";
        preg_match_all($pattern, $this->getNotaEmpenho(), $matches);
        return $matches[0][1];
    }
    
    public function getCodEmpenho()
    {
        // $pattern = "/(\d+)\/\d{4}/";
        // preg_match_all($pattern, $this->getNotaEmpenho(), $matches);
        // return $matches[1][0];
        return $this->codEmpenho;
    }
    
    public function getLiquidacao()
    {
        $pattern = "/(\d+\/\d{4})/";
        preg_match_all($pattern, $this->getNotaEmpenho(), $matches);
        return $matches[0][0];
    }
    
    public function getNrOp()
    {
        return $this->getCodOrdem() . "/" . $this->getExercicio();
    }
    
    public function getCodEntidadeNomEntidade()
    {
        return $this->getCodEntidade() . " - " . $this->getEntidade();
    }
}
