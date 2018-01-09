<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * EventoDecimoCalculado
 */
class EventoDecimoCalculado
{
    /**
     * PK
     * @var integer
     */
    private $codEvento;

    /**
     * PK
     * @var integer
     */
    private $codRegistro;

    /**
     * PK
     * @var string
     */
    private $desdobramento;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampRegistro;

    /**
     * @var integer
     */
    private $valor;

    /**
     * @var integer
     */
    private $quantidade;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoDecimo
     */
    private $fkFolhapagamentoUltimoRegistroEventoDecimo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\EventoDecimoCalculadoDependente
     */
    private $fkFolhapagamentoEventoDecimoCalculadoDependentes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoEventoDecimoCalculadoDependentes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestampRegistro = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codEvento
     *
     * @param integer $codEvento
     * @return EventoDecimoCalculado
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
     * Set codRegistro
     *
     * @param integer $codRegistro
     * @return EventoDecimoCalculado
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
     * Set desdobramento
     *
     * @param string $desdobramento
     * @return EventoDecimoCalculado
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
     * Set timestampRegistro
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampRegistro
     * @return EventoDecimoCalculado
     */
    public function setTimestampRegistro(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampRegistro)
    {
        $this->timestampRegistro = $timestampRegistro;
        return $this;
    }

    /**
     * Get timestampRegistro
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampRegistro()
    {
        return $this->timestampRegistro;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return EventoDecimoCalculado
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
     * @return EventoDecimoCalculado
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return EventoDecimoCalculado
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
     * OneToMany (owning side)
     * Add FolhapagamentoEventoDecimoCalculadoDependente
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoDecimoCalculadoDependente $fkFolhapagamentoEventoDecimoCalculadoDependente
     * @return EventoDecimoCalculado
     */
    public function addFkFolhapagamentoEventoDecimoCalculadoDependentes(\Urbem\CoreBundle\Entity\Folhapagamento\EventoDecimoCalculadoDependente $fkFolhapagamentoEventoDecimoCalculadoDependente)
    {
        if (false === $this->fkFolhapagamentoEventoDecimoCalculadoDependentes->contains($fkFolhapagamentoEventoDecimoCalculadoDependente)) {
            $fkFolhapagamentoEventoDecimoCalculadoDependente->setFkFolhapagamentoEventoDecimoCalculado($this);
            $this->fkFolhapagamentoEventoDecimoCalculadoDependentes->add($fkFolhapagamentoEventoDecimoCalculadoDependente);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoEventoDecimoCalculadoDependente
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoDecimoCalculadoDependente $fkFolhapagamentoEventoDecimoCalculadoDependente
     */
    public function removeFkFolhapagamentoEventoDecimoCalculadoDependentes(\Urbem\CoreBundle\Entity\Folhapagamento\EventoDecimoCalculadoDependente $fkFolhapagamentoEventoDecimoCalculadoDependente)
    {
        $this->fkFolhapagamentoEventoDecimoCalculadoDependentes->removeElement($fkFolhapagamentoEventoDecimoCalculadoDependente);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoEventoDecimoCalculadoDependentes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\EventoDecimoCalculadoDependente
     */
    public function getFkFolhapagamentoEventoDecimoCalculadoDependentes()
    {
        return $this->fkFolhapagamentoEventoDecimoCalculadoDependentes;
    }

    /**
     * OneToOne (owning side)
     * Set FolhapagamentoUltimoRegistroEventoDecimo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoDecimo $fkFolhapagamentoUltimoRegistroEventoDecimo
     * @return EventoDecimoCalculado
     */
    public function setFkFolhapagamentoUltimoRegistroEventoDecimo(\Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoDecimo $fkFolhapagamentoUltimoRegistroEventoDecimo)
    {
        $this->desdobramento = $fkFolhapagamentoUltimoRegistroEventoDecimo->getDesdobramento();
        $this->timestampRegistro = $fkFolhapagamentoUltimoRegistroEventoDecimo->getTimestamp();
        $this->codRegistro = $fkFolhapagamentoUltimoRegistroEventoDecimo->getCodRegistro();
        $this->codEvento = $fkFolhapagamentoUltimoRegistroEventoDecimo->getCodEvento();
        $this->fkFolhapagamentoUltimoRegistroEventoDecimo = $fkFolhapagamentoUltimoRegistroEventoDecimo;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFolhapagamentoUltimoRegistroEventoDecimo
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoDecimo
     */
    public function getFkFolhapagamentoUltimoRegistroEventoDecimo()
    {
        return $this->fkFolhapagamentoUltimoRegistroEventoDecimo;
    }
}
