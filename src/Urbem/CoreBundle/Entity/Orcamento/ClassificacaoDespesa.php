<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * ClassificacaoDespesa
 */
class ClassificacaoDespesa
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
    private $codConta;

    /**
     * PK
     * @var integer
     */
    private $codPosicao;

    /**
     * @var integer
     */
    private $codClassificacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\ContaDespesa
     */
    private $fkOrcamentoContaDespesa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\PosicaoDespesa
     */
    private $fkOrcamentoPosicaoDespesa;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ClassificacaoDespesa
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
     * Set codConta
     *
     * @param integer $codConta
     * @return ClassificacaoDespesa
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
     * Set codPosicao
     *
     * @param integer $codPosicao
     * @return ClassificacaoDespesa
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
     * Set codClassificacao
     *
     * @param integer $codClassificacao
     * @return ClassificacaoDespesa
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
     * Set fkOrcamentoContaDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ContaDespesa $fkOrcamentoContaDespesa
     * @return ClassificacaoDespesa
     */
    public function setFkOrcamentoContaDespesa(\Urbem\CoreBundle\Entity\Orcamento\ContaDespesa $fkOrcamentoContaDespesa)
    {
        $this->exercicio = $fkOrcamentoContaDespesa->getExercicio();
        $this->codConta = $fkOrcamentoContaDespesa->getCodConta();
        $this->fkOrcamentoContaDespesa = $fkOrcamentoContaDespesa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoContaDespesa
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\ContaDespesa
     */
    public function getFkOrcamentoContaDespesa()
    {
        return $this->fkOrcamentoContaDespesa;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoPosicaoDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\PosicaoDespesa $fkOrcamentoPosicaoDespesa
     * @return ClassificacaoDespesa
     */
    public function setFkOrcamentoPosicaoDespesa(\Urbem\CoreBundle\Entity\Orcamento\PosicaoDespesa $fkOrcamentoPosicaoDespesa)
    {
        $this->exercicio = $fkOrcamentoPosicaoDespesa->getExercicio();
        $this->codPosicao = $fkOrcamentoPosicaoDespesa->getCodPosicao();
        $this->fkOrcamentoPosicaoDespesa = $fkOrcamentoPosicaoDespesa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoPosicaoDespesa
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\PosicaoDespesa
     */
    public function getFkOrcamentoPosicaoDespesa()
    {
        return $this->fkOrcamentoPosicaoDespesa;
    }
}
