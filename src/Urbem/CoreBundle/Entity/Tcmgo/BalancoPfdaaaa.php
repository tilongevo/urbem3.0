<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * BalancoPfdaaaa
 */
class BalancoPfdaaaa
{
    /**
     * PK
     * @var integer
     */
    private $codPlano;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $tipoLancamento;

    /**
     * @var integer
     */
    private $desdobramentoTipo;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    private $fkContabilidadePlanoAnalitica;


    /**
     * Set codPlano
     *
     * @param integer $codPlano
     * @return BalancoPfdaaaa
     */
    public function setCodPlano($codPlano)
    {
        $this->codPlano = $codPlano;
        return $this;
    }

    /**
     * Get codPlano
     *
     * @return integer
     */
    public function getCodPlano()
    {
        return $this->codPlano;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return BalancoPfdaaaa
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
     * Set tipoLancamento
     *
     * @param integer $tipoLancamento
     * @return BalancoPfdaaaa
     */
    public function setTipoLancamento($tipoLancamento)
    {
        $this->tipoLancamento = $tipoLancamento;
        return $this;
    }

    /**
     * Get tipoLancamento
     *
     * @return integer
     */
    public function getTipoLancamento()
    {
        return $this->tipoLancamento;
    }

    /**
     * Set desdobramentoTipo
     *
     * @param integer $desdobramentoTipo
     * @return BalancoPfdaaaa
     */
    public function setDesdobramentoTipo($desdobramentoTipo = null)
    {
        $this->desdobramentoTipo = $desdobramentoTipo;
        return $this;
    }

    /**
     * Get desdobramentoTipo
     *
     * @return integer
     */
    public function getDesdobramentoTipo()
    {
        return $this->desdobramentoTipo;
    }

    /**
     * OneToOne (owning side)
     * Set ContabilidadePlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica
     * @return BalancoPfdaaaa
     */
    public function setFkContabilidadePlanoAnalitica(\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica)
    {
        $this->codPlano = $fkContabilidadePlanoAnalitica->getCodPlano();
        $this->exercicio = $fkContabilidadePlanoAnalitica->getExercicio();
        $this->fkContabilidadePlanoAnalitica = $fkContabilidadePlanoAnalitica;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkContabilidadePlanoAnalitica
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    public function getFkContabilidadePlanoAnalitica()
    {
        return $this->fkContabilidadePlanoAnalitica;
    }
}
