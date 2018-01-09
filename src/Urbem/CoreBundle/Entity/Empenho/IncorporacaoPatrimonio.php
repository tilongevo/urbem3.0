<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * IncorporacaoPatrimonio
 */
class IncorporacaoPatrimonio
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
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $codNota;

    /**
     * @var integer
     */
    private $codPlanoCredito;

    /**
     * @var integer
     */
    private $codPlanoDebito;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao
     */
    private $fkEmpenhoNotaLiquidacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    private $fkContabilidadePlanoAnalitica;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    private $fkContabilidadePlanoAnalitica1;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return IncorporacaoPatrimonio
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
     * @return IncorporacaoPatrimonio
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
     * Set codNota
     *
     * @param integer $codNota
     * @return IncorporacaoPatrimonio
     */
    public function setCodNota($codNota)
    {
        $this->codNota = $codNota;
        return $this;
    }

    /**
     * Get codNota
     *
     * @return integer
     */
    public function getCodNota()
    {
        return $this->codNota;
    }

    /**
     * Set codPlanoCredito
     *
     * @param integer $codPlanoCredito
     * @return IncorporacaoPatrimonio
     */
    public function setCodPlanoCredito($codPlanoCredito)
    {
        $this->codPlanoCredito = $codPlanoCredito;
        return $this;
    }

    /**
     * Get codPlanoCredito
     *
     * @return integer
     */
    public function getCodPlanoCredito()
    {
        return $this->codPlanoCredito;
    }

    /**
     * Set codPlanoDebito
     *
     * @param integer $codPlanoDebito
     * @return IncorporacaoPatrimonio
     */
    public function setCodPlanoDebito($codPlanoDebito)
    {
        $this->codPlanoDebito = $codPlanoDebito;
        return $this;
    }

    /**
     * Get codPlanoDebito
     *
     * @return integer
     */
    public function getCodPlanoDebito()
    {
        return $this->codPlanoDebito;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadePlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica
     * @return IncorporacaoPatrimonio
     */
    public function setFkContabilidadePlanoAnalitica(\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica)
    {
        $this->codPlanoCredito = $fkContabilidadePlanoAnalitica->getCodPlano();
        $this->exercicio = $fkContabilidadePlanoAnalitica->getExercicio();
        $this->fkContabilidadePlanoAnalitica = $fkContabilidadePlanoAnalitica;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadePlanoAnalitica
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    public function getFkContabilidadePlanoAnalitica()
    {
        return $this->fkContabilidadePlanoAnalitica;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadePlanoAnalitica1
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica1
     * @return IncorporacaoPatrimonio
     */
    public function setFkContabilidadePlanoAnalitica1(\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica1)
    {
        $this->codPlanoDebito = $fkContabilidadePlanoAnalitica1->getCodPlano();
        $this->exercicio = $fkContabilidadePlanoAnalitica1->getExercicio();
        $this->fkContabilidadePlanoAnalitica1 = $fkContabilidadePlanoAnalitica1;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadePlanoAnalitica1
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    public function getFkContabilidadePlanoAnalitica1()
    {
        return $this->fkContabilidadePlanoAnalitica1;
    }

    /**
     * OneToOne (owning side)
     * Set EmpenhoNotaLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao $fkEmpenhoNotaLiquidacao
     * @return IncorporacaoPatrimonio
     */
    public function setFkEmpenhoNotaLiquidacao(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao $fkEmpenhoNotaLiquidacao)
    {
        $this->exercicio = $fkEmpenhoNotaLiquidacao->getExercicio();
        $this->codNota = $fkEmpenhoNotaLiquidacao->getCodNota();
        $this->codEntidade = $fkEmpenhoNotaLiquidacao->getCodEntidade();
        $this->fkEmpenhoNotaLiquidacao = $fkEmpenhoNotaLiquidacao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkEmpenhoNotaLiquidacao
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao
     */
    public function getFkEmpenhoNotaLiquidacao()
    {
        return $this->fkEmpenhoNotaLiquidacao;
    }
}
