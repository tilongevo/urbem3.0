<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * VerbaRescisoriaMte
 */
class VerbaRescisoriaMte
{
    /**
     * PK
     * @var string
     */
    private $codVerba;

    /**
     * @var string
     */
    private $nomVerba;

    /**
     * @var string
     */
    private $natureza;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    private $fkFolhapagamentoEventos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoEventos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codVerba
     *
     * @param string $codVerba
     * @return VerbaRescisoriaMte
     */
    public function setCodVerba($codVerba)
    {
        $this->codVerba = $codVerba;
        return $this;
    }

    /**
     * Get codVerba
     *
     * @return string
     */
    public function getCodVerba()
    {
        return $this->codVerba;
    }

    /**
     * Set nomVerba
     *
     * @param string $nomVerba
     * @return VerbaRescisoriaMte
     */
    public function setNomVerba($nomVerba)
    {
        $this->nomVerba = $nomVerba;
        return $this;
    }

    /**
     * Get nomVerba
     *
     * @return string
     */
    public function getNomVerba()
    {
        return $this->nomVerba;
    }

    /**
     * Set natureza
     *
     * @param string $natureza
     * @return VerbaRescisoriaMte
     */
    public function setNatureza($natureza)
    {
        $this->natureza = $natureza;
        return $this;
    }

    /**
     * Get natureza
     *
     * @return string
     */
    public function getNatureza()
    {
        return $this->natureza;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento
     * @return VerbaRescisoriaMte
     */
    public function addFkFolhapagamentoEventos(\Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento)
    {
        if (false === $this->fkFolhapagamentoEventos->contains($fkFolhapagamentoEvento)) {
            $fkFolhapagamentoEvento->setFkFolhapagamentoVerbaRescisoriaMte($this);
            $this->fkFolhapagamentoEventos->add($fkFolhapagamentoEvento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento
     */
    public function removeFkFolhapagamentoEventos(\Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento)
    {
        $this->fkFolhapagamentoEventos->removeElement($fkFolhapagamentoEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    public function getFkFolhapagamentoEventos()
    {
        return $this->fkFolhapagamentoEventos;
    }
}
