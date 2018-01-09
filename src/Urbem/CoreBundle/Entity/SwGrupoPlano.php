<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwGrupoPlano
 */
class SwGrupoPlano
{
    /**
     * PK
     * @var integer
     */
    private $codGrupo;

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
     * @var integer
     */
    private $codPlano;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwPlanoConta
     */
    private $fkSwPlanoConta;


    /**
     * Set codGrupo
     *
     * @param integer $codGrupo
     * @return SwGrupoPlano
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
     * Set codNivel1
     *
     * @param integer $codNivel1
     * @return SwGrupoPlano
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
     * @return SwGrupoPlano
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
     * @return SwGrupoPlano
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
     * @return SwGrupoPlano
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
     * @return SwGrupoPlano
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
     * @return SwGrupoPlano
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
     * @return SwGrupoPlano
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
     * @return SwGrupoPlano
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
     * @return SwGrupoPlano
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
     * @return SwGrupoPlano
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
     * @return SwGrupoPlano
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
     * Set fkSwPlanoConta
     *
     * @param \Urbem\CoreBundle\Entity\SwPlanoConta $fkSwPlanoConta
     * @return SwGrupoPlano
     */
    public function setFkSwPlanoConta(\Urbem\CoreBundle\Entity\SwPlanoConta $fkSwPlanoConta)
    {
        $this->codNivel1 = $fkSwPlanoConta->getCodNivel1();
        $this->codNivel2 = $fkSwPlanoConta->getCodNivel2();
        $this->codNivel3 = $fkSwPlanoConta->getCodNivel3();
        $this->codNivel4 = $fkSwPlanoConta->getCodNivel4();
        $this->codNivel5 = $fkSwPlanoConta->getCodNivel5();
        $this->codNivel6 = $fkSwPlanoConta->getCodNivel6();
        $this->codNivel7 = $fkSwPlanoConta->getCodNivel7();
        $this->codNivel8 = $fkSwPlanoConta->getCodNivel8();
        $this->codNivel9 = $fkSwPlanoConta->getCodNivel9();
        $this->exercicio = $fkSwPlanoConta->getExercicio();
        $this->fkSwPlanoConta = $fkSwPlanoConta;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwPlanoConta
     *
     * @return \Urbem\CoreBundle\Entity\SwPlanoConta
     */
    public function getFkSwPlanoConta()
    {
        return $this->fkSwPlanoConta;
    }
}
