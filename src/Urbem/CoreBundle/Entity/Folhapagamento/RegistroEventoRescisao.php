<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * RegistroEventoRescisao
 */
class RegistroEventoRescisao
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
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoRescisao
     */
    private $fkFolhapagamentoUltimoRegistroEventoRescisao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoRescisao
     */
    private $fkFolhapagamentoReajusteRegistroEventoRescisoes;

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
        $this->fkFolhapagamentoReajusteRegistroEventoRescisoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codRegistro
     *
     * @param integer $codRegistro
     * @return RegistroEventoRescisao
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
     * @return RegistroEventoRescisao
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
     * @return RegistroEventoRescisao
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
     * @return RegistroEventoRescisao
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
     * @return RegistroEventoRescisao
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
     * @return RegistroEventoRescisao
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
     * @return RegistroEventoRescisao
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
     * @return RegistroEventoRescisao
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
     * @return RegistroEventoRescisao
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
     * Add FolhapagamentoReajusteRegistroEventoRescisao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoRescisao $fkFolhapagamentoReajusteRegistroEventoRescisao
     * @return RegistroEventoRescisao
     */
    public function addFkFolhapagamentoReajusteRegistroEventoRescisoes(\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoRescisao $fkFolhapagamentoReajusteRegistroEventoRescisao)
    {
        if (false === $this->fkFolhapagamentoReajusteRegistroEventoRescisoes->contains($fkFolhapagamentoReajusteRegistroEventoRescisao)) {
            $fkFolhapagamentoReajusteRegistroEventoRescisao->setFkFolhapagamentoRegistroEventoRescisao($this);
            $this->fkFolhapagamentoReajusteRegistroEventoRescisoes->add($fkFolhapagamentoReajusteRegistroEventoRescisao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoReajusteRegistroEventoRescisao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoRescisao $fkFolhapagamentoReajusteRegistroEventoRescisao
     */
    public function removeFkFolhapagamentoReajusteRegistroEventoRescisoes(\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoRescisao $fkFolhapagamentoReajusteRegistroEventoRescisao)
    {
        $this->fkFolhapagamentoReajusteRegistroEventoRescisoes->removeElement($fkFolhapagamentoReajusteRegistroEventoRescisao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoReajusteRegistroEventoRescisoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoRescisao
     */
    public function getFkFolhapagamentoReajusteRegistroEventoRescisoes()
    {
        return $this->fkFolhapagamentoReajusteRegistroEventoRescisoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento
     * @return RegistroEventoRescisao
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
     * @return RegistroEventoRescisao
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
     * Set FolhapagamentoUltimoRegistroEventoRescisao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoRescisao $fkFolhapagamentoUltimoRegistroEventoRescisao
     * @return RegistroEventoRescisao
     */
    public function setFkFolhapagamentoUltimoRegistroEventoRescisao(\Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoRescisao $fkFolhapagamentoUltimoRegistroEventoRescisao)
    {
        $fkFolhapagamentoUltimoRegistroEventoRescisao->setFkFolhapagamentoRegistroEventoRescisao($this);
        $this->fkFolhapagamentoUltimoRegistroEventoRescisao = $fkFolhapagamentoUltimoRegistroEventoRescisao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoUltimoRegistroEventoRescisao
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoRescisao
     */
    public function getFkFolhapagamentoUltimoRegistroEventoRescisao()
    {
        return $this->fkFolhapagamentoUltimoRegistroEventoRescisao;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->fkFolhapagamentoEvento) {
            return (string) $this->getFkFolhapagamentoEvento();
        } else {
            return "Registro de Evento de Rescisão";
        }
    }
}
