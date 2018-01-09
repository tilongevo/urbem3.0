<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * EventoConfiguracaoEvento
 */
class EventoConfiguracaoEvento
{
    /**
     * PK
     * @var integer
     */
    private $codEvento;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codConfiguracao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoDespesa
     */
    private $fkFolhapagamentoConfiguracaoEventoDespesa;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCaso
     */
    private $fkFolhapagamentoConfiguracaoEventoCasos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\EventoEvento
     */
    private $fkFolhapagamentoEventoEvento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEvento
     */
    private $fkFolhapagamentoConfiguracaoEvento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoConfiguracaoEventoCasos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codEvento
     *
     * @param integer $codEvento
     * @return EventoConfiguracaoEvento
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return EventoConfiguracaoEvento
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
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return EventoConfiguracaoEvento
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
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoEventoCaso
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCaso $fkFolhapagamentoConfiguracaoEventoCaso
     * @return EventoConfiguracaoEvento
     */
    public function addFkFolhapagamentoConfiguracaoEventoCasos(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCaso $fkFolhapagamentoConfiguracaoEventoCaso)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEventoCasos->contains($fkFolhapagamentoConfiguracaoEventoCaso)) {
            $fkFolhapagamentoConfiguracaoEventoCaso->setFkFolhapagamentoEventoConfiguracaoEvento($this);
            $this->fkFolhapagamentoConfiguracaoEventoCasos->add($fkFolhapagamentoConfiguracaoEventoCaso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEventoCaso
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCaso $fkFolhapagamentoConfiguracaoEventoCaso
     */
    public function removeFkFolhapagamentoConfiguracaoEventoCasos(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCaso $fkFolhapagamentoConfiguracaoEventoCaso)
    {
        $this->fkFolhapagamentoConfiguracaoEventoCasos->removeElement($fkFolhapagamentoConfiguracaoEventoCaso);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEventoCasos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCaso
     */
    public function getFkFolhapagamentoConfiguracaoEventoCasos()
    {
        return $this->fkFolhapagamentoConfiguracaoEventoCasos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoEventoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoEvento $fkFolhapagamentoEventoEvento
     * @return EventoConfiguracaoEvento
     */
    public function setFkFolhapagamentoEventoEvento(\Urbem\CoreBundle\Entity\Folhapagamento\EventoEvento $fkFolhapagamentoEventoEvento)
    {
        $this->codEvento = $fkFolhapagamentoEventoEvento->getCodEvento();
        $this->timestamp = $fkFolhapagamentoEventoEvento->getTimestamp();
        $this->fkFolhapagamentoEventoEvento = $fkFolhapagamentoEventoEvento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoEventoEvento
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\EventoEvento
     */
    public function getFkFolhapagamentoEventoEvento()
    {
        return $this->fkFolhapagamentoEventoEvento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoConfiguracaoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEvento $fkFolhapagamentoConfiguracaoEvento
     * @return EventoConfiguracaoEvento
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
     * OneToOne (inverse side)
     * Set FolhapagamentoConfiguracaoEventoDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoDespesa $fkFolhapagamentoConfiguracaoEventoDespesa
     * @return EventoConfiguracaoEvento
     */
    public function setFkFolhapagamentoConfiguracaoEventoDespesa(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoDespesa $fkFolhapagamentoConfiguracaoEventoDespesa)
    {
        $fkFolhapagamentoConfiguracaoEventoDespesa->setFkFolhapagamentoEventoConfiguracaoEvento($this);
        $this->fkFolhapagamentoConfiguracaoEventoDespesa = $fkFolhapagamentoConfiguracaoEventoDespesa;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoConfiguracaoEventoDespesa
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoDespesa
     */
    public function getFkFolhapagamentoConfiguracaoEventoDespesa()
    {
        return $this->fkFolhapagamentoConfiguracaoEventoDespesa;
    }
}
