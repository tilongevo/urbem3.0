<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * ConfiguracaoLancamentoContaDespesaItem
 */
class ConfiguracaoLancamentoContaDespesaItem
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
    private $codContaDespesa;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem
     */
    private $fkAlmoxarifadoCatalogoItem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\ContaDespesa
     */
    private $fkOrcamentoContaDespesa;


    /**
     * Set codItem
     *
     * @param integer $codItem
     * @return ConfiguracaoLancamentoContaDespesaItem
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
     * Set codContaDespesa
     *
     * @param integer $codContaDespesa
     * @return ConfiguracaoLancamentoContaDespesaItem
     */
    public function setCodContaDespesa($codContaDespesa)
    {
        $this->codContaDespesa = $codContaDespesa;
        return $this;
    }

    /**
     * Get codContaDespesa
     *
     * @return integer
     */
    public function getCodContaDespesa()
    {
        return $this->codContaDespesa;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConfiguracaoLancamentoContaDespesaItem
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
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoCatalogoItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem $fkAlmoxarifadoCatalogoItem
     * @return ConfiguracaoLancamentoContaDespesaItem
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

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoContaDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ContaDespesa $fkOrcamentoContaDespesa
     * @return ConfiguracaoLancamentoContaDespesaItem
     */
    public function setFkOrcamentoContaDespesa(\Urbem\CoreBundle\Entity\Orcamento\ContaDespesa $fkOrcamentoContaDespesa)
    {
        $this->exercicio = $fkOrcamentoContaDespesa->getExercicio();
        $this->codContaDespesa = $fkOrcamentoContaDespesa->getCodConta();
        $this->fkOrcamentoContaDespesa = $fkOrcamentoContaDespesa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoContaDespesa
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\ContaDespesa
     */
    public function getFkOrcamentoContaDespesa()
    {
        return $this->fkOrcamentoContaDespesa;
    }
}
