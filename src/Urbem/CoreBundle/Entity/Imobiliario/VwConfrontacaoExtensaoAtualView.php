<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * VwConfrontacaoExtensaoAtualView
 */
class VwConfrontacaoExtensaoAtualView
{
    /**
     * PK
     * @var integer
     */
    private $codConfrontacao;

    /**
     * @var integer
     */
    private $codLote;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $valor;


    /**
     * Set codConfrontacao
     *
     * @param integer $codConfrontacao
     * @return VwConfrontacaoExtensaoAtual
     */
    public function setCodConfrontacao($codConfrontacao)
    {
        $this->codConfrontacao = $codConfrontacao;
        return $this;
    }

    /**
     * Get codConfrontacao
     *
     * @return integer
     */
    public function getCodConfrontacao()
    {
        return $this->codConfrontacao;
    }

    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return VwConfrontacaoExtensaoAtual
     */
    public function setCodLote($codLote = null)
    {
        $this->codLote = $codLote;
        return $this;
    }

    /**
     * Get codLote
     *
     * @return integer
     */
    public function getCodLote()
    {
        return $this->codLote;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return VwConfrontacaoExtensaoAtual
     */
    public function setTimestamp(\DateTime $timestamp = null)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return VwConfrontacaoExtensaoAtual
     */
    public function setValor($valor = null)
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
}
