<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * RegistroEventoFerias
 */
class RegistroEventoFerias
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
     * @var integer
     */
    private $codEvento;

    /**
     * PK
     * @var string
     */
    private $desdobramento;

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
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoFerias
     */
    private $fkFolhapagamentoUltimoRegistroEventoFerias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoFerias
     */
    private $fkFolhapagamentoReajusteRegistroEventoFerias;

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
        $this->fkFolhapagamentoReajusteRegistroEventoFerias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codRegistro
     *
     * @param integer $codRegistro
     * @return RegistroEventoFerias
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
     * @return RegistroEventoFerias
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
     * Set codEvento
     *
     * @param integer $codEvento
     * @return RegistroEventoFerias
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
     * Set desdobramento
     *
     * @param string $desdobramento
     * @return RegistroEventoFerias
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
     * Set codContrato
     *
     * @param integer $codContrato
     * @return RegistroEventoFerias
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
     * @return RegistroEventoFerias
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
     * @return RegistroEventoFerias
     */
    public function setValor($valor = null)
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
     * @return RegistroEventoFerias
     */
    public function setQuantidade($quantidade = null)
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
     * @return RegistroEventoFerias
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
     * Add FolhapagamentoReajusteRegistroEventoFerias
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoFerias $fkFolhapagamentoReajusteRegistroEventoFerias
     * @return RegistroEventoFerias
     */
    public function addFkFolhapagamentoReajusteRegistroEventoFerias(\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoFerias $fkFolhapagamentoReajusteRegistroEventoFerias)
    {
        if (false === $this->fkFolhapagamentoReajusteRegistroEventoFerias->contains($fkFolhapagamentoReajusteRegistroEventoFerias)) {
            $fkFolhapagamentoReajusteRegistroEventoFerias->setFkFolhapagamentoRegistroEventoFerias($this);
            $this->fkFolhapagamentoReajusteRegistroEventoFerias->add($fkFolhapagamentoReajusteRegistroEventoFerias);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoReajusteRegistroEventoFerias
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoFerias $fkFolhapagamentoReajusteRegistroEventoFerias
     */
    public function removeFkFolhapagamentoReajusteRegistroEventoFerias(\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoFerias $fkFolhapagamentoReajusteRegistroEventoFerias)
    {
        $this->fkFolhapagamentoReajusteRegistroEventoFerias->removeElement($fkFolhapagamentoReajusteRegistroEventoFerias);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoReajusteRegistroEventoFerias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoFerias
     */
    public function getFkFolhapagamentoReajusteRegistroEventoFerias()
    {
        return $this->fkFolhapagamentoReajusteRegistroEventoFerias;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento
     * @return RegistroEventoFerias
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
     * @return RegistroEventoFerias
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
     * Set FolhapagamentoUltimoRegistroEventoFerias
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoFerias $fkFolhapagamentoUltimoRegistroEventoFerias
     * @return RegistroEventoFerias
     */
    public function setFkFolhapagamentoUltimoRegistroEventoFerias(\Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoFerias $fkFolhapagamentoUltimoRegistroEventoFerias)
    {
        $fkFolhapagamentoUltimoRegistroEventoFerias->setFkFolhapagamentoRegistroEventoFerias($this);
        $this->fkFolhapagamentoUltimoRegistroEventoFerias = $fkFolhapagamentoUltimoRegistroEventoFerias;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoUltimoRegistroEventoFerias
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoFerias
     */
    public function getFkFolhapagamentoUltimoRegistroEventoFerias()
    {
        return $this->fkFolhapagamentoUltimoRegistroEventoFerias;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->fkFolhapagamentoEvento) {
            return (string) $this->getFkFolhapagamentoEvento();
        } else {
            return "Registro de Evento de Férias";
        }
    }
}
