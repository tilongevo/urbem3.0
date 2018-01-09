<?php
 
namespace Urbem\CoreBundle\Entity\Divida;

/**
 * ModalidadeReducaoAcrescimo
 */
class ModalidadeReducaoAcrescimo
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
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codAcrescimo;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * PK
     * @var boolean
     */
    private $pagamento;

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
     * @var \Urbem\CoreBundle\Entity\Divida\ModalidadeAcrescimo
     */
    private $fkDividaModalidadeAcrescimo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return ModalidadeReducaoAcrescimo
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
     * @return ModalidadeReducaoAcrescimo
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
     * @return ModalidadeReducaoAcrescimo
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
     * @return ModalidadeReducaoAcrescimo
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ModalidadeReducaoAcrescimo
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
     * Set codAcrescimo
     *
     * @param integer $codAcrescimo
     * @return ModalidadeReducaoAcrescimo
     */
    public function setCodAcrescimo($codAcrescimo)
    {
        $this->codAcrescimo = $codAcrescimo;
        return $this;
    }

    /**
     * Get codAcrescimo
     *
     * @return integer
     */
    public function getCodAcrescimo()
    {
        return $this->codAcrescimo;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return ModalidadeReducaoAcrescimo
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set pagamento
     *
     * @param boolean $pagamento
     * @return ModalidadeReducaoAcrescimo
     */
    public function setPagamento($pagamento)
    {
        $this->pagamento = $pagamento;
        return $this;
    }

    /**
     * Get pagamento
     *
     * @return boolean
     */
    public function getPagamento()
    {
        return $this->pagamento;
    }

    /**
     * Set percentual
     *
     * @param boolean $percentual
     * @return ModalidadeReducaoAcrescimo
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
     * @return ModalidadeReducaoAcrescimo
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
     * @return ModalidadeReducaoAcrescimo
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
     * Set fkDividaModalidadeAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeAcrescimo $fkDividaModalidadeAcrescimo
     * @return ModalidadeReducaoAcrescimo
     */
    public function setFkDividaModalidadeAcrescimo(\Urbem\CoreBundle\Entity\Divida\ModalidadeAcrescimo $fkDividaModalidadeAcrescimo)
    {
        $this->codModalidade = $fkDividaModalidadeAcrescimo->getCodModalidade();
        $this->timestamp = $fkDividaModalidadeAcrescimo->getTimestamp();
        $this->codTipo = $fkDividaModalidadeAcrescimo->getCodTipo();
        $this->codAcrescimo = $fkDividaModalidadeAcrescimo->getCodAcrescimo();
        $this->pagamento = $fkDividaModalidadeAcrescimo->getPagamento();
        $this->fkDividaModalidadeAcrescimo = $fkDividaModalidadeAcrescimo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkDividaModalidadeAcrescimo
     *
     * @return \Urbem\CoreBundle\Entity\Divida\ModalidadeAcrescimo
     */
    public function getFkDividaModalidadeAcrescimo()
    {
        return $this->fkDividaModalidadeAcrescimo;
    }
}
