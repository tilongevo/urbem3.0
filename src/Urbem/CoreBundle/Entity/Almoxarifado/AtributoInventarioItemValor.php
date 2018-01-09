<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * AtributoInventarioItemValor
 */
class AtributoInventarioItemValor
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
    private $codAlmoxarifado;

    /**
     * PK
     * @var integer
     */
    private $codInventario;

    /**
     * PK
     * @var integer
     */
    private $codItem;

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
     * @var string
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\InventarioItens
     */
    private $fkAlmoxarifadoInventarioItens;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoItem
     */
    private $fkAlmoxarifadoAtributoCatalogoItem;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return AtributoInventarioItemValor
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
     * Set codAlmoxarifado
     *
     * @param integer $codAlmoxarifado
     * @return AtributoInventarioItemValor
     */
    public function setCodAlmoxarifado($codAlmoxarifado)
    {
        $this->codAlmoxarifado = $codAlmoxarifado;
        return $this;
    }

    /**
     * Get codAlmoxarifado
     *
     * @return integer
     */
    public function getCodAlmoxarifado()
    {
        return $this->codAlmoxarifado;
    }

    /**
     * Set codInventario
     *
     * @param integer $codInventario
     * @return AtributoInventarioItemValor
     */
    public function setCodInventario($codInventario)
    {
        $this->codInventario = $codInventario;
        return $this;
    }

    /**
     * Get codInventario
     *
     * @return integer
     */
    public function getCodInventario()
    {
        return $this->codInventario;
    }

    /**
     * Set codItem
     *
     * @param integer $codItem
     * @return AtributoInventarioItemValor
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
     * Set codMarca
     *
     * @param integer $codMarca
     * @return AtributoInventarioItemValor
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
     * @return AtributoInventarioItemValor
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
     * Set codModulo
     *
     * @param integer $codModulo
     * @return AtributoInventarioItemValor
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
     * @return AtributoInventarioItemValor
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
     * @return AtributoInventarioItemValor
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
     * Set valor
     *
     * @param string $valor
     * @return AtributoInventarioItemValor
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
     * Set fkAlmoxarifadoInventarioItens
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\InventarioItens $fkAlmoxarifadoInventarioItens
     * @return AtributoInventarioItemValor
     */
    public function setFkAlmoxarifadoInventarioItens(\Urbem\CoreBundle\Entity\Almoxarifado\InventarioItens $fkAlmoxarifadoInventarioItens)
    {
        $this->exercicio = $fkAlmoxarifadoInventarioItens->getExercicio();
        $this->codAlmoxarifado = $fkAlmoxarifadoInventarioItens->getCodAlmoxarifado();
        $this->codInventario = $fkAlmoxarifadoInventarioItens->getCodInventario();
        $this->codItem = $fkAlmoxarifadoInventarioItens->getCodItem();
        $this->codMarca = $fkAlmoxarifadoInventarioItens->getCodMarca();
        $this->codCentro = $fkAlmoxarifadoInventarioItens->getCodCentro();
        $this->fkAlmoxarifadoInventarioItens = $fkAlmoxarifadoInventarioItens;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoInventarioItens
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\InventarioItens
     */
    public function getFkAlmoxarifadoInventarioItens()
    {
        return $this->fkAlmoxarifadoInventarioItens;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoAtributoCatalogoItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoItem $fkAlmoxarifadoAtributoCatalogoItem
     * @return AtributoInventarioItemValor
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
