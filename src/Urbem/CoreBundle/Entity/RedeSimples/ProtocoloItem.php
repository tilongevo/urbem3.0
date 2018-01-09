<?php

namespace Urbem\CoreBundle\Entity\RedeSimples;

/**
 * ProtocoloItem
 */
class ProtocoloItem
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $identificador;

    /**
     * @var string
     */
    private $campo;

    /**
     * @var string
     */
    private $tipo;

    /**
     * @var string
     */
    private $valor;

    /**
     * ManyToOne
     * @var Protocolo
     */
    private $fkProtocoloRedeSimplesProtocolo;

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
     * Set identificador
     *
     * @param string $identificador
     *
     * @return ProtocoloItem
     */
    public function setIdentificador($identificador)
    {
        $this->identificador = $identificador;

        return $this;
    }

    /**
     * Get identificador
     *
     * @return string
     */
    public function getIdentificador()
    {
        return $this->identificador;
    }

    /**
     * Set campo
     *
     * @param string $campo
     *
     * @return ProtocoloItem
     */
    public function setCampo($campo)
    {
        $this->campo = $campo;

        return $this;
    }

    /**
     * Get campo
     *
     * @return string
     */
    public function getCampo()
    {
        return $this->campo;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     *
     * @return ProtocoloItem
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set valor
     *
     * @param string $valor
     *
     * @return ProtocoloItem
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set fkProtocoloRedeSimplesProtocolo
     *
     * @param Protocolo $fkProtocoloRedeSimplesProtocolo
     *
     * @return ProtocoloItem
     */
    public function setFkProtocoloRedeSimplesProtocolo(Protocolo $fkProtocoloRedeSimplesProtocolo = null)
    {
        $this->fkProtocoloRedeSimplesProtocolo = $fkProtocoloRedeSimplesProtocolo;

        return $this;
    }

    /**
     * Get fkProtocoloRedeSimplesProtocolo
     *
     * @return Protocolo
     */
    public function getFkProtocoloRedeSimplesProtocolo()
    {
        return $this->fkProtocoloRedeSimplesProtocolo;
    }
}

