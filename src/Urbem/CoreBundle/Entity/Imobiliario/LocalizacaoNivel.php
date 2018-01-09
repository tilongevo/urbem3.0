<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * LocalizacaoNivel
 */
class LocalizacaoNivel
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
     * @var string
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Nivel
     */
    private $fkImobiliarioNivel;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Localizacao
     */
    private $fkImobiliarioLocalizacao;


    /**
     * Set codNivel
     *
     * @param integer $codNivel
     * @return LocalizacaoNivel
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
     * @return LocalizacaoNivel
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
     * @return LocalizacaoNivel
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
     * Set valor
     *
     * @param string $valor
     * @return LocalizacaoNivel
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
     * Set fkImobiliarioNivel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Nivel $fkImobiliarioNivel
     * @return LocalizacaoNivel
     */
    public function setFkImobiliarioNivel(\Urbem\CoreBundle\Entity\Imobiliario\Nivel $fkImobiliarioNivel)
    {
        $this->codNivel = $fkImobiliarioNivel->getCodNivel();
        $this->codVigencia = $fkImobiliarioNivel->getCodVigencia();
        $this->fkImobiliarioNivel = $fkImobiliarioNivel;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioNivel
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Nivel
     */
    public function getFkImobiliarioNivel()
    {
        return $this->fkImobiliarioNivel;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioLocalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Localizacao $fkImobiliarioLocalizacao
     * @return LocalizacaoNivel
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
