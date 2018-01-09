<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * ExecucaoVariacao
 */
class ExecucaoVariacao
{
    /**
     * PK
     * @var integer
     */
    private $codMes;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $consAdmDir;

    /**
     * @var string
     */
    private $consAut;

    /**
     * @var string
     */
    private $consFund;

    /**
     * @var string
     */
    private $consEmpeEstDep;

    /**
     * @var string
     */
    private $consDemEnt;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Mes
     */
    private $fkAdministracaoMes;


    /**
     * Set codMes
     *
     * @param integer $codMes
     * @return ExecucaoVariacao
     */
    public function setCodMes($codMes)
    {
        $this->codMes = $codMes;
        return $this;
    }

    /**
     * Get codMes
     *
     * @return integer
     */
    public function getCodMes()
    {
        return $this->codMes;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ExecucaoVariacao
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
     * Set consAdmDir
     *
     * @param string $consAdmDir
     * @return ExecucaoVariacao
     */
    public function setConsAdmDir($consAdmDir)
    {
        $this->consAdmDir = $consAdmDir;
        return $this;
    }

    /**
     * Get consAdmDir
     *
     * @return string
     */
    public function getConsAdmDir()
    {
        return $this->consAdmDir;
    }

    /**
     * Set consAut
     *
     * @param string $consAut
     * @return ExecucaoVariacao
     */
    public function setConsAut($consAut)
    {
        $this->consAut = $consAut;
        return $this;
    }

    /**
     * Get consAut
     *
     * @return string
     */
    public function getConsAut()
    {
        return $this->consAut;
    }

    /**
     * Set consFund
     *
     * @param string $consFund
     * @return ExecucaoVariacao
     */
    public function setConsFund($consFund)
    {
        $this->consFund = $consFund;
        return $this;
    }

    /**
     * Get consFund
     *
     * @return string
     */
    public function getConsFund()
    {
        return $this->consFund;
    }

    /**
     * Set consEmpeEstDep
     *
     * @param string $consEmpeEstDep
     * @return ExecucaoVariacao
     */
    public function setConsEmpeEstDep($consEmpeEstDep)
    {
        $this->consEmpeEstDep = $consEmpeEstDep;
        return $this;
    }

    /**
     * Get consEmpeEstDep
     *
     * @return string
     */
    public function getConsEmpeEstDep()
    {
        return $this->consEmpeEstDep;
    }

    /**
     * Set consDemEnt
     *
     * @param string $consDemEnt
     * @return ExecucaoVariacao
     */
    public function setConsDemEnt($consDemEnt)
    {
        $this->consDemEnt = $consDemEnt;
        return $this;
    }

    /**
     * Get consDemEnt
     *
     * @return string
     */
    public function getConsDemEnt()
    {
        return $this->consDemEnt;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoMes
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Mes $fkAdministracaoMes
     * @return ExecucaoVariacao
     */
    public function setFkAdministracaoMes(\Urbem\CoreBundle\Entity\Administracao\Mes $fkAdministracaoMes)
    {
        $this->codMes = $fkAdministracaoMes->getCodMes();
        $this->fkAdministracaoMes = $fkAdministracaoMes;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoMes
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Mes
     */
    public function getFkAdministracaoMes()
    {
        return $this->fkAdministracaoMes;
    }
}
