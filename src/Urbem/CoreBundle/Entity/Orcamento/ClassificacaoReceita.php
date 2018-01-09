<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * ClassificacaoReceita
 */
class ClassificacaoReceita
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
    private $codPosicao;

    /**
     * PK
     * @var integer
     */
    private $codConta;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var integer
     */
    private $codClassificacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\PosicaoReceita
     */
    private $fkOrcamentoPosicaoReceita;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\ContaReceita
     */
    private $fkOrcamentoContaReceita;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ClassificacaoReceita
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
     * Set codPosicao
     *
     * @param integer $codPosicao
     * @return ClassificacaoReceita
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

    /**
     * Set codConta
     *
     * @param integer $codConta
     * @return ClassificacaoReceita
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return ClassificacaoReceita
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set codClassificacao
     *
     * @param integer $codClassificacao
     * @return ClassificacaoReceita
     */
    public function setCodClassificacao($codClassificacao = null)
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
     * ManyToOne (inverse side)
     * Set fkOrcamentoPosicaoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\PosicaoReceita $fkOrcamentoPosicaoReceita
     * @return ClassificacaoReceita
     */
    public function setFkOrcamentoPosicaoReceita(\Urbem\CoreBundle\Entity\Orcamento\PosicaoReceita $fkOrcamentoPosicaoReceita)
    {
        $this->exercicio = $fkOrcamentoPosicaoReceita->getExercicio();
        $this->codPosicao = $fkOrcamentoPosicaoReceita->getCodPosicao();
        $this->codTipo = $fkOrcamentoPosicaoReceita->getCodTipo();
        $this->fkOrcamentoPosicaoReceita = $fkOrcamentoPosicaoReceita;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoPosicaoReceita
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\PosicaoReceita
     */
    public function getFkOrcamentoPosicaoReceita()
    {
        return $this->fkOrcamentoPosicaoReceita;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoContaReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ContaReceita $fkOrcamentoContaReceita
     * @return ClassificacaoReceita
     */
    public function setFkOrcamentoContaReceita(\Urbem\CoreBundle\Entity\Orcamento\ContaReceita $fkOrcamentoContaReceita)
    {
        $this->exercicio = $fkOrcamentoContaReceita->getExercicio();
        $this->codConta = $fkOrcamentoContaReceita->getCodConta();
        $this->fkOrcamentoContaReceita = $fkOrcamentoContaReceita;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoContaReceita
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\ContaReceita
     */
    public function getFkOrcamentoContaReceita()
    {
        return $this->fkOrcamentoContaReceita;
    }
}
