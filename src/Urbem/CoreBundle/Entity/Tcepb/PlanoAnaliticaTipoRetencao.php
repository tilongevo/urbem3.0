<?php
 
namespace Urbem\CoreBundle\Entity\Tcepb;

/**
 * PlanoAnaliticaTipoRetencao
 */
class PlanoAnaliticaTipoRetencao
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
    private $codTipo;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    private $fkContabilidadePlanoAnalitica;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcepb\TipoRetencao
     */
    private $fkTcepbTipoRetencao;


    /**
     * Set codPlano
     *
     * @param integer $codPlano
     * @return PlanoAnaliticaTipoRetencao
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
     * @return PlanoAnaliticaTipoRetencao
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return PlanoAnaliticaTipoRetencao
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
     * ManyToOne (inverse side)
     * Set fkTcepbTipoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\TipoRetencao $fkTcepbTipoRetencao
     * @return PlanoAnaliticaTipoRetencao
     */
    public function setFkTcepbTipoRetencao(\Urbem\CoreBundle\Entity\Tcepb\TipoRetencao $fkTcepbTipoRetencao)
    {
        $this->codTipo = $fkTcepbTipoRetencao->getCodTipo();
        $this->fkTcepbTipoRetencao = $fkTcepbTipoRetencao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcepbTipoRetencao
     *
     * @return \Urbem\CoreBundle\Entity\Tcepb\TipoRetencao
     */
    public function getFkTcepbTipoRetencao()
    {
        return $this->fkTcepbTipoRetencao;
    }

    /**
     * OneToOne (owning side)
     * Set ContabilidadePlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica
     * @return PlanoAnaliticaTipoRetencao
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
