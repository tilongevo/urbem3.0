<?php
 
namespace Urbem\CoreBundle\Entity\Tcern;

/**
 * Contrato
 */
class Contrato
{
    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $numContrato;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var string
     */
    private $exercicioContrato;

    /**
     * PK
     * @var integer
     */
    private $numConvenio;

    /**
     * @var integer
     */
    private $codProcesso;

    /**
     * @var string
     */
    private $exercicioProcesso;

    /**
     * @var integer
     */
    private $bimestre;

    /**
     * @var string
     */
    private $codContaEspecifica;

    /**
     * @var \DateTime
     */
    private $dtEntregaRecurso;

    /**
     * @var integer
     */
    private $valorRepasse;

    /**
     * @var integer
     */
    private $valorExecutado;

    /**
     * @var integer
     */
    private $receitaAplicacaoFinanceira;

    /**
     * @var \DateTime
     */
    private $dtRecebimentoSaldo;

    /**
     * @var \DateTime
     */
    private $dtPrestacaoContas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcern\Convenio
     */
    private $fkTcernConvenio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwProcesso
     */
    private $fkSwProcesso;


    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return Contrato
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
     * Set numContrato
     *
     * @param integer $numContrato
     * @return Contrato
     */
    public function setNumContrato($numContrato)
    {
        $this->numContrato = $numContrato;
        return $this;
    }

