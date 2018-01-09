<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * EventoEvento
 */
class EventoEvento
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
     * @var string
     */
    private $observacao;

    /**
     * @var integer
     */
    private $valorQuantidade;

    /**
     * @var integer
     */
    private $unidadeQuantitativa;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\AtributoEventoValor
     */
    private $fkFolhapagamentoAtributoEventoValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\EventoConfiguracaoEvento
     */
    private $fkFolhapagamentoEventoConfiguracaoEventos;

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
        $this->fkFolhapagamentoAtributoEventoValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoEventoConfiguracaoEventos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codEvento
     *
     * @param integer $codEvento
     * @return EventoEvento
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
     * @return EventoEvento
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
     * Set observacao
     *
     * @param string $observacao
     * @return EventoEvento
     */
    public function setObservacao($observacao = null)
    {
        $this->observacao = $observacao;
        return $this;
    }

    /**
     * Get observacao
     *
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * Set valorQuantidade
     *
     * @param integer $valorQuantidade
     * @return EventoEvento
     */
    public function setValorQuantidade($valorQuantidade = null)
    {
        $this->valorQuantidade = $valorQuantidade;
        return $this;
    }

    /**
     * Get valorQuantidade
     *
     * @return integer
     */
    public function getValorQuantidade()
    {
        return $this->valorQuantidade;
    }

    /**
     * Set unidadeQuantitativa
     *
     * @param integer $unidadeQuantitativa
     * @return EventoEvento
     */
    public function setUnidadeQuantitativa($unidadeQuantitativa = null)
    {
        $this->unidadeQuantitativa = $unidadeQuantitativa;
        return $this;
    }

    /**
     * Get unidadeQuantitativa
     *
     * @return integer
     */
    public function getUnidadeQuantitativa()
    {
        return $this->unidadeQuantitativa;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoAtributoEventoValor
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\AtributoEventoValor $fkFolhapagamentoAtributoEventoValor
     * @return EventoEvento
     */
    public function addFkFolhapagamentoAtributoEventoValores(\Urbem\CoreBundle\Entity\Folhapagamento\AtributoEventoValor $fkFolhapagamentoAtributoEventoValor)
    {
        if (false === $this->fkFolhapagamentoAtributoEventoValores->contains($fkFolhapagamentoAtributoEventoValor)) {
            $fkFolhapagamentoAtributoEventoValor->setFkFolhapagamentoEventoEvento($this);
            $this->fkFolhapagamentoAtributoEventoValores->add($fkFolhapagamentoAtributoEventoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoAtributoEventoValor
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\AtributoEventoValor $fkFolhapagamentoAtributoEventoValor
     */
    public function removeFkFolhapagamentoAtributoEventoValores(\Urbem\CoreBundle\Entity\Folhapagamento\AtributoEventoValor $fkFolhapagamentoAtributoEventoValor)
    {
        $this->fkFolhapagamentoAtributoEventoValores->removeElement($fkFolhapagamentoAtributoEventoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoAtributoEventoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\AtributoEventoValor
     */
    public function getFkFolhapagamentoAtributoEventoValores()
    {
        return $this->fkFolhapagamentoAtributoEventoValores;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoEventoConfiguracaoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoConfiguracaoEvento $fkFolhapagamentoEventoConfiguracaoEvento
     * @return EventoEvento
     */
    public function addFkFolhapagamentoEventoConfiguracaoEventos(\Urbem\CoreBundle\Entity\Folhapagamento\EventoConfiguracaoEvento $fkFolhapagamentoEventoConfiguracaoEvento)
    {
        if (false === $this->fkFolhapagamentoEventoConfiguracaoEventos->contains($fkFolhapagamentoEventoConfiguracaoEvento)) {
            $fkFolhapagamentoEventoConfiguracaoEvento->setFkFolhapagamentoEventoEvento($this);
            $this->fkFolhapagamentoEventoConfiguracaoEventos->add($fkFolhapagamentoEventoConfiguracaoEvento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoEventoConfiguracaoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoConfiguracaoEvento $fkFolhapagamentoEventoConfiguracaoEvento
     */
    public function removeFkFolhapagamentoEventoConfiguracaoEventos(\Urbem\CoreBundle\Entity\Folhapagamento\EventoConfiguracaoEvento $fkFolhapagamentoEventoConfiguracaoEvento)
    {
        $this->fkFolhapagamentoEventoConfiguracaoEventos->removeElement($fkFolhapagamentoEventoConfiguracaoEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoEventoConfiguracaoEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\EventoConfiguracaoEvento
     */
    public function getFkFolhapagamentoEventoConfiguracaoEventos()
    {
        return $this->fkFolhapagamentoEventoConfiguracaoEventos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento
     * @return EventoEvento
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
}
