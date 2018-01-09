<?php
 
namespace Urbem\CoreBundle\Entity\Frota;

/**
 * Utilizacao
 */
class Utilizacao
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
     * @var integer
     */
    private $kmSaida;

    /**
     * @var string
     */
    private $destino;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Frota\UtilizacaoRetorno
     */
    private $fkFrotaUtilizacaoRetorno;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Frota\Veiculo
     */
    private $fkFrotaVeiculo;

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
     * @return Utilizacao
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
     * @return Utilizacao
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
     * @return Utilizacao
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
     * @return Utilizacao
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
     * Set kmSaida
     *
     * @param integer $kmSaida
     * @return Utilizacao
     */
    public function setKmSaida($kmSaida)
    {
        $this->kmSaida = $kmSaida;
        return $this;
    }

    /**
     * Get kmSaida
     *
     * @return integer
     */
    public function getKmSaida()
    {
        return $this->kmSaida;
    }

    /**
     * Set destino
     *
     * @param string $destino
     * @return Utilizacao
     */
    public function setDestino($destino)
    {
        $this->destino = $destino;
        return $this;
    }

    /**
     * Get destino
     *
     * @return string
     */
    public function getDestino()
    {
        return $this->destino;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFrotaVeiculo
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Veiculo $fkFrotaVeiculo
     * @return Utilizacao
     */
    public function setFkFrotaVeiculo(\Urbem\CoreBundle\Entity\Frota\Veiculo $fkFrotaVeiculo)
    {
        $this->codVeiculo = $fkFrotaVeiculo->getCodVeiculo();
        $this->fkFrotaVeiculo = $fkFrotaVeiculo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFrotaVeiculo
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Veiculo
     */
    public function getFkFrotaVeiculo()
    {
        return $this->fkFrotaVeiculo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFrotaMotorista
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Motorista $fkFrotaMotorista
     * @return Utilizacao
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
     * OneToOne (inverse side)
     * Set FrotaUtilizacaoRetorno
     *
     * @param \Urbem\CoreBundle\Entity\Frota\UtilizacaoRetorno $fkFrotaUtilizacaoRetorno
     * @return Utilizacao
     */
    public function setFkFrotaUtilizacaoRetorno(\Urbem\CoreBundle\Entity\Frota\UtilizacaoRetorno $fkFrotaUtilizacaoRetorno)
    {
        $fkFrotaUtilizacaoRetorno->setFkFrotaUtilizacao($this);
        $this->fkFrotaUtilizacaoRetorno = $fkFrotaUtilizacaoRetorno;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFrotaUtilizacaoRetorno
     *
     * @return \Urbem\CoreBundle\Entity\Frota\UtilizacaoRetorno
     */
    public function getFkFrotaUtilizacaoRetorno()
    {
        return $this->fkFrotaUtilizacaoRetorno;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '%s | %s %s',
            $this->fkFrotaVeiculo,
            $this->dtSaida->format('d/m/Y'),
            $this->hrSaida
        );
    }
}