    /**
     * Get numContrato
     *
     * @return integer
     */
    public function getNumContrato()
    {
        return $this->numContrato;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Contrato
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
     * Set exercicioContrato
     *
     * @param string $exercicioContrato
     * @return Contrato
     */
    public function setExercicioContrato($exercicioContrato)
    {
        $this->exercicioContrato = $exercicioContrato;
        return $this;
    }

    /**
     * Get exercicioContrato
     *
     * @return string
     */
    public function getExercicioContrato()
    {
        return $this->exercicioContrato;
    }

    /**
     * Set numConvenio
     *
     * @param integer $numConvenio
     * @return Contrato
     */
    public function setNumConvenio($numConvenio)
    {
        $this->numConvenio = $numConvenio;
        return $this;
    }

    /**
     * Get numConvenio
     *
     * @return integer
     */
    public function getNumConvenio()
    {
        return $this->numConvenio;
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return Contrato
     */
    public function setCodProcesso($codProcesso)
    {
        $this->codProcesso = $codProcesso;
        return $this;
    }

    /**
     * Get codProcesso
     *
     * @return integer
     */
    public function getCodProcesso()
    {
        return $this->codProcesso;
    }

    /**
     * Set exercicioProcesso
     *
     * @param string $exercicioProcesso
     * @return Contrato
     */
    public function setExercicioProcesso($exercicioProcesso)
    {
        $this->exercicioProcesso = $exercicioProcesso;
        return $this;
    }

    /**
     * Get exercicioProcesso
     *
     * @return string
     */
    public function getExercicioProcesso()
    {
        return $this->exercicioProcesso;
    }

    /**
     * Set bimestre
     *
     * @param integer $bimestre
     * @return Contrato
     */
    public function setBimestre($bimestre)
    {
        $this->bimestre = $bimestre;
        return $this;
    }

    /**
     * Get bimestre
     *
     * @return integer
     */
    public function getBimestre()
    {
        return $this->bimestre;
    }

    /**
     * Set codContaEspecifica
     *
     * @param string $codContaEspecifica
     * @return Contrato
     */
    public function setCodContaEspecifica($codContaEspecifica)
    {
        $this->codContaEspecifica = $codContaEspecifica;
        return $this;
    }

    /**
     * Get codContaEspecifica
     *
     * @return string
     */
    public function getCodContaEspecifica()
    {
        return $this->codContaEspecifica;
    }

    /**
     * Set dtEntregaRecurso
     *
     * @param \DateTime $dtEntregaRecurso
     * @return Contrato
     */
    public function setDtEntregaRecurso(\DateTime $dtEntregaRecurso)
    {
        $this->dtEntregaRecurso = $dtEntregaRecurso;
        return $this;
    }

    /**
     * Get dtEntregaRecurso
     *
     * @return \DateTime
     */
    public function getDtEntregaRecurso()
    {
        return $this->dtEntregaRecurso;
    }

    /**
     * Set valorRepasse
     *
     * @param integer $valorRepasse
     * @return Contrato
     */
    public function setValorRepasse($valorRepasse)
    {
        $this->valorRepasse = $valorRepasse;
        return $this;
    }

    /**
     * Get valorRepasse
     *
     * @return integer
     */
    public function getValorRepasse()
    {
        return $this->valorRepasse;
    }

    /**
     * Set valorExecutado
     *
     * @param integer $valorExecutado
     * @return Contrato
     */
    public function setValorExecutado($valorExecutado)
    {
        $this->valorExecutado = $valorExecutado;
        return $this;
    }

    /**
     * Get valorExecutado
     *
     * @return integer
     */
    public function getValorExecutado()
    {
        return $this->valorExecutado;
    }

    /**
     * Set receitaAplicacaoFinanceira
     *
     * @param integer $receitaAplicacaoFinanceira
     * @return Contrato
     */
    public function setReceitaAplicacaoFinanceira($receitaAplicacaoFinanceira)
    {
        $this->receitaAplicacaoFinanceira = $receitaAplicacaoFinanceira;
        return $this;
    }

    /**
     * Get receitaAplicacaoFinanceira
     *
     * @return integer
     */
    public function getReceitaAplicacaoFinanceira()
    {
        return $this->receitaAplicacaoFinanceira;
    }

    /**
     * Set dtRecebimentoSaldo
     *
     * @param \DateTime $dtRecebimentoSaldo
     * @return Contrato
     */
    public function setDtRecebimentoSaldo(\DateTime $dtRecebimentoSaldo)
    {
        $this->dtRecebimentoSaldo = $dtRecebimentoSaldo;
        return $this;
    }

    /**
     * Get dtRecebimentoSaldo
     *
     * @return \DateTime
     */
    public function getDtRecebimentoSaldo()
    {
        return $this->dtRecebimentoSaldo;
    }

    /**
     * Set dtPrestacaoContas
     *
     * @param \DateTime $dtPrestacaoContas
     * @return Contrato
     */
    public function setDtPrestacaoContas(\DateTime $dtPrestacaoContas)
    {
        $this->dtPrestacaoContas = $dtPrestacaoContas;
        return $this;
    }

    /**
     * Get dtPrestacaoContas
     *
     * @return \DateTime
     */
    public function getDtPrestacaoContas()
    {
        return $this->dtPrestacaoContas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcernConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\Convenio $fkTcernConvenio
     * @return Contrato
     */
    public function setFkTcernConvenio(\Urbem\CoreBundle\Entity\Tcern\Convenio $fkTcernConvenio)
    {
        $this->codEntidade = $fkTcernConvenio->getCodEntidade();
        $this->exercicio = $fkTcernConvenio->getExercicio();
        $this->numConvenio = $fkTcernConvenio->getNumConvenio();
        $this->fkTcernConvenio = $fkTcernConvenio;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcernConvenio
     *
     * @return \Urbem\CoreBundle\Entity\Tcern\Convenio
     */
    public function getFkTcernConvenio()
    {
        return $this->fkTcernConvenio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     * @return Contrato
     */
    public function setFkSwProcesso(\Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso)
    {
        $this->codProcesso = $fkSwProcesso->getCodProcesso();
        $this->exercicioProcesso = $fkSwProcesso->getAnoExercicio();
        $this->fkSwProcesso = $fkSwProcesso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwProcesso
     *
     * @return \Urbem\CoreBundle\Entity\SwProcesso
     */
    public function getFkSwProcesso()
    {
        return $this->fkSwProcesso;
    }
}
