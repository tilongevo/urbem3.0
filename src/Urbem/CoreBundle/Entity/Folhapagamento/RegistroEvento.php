<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * RegistroEvento
 */
class RegistroEvento
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
     * @var integer
     */
    private $valor;

    /**
     * @var integer
     */
    private $quantidade;

    /**
     * @var boolean
     */
    private $proporcional = false;

    /**
     * @var boolean
     */
    private $automatico = false;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEvento
     */
    private $fkFolhapagamentoUltimoRegistroEvento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEvento
     */
    private $fkFolhapagamentoReajusteRegistroEventos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoPeriodo
     */
    private $fkFolhapagamentoRegistroEventoPeriodo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    private $fkFolhapagamentoEvento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoReajusteRegistroEventos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codRegistro
     *
     * @param integer $codRegistro
     * @return RegistroEvento
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
     * @return RegistroEvento
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
     * @return RegistroEvento
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
     * Set valor
     *
     * @param integer $valor
     * @return RegistroEvento
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
     * @return RegistroEvento
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
     * Set proporcional
     *
     * @param boolean $proporcional
     * @return RegistroEvento
     */
    public function setProporcional($proporcional)
    {
        $this->proporcional = $proporcional;
        return $this;
    }

    /**
     * Get proporcional
     *
     * @return boolean
     */
    public function getProporcional()
    {
        return $this->proporcional;
    }

    /**
     * Set automatico
     *
     * @param boolean $automatico
     * @return RegistroEvento
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
     * Add FolhapagamentoReajusteRegistroEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEvento $fkFolhapagamentoReajusteRegistroEvento
     * @return RegistroEvento
     */
    public function addFkFolhapagamentoReajusteRegistroEventos(\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEvento $fkFolhapagamentoReajusteRegistroEvento)
    {
        if (false === $this->fkFolhapagamentoReajusteRegistroEventos->contains($fkFolhapagamentoReajusteRegistroEvento)) {
            $fkFolhapagamentoReajusteRegistroEvento->setFkFolhapagamentoRegistroEvento($this);
            $this->fkFolhapagamentoReajusteRegistroEventos->add($fkFolhapagamentoReajusteRegistroEvento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoReajusteRegistroEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEvento $fkFolhapagamentoReajusteRegistroEvento
     */
    public function removeFkFolhapagamentoReajusteRegistroEventos(\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEvento $fkFolhapagamentoReajusteRegistroEvento)
    {
        $this->fkFolhapagamentoReajusteRegistroEventos->removeElement($fkFolhapagamentoReajusteRegistroEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoReajusteRegistroEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEvento
     */
    public function getFkFolhapagamentoReajusteRegistroEventos()
    {
        return $this->fkFolhapagamentoReajusteRegistroEventos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoRegistroEventoPeriodo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoPeriodo $fkFolhapagamentoRegistroEventoPeriodo
     * @return RegistroEvento
     */
    public function setFkFolhapagamentoRegistroEventoPeriodo(\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoPeriodo $fkFolhapagamentoRegistroEventoPeriodo)
    {
        $this->codRegistro = $fkFolhapagamentoRegistroEventoPeriodo->getCodRegistro();
        $this->fkFolhapagamentoRegistroEventoPeriodo = $fkFolhapagamentoRegistroEventoPeriodo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoRegistroEventoPeriodo
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoPeriodo
     */
    public function getFkFolhapagamentoRegistroEventoPeriodo()
    {
        return $this->fkFolhapagamentoRegistroEventoPeriodo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento
     * @return RegistroEvento
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
     * OneToOne (inverse side)
     * Set FolhapagamentoUltimoRegistroEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEvento $fkFolhapagamentoUltimoRegistroEvento
     * @return RegistroEvento
     */
    public function setFkFolhapagamentoUltimoRegistroEvento(\Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEvento $fkFolhapagamentoUltimoRegistroEvento)
    {
        $fkFolhapagamentoUltimoRegistroEvento->setFkFolhapagamentoRegistroEvento($this);
        $this->fkFolhapagamentoUltimoRegistroEvento = $fkFolhapagamentoUltimoRegistroEvento;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoUltimoRegistroEvento
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEvento
     */
    public function getFkFolhapagamentoUltimoRegistroEvento()
    {
        return $this->fkFolhapagamentoUltimoRegistroEvento;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->fkFolhapagamentoEvento) {
            return sprintf('%s', $this->fkFolhapagamentoEvento);
        } else {
            return "Registro de Eventos";
        }
    }
}
