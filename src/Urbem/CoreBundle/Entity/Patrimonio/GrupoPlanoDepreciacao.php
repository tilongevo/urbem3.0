<?php
 
namespace Urbem\CoreBundle\Entity\Patrimonio;

/**
 * GrupoPlanoDepreciacao
 */
class GrupoPlanoDepreciacao
{
    /**
     * PK
     * @var integer
     */
    private $codNatureza;

    /**
     * PK
     * @var integer
     */
    private $codGrupo;

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
     * @var \Urbem\CoreBundle\Entity\Patrimonio\Grupo
     */
    private $fkPatrimonioGrupo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    private $fkContabilidadePlanoAnalitica;


    /**
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return GrupoPlanoDepreciacao
     */
    public function setCodNatureza($codNatureza)
    {
        $this->codNatureza = $codNatureza;
        return $this;
    }

    /**
     * Get codNatureza
     *
     * @return integer
     */
    public function getCodNatureza()
    {
        return $this->codNatureza;
    }

    /**
     * Set codGrupo
     *
     * @param integer $codGrupo
     * @return GrupoPlanoDepreciacao
     */
    public function setCodGrupo($codGrupo)
    {
        $this->codGrupo = $codGrupo;
        return $this;
    }

    /**
     * Get codGrupo
     *
     * @return integer
     */
    public function getCodGrupo()
    {
        return $this->codGrupo;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return GrupoPlanoDepreciacao
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
     * @return GrupoPlanoDepreciacao
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
     * Set fkPatrimonioGrupo
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Grupo $fkPatrimonioGrupo
     * @return GrupoPlanoDepreciacao
     */
    public function setFkPatrimonioGrupo(\Urbem\CoreBundle\Entity\Patrimonio\Grupo $fkPatrimonioGrupo)
    {
        $this->codGrupo = $fkPatrimonioGrupo->getCodGrupo();
        $this->codNatureza = $fkPatrimonioGrupo->getCodNatureza();
        $this->fkPatrimonioGrupo = $fkPatrimonioGrupo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPatrimonioGrupo
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\Grupo
     */
    public function getFkPatrimonioGrupo()
    {
        return $this->fkPatrimonioGrupo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadePlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica
     * @return GrupoPlanoDepreciacao
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
