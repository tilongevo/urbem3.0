<?php
 
namespace Urbem\CoreBundle\Entity\Tcers;

/**
 * RdExtra
 */
class RdExtra
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
     * @var integer
     */
    private $classificacao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoConta
     */
    private $fkContabilidadePlanoConta;

    /**
     * @var array
     */
    public static $classificacaoList = [
        1 => "1 - Restos a Pagar",
        2 => "2 - Serviço da Dívida",
        3 => "3 - Depósitos",
        4 => "4 - Convênios",
        5 => "5 - Débitos de Tesouraria",
        6 => "6 - Sentenças Judiciais",
        7 => "7 - Outras Operações",
    ];

    /**
     * Set codConta
     *
     * @param integer $codConta
     * @return RdExtra
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
     * @return RdExtra
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
     * Set classificacao
     *
     * @param integer $classificacao
     * @return RdExtra
     */
    public function setClassificacao($classificacao)
    {
        $this->classificacao = $classificacao;
        return $this;
    }

    /**
     * Get classificacao
     *
     * @return integer
     */
    public function getClassificacao()
    {
        return $this->classificacao;
    }

    /**
     * OneToOne (owning side)
     * Set ContabilidadePlanoConta
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoConta $fkContabilidadePlanoConta
     * @return RdExtra
     */
    public function setFkContabilidadePlanoConta(\Urbem\CoreBundle\Entity\Contabilidade\PlanoConta $fkContabilidadePlanoConta = null)
    {
        if (empty($fkContabilidadePlanoConta)) {
            return $this;
        }

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

    /**
     * @return string
     */
    public function __toString()
    {
        $planoConta = $this->getFkContabilidadePlanoConta();
        if (!empty($planoConta)) {
            $planoConta = sprintf("%s - %s", $planoConta->getCodConta(), $planoConta->getNomConta());
        }

        return (string) $planoConta;
    }
}
