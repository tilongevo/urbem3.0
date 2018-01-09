<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * ItemPrestacaoContas
 */
class ItemPrestacaoContas
{
    /**
     * PK
     * @var integer
     */
    private $numItem;

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
    private $codEmpenho;

    /**
     * @var string
     */
    private $exercicioConta;

    /**
     * @var integer
     */
    private $contaContrapartida;

    /**
     * @var integer
     */
    private $codDocumento;

    /**
     * @var integer
     */
    private $numDocumento;

    /**
     * @var \DateTime
     */
    private $dataItem;

    /**
     * @var integer
     */
    private $valorItem;

    /**
     * @var string
     */
    private $justificativa;

    /**
     * @var string
     */
    private $credor;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Empenho\ItemPrestacaoContasAnulado
     */
    private $fkEmpenhoItemPrestacaoContasAnulado;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\PrestacaoContas
     */
    private $fkContabilidadePrestacaoContas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\PrestacaoContas
     */
    private $fkEmpenhoPrestacaoContas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\ContrapartidaResponsavel
     */
    private $fkEmpenhoContrapartidaResponsavel;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\TipoDocumento
     */
    private $fkEmpenhoTipoDocumento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkContabilidadePrestacaoContas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set numItem
     *
     * @param integer $numItem
     * @return ItemPrestacaoContas
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return ItemPrestacaoContas
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
     * @return ItemPrestacaoContas
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
     * Set codEmpenho
     *
     * @param integer $codEmpenho
     * @return ItemPrestacaoContas
     */
    public function setCodEmpenho($codEmpenho)
    {
        $this->codEmpenho = $codEmpenho;
        return $this;
    }

    /**
     * Get codEmpenho
     *
     * @return integer
     */
    public function getCodEmpenho()
    {
        return $this->codEmpenho;
    }

    /**
     * Set exercicioConta
     *
     * @param string $exercicioConta
     * @return ItemPrestacaoContas
     */
    public function setExercicioConta($exercicioConta)
    {
        $this->exercicioConta = $exercicioConta;
        return $this;
    }

    /**
     * Get exercicioConta
     *
     * @return string
     */
    public function getExercicioConta()
    {
        return $this->exercicioConta;
    }

    /**
     * Set contaContrapartida
     *
     * @param integer $contaContrapartida
     * @return ItemPrestacaoContas
     */
    public function setContaContrapartida($contaContrapartida)
    {
        $this->contaContrapartida = $contaContrapartida;
        return $this;
    }

