<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * PrestacaoContas
 */
class PrestacaoContas
{
    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var string
     */
    private $tipo;

    /**
     * PK
     * @var integer
     */
    private $sequencia;

    /**
     * @var string
     */
    private $exercicioPrestacaoContas;

    /**
     * @var integer
     */
    private $codEmpenho;

    /**
     * @var integer
     */
    private $numItem;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\LancamentoEmpenho
     */
    private $fkContabilidadeLancamentoEmpenho;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\ItemPrestacaoContas
     */
    private $fkEmpenhoItemPrestacaoContas;


    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return PrestacaoContas
     */
    public function setCodLote($codLote)
    {
        $this->codLote = $codLote;
        return $this;
    }

    /**
     * Get codLote
     *
     * @return integer
     */
    public function getCodLote()
    {
        return $this->codLote;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return PrestacaoContas
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return PrestacaoContas
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
     * Set tipo
     *
     * @param string $tipo
     * @return PrestacaoContas
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
     * Set sequencia
     *
     * @param integer $sequencia
     * @return PrestacaoContas
     */
    public function setSequencia($sequencia)
    {
        $this->sequencia = $sequencia;
        return $this;
    }

    /**
     * Get sequencia
     *
     * @return integer
     */
    public function getSequencia()
    {
        return $this->sequencia;
    }

    /**
     * Set exercicioPrestacaoContas
     *
     * @param string $exercicioPrestacaoContas
     * @return PrestacaoContas
     */
    public function setExercicioPrestacaoContas($exercicioPrestacaoContas)
    {
        $this->exercicioPrestacaoContas = $exercicioPrestacaoContas;
        return $this;
    }

    /**
     * Get exercicioPrestacaoContas
     *
     * @return string
     */
    public function getExercicioPrestacaoContas()
    {
        return $this->exercicioPrestacaoContas;
    }

    /**
     * Set codEmpenho
     *
     * @param integer $codEmpenho
     * @return PrestacaoContas
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
     * Set numItem
     *
     * @param integer $numItem
     * @return PrestacaoContas
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
     * Set fkEmpenhoItemPrestacaoContas
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ItemPrestacaoContas $fkEmpenhoItemPrestacaoContas
     * @return PrestacaoContas
     */
    public function setFkEmpenhoItemPrestacaoContas(\Urbem\CoreBundle\Entity\Empenho\ItemPrestacaoContas $fkEmpenhoItemPrestacaoContas)
    {
        $this->numItem = $fkEmpenhoItemPrestacaoContas->getNumItem();
        $this->exercicioPrestacaoContas = $fkEmpenhoItemPrestacaoContas->getExercicio();
        $this->codEntidade = $fkEmpenhoItemPrestacaoContas->getCodEntidade();
        $this->codEmpenho = $fkEmpenhoItemPrestacaoContas->getCodEmpenho();
        $this->fkEmpenhoItemPrestacaoContas = $fkEmpenhoItemPrestacaoContas;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoItemPrestacaoContas
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\ItemPrestacaoContas
     */
    public function getFkEmpenhoItemPrestacaoContas()
    {
        return $this->fkEmpenhoItemPrestacaoContas;
    }

    /**
     * OneToOne (owning side)
     * Set ContabilidadeLancamentoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LancamentoEmpenho $fkContabilidadeLancamentoEmpenho
     * @return PrestacaoContas
     */
    public function setFkContabilidadeLancamentoEmpenho(\Urbem\CoreBundle\Entity\Contabilidade\LancamentoEmpenho $fkContabilidadeLancamentoEmpenho)
    {
        $this->codLote = $fkContabilidadeLancamentoEmpenho->getCodLote();
        $this->tipo = $fkContabilidadeLancamentoEmpenho->getTipo();
        $this->sequencia = $fkContabilidadeLancamentoEmpenho->getSequencia();
        $this->exercicio = $fkContabilidadeLancamentoEmpenho->getExercicio();
        $this->codEntidade = $fkContabilidadeLancamentoEmpenho->getCodEntidade();
        $this->fkContabilidadeLancamentoEmpenho = $fkContabilidadeLancamentoEmpenho;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkContabilidadeLancamentoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\LancamentoEmpenho
     */
    public function getFkContabilidadeLancamentoEmpenho()
    {
        return $this->fkContabilidadeLancamentoEmpenho;
    }
}
