<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * EventoComplementarCalculado
 */
class EventoComplementarCalculado
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
     * PK
     * @var integer
     */
    private $codConfiguracao;

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
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoComplementar
     */
    private $fkFolhapagamentoUltimoRegistroEventoComplementar;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\EventoComplementarCalculadoDependente
     */
    private $fkFolhapagamentoEventoComplementarCalculadoDependentes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoEventoComplementarCalculadoDependentes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestampRegistro = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codEvento
     *
     * @param integer $codEvento
     * @return EventoComplementarCalculado
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
     * @return EventoComplementarCalculado
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
     * @return EventoComplementarCalculado
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
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return EventoComplementarCalculado
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
     * Set valor
     *
     * @param integer $valor
     * @return EventoComplementarCalculado
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
     * @return EventoComplementarCalculado
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
     * @return EventoComplementarCalculado
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
     * @return EventoComplementarCalculado
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
     * Add FolhapagamentoEventoComplementarCalculadoDependente
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoComplementarCalculadoDependente $fkFolhapagamentoEventoComplementarCalculadoDependente
     * @return EventoComplementarCalculado
     */
    public function addFkFolhapagamentoEventoComplementarCalculadoDependentes(\Urbem\CoreBundle\Entity\Folhapagamento\EventoComplementarCalculadoDependente $fkFolhapagamentoEventoComplementarCalculadoDependente)
    {
        if (false === $this->fkFolhapagamentoEventoComplementarCalculadoDependentes->contains($fkFolhapagamentoEventoComplementarCalculadoDependente)) {
            $fkFolhapagamentoEventoComplementarCalculadoDependente->setFkFolhapagamentoEventoComplementarCalculado($this);
            $this->fkFolhapagamentoEventoComplementarCalculadoDependentes->add($fkFolhapagamentoEventoComplementarCalculadoDependente);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoEventoComplementarCalculadoDependente
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoComplementarCalculadoDependente $fkFolhapagamentoEventoComplementarCalculadoDependente
     */
    public function removeFkFolhapagamentoEventoComplementarCalculadoDependentes(\Urbem\CoreBundle\Entity\Folhapagamento\EventoComplementarCalculadoDependente $fkFolhapagamentoEventoComplementarCalculadoDependente)
    {
        $this->fkFolhapagamentoEventoComplementarCalculadoDependentes->removeElement($fkFolhapagamentoEventoComplementarCalculadoDependente);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoEventoComplementarCalculadoDependentes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\EventoComplementarCalculadoDependente
     */
    public function getFkFolhapagamentoEventoComplementarCalculadoDependentes()
    {
        return $this->fkFolhapagamentoEventoComplementarCalculadoDependentes;
    }

    /**
     * OneToOne (owning side)
     * Set FolhapagamentoUltimoRegistroEventoComplementar
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoComplementar $fkFolhapagamentoUltimoRegistroEventoComplementar
     * @return EventoComplementarCalculado
     */
    public function setFkFolhapagamentoUltimoRegistroEventoComplementar(\Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoComplementar $fkFolhapagamentoUltimoRegistroEventoComplementar)
    {
        $this->timestampRegistro = $fkFolhapagamentoUltimoRegistroEventoComplementar->getTimestamp();
        $this->codRegistro = $fkFolhapagamentoUltimoRegistroEventoComplementar->getCodRegistro();
        $this->codEvento = $fkFolhapagamentoUltimoRegistroEventoComplementar->getCodEvento();
        $this->codConfiguracao = $fkFolhapagamentoUltimoRegistroEventoComplementar->getCodConfiguracao();
        $this->fkFolhapagamentoUltimoRegistroEventoComplementar = $fkFolhapagamentoUltimoRegistroEventoComplementar;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFolhapagamentoUltimoRegistroEventoComplementar
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoComplementar
     */
    public function getFkFolhapagamentoUltimoRegistroEventoComplementar()
    {
        return $this->fkFolhapagamentoUltimoRegistroEventoComplementar;
    }
}
