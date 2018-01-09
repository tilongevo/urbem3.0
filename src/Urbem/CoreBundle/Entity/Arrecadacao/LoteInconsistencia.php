<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * LoteInconsistencia
 */
class LoteInconsistencia
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * PK
     * @var integer
     */
    private $ocorrencia;

    /**
     * @var string
     */
    private $numeracao;

    /**
     * @var integer
     */
    private $valor;

    /**
     * @var \DateTime
     */
    private $dataPagamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Lote
     */
    private $fkArrecadacaoLote;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return LoteInconsistencia
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
     * Set codLote
     *
     * @param integer $codLote
     * @return LoteInconsistencia
     */
    public function setCodLote($codLote)
    {
        $this->codLote = $codLote;
        return $this;
    }

    /**
     * Get codLote
     *
     * @return integer
     */
    public function getCodLote()
    {
        return $this->codLote;
    }

    /**
     * Set ocorrencia
     *
     * @param integer $ocorrencia
     * @return LoteInconsistencia
     */
    public function setOcorrencia($ocorrencia)
    {
        $this->ocorrencia = $ocorrencia;
        return $this;
    }

    /**
     * Get ocorrencia
     *
     * @return integer
     */
    public function getOcorrencia()
    {
        return $this->ocorrencia;
    }

    /**
     * Set numeracao
     *
     * @param string $numeracao
     * @return LoteInconsistencia
     */
    public function setNumeracao($numeracao)
    {
        $this->numeracao = $numeracao;
        return $this;
    }

    /**
     * Get numeracao
     *
     * @return string
     */
    public function getNumeracao()
    {
        return $this->numeracao;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return LoteInconsistencia
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set dataPagamento
     *
     * @param \DateTime $dataPagamento
     * @return LoteInconsistencia
     */
    public function setDataPagamento(\DateTime $dataPagamento)
    {
        $this->dataPagamento = $dataPagamento;
        return $this;
    }

    /**
     * Get dataPagamento
     *
     * @return \DateTime
     */
    public function getDataPagamento()
    {
        return $this->dataPagamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoLote
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Lote $fkArrecadacaoLote
     * @return LoteInconsistencia
     */
    public function setFkArrecadacaoLote(\Urbem\CoreBundle\Entity\Arrecadacao\Lote $fkArrecadacaoLote)
    {
        $this->exercicio = $fkArrecadacaoLote->getExercicio();
        $this->codLote = $fkArrecadacaoLote->getCodLote();
        $this->fkArrecadacaoLote = $fkArrecadacaoLote;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoLote
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Lote
     */
    public function getFkArrecadacaoLote()
    {
        return $this->fkArrecadacaoLote;
    }
}
