<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * ValorLancamento
 */
class ValorLancamento
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
    private $tipo;

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
     * @var string
     */
    private $tipoValor;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * @var integer
     */
    private $vlLancamento;

    /**
     * @var integer
     */
    private $oidLancamento;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\ContaCredito
     */
    private $fkContabilidadeContaCredito;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\ContaDebito
     */
    private $fkContabilidadeContaDebito;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoContabil
     */
    private $fkTesourariaConciliacaoLancamentoContabiis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\ValorLancamentoRecurso
     */
    private $fkContabilidadeValorLancamentoRecursos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\Lancamento
     */
    private $fkContabilidadeLancamento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTesourariaConciliacaoLancamentoContabiis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadeValorLancamentoRecursos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return ValorLancamento
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
     * @return ValorLancamento
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
     * @return ValorLancamento
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
     * @return ValorLancamento
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
     * Set tipoValor
     *
     * @param string $tipoValor
     * @return ValorLancamento
     */
    public function setTipoValor($tipoValor)
    {
        $this->tipoValor = $tipoValor;
        return $this;
    }

    /**
     * Get tipoValor
     *
     * @return string
     */
    public function getTipoValor()
    {
        return $this->tipoValor;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return ValorLancamento
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
     * Set vlLancamento
     *
     * @param integer $vlLancamento
     * @return ValorLancamento
     */
    public function setVlLancamento($vlLancamento)
    {
        $this->vlLancamento = $vlLancamento;
        return $this;
    }

    /**
     * Get vlLancamento
     *
     * @return integer
     */
    public function getVlLancamento()
    {
        return $this->vlLancamento;
    }

    /**
     * Set oidLancamento
     *
     * @param integer $oidLancamento
     * @return ValorLancamento
     */
    public function setOidLancamento($oidLancamento)
    {
        $this->oidLancamento = $oidLancamento;
        return $this;
    }

    /**
     * Get oidLancamento
     *
     * @return integer
     */
    public function getOidLancamento()
    {
        return $this->oidLancamento;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaConciliacaoLancamentoContabil
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoContabil $fkTesourariaConciliacaoLancamentoContabil
     * @return ValorLancamento
     */
    public function addFkTesourariaConciliacaoLancamentoContabiis(\Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoContabil $fkTesourariaConciliacaoLancamentoContabil)
    {
        if (false === $this->fkTesourariaConciliacaoLancamentoContabiis->contains($fkTesourariaConciliacaoLancamentoContabil)) {
            $fkTesourariaConciliacaoLancamentoContabil->setFkContabilidadeValorLancamento($this);
            $this->fkTesourariaConciliacaoLancamentoContabiis->add($fkTesourariaConciliacaoLancamentoContabil);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaConciliacaoLancamentoContabil
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoContabil $fkTesourariaConciliacaoLancamentoContabil
     */
    public function removeFkTesourariaConciliacaoLancamentoContabiis(\Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoContabil $fkTesourariaConciliacaoLancamentoContabil)
    {
        $this->fkTesourariaConciliacaoLancamentoContabiis->removeElement($fkTesourariaConciliacaoLancamentoContabil);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaConciliacaoLancamentoContabiis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoContabil
     */
    public function getFkTesourariaConciliacaoLancamentoContabiis()
    {
        return $this->fkTesourariaConciliacaoLancamentoContabiis;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeValorLancamentoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ValorLancamentoRecurso $fkContabilidadeValorLancamentoRecurso
     * @return ValorLancamento
     */
    public function addFkContabilidadeValorLancamentoRecursos(\Urbem\CoreBundle\Entity\Contabilidade\ValorLancamentoRecurso $fkContabilidadeValorLancamentoRecurso)
    {
        if (false === $this->fkContabilidadeValorLancamentoRecursos->contains($fkContabilidadeValorLancamentoRecurso)) {
            $fkContabilidadeValorLancamentoRecurso->setFkContabilidadeValorLancamento($this);
            $this->fkContabilidadeValorLancamentoRecursos->add($fkContabilidadeValorLancamentoRecurso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeValorLancamentoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ValorLancamentoRecurso $fkContabilidadeValorLancamentoRecurso
     */
    public function removeFkContabilidadeValorLancamentoRecursos(\Urbem\CoreBundle\Entity\Contabilidade\ValorLancamentoRecurso $fkContabilidadeValorLancamentoRecurso)
    {
        $this->fkContabilidadeValorLancamentoRecursos->removeElement($fkContabilidadeValorLancamentoRecurso);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeValorLancamentoRecursos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\ValorLancamentoRecurso
     */
    public function getFkContabilidadeValorLancamentoRecursos()
    {
        return $this->fkContabilidadeValorLancamentoRecursos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadeLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\Lancamento $fkContabilidadeLancamento
     * @return ValorLancamento
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
     * OneToOne (inverse side)
     * Set ContabilidadeContaCredito
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ContaCredito $fkContabilidadeContaCredito
     * @return ValorLancamento
     */
    public function setFkContabilidadeContaCredito(\Urbem\CoreBundle\Entity\Contabilidade\ContaCredito $fkContabilidadeContaCredito)
    {
        $fkContabilidadeContaCredito->setFkContabilidadeValorLancamento($this);
        $this->fkContabilidadeContaCredito = $fkContabilidadeContaCredito;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkContabilidadeContaCredito
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\ContaCredito
     */
    public function getFkContabilidadeContaCredito()
    {
        return $this->fkContabilidadeContaCredito;
    }

    /**
     * OneToOne (inverse side)
     * Set ContabilidadeContaDebito
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ContaDebito $fkContabilidadeContaDebito
     * @return ValorLancamento
     */
    public function setFkContabilidadeContaDebito(\Urbem\CoreBundle\Entity\Contabilidade\ContaDebito $fkContabilidadeContaDebito)
    {
        $fkContabilidadeContaDebito->setFkContabilidadeValorLancamento($this);
        $this->fkContabilidadeContaDebito = $fkContabilidadeContaDebito;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkContabilidadeContaDebito
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\ContaDebito
     */
    public function getFkContabilidadeContaDebito()
    {
        return $this->fkContabilidadeContaDebito;
    }
}
