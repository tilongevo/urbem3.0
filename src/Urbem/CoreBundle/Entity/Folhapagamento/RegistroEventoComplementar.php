<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * RegistroEventoComplementar
 */
class RegistroEventoComplementar
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
     * @var integer
     */
    private $codConfiguracao;

    /**
     * @var integer
     */
    private $codContrato;

    /**
     * @var integer
     */
    private $codComplementar;

    /**
     * @var integer
     */
    private $codPeriodoMovimentacao;

    /**
     * @var integer
     */
    private $valor;

    /**
     * @var integer
     */
    private $quantidade;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoComplementar
     */
    private $fkFolhapagamentoUltimoRegistroEventoComplementar;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoComplementar
     */
    private $fkFolhapagamentoReajusteRegistroEventoComplementares;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    private $fkFolhapagamentoEvento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEvento
     */
    private $fkFolhapagamentoConfiguracaoEvento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorComplementar
     */
    private $fkFolhapagamentoContratoServidorComplementar;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoReajusteRegistroEventoComplementares = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codRegistro
     *
     * @param integer $codRegistro
     * @return RegistroEventoComplementar
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
     * @return RegistroEventoComplementar
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
     * @return RegistroEventoComplementar
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
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return RegistroEventoComplementar
     */
    public function setCodConfiguracao($codConfiguracao)
    {
        $this->codConfiguracao = $codConfiguracao;
        return $this;
    }

    /**
     * Get codConfiguracao
     *
     * @return integer
     */
    public function getCodConfiguracao()
    {
        return $this->codConfiguracao;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return RegistroEventoComplementar
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
     * Set codComplementar
     *
     * @param integer $codComplementar
     * @return RegistroEventoComplementar
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
     * @return RegistroEventoComplementar
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
     * @return RegistroEventoComplementar
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
     * @return RegistroEventoComplementar
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
     * OneToMany (owning side)
     * Add FolhapagamentoReajusteRegistroEventoComplementar
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoComplementar $fkFolhapagamentoReajusteRegistroEventoComplementar
     * @return RegistroEventoComplementar
     */
    public function addFkFolhapagamentoReajusteRegistroEventoComplementares(\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoComplementar $fkFolhapagamentoReajusteRegistroEventoComplementar)
    {
        if (false === $this->fkFolhapagamentoReajusteRegistroEventoComplementares->contains($fkFolhapagamentoReajusteRegistroEventoComplementar)) {
            $fkFolhapagamentoReajusteRegistroEventoComplementar->setFkFolhapagamentoRegistroEventoComplementar($this);
            $this->fkFolhapagamentoReajusteRegistroEventoComplementares->add($fkFolhapagamentoReajusteRegistroEventoComplementar);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoReajusteRegistroEventoComplementar
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoComplementar $fkFolhapagamentoReajusteRegistroEventoComplementar
     */
    public function removeFkFolhapagamentoReajusteRegistroEventoComplementares(\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoComplementar $fkFolhapagamentoReajusteRegistroEventoComplementar)
    {
        $this->fkFolhapagamentoReajusteRegistroEventoComplementares->removeElement($fkFolhapagamentoReajusteRegistroEventoComplementar);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoReajusteRegistroEventoComplementares
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoComplementar
     */
    public function getFkFolhapagamentoReajusteRegistroEventoComplementares()
    {
        return $this->fkFolhapagamentoReajusteRegistroEventoComplementares;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento
     * @return RegistroEventoComplementar
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
     * Set fkFolhapagamentoConfiguracaoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEvento $fkFolhapagamentoConfiguracaoEvento
     * @return RegistroEventoComplementar
     */
    public function setFkFolhapagamentoConfiguracaoEvento(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEvento $fkFolhapagamentoConfiguracaoEvento)
    {
        $this->codConfiguracao = $fkFolhapagamentoConfiguracaoEvento->getCodConfiguracao();
        $this->fkFolhapagamentoConfiguracaoEvento = $fkFolhapagamentoConfiguracaoEvento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoConfiguracaoEvento
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEvento
     */
    public function getFkFolhapagamentoConfiguracaoEvento()
    {
        return $this->fkFolhapagamentoConfiguracaoEvento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoContratoServidorComplementar
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorComplementar $fkFolhapagamentoContratoServidorComplementar
     * @return RegistroEventoComplementar
     */
    public function setFkFolhapagamentoContratoServidorComplementar(\Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorComplementar $fkFolhapagamentoContratoServidorComplementar)
    {
        $this->codPeriodoMovimentacao = $fkFolhapagamentoContratoServidorComplementar->getCodPeriodoMovimentacao();
        $this->codComplementar = $fkFolhapagamentoContratoServidorComplementar->getCodComplementar();
        $this->codContrato = $fkFolhapagamentoContratoServidorComplementar->getCodContrato();
        $this->fkFolhapagamentoContratoServidorComplementar = $fkFolhapagamentoContratoServidorComplementar;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoContratoServidorComplementar
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorComplementar
     */
    public function getFkFolhapagamentoContratoServidorComplementar()
    {
        return $this->fkFolhapagamentoContratoServidorComplementar;
    }

    /**
     * OneToOne (inverse side)
     * Set FolhapagamentoUltimoRegistroEventoComplementar
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoComplementar $fkFolhapagamentoUltimoRegistroEventoComplementar
     * @return RegistroEventoComplementar
     */
    public function setFkFolhapagamentoUltimoRegistroEventoComplementar(\Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoComplementar $fkFolhapagamentoUltimoRegistroEventoComplementar)
    {
        $fkFolhapagamentoUltimoRegistroEventoComplementar->setFkFolhapagamentoRegistroEventoComplementar($this);
        $this->fkFolhapagamentoUltimoRegistroEventoComplementar = $fkFolhapagamentoUltimoRegistroEventoComplementar;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoUltimoRegistroEventoComplementar
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoComplementar
     */
    public function getFkFolhapagamentoUltimoRegistroEventoComplementar()
    {
        return $this->fkFolhapagamentoUltimoRegistroEventoComplementar;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->fkFolhapagamentoEvento) {
            return sprintf('%s', $this->fkFolhapagamentoEvento);
        } else {
            return "Registro de Eventos Complementar";
        }
    }
}
