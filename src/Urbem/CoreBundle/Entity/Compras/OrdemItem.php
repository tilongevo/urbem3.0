<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * OrdemItem
 */
class OrdemItem
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
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $codOrdem;

    /**
     * PK
     * @var integer
     */
    private $codPreEmpenho;

    /**
     * PK
     * @var integer
     */
    private $numItem;

    /**
     * PK
     * @var string
     */
    private $tipo = 'C';

    /**
     * PK
     * @var string
     */
    private $exercicioPreEmpenho;

    /**
     * @var integer
     */
    private $quantidade;

    /**
     * @var integer
     */
    private $vlTotal;

    /**
     * @var integer
     */
    private $codMarca;

    /**
     * @var integer
     */
    private $codCentro;

    /**
     * @var integer
     */
    private $codItem;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoOrdem
     */
    private $fkAlmoxarifadoLancamentoOrdens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\OrdemItemAnulacao
     */
    private $fkComprasOrdemItemAnulacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\Ordem
     */
    private $fkComprasOrdem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho
     */
    private $fkEmpenhoItemPreEmpenho;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItemMarca
     */
    private $fkAlmoxarifadoCatalogoItemMarca;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto
     */
    private $fkAlmoxarifadoCentroCusto;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAlmoxarifadoLancamentoOrdens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasOrdemItemAnulacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return OrdemItem
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
     * @return OrdemItem
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
     * @return OrdemItem
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
     * Set codPreEmpenho
     *
     * @param integer $codPreEmpenho
     * @return OrdemItem
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
     * Set numItem
     *
     * @param integer $numItem
     * @return OrdemItem
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
     * Set tipo
     *
     * @param string $tipo
     * @return OrdemItem
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
     * Set exercicioPreEmpenho
     *
     * @param string $exercicioPreEmpenho
     * @return OrdemItem
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
     * Set quantidade
     *
     * @param integer $quantidade
     * @return OrdemItem
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
     * Set vlTotal
     *
     * @param integer $vlTotal
     * @return OrdemItem
     */
    public function setVlTotal($vlTotal = null)
    {
        $this->vlTotal = $vlTotal;
        return $this;
    }

    /**
     * Get vlTotal
     *
     * @return integer
     */
    public function getVlTotal()
    {
        return $this->vlTotal;
    }

    /**
     * Set codMarca
     *
     * @param integer $codMarca
     * @return OrdemItem
     */
    public function setCodMarca($codMarca = null)
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
     * @return OrdemItem
     */
    public function setCodCentro($codCentro = null)
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
     * @return OrdemItem
     */
    public function setCodItem($codItem = null)
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
     * OneToMany (owning side)
     * Add AlmoxarifadoLancamentoOrdem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoOrdem $fkAlmoxarifadoLancamentoOrdem
     * @return OrdemItem
     */
    public function addFkAlmoxarifadoLancamentoOrdens(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoOrdem $fkAlmoxarifadoLancamentoOrdem)
    {
        if (false === $this->fkAlmoxarifadoLancamentoOrdens->contains($fkAlmoxarifadoLancamentoOrdem)) {
            $fkAlmoxarifadoLancamentoOrdem->setFkComprasOrdemItem($this);
            $this->fkAlmoxarifadoLancamentoOrdens->add($fkAlmoxarifadoLancamentoOrdem);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoLancamentoOrdem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoOrdem $fkAlmoxarifadoLancamentoOrdem
     */
    public function removeFkAlmoxarifadoLancamentoOrdens(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoOrdem $fkAlmoxarifadoLancamentoOrdem)
    {
        $this->fkAlmoxarifadoLancamentoOrdens->removeElement($fkAlmoxarifadoLancamentoOrdem);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoLancamentoOrdens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoOrdem
     */
    public function getFkAlmoxarifadoLancamentoOrdens()
    {
        return $this->fkAlmoxarifadoLancamentoOrdens;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasOrdemItemAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\OrdemItemAnulacao $fkComprasOrdemItemAnulacao
     * @return OrdemItem
     */
    public function addFkComprasOrdemItemAnulacoes(\Urbem\CoreBundle\Entity\Compras\OrdemItemAnulacao $fkComprasOrdemItemAnulacao)
    {
        if (false === $this->fkComprasOrdemItemAnulacoes->contains($fkComprasOrdemItemAnulacao)) {
            $fkComprasOrdemItemAnulacao->setFkComprasOrdemItem($this);
            $this->fkComprasOrdemItemAnulacoes->add($fkComprasOrdemItemAnulacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasOrdemItemAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\OrdemItemAnulacao $fkComprasOrdemItemAnulacao
     */
    public function removeFkComprasOrdemItemAnulacoes(\Urbem\CoreBundle\Entity\Compras\OrdemItemAnulacao $fkComprasOrdemItemAnulacao)
    {
        $this->fkComprasOrdemItemAnulacoes->removeElement($fkComprasOrdemItemAnulacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasOrdemItemAnulacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\OrdemItemAnulacao
     */
    public function getFkComprasOrdemItemAnulacoes()
    {
        return $this->fkComprasOrdemItemAnulacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasOrdem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Ordem $fkComprasOrdem
     * @return OrdemItem
     */
    public function setFkComprasOrdem(\Urbem\CoreBundle\Entity\Compras\Ordem $fkComprasOrdem)
    {
        $this->exercicio = $fkComprasOrdem->getExercicio();
        $this->codEntidade = $fkComprasOrdem->getCodEntidade();
        $this->codOrdem = $fkComprasOrdem->getCodOrdem();
        $this->tipo = $fkComprasOrdem->getTipo();
        $this->fkComprasOrdem = $fkComprasOrdem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasOrdem
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Ordem
     */
    public function getFkComprasOrdem()
    {
        return $this->fkComprasOrdem;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoItemPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho $fkEmpenhoItemPreEmpenho
     * @return OrdemItem
     */
    public function setFkEmpenhoItemPreEmpenho(\Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho $fkEmpenhoItemPreEmpenho)
    {
        $this->codPreEmpenho = $fkEmpenhoItemPreEmpenho->getCodPreEmpenho();
        $this->exercicioPreEmpenho = $fkEmpenhoItemPreEmpenho->getExercicio();
        $this->numItem = $fkEmpenhoItemPreEmpenho->getNumItem();
        $this->fkEmpenhoItemPreEmpenho = $fkEmpenhoItemPreEmpenho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoItemPreEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho
     */
    public function getFkEmpenhoItemPreEmpenho()
    {
        return $this->fkEmpenhoItemPreEmpenho;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoCatalogoItemMarca
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItemMarca $fkAlmoxarifadoCatalogoItemMarca
     * @return OrdemItem
     */
    public function setFkAlmoxarifadoCatalogoItemMarca(\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItemMarca $fkAlmoxarifadoCatalogoItemMarca)
    {
        $this->codItem = $fkAlmoxarifadoCatalogoItemMarca->getCodItem();
        $this->codMarca = $fkAlmoxarifadoCatalogoItemMarca->getCodMarca();
        $this->fkAlmoxarifadoCatalogoItemMarca = $fkAlmoxarifadoCatalogoItemMarca;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoCatalogoItemMarca
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItemMarca
     */
    public function getFkAlmoxarifadoCatalogoItemMarca()
    {
        return $this->fkAlmoxarifadoCatalogoItemMarca;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoCentroCusto
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto $fkAlmoxarifadoCentroCusto
     * @return OrdemItem
     */
    public function setFkAlmoxarifadoCentroCusto(\Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto $fkAlmoxarifadoCentroCusto)
    {
        $this->codCentro = $fkAlmoxarifadoCentroCusto->getCodCentro();
        $this->fkAlmoxarifadoCentroCusto = $fkAlmoxarifadoCentroCusto;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoCentroCusto
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto
     */
    public function getFkAlmoxarifadoCentroCusto()
    {
        return $this->fkAlmoxarifadoCentroCusto;
    }
}
