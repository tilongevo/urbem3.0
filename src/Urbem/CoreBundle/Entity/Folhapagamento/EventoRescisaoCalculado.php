<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * EventoRescisaoCalculado
 */
class EventoRescisaoCalculado
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
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoRescisao
     */
    private $fkFolhapagamentoUltimoRegistroEventoRescisao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\EventoRescisaoCalculadoDependente
     */
    private $fkFolhapagamentoEventoRescisaoCalculadoDependentes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoEventoRescisaoCalculadoDependentes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestampRegistro = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codEvento
     *
     * @param integer $codEvento
     * @return EventoRescisaoCalculado
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
     * @return EventoRescisaoCalculado
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
     * @return EventoRescisaoCalculado
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
     * @return EventoRescisaoCalculado
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
     * @return EventoRescisaoCalculado
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
     * @return EventoRescisaoCalculado
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
     * @return EventoRescisaoCalculado
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
     * Add FolhapagamentoEventoRescisaoCalculadoDependente
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoRescisaoCalculadoDependente $fkFolhapagamentoEventoRescisaoCalculadoDependente
     * @return EventoRescisaoCalculado
     */
    public function addFkFolhapagamentoEventoRescisaoCalculadoDependentes(\Urbem\CoreBundle\Entity\Folhapagamento\EventoRescisaoCalculadoDependente $fkFolhapagamentoEventoRescisaoCalculadoDependente)
    {
        if (false === $this->fkFolhapagamentoEventoRescisaoCalculadoDependentes->contains($fkFolhapagamentoEventoRescisaoCalculadoDependente)) {
            $fkFolhapagamentoEventoRescisaoCalculadoDependente->setFkFolhapagamentoEventoRescisaoCalculado($this);
            $this->fkFolhapagamentoEventoRescisaoCalculadoDependentes->add($fkFolhapagamentoEventoRescisaoCalculadoDependente);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoEventoRescisaoCalculadoDependente
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoRescisaoCalculadoDependente $fkFolhapagamentoEventoRescisaoCalculadoDependente
     */
    public function removeFkFolhapagamentoEventoRescisaoCalculadoDependentes(\Urbem\CoreBundle\Entity\Folhapagamento\EventoRescisaoCalculadoDependente $fkFolhapagamentoEventoRescisaoCalculadoDependente)
    {
        $this->fkFolhapagamentoEventoRescisaoCalculadoDependentes->removeElement($fkFolhapagamentoEventoRescisaoCalculadoDependente);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoEventoRescisaoCalculadoDependentes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\EventoRescisaoCalculadoDependente
     */
    public function getFkFolhapagamentoEventoRescisaoCalculadoDependentes()
    {
        return $this->fkFolhapagamentoEventoRescisaoCalculadoDependentes;
    }

    /**
     * OneToOne (owning side)
     * Set FolhapagamentoUltimoRegistroEventoRescisao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoRescisao $fkFolhapagamentoUltimoRegistroEventoRescisao
     * @return EventoRescisaoCalculado
     */
    public function setFkFolhapagamentoUltimoRegistroEventoRescisao(\Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoRescisao $fkFolhapagamentoUltimoRegistroEventoRescisao)
    {
        $this->desdobramento = $fkFolhapagamentoUltimoRegistroEventoRescisao->getDesdobramento();
        $this->timestampRegistro = $fkFolhapagamentoUltimoRegistroEventoRescisao->getTimestamp();
        $this->codRegistro = $fkFolhapagamentoUltimoRegistroEventoRescisao->getCodRegistro();
        $this->codEvento = $fkFolhapagamentoUltimoRegistroEventoRescisao->getCodEvento();
        $this->fkFolhapagamentoUltimoRegistroEventoRescisao = $fkFolhapagamentoUltimoRegistroEventoRescisao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFolhapagamentoUltimoRegistroEventoRescisao
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoRescisao
     */
    public function getFkFolhapagamentoUltimoRegistroEventoRescisao()
    {
        return $this->fkFolhapagamentoUltimoRegistroEventoRescisao;
    }
}
