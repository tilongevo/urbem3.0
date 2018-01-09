<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * EventoCalculado
 */
class EventoCalculado
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
     * @var string
     */
    private $desdobramento;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEvento
     */
    private $fkFolhapagamentoUltimoRegistroEvento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\EventoCalculadoDependente
     */
    private $fkFolhapagamentoEventoCalculadoDependentes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoEventoCalculadoDependentes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestampRegistro = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codEvento
     *
     * @param integer $codEvento
     * @return EventoCalculado
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
     * @return EventoCalculado
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
     * Set timestampRegistro
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampRegistro
     * @return EventoCalculado
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
     * @return EventoCalculado
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
     * @return EventoCalculado
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
     * @return EventoCalculado
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
     * @return EventoCalculado
     */
    public function setDesdobramento($desdobramento = null)
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
     * OneToMany (owning side)
     * Add FolhapagamentoEventoCalculadoDependente
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoCalculadoDependente $fkFolhapagamentoEventoCalculadoDependente
     * @return EventoCalculado
     */
    public function addFkFolhapagamentoEventoCalculadoDependentes(\Urbem\CoreBundle\Entity\Folhapagamento\EventoCalculadoDependente $fkFolhapagamentoEventoCalculadoDependente)
    {
        if (false === $this->fkFolhapagamentoEventoCalculadoDependentes->contains($fkFolhapagamentoEventoCalculadoDependente)) {
            $fkFolhapagamentoEventoCalculadoDependente->setFkFolhapagamentoEventoCalculado($this);
            $this->fkFolhapagamentoEventoCalculadoDependentes->add($fkFolhapagamentoEventoCalculadoDependente);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoEventoCalculadoDependente
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoCalculadoDependente $fkFolhapagamentoEventoCalculadoDependente
     */
    public function removeFkFolhapagamentoEventoCalculadoDependentes(\Urbem\CoreBundle\Entity\Folhapagamento\EventoCalculadoDependente $fkFolhapagamentoEventoCalculadoDependente)
    {
        $this->fkFolhapagamentoEventoCalculadoDependentes->removeElement($fkFolhapagamentoEventoCalculadoDependente);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoEventoCalculadoDependentes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\EventoCalculadoDependente
     */
    public function getFkFolhapagamentoEventoCalculadoDependentes()
    {
        return $this->fkFolhapagamentoEventoCalculadoDependentes;
    }

    /**
     * OneToOne (owning side)
     * Set FolhapagamentoUltimoRegistroEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEvento $fkFolhapagamentoUltimoRegistroEvento
     * @return EventoCalculado
     */
    public function setFkFolhapagamentoUltimoRegistroEvento(\Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEvento $fkFolhapagamentoUltimoRegistroEvento)
    {
        $this->codRegistro = $fkFolhapagamentoUltimoRegistroEvento->getCodRegistro();
        $this->timestampRegistro = $fkFolhapagamentoUltimoRegistroEvento->getTimestamp();
        $this->codEvento = $fkFolhapagamentoUltimoRegistroEvento->getCodEvento();
        $this->fkFolhapagamentoUltimoRegistroEvento = $fkFolhapagamentoUltimoRegistroEvento;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFolhapagamentoUltimoRegistroEvento
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEvento
     */
    public function getFkFolhapagamentoUltimoRegistroEvento()
    {
        return $this->fkFolhapagamentoUltimoRegistroEvento;
    }
}
