<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwPlanoConta
 */
class SwPlanoConta
{
    /**
     * PK
     * @var integer
     */
    private $codNivel1;

    /**
     * PK
     * @var integer
     */
    private $codNivel2;

    /**
     * PK
     * @var integer
     */
    private $codNivel3;

    /**
     * PK
     * @var integer
     */
    private $codNivel4;

    /**
     * PK
     * @var integer
     */
    private $codNivel5;

    /**
     * PK
     * @var integer
     */
    private $codNivel6;

    /**
     * PK
     * @var integer
     */
    private $codNivel7;

    /**
     * PK
     * @var integer
     */
    private $codNivel8;

    /**
     * PK
     * @var integer
     */
    private $codNivel9;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $nomConta;

    /**
     * @var string
     */
    private $tipo;

    /**
     * @var integer
     */
    private $codClassificacao;

    /**
     * @var integer
     */
    private $codSistema;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwGrupoPlano
     */
    private $fkSwGrupoPlanos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwClassificacaoContabil
     */
    private $fkSwClassificacaoContabil;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwSistemaContabil
     */
    private $fkSwSistemaContabil;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkSwGrupoPlanos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codNivel1
     *
     * @param integer $codNivel1
     * @return SwPlanoConta
     */
    public function setCodNivel1($codNivel1)
    {
        $this->codNivel1 = $codNivel1;
        return $this;
    }

    /**
     * Get codNivel1
     *
     * @return integer
     */
    public function getCodNivel1()
    {
        return $this->codNivel1;
    }

    /**
     * Set codNivel2
     *
     * @param integer $codNivel2
     * @return SwPlanoConta
     */
    public function setCodNivel2($codNivel2)
    {
        $this->codNivel2 = $codNivel2;
        return $this;
    }

    /**
     * Get codNivel2
     *
     * @return integer
     */
    public function getCodNivel2()
    {
        return $this->codNivel2;
    }

    /**
     * Set codNivel3
     *
     * @param integer $codNivel3
     * @return SwPlanoConta
     */
    public function setCodNivel3($codNivel3)
    {
        $this->codNivel3 = $codNivel3;
        return $this;
    }

    /**
     * Get codNivel3
     *
     * @return integer
     */
    public function getCodNivel3()
    {
        return $this->codNivel3;
    }

    /**
     * Set codNivel4
     *
     * @param integer $codNivel4
     * @return SwPlanoConta
     */
    public function setCodNivel4($codNivel4)
    {
        $this->codNivel4 = $codNivel4;
        return $this;
    }

    /**
     * Get codNivel4
     *
     * @return integer
     */
    public function getCodNivel4()
    {
        return $this->codNivel4;
    }

    /**
     * Set codNivel5
     *
     * @param integer $codNivel5
     * @return SwPlanoConta
     */
    public function setCodNivel5($codNivel5)
    {
        $this->codNivel5 = $codNivel5;
        return $this;
    }

    /**
     * Get codNivel5
     *
     * @return integer
     */
    public function getCodNivel5()
    {
        return $this->codNivel5;
    }

    /**
     * Set codNivel6
     *
     * @param integer $codNivel6
     * @return SwPlanoConta
     */
    public function setCodNivel6($codNivel6)
    {
        $this->codNivel6 = $codNivel6;
        return $this;
    }

    /**
     * Get codNivel6
     *
     * @return integer
     */
    public function getCodNivel6()
    {
        return $this->codNivel6;
    }

    /**
     * Set codNivel7
     *
     * @param integer $codNivel7
     * @return SwPlanoConta
     */
    public function setCodNivel7($codNivel7)
    {
        $this->codNivel7 = $codNivel7;
        return $this;
    }

    /**
     * Get codNivel7
     *
     * @return integer
     */
    public function getCodNivel7()
    {
        return $this->codNivel7;
    }

    /**
     * Set codNivel8
     *
     * @param integer $codNivel8
     * @return SwPlanoConta
     */
    public function setCodNivel8($codNivel8)
    {
        $this->codNivel8 = $codNivel8;
        return $this;
    }

    /**
     * Get codNivel8
     *
     * @return integer
     */
    public function getCodNivel8()
    {
        return $this->codNivel8;
    }

