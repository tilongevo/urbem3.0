<?php
 
namespace Urbem\CoreBundle\Entity\Tcerj;

/**
 * TipoAlteracao
 */
class TipoAlteracao
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
    private $codTipo;

    /**
     * PK
     * @var string
     */
    private $tipo;

    /**
     * @var integer
     */
    private $codTipoAlteracao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\TipoTransferencia
     */
    private $fkContabilidadeTipoTransferencia;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return TipoAlteracao
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
     * @return TipoAlteracao
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
     * Set tipo
     *
     * @param string $tipo
     * @return TipoAlteracao
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set codTipoAlteracao
     *
     * @param integer $codTipoAlteracao
     * @return TipoAlteracao
     */
    public function setCodTipoAlteracao($codTipoAlteracao)
    {
        $this->codTipoAlteracao = $codTipoAlteracao;
        return $this;
    }

    /**
     * Get codTipoAlteracao
     *
     * @return integer
     */
    public function getCodTipoAlteracao()
    {
        return $this->codTipoAlteracao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadeTipoTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\TipoTransferencia $fkContabilidadeTipoTransferencia
     * @return TipoAlteracao
     */
    public function setFkContabilidadeTipoTransferencia(\Urbem\CoreBundle\Entity\Contabilidade\TipoTransferencia $fkContabilidadeTipoTransferencia)
    {
        $this->codTipo = $fkContabilidadeTipoTransferencia->getCodTipo();
        $this->exercicio = $fkContabilidadeTipoTransferencia->getExercicio();
        $this->fkContabilidadeTipoTransferencia = $fkContabilidadeTipoTransferencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadeTipoTransferencia
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\TipoTransferencia
     */
    public function getFkContabilidadeTipoTransferencia()
    {
        return $this->fkContabilidadeTipoTransferencia;
    }
}
