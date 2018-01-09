<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * TipoTransferencia
 */
class TipoTransferencia
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $nomTipo;

    /**
     * @var boolean
     */
    private $lancamentoContabil;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\Suplementacao
     */
    private $fkOrcamentoSuplementacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcerj\TipoAlteracao
     */
    private $fkTcerjTipoAlteracoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\LancamentoTransferencia
     */
    private $fkContabilidadeLancamentoTransferencias;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkOrcamentoSuplementacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcerjTipoAlteracoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadeLancamentoTransferencias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoTransferencia
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return TipoTransferencia
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
     * Set nomTipo
     *
     * @param string $nomTipo
     * @return TipoTransferencia
     */
    public function setNomTipo($nomTipo)
    {
        $this->nomTipo = $nomTipo;
        return $this;
    }

    /**
     * Get nomTipo
     *
     * @return string
     */
    public function getNomTipo()
    {
        return $this->nomTipo;
    }

    /**
     * Set lancamentoContabil
     *
     * @param boolean $lancamentoContabil
     * @return TipoTransferencia
     */
    public function setLancamentoContabil($lancamentoContabil)
    {
        $this->lancamentoContabil = $lancamentoContabil;
        return $this;
    }

    /**
     * Get lancamentoContabil
     *
     * @return boolean
     */
    public function getLancamentoContabil()
    {
        return $this->lancamentoContabil;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoSuplementacao
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Suplementacao $fkOrcamentoSuplementacao
     * @return TipoTransferencia
     */
    public function addFkOrcamentoSuplementacoes(\Urbem\CoreBundle\Entity\Orcamento\Suplementacao $fkOrcamentoSuplementacao)
    {
        if (false === $this->fkOrcamentoSuplementacoes->contains($fkOrcamentoSuplementacao)) {
            $fkOrcamentoSuplementacao->setFkContabilidadeTipoTransferencia($this);
            $this->fkOrcamentoSuplementacoes->add($fkOrcamentoSuplementacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoSuplementacao
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Suplementacao $fkOrcamentoSuplementacao
     */
    public function removeFkOrcamentoSuplementacoes(\Urbem\CoreBundle\Entity\Orcamento\Suplementacao $fkOrcamentoSuplementacao)
    {
        $this->fkOrcamentoSuplementacoes->removeElement($fkOrcamentoSuplementacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoSuplementacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\Suplementacao
     */
    public function getFkOrcamentoSuplementacoes()
    {
        return $this->fkOrcamentoSuplementacoes;
    }

    /**
     * OneToMany (owning side)
     * Add TcerjTipoAlteracao
     *
     * @param \Urbem\CoreBundle\Entity\Tcerj\TipoAlteracao $fkTcerjTipoAlteracao
     * @return TipoTransferencia
     */
    public function addFkTcerjTipoAlteracoes(\Urbem\CoreBundle\Entity\Tcerj\TipoAlteracao $fkTcerjTipoAlteracao)
    {
        if (false === $this->fkTcerjTipoAlteracoes->contains($fkTcerjTipoAlteracao)) {
            $fkTcerjTipoAlteracao->setFkContabilidadeTipoTransferencia($this);
            $this->fkTcerjTipoAlteracoes->add($fkTcerjTipoAlteracao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcerjTipoAlteracao
     *
     * @param \Urbem\CoreBundle\Entity\Tcerj\TipoAlteracao $fkTcerjTipoAlteracao
     */
    public function removeFkTcerjTipoAlteracoes(\Urbem\CoreBundle\Entity\Tcerj\TipoAlteracao $fkTcerjTipoAlteracao)
    {
        $this->fkTcerjTipoAlteracoes->removeElement($fkTcerjTipoAlteracao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcerjTipoAlteracoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcerj\TipoAlteracao
     */
    public function getFkTcerjTipoAlteracoes()
    {
        return $this->fkTcerjTipoAlteracoes;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadeLancamentoTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LancamentoTransferencia $fkContabilidadeLancamentoTransferencia
     * @return TipoTransferencia
     */
    public function addFkContabilidadeLancamentoTransferencias(\Urbem\CoreBundle\Entity\Contabilidade\LancamentoTransferencia $fkContabilidadeLancamentoTransferencia)
    {
        if (false === $this->fkContabilidadeLancamentoTransferencias->contains($fkContabilidadeLancamentoTransferencia)) {
            $fkContabilidadeLancamentoTransferencia->setFkContabilidadeTipoTransferencia($this);
            $this->fkContabilidadeLancamentoTransferencias->add($fkContabilidadeLancamentoTransferencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadeLancamentoTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LancamentoTransferencia $fkContabilidadeLancamentoTransferencia
     */
    public function removeFkContabilidadeLancamentoTransferencias(\Urbem\CoreBundle\Entity\Contabilidade\LancamentoTransferencia $fkContabilidadeLancamentoTransferencia)
    {
        $this->fkContabilidadeLancamentoTransferencias->removeElement($fkContabilidadeLancamentoTransferencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadeLancamentoTransferencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\LancamentoTransferencia
     */
    public function getFkContabilidadeLancamentoTransferencias()
    {
        return $this->fkContabilidadeLancamentoTransferencias;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->nomTipo;
    }
}
