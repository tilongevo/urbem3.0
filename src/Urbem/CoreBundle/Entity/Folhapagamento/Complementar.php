<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * Complementar
 */
class Complementar
{
    /**
     * PK
     * @var integer
     */
    private $codComplementar;

    /**
     * PK
     * @var integer
     */
    private $codPeriodoMovimentacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ComplementarSituacao
     */
    private $fkFolhapagamentoComplementarSituacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\DeducaoDependenteComplementar
     */
    private $fkFolhapagamentoDeducaoDependenteComplementares;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorComplementar
     */
    private $fkFolhapagamentoContratoServidorComplementares;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao
     */
    private $fkFolhapagamentoPeriodoMovimentacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoComplementarSituacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoDeducaoDependenteComplementares = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoContratoServidorComplementares = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codComplementar
     *
     * @param integer $codComplementar
     * @return Complementar
     */
    public function setCodComplementar($codComplementar)
    {
        $this->codComplementar = $codComplementar;
        return $this;
    }

    /**
     * Get codComplementar
     *
     * @return integer
     */
    public function getCodComplementar()
    {
        return $this->codComplementar;
    }

    /**
     * Set codPeriodoMovimentacao
     *
     * @param integer $codPeriodoMovimentacao
     * @return Complementar
     */
    public function setCodPeriodoMovimentacao($codPeriodoMovimentacao)
    {
        $this->codPeriodoMovimentacao = $codPeriodoMovimentacao;
        return $this;
    }

    /**
     * Get codPeriodoMovimentacao
     *
     * @return integer
     */
    public function getCodPeriodoMovimentacao()
    {
        return $this->codPeriodoMovimentacao;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoComplementarSituacao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ComplementarSituacao $fkFolhapagamentoComplementarSituacao
     * @return Complementar
     */
    public function addFkFolhapagamentoComplementarSituacoes(\Urbem\CoreBundle\Entity\Folhapagamento\ComplementarSituacao $fkFolhapagamentoComplementarSituacao)
    {
        if (false === $this->fkFolhapagamentoComplementarSituacoes->contains($fkFolhapagamentoComplementarSituacao)) {
            $fkFolhapagamentoComplementarSituacao->setFkFolhapagamentoComplementar($this);
            $this->fkFolhapagamentoComplementarSituacoes->add($fkFolhapagamentoComplementarSituacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoComplementarSituacao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ComplementarSituacao $fkFolhapagamentoComplementarSituacao
     */
    public function removeFkFolhapagamentoComplementarSituacoes(\Urbem\CoreBundle\Entity\Folhapagamento\ComplementarSituacao $fkFolhapagamentoComplementarSituacao)
    {
        $this->fkFolhapagamentoComplementarSituacoes->removeElement($fkFolhapagamentoComplementarSituacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoComplementarSituacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ComplementarSituacao
     */
    public function getFkFolhapagamentoComplementarSituacoes()
    {
        return $this->fkFolhapagamentoComplementarSituacoes;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoDeducaoDependenteComplementar
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\DeducaoDependenteComplementar $fkFolhapagamentoDeducaoDependenteComplementar
     * @return Complementar
     */
    public function addFkFolhapagamentoDeducaoDependenteComplementares(\Urbem\CoreBundle\Entity\Folhapagamento\DeducaoDependenteComplementar $fkFolhapagamentoDeducaoDependenteComplementar)
    {
        if (false === $this->fkFolhapagamentoDeducaoDependenteComplementares->contains($fkFolhapagamentoDeducaoDependenteComplementar)) {
            $fkFolhapagamentoDeducaoDependenteComplementar->setFkFolhapagamentoComplementar($this);
            $this->fkFolhapagamentoDeducaoDependenteComplementares->add($fkFolhapagamentoDeducaoDependenteComplementar);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoDeducaoDependenteComplementar
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\DeducaoDependenteComplementar $fkFolhapagamentoDeducaoDependenteComplementar
     */
    public function removeFkFolhapagamentoDeducaoDependenteComplementares(\Urbem\CoreBundle\Entity\Folhapagamento\DeducaoDependenteComplementar $fkFolhapagamentoDeducaoDependenteComplementar)
    {
        $this->fkFolhapagamentoDeducaoDependenteComplementares->removeElement($fkFolhapagamentoDeducaoDependenteComplementar);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoDeducaoDependenteComplementares
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\DeducaoDependenteComplementar
     */
    public function getFkFolhapagamentoDeducaoDependenteComplementares()
    {
        return $this->fkFolhapagamentoDeducaoDependenteComplementares;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoContratoServidorComplementar
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorComplementar $fkFolhapagamentoContratoServidorComplementar
     * @return Complementar
     */
    public function addFkFolhapagamentoContratoServidorComplementares(\Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorComplementar $fkFolhapagamentoContratoServidorComplementar)
    {
        if (false === $this->fkFolhapagamentoContratoServidorComplementares->contains($fkFolhapagamentoContratoServidorComplementar)) {
            $fkFolhapagamentoContratoServidorComplementar->setFkFolhapagamentoComplementar($this);
            $this->fkFolhapagamentoContratoServidorComplementares->add($fkFolhapagamentoContratoServidorComplementar);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoContratoServidorComplementar
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorComplementar $fkFolhapagamentoContratoServidorComplementar
     */
    public function removeFkFolhapagamentoContratoServidorComplementares(\Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorComplementar $fkFolhapagamentoContratoServidorComplementar)
    {
        $this->fkFolhapagamentoContratoServidorComplementares->removeElement($fkFolhapagamentoContratoServidorComplementar);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoContratoServidorComplementares
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorComplementar
     */
    public function getFkFolhapagamentoContratoServidorComplementares()
    {
        return $this->fkFolhapagamentoContratoServidorComplementares;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoPeriodoMovimentacao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao $fkFolhapagamentoPeriodoMovimentacao
     * @return Complementar
     */
    public function setFkFolhapagamentoPeriodoMovimentacao(\Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao $fkFolhapagamentoPeriodoMovimentacao)
    {
        $this->codPeriodoMovimentacao = $fkFolhapagamentoPeriodoMovimentacao->getCodPeriodoMovimentacao();
        $this->fkFolhapagamentoPeriodoMovimentacao = $fkFolhapagamentoPeriodoMovimentacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoPeriodoMovimentacao
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao
     */
    public function getFkFolhapagamentoPeriodoMovimentacao()
    {
        return $this->fkFolhapagamentoPeriodoMovimentacao;
    }

    public function __toString()
    {
        return "Erro";
    }
}
