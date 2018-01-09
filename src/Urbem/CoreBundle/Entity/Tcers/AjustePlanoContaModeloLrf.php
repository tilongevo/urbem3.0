<?php
 
namespace Urbem\CoreBundle\Entity\Tcers;

/**
 * AjustePlanoContaModeloLrf
 */
class AjustePlanoContaModeloLrf
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
    private $codModelo;

    /**
     * PK
     * @var integer
     */
    private $codConta;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $codQuadro;

    /**
     * PK
     * @var integer
     */
    private $mes;

    /**
     * @var integer
     */
    private $vlAjuste;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcers\PlanoContaModeloLrf
     */
    private $fkTcersPlanoContaModeloLrf;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return AjustePlanoContaModeloLrf
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
     * Set codModelo
     *
     * @param integer $codModelo
     * @return AjustePlanoContaModeloLrf
     */
    public function setCodModelo($codModelo)
    {
        $this->codModelo = $codModelo;
        return $this;
    }

    /**
     * Get codModelo
     *
     * @return integer
     */
    public function getCodModelo()
    {
        return $this->codModelo;
    }

    /**
     * Set codConta
     *
     * @param integer $codConta
     * @return AjustePlanoContaModeloLrf
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return AjustePlanoContaModeloLrf
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
     * Set codQuadro
     *
     * @param integer $codQuadro
     * @return AjustePlanoContaModeloLrf
     */
    public function setCodQuadro($codQuadro)
    {
        $this->codQuadro = $codQuadro;
        return $this;
    }

    /**
     * Get codQuadro
     *
     * @return integer
     */
    public function getCodQuadro()
    {
        return $this->codQuadro;
    }

    /**
     * Set mes
     *
     * @param integer $mes
     * @return AjustePlanoContaModeloLrf
     */
    public function setMes($mes)
    {
        $this->mes = $mes;
        return $this;
    }

    /**
     * Get mes
     *
     * @return integer
     */
    public function getMes()
    {
        return $this->mes;
    }

    /**
     * Set vlAjuste
     *
     * @param integer $vlAjuste
     * @return AjustePlanoContaModeloLrf
     */
    public function setVlAjuste($vlAjuste)
    {
        $this->vlAjuste = $vlAjuste;
        return $this;
    }

    /**
     * Get vlAjuste
     *
     * @return integer
     */
    public function getVlAjuste()
    {
        return $this->vlAjuste;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return AjustePlanoContaModeloLrf
     */
    public function setFkOrcamentoEntidade(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
        $this->exercicio = $fkOrcamentoEntidade->getExercicio();
        $this->codEntidade = $fkOrcamentoEntidade->getCodEntidade();
        $this->fkOrcamentoEntidade = $fkOrcamentoEntidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoEntidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    public function getFkOrcamentoEntidade()
    {
        return $this->fkOrcamentoEntidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcersPlanoContaModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Tcers\PlanoContaModeloLrf $fkTcersPlanoContaModeloLrf
     * @return AjustePlanoContaModeloLrf
     */
    public function setFkTcersPlanoContaModeloLrf(\Urbem\CoreBundle\Entity\Tcers\PlanoContaModeloLrf $fkTcersPlanoContaModeloLrf)
    {
        $this->exercicio = $fkTcersPlanoContaModeloLrf->getExercicio();
        $this->codModelo = $fkTcersPlanoContaModeloLrf->getCodModelo();
        $this->codConta = $fkTcersPlanoContaModeloLrf->getCodConta();
        $this->codQuadro = $fkTcersPlanoContaModeloLrf->getCodQuadro();
        $this->fkTcersPlanoContaModeloLrf = $fkTcersPlanoContaModeloLrf;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcersPlanoContaModeloLrf
     *
     * @return \Urbem\CoreBundle\Entity\Tcers\PlanoContaModeloLrf
     */
    public function getFkTcersPlanoContaModeloLrf()
    {
        return $this->fkTcersPlanoContaModeloLrf;
    }
}
