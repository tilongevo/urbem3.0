<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

use Urbem\FinanceiroBundle\Resources\config\Sonata\Contabilidade\LoteAdmin;

/**
 * Lote
 */
class Lote
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
    private $codEntidade;

    /**
     * @var string
     */
    private $nomLote;

    /**
     * @var \DateTime
     */
    private $dtLote;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Transferencia
     */
    private $fkTesourariaTransferencia;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberadoLote
     */
    private $fkTesourariaBoletimLiberadoLotes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornada
     */
    private $fkTesourariaTransferenciaEstornadas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\LoteNorma
     */
    private $fkContabilidadeLoteNormas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\Lancamento
     */
    private $fkContabilidadeLancamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\DoteProcessado
     */
    private $fkTesourariaDoteProcessados;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTesourariaBoletimLiberadoLotes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaTransferenciaEstornadas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadeLoteNormas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadeLancamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaDoteProcessados = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return Lote
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return Lote
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
     * @return Lote
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return Lote
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
     * Set nomLote
     *
     * @param string $nomLote
     * @return Lote
     */
    public function setNomLote($nomLote)
    {
        $this->nomLote = $nomLote;
        return $this;
    }

    /**
     * Get nomLote
     *
     * @return string
     */
    public function getNomLote()
    {
        return $this->nomLote;
    }

    /**
     * Set dtLote
     *
     * @param \DateTime $dtLote
     * @return Lote
     */
    public function setDtLote(\DateTime $dtLote)
    {
        $this->dtLote = $dtLote;
        return $this;
    }

    /**
     * Get dtLote
     *
     * @return \DateTime
     */
    public function getDtLote()
    {
        return $this->dtLote;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaBoletimLiberadoLote
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberadoLote $fkTesourariaBoletimLiberadoLote
     * @return Lote
     */
    public function addFkTesourariaBoletimLiberadoLotes(\Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberadoLote $fkTesourariaBoletimLiberadoLote)
    {
        if (false === $this->fkTesourariaBoletimLiberadoLotes->contains($fkTesourariaBoletimLiberadoLote)) {
            $fkTesourariaBoletimLiberadoLote->setFkContabilidadeLote($this);
            $this->fkTesourariaBoletimLiberadoLotes->add($fkTesourariaBoletimLiberadoLote);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaBoletimLiberadoLote
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberadoLote $fkTesourariaBoletimLiberadoLote
     */
    public function removeFkTesourariaBoletimLiberadoLotes(\Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberadoLote $fkTesourariaBoletimLiberadoLote)
    {
        $this->fkTesourariaBoletimLiberadoLotes->removeElement($fkTesourariaBoletimLiberadoLote);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaBoletimLiberadoLotes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberadoLote
     */
    public function getFkTesourariaBoletimLiberadoLotes()
    {
        return $this->fkTesourariaBoletimLiberadoLotes;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaTransferenciaEstornada
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornada $fkTesourariaTransferenciaEstornada
     * @return Lote
     */
    public function addFkTesourariaTransferenciaEstornadas(\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornada $fkTesourariaTransferenciaEstornada)
    {
        if (false === $this->fkTesourariaTransferenciaEstornadas->contains($fkTesourariaTransferenciaEstornada)) {
            $fkTesourariaTransferenciaEstornada->setFkContabilidadeLote($this);
            $this->fkTesourariaTransferenciaEstornadas->add($fkTesourariaTransferenciaEstornada);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaTransferenciaEstornada
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornada $fkTesourariaTransferenciaEstornada
     */
    public function removeFkTesourariaTransferenciaEstornadas(\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornada $fkTesourariaTransferenciaEstornada)
    {
        $this->fkTesourariaTransferenciaEstornadas->removeElement($fkTesourariaTransferenciaEstornada);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaTransferenciaEstornadas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornada
     */
    public function getFkTesourariaTransferenciaEstornadas()
    {
        return $this->fkTesourariaTransferenciaEstornadas;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeLoteNorma
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LoteNorma $fkContabilidadeLoteNorma
     * @return Lote
     */
    public function addFkContabilidadeLoteNormas(\Urbem\CoreBundle\Entity\Contabilidade\LoteNorma $fkContabilidadeLoteNorma)
    {
        if (false === $this->fkContabilidadeLoteNormas->contains($fkContabilidadeLoteNorma)) {
            $fkContabilidadeLoteNorma->setFkContabilidadeLote($this);
            $this->fkContabilidadeLoteNormas->add($fkContabilidadeLoteNorma);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeLoteNorma
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LoteNorma $fkContabilidadeLoteNorma
     */
    public function removeFkContabilidadeLoteNormas(\Urbem\CoreBundle\Entity\Contabilidade\LoteNorma $fkContabilidadeLoteNorma)
    {
        $this->fkContabilidadeLoteNormas->removeElement($fkContabilidadeLoteNorma);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeLoteNormas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\LoteNorma
     */
    public function getFkContabilidadeLoteNormas()
    {
        return $this->fkContabilidadeLoteNormas;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\Lancamento $fkContabilidadeLancamento
     * @return Lote
     */
    public function addFkContabilidadeLancamentos(\Urbem\CoreBundle\Entity\Contabilidade\Lancamento $fkContabilidadeLancamento)
    {
        if (false === $this->fkContabilidadeLancamentos->contains($fkContabilidadeLancamento)) {
            $fkContabilidadeLancamento->setFkContabilidadeLote($this);
            $this->fkContabilidadeLancamentos->add($fkContabilidadeLancamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\Lancamento $fkContabilidadeLancamento
     */
    public function removeFkContabilidadeLancamentos(\Urbem\CoreBundle\Entity\Contabilidade\Lancamento $fkContabilidadeLancamento)
    {
        $this->fkContabilidadeLancamentos->removeElement($fkContabilidadeLancamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeLancamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\Lancamento
     */
    public function getFkContabilidadeLancamentos()
    {
        return $this->fkContabilidadeLancamentos;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaDoteProcessado
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\DoteProcessado $fkTesourariaDoteProcessado
     * @return Lote
     */
    public function addFkTesourariaDoteProcessados(\Urbem\CoreBundle\Entity\Tesouraria\DoteProcessado $fkTesourariaDoteProcessado)
    {
        if (false === $this->fkTesourariaDoteProcessados->contains($fkTesourariaDoteProcessado)) {
            $fkTesourariaDoteProcessado->setFkContabilidadeLote($this);
            $this->fkTesourariaDoteProcessados->add($fkTesourariaDoteProcessado);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaDoteProcessado
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\DoteProcessado $fkTesourariaDoteProcessado
     */
    public function removeFkTesourariaDoteProcessados(\Urbem\CoreBundle\Entity\Tesouraria\DoteProcessado $fkTesourariaDoteProcessado)
    {
        $this->fkTesourariaDoteProcessados->removeElement($fkTesourariaDoteProcessado);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaDoteProcessados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\DoteProcessado
     */
    public function getFkTesourariaDoteProcessados()
    {
        return $this->fkTesourariaDoteProcessados;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return Lote
     */
    public function setFkOrcamentoEntidade(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
        $this->exercicio = $fkOrcamentoEntidade->getExercicio();
        $this->codEntidade = $fkOrcamentoEntidade->getCodEntidade();
        $this->fkOrcamentoEntidade = $fkOrcamentoEntidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoEntidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    public function getFkOrcamentoEntidade()
    {
        return $this->fkOrcamentoEntidade;
    }

    /**
     * OneToOne (inverse side)
     * Set TesourariaTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia
     * @return Lote
     */
    public function setFkTesourariaTransferencia(\Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia)
    {
        $fkTesourariaTransferencia->setFkContabilidadeLote($this);
        $this->fkTesourariaTransferencia = $fkTesourariaTransferencia;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTesourariaTransferencia
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\Transferencia
     */
    public function getFkTesourariaTransferencia()
    {
        return $this->fkTesourariaTransferencia;
    }

    /**
     * @return float
     */
    public function getTotaisDebito()
    {
        $total = 0.00;
        foreach ($this->fkContabilidadeLancamentos as $fkContabilidadeLancamento) {
            foreach ($fkContabilidadeLancamento->getFkContabilidadeValorLancamentos() as $fkContabilidadeValorLancamento) {
                if ($fkContabilidadeValorLancamento->getTipoValor() == LoteAdmin::TYPE_DEBITO) {
                    $total += (float) $fkContabilidadeValorLancamento->getVlLancamento();
                }
            }
        }
        return $total;
    }

    /**
     * @return float
     */
    public function getTotaisCredito()
    {
        $total = 0.00;
        foreach ($this->fkContabilidadeLancamentos as $fkContabilidadeLancamento) {
            foreach ($fkContabilidadeLancamento->getFkContabilidadeValorLancamentos() as $fkContabilidadeValorLancamento) {
                if ($fkContabilidadeValorLancamento->getTipoValor() == LoteAdmin::TYPE_CREDITO) {
                    $total += (float) $fkContabilidadeValorLancamento->getVlLancamento();
                }
            }
        }
        return $total;
    }

    /**
     * @return float
     */
    public function getDiferenca()
    {
        return $this->getTotaisDebito() + $this->getTotaisCredito();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s/%s', $this->codLote, $this->exercicio);
    }
}
