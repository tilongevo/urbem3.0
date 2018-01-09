<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * AtributoCatalogoClassificacaoItemValor
 */
class AtributoCatalogoClassificacaoItemValor
{
    /**
     * PK
     * @var integer
     */
    private $codClassificacao;

    /**
     * PK
     * @var integer
     */
    private $codModulo;

    /**
     * PK
     * @var integer
     */
    private $codCadastro;

    /**
     * PK
     * @var integer
     */
    private $codAtributo;

    /**
     * PK
     * @var integer
     */
    private $codItem;

    /**
     * PK
     * @var integer
     */
    private $codCatalogo;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var string
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoClassificacao
     */
    private $fkAlmoxarifadoAtributoCatalogoClassificacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem
     */
    private $fkAlmoxarifadoCatalogoItem;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \DateTime;
    }

    /**
     * Set codClassificacao
     *
     * @param integer $codClassificacao
     * @return AtributoCatalogoClassificacaoItemValor
     */
    public function setCodClassificacao($codClassificacao)
    {
        $this->codClassificacao = $codClassificacao;
        return $this;
    }

    /**
     * Get codClassificacao
     *
     * @return integer
     */
    public function getCodClassificacao()
    {
        return $this->codClassificacao;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return AtributoCatalogoClassificacaoItemValor
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
     * Set codCadastro
     *
     * @param integer $codCadastro
     * @return AtributoCatalogoClassificacaoItemValor
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
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return AtributoCatalogoClassificacaoItemValor
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
     * Set codItem
     *
     * @param integer $codItem
     * @return AtributoCatalogoClassificacaoItemValor
     */
    public function setCodItem($codItem)
    {
        $this->codItem = $codItem;
        return $this;
    }

    /**
     * Get codItem
     *
     * @return integer
     */
    public function getCodItem()
    {
        return $this->codItem;
    }

    /**
     * Set codCatalogo
     *
     * @param integer $codCatalogo
     * @return AtributoCatalogoClassificacaoItemValor
     */
    public function setCodCatalogo($codCatalogo)
    {
        $this->codCatalogo = $codCatalogo;
        return $this;
    }

    /**
     * Get codCatalogo
     *
     * @return integer
     */
    public function getCodCatalogo()
    {
        return $this->codCatalogo;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return AtributoCatalogoClassificacaoItemValor
     */
    public function setTimestamp(\DateTime $timestamp)
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
     * @param string $valor
     * @return AtributoCatalogoClassificacaoItemValor
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
     * Set fkAlmoxarifadoAtributoCatalogoClassificacao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoClassificacao $fkAlmoxarifadoAtributoCatalogoClassificacao
     * @return AtributoCatalogoClassificacaoItemValor
     */
    public function setFkAlmoxarifadoAtributoCatalogoClassificacao(\Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoClassificacao $fkAlmoxarifadoAtributoCatalogoClassificacao)
    {
        $this->codAtributo = $fkAlmoxarifadoAtributoCatalogoClassificacao->getCodAtributo();
        $this->codCadastro = $fkAlmoxarifadoAtributoCatalogoClassificacao->getCodCadastro();
        $this->codModulo = $fkAlmoxarifadoAtributoCatalogoClassificacao->getCodModulo();
        $this->codClassificacao = $fkAlmoxarifadoAtributoCatalogoClassificacao->getCodClassificacao();
        $this->codCatalogo = $fkAlmoxarifadoAtributoCatalogoClassificacao->getCodCatalogo();
        $this->fkAlmoxarifadoAtributoCatalogoClassificacao = $fkAlmoxarifadoAtributoCatalogoClassificacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoAtributoCatalogoClassificacao
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoClassificacao
     */
    public function getFkAlmoxarifadoAtributoCatalogoClassificacao()
    {
        return $this->fkAlmoxarifadoAtributoCatalogoClassificacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoCatalogoItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem $fkAlmoxarifadoCatalogoItem
     * @return AtributoCatalogoClassificacaoItemValor
     */
    public function setFkAlmoxarifadoCatalogoItem(\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem $fkAlmoxarifadoCatalogoItem)
    {
        $this->codItem = $fkAlmoxarifadoCatalogoItem->getCodItem();
        $this->fkAlmoxarifadoCatalogoItem = $fkAlmoxarifadoCatalogoItem;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoCatalogoItem
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem
     */
    public function getFkAlmoxarifadoCatalogoItem()
    {
        return $this->fkAlmoxarifadoCatalogoItem;
    }
}
