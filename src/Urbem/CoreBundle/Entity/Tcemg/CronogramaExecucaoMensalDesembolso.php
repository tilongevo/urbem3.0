<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * CronogramaExecucaoMensalDesembolso
 */
class CronogramaExecucaoMensalDesembolso
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
    private $periodo;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $numUnidade;

    /**
     * PK
     * @var integer
     */
    private $numOrgao;

    /**
     * @var integer
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcemg\GruposDespesa
     */
    private $fkTcemgGruposDespesa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcemg\Uniorcam
     */
    private $fkTcemgUniorcam;


    /**
     * Set codGrupo
     *
     * @param integer $codGrupo
     * @return CronogramaExecucaoMensalDesembolso
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
     * Set periodo
     *
     * @param integer $periodo
     * @return CronogramaExecucaoMensalDesembolso
     */
    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;
        return $this;
    }

    /**
     * Get periodo
     *
     * @return integer
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return CronogramaExecucaoMensalDesembolso
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return CronogramaExecucaoMensalDesembolso
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
     * Set numUnidade
     *
     * @param integer $numUnidade
     * @return CronogramaExecucaoMensalDesembolso
     */
    public function setNumUnidade($numUnidade)
    {
        $this->numUnidade = $numUnidade;
        return $this;
    }

    /**
     * Get numUnidade
     *
     * @return integer
     */
    public function getNumUnidade()
    {
        return $this->numUnidade;
    }

    /**
     * Set numOrgao
     *
     * @param integer $numOrgao
     * @return CronogramaExecucaoMensalDesembolso
     */
    public function setNumOrgao($numOrgao)
    {
        $this->numOrgao = $numOrgao;
        return $this;
    }

    /**
     * Get numOrgao
     *
     * @return integer
     */
    public function getNumOrgao()
    {
        return $this->numOrgao;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return CronogramaExecucaoMensalDesembolso
     */
    public function setValor($valor = null)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcemgGruposDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\GruposDespesa $fkTcemgGruposDespesa
     * @return CronogramaExecucaoMensalDesembolso
     */
    public function setFkTcemgGruposDespesa(\Urbem\CoreBundle\Entity\Tcemg\GruposDespesa $fkTcemgGruposDespesa)
    {
        $this->codGrupo = $fkTcemgGruposDespesa->getCodGrupo();
        $this->fkTcemgGruposDespesa = $fkTcemgGruposDespesa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgGruposDespesa
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\GruposDespesa
     */
    public function getFkTcemgGruposDespesa()
    {
        return $this->fkTcemgGruposDespesa;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcemgUniorcam
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Uniorcam $fkTcemgUniorcam
     * @return CronogramaExecucaoMensalDesembolso
     */
    public function setFkTcemgUniorcam(\Urbem\CoreBundle\Entity\Tcemg\Uniorcam $fkTcemgUniorcam)
    {
        $this->exercicio = $fkTcemgUniorcam->getExercicio();
        $this->numUnidade = $fkTcemgUniorcam->getNumUnidade();
        $this->numOrgao = $fkTcemgUniorcam->getNumOrgao();
        $this->fkTcemgUniorcam = $fkTcemgUniorcam;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgUniorcam
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\Uniorcam
     */
    public function getFkTcemgUniorcam()
    {
        return $this->fkTcemgUniorcam;
    }
}
