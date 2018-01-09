<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ContratoServidorComplementar
 */
class ContratoServidorComplementar
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
    private $codComplementar;

    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoComplementar
     */
    private $fkFolhapagamentoRegistroEventoComplementares;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Complementar
     */
    private $fkFolhapagamentoComplementar;

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
        $this->fkFolhapagamentoRegistroEventoComplementares = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codPeriodoMovimentacao
     *
     * @param integer $codPeriodoMovimentacao
     * @return ContratoServidorComplementar
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
     * Set codComplementar
     *
     * @param integer $codComplementar
     * @return ContratoServidorComplementar
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
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ContratoServidorComplementar
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
     * Add FolhapagamentoRegistroEventoComplementar
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoComplementar $fkFolhapagamentoRegistroEventoComplementar
     * @return ContratoServidorComplementar
     */
    public function addFkFolhapagamentoRegistroEventoComplementares(\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoComplementar $fkFolhapagamentoRegistroEventoComplementar)
    {
        if (false === $this->fkFolhapagamentoRegistroEventoComplementares->contains($fkFolhapagamentoRegistroEventoComplementar)) {
            $fkFolhapagamentoRegistroEventoComplementar->setFkFolhapagamentoContratoServidorComplementar($this);
            $this->fkFolhapagamentoRegistroEventoComplementares->add($fkFolhapagamentoRegistroEventoComplementar);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoRegistroEventoComplementar
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoComplementar $fkFolhapagamentoRegistroEventoComplementar
     */
    public function removeFkFolhapagamentoRegistroEventoComplementares(\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoComplementar $fkFolhapagamentoRegistroEventoComplementar)
    {
        $this->fkFolhapagamentoRegistroEventoComplementares->removeElement($fkFolhapagamentoRegistroEventoComplementar);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoRegistroEventoComplementares
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoComplementar
     */
    public function getFkFolhapagamentoRegistroEventoComplementares()
    {
        return $this->fkFolhapagamentoRegistroEventoComplementares;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoComplementar
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Complementar $fkFolhapagamentoComplementar
     * @return ContratoServidorComplementar
     */
    public function setFkFolhapagamentoComplementar(\Urbem\CoreBundle\Entity\Folhapagamento\Complementar $fkFolhapagamentoComplementar)
    {
        $this->codComplementar = $fkFolhapagamentoComplementar->getCodComplementar();
        $this->codPeriodoMovimentacao = $fkFolhapagamentoComplementar->getCodPeriodoMovimentacao();
        $this->fkFolhapagamentoComplementar = $fkFolhapagamentoComplementar;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoComplementar
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\Complementar
     */
    public function getFkFolhapagamentoComplementar()
    {
        return $this->fkFolhapagamentoComplementar;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalContrato
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Contrato $fkPessoalContrato
     * @return ContratoServidorComplementar
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
     * @return string
     */
    public function __toString()
    {
        if ($this->fkPessoalContrato) {
            return (string) $this->fkPessoalContrato;
        } else {
            return "Evento na Complementar por Contrato";
        }
    }
}
