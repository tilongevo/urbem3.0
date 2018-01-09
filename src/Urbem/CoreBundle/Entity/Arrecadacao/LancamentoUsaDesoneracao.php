<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * LancamentoUsaDesoneracao
 */
class LancamentoUsaDesoneracao
{
    /**
     * PK
     * @var integer
     */
    private $codLancamento;

    /**
     * PK
     * @var integer
     */
    private $codCalculo;

    /**
     * PK
     * @var integer
     */
    private $codDesoneracao;

    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * PK
     * @var integer
     */
    private $ocorrencia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\LancamentoCalculo
     */
    private $fkArrecadacaoLancamentoCalculo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Desonerado
     */
    private $fkArrecadacaoDesonerado;


    /**
     * Set codLancamento
     *
     * @param integer $codLancamento
     * @return LancamentoUsaDesoneracao
     */
    public function setCodLancamento($codLancamento)
    {
        $this->codLancamento = $codLancamento;
        return $this;
    }

    /**
     * Get codLancamento
     *
     * @return integer
     */
    public function getCodLancamento()
    {
        return $this->codLancamento;
    }

    /**
     * Set codCalculo
     *
     * @param integer $codCalculo
     * @return LancamentoUsaDesoneracao
     */
    public function setCodCalculo($codCalculo)
    {
        $this->codCalculo = $codCalculo;
        return $this;
    }

    /**
     * Get codCalculo
     *
     * @return integer
     */
    public function getCodCalculo()
    {
        return $this->codCalculo;
    }

    /**
     * Set codDesoneracao
     *
     * @param integer $codDesoneracao
     * @return LancamentoUsaDesoneracao
     */
    public function setCodDesoneracao($codDesoneracao)
    {
        $this->codDesoneracao = $codDesoneracao;
        return $this;
    }

    /**
     * Get codDesoneracao
     *
     * @return integer
     */
    public function getCodDesoneracao()
    {
        return $this->codDesoneracao;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return LancamentoUsaDesoneracao
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set ocorrencia
     *
     * @param integer $ocorrencia
     * @return LancamentoUsaDesoneracao
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
     * ManyToOne (inverse side)
     * Set fkArrecadacaoLancamentoCalculo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\LancamentoCalculo $fkArrecadacaoLancamentoCalculo
     * @return LancamentoUsaDesoneracao
     */
    public function setFkArrecadacaoLancamentoCalculo(\Urbem\CoreBundle\Entity\Arrecadacao\LancamentoCalculo $fkArrecadacaoLancamentoCalculo)
    {
        $this->codCalculo = $fkArrecadacaoLancamentoCalculo->getCodCalculo();
        $this->codLancamento = $fkArrecadacaoLancamentoCalculo->getCodLancamento();
        $this->fkArrecadacaoLancamentoCalculo = $fkArrecadacaoLancamentoCalculo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoLancamentoCalculo
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\LancamentoCalculo
     */
    public function getFkArrecadacaoLancamentoCalculo()
    {
        return $this->fkArrecadacaoLancamentoCalculo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoDesonerado
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Desonerado $fkArrecadacaoDesonerado
     * @return LancamentoUsaDesoneracao
     */
    public function setFkArrecadacaoDesonerado(\Urbem\CoreBundle\Entity\Arrecadacao\Desonerado $fkArrecadacaoDesonerado)
    {
        $this->codDesoneracao = $fkArrecadacaoDesonerado->getCodDesoneracao();
        $this->numcgm = $fkArrecadacaoDesonerado->getNumcgm();
        $this->ocorrencia = $fkArrecadacaoDesonerado->getOcorrencia();
        $this->fkArrecadacaoDesonerado = $fkArrecadacaoDesonerado;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoDesonerado
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Desonerado
     */
    public function getFkArrecadacaoDesonerado()
    {
        return $this->fkArrecadacaoDesonerado;
    }
}
