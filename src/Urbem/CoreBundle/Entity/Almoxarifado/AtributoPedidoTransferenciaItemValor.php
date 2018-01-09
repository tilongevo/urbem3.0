<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * AtributoPedidoTransferenciaItemValor
 */
class AtributoPedidoTransferenciaItemValor
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codTransferencia;

    /**
     * PK
     * @var integer
     */
    private $codItem;

    /**
     * PK
     * @var integer
     */
    private $codSequencial;

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
    private $codMarca;

    /**
     * PK
     * @var integer
     */
    private $codCentro;

    /**
     * @var string
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\AtributoPedidoTransferenciaItem
     */
    private $fkAlmoxarifadoAtributoPedidoTransferenciaItem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoItem
     */
    private $fkAlmoxarifadoAtributoCatalogoItem;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return AtributoPedidoTransferenciaItemValor
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set codTransferencia
     *
     * @param integer $codTransferencia
     * @return AtributoPedidoTransferenciaItemValor
     */
    public function setCodTransferencia($codTransferencia)
    {
        $this->codTransferencia = $codTransferencia;
        return $this;
    }

    /**
     * Get codTransferencia
     *
     * @return integer
     */
    public function getCodTransferencia()
    {
        return $this->codTransferencia;
    }

    /**
     * Set codItem
     *
     * @param integer $codItem
     * @return AtributoPedidoTransferenciaItemValor
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
     * Set codSequencial
     *
     * @param integer $codSequencial
     * @return AtributoPedidoTransferenciaItemValor
     */
    public function setCodSequencial($codSequencial)
    {
        $this->codSequencial = $codSequencial;
        return $this;
    }

    /**
     * Get codSequencial
     *
     * @return integer
     */
    public function getCodSequencial()
    {
        return $this->codSequencial;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return AtributoPedidoTransferenciaItemValor
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
     * @return AtributoPedidoTransferenciaItemValor
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
     * @return AtributoPedidoTransferenciaItemValor
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
     * Set codMarca
     *
     * @param integer $codMarca
     * @return AtributoPedidoTransferenciaItemValor
     */
    public function setCodMarca($codMarca)
    {
        $this->codMarca = $codMarca;
        return $this;
    }

    /**
     * Get codMarca
     *
     * @return integer
     */
    public function getCodMarca()
    {
        return $this->codMarca;
    }

    /**
     * Set codCentro
     *
     * @param integer $codCentro
     * @return AtributoPedidoTransferenciaItemValor
     */
    public function setCodCentro($codCentro)
    {
        $this->codCentro = $codCentro;
        return $this;
    }

    /**
     * Get codCentro
     *
     * @return integer
     */
    public function getCodCentro()
    {
        return $this->codCentro;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return AtributoPedidoTransferenciaItemValor
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
     * Set fkAlmoxarifadoAtributoPedidoTransferenciaItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoPedidoTransferenciaItem $fkAlmoxarifadoAtributoPedidoTransferenciaItem
     * @return AtributoPedidoTransferenciaItemValor
     */
    public function setFkAlmoxarifadoAtributoPedidoTransferenciaItem(\Urbem\CoreBundle\Entity\Almoxarifado\AtributoPedidoTransferenciaItem $fkAlmoxarifadoAtributoPedidoTransferenciaItem)
    {
        $this->exercicio = $fkAlmoxarifadoAtributoPedidoTransferenciaItem->getExercicio();
        $this->codTransferencia = $fkAlmoxarifadoAtributoPedidoTransferenciaItem->getCodTransferencia();
        $this->codSequencial = $fkAlmoxarifadoAtributoPedidoTransferenciaItem->getCodSequencial();
        $this->codItem = $fkAlmoxarifadoAtributoPedidoTransferenciaItem->getCodItem();
        $this->codMarca = $fkAlmoxarifadoAtributoPedidoTransferenciaItem->getCodMarca();
        $this->codCentro = $fkAlmoxarifadoAtributoPedidoTransferenciaItem->getCodCentro();
        $this->fkAlmoxarifadoAtributoPedidoTransferenciaItem = $fkAlmoxarifadoAtributoPedidoTransferenciaItem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoAtributoPedidoTransferenciaItem
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\AtributoPedidoTransferenciaItem
     */
    public function getFkAlmoxarifadoAtributoPedidoTransferenciaItem()
    {
        return $this->fkAlmoxarifadoAtributoPedidoTransferenciaItem;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoAtributoCatalogoItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoItem $fkAlmoxarifadoAtributoCatalogoItem
     * @return AtributoPedidoTransferenciaItemValor
     */
    public function setFkAlmoxarifadoAtributoCatalogoItem(\Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoItem $fkAlmoxarifadoAtributoCatalogoItem)
    {
        $this->codItem = $fkAlmoxarifadoAtributoCatalogoItem->getCodItem();
        $this->codAtributo = $fkAlmoxarifadoAtributoCatalogoItem->getCodAtributo();
        $this->codCadastro = $fkAlmoxarifadoAtributoCatalogoItem->getCodCadastro();
        $this->codModulo = $fkAlmoxarifadoAtributoCatalogoItem->getCodModulo();
        $this->fkAlmoxarifadoAtributoCatalogoItem = $fkAlmoxarifadoAtributoCatalogoItem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoAtributoCatalogoItem
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoItem
     */
    public function getFkAlmoxarifadoAtributoCatalogoItem()
    {
        return $this->fkAlmoxarifadoAtributoCatalogoItem;
    }
}