    /**
     * Get contaContrapartida
     *
     * @return integer
     */
    public function getContaContrapartida()
    {
        return $this->contaContrapartida;
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return ItemPrestacaoContas
     */
    public function setCodDocumento($codDocumento)
    {
        $this->codDocumento = $codDocumento;
        return $this;
    }

    /**
     * Get codDocumento
     *
     * @return integer
     */
    public function getCodDocumento()
    {
        return $this->codDocumento;
    }

    /**
     * Set numDocumento
     *
     * @param integer $numDocumento
     * @return ItemPrestacaoContas
     */
    public function setNumDocumento($numDocumento = null)
    {
        $this->numDocumento = $numDocumento;
        return $this;
    }

    /**
     * Get numDocumento
     *
     * @return integer
     */
    public function getNumDocumento()
    {
        return $this->numDocumento;
    }

    /**
     * Set dataItem
     *
     * @param \DateTime $dataItem
     * @return ItemPrestacaoContas
     */
    public function setDataItem(\DateTime $dataItem)
    {
        $this->dataItem = $dataItem;
        return $this;
    }

    /**
     * Get dataItem
     *
     * @return \DateTime
     */
    public function getDataItem()
    {
        return $this->dataItem;
    }

    /**
     * Set valorItem
     *
     * @param integer $valorItem
     * @return ItemPrestacaoContas
     */
    public function setValorItem($valorItem = null)
    {
        $this->valorItem = $valorItem;
        return $this;
    }

    /**
     * Get valorItem
     *
     * @return integer
     */
    public function getValorItem()
    {
        return $this->valorItem;
    }

    /**
     * Set justificativa
     *
     * @param string $justificativa
     * @return ItemPrestacaoContas
     */
    public function setJustificativa($justificativa)
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
     * Set credor
     *
     * @param string $credor
     * @return ItemPrestacaoContas
     */
    public function setCredor($credor)
    {
        $this->credor = $credor;
        return $this;
    }

    /**
     * Get credor
     *
     * @return string
     */
    public function getCredor()
    {
        return $this->credor;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadePrestacaoContas
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PrestacaoContas $fkContabilidadePrestacaoContas
     * @return ItemPrestacaoContas
     */
    public function addFkContabilidadePrestacaoContas(\Urbem\CoreBundle\Entity\Contabilidade\PrestacaoContas $fkContabilidadePrestacaoContas)
    {
        if (false === $this->fkContabilidadePrestacaoContas->contains($fkContabilidadePrestacaoContas)) {
            $fkContabilidadePrestacaoContas->setFkEmpenhoItemPrestacaoContas($this);
            $this->fkContabilidadePrestacaoContas->add($fkContabilidadePrestacaoContas);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadePrestacaoContas
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PrestacaoContas $fkContabilidadePrestacaoContas
     */
    public function removeFkContabilidadePrestacaoContas(\Urbem\CoreBundle\Entity\Contabilidade\PrestacaoContas $fkContabilidadePrestacaoContas)
    {
        $this->fkContabilidadePrestacaoContas->removeElement($fkContabilidadePrestacaoContas);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadePrestacaoContas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\PrestacaoContas
     */
    public function getFkContabilidadePrestacaoContas()
    {
        return $this->fkContabilidadePrestacaoContas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoPrestacaoContas
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\PrestacaoContas $fkEmpenhoPrestacaoContas
     * @return ItemPrestacaoContas
     */
    public function setFkEmpenhoPrestacaoContas(\Urbem\CoreBundle\Entity\Empenho\PrestacaoContas $fkEmpenhoPrestacaoContas)
    {
        $this->codEmpenho = $fkEmpenhoPrestacaoContas->getCodEmpenho();
        $this->codEntidade = $fkEmpenhoPrestacaoContas->getCodEntidade();
        $this->exercicio = $fkEmpenhoPrestacaoContas->getExercicio();
        $this->fkEmpenhoPrestacaoContas = $fkEmpenhoPrestacaoContas;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoPrestacaoContas
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\PrestacaoContas
     */
    public function getFkEmpenhoPrestacaoContas()
    {
        return $this->fkEmpenhoPrestacaoContas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoContrapartidaResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ContrapartidaResponsavel $fkEmpenhoContrapartidaResponsavel
     * @return ItemPrestacaoContas
     */
    public function setFkEmpenhoContrapartidaResponsavel(\Urbem\CoreBundle\Entity\Empenho\ContrapartidaResponsavel $fkEmpenhoContrapartidaResponsavel)
    {
        $this->exercicioConta = $fkEmpenhoContrapartidaResponsavel->getExercicio();
        $this->contaContrapartida = $fkEmpenhoContrapartidaResponsavel->getContaContrapartida();
        $this->fkEmpenhoContrapartidaResponsavel = $fkEmpenhoContrapartidaResponsavel;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoContrapartidaResponsavel
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\ContrapartidaResponsavel
     */
    public function getFkEmpenhoContrapartidaResponsavel()
    {
        return $this->fkEmpenhoContrapartidaResponsavel;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoTipoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\TipoDocumento $fkEmpenhoTipoDocumento
     * @return ItemPrestacaoContas
     */
    public function setFkEmpenhoTipoDocumento(\Urbem\CoreBundle\Entity\Empenho\TipoDocumento $fkEmpenhoTipoDocumento)
    {
        $this->codDocumento = $fkEmpenhoTipoDocumento->getCodDocumento();
        $this->fkEmpenhoTipoDocumento = $fkEmpenhoTipoDocumento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoTipoDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\TipoDocumento
     */
    public function getFkEmpenhoTipoDocumento()
    {
        return $this->fkEmpenhoTipoDocumento;
    }

    /**
     * OneToOne (inverse side)
     * Set EmpenhoItemPrestacaoContasAnulado
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ItemPrestacaoContasAnulado $fkEmpenhoItemPrestacaoContasAnulado
     * @return ItemPrestacaoContas
     */
    public function setFkEmpenhoItemPrestacaoContasAnulado(\Urbem\CoreBundle\Entity\Empenho\ItemPrestacaoContasAnulado $fkEmpenhoItemPrestacaoContasAnulado)
    {
        $fkEmpenhoItemPrestacaoContasAnulado->setFkEmpenhoItemPrestacaoContas($this);
        $this->fkEmpenhoItemPrestacaoContasAnulado = $fkEmpenhoItemPrestacaoContasAnulado;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEmpenhoItemPrestacaoContasAnulado
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\ItemPrestacaoContasAnulado
     */
    public function getFkEmpenhoItemPrestacaoContasAnulado()
    {
        return $this->fkEmpenhoItemPrestacaoContasAnulado;
    }
}
