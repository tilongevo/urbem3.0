<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * EventoFeriasCalculado
 */
class EventoFeriasCalculado
{
    /**
     * PK
     * @var integer
     */
    private $codRegistro;

    /**
     * PK
     * @var integer
     */
    private $codEvento;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampRegistro;

    /**
     * PK
     * @var string
     */
    private $desdobramento;

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
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoFerias
     */
    private $fkFolhapagamentoUltimoRegistroEventoFerias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\EventoFeriasCalculadoDependente
     */
    private $fkFolhapagamentoEventoFeriasCalculadoDependentes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoEventoFeriasCalculadoDependentes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestampRegistro = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codRegistro
     *
     * @param integer $codRegistro
     * @return EventoFeriasCalculado
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
     * Set codEvento
     *
     * @param integer $codEvento
     * @return EventoFeriasCalculado
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
     * Set timestampRegistro
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampRegistro
     * @return EventoFeriasCalculado
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
     * Set desdobramento
     *
     * @param string $desdobramento
     * @return EventoFeriasCalculado
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
     * Set valor
     *
     * @param integer $valor
     * @return EventoFeriasCalculado
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
     * @return EventoFeriasCalculado
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return EventoFeriasCalculado
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
     * Add FolhapagamentoEventoFeriasCalculadoDependente
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoFeriasCalculadoDependente $fkFolhapagamentoEventoFeriasCalculadoDependente
     * @return EventoFeriasCalculado
     */
    public function addFkFolhapagamentoEventoFeriasCalculadoDependentes(\Urbem\CoreBundle\Entity\Folhapagamento\EventoFeriasCalculadoDependente $fkFolhapagamentoEventoFeriasCalculadoDependente)
    {
        if (false === $this->fkFolhapagamentoEventoFeriasCalculadoDependentes->contains($fkFolhapagamentoEventoFeriasCalculadoDependente)) {
            $fkFolhapagamentoEventoFeriasCalculadoDependente->setFkFolhapagamentoEventoFeriasCalculado($this);
            $this->fkFolhapagamentoEventoFeriasCalculadoDependentes->add($fkFolhapagamentoEventoFeriasCalculadoDependente);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoEventoFeriasCalculadoDependente
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoFeriasCalculadoDependente $fkFolhapagamentoEventoFeriasCalculadoDependente
     */
    public function removeFkFolhapagamentoEventoFeriasCalculadoDependentes(\Urbem\CoreBundle\Entity\Folhapagamento\EventoFeriasCalculadoDependente $fkFolhapagamentoEventoFeriasCalculadoDependente)
    {
        $this->fkFolhapagamentoEventoFeriasCalculadoDependentes->removeElement($fkFolhapagamentoEventoFeriasCalculadoDependente);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoEventoFeriasCalculadoDependentes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\EventoFeriasCalculadoDependente
     */
    public function getFkFolhapagamentoEventoFeriasCalculadoDependentes()
    {
        return $this->fkFolhapagamentoEventoFeriasCalculadoDependentes;
    }

    /**
     * OneToOne (owning side)
     * Set FolhapagamentoUltimoRegistroEventoFerias
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoFerias $fkFolhapagamentoUltimoRegistroEventoFerias
     * @return EventoFeriasCalculado
     */
    public function setFkFolhapagamentoUltimoRegistroEventoFerias(\Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoFerias $fkFolhapagamentoUltimoRegistroEventoFerias)
    {
        $this->codEvento = $fkFolhapagamentoUltimoRegistroEventoFerias->getCodEvento();
        $this->timestampRegistro = $fkFolhapagamentoUltimoRegistroEventoFerias->getTimestamp();
        $this->codRegistro = $fkFolhapagamentoUltimoRegistroEventoFerias->getCodRegistro();
        $this->desdobramento = $fkFolhapagamentoUltimoRegistroEventoFerias->getDesdobramento();
        $this->fkFolhapagamentoUltimoRegistroEventoFerias = $fkFolhapagamentoUltimoRegistroEventoFerias;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFolhapagamentoUltimoRegistroEventoFerias
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoFerias
     */
    public function getFkFolhapagamentoUltimoRegistroEventoFerias()
    {
        return $this->fkFolhapagamentoUltimoRegistroEventoFerias;
    }
}
