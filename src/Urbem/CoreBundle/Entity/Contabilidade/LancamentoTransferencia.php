<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * LancamentoTransferencia
 */
class LancamentoTransferencia
{
    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * PK
     * @var string
     */
    private $tipo = 'C';

    /**
     * PK
     * @var integer
     */
    private $sequencia;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * @var boolean
     */
    private $estorno = false;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\TransferenciaDespesa
     */
    private $fkContabilidadeTransferenciaDespesas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\TransferenciaReceita
     */
    private $fkContabilidadeTransferenciaReceitas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\Lancamento
     */
    private $fkContabilidadeLancamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\TipoTransferencia
     */
    private $fkContabilidadeTipoTransferencia;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkContabilidadeTransferenciaDespesas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadeTransferenciaReceitas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return LancamentoTransferencia
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
     * Set tipo
     *
     * @param string $tipo
     * @return LancamentoTransferencia
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
     * @return LancamentoTransferencia
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return LancamentoTransferencia
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return LancamentoTransferencia
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return LancamentoTransferencia
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
     * Set estorno
     *
     * @param boolean $estorno
     * @return LancamentoTransferencia
     */
    public function setEstorno($estorno)
    {
        $this->estorno = $estorno;
        return $this;
    }

    /**
     * Get estorno
     *
     * @return boolean
     */
    public function getEstorno()
    {
        return $this->estorno;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeTransferenciaDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\TransferenciaDespesa $fkContabilidadeTransferenciaDespesa
     * @return LancamentoTransferencia
     */
    public function addFkContabilidadeTransferenciaDespesas(\Urbem\CoreBundle\Entity\Contabilidade\TransferenciaDespesa $fkContabilidadeTransferenciaDespesa)
    {
        if (false === $this->fkContabilidadeTransferenciaDespesas->contains($fkContabilidadeTransferenciaDespesa)) {
            $fkContabilidadeTransferenciaDespesa->setFkContabilidadeLancamentoTransferencia($this);
            $this->fkContabilidadeTransferenciaDespesas->add($fkContabilidadeTransferenciaDespesa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeTransferenciaDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\TransferenciaDespesa $fkContabilidadeTransferenciaDespesa
     */
    public function removeFkContabilidadeTransferenciaDespesas(\Urbem\CoreBundle\Entity\Contabilidade\TransferenciaDespesa $fkContabilidadeTransferenciaDespesa)
    {
        $this->fkContabilidadeTransferenciaDespesas->removeElement($fkContabilidadeTransferenciaDespesa);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeTransferenciaDespesas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\TransferenciaDespesa
     */
    public function getFkContabilidadeTransferenciaDespesas()
    {
        return $this->fkContabilidadeTransferenciaDespesas;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeTransferenciaReceita
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\TransferenciaReceita $fkContabilidadeTransferenciaReceita
     * @return LancamentoTransferencia
     */
    public function addFkContabilidadeTransferenciaReceitas(\Urbem\CoreBundle\Entity\Contabilidade\TransferenciaReceita $fkContabilidadeTransferenciaReceita)
    {
        if (false === $this->fkContabilidadeTransferenciaReceitas->contains($fkContabilidadeTransferenciaReceita)) {
            $fkContabilidadeTransferenciaReceita->setFkContabilidadeLancamentoTransferencia($this);
            $this->fkContabilidadeTransferenciaReceitas->add($fkContabilidadeTransferenciaReceita);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeTransferenciaReceita
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\TransferenciaReceita $fkContabilidadeTransferenciaReceita
     */
    public function removeFkContabilidadeTransferenciaReceitas(\Urbem\CoreBundle\Entity\Contabilidade\TransferenciaReceita $fkContabilidadeTransferenciaReceita)
    {
        $this->fkContabilidadeTransferenciaReceitas->removeElement($fkContabilidadeTransferenciaReceita);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeTransferenciaReceitas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\TransferenciaReceita
     */
    public function getFkContabilidadeTransferenciaReceitas()
    {
        return $this->fkContabilidadeTransferenciaReceitas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadeLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\Lancamento $fkContabilidadeLancamento
     * @return LancamentoTransferencia
     */
    public function setFkContabilidadeLancamento(\Urbem\CoreBundle\Entity\Contabilidade\Lancamento $fkContabilidadeLancamento)
    {
        $this->sequencia = $fkContabilidadeLancamento->getSequencia();
        $this->codLote = $fkContabilidadeLancamento->getCodLote();
        $this->tipo = $fkContabilidadeLancamento->getTipo();
        $this->exercicio = $fkContabilidadeLancamento->getExercicio();
        $this->codEntidade = $fkContabilidadeLancamento->getCodEntidade();
        $this->fkContabilidadeLancamento = $fkContabilidadeLancamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadeLancamento
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\Lancamento
     */
    public function getFkContabilidadeLancamento()
    {
        return $this->fkContabilidadeLancamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadeTipoTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\TipoTransferencia $fkContabilidadeTipoTransferencia
     * @return LancamentoTransferencia
     */
    public function setFkContabilidadeTipoTransferencia(\Urbem\CoreBundle\Entity\Contabilidade\TipoTransferencia $fkContabilidadeTipoTransferencia)
    {
        $this->codTipo = $fkContabilidadeTipoTransferencia->getCodTipo();
        $this->exercicio = $fkContabilidadeTipoTransferencia->getExercicio();
        $this->fkContabilidadeTipoTransferencia = $fkContabilidadeTipoTransferencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadeTipoTransferencia
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\TipoTransferencia
     */
    public function getFkContabilidadeTipoTransferencia()
    {
        return $this->fkContabilidadeTipoTransferencia;
    }
}
