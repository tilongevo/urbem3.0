<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * ContratoAditivosAnulacao
 */
class ContratoAditivosAnulacao
{
    /**
     * PK
     * @var string
     */
    private $exercicioContrato;

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
     * @var integer
     */
    private $numAditivo;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var \DateTime
     */
    private $dtAnulacao;

    /**
     * @var string
     */
    private $motivo;

    /**
     * @var integer
     */
    private $valorAnulacao = 0;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Licitacao\ContratoAditivos
     */
    private $fkLicitacaoContratoAditivos;


    /**
     * Set exercicioContrato
     *
     * @param string $exercicioContrato
     * @return ContratoAditivosAnulacao
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return ContratoAditivosAnulacao
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
     * @return ContratoAditivosAnulacao
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
     * Set numAditivo
     *
     * @param integer $numAditivo
     * @return ContratoAditivosAnulacao
     */
    public function setNumAditivo($numAditivo)
    {
        $this->numAditivo = $numAditivo;
        return $this;
    }

    /**
     * Get numAditivo
     *
     * @return integer
     */
    public function getNumAditivo()
    {
        return $this->numAditivo;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ContratoAditivosAnulacao
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
     * Set dtAnulacao
     *
     * @param \DateTime $dtAnulacao
     * @return ContratoAditivosAnulacao
     */
    public function setDtAnulacao(\DateTime $dtAnulacao)
    {
        $this->dtAnulacao = $dtAnulacao;
        return $this;
    }

    /**
     * Get dtAnulacao
     *
     * @return \DateTime
     */
    public function getDtAnulacao()
    {
        return $this->dtAnulacao;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     * @return ContratoAditivosAnulacao
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;
        return $this;
    }

    /**
     * Get motivo
     *
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * Set valorAnulacao
     *
     * @param integer $valorAnulacao
     * @return ContratoAditivosAnulacao
     */
    public function setValorAnulacao($valorAnulacao)
    {
        $this->valorAnulacao = $valorAnulacao;
        return $this;
    }

    /**
     * Get valorAnulacao
     *
     * @return integer
     */
    public function getValorAnulacao()
    {
        return $this->valorAnulacao;
    }

    /**
     * OneToOne (owning side)
     * Set LicitacaoContratoAditivos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ContratoAditivos $fkLicitacaoContratoAditivos
     * @return ContratoAditivosAnulacao
     */
    public function setFkLicitacaoContratoAditivos(\Urbem\CoreBundle\Entity\Licitacao\ContratoAditivos $fkLicitacaoContratoAditivos)
    {
        $this->exercicioContrato = $fkLicitacaoContratoAditivos->getExercicioContrato();
        $this->codEntidade = $fkLicitacaoContratoAditivos->getCodEntidade();
        $this->numContrato = $fkLicitacaoContratoAditivos->getNumContrato();
        $this->exercicio = $fkLicitacaoContratoAditivos->getExercicio();
        $this->numAditivo = $fkLicitacaoContratoAditivos->getNumAditivo();
        $this->fkLicitacaoContratoAditivos = $fkLicitacaoContratoAditivos;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkLicitacaoContratoAditivos
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\ContratoAditivos
     */
    public function getFkLicitacaoContratoAditivos()
    {
        return $this->fkLicitacaoContratoAditivos;
    }
}
