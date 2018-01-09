<?php
 
namespace Urbem\CoreBundle\Entity\Tceal;

/**
 * OcorrenciaFuncional
 */
class OcorrenciaFuncional
{
    /**
     * PK
     * @var integer
     */
    private $codOcorrencia;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceal\OcorrenciaFuncionalAssentamento
     */
    private $fkTcealOcorrenciaFuncionalAssentamentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcealOcorrenciaFuncionalAssentamentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codOcorrencia
     *
     * @param integer $codOcorrencia
     * @return OcorrenciaFuncional
     */
    public function setCodOcorrencia($codOcorrencia)
    {
        $this->codOcorrencia = $codOcorrencia;
        return $this;
    }

    /**
     * Get codOcorrencia
     *
     * @return integer
     */
    public function getCodOcorrencia()
    {
        return $this->codOcorrencia;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return OcorrenciaFuncional
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
     * Set descricao
     *
     * @param string $descricao
     * @return OcorrenciaFuncional
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * OneToMany (owning side)
     * Add TcealOcorrenciaFuncionalAssentamento
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\OcorrenciaFuncionalAssentamento $fkTcealOcorrenciaFuncionalAssentamento
     * @return OcorrenciaFuncional
     */
    public function addFkTcealOcorrenciaFuncionalAssentamentos(\Urbem\CoreBundle\Entity\Tceal\OcorrenciaFuncionalAssentamento $fkTcealOcorrenciaFuncionalAssentamento)
    {
        if (false === $this->fkTcealOcorrenciaFuncionalAssentamentos->contains($fkTcealOcorrenciaFuncionalAssentamento)) {
            $fkTcealOcorrenciaFuncionalAssentamento->setFkTcealOcorrenciaFuncional($this);
            $this->fkTcealOcorrenciaFuncionalAssentamentos->add($fkTcealOcorrenciaFuncionalAssentamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcealOcorrenciaFuncionalAssentamento
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\OcorrenciaFuncionalAssentamento $fkTcealOcorrenciaFuncionalAssentamento
     */
    public function removeFkTcealOcorrenciaFuncionalAssentamentos(\Urbem\CoreBundle\Entity\Tceal\OcorrenciaFuncionalAssentamento $fkTcealOcorrenciaFuncionalAssentamento)
    {
        $this->fkTcealOcorrenciaFuncionalAssentamentos->removeElement($fkTcealOcorrenciaFuncionalAssentamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcealOcorrenciaFuncionalAssentamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceal\OcorrenciaFuncionalAssentamento
     */
    public function getFkTcealOcorrenciaFuncionalAssentamentos()
    {
        return $this->fkTcealOcorrenciaFuncionalAssentamentos;
    }
}
