<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * PlanoContaEncerrada
 */
class PlanoContaEncerrada
{
    /**
     * PK
     * @var integer
     */
    private $codConta;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var \DateTime
     */
    private $dtEncerramento;

    /**
     * @var string
     */
    private $motivo;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoConta
     */
    private $fkContabilidadePlanoConta;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \DateTime;
    }

    /**
     * Set codConta
     *
     * @param integer $codConta
     * @return PlanoContaEncerrada
     */
    public function setCodConta($codConta)
    {
        $this->codConta = $codConta;
        return $this;
    }

    /**
     * Get codConta
     *
     * @return integer
     */
    public function getCodConta()
    {
        return $this->codConta;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return PlanoContaEncerrada
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
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return PlanoContaEncerrada
     */
    public function setTimestamp(\DateTime $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set dtEncerramento
     *
     * @param \DateTime $dtEncerramento
     * @return PlanoContaEncerrada
     */
    public function setDtEncerramento(\DateTime $dtEncerramento)
    {
        $this->dtEncerramento = $dtEncerramento;
        return $this;
    }

    /**
     * Get dtEncerramento
     *
     * @return \DateTime
     */
    public function getDtEncerramento()
    {
        return $this->dtEncerramento;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     * @return PlanoContaEncerrada
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
     * OneToOne (owning side)
     * Set ContabilidadePlanoConta
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoConta $fkContabilidadePlanoConta
     * @return PlanoContaEncerrada
     */
    public function setFkContabilidadePlanoConta(\Urbem\CoreBundle\Entity\Contabilidade\PlanoConta $fkContabilidadePlanoConta)
    {
        $this->codConta = $fkContabilidadePlanoConta->getCodConta();
        $this->exercicio = $fkContabilidadePlanoConta->getExercicio();
        $this->fkContabilidadePlanoConta = $fkContabilidadePlanoConta;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkContabilidadePlanoConta
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoConta
     */
    public function getFkContabilidadePlanoConta()
    {
        return $this->fkContabilidadePlanoConta;
    }
}
