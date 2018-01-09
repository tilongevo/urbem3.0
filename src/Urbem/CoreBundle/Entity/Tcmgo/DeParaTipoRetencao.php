<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * DeParaTipoRetencao
 */
class DeParaTipoRetencao
{
    /**
     * PK
     * @var string
     */
    private $exercicioTipo;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codPlano;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmgo\TipoRetencao
     */
    private $fkTcmgoTipoRetencao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    private $fkContabilidadePlanoAnalitica;


    /**
     * Set exercicioTipo
     *
     * @param string $exercicioTipo
     * @return DeParaTipoRetencao
     */
    public function setExercicioTipo($exercicioTipo)
    {
        $this->exercicioTipo = $exercicioTipo;
        return $this;
    }

    /**
     * Get exercicioTipo
     *
     * @return string
     */
    public function getExercicioTipo()
    {
        return $this->exercicioTipo;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return DeParaTipoRetencao
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return DeParaTipoRetencao
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
     * Set codPlano
     *
     * @param integer $codPlano
     * @return DeParaTipoRetencao
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
     * ManyToOne (inverse side)
     * Set fkTcmgoTipoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\TipoRetencao $fkTcmgoTipoRetencao
     * @return DeParaTipoRetencao
     */
    public function setFkTcmgoTipoRetencao(\Urbem\CoreBundle\Entity\Tcmgo\TipoRetencao $fkTcmgoTipoRetencao)
    {
        $this->exercicioTipo = $fkTcmgoTipoRetencao->getExercicio();
        $this->codTipo = $fkTcmgoTipoRetencao->getCodTipo();
        $this->fkTcmgoTipoRetencao = $fkTcmgoTipoRetencao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmgoTipoRetencao
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\TipoRetencao
     */
    public function getFkTcmgoTipoRetencao()
    {
        return $this->fkTcmgoTipoRetencao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadePlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica
     * @return DeParaTipoRetencao
     */
    public function setFkContabilidadePlanoAnalitica(\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica)
    {
        $this->codPlano = $fkContabilidadePlanoAnalitica->getCodPlano();
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
}
