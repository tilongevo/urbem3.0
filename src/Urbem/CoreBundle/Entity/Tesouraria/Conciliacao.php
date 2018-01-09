<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Conciliacao
 */
class Conciliacao
{
    /**
     * PK
     * @var integer
     */
    private $codPlano;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $mes;

    /**
     * @var \DateTime
     */
    private $dtExtrato;

    /**
     * @var integer
     */
    private $vlExtrato;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoContabil
     */
    private $fkTesourariaConciliacaoLancamentoContabiis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoArrecadacao
     */
    private $fkTesourariaConciliacaoLancamentoArrecadacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoManual
     */
    private $fkTesourariaConciliacaoLancamentoManuais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoArrecadacaoEstornada
     */
    private $fkTesourariaConciliacaoLancamentoArrecadacaoEstornadas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoBanco
     */
    private $fkContabilidadePlanoBanco;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTesourariaConciliacaoLancamentoContabiis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaConciliacaoLancamentoArrecadacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaConciliacaoLancamentoManuais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaConciliacaoLancamentoArrecadacaoEstornadas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codPlano
     *
     * @param integer $codPlano
     * @return Conciliacao
     */
    public function setCodPlano($codPlano)
    {
        $this->codPlano = $codPlano;
        return $this;
    }

    /**
     * Get codPlano
     *
     * @return integer
     */
    public function getCodPlano()
    {
        return $this->codPlano;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Conciliacao
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
     * Set mes
     *
     * @param integer $mes
     * @return Conciliacao
     */
    public function setMes($mes)
    {
        $this->mes = $mes;
        return $this;
    }

    /**
     * Get mes
     *
     * @return integer
     */
    public function getMes()
    {
        return $this->mes;
    }

    /**
     * Set dtExtrato
     *
     * @param \DateTime $dtExtrato
     * @return Conciliacao
     */
    public function setDtExtrato(\DateTime $dtExtrato)
    {
        $this->dtExtrato = $dtExtrato;
        return $this;
    }

    /**
     * Get dtExtrato
     *
     * @return \DateTime
     */
    public function getDtExtrato()
    {
        return $this->dtExtrato;
    }

    /**
     * Set vlExtrato
     *
     * @param integer $vlExtrato
     * @return Conciliacao
     */
    public function setVlExtrato($vlExtrato)
    {
        $this->vlExtrato = $vlExtrato;
        return $this;
    }

    /**
     * Get vlExtrato
     *
     * @return integer
     */
    public function getVlExtrato()
    {
        return $this->vlExtrato;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return Conciliacao
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
     * OneToMany (owning side)
     * Add TesourariaConciliacaoLancamentoContabil
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoContabil $fkTesourariaConciliacaoLancamentoContabil
     * @return Conciliacao
     */
    public function addFkTesourariaConciliacaoLancamentoContabiis(\Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoContabil $fkTesourariaConciliacaoLancamentoContabil)
    {
        if (false === $this->fkTesourariaConciliacaoLancamentoContabiis->contains($fkTesourariaConciliacaoLancamentoContabil)) {
            $fkTesourariaConciliacaoLancamentoContabil->setFkTesourariaConciliacao($this);
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
     * Add TesourariaConciliacaoLancamentoArrecadacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoArrecadacao $fkTesourariaConciliacaoLancamentoArrecadacao
     * @return Conciliacao
     */
    public function addFkTesourariaConciliacaoLancamentoArrecadacoes(\Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoArrecadacao $fkTesourariaConciliacaoLancamentoArrecadacao)
    {
        if (false === $this->fkTesourariaConciliacaoLancamentoArrecadacoes->contains($fkTesourariaConciliacaoLancamentoArrecadacao)) {
            $fkTesourariaConciliacaoLancamentoArrecadacao->setFkTesourariaConciliacao($this);
            $this->fkTesourariaConciliacaoLancamentoArrecadacoes->add($fkTesourariaConciliacaoLancamentoArrecadacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaConciliacaoLancamentoArrecadacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoArrecadacao $fkTesourariaConciliacaoLancamentoArrecadacao
     */
    public function removeFkTesourariaConciliacaoLancamentoArrecadacoes(\Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoArrecadacao $fkTesourariaConciliacaoLancamentoArrecadacao)
    {
        $this->fkTesourariaConciliacaoLancamentoArrecadacoes->removeElement($fkTesourariaConciliacaoLancamentoArrecadacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaConciliacaoLancamentoArrecadacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoArrecadacao
     */
    public function getFkTesourariaConciliacaoLancamentoArrecadacoes()
    {
        return $this->fkTesourariaConciliacaoLancamentoArrecadacoes;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaConciliacaoLancamentoManual
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoManual $fkTesourariaConciliacaoLancamentoManual
     * @return Conciliacao
     */
    public function addFkTesourariaConciliacaoLancamentoManuais(\Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoManual $fkTesourariaConciliacaoLancamentoManual)
    {
        if (false === $this->fkTesourariaConciliacaoLancamentoManuais->contains($fkTesourariaConciliacaoLancamentoManual)) {
            $fkTesourariaConciliacaoLancamentoManual->setFkTesourariaConciliacao($this);
            $this->fkTesourariaConciliacaoLancamentoManuais->add($fkTesourariaConciliacaoLancamentoManual);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaConciliacaoLancamentoManual
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoManual $fkTesourariaConciliacaoLancamentoManual
     */
    public function removeFkTesourariaConciliacaoLancamentoManuais(\Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoManual $fkTesourariaConciliacaoLancamentoManual)
    {
        $this->fkTesourariaConciliacaoLancamentoManuais->removeElement($fkTesourariaConciliacaoLancamentoManual);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaConciliacaoLancamentoManuais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoManual
     */
    public function getFkTesourariaConciliacaoLancamentoManuais()
    {
        return $this->fkTesourariaConciliacaoLancamentoManuais;
    }

    /**
     * OneToMany (owning side)
     * Set fkTesourariaConciliacaoLancamentoManuais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoManual
     */
    public function setFkTesourariaConciliacaoLancamentoManuais(\Doctrine\Common\Collections\Collection $lancamentoManuais)
    {
        $this->fkTesourariaConciliacaoLancamentoManuais = $lancamentoManuais;
        return $this->fkTesourariaConciliacaoLancamentoManuais;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaConciliacaoLancamentoArrecadacaoEstornada
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoArrecadacaoEstornada $fkTesourariaConciliacaoLancamentoArrecadacaoEstornada
     * @return Conciliacao
     */
    public function addFkTesourariaConciliacaoLancamentoArrecadacaoEstornadas(\Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoArrecadacaoEstornada $fkTesourariaConciliacaoLancamentoArrecadacaoEstornada)
    {
        if (false === $this->fkTesourariaConciliacaoLancamentoArrecadacaoEstornadas->contains($fkTesourariaConciliacaoLancamentoArrecadacaoEstornada)) {
            $fkTesourariaConciliacaoLancamentoArrecadacaoEstornada->setFkTesourariaConciliacao($this);
            $this->fkTesourariaConciliacaoLancamentoArrecadacaoEstornadas->add($fkTesourariaConciliacaoLancamentoArrecadacaoEstornada);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaConciliacaoLancamentoArrecadacaoEstornada
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoArrecadacaoEstornada $fkTesourariaConciliacaoLancamentoArrecadacaoEstornada
     */
    public function removeFkTesourariaConciliacaoLancamentoArrecadacaoEstornadas(\Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoArrecadacaoEstornada $fkTesourariaConciliacaoLancamentoArrecadacaoEstornada)
    {
        $this->fkTesourariaConciliacaoLancamentoArrecadacaoEstornadas->removeElement($fkTesourariaConciliacaoLancamentoArrecadacaoEstornada);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaConciliacaoLancamentoArrecadacaoEstornadas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ConciliacaoLancamentoArrecadacaoEstornada
     */
    public function getFkTesourariaConciliacaoLancamentoArrecadacaoEstornadas()
    {
        return $this->fkTesourariaConciliacaoLancamentoArrecadacaoEstornadas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadePlanoBanco
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoBanco $fkContabilidadePlanoBanco
     * @return Conciliacao
     */
    public function setFkContabilidadePlanoBanco(\Urbem\CoreBundle\Entity\Contabilidade\PlanoBanco $fkContabilidadePlanoBanco)
    {
        $this->codPlano = $fkContabilidadePlanoBanco->getCodPlano();
        $this->exercicio = $fkContabilidadePlanoBanco->getExercicio();
        $this->fkContabilidadePlanoBanco = $fkContabilidadePlanoBanco;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadePlanoBanco
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoBanco
     */
    public function getFkContabilidadePlanoBanco()
    {
        return $this->fkContabilidadePlanoBanco;
    }
}
