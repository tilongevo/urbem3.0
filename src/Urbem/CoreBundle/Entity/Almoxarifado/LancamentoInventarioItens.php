<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * LancamentoInventarioItens
 */
class LancamentoInventarioItens
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
    private $codLancamento;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\InventarioItens
     */
    private $fkAlmoxarifadoInventarioItens;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial
     */
    private $fkAlmoxarifadoLancamentoMaterial;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return LancamentoInventarioItens
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
     * @return LancamentoInventarioItens
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
     * @return LancamentoInventarioItens
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
     * @return LancamentoInventarioItens
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
     * @return LancamentoInventarioItens
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
     * @return LancamentoInventarioItens
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
     * Set codLancamento
     *
     * @param integer $codLancamento
     * @return LancamentoInventarioItens
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
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoLancamentoMaterial
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial $fkAlmoxarifadoLancamentoMaterial
     * @return LancamentoInventarioItens
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

    /**
     * OneToOne (owning side)
     * Set AlmoxarifadoInventarioItens
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\InventarioItens $fkAlmoxarifadoInventarioItens
     * @return LancamentoInventarioItens
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
     * OneToOne (owning side)
     * Get fkAlmoxarifadoInventarioItens
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\InventarioItens
     */
    public function getFkAlmoxarifadoInventarioItens()
    {
        return $this->fkAlmoxarifadoInventarioItens;
    }
}
