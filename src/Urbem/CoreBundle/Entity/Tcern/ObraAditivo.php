<?php
 
namespace Urbem\CoreBundle\Entity\Tcern;

/**
 * ObraAditivo
 */
class ObraAditivo
{
    /**
     * PK
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $obraContratoId;

    /**
     * @var string
     */
    private $numAditivo;

    /**
     * @var \DateTime
     */
    private $dtAditivo;

    /**
     * @var string
     */
    private $prazo;

    /**
     * @var string
     */
    private $prazoAditado;

    /**
     * @var integer
     */
    private $valor;

    /**
     * @var integer
     */
    private $valorAditado;

    /**
     * @var integer
     */
    private $numArt;

    /**
     * @var string
     */
    private $motivo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcern\ObraContrato
     */
    private $fkTcernObraContrato;


    /**
     * Set id
     *
     * @param integer $id
     * @return ObraAditivo
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set obraContratoId
     *
     * @param integer $obraContratoId
     * @return ObraAditivo
     */
    public function setObraContratoId($obraContratoId)
    {
        $this->obraContratoId = $obraContratoId;
        return $this;
    }

    /**
     * Get obraContratoId
     *
     * @return integer
     */
    public function getObraContratoId()
    {
        return $this->obraContratoId;
    }

    /**
     * Set numAditivo
     *
     * @param string $numAditivo
     * @return ObraAditivo
     */
    public function setNumAditivo($numAditivo)
    {
        $this->numAditivo = $numAditivo;
        return $this;
    }

    /**
     * Get numAditivo
     *
     * @return string
     */
    public function getNumAditivo()
    {
        return $this->numAditivo;
    }

    /**
     * Set dtAditivo
     *
     * @param \DateTime $dtAditivo
     * @return ObraAditivo
     */
    public function setDtAditivo(\DateTime $dtAditivo)
    {
        $this->dtAditivo = $dtAditivo;
        return $this;
    }

    /**
     * Get dtAditivo
     *
     * @return \DateTime
     */
    public function getDtAditivo()
    {
        return $this->dtAditivo;
    }

    /**
     * Set prazo
     *
     * @param string $prazo
     * @return ObraAditivo
     */
    public function setPrazo($prazo)
    {
        $this->prazo = $prazo;
        return $this;
    }

    /**
     * Get prazo
     *
     * @return string
     */
    public function getPrazo()
    {
        return $this->prazo;
    }

    /**
     * Set prazoAditado
     *
     * @param string $prazoAditado
     * @return ObraAditivo
     */
    public function setPrazoAditado($prazoAditado)
    {
        $this->prazoAditado = $prazoAditado;
        return $this;
    }

    /**
     * Get prazoAditado
     *
     * @return string
     */
    public function getPrazoAditado()
    {
        return $this->prazoAditado;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return ObraAditivo
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set valorAditado
     *
     * @param integer $valorAditado
     * @return ObraAditivo
     */
    public function setValorAditado($valorAditado)
    {
        $this->valorAditado = $valorAditado;
        return $this;
    }

    /**
     * Get valorAditado
     *
     * @return integer
     */
    public function getValorAditado()
    {
        return $this->valorAditado;
    }

    /**
     * Set numArt
     *
     * @param integer $numArt
     * @return ObraAditivo
     */
    public function setNumArt($numArt)
    {
        $this->numArt = $numArt;
        return $this;
    }

    /**
     * Get numArt
     *
     * @return integer
     */
    public function getNumArt()
    {
        return $this->numArt;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     * @return ObraAditivo
     */
    public function setMotivo($motivo)
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
     * Set fkTcernObraContrato
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\ObraContrato $fkTcernObraContrato
     * @return ObraAditivo
     */
    public function setFkTcernObraContrato(\Urbem\CoreBundle\Entity\Tcern\ObraContrato $fkTcernObraContrato)
    {
        $this->obraContratoId = $fkTcernObraContrato->getId();
        $this->fkTcernObraContrato = $fkTcernObraContrato;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcernObraContrato
     *
     * @return \Urbem\CoreBundle\Entity\Tcern\ObraContrato
     */
    public function getFkTcernObraContrato()
    {
        return $this->fkTcernObraContrato;
    }
}
