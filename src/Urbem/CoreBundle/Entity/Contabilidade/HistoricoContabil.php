<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * HistoricoContabil
 */
class HistoricoContabil
{
    /**
     * PK
     * @var integer
     */
    private $codHistorico;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $nomHistorico;

    /**
     * @var boolean
     */
    private $complemento;

    /**
     * @var boolean
     */
    private $historicoInterno = false;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Transferencia
     */
    private $fkTesourariaTransferencias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornada
     */
    private $fkTesourariaTransferenciaEstornadas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\Lancamento
     */
    private $fkContabilidadeLancamentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTesourariaTransferencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaTransferenciaEstornadas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadeLancamentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codHistorico
     *
     * @param integer $codHistorico
     * @return HistoricoContabil
     */
    public function setCodHistorico($codHistorico)
    {
        $this->codHistorico = $codHistorico;
        return $this;
    }

    /**
     * Get codHistorico
     *
     * @return integer
     */
    public function getCodHistorico()
    {
        return $this->codHistorico;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return HistoricoContabil
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
     * Set nomHistorico
     *
     * @param string $nomHistorico
     * @return HistoricoContabil
     */
    public function setNomHistorico($nomHistorico)
    {
        $this->nomHistorico = $nomHistorico;
        return $this;
    }

    /**
     * Get nomHistorico
     *
     * @return string
     */
    public function getNomHistorico()
    {
        return $this->nomHistorico;
    }

    /**
     * Set complemento
     *
     * @param boolean $complemento
     * @return HistoricoContabil
     */
    public function setComplemento($complemento)
    {
        $this->complemento = $complemento;
        return $this;
    }

    /**
     * Get complemento
     *
     * @return boolean
     */
    public function getComplemento()
    {
        return $this->complemento;
    }

    /**
     * Set historicoInterno
     *
     * @param boolean $historicoInterno
     * @return HistoricoContabil
     */
    public function setHistoricoInterno($historicoInterno)
    {
        $this->historicoInterno = $historicoInterno;
        return $this;
    }

    /**
     * Get historicoInterno
     *
     * @return boolean
     */
    public function getHistoricoInterno()
    {
        return $this->historicoInterno;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia
     * @return HistoricoContabil
     */
    public function addFkTesourariaTransferencias(\Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia)
    {
        if (false === $this->fkTesourariaTransferencias->contains($fkTesourariaTransferencia)) {
            $fkTesourariaTransferencia->setFkContabilidadeHistoricoContabil($this);
            $this->fkTesourariaTransferencias->add($fkTesourariaTransferencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia
     */
    public function removeFkTesourariaTransferencias(\Urbem\CoreBundle\Entity\Tesouraria\Transferencia $fkTesourariaTransferencia)
    {
        $this->fkTesourariaTransferencias->removeElement($fkTesourariaTransferencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaTransferencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Transferencia
     */
    public function getFkTesourariaTransferencias()
    {
        return $this->fkTesourariaTransferencias;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaTransferenciaEstornada
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornada $fkTesourariaTransferenciaEstornada
     * @return HistoricoContabil
     */
    public function addFkTesourariaTransferenciaEstornadas(\Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornada $fkTesourariaTransferenciaEstornada)
    {
        if (false === $this->fkTesourariaTransferenciaEstornadas->contains($fkTesourariaTransferenciaEstornada)) {
            $fkTesourariaTransferenciaEstornada->setFkContabilidadeHistoricoContabil($this);
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
     * Add ContabilidadeLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\Lancamento $fkContabilidadeLancamento
     * @return HistoricoContabil
     */
    public function addFkContabilidadeLancamentos(\Urbem\CoreBundle\Entity\Contabilidade\Lancamento $fkContabilidadeLancamento)
    {
        if (false === $this->fkContabilidadeLancamentos->contains($fkContabilidadeLancamento)) {
            $fkContabilidadeLancamento->setFkContabilidadeHistoricoContabil($this);
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
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->codHistorico, $this->nomHistorico);
    }
}
