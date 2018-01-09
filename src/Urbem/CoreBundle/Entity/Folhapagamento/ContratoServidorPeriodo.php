<?php

namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ContratoServidorPeriodo
 */
class ContratoServidorPeriodo
{
    /**
     * PK
     * @var integer
     */
    private $codPeriodoMovimentacao;

    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoDecimo
     */
    private $fkFolhapagamentoRegistroEventoDecimos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoRescisao
     */
    private $fkFolhapagamentoRegistroEventoRescisoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoFerias
     */
    private $fkFolhapagamentoRegistroEventoFerias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoPeriodo
     */
    private $fkFolhapagamentoRegistroEventoPeriodos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao
     */
    private $fkFolhapagamentoPeriodoMovimentacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Contrato
     */
    private $fkPessoalContrato;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoRegistroEventoDecimos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoRegistroEventoRescisoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoRegistroEventoFerias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoRegistroEventoPeriodos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codPeriodoMovimentacao
     *
     * @param integer $codPeriodoMovimentacao
     * @return ContratoServidorPeriodo
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
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ContratoServidorPeriodo
     */
    public function setCodContrato($codContrato)
    {
        $this->codContrato = $codContrato;
        return $this;
    }

    /**
     * Get codContrato
     *
     * @return integer
     */
    public function getCodContrato()
    {
        return $this->codContrato;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoRegistroEventoDecimo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoDecimo $fkFolhapagamentoRegistroEventoDecimo
     * @return ContratoServidorPeriodo
     */
    public function addFkFolhapagamentoRegistroEventoDecimos(\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoDecimo $fkFolhapagamentoRegistroEventoDecimo)
    {
        if (false === $this->fkFolhapagamentoRegistroEventoDecimos->contains($fkFolhapagamentoRegistroEventoDecimo)) {
            $fkFolhapagamentoRegistroEventoDecimo->setFkFolhapagamentoContratoServidorPeriodo($this);
            $this->fkFolhapagamentoRegistroEventoDecimos->add($fkFolhapagamentoRegistroEventoDecimo);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoRegistroEventoDecimo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoDecimo $fkFolhapagamentoRegistroEventoDecimo
     */
    public function removeFkFolhapagamentoRegistroEventoDecimos(\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoDecimo $fkFolhapagamentoRegistroEventoDecimo)
    {
        $this->fkFolhapagamentoRegistroEventoDecimos->removeElement($fkFolhapagamentoRegistroEventoDecimo);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoRegistroEventoDecimos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoDecimo
     */
    public function getFkFolhapagamentoRegistroEventoDecimos()
    {
        return $this->fkFolhapagamentoRegistroEventoDecimos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoRegistroEventoRescisao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoRescisao $fkFolhapagamentoRegistroEventoRescisao
     * @return ContratoServidorPeriodo
     */
    public function addFkFolhapagamentoRegistroEventoRescisoes(\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoRescisao $fkFolhapagamentoRegistroEventoRescisao)
    {
        if (false === $this->fkFolhapagamentoRegistroEventoRescisoes->contains($fkFolhapagamentoRegistroEventoRescisao)) {
            $fkFolhapagamentoRegistroEventoRescisao->setFkFolhapagamentoContratoServidorPeriodo($this);
            $this->fkFolhapagamentoRegistroEventoRescisoes->add($fkFolhapagamentoRegistroEventoRescisao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoRegistroEventoRescisao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoRescisao $fkFolhapagamentoRegistroEventoRescisao
     */
    public function removeFkFolhapagamentoRegistroEventoRescisoes(\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoRescisao $fkFolhapagamentoRegistroEventoRescisao)
    {
        $this->fkFolhapagamentoRegistroEventoRescisoes->removeElement($fkFolhapagamentoRegistroEventoRescisao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoRegistroEventoRescisoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoRescisao
     */
    public function getFkFolhapagamentoRegistroEventoRescisoes()
    {
        return $this->fkFolhapagamentoRegistroEventoRescisoes;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoRegistroEventoFerias
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoFerias $fkFolhapagamentoRegistroEventoFerias
     * @return ContratoServidorPeriodo
     */
    public function addFkFolhapagamentoRegistroEventoFerias(\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoFerias $fkFolhapagamentoRegistroEventoFerias)
    {
        if (false === $this->fkFolhapagamentoRegistroEventoFerias->contains($fkFolhapagamentoRegistroEventoFerias)) {
            $fkFolhapagamentoRegistroEventoFerias->setFkFolhapagamentoContratoServidorPeriodo($this);
            $this->fkFolhapagamentoRegistroEventoFerias->add($fkFolhapagamentoRegistroEventoFerias);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoRegistroEventoFerias
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoFerias $fkFolhapagamentoRegistroEventoFerias
     */
    public function removeFkFolhapagamentoRegistroEventoFerias(\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoFerias $fkFolhapagamentoRegistroEventoFerias)
    {
        $this->fkFolhapagamentoRegistroEventoFerias->removeElement($fkFolhapagamentoRegistroEventoFerias);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoRegistroEventoFerias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoFerias
     */
    public function getFkFolhapagamentoRegistroEventoFerias()
    {
        return $this->fkFolhapagamentoRegistroEventoFerias;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoRegistroEventoPeriodo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoPeriodo $fkFolhapagamentoRegistroEventoPeriodo
     * @return ContratoServidorPeriodo
     */
    public function addFkFolhapagamentoRegistroEventoPeriodos(\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoPeriodo $fkFolhapagamentoRegistroEventoPeriodo)
    {
        if (false === $this->fkFolhapagamentoRegistroEventoPeriodos->contains($fkFolhapagamentoRegistroEventoPeriodo)) {
            $fkFolhapagamentoRegistroEventoPeriodo->setFkFolhapagamentoContratoServidorPeriodo($this);
            $this->fkFolhapagamentoRegistroEventoPeriodos->add($fkFolhapagamentoRegistroEventoPeriodo);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoRegistroEventoPeriodo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoPeriodo $fkFolhapagamentoRegistroEventoPeriodo
     */
    public function removeFkFolhapagamentoRegistroEventoPeriodos(\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoPeriodo $fkFolhapagamentoRegistroEventoPeriodo)
    {
        $this->fkFolhapagamentoRegistroEventoPeriodos->removeElement($fkFolhapagamentoRegistroEventoPeriodo);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoRegistroEventoPeriodos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoPeriodo
     */
    public function getFkFolhapagamentoRegistroEventoPeriodos()
    {
        return $this->fkFolhapagamentoRegistroEventoPeriodos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoPeriodoMovimentacao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao $fkFolhapagamentoPeriodoMovimentacao
     * @return ContratoServidorPeriodo
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

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalContrato
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Contrato $fkPessoalContrato
     * @return ContratoServidorPeriodo
     */
    public function setFkPessoalContrato(\Urbem\CoreBundle\Entity\Pessoal\Contrato $fkPessoalContrato)
    {
        $this->codContrato = $fkPessoalContrato->getCodContrato();
        $this->fkPessoalContrato = $fkPessoalContrato;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalContrato
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Contrato
     */
    public function getFkPessoalContrato()
    {
        return $this->fkPessoalContrato;
    }


    /**
     * @return string|PeriodoMovimentacao
     */
    public function __toString()
    {
        return "Contrato por Evento";
    }
}
