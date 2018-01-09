<?php
 
namespace Urbem\CoreBundle\Entity\Patrimonio;

/**
 * GrupoPlanoAnalitica
 */
class GrupoPlanoAnalitica
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
     * @var integer
     */
    private $codPlanoDoacao;

    /**
     * @var integer
     */
    private $codPlanoPerdaInvoluntaria;

    /**
     * @var integer
     */
    private $codPlanoTransferencia;

    /**
     * @var integer
     */
    private $codPlanoAlienacaoGanho;

    /**
     * @var integer
     */
    private $codPlanoAlienacaoPerda;

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
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    private $fkContabilidadePlanoAnalitica1;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    private $fkContabilidadePlanoAnalitica2;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    private $fkContabilidadePlanoAnalitica3;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    private $fkContabilidadePlanoAnalitica4;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    private $fkContabilidadePlanoAnalitica5;


    /**
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return GrupoPlanoAnalitica
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
     * @return GrupoPlanoAnalitica
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
     * @return GrupoPlanoAnalitica
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
     * @return GrupoPlanoAnalitica
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
     * Set codPlanoDoacao
     *
     * @param integer $codPlanoDoacao
     * @return GrupoPlanoAnalitica
     */
    public function setCodPlanoDoacao($codPlanoDoacao = null)
    {
        $this->codPlanoDoacao = $codPlanoDoacao;
        return $this;
    }

    /**
     * Get codPlanoDoacao
     *
     * @return integer
     */
    public function getCodPlanoDoacao()
    {
        return $this->codPlanoDoacao;
    }

    /**
     * Set codPlanoPerdaInvoluntaria
     *
     * @param integer $codPlanoPerdaInvoluntaria
     * @return GrupoPlanoAnalitica
     */
    public function setCodPlanoPerdaInvoluntaria($codPlanoPerdaInvoluntaria = null)
    {
        $this->codPlanoPerdaInvoluntaria = $codPlanoPerdaInvoluntaria;
        return $this;
    }

    /**
     * Get codPlanoPerdaInvoluntaria
     *
     * @return integer
     */
    public function getCodPlanoPerdaInvoluntaria()
    {
        return $this->codPlanoPerdaInvoluntaria;
    }

    /**
     * Set codPlanoTransferencia
     *
     * @param integer $codPlanoTransferencia
     * @return GrupoPlanoAnalitica
     */
    public function setCodPlanoTransferencia($codPlanoTransferencia = null)
    {
        $this->codPlanoTransferencia = $codPlanoTransferencia;
        return $this;
    }

    /**
     * Get codPlanoTransferencia
     *
     * @return integer
     */
    public function getCodPlanoTransferencia()
    {
        return $this->codPlanoTransferencia;
    }

    /**
     * Set codPlanoAlienacaoGanho
     *
     * @param integer $codPlanoAlienacaoGanho
     * @return GrupoPlanoAnalitica
     */
    public function setCodPlanoAlienacaoGanho($codPlanoAlienacaoGanho = null)
    {
        $this->codPlanoAlienacaoGanho = $codPlanoAlienacaoGanho;
        return $this;
    }

    /**
     * Get codPlanoAlienacaoGanho
     *
     * @return integer
     */
    public function getCodPlanoAlienacaoGanho()
    {
        return $this->codPlanoAlienacaoGanho;
    }

    /**
     * Set codPlanoAlienacaoPerda
     *
     * @param integer $codPlanoAlienacaoPerda
     * @return GrupoPlanoAnalitica
     */
    public function setCodPlanoAlienacaoPerda($codPlanoAlienacaoPerda = null)
    {
        $this->codPlanoAlienacaoPerda = $codPlanoAlienacaoPerda;
        return $this;
    }

    /**
     * Get codPlanoAlienacaoPerda
     *
     * @return integer
     */
    public function getCodPlanoAlienacaoPerda()
    {
        return $this->codPlanoAlienacaoPerda;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPatrimonioGrupo
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Grupo $fkPatrimonioGrupo
     * @return GrupoPlanoAnalitica
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
     * @return GrupoPlanoAnalitica
     */
    public function setFkContabilidadePlanoAnalitica(\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica)
    {
        $this->codPlanoAlienacaoGanho = $fkContabilidadePlanoAnalitica->getCodPlano();
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
     * @return GrupoPlanoAnalitica
     */
    public function setFkContabilidadePlanoAnalitica1(\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica1)
    {
        $this->codPlano = $fkContabilidadePlanoAnalitica1->getCodPlano();
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
     * ManyToOne (inverse side)
     * Set fkContabilidadePlanoAnalitica2
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica2
     * @return GrupoPlanoAnalitica
     */
    public function setFkContabilidadePlanoAnalitica2(\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica2)
    {
        $this->codPlanoDoacao = $fkContabilidadePlanoAnalitica2->getCodPlano();
        $this->exercicio = $fkContabilidadePlanoAnalitica2->getExercicio();
        $this->fkContabilidadePlanoAnalitica2 = $fkContabilidadePlanoAnalitica2;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadePlanoAnalitica2
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    public function getFkContabilidadePlanoAnalitica2()
    {
        return $this->fkContabilidadePlanoAnalitica2;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadePlanoAnalitica3
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica3
     * @return GrupoPlanoAnalitica
     */
    public function setFkContabilidadePlanoAnalitica3(\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica3)
    {
        $this->codPlanoPerdaInvoluntaria = $fkContabilidadePlanoAnalitica3->getCodPlano();
        $this->exercicio = $fkContabilidadePlanoAnalitica3->getExercicio();
        $this->fkContabilidadePlanoAnalitica3 = $fkContabilidadePlanoAnalitica3;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadePlanoAnalitica3
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    public function getFkContabilidadePlanoAnalitica3()
    {
        return $this->fkContabilidadePlanoAnalitica3;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadePlanoAnalitica4
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica4
     * @return GrupoPlanoAnalitica
     */
    public function setFkContabilidadePlanoAnalitica4(\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica4)
    {
        $this->codPlanoTransferencia = $fkContabilidadePlanoAnalitica4->getCodPlano();
        $this->exercicio = $fkContabilidadePlanoAnalitica4->getExercicio();
        $this->fkContabilidadePlanoAnalitica4 = $fkContabilidadePlanoAnalitica4;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadePlanoAnalitica4
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    public function getFkContabilidadePlanoAnalitica4()
    {
        return $this->fkContabilidadePlanoAnalitica4;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadePlanoAnalitica5
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica5
     * @return GrupoPlanoAnalitica
     */
    public function setFkContabilidadePlanoAnalitica5(\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica5)
    {
        $this->codPlanoAlienacaoPerda = $fkContabilidadePlanoAnalitica5->getCodPlano();
        $this->exercicio = $fkContabilidadePlanoAnalitica5->getExercicio();
        $this->fkContabilidadePlanoAnalitica5 = $fkContabilidadePlanoAnalitica5;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadePlanoAnalitica5
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    public function getFkContabilidadePlanoAnalitica5()
    {
        return $this->fkContabilidadePlanoAnalitica5;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getFkContabilidadePlanoAnalitica()->getFkContabilidadePlanoConta()->getNomConta();
    }
}
