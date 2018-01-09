<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;
use Urbem\CoreBundle\Entity\Entity;

/**
 * OperacaoCreditoAro
 */
class OperacaoCreditoAro
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
     * @var \DateTime
     */
    private $dtContratacao;

    /**
     * @var integer
     */
    private $vlContratado;

    /**
     * @var \DateTime
     */
    private $dtPrincipal;

    /**
     * @var \DateTime
     */
    private $dtJuros;

    /**
     * @var \DateTime
     */
    private $dtEncargos;

    /**
     * @var integer
     */
    private $vlLiquidacao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return OperacaoCreditoAro
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
     * @return OperacaoCreditoAro
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
     * Set dtContratacao
     *
     * @param \DateTime $dtContratacao
     * @return OperacaoCreditoAro
     */
    public function setDtContratacao(\DateTime $dtContratacao)
    {
        $this->dtContratacao = $dtContratacao;
        return $this;
    }

    /**
     * Get dtContratacao
     *
     * @return \DateTime
     */
    public function getDtContratacao()
    {
        return $this->dtContratacao;
    }

    /**
     * Set vlContratado
     *
     * @param integer $vlContratado
     * @return OperacaoCreditoAro
     */
    public function setVlContratado($vlContratado)
    {
        $this->vlContratado = $vlContratado;
        return $this;
    }

    /**
     * Get vlContratado
     *
     * @return integer
     */
    public function getVlContratado()
    {
        return $this->vlContratado;
    }

    /**
     * Set dtPrincipal
     *
     * @param \DateTime $dtPrincipal
     * @return OperacaoCreditoAro
     */
    public function setDtPrincipal(\DateTime $dtPrincipal)
    {
        $this->dtPrincipal = $dtPrincipal;
        return $this;
    }

    /**
     * Get dtPrincipal
     *
     * @return \DateTime
     */
    public function getDtPrincipal()
    {
        return $this->dtPrincipal;
    }

    /**
     * Set dtJuros
     *
     * @param \DateTime $dtJuros
     * @return OperacaoCreditoAro
     */
    public function setDtJuros(\DateTime $dtJuros)
    {
        $this->dtJuros = $dtJuros;
        return $this;
    }

    /**
     * Get dtJuros
     *
     * @return \DateTime
     */
    public function getDtJuros()
    {
        return $this->dtJuros;
    }

    /**
     * Set dtEncargos
     *
     * @param \DateTime $dtEncargos
     * @return OperacaoCreditoAro
     */
    public function setDtEncargos(\DateTime $dtEncargos)
    {
        $this->dtEncargos = $dtEncargos;
        return $this;
    }

    /**
     * Get dtEncargos
     *
     * @return \DateTime
     */
    public function getDtEncargos()
    {
        return $this->dtEncargos;
    }

    /**
     * Set vlLiquidacao
     *
     * @param integer $vlLiquidacao
     * @return OperacaoCreditoAro
     */
    public function setVlLiquidacao($vlLiquidacao)
    {
        $this->vlLiquidacao = $vlLiquidacao;
        return $this;
    }

    /**
     * Get vlLiquidacao
     *
     * @return integer
     */
    public function getVlLiquidacao()
    {
        return $this->vlLiquidacao;
    }

    /**
     * OneToOne (owning side)
     * Set OrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return OperacaoCreditoAro
     */
    public function setFkOrcamentoEntidade(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
        $this->exercicio = $fkOrcamentoEntidade->getExercicio();
        $this->codEntidade = $fkOrcamentoEntidade->getCodEntidade();
        $this->fkOrcamentoEntidade = $fkOrcamentoEntidade;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkOrcamentoEntidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    public function getFkOrcamentoEntidade()
    {
        return $this->fkOrcamentoEntidade;
    }
}
