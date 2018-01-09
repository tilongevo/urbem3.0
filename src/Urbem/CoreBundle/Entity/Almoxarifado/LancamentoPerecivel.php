<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * LancamentoPerecivel
 */
class LancamentoPerecivel
{
    /**
     * PK
     * @var integer
     */
    private $codLancamento;

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
    private $codAlmoxarifado;

    /**
     * PK
     * @var integer
     */
    private $codCentro;

    /**
     * @var string
     */
    private $lote;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial
     */
    private $fkAlmoxarifadoLancamentoMaterial;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\Perecivel
     */
    private $fkAlmoxarifadoPerecivel;


    /**
     * Set codLancamento
     *
     * @param integer $codLancamento
     * @return LancamentoPerecivel
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
     * Set codItem
     *
     * @param integer $codItem
     * @return LancamentoPerecivel
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
     * @return LancamentoPerecivel
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
     * Set codAlmoxarifado
     *
     * @param integer $codAlmoxarifado
     * @return LancamentoPerecivel
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
     * Set codCentro
     *
     * @param integer $codCentro
     * @return LancamentoPerecivel
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
     * Set lote
     *
     * @param string $lote
     * @return LancamentoPerecivel
     */
    public function setLote($lote)
    {
        $this->lote = $lote;
        return $this;
    }

    /**
     * Get lote
     *
     * @return string
     */
    public function getLote()
    {
        return $this->lote;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoPerecivel
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Perecivel $fkAlmoxarifadoPerecivel
     * @return LancamentoPerecivel
     */
    public function setFkAlmoxarifadoPerecivel(\Urbem\CoreBundle\Entity\Almoxarifado\Perecivel $fkAlmoxarifadoPerecivel)
    {
        $this->lote = $fkAlmoxarifadoPerecivel->getLote();
        $this->codItem = $fkAlmoxarifadoPerecivel->getCodItem();
        $this->codMarca = $fkAlmoxarifadoPerecivel->getCodMarca();
        $this->codAlmoxarifado = $fkAlmoxarifadoPerecivel->getCodAlmoxarifado();
        $this->codCentro = $fkAlmoxarifadoPerecivel->getCodCentro();
        $this->fkAlmoxarifadoPerecivel = $fkAlmoxarifadoPerecivel;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoPerecivel
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\Perecivel
     */
    public function getFkAlmoxarifadoPerecivel()
    {
        return $this->fkAlmoxarifadoPerecivel;
    }

    /**
     * OneToOne (owning side)
     * Set AlmoxarifadoLancamentoMaterial
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial $fkAlmoxarifadoLancamentoMaterial
     * @return LancamentoPerecivel
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
     * OneToOne (owning side)
     * Get fkAlmoxarifadoLancamentoMaterial
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial
     */
    public function getFkAlmoxarifadoLancamentoMaterial()
    {
        return $this->fkAlmoxarifadoLancamentoMaterial;
    }
}
