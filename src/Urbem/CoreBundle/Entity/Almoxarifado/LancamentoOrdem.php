<?php

namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * LancamentoOrdem
 */
class LancamentoOrdem
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
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $codOrdem;

    /**
     * PK
     * @var string
     */
    private $tipo;

    /**
     * PK
     * @var integer
     */
    private $codPreEmpenho;

    /**
     * PK
     * @var string
     */
    private $exercicioPreEmpenho;

    /**
     * PK
     * @var integer
     */
    private $numItem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial
     */
    private $fkAlmoxarifadoLancamentoMaterial;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\OrdemItem
     */
    private $fkComprasOrdemItem;

    /**
     * Set codLancamento
     *
     * @param integer $codLancamento
     * @return LancamentoOrdem
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
     * @return LancamentoOrdem
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
     * @return LancamentoOrdem
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
     * @return LancamentoOrdem
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
     * @return LancamentoOrdem
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
     * @return LancamentoOrdem
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return LancamentoOrdem
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set codOrdem
     *
     * @param integer $codOrdem
     * @return LancamentoOrdem
     */
    public function setCodOrdem($codOrdem)
    {
        $this->codOrdem = $codOrdem;
        return $this;
    }

    /**
     * Get codOrdem
     *
     * @return integer
     */
    public function getCodOrdem()
    {
        return $this->codOrdem;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return LancamentoOrdem
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set codPreEmpenho
     *
     * @param integer $codPreEmpenho
     * @return LancamentoOrdem
     */
    public function setCodPreEmpenho($codPreEmpenho)
    {
        $this->codPreEmpenho = $codPreEmpenho;
        return $this;
    }

    /**
     * Get codPreEmpenho
     *
     * @return integer
     */
    public function getCodPreEmpenho()
    {
        return $this->codPreEmpenho;
    }

    /**
     * Set exercicioPreEmpenho
     *
     * @param string $exercicioPreEmpenho
     * @return LancamentoOrdem
     */
    public function setExercicioPreEmpenho($exercicioPreEmpenho)
    {
        $this->exercicioPreEmpenho = $exercicioPreEmpenho;
        return $this;
    }

    /**
     * Get exercicioPreEmpenho
     *
     * @return string
     */
    public function getExercicioPreEmpenho()
    {
        return $this->exercicioPreEmpenho;
    }

    /**
     * Set numItem
     *
     * @param integer $numItem
     * @return LancamentoOrdem
     */
    public function setNumItem($numItem)
    {
        $this->numItem = $numItem;
        return $this;
    }

    /**
     * Get numItem
     *
     * @return integer
     */
    public function getNumItem()
    {
        return $this->numItem;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoLancamentoMaterial
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial $fkAlmoxarifadoLancamentoMaterial
     * @return LancamentoOrdem
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
     * ManyToOne (inverse side)
     * Set fkComprasOrdemItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\OrdemItem $fkComprasOrdemItem
     * @return LancamentoOrdem
     */
    public function setFkComprasOrdemItem(\Urbem\CoreBundle\Entity\Compras\OrdemItem $fkComprasOrdemItem)
    {
        $this->exercicio = $fkComprasOrdemItem->getExercicio();
        $this->codEntidade = $fkComprasOrdemItem->getCodEntidade();
        $this->codOrdem = $fkComprasOrdemItem->getCodOrdem();
        $this->codPreEmpenho = $fkComprasOrdemItem->getCodPreEmpenho();
        $this->numItem = $fkComprasOrdemItem->getNumItem();
        $this->tipo = $fkComprasOrdemItem->getTipo();
        $this->exercicioPreEmpenho = $fkComprasOrdemItem->getExercicioPreEmpenho();
        $this->fkComprasOrdemItem = $fkComprasOrdemItem;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasOrdemItem
     *
     * @return \Urbem\CoreBundle\Entity\Compras\OrdemItem
     */
    public function getFkComprasOrdemItem()
    {
        return $this->fkComprasOrdemItem;
    }
}
