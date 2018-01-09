<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * JustificativaRazao
 */
class JustificativaRazao
{
    /**
     * PK
     * @var integer
     */
    private $codLicitacao;

    /**
     * PK
     * @var integer
     */
    private $codModalidade;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $justificativa;

    /**
     * @var string
     */
    private $razao;

    /**
     * @var string
     */
    private $fundamentacaoLegal;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Licitacao\Licitacao
     */
    private $fkLicitacaoLicitacao;


    /**
     * Set codLicitacao
     *
     * @param integer $codLicitacao
     * @return JustificativaRazao
     */
    public function setCodLicitacao($codLicitacao)
    {
        $this->codLicitacao = $codLicitacao;
        return $this;
    }

    /**
     * Get codLicitacao
     *
     * @return integer
     */
    public function getCodLicitacao()
    {
        return $this->codLicitacao;
    }

    /**
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return JustificativaRazao
     */
    public function setCodModalidade($codModalidade)
    {
        $this->codModalidade = $codModalidade;
        return $this;
    }

    /**
     * Get codModalidade
     *
     * @return integer
     */
    public function getCodModalidade()
    {
        return $this->codModalidade;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return JustificativaRazao
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return JustificativaRazao
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
     * Set justificativa
     *
     * @param string $justificativa
     * @return JustificativaRazao
     */
    public function setJustificativa($justificativa)
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
     * Set razao
     *
     * @param string $razao
     * @return JustificativaRazao
     */
    public function setRazao($razao)
    {
        $this->razao = $razao;
        return $this;
    }

    /**
     * Get razao
     *
     * @return string
     */
    public function getRazao()
    {
        return $this->razao;
    }

    /**
     * Set fundamentacaoLegal
     *
     * @param string $fundamentacaoLegal
     * @return JustificativaRazao
     */
    public function setFundamentacaoLegal($fundamentacaoLegal)
    {
        $this->fundamentacaoLegal = $fundamentacaoLegal;
        return $this;
    }

    /**
     * Get fundamentacaoLegal
     *
     * @return string
     */
    public function getFundamentacaoLegal()
    {
        return $this->fundamentacaoLegal;
    }

    /**
     * OneToOne (owning side)
     * Set LicitacaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao
     * @return JustificativaRazao
     */
    public function setFkLicitacaoLicitacao(\Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao)
    {
        $this->codLicitacao = $fkLicitacaoLicitacao->getCodLicitacao();
        $this->codModalidade = $fkLicitacaoLicitacao->getCodModalidade();
        $this->codEntidade = $fkLicitacaoLicitacao->getCodEntidade();
        $this->exercicio = $fkLicitacaoLicitacao->getExercicio();
        $this->fkLicitacaoLicitacao = $fkLicitacaoLicitacao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkLicitacaoLicitacao
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\Licitacao
     */
    public function getFkLicitacaoLicitacao()
    {
        return $this->fkLicitacaoLicitacao;
    }
}
