<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * RequisicaoItensAnulacao
 */
class RequisicaoItensAnulacao
{
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
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $quantidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItem
     */
    private $fkAlmoxarifadoRequisicaoItem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoAnulacao
     */
    private $fkAlmoxarifadoRequisicaoAnulacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codItem
     *
     * @param integer $codItem
     * @return RequisicaoItensAnulacao
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
     * @return RequisicaoItensAnulacao
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
     * @return RequisicaoItensAnulacao
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return RequisicaoItensAnulacao
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
     * @return RequisicaoItensAnulacao
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
     * @return RequisicaoItensAnulacao
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return RequisicaoItensAnulacao
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
     * Set quantidade
     *
     * @param integer $quantidade
     * @return RequisicaoItensAnulacao
     */
    public function setQuantidade($quantidade)
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
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoRequisicaoItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItem $fkAlmoxarifadoRequisicaoItem
     * @return RequisicaoItensAnulacao
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
     * Set fkAlmoxarifadoRequisicaoAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoAnulacao $fkAlmoxarifadoRequisicaoAnulacao
     * @return RequisicaoItensAnulacao
     */
    public function setFkAlmoxarifadoRequisicaoAnulacao(\Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoAnulacao $fkAlmoxarifadoRequisicaoAnulacao)
    {
        $this->exercicio = $fkAlmoxarifadoRequisicaoAnulacao->getExercicio();
        $this->codRequisicao = $fkAlmoxarifadoRequisicaoAnulacao->getCodRequisicao();
        $this->codAlmoxarifado = $fkAlmoxarifadoRequisicaoAnulacao->getCodAlmoxarifado();
        $this->timestamp = $fkAlmoxarifadoRequisicaoAnulacao->getTimestamp();
        $this->fkAlmoxarifadoRequisicaoAnulacao = $fkAlmoxarifadoRequisicaoAnulacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoRequisicaoAnulacao
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoAnulacao
     */
    public function getFkAlmoxarifadoRequisicaoAnulacao()
    {
        return $this->fkAlmoxarifadoRequisicaoAnulacao;
    }
}
