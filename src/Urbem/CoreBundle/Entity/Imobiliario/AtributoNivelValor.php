<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * AtributoNivelValor
 */
class AtributoNivelValor
{
    /**
     * PK
     * @var integer
     */
    private $codNivel;

    /**
     * PK
     * @var integer
     */
    private $codVigencia;

    /**
     * PK
     * @var integer
     */
    private $codLocalizacao;

    /**
     * PK
     * @var integer
     */
    private $codAtributo;

    /**
     * PK
     * @var integer
     */
    private $codCadastro;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codModulo;

    /**
     * @var string
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\AtributoNivel
     */
    private $fkImobiliarioAtributoNivel;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Localizacao
     */
    private $fkImobiliarioLocalizacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codNivel
     *
     * @param integer $codNivel
     * @return AtributoNivelValor
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
     * @return AtributoNivelValor
     */
    public function setCodVigencia($codVigencia)
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
     * Set codLocalizacao
     *
     * @param integer $codLocalizacao
     * @return AtributoNivelValor
     */
    public function setCodLocalizacao($codLocalizacao)
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
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return AtributoNivelValor
     */
    public function setCodAtributo($codAtributo)
    {
        $this->codAtributo = $codAtributo;
        return $this;
    }

    /**
     * Get codAtributo
     *
     * @return integer
     */
    public function getCodAtributo()
    {
        return $this->codAtributo;
    }

    /**
     * Set codCadastro
     *
     * @param integer $codCadastro
     * @return AtributoNivelValor
     */
    public function setCodCadastro($codCadastro)
    {
        $this->codCadastro = $codCadastro;
        return $this;
    }

    /**
     * Get codCadastro
     *
     * @return integer
     */
    public function getCodCadastro()
    {
        return $this->codCadastro;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return AtributoNivelValor
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
     * Set codModulo
     *
     * @param integer $codModulo
     * @return AtributoNivelValor
     */
    public function setCodModulo($codModulo)
    {
        $this->codModulo = $codModulo;
        return $this;
    }

    /**
     * Get codModulo
     *
     * @return integer
     */
    public function getCodModulo()
    {
        return $this->codModulo;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return AtributoNivelValor
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
     * ManyToOne (inverse side)
     * Set fkImobiliarioAtributoNivel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoNivel $fkImobiliarioAtributoNivel
     * @return AtributoNivelValor
     */
    public function setFkImobiliarioAtributoNivel(\Urbem\CoreBundle\Entity\Imobiliario\AtributoNivel $fkImobiliarioAtributoNivel)
    {
        $this->codNivel = $fkImobiliarioAtributoNivel->getCodNivel();
        $this->codVigencia = $fkImobiliarioAtributoNivel->getCodVigencia();
        $this->codAtributo = $fkImobiliarioAtributoNivel->getCodAtributo();
        $this->codCadastro = $fkImobiliarioAtributoNivel->getCodCadastro();
        $this->codModulo = $fkImobiliarioAtributoNivel->getCodModulo();
        $this->fkImobiliarioAtributoNivel = $fkImobiliarioAtributoNivel;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioAtributoNivel
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\AtributoNivel
     */
    public function getFkImobiliarioAtributoNivel()
    {
        return $this->fkImobiliarioAtributoNivel;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioLocalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Localizacao $fkImobiliarioLocalizacao
     * @return AtributoNivelValor
     */
    public function setFkImobiliarioLocalizacao(\Urbem\CoreBundle\Entity\Imobiliario\Localizacao $fkImobiliarioLocalizacao)
    {
        $this->codLocalizacao = $fkImobiliarioLocalizacao->getCodLocalizacao();
        $this->fkImobiliarioLocalizacao = $fkImobiliarioLocalizacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioLocalizacao
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Localizacao
     */
    public function getFkImobiliarioLocalizacao()
    {
        return $this->fkImobiliarioLocalizacao;
    }
}
