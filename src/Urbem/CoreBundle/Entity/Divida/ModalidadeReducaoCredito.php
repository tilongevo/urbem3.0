<?php
 
namespace Urbem\CoreBundle\Entity\Divida;

use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;

/**
 * ModalidadeReducaoCredito
 */
class ModalidadeReducaoCredito
{
    /**
     * PK
     * @var integer
     */
    private $codModulo;

    /**
     * PK
     * @var integer
     */
    private $codBiblioteca;

    /**
     * PK
     * @var integer
     */
    private $codFuncao;

    /**
     * PK
     * @var integer
     */
    private $codModalidade;

    /**
     * PK
     * @var DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codCredito;

    /**
     * PK
     * @var integer
     */
    private $codNatureza;

    /**
     * PK
     * @var integer
     */
    private $codGenero;

    /**
     * PK
     * @var integer
     */
    private $codEspecie;

    /**
     * PK
     * @var boolean
     */
    private $percentual;

    /**
     * PK
     * @var integer
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Divida\ModalidadeReducao
     */
    private $fkDividaModalidadeReducao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Divida\ModalidadeCredito
     */
    private $fkDividaModalidadeCredito;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new DateTimeMicrosecondPK();
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return ModalidadeReducaoCredito
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
     * Set codBiblioteca
     *
     * @param integer $codBiblioteca
     * @return ModalidadeReducaoCredito
     */
    public function setCodBiblioteca($codBiblioteca)
    {
        $this->codBiblioteca = $codBiblioteca;
        return $this;
    }

    /**
     * Get codBiblioteca
     *
     * @return integer
     */
    public function getCodBiblioteca()
    {
        return $this->codBiblioteca;
    }

    /**
     * Set codFuncao
     *
     * @param integer $codFuncao
     * @return ModalidadeReducaoCredito
     */
    public function setCodFuncao($codFuncao)
    {
        $this->codFuncao = $codFuncao;
        return $this;
    }

    /**
     * Get codFuncao
     *
     * @return integer
     */
    public function getCodFuncao()
    {
        return $this->codFuncao;
    }

    /**
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return ModalidadeReducaoCredito
     */
    public function setCodModalidade($codModalidade)
    {
        $this->codModalidade = $codModalidade;
        return $this;
    }

    /**
     * Get codModalidade
     *
     * @return integer
     */
    public function getCodModalidade()
    {
        return $this->codModalidade;
    }

    /**
     * @param DateTimeMicrosecondPK $timestamp
     * @return $this
     */
    public function setTimestamp(DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * @return DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set codCredito
     *
     * @param integer $codCredito
     * @return ModalidadeReducaoCredito
     */
    public function setCodCredito($codCredito)
    {
        $this->codCredito = $codCredito;
        return $this;
    }

    /**
     * Get codCredito
     *
     * @return integer
     */
    public function getCodCredito()
    {
        return $this->codCredito;
    }

    /**
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return ModalidadeReducaoCredito
     */
    public function setCodNatureza($codNatureza)
    {
        $this->codNatureza = $codNatureza;
        return $this;
    }

    /**
     * Get codNatureza
     *
     * @return integer
     */
    public function getCodNatureza()
    {
        return $this->codNatureza;
    }

    /**
     * Set codGenero
     *
     * @param integer $codGenero
     * @return ModalidadeReducaoCredito
     */
    public function setCodGenero($codGenero)
    {
        $this->codGenero = $codGenero;
        return $this;
    }

    /**
     * Get codGenero
     *
     * @return integer
     */
    public function getCodGenero()
    {
        return $this->codGenero;
    }

    /**
     * Set codEspecie
     *
     * @param integer $codEspecie
     * @return ModalidadeReducaoCredito
     */
    public function setCodEspecie($codEspecie)
    {
        $this->codEspecie = $codEspecie;
        return $this;
    }

    /**
     * Get codEspecie
     *
     * @return integer
     */
    public function getCodEspecie()
    {
        return $this->codEspecie;
    }

    /**
     * Set percentual
     *
     * @param boolean $percentual
     * @return ModalidadeReducaoCredito
     */
    public function setPercentual($percentual)
    {
        $this->percentual = $percentual;
        return $this;
    }

    /**
     * Get percentual
     *
     * @return boolean
     */
    public function getPercentual()
    {
        return $this->percentual;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return ModalidadeReducaoCredito
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
     * ManyToOne (inverse side)
     * Set fkDividaModalidadeReducao
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeReducao $fkDividaModalidadeReducao
     * @return ModalidadeReducaoCredito
     */
    public function setFkDividaModalidadeReducao(\Urbem\CoreBundle\Entity\Divida\ModalidadeReducao $fkDividaModalidadeReducao)
    {
        $this->codModalidade = $fkDividaModalidadeReducao->getCodModalidade();
        $this->timestamp = $fkDividaModalidadeReducao->getTimestamp();
        $this->codFuncao = $fkDividaModalidadeReducao->getCodFuncao();
        $this->codBiblioteca = $fkDividaModalidadeReducao->getCodBiblioteca();
        $this->codModulo = $fkDividaModalidadeReducao->getCodModulo();
        $this->percentual = $fkDividaModalidadeReducao->getPercentual();
        $this->valor = $fkDividaModalidadeReducao->getValor();
        $this->fkDividaModalidadeReducao = $fkDividaModalidadeReducao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkDividaModalidadeReducao
     *
     * @return \Urbem\CoreBundle\Entity\Divida\ModalidadeReducao
     */
    public function getFkDividaModalidadeReducao()
    {
        return $this->fkDividaModalidadeReducao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkDividaModalidadeCredito
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeCredito $fkDividaModalidadeCredito
     * @return ModalidadeReducaoCredito
     */
    public function setFkDividaModalidadeCredito(\Urbem\CoreBundle\Entity\Divida\ModalidadeCredito $fkDividaModalidadeCredito)
    {
        $this->codModalidade = $fkDividaModalidadeCredito->getCodModalidade();
        $this->timestamp = $fkDividaModalidadeCredito->getTimestamp();
        $this->codEspecie = $fkDividaModalidadeCredito->getCodEspecie();
        $this->codGenero = $fkDividaModalidadeCredito->getCodGenero();
        $this->codNatureza = $fkDividaModalidadeCredito->getCodNatureza();
        $this->codCredito = $fkDividaModalidadeCredito->getCodCredito();
        $this->fkDividaModalidadeCredito = $fkDividaModalidadeCredito;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkDividaModalidadeCredito
     *
     * @return \Urbem\CoreBundle\Entity\Divida\ModalidadeCredito
     */
    public function getFkDividaModalidadeCredito()
    {
        return $this->fkDividaModalidadeCredito;
    }
}
