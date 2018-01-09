<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * EscalaContratoExclusao
 */
class EscalaContratoExclusao
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * PK
     * @var integer
     */
    private $codEscala;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var \DateTime
     */
    private $timestampExclusao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Ponto\EscalaContrato
     */
    private $fkPontoEscalaContrato;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
        $this->timestampExclusao = new \DateTime;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return EscalaContratoExclusao
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
     * Set codEscala
     *
     * @param integer $codEscala
     * @return EscalaContratoExclusao
     */
    public function setCodEscala($codEscala)
    {
        $this->codEscala = $codEscala;
        return $this;
    }

    /**
     * Get codEscala
     *
     * @return integer
     */
    public function getCodEscala()
    {
        return $this->codEscala;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return EscalaContratoExclusao
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimePK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return EscalaContratoExclusao
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set timestampExclusao
     *
     * @param \DateTime $timestampExclusao
     * @return EscalaContratoExclusao
     */
    public function setTimestampExclusao(\DateTime $timestampExclusao)
    {
        $this->timestampExclusao = $timestampExclusao;
        return $this;
    }

    /**
     * Get timestampExclusao
     *
     * @return \DateTime
     */
    public function getTimestampExclusao()
    {
        return $this->timestampExclusao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return EscalaContratoExclusao
     */
    public function setFkAdministracaoUsuario(\Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario)
    {
        $this->numcgm = $fkAdministracaoUsuario->getNumcgm();
        $this->fkAdministracaoUsuario = $fkAdministracaoUsuario;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoUsuario
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    public function getFkAdministracaoUsuario()
    {
        return $this->fkAdministracaoUsuario;
    }

    /**
     * OneToOne (owning side)
     * Set PontoEscalaContrato
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\EscalaContrato $fkPontoEscalaContrato
     * @return EscalaContratoExclusao
     */
    public function setFkPontoEscalaContrato(\Urbem\CoreBundle\Entity\Ponto\EscalaContrato $fkPontoEscalaContrato)
    {
        $this->codContrato = $fkPontoEscalaContrato->getCodContrato();
        $this->codEscala = $fkPontoEscalaContrato->getCodEscala();
        $this->timestamp = $fkPontoEscalaContrato->getTimestamp();
        $this->fkPontoEscalaContrato = $fkPontoEscalaContrato;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPontoEscalaContrato
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\EscalaContrato
     */
    public function getFkPontoEscalaContrato()
    {
        return $this->fkPontoEscalaContrato;
    }
}
