<?php
 
namespace Urbem\CoreBundle\Entity\Tceam;

/**
 * TipoDocumentoDiaria
 */
class TipoDocumentoDiaria
{
    /**
     * PK
     * @var integer
     */
    private $codTipoDocumentoDiaria;

    /**
     * @var integer
     */
    private $codDocumento;

    /**
     * @var string
     */
    private $funcionario;

    /**
     * @var string
     */
    private $matricula;

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
    private $dtRetorno;

    /**
     * @var \DateTime
     */
    private $horaRetorno;

    /**
     * @var string
     */
    private $motivo;

    /**
     * @var integer
     */
    private $quantidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tceam\Documento
     */
    private $fkTceamDocumento;


    /**
     * Set codTipoDocumentoDiaria
     *
     * @param integer $codTipoDocumentoDiaria
     * @return TipoDocumentoDiaria
     */
    public function setCodTipoDocumentoDiaria($codTipoDocumentoDiaria)
    {
        $this->codTipoDocumentoDiaria = $codTipoDocumentoDiaria;
        return $this;
    }

    /**
     * Get codTipoDocumentoDiaria
     *
     * @return integer
     */
    public function getCodTipoDocumentoDiaria()
    {
        return $this->codTipoDocumentoDiaria;
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return TipoDocumentoDiaria
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
     * Set funcionario
     *
     * @param string $funcionario
     * @return TipoDocumentoDiaria
     */
    public function setFuncionario($funcionario = null)
    {
        $this->funcionario = $funcionario;
        return $this;
    }

    /**
     * Get funcionario
     *
     * @return string
     */
    public function getFuncionario()
    {
        return $this->funcionario;
    }

    /**
     * Set matricula
     *
     * @param string $matricula
     * @return TipoDocumentoDiaria
     */
    public function setMatricula($matricula = null)
    {
        $this->matricula = $matricula;
        return $this;
    }

    /**
     * Get matricula
     *
     * @return string
     */
    public function getMatricula()
    {
        return $this->matricula;
    }

    /**
     * Set dtSaida
     *
     * @param \DateTime $dtSaida
     * @return TipoDocumentoDiaria
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
     * @return TipoDocumentoDiaria
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
     * @return TipoDocumentoDiaria
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
     * Set dtRetorno
     *
     * @param \DateTime $dtRetorno
     * @return TipoDocumentoDiaria
     */
    public function setDtRetorno(\DateTime $dtRetorno = null)
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
     * Set horaRetorno
     *
     * @param \DateTime $horaRetorno
     * @return TipoDocumentoDiaria
     */
    public function setHoraRetorno(\DateTime $horaRetorno = null)
    {
        $this->horaRetorno = $horaRetorno;
        return $this;
    }

    /**
     * Get horaRetorno
     *
     * @return \DateTime
     */
    public function getHoraRetorno()
    {
        return $this->horaRetorno;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     * @return TipoDocumentoDiaria
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
     * Set quantidade
     *
     * @param integer $quantidade
     * @return TipoDocumentoDiaria
     */
    public function setQuantidade($quantidade = null)
    {
        $this->quantidade = $quantidade;
        return $this;
    }

    /**
     * Get quantidade
     *
     * @return integer
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTceamDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tceam\Documento $fkTceamDocumento
     * @return TipoDocumentoDiaria
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
