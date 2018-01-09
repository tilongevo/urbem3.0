<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * InventarioItens
 */
class InventarioItens
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
     * @var integer
     */
    private $quantidade;

    /**
     * @var string
     */
    private $justificativa;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoInventarioItens
     */
    private $fkAlmoxarifadoLancamentoInventarioItens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\AtributoInventarioItemValor
     */
    private $fkAlmoxarifadoAtributoInventarioItemValores;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\Inventario
     */
    private $fkAlmoxarifadoInventario;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial
     */
    private $fkAlmoxarifadoEstoqueMaterial;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAlmoxarifadoAtributoInventarioItemValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return InventarioItens
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
     * @return InventarioItens
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
     * @return InventarioItens
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
     * @return InventarioItens
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
     * @return InventarioItens
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
     * @return InventarioItens
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
     * Set quantidade
     *
     * @param integer $quantidade
     * @return InventarioItens
     */
    public function setQuantidade($quantidade = null)
    {
        $this->quantidade = $quantidade;
        return $this;
    }

    /**
     * Get quantidade
     *
     * @return integer
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * Set justificativa
     *
     * @param string $justificativa
     * @return InventarioItens
     */
    public function setJustificativa($justificativa = null)
    {
        $this->justificativa = $justificativa;
        return $this;
    }

    /**
     * Get justificativa
     *
     * @return string
     */
    public function getJustificativa()
    {
        return $this->justificativa;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return InventarioItens
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp = null)
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
     * OneToMany (owning side)
     * Add AlmoxarifadoAtributoInventarioItemValor
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoInventarioItemValor $fkAlmoxarifadoAtributoInventarioItemValor
     * @return InventarioItens
     */
    public function addFkAlmoxarifadoAtributoInventarioItemValores(\Urbem\CoreBundle\Entity\Almoxarifado\AtributoInventarioItemValor $fkAlmoxarifadoAtributoInventarioItemValor)
    {
        if (false === $this->fkAlmoxarifadoAtributoInventarioItemValores->contains($fkAlmoxarifadoAtributoInventarioItemValor)) {
            $fkAlmoxarifadoAtributoInventarioItemValor->setFkAlmoxarifadoInventarioItens($this);
            $this->fkAlmoxarifadoAtributoInventarioItemValores->add($fkAlmoxarifadoAtributoInventarioItemValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoAtributoInventarioItemValor
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoInventarioItemValor $fkAlmoxarifadoAtributoInventarioItemValor
     */
    public function removeFkAlmoxarifadoAtributoInventarioItemValores(\Urbem\CoreBundle\Entity\Almoxarifado\AtributoInventarioItemValor $fkAlmoxarifadoAtributoInventarioItemValor)
    {
        $this->fkAlmoxarifadoAtributoInventarioItemValores->removeElement($fkAlmoxarifadoAtributoInventarioItemValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoAtributoInventarioItemValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\AtributoInventarioItemValor
     */
    public function getFkAlmoxarifadoAtributoInventarioItemValores()
    {
        return $this->fkAlmoxarifadoAtributoInventarioItemValores;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoInventario
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Inventario $fkAlmoxarifadoInventario
     * @return InventarioItens
     */
    public function setFkAlmoxarifadoInventario(\Urbem\CoreBundle\Entity\Almoxarifado\Inventario $fkAlmoxarifadoInventario)
    {
        $this->exercicio = $fkAlmoxarifadoInventario->getExercicio();
        $this->codAlmoxarifado = $fkAlmoxarifadoInventario->getCodAlmoxarifado();
        $this->codInventario = $fkAlmoxarifadoInventario->getCodInventario();
        $this->fkAlmoxarifadoInventario = $fkAlmoxarifadoInventario;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoInventario
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\Inventario
     */
    public function getFkAlmoxarifadoInventario()
    {
        return $this->fkAlmoxarifadoInventario;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoEstoqueMaterial
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial $fkAlmoxarifadoEstoqueMaterial
     * @return InventarioItens
     */
    public function setFkAlmoxarifadoEstoqueMaterial(\Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial $fkAlmoxarifadoEstoqueMaterial)
    {
        $this->codItem = $fkAlmoxarifadoEstoqueMaterial->getCodItem();
        $this->codMarca = $fkAlmoxarifadoEstoqueMaterial->getCodMarca();
        $this->codAlmoxarifado = $fkAlmoxarifadoEstoqueMaterial->getCodAlmoxarifado();
        $this->codCentro = $fkAlmoxarifadoEstoqueMaterial->getCodCentro();
        $this->fkAlmoxarifadoEstoqueMaterial = $fkAlmoxarifadoEstoqueMaterial;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoEstoqueMaterial
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial
     */
    public function getFkAlmoxarifadoEstoqueMaterial()
    {
        return $this->fkAlmoxarifadoEstoqueMaterial;
    }

    /**
     * OneToOne (inverse side)
     * Set AlmoxarifadoLancamentoInventarioItens
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoInventarioItens $fkAlmoxarifadoLancamentoInventarioItens
     * @return InventarioItens
     */
    public function setFkAlmoxarifadoLancamentoInventarioItens(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoInventarioItens $fkAlmoxarifadoLancamentoInventarioItens)
    {
        $fkAlmoxarifadoLancamentoInventarioItens->setFkAlmoxarifadoInventarioItens($this);
        $this->fkAlmoxarifadoLancamentoInventarioItens = $fkAlmoxarifadoLancamentoInventarioItens;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkAlmoxarifadoLancamentoInventarioItens
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoInventarioItens
     */
    public function getFkAlmoxarifadoLancamentoInventarioItens()
    {
        return $this->fkAlmoxarifadoLancamentoInventarioItens;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) "Item de inventário";
    }
}
