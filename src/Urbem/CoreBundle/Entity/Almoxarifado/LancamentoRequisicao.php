<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * LancamentoRequisicao
 */
class LancamentoRequisicao
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
    private $codRequisicao;

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
    private $codCentro;

    /**
     * PK
     * @var integer
     */
    private $codItem;

    /**
     * PK
     * @var integer
     */
    private $codLancamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItem
     */
    private $fkAlmoxarifadoRequisicaoItem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial
     */
    private $fkAlmoxarifadoLancamentoMaterial;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return LancamentoRequisicao
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
     * Set codRequisicao
     *
     * @param integer $codRequisicao
     * @return LancamentoRequisicao
     */
    public function setCodRequisicao($codRequisicao)
    {
        $this->codRequisicao = $codRequisicao;
        return $this;
    }

    /**
     * Get codRequisicao
     *
     * @return integer
     */
    public function getCodRequisicao()
    {
        return $this->codRequisicao;
    }

    /**
     * Set codAlmoxarifado
     *
     * @param integer $codAlmoxarifado
     * @return LancamentoRequisicao
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
     * @return LancamentoRequisicao
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
     * @return LancamentoRequisicao
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
     * Set codItem
     *
     * @param integer $codItem
     * @return LancamentoRequisicao
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
     * Set codLancamento
     *
     * @param integer $codLancamento
     * @return LancamentoRequisicao
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
     * Set fkAlmoxarifadoRequisicaoItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItem $fkAlmoxarifadoRequisicaoItem
     * @return LancamentoRequisicao
     */
    public function setFkAlmoxarifadoRequisicaoItem(\Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItem $fkAlmoxarifadoRequisicaoItem)
    {
        $this->codAlmoxarifado = $fkAlmoxarifadoRequisicaoItem->getCodAlmoxarifado();
        $this->codRequisicao = $fkAlmoxarifadoRequisicaoItem->getCodRequisicao();
        $this->exercicio = $fkAlmoxarifadoRequisicaoItem->getExercicio();
        $this->codCentro = $fkAlmoxarifadoRequisicaoItem->getCodCentro();
        $this->codMarca = $fkAlmoxarifadoRequisicaoItem->getCodMarca();
        $this->codItem = $fkAlmoxarifadoRequisicaoItem->getCodItem();
        $this->fkAlmoxarifadoRequisicaoItem = $fkAlmoxarifadoRequisicaoItem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoRequisicaoItem
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItem
     */
    public function getFkAlmoxarifadoRequisicaoItem()
    {
        return $this->fkAlmoxarifadoRequisicaoItem;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoLancamentoMaterial
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial $fkAlmoxarifadoLancamentoMaterial
     * @return LancamentoRequisicao
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
