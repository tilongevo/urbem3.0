<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * RegistroEventoDecimo
 */
class RegistroEventoDecimo
{
    /**
     * PK
     * @var integer
     */
    private $codRegistro;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var string
     */
    private $desdobramento;

    /**
     * PK
     * @var integer
     */
    private $codEvento;

    /**
     * @var integer
     */
    private $codContrato;

    /**
     * @var integer
     */
    private $codPeriodoMovimentacao;

    /**
     * @var integer
     */
    private $valor = 0;

    /**
     * @var integer
     */
    private $quantidade = 0;

    /**
     * @var boolean
     */
    private $automatico = false;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoDecimo
     */
    private $fkFolhapagamentoUltimoRegistroEventoDecimo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoDecimo
     */
    private $fkFolhapagamentoReajusteRegistroEventoDecimos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    private $fkFolhapagamentoEvento;

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
        $this->fkFolhapagamentoReajusteRegistroEventoDecimos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codRegistro
     *
     * @param integer $codRegistro
     * @return RegistroEventoDecimo
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return RegistroEventoDecimo
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
     * Set desdobramento
     *
     * @param string $desdobramento
     * @return RegistroEventoDecimo
     */
    public function setDesdobramento($desdobramento)
    {
        $this->desdobramento = $desdobramento;
        return $this;
    }

    /**
     * Get desdobramento
     *
     * @return string
     */
    public function getDesdobramento()
    {
        return $this->desdobramento;
    }

    /**
     * Set codEvento
     *
     * @param integer $codEvento
     * @return RegistroEventoDecimo
     */
    public function setCodEvento($codEvento)
    {
        $this->codEvento = $codEvento;
        return $this;
    }

    /**
     * Get codEvento
     *
     * @return integer
     */
    public function getCodEvento()
    {
        return $this->codEvento;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return RegistroEventoDecimo
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
     * @return RegistroEventoDecimo
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
     * Set valor
     *
     * @param integer $valor
     * @return RegistroEventoDecimo
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set quantidade
     *
     * @param integer $quantidade
     * @return RegistroEventoDecimo
     */
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
        return $this;
    }

    /**
     * Get quantidade
     *
     * @return integer
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * Set automatico
     *
     * @param boolean $automatico
     * @return RegistroEventoDecimo
     */
    public function setAutomatico($automatico)
    {
        $this->automatico = $automatico;
        return $this;
    }

    /**
     * Get automatico
     *
     * @return boolean
     */
    public function getAutomatico()
    {
        return $this->automatico;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoReajusteRegistroEventoDecimo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoDecimo $fkFolhapagamentoReajusteRegistroEventoDecimo
     * @return RegistroEventoDecimo
     */
    public function addFkFolhapagamentoReajusteRegistroEventoDecimos(\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoDecimo $fkFolhapagamentoReajusteRegistroEventoDecimo)
    {
        if (false === $this->fkFolhapagamentoReajusteRegistroEventoDecimos->contains($fkFolhapagamentoReajusteRegistroEventoDecimo)) {
            $fkFolhapagamentoReajusteRegistroEventoDecimo->setFkFolhapagamentoRegistroEventoDecimo($this);
            $this->fkFolhapagamentoReajusteRegistroEventoDecimos->add($fkFolhapagamentoReajusteRegistroEventoDecimo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoReajusteRegistroEventoDecimo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoDecimo $fkFolhapagamentoReajusteRegistroEventoDecimo
     */
    public function removeFkFolhapagamentoReajusteRegistroEventoDecimos(\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoDecimo $fkFolhapagamentoReajusteRegistroEventoDecimo)
    {
        $this->fkFolhapagamentoReajusteRegistroEventoDecimos->removeElement($fkFolhapagamentoReajusteRegistroEventoDecimo);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoReajusteRegistroEventoDecimos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoDecimo
     */
    public function getFkFolhapagamentoReajusteRegistroEventoDecimos()
    {
        return $this->fkFolhapagamentoReajusteRegistroEventoDecimos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento
     * @return RegistroEventoDecimo
     */
    public function setFkFolhapagamentoEvento(\Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento)
    {
        $this->codEvento = $fkFolhapagamentoEvento->getCodEvento();
        $this->fkFolhapagamentoEvento = $fkFolhapagamentoEvento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoEvento
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    public function getFkFolhapagamentoEvento()
    {
        return $this->fkFolhapagamentoEvento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoContratoServidorPeriodo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo $fkFolhapagamentoContratoServidorPeriodo
     * @return RegistroEventoDecimo
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

    /**
     * OneToOne (inverse side)
     * Set FolhapagamentoUltimoRegistroEventoDecimo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoDecimo $fkFolhapagamentoUltimoRegistroEventoDecimo
     * @return RegistroEventoDecimo
     */
    public function setFkFolhapagamentoUltimoRegistroEventoDecimo(\Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoDecimo $fkFolhapagamentoUltimoRegistroEventoDecimo)
    {
        $fkFolhapagamentoUltimoRegistroEventoDecimo->setFkFolhapagamentoRegistroEventoDecimo($this);
        $this->fkFolhapagamentoUltimoRegistroEventoDecimo = $fkFolhapagamentoUltimoRegistroEventoDecimo;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoUltimoRegistroEventoDecimo
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoDecimo
     */
    public function getFkFolhapagamentoUltimoRegistroEventoDecimo()
    {
        return $this->fkFolhapagamentoUltimoRegistroEventoDecimo;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->fkFolhapagamentoEvento) {
            return (string) $this->getFkFolhapagamentoEvento();
        } else {
            return "Registro de Evento 13° saláro";
        }
    }
}
