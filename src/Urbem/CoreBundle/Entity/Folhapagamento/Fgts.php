<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * Fgts
 */
class Fgts
{
    /**
     * PK
     * @var integer
     */
    private $codFgts;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var \DateTime
     */
    private $vigencia;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\FgtsEvento
     */
    private $fkFolhapagamentoFgtsEventos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\FgtsCategoria
     */
    private $fkFolhapagamentoFgtsCategorias;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoFgtsEventos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoFgtsCategorias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codFgts
     *
     * @param integer $codFgts
     * @return Fgts
     */
    public function setCodFgts($codFgts)
    {
        $this->codFgts = $codFgts;
        return $this;
    }

    /**
     * Get codFgts
     *
     * @return integer
     */
    public function getCodFgts()
    {
        return $this->codFgts;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return Fgts
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
     * Set vigencia
     *
     * @param \DateTime $vigencia
     * @return Fgts
     */
    public function setVigencia(\DateTime $vigencia)
    {
        $this->vigencia = $vigencia;
        return $this;
    }

    /**
     * Get vigencia
     *
     * @return \DateTime
     */
    public function getVigencia()
    {
        return $this->vigencia;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoFgtsEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\FgtsEvento $fkFolhapagamentoFgtsEvento
     * @return Fgts
     */
    public function addFkFolhapagamentoFgtsEventos(\Urbem\CoreBundle\Entity\Folhapagamento\FgtsEvento $fkFolhapagamentoFgtsEvento)
    {
        if (false === $this->fkFolhapagamentoFgtsEventos->contains($fkFolhapagamentoFgtsEvento)) {
            $fkFolhapagamentoFgtsEvento->setFkFolhapagamentoFgts($this);
            $this->fkFolhapagamentoFgtsEventos->add($fkFolhapagamentoFgtsEvento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoFgtsEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\FgtsEvento $fkFolhapagamentoFgtsEvento
     */
    public function removeFkFolhapagamentoFgtsEventos(\Urbem\CoreBundle\Entity\Folhapagamento\FgtsEvento $fkFolhapagamentoFgtsEvento)
    {
        $this->fkFolhapagamentoFgtsEventos->removeElement($fkFolhapagamentoFgtsEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoFgtsEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\FgtsEvento
     */
    public function getFkFolhapagamentoFgtsEventos()
    {
        return $this->fkFolhapagamentoFgtsEventos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoFgtsCategoria
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\FgtsCategoria $fkFolhapagamentoFgtsCategoria
     * @return Fgts
     */
    public function addFkFolhapagamentoFgtsCategorias(\Urbem\CoreBundle\Entity\Folhapagamento\FgtsCategoria $fkFolhapagamentoFgtsCategoria)
    {
        if (false === $this->fkFolhapagamentoFgtsCategorias->contains($fkFolhapagamentoFgtsCategoria)) {
            $fkFolhapagamentoFgtsCategoria->setFkFolhapagamentoFgts($this);
            $this->fkFolhapagamentoFgtsCategorias->add($fkFolhapagamentoFgtsCategoria);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoFgtsCategoria
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\FgtsCategoria $fkFolhapagamentoFgtsCategoria
     */
    public function removeFkFolhapagamentoFgtsCategorias(\Urbem\CoreBundle\Entity\Folhapagamento\FgtsCategoria $fkFolhapagamentoFgtsCategoria)
    {
        $this->fkFolhapagamentoFgtsCategorias->removeElement($fkFolhapagamentoFgtsCategoria);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoFgtsCategorias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\FgtsCategoria
     */
    public function getFkFolhapagamentoFgtsCategorias()
    {
        return $this->fkFolhapagamentoFgtsCategorias;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection|FgtsCategoria $fkFolhapagamentoFgtsCategorias
     */
    public function setFkFolhapagamentoFgtsCategorias($fkFolhapagamentoFgtsCategorias)
    {
        $this->fkFolhapagamentoFgtsCategorias = $fkFolhapagamentoFgtsCategorias;
    }

    public function __toString()
    {
        if ($this->codFgts) {
            $fgts = sprintf('%s - %s', $this->codFgts, $this->getVigencia()->format('d/m/Y'));
        } else {
            $fgts = 'FGTS';
        }

        return $fgts;
    }
}
