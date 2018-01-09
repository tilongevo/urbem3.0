<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * EmpenhoModalidade
 */
class EmpenhoModalidade
{
    /**
     * PK
     * @var string
     */
    private $codModalidade;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $codEmpenho;

    /**
     * @var string
     */
    private $codFundamentacao;

    /**
     * @var string
     */
    private $justificativa;

    /**
     * @var string
     */
    private $razaoEscolha;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmgo\Modalidade
     */
    private $fkTcmgoModalidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmgo\FundamentacaoLegal
     */
    private $fkTcmgoFundamentacaoLegal;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    private $fkEmpenhoEmpenho;


    /**
     * Set codModalidade
     *
     * @param string $codModalidade
     * @return EmpenhoModalidade
     */
    public function setCodModalidade($codModalidade)
    {
        $this->codModalidade = $codModalidade;
        return $this;
    }

    /**
     * Get codModalidade
     *
     * @return string
     */
    public function getCodModalidade()
    {
        return $this->codModalidade;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return EmpenhoModalidade
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return EmpenhoModalidade
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set codEmpenho
     *
     * @param integer $codEmpenho
     * @return EmpenhoModalidade
     */
    public function setCodEmpenho($codEmpenho)
    {
        $this->codEmpenho = $codEmpenho;
        return $this;
    }

    /**
     * Get codEmpenho
     *
     * @return integer
     */
    public function getCodEmpenho()
    {
        return $this->codEmpenho;
    }

    /**
     * Set codFundamentacao
     *
     * @param string $codFundamentacao
     * @return EmpenhoModalidade
     */
    public function setCodFundamentacao($codFundamentacao = null)
    {
        $this->codFundamentacao = $codFundamentacao;
        return $this;
    }

    /**
     * Get codFundamentacao
     *
     * @return string
     */
    public function getCodFundamentacao()
    {
        return $this->codFundamentacao;
    }

    /**
     * Set justificativa
     *
     * @param string $justificativa
     * @return EmpenhoModalidade
     */
    public function setJustificativa($justificativa = null)
    {
        $this->justificativa = $justificativa;
        return $this;
    }

    /**
     * Get justificativa
     *
     * @return string
     */
    public function getJustificativa()
    {
        return $this->justificativa;
    }

    /**
     * Set razaoEscolha
     *
     * @param string $razaoEscolha
     * @return EmpenhoModalidade
     */
    public function setRazaoEscolha($razaoEscolha = null)
    {
        $this->razaoEscolha = $razaoEscolha;
        return $this;
    }

    /**
     * Get razaoEscolha
     *
     * @return string
     */
    public function getRazaoEscolha()
    {
        return $this->razaoEscolha;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcmgoModalidade
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\Modalidade $fkTcmgoModalidade
     * @return EmpenhoModalidade
     */
    public function setFkTcmgoModalidade(\Urbem\CoreBundle\Entity\Tcmgo\Modalidade $fkTcmgoModalidade)
    {
        $this->codModalidade = $fkTcmgoModalidade->getCodModalidade();
        $this->fkTcmgoModalidade = $fkTcmgoModalidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmgoModalidade
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\Modalidade
     */
    public function getFkTcmgoModalidade()
    {
        return $this->fkTcmgoModalidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcmgoFundamentacaoLegal
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\FundamentacaoLegal $fkTcmgoFundamentacaoLegal
     * @return EmpenhoModalidade
     */
    public function setFkTcmgoFundamentacaoLegal(\Urbem\CoreBundle\Entity\Tcmgo\FundamentacaoLegal $fkTcmgoFundamentacaoLegal)
    {
        $this->codFundamentacao = $fkTcmgoFundamentacaoLegal->getCodFundamentacao();
        $this->fkTcmgoFundamentacaoLegal = $fkTcmgoFundamentacaoLegal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmgoFundamentacaoLegal
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\FundamentacaoLegal
     */
    public function getFkTcmgoFundamentacaoLegal()
    {
        return $this->fkTcmgoFundamentacaoLegal;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho
     * @return EmpenhoModalidade
     */
    public function setFkEmpenhoEmpenho(\Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho)
    {
        $this->codEmpenho = $fkEmpenhoEmpenho->getCodEmpenho();
        $this->exercicio = $fkEmpenhoEmpenho->getExercicio();
        $this->codEntidade = $fkEmpenhoEmpenho->getCodEntidade();
        $this->fkEmpenhoEmpenho = $fkEmpenhoEmpenho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    public function getFkEmpenhoEmpenho()
    {
        return $this->fkEmpenhoEmpenho;
    }
}
