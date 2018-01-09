<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwHistoricoArquivamento
 */
class SwHistoricoArquivamento
{
    /**
     * PK
     * @var integer
     */
    private $codHistorico;

    /**
     * @var string
     */
    private $nomHistorico;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwProcessoArquivado
     */
    private $fkSwProcessoArquivados;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkSwProcessoArquivados = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codHistorico
     *
     * @param integer $codHistorico
     * @return SwHistoricoArquivamento
     */
    public function setCodHistorico($codHistorico)
    {
        $this->codHistorico = $codHistorico;
        return $this;
    }

    /**
     * Get codHistorico
     *
     * @return integer
     */
    public function getCodHistorico()
    {
        return $this->codHistorico;
    }

    /**
     * Set nomHistorico
     *
     * @param string $nomHistorico
     * @return SwHistoricoArquivamento
     */
    public function setNomHistorico($nomHistorico)
    {
        $this->nomHistorico = $nomHistorico;
        return $this;
    }

    /**
     * Get nomHistorico
     *
     * @return string
     */
    public function getNomHistorico()
    {
        return $this->nomHistorico;
    }

    /**
     * OneToMany (owning side)
     * Add SwProcessoArquivado
     *
     * @param \Urbem\CoreBundle\Entity\SwProcessoArquivado $fkSwProcessoArquivado
     * @return SwHistoricoArquivamento
     */
    public function addFkSwProcessoArquivados(\Urbem\CoreBundle\Entity\SwProcessoArquivado $fkSwProcessoArquivado)
    {
        if (false === $this->fkSwProcessoArquivados->contains($fkSwProcessoArquivado)) {
            $fkSwProcessoArquivado->setFkSwHistoricoArquivamento($this);
            $this->fkSwProcessoArquivados->add($fkSwProcessoArquivado);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwProcessoArquivado
     *
     * @param \Urbem\CoreBundle\Entity\SwProcessoArquivado $fkSwProcessoArquivado
     */
    public function removeFkSwProcessoArquivados(\Urbem\CoreBundle\Entity\SwProcessoArquivado $fkSwProcessoArquivado)
    {
        $this->fkSwProcessoArquivados->removeElement($fkSwProcessoArquivado);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwProcessoArquivados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwProcessoArquivado
     */
    public function getFkSwProcessoArquivados()
    {
        return $this->fkSwProcessoArquivados;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->nomHistorico;
    }
}
