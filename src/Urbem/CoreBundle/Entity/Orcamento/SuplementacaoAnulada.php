<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * SuplementacaoAnulada
 */
class SuplementacaoAnulada
{
    /**
     * PK
     * @var integer
     */
    private $codSuplementacao;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codSuplementacaoAnulacao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Orcamento\Suplementacao
     */
    private $fkOrcamentoSuplementacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Suplementacao
     */
    private $fkOrcamentoSuplementacao1;


    /**
     * Set codSuplementacao
     *
     * @param integer $codSuplementacao
     * @return SuplementacaoAnulada
     */
    public function setCodSuplementacao($codSuplementacao)
    {
        $this->codSuplementacao = $codSuplementacao;
        return $this;
    }

    /**
     * Get codSuplementacao
     *
     * @return integer
     */
    public function getCodSuplementacao()
    {
        return $this->codSuplementacao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return SuplementacaoAnulada
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
     * Set codSuplementacaoAnulacao
     *
     * @param integer $codSuplementacaoAnulacao
     * @return SuplementacaoAnulada
     */
    public function setCodSuplementacaoAnulacao($codSuplementacaoAnulacao)
    {
        $this->codSuplementacaoAnulacao = $codSuplementacaoAnulacao;
        return $this;
    }

    /**
     * Get codSuplementacaoAnulacao
     *
     * @return integer
     */
    public function getCodSuplementacaoAnulacao()
    {
        return $this->codSuplementacaoAnulacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoSuplementacao1
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Suplementacao $fkOrcamentoSuplementacao1
     * @return SuplementacaoAnulada
     */
    public function setFkOrcamentoSuplementacao1(\Urbem\CoreBundle\Entity\Orcamento\Suplementacao $fkOrcamentoSuplementacao1)
    {
        $this->exercicio = $fkOrcamentoSuplementacao1->getExercicio();
        $this->codSuplementacaoAnulacao = $fkOrcamentoSuplementacao1->getCodSuplementacao();
        $this->fkOrcamentoSuplementacao1 = $fkOrcamentoSuplementacao1;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoSuplementacao1
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Suplementacao
     */
    public function getFkOrcamentoSuplementacao1()
    {
        return $this->fkOrcamentoSuplementacao1;
    }

    /**
     * OneToOne (owning side)
     * Set OrcamentoSuplementacao
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Suplementacao $fkOrcamentoSuplementacao
     * @return SuplementacaoAnulada
     */
    public function setFkOrcamentoSuplementacao(\Urbem\CoreBundle\Entity\Orcamento\Suplementacao $fkOrcamentoSuplementacao)
    {
        $this->exercicio = $fkOrcamentoSuplementacao->getExercicio();
        $this->codSuplementacao = $fkOrcamentoSuplementacao->getCodSuplementacao();
        $this->fkOrcamentoSuplementacao = $fkOrcamentoSuplementacao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkOrcamentoSuplementacao
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Suplementacao
     */
    public function getFkOrcamentoSuplementacao()
    {
        return $this->fkOrcamentoSuplementacao;
    }
}
