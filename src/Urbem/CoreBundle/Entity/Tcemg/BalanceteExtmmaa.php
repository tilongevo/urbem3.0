<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * BalanceteExtmmaa
 */
class BalanceteExtmmaa
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
    private $categoria;

    /**
     * @var integer
     */
    private $tipoLancamento;

    /**
     * @var integer
     */
    private $subTipoLancamento;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    private $fkContabilidadePlanoAnalitica;


    /**
     * Set codPlano
     *
     * @param integer $codPlano
     * @return BalanceteExtmmaa
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
     * @return BalanceteExtmmaa
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
     * Set categoria
     *
     * @param integer $categoria
     * @return BalanceteExtmmaa
     */
    public function setCategoria($categoria = null)
    {
        $this->categoria = $categoria;
        return $this;
    }

    /**
     * Get categoria
     *
     * @return integer
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set tipoLancamento
     *
     * @param integer $tipoLancamento
     * @return BalanceteExtmmaa
     */
    public function setTipoLancamento($tipoLancamento = null)
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
     * Set subTipoLancamento
     *
     * @param integer $subTipoLancamento
     * @return BalanceteExtmmaa
     */
    public function setSubTipoLancamento($subTipoLancamento = null)
    {
        $this->subTipoLancamento = $subTipoLancamento;
        return $this;
    }

    /**
     * Get subTipoLancamento
     *
     * @return integer
     */
    public function getSubTipoLancamento()
    {
        return $this->subTipoLancamento;
    }

    /**
     * OneToOne (owning side)
     * Set ContabilidadePlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica
     * @return BalanceteExtmmaa
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
