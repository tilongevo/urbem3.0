<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * LancamentoMaterialEstorno
 */
class LancamentoMaterialEstorno
{
    /**
     * PK
     * @var integer
     */
    private $codLancamentoEstorno;

    /**
     * PK
     * @var integer
     */
    private $codLancamento;

    /**
     * PK
     * @var integer
     */
    private $codAlmoxarifado;

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
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial
     */
    private $fkAlmoxarifadoLancamentoMaterial;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial
     */
    private $fkAlmoxarifadoLancamentoMaterial1;


    /**
     * Set codLancamentoEstorno
     *
     * @param integer $codLancamentoEstorno
     * @return LancamentoMaterialEstorno
     */
    public function setCodLancamentoEstorno($codLancamentoEstorno)
    {
        $this->codLancamentoEstorno = $codLancamentoEstorno;
        return $this;
    }

    /**
     * Get codLancamentoEstorno
     *
     * @return integer
     */
    public function getCodLancamentoEstorno()
    {
        return $this->codLancamentoEstorno;
    }

    /**
     * Set codLancamento
     *
     * @param integer $codLancamento
     * @return LancamentoMaterialEstorno
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
     * Set codAlmoxarifado
     *
     * @param integer $codAlmoxarifado
     * @return LancamentoMaterialEstorno
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
     * Set codItem
     *
     * @param integer $codItem
     * @return LancamentoMaterialEstorno
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
     * @return LancamentoMaterialEstorno
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
     * @return LancamentoMaterialEstorno
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
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoLancamentoMaterial
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial $fkAlmoxarifadoLancamentoMaterial
     * @return LancamentoMaterialEstorno
     */
    public function setFkAlmoxarifadoLancamentoMaterial(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial $fkAlmoxarifadoLancamentoMaterial)
    {
        $this->codLancamentoEstorno = $fkAlmoxarifadoLancamentoMaterial->getCodLancamento();
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
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoLancamentoMaterial1
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial $fkAlmoxarifadoLancamentoMaterial1
     * @return LancamentoMaterialEstorno
     */
    public function setFkAlmoxarifadoLancamentoMaterial1(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial $fkAlmoxarifadoLancamentoMaterial1)
    {
        $this->codLancamento = $fkAlmoxarifadoLancamentoMaterial1->getCodLancamento();
        $this->codItem = $fkAlmoxarifadoLancamentoMaterial1->getCodItem();
        $this->codMarca = $fkAlmoxarifadoLancamentoMaterial1->getCodMarca();
        $this->codAlmoxarifado = $fkAlmoxarifadoLancamentoMaterial1->getCodAlmoxarifado();
        $this->codCentro = $fkAlmoxarifadoLancamentoMaterial1->getCodCentro();
        $this->fkAlmoxarifadoLancamentoMaterial1 = $fkAlmoxarifadoLancamentoMaterial1;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoLancamentoMaterial1
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial
     */
    public function getFkAlmoxarifadoLancamentoMaterial1()
    {
        return $this->fkAlmoxarifadoLancamentoMaterial1;
    }
}
