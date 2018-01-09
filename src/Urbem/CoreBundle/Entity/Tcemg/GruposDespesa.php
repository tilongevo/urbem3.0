<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * GruposDespesa
 */
class GruposDespesa
{
    /**
     * PK
     * @var integer
     */
    private $codGrupo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\CronogramaExecucaoMensalDesembolso
     */
    private $fkTcemgCronogramaExecucaoMensalDesembolsos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcemgCronogramaExecucaoMensalDesembolsos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codGrupo
     *
     * @param integer $codGrupo
     * @return GruposDespesa
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
     * Set descricao
     *
     * @param string $descricao
     * @return GruposDespesa
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
     * Add TcemgCronogramaExecucaoMensalDesembolso
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\CronogramaExecucaoMensalDesembolso $fkTcemgCronogramaExecucaoMensalDesembolso
     * @return GruposDespesa
     */
    public function addFkTcemgCronogramaExecucaoMensalDesembolsos(\Urbem\CoreBundle\Entity\Tcemg\CronogramaExecucaoMensalDesembolso $fkTcemgCronogramaExecucaoMensalDesembolso)
    {
        if (false === $this->fkTcemgCronogramaExecucaoMensalDesembolsos->contains($fkTcemgCronogramaExecucaoMensalDesembolso)) {
            $fkTcemgCronogramaExecucaoMensalDesembolso->setFkTcemgGruposDespesa($this);
            $this->fkTcemgCronogramaExecucaoMensalDesembolsos->add($fkTcemgCronogramaExecucaoMensalDesembolso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgCronogramaExecucaoMensalDesembolso
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\CronogramaExecucaoMensalDesembolso $fkTcemgCronogramaExecucaoMensalDesembolso
     */
    public function removeFkTcemgCronogramaExecucaoMensalDesembolsos(\Urbem\CoreBundle\Entity\Tcemg\CronogramaExecucaoMensalDesembolso $fkTcemgCronogramaExecucaoMensalDesembolso)
    {
        $this->fkTcemgCronogramaExecucaoMensalDesembolsos->removeElement($fkTcemgCronogramaExecucaoMensalDesembolso);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgCronogramaExecucaoMensalDesembolsos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\CronogramaExecucaoMensalDesembolso
     */
    public function getFkTcemgCronogramaExecucaoMensalDesembolsos()
    {
        return $this->fkTcemgCronogramaExecucaoMensalDesembolsos;
    }
}
