<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwRecebimento
 */
class SwRecebimento
{
    /**
     * PK
     * @var integer
     */
    private $codAndamento;

    /**
     * PK
     * @var integer
     */
    private $codProcesso;

    /**
     * PK
     * @var string
     */
    private $anoExercicio;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\SwAssinaturaDigital
     */
    private $fkSwAssinaturaDigital;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\SwReciboImpresso
     */
    private $fkSwReciboImpresso;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\SwAndamento
     */
    private $fkSwAndamento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codAndamento
     *
     * @param integer $codAndamento
     * @return SwRecebimento
     */
    public function setCodAndamento($codAndamento)
    {
        $this->codAndamento = $codAndamento;
        return $this;
    }

    /**
     * Get codAndamento
     *
     * @return integer
     */
    public function getCodAndamento()
    {
        return $this->codAndamento;
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return SwRecebimento
     */
    public function setCodProcesso($codProcesso)
    {
        $this->codProcesso = $codProcesso;
        return $this;
    }

    /**
     * Get codProcesso
     *
     * @return integer
     */
    public function getCodProcesso()
    {
        return $this->codProcesso;
    }

    /**
     * Set anoExercicio
     *
     * @param string $anoExercicio
     * @return SwRecebimento
     */
    public function setAnoExercicio($anoExercicio)
    {
        $this->anoExercicio = $anoExercicio;
        return $this;
    }

    /**
     * Get anoExercicio
     *
     * @return string
     */
    public function getAnoExercicio()
    {
        return $this->anoExercicio;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return SwRecebimento
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
     * OneToOne (inverse side)
     * Set SwAssinaturaDigital
     *
     * @param \Urbem\CoreBundle\Entity\SwAssinaturaDigital $fkSwAssinaturaDigital
     * @return SwRecebimento
     */
    public function setFkSwAssinaturaDigital(\Urbem\CoreBundle\Entity\SwAssinaturaDigital $fkSwAssinaturaDigital)
    {
        $fkSwAssinaturaDigital->setFkSwRecebimento($this);
        $this->fkSwAssinaturaDigital = $fkSwAssinaturaDigital;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkSwAssinaturaDigital
     *
     * @return \Urbem\CoreBundle\Entity\SwAssinaturaDigital
     */
    public function getFkSwAssinaturaDigital()
    {
        return $this->fkSwAssinaturaDigital;
    }

    /**
     * OneToOne (inverse side)
     * Set SwReciboImpresso
     *
     * @param \Urbem\CoreBundle\Entity\SwReciboImpresso $fkSwReciboImpresso
     * @return SwRecebimento
     */
    public function setFkSwReciboImpresso(\Urbem\CoreBundle\Entity\SwReciboImpresso $fkSwReciboImpresso)
    {
        $fkSwReciboImpresso->setFkSwRecebimento($this);
        $this->fkSwReciboImpresso = $fkSwReciboImpresso;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkSwReciboImpresso
     *
     * @return \Urbem\CoreBundle\Entity\SwReciboImpresso
     */
    public function getFkSwReciboImpresso()
    {
        return $this->fkSwReciboImpresso;
    }

    /**
     * OneToOne (owning side)
     * Set SwAndamento
     *
     * @param \Urbem\CoreBundle\Entity\SwAndamento $fkSwAndamento
     * @return SwRecebimento
     */
    public function setFkSwAndamento(\Urbem\CoreBundle\Entity\SwAndamento $fkSwAndamento)
    {
        $this->codAndamento = $fkSwAndamento->getCodAndamento();
        $this->codProcesso = $fkSwAndamento->getCodProcesso();
        $this->anoExercicio = $fkSwAndamento->getAnoExercicio();
        $this->fkSwAndamento = $fkSwAndamento;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkSwAndamento
     *
     * @return \Urbem\CoreBundle\Entity\SwAndamento
     */
    public function getFkSwAndamento()
    {
        return $this->fkSwAndamento;
    }
}
