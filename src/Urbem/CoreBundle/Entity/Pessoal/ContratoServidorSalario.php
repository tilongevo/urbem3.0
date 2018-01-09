<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ContratoServidorSalario
 */
class ContratoServidorSalario
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $salario;

    /**
     * @var integer
     */
    private $horasMensais;

    /**
     * @var integer
     */
    private $horasSemanais;

    /**
     * @var \DateTime
     */
    private $vigencia;

    /**
     * @var integer
     */
    private $codPeriodoMovimentacao;

    /**
     * @var boolean
     */
    private $reajuste = false;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteContratoServidorSalario
     */
    private $fkFolhapagamentoReajusteContratoServidorSalarios;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    private $fkPessoalContratoServidor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao
     */
    private $fkFolhapagamentoPeriodoMovimentacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoReajusteContratoServidorSalarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ContratoServidorSalario
     */
    public function setCodContrato($codContrato)
    {
        $this->codContrato = $codContrato;
        return $this;
    }

    /**
     * Get codContrato
     *
     * @return integer
     */
    public function getCodContrato()
    {
        return $this->codContrato;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ContratoServidorSalario
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set salario
     *
     * @param integer $salario
     * @return ContratoServidorSalario
     */
    public function setSalario($salario)
    {
        $this->salario = $salario;
        return $this;
    }

    /**
     * Get salario
     *
     * @return integer
     */
    public function getSalario()
    {
        return $this->salario;
    }

    /**
     * Set horasMensais
     *
     * @param integer $horasMensais
     * @return ContratoServidorSalario
     */
    public function setHorasMensais($horasMensais)
    {
        $this->horasMensais = $horasMensais;
        return $this;
    }

    /**
     * Get horasMensais
     *
     * @return integer
     */
    public function getHorasMensais()
    {
        return $this->horasMensais;
    }

    /**
     * Set horasSemanais
     *
     * @param integer $horasSemanais
     * @return ContratoServidorSalario
     */
    public function setHorasSemanais($horasSemanais)
    {
        $this->horasSemanais = $horasSemanais;
        return $this;
    }

    /**
     * Get horasSemanais
     *
     * @return integer
     */
    public function getHorasSemanais()
    {
        return $this->horasSemanais;
    }

    /**
     * Set vigencia
     *
     * @param \DateTime $vigencia
     * @return ContratoServidorSalario
     */
    public function setVigencia(\DateTime $vigencia)
    {
        $this->vigencia = $vigencia;
        return $this;
    }

    /**
     * Get vigencia
     *
     * @return \DateTime
     */
    public function getVigencia()
    {
        return $this->vigencia;
    }

    /**
     * Set codPeriodoMovimentacao
     *
     * @param integer $codPeriodoMovimentacao
     * @return ContratoServidorSalario
     */
    public function setCodPeriodoMovimentacao($codPeriodoMovimentacao)
    {
        $this->codPeriodoMovimentacao = $codPeriodoMovimentacao;
        return $this;
    }

    /**
     * Get codPeriodoMovimentacao
     *
     * @return integer
     */
    public function getCodPeriodoMovimentacao()
    {
        return $this->codPeriodoMovimentacao;
    }

    /**
     * Set reajuste
     *
     * @param boolean $reajuste
     * @return ContratoServidorSalario
     */
    public function setReajuste($reajuste)
    {
        $this->reajuste = $reajuste;
        return $this;
    }

    /**
     * Get reajuste
     *
     * @return boolean
     */
    public function getReajuste()
    {
        return $this->reajuste;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoReajusteContratoServidorSalario
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ReajusteContratoServidorSalario $fkFolhapagamentoReajusteContratoServidorSalario
     * @return ContratoServidorSalario
     */
    public function addFkFolhapagamentoReajusteContratoServidorSalarios(\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteContratoServidorSalario $fkFolhapagamentoReajusteContratoServidorSalario)
    {
        if (false === $this->fkFolhapagamentoReajusteContratoServidorSalarios->contains($fkFolhapagamentoReajusteContratoServidorSalario)) {
            $fkFolhapagamentoReajusteContratoServidorSalario->setFkPessoalContratoServidorSalario($this);
            $this->fkFolhapagamentoReajusteContratoServidorSalarios->add($fkFolhapagamentoReajusteContratoServidorSalario);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoReajusteContratoServidorSalario
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ReajusteContratoServidorSalario $fkFolhapagamentoReajusteContratoServidorSalario
     */
    public function removeFkFolhapagamentoReajusteContratoServidorSalarios(\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteContratoServidorSalario $fkFolhapagamentoReajusteContratoServidorSalario)
    {
        $this->fkFolhapagamentoReajusteContratoServidorSalarios->removeElement($fkFolhapagamentoReajusteContratoServidorSalario);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoReajusteContratoServidorSalarios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteContratoServidorSalario
     */
    public function getFkFolhapagamentoReajusteContratoServidorSalarios()
    {
        return $this->fkFolhapagamentoReajusteContratoServidorSalarios;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor
     * @return ContratoServidorSalario
     */
    public function setFkPessoalContratoServidor(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor)
    {
        $this->codContrato = $fkPessoalContratoServidor->getCodContrato();
        $this->fkPessoalContratoServidor = $fkPessoalContratoServidor;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalContratoServidor
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    public function getFkPessoalContratoServidor()
    {
        return $this->fkPessoalContratoServidor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoPeriodoMovimentacao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao $fkFolhapagamentoPeriodoMovimentacao
     * @return ContratoServidorSalario
     */
    public function setFkFolhapagamentoPeriodoMovimentacao(\Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao $fkFolhapagamentoPeriodoMovimentacao)
    {
        $this->codPeriodoMovimentacao = $fkFolhapagamentoPeriodoMovimentacao->getCodPeriodoMovimentacao();
        $this->fkFolhapagamentoPeriodoMovimentacao = $fkFolhapagamentoPeriodoMovimentacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoPeriodoMovimentacao
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao
     */
    public function getFkFolhapagamentoPeriodoMovimentacao()
    {
        return $this->fkFolhapagamentoPeriodoMovimentacao;
    }
}
