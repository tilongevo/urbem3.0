<?php
 
namespace Urbem\CoreBundle\Entity\Tceam;

/**
 * TipoDocumentoBilhete
 */
class TipoDocumentoBilhete
{
    /**
     * PK
     * @var integer
     */
    private $codTipoDocumentoBilhete;

    /**
     * @var integer
     */
    private $codDocumento;

    /**
     * @var string
     */
    private $numero;

    /**
     * @var \DateTime
     */
    private $dtEmissao;

    /**
     * @var \DateTime
     */
    private $dtSaida;

    /**
     * @var \DateTime
     */
    private $horaSaida;

    /**
     * @var string
     */
    private $destino;

    /**
     * @var \DateTime
     */
    private $dtChegada;

    /**
     * @var \DateTime
     */
    private $horaChegada;

    /**
     * @var string
     */
    private $motivo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tceam\Documento
     */
    private $fkTceamDocumento;


    /**
     * Set codTipoDocumentoBilhete
     *
     * @param integer $codTipoDocumentoBilhete
     * @return TipoDocumentoBilhete
     */
    public function setCodTipoDocumentoBilhete($codTipoDocumentoBilhete)
    {
        $this->codTipoDocumentoBilhete = $codTipoDocumentoBilhete;
        return $this;
    }

    /**
     * Get codTipoDocumentoBilhete
     *
     * @return integer
     */
    public function getCodTipoDocumentoBilhete()
    {
        return $this->codTipoDocumentoBilhete;
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return TipoDocumentoBilhete
     */
    public function setCodDocumento($codDocumento)
    {
        $this->codDocumento = $codDocumento;
        return $this;
    }

    /**
     * Get codDocumento
     *
     * @return integer
     */
    public function getCodDocumento()
    {
        return $this->codDocumento;
    }

    /**
     * Set numero
     *
     * @param string $numero
     * @return TipoDocumentoBilhete
     */
    public function setNumero($numero = null)
    {
        $this->numero = $numero;
        return $this;
    }

    /**
     * Get numero
     *
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set dtEmissao
     *
     * @param \DateTime $dtEmissao
     * @return TipoDocumentoBilhete
     */
    public function setDtEmissao(\DateTime $dtEmissao = null)
    {
        $this->dtEmissao = $dtEmissao;
        return $this;
    }

    /**
     * Get dtEmissao
     *
     * @return \DateTime
     */
    public function getDtEmissao()
    {
        return $this->dtEmissao;
    }

    /**
     * Set dtSaida
     *
     * @param \DateTime $dtSaida
     * @return TipoDocumentoBilhete
     */
    public function setDtSaida(\DateTime $dtSaida = null)
    {
        $this->dtSaida = $dtSaida;
        return $this;
    }

    /**
     * Get dtSaida
     *
     * @return \DateTime
     */
    public function getDtSaida()
    {
        return $this->dtSaida;
    }

    /**
     * Set horaSaida
     *
     * @param \DateTime $horaSaida
     * @return TipoDocumentoBilhete
     */
    public function setHoraSaida(\DateTime $horaSaida = null)
    {
        $this->horaSaida = $horaSaida;
        return $this;
    }

    /**
     * Get horaSaida
     *
     * @return \DateTime
     */
    public function getHoraSaida()
    {
        return $this->horaSaida;
    }

    /**
     * Set destino
     *
     * @param string $destino
     * @return TipoDocumentoBilhete
     */
    public function setDestino($destino = null)
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
     * Set dtChegada
     *
     * @param \DateTime $dtChegada
     * @return TipoDocumentoBilhete
     */
    public function setDtChegada(\DateTime $dtChegada = null)
    {
        $this->dtChegada = $dtChegada;
        return $this;
    }

    /**
     * Get dtChegada
     *
     * @return \DateTime
     */
    public function getDtChegada()
    {
        return $this->dtChegada;
    }

    /**
     * Set horaChegada
     *
     * @param \DateTime $horaChegada
     * @return TipoDocumentoBilhete
     */
    public function setHoraChegada(\DateTime $horaChegada = null)
    {
        $this->horaChegada = $horaChegada;
        return $this;
    }

    /**
     * Get horaChegada
     *
     * @return \DateTime
     */
    public function getHoraChegada()
    {
        return $this->horaChegada;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     * @return TipoDocumentoBilhete
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
     * ManyToOne (inverse side)
     * Set fkTceamDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tceam\Documento $fkTceamDocumento
     * @return TipoDocumentoBilhete
     */
    public function setFkTceamDocumento(\Urbem\CoreBundle\Entity\Tceam\Documento $fkTceamDocumento)
    {
        $this->codDocumento = $fkTceamDocumento->getCodDocumento();
        $this->fkTceamDocumento = $fkTceamDocumento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTceamDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Tceam\Documento
     */
    public function getFkTceamDocumento()
    {
        return $this->fkTceamDocumento;
    }
}
