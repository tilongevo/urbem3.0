<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * RegistroEventoPeriodo
 */
class RegistroEventoPeriodo
{
    /**
     * PK
     * @var integer
     */
    private $codRegistro;

    /**
     * @var integer
     */
    private $codContrato;

    /**
     * @var integer
     */
    private $codPeriodoMovimentacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEvento
     */
    private $fkFolhapagamentoRegistroEventos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo
     */
    private $fkFolhapagamentoContratoServidorPeriodo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoRegistroEventos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codRegistro
     *
     * @param integer $codRegistro
     * @return RegistroEventoPeriodo
     */
    public function setCodRegistro($codRegistro)
    {
        $this->codRegistro = $codRegistro;
        return $this;
    }

    /**
     * Get codRegistro
     *
     * @return integer
     */
    public function getCodRegistro()
    {
        return $this->codRegistro;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return RegistroEventoPeriodo
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
     * Set codPeriodoMovimentacao
     *
     * @param integer $codPeriodoMovimentacao
     * @return RegistroEventoPeriodo
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
     * Add FolhapagamentoRegistroEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEvento $fkFolhapagamentoRegistroEvento
     * @return RegistroEventoPeriodo
     */
    public function addFkFolhapagamentoRegistroEventos(\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEvento $fkFolhapagamentoRegistroEvento)
    {
        if (false === $this->fkFolhapagamentoRegistroEventos->contains($fkFolhapagamentoRegistroEvento)) {
            $fkFolhapagamentoRegistroEvento->setFkFolhapagamentoRegistroEventoPeriodo($this);
            $this->fkFolhapagamentoRegistroEventos->add($fkFolhapagamentoRegistroEvento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoRegistroEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEvento $fkFolhapagamentoRegistroEvento
     */
    public function removeFkFolhapagamentoRegistroEventos(\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEvento $fkFolhapagamentoRegistroEvento)
    {
        $this->fkFolhapagamentoRegistroEventos->removeElement($fkFolhapagamentoRegistroEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoRegistroEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEvento
     */
    public function getFkFolhapagamentoRegistroEventos()
    {
        return $this->fkFolhapagamentoRegistroEventos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoContratoServidorPeriodo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo $fkFolhapagamentoContratoServidorPeriodo
     * @return RegistroEventoPeriodo
     */
    public function setFkFolhapagamentoContratoServidorPeriodo(\Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo $fkFolhapagamentoContratoServidorPeriodo)
    {
        $this->codPeriodoMovimentacao = $fkFolhapagamentoContratoServidorPeriodo->getCodPeriodoMovimentacao();
        $this->codContrato = $fkFolhapagamentoContratoServidorPeriodo->getCodContrato();
        $this->fkFolhapagamentoContratoServidorPeriodo = $fkFolhapagamentoContratoServidorPeriodo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoContratoServidorPeriodo
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo
     */
    public function getFkFolhapagamentoContratoServidorPeriodo()
    {
        return $this->fkFolhapagamentoContratoServidorPeriodo;
    }
}
