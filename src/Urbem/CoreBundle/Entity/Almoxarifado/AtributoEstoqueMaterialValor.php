<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * AtributoEstoqueMaterialValor
 */
class AtributoEstoqueMaterialValor
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
    private $codCentro;

    /**
     * PK
     * @var integer
     */
    private $codAlmoxarifado;

    /**
     * PK
     * @var integer
     */
    private $codMarca;

    /**
     * PK
     * @var integer
     */
    private $codLancamento;

    /**
     * @var string
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoItem
     */
    private $fkAlmoxarifadoAtributoCatalogoItem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial
     */
    private $fkAlmoxarifadoLancamentoMaterial;


    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return AtributoEstoqueMaterialValor
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
     * @return AtributoEstoqueMaterialValor
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
     * @return AtributoEstoqueMaterialValor
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
     * @return AtributoEstoqueMaterialValor
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
     * Set codCentro
     *
     * @param integer $codCentro
     * @return AtributoEstoqueMaterialValor
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
     * Set codAlmoxarifado
     *
     * @param integer $codAlmoxarifado
     * @return AtributoEstoqueMaterialValor
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
     * Set codMarca
     *
     * @param integer $codMarca
     * @return AtributoEstoqueMaterialValor
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
     * Set codLancamento
     *
     * @param integer $codLancamento
     * @return AtributoEstoqueMaterialValor
     */
    public function setCodLancamento($codLancamento)
    {
        $this->codLancamento = $codLancamento;
        return $this;
    }

    /**
     * Get codLancamento
     *
     * @return integer
     */
    public function getCodLancamento()
    {
        return $this->codLancamento;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return AtributoEstoqueMaterialValor
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

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoAtributoCatalogoItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoCatalogoItem $fkAlmoxarifadoAtributoCatalogoItem
     * @return AtributoEstoqueMaterialValor
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

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoLancamentoMaterial
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial $fkAlmoxarifadoLancamentoMaterial
     * @return AtributoEstoqueMaterialValor
     */
    public function setFkAlmoxarifadoLancamentoMaterial(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial $fkAlmoxarifadoLancamentoMaterial)
    {
        $this->codLancamento = $fkAlmoxarifadoLancamentoMaterial->getCodLancamento();
        $this->codItem = $fkAlmoxarifadoLancamentoMaterial->getCodItem();
        $this->codMarca = $fkAlmoxarifadoLancamentoMaterial->getCodMarca();
        $this->codAlmoxarifado = $fkAlmoxarifadoLancamentoMaterial->getCodAlmoxarifado();
        $this->codCentro = $fkAlmoxarifadoLancamentoMaterial->getCodCentro();
        $this->fkAlmoxarifadoLancamentoMaterial = $fkAlmoxarifadoLancamentoMaterial;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoLancamentoMaterial
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial
     */
    public function getFkAlmoxarifadoLancamentoMaterial()
    {
        return $this->fkAlmoxarifadoLancamentoMaterial;
    }
}
