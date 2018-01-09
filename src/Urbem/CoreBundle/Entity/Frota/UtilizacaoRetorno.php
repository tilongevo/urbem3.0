<?php
 
namespace Urbem\CoreBundle\Entity\Frota;

/**
 * UtilizacaoRetorno
 */
class UtilizacaoRetorno
{
    /**
     * PK
     * @var integer
     */
    private $codVeiculo;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DatePK
     */
    private $dtSaida;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\TimePK
     */
    private $hrSaida;

    /**
     * @var integer
     */
    private $cgmMotorista;

    /**
     * @var \DateTime
     */
    private $dtRetorno;

    /**
     * @var \DateTime
     */
    private $hrRetorno;

    /**
     * @var integer
     */
    private $kmRetorno;

    /**
     * @var string
     */
    private $observacao;

    /**
     * @var boolean
     */
    private $viradaOdometro = false;

    /**
     * @var integer
     */
    private $qtdeHorasTrabalhadas = 0;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Frota\Utilizacao
     */
    private $fkFrotaUtilizacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Frota\Motorista
     */
    private $fkFrotaMotorista;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dtSaida = new \Urbem\CoreBundle\Helper\DatePK;
        $this->hrSaida = new \Urbem\CoreBundle\Helper\TimePK;
    }

    /**
     * Set codVeiculo
     *
     * @param integer $codVeiculo
     * @return UtilizacaoRetorno
     */
    public function setCodVeiculo($codVeiculo)
    {
        $this->codVeiculo = $codVeiculo;
        return $this;
    }

    /**
     * Get codVeiculo
     *
     * @return integer
     */
    public function getCodVeiculo()
    {
        return $this->codVeiculo;
    }

    /**
     * Set dtSaida
     *
     * @param \Urbem\CoreBundle\Helper\DatePK $dtSaida
     * @return UtilizacaoRetorno
     */
    public function setDtSaida(\Urbem\CoreBundle\Helper\DatePK $dtSaida)
    {
        $this->dtSaida = $dtSaida;
        return $this;
    }

    /**
     * Get dtSaida
     *
     * @return \Urbem\CoreBundle\Helper\DatePK
     */
    public function getDtSaida()
    {
        return $this->dtSaida;
    }

    /**
     * Set hrSaida
     *
     * @param \Urbem\CoreBundle\Helper\TimePK $hrSaida
     * @return UtilizacaoRetorno
     */
    public function setHrSaida(\Urbem\CoreBundle\Helper\TimePK $hrSaida)
    {
        $this->hrSaida = $hrSaida;
        return $this;
    }

    /**
     * Get hrSaida
     *
     * @return \Urbem\CoreBundle\Helper\TimePK
     */
    public function getHrSaida()
    {
        return $this->hrSaida;
    }

    /**
     * Set cgmMotorista
     *
     * @param integer $cgmMotorista
     * @return UtilizacaoRetorno
     */
    public function setCgmMotorista($cgmMotorista)
    {
        $this->cgmMotorista = $cgmMotorista;
        return $this;
    }

    /**
     * Get cgmMotorista
     *
     * @return integer
     */
    public function getCgmMotorista()
    {
        return $this->cgmMotorista;
    }

    /**
     * Set dtRetorno
     *
     * @param \DateTime $dtRetorno
     * @return UtilizacaoRetorno
     */
    public function setDtRetorno(\DateTime $dtRetorno)
    {
        $this->dtRetorno = $dtRetorno;
        return $this;
    }

    /**
     * Get dtRetorno
     *
     * @return \DateTime
     */
    public function getDtRetorno()
    {
        return $this->dtRetorno;
    }

    /**
     * Set hrRetorno
     *
     * @param \DateTime $hrRetorno
     * @return UtilizacaoRetorno
     */
    public function setHrRetorno(\DateTime $hrRetorno)
    {
        $this->hrRetorno = $hrRetorno;
        return $this;
    }

    /**
     * Get hrRetorno
     *
     * @return \DateTime
     */
    public function getHrRetorno()
    {
        return $this->hrRetorno;
    }

    /**
     * Set kmRetorno
     *
     * @param integer $kmRetorno
     * @return UtilizacaoRetorno
     */
    public function setKmRetorno($kmRetorno)
    {
        $this->kmRetorno = $kmRetorno;
        return $this;
    }

    /**
     * Get kmRetorno
     *
     * @return integer
     */
    public function getKmRetorno()
    {
        return $this->kmRetorno;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return UtilizacaoRetorno
     */
    public function setObservacao($observacao = null)
    {
        $this->observacao = $observacao;
        return $this;
    }

    /**
     * Get observacao
     *
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * Set viradaOdometro
     *
     * @param boolean $viradaOdometro
     * @return UtilizacaoRetorno
     */
    public function setViradaOdometro($viradaOdometro)
    {
        $this->viradaOdometro = $viradaOdometro;
        return $this;
    }

    /**
     * Get viradaOdometro
     *
     * @return boolean
     */
    public function getViradaOdometro()
    {
        return $this->viradaOdometro;
    }

    /**
     * Set qtdeHorasTrabalhadas
     *
     * @param integer $qtdeHorasTrabalhadas
     * @return UtilizacaoRetorno
     */
    public function setQtdeHorasTrabalhadas($qtdeHorasTrabalhadas)
    {
        $this->qtdeHorasTrabalhadas = $qtdeHorasTrabalhadas;
        return $this;
    }

    /**
     * Get qtdeHorasTrabalhadas
     *
     * @return integer
     */
    public function getQtdeHorasTrabalhadas()
    {
        return $this->qtdeHorasTrabalhadas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFrotaMotorista
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Motorista $fkFrotaMotorista
     * @return UtilizacaoRetorno
     */
    public function setFkFrotaMotorista(\Urbem\CoreBundle\Entity\Frota\Motorista $fkFrotaMotorista)
    {
        $this->cgmMotorista = $fkFrotaMotorista->getCgmMotorista();
        $this->fkFrotaMotorista = $fkFrotaMotorista;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFrotaMotorista
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Motorista
     */
    public function getFkFrotaMotorista()
    {
        return $this->fkFrotaMotorista;
    }

    /**
     * OneToOne (owning side)
     * Set FrotaUtilizacao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Utilizacao $fkFrotaUtilizacao
     * @return UtilizacaoRetorno
     */
    public function setFkFrotaUtilizacao(\Urbem\CoreBundle\Entity\Frota\Utilizacao $fkFrotaUtilizacao)
    {
        $this->codVeiculo = $fkFrotaUtilizacao->getCodVeiculo();
        $this->dtSaida = $fkFrotaUtilizacao->getDtSaida();
        $this->hrSaida = $fkFrotaUtilizacao->getHrSaida();
        $this->fkFrotaUtilizacao = $fkFrotaUtilizacao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFrotaUtilizacao
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Utilizacao
     */
    public function getFkFrotaUtilizacao()
    {
        return $this->fkFrotaUtilizacao;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) "Retorno de Veiculo";
    }
}
