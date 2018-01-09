<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * EscalaContrato
 */
class EscalaContrato
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
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ponto\EscalaContratoExclusao
     */
    private $fkPontoEscalaContratoExclusao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Contrato
     */
    private $fkPessoalContrato;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ponto\Escala
     */
    private $fkPontoEscala;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return EscalaContrato
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
     * @return EscalaContrato
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
     * @return EscalaContrato
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
     * ManyToOne (inverse side)
     * Set fkPessoalContrato
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Contrato $fkPessoalContrato
     * @return EscalaContrato
     */
    public function setFkPessoalContrato(\Urbem\CoreBundle\Entity\Pessoal\Contrato $fkPessoalContrato)
    {
        $this->codContrato = $fkPessoalContrato->getCodContrato();
        $this->fkPessoalContrato = $fkPessoalContrato;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalContrato
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Contrato
     */
    public function getFkPessoalContrato()
    {
        return $this->fkPessoalContrato;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPontoEscala
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\Escala $fkPontoEscala
     * @return EscalaContrato
     */
    public function setFkPontoEscala(\Urbem\CoreBundle\Entity\Ponto\Escala $fkPontoEscala)
    {
        $this->codEscala = $fkPontoEscala->getCodEscala();
        $this->fkPontoEscala = $fkPontoEscala;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPontoEscala
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\Escala
     */
    public function getFkPontoEscala()
    {
        return $this->fkPontoEscala;
    }

    /**
     * OneToOne (inverse side)
     * Set PontoEscalaContratoExclusao
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\EscalaContratoExclusao $fkPontoEscalaContratoExclusao
     * @return EscalaContrato
     */
    public function setFkPontoEscalaContratoExclusao(\Urbem\CoreBundle\Entity\Ponto\EscalaContratoExclusao $fkPontoEscalaContratoExclusao)
    {
        $fkPontoEscalaContratoExclusao->setFkPontoEscalaContrato($this);
        $this->fkPontoEscalaContratoExclusao = $fkPontoEscalaContratoExclusao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPontoEscalaContratoExclusao
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\EscalaContratoExclusao
     */
    public function getFkPontoEscalaContratoExclusao()
    {
        return $this->fkPontoEscalaContratoExclusao;
    }
}