    /**
     * Set codNivel9
     *
     * @param integer $codNivel9
     * @return SwPlanoConta
     */
    public function setCodNivel9($codNivel9)
    {
        $this->codNivel9 = $codNivel9;
        return $this;
    }

    /**
     * Get codNivel9
     *
     * @return integer
     */
    public function getCodNivel9()
    {
        return $this->codNivel9;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return SwPlanoConta
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
     * Set nomConta
     *
     * @param string $nomConta
     * @return SwPlanoConta
     */
    public function setNomConta($nomConta)
    {
        $this->nomConta = $nomConta;
        return $this;
    }

    /**
     * Get nomConta
     *
     * @return string
     */
    public function getNomConta()
    {
        return $this->nomConta;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return SwPlanoConta
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
     * Set codClassificacao
     *
     * @param integer $codClassificacao
     * @return SwPlanoConta
     */
    public function setCodClassificacao($codClassificacao)
    {
        $this->codClassificacao = $codClassificacao;
        return $this;
    }

    /**
     * Get codClassificacao
     *
     * @return integer
     */
    public function getCodClassificacao()
    {
        return $this->codClassificacao;
    }

    /**
     * Set codSistema
     *
     * @param integer $codSistema
     * @return SwPlanoConta
     */
    public function setCodSistema($codSistema)
    {
        $this->codSistema = $codSistema;
        return $this;
    }

    /**
     * Get codSistema
     *
     * @return integer
     */
    public function getCodSistema()
    {
        return $this->codSistema;
    }

    /**
     * OneToMany (owning side)
     * Add SwGrupoPlano
     *
     * @param \Urbem\CoreBundle\Entity\SwGrupoPlano $fkSwGrupoPlano
     * @return SwPlanoConta
     */
    public function addFkSwGrupoPlanos(\Urbem\CoreBundle\Entity\SwGrupoPlano $fkSwGrupoPlano)
    {
        if (false === $this->fkSwGrupoPlanos->contains($fkSwGrupoPlano)) {
            $fkSwGrupoPlano->setFkSwPlanoConta($this);
            $this->fkSwGrupoPlanos->add($fkSwGrupoPlano);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwGrupoPlano
     *
     * @param \Urbem\CoreBundle\Entity\SwGrupoPlano $fkSwGrupoPlano
     */
    public function removeFkSwGrupoPlanos(\Urbem\CoreBundle\Entity\SwGrupoPlano $fkSwGrupoPlano)
    {
        $this->fkSwGrupoPlanos->removeElement($fkSwGrupoPlano);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwGrupoPlanos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwGrupoPlano
     */
    public function getFkSwGrupoPlanos()
    {
        return $this->fkSwGrupoPlanos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwClassificacaoContabil
     *
     * @param \Urbem\CoreBundle\Entity\SwClassificacaoContabil $fkSwClassificacaoContabil
     * @return SwPlanoConta
     */
    public function setFkSwClassificacaoContabil(\Urbem\CoreBundle\Entity\SwClassificacaoContabil $fkSwClassificacaoContabil)
    {
        $this->codClassificacao = $fkSwClassificacaoContabil->getCodClassificacao();
        $this->exercicio = $fkSwClassificacaoContabil->getExercicio();
        $this->fkSwClassificacaoContabil = $fkSwClassificacaoContabil;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwClassificacaoContabil
     *
     * @return \Urbem\CoreBundle\Entity\SwClassificacaoContabil
     */
    public function getFkSwClassificacaoContabil()
    {
        return $this->fkSwClassificacaoContabil;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwSistemaContabil
     *
     * @param \Urbem\CoreBundle\Entity\SwSistemaContabil $fkSwSistemaContabil
     * @return SwPlanoConta
     */
    public function setFkSwSistemaContabil(\Urbem\CoreBundle\Entity\SwSistemaContabil $fkSwSistemaContabil)
    {
        $this->codSistema = $fkSwSistemaContabil->getCodSistema();
        $this->exercicio = $fkSwSistemaContabil->getExercicio();
        $this->fkSwSistemaContabil = $fkSwSistemaContabil;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwSistemaContabil
     *
     * @return \Urbem\CoreBundle\Entity\SwSistemaContabil
     */
    public function getFkSwSistemaContabil()
    {
        return $this->fkSwSistemaContabil;
    }
}
