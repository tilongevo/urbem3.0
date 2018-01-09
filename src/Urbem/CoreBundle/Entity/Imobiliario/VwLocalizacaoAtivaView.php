<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * VwLocalizacaoAtivaView
 */
class VwLocalizacaoAtivaView
{
    /**
     * PK
     * @var integer
     */
    private $codNivel;

    /**
     * @var integer
     */
    private $codVigencia;

    /**
     * @var string
     */
    private $mascara;

    /**
     * @var string
     */
    private $nomNivel;

    /**
     * @var integer
     */
    private $codLocalizacao;

    /**
     * @var string
     */
    private $nomLocalizacao;

    /**
     * @var string
     */
    private $valorComposto;

    /**
     * @var string
     */
    private $valorReduzido;

    /**
     * @var string
     */
    private $valor;


    /**
     * Set codNivel
     *
     * @param integer $codNivel
     * @return VwLocalizacaoAtiva
     */
    public function setCodNivel($codNivel)
    {
        $this->codNivel = $codNivel;
        return $this;
    }

    /**
     * Get codNivel
     *
     * @return integer
     */
    public function getCodNivel()
    {
        return $this->codNivel;
    }

    /**
     * Set codVigencia
     *
     * @param integer $codVigencia
     * @return VwLocalizacaoAtiva
     */
    public function setCodVigencia($codVigencia = null)
    {
        $this->codVigencia = $codVigencia;
        return $this;
    }

    /**
     * Get codVigencia
     *
     * @return integer
     */
    public function getCodVigencia()
    {
        return $this->codVigencia;
    }

    /**
     * Set mascara
     *
     * @param string $mascara
     * @return VwLocalizacaoAtiva
     */
    public function setMascara($mascara = null)
    {
        $this->mascara = $mascara;
        return $this;
    }

    /**
     * Get mascara
     *
     * @return string
     */
    public function getMascara()
    {
        return $this->mascara;
    }

    /**
     * Set nomNivel
     *
     * @param string $nomNivel
     * @return VwLocalizacaoAtiva
     */
    public function setNomNivel($nomNivel = null)
    {
        $this->nomNivel = $nomNivel;
        return $this;
    }

    /**
     * Get nomNivel
     *
     * @return string
     */
    public function getNomNivel()
    {
        return $this->nomNivel;
    }

    /**
     * Set codLocalizacao
     *
     * @param integer $codLocalizacao
     * @return VwLocalizacaoAtiva
     */
    public function setCodLocalizacao($codLocalizacao = null)
    {
        $this->codLocalizacao = $codLocalizacao;
        return $this;
    }

    /**
     * Get codLocalizacao
     *
     * @return integer
     */
    public function getCodLocalizacao()
    {
        return $this->codLocalizacao;
    }

    /**
     * Set nomLocalizacao
     *
     * @param string $nomLocalizacao
     * @return VwLocalizacaoAtiva
     */
    public function setNomLocalizacao($nomLocalizacao = null)
    {
        $this->nomLocalizacao = $nomLocalizacao;
        return $this;
    }

    /**
     * Get nomLocalizacao
     *
     * @return string
     */
    public function getNomLocalizacao()
    {
        return $this->nomLocalizacao;
    }

    /**
     * Set valorComposto
     *
     * @param string $valorComposto
     * @return VwLocalizacaoAtiva
     */
    public function setValorComposto($valorComposto = null)
    {
        $this->valorComposto = $valorComposto;
        return $this;
    }

    /**
     * Get valorComposto
     *
     * @return string
     */
    public function getValorComposto()
    {
        return $this->valorComposto;
    }

    /**
     * Set valorReduzido
     *
     * @param string $valorReduzido
     * @return VwLocalizacaoAtiva
     */
    public function setValorReduzido($valorReduzido = null)
    {
        $this->valorReduzido = $valorReduzido;
        return $this;
    }

    /**
     * Get valorReduzido
     *
     * @return string
     */
    public function getValorReduzido()
    {
        return $this->valorReduzido;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return VwLocalizacaoAtiva
     */
    public function setValor($valor = null)
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
}
