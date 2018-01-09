<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * ContratoAnulado
 */
class ContratoAnulado
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

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
     * @var \Urbem\CoreBundle\Entity\Licitacao\Contrato
     */
    private $fkLicitacaoContrato;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ContratoAnulado
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return ContratoAnulado
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
     * @return ContratoAnulado
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
     * Set dtAnulacao
     *
     * @param \DateTime $dtAnulacao
     * @return ContratoAnulado
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
     * @return ContratoAnulado
     */
    public function setMotivo($motivo = null)
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
     * @return ContratoAnulado
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
     * Set LicitacaoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato
     * @return ContratoAnulado
     */
    public function setFkLicitacaoContrato(\Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato)
    {
        $this->exercicio = $fkLicitacaoContrato->getExercicio();
        $this->codEntidade = $fkLicitacaoContrato->getCodEntidade();
        $this->numContrato = $fkLicitacaoContrato->getNumContrato();
        $this->fkLicitacaoContrato = $fkLicitacaoContrato;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkLicitacaoContrato
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\Contrato
     */
    public function getFkLicitacaoContrato()
    {
        return $this->fkLicitacaoContrato;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->numContrato;
    }
}
