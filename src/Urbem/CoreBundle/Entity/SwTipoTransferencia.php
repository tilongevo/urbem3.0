<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwTipoTransferencia
 */
class SwTipoTransferencia
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $nomTipo;

    /**
     * @var boolean
     */
    private $lancamentoContabil;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwLancamentoTransferencia
     */
    private $fkSwLancamentoTransferencias;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkSwLancamentoTransferencias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return SwTipoTransferencia
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return SwTipoTransferencia
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set nomTipo
     *
     * @param string $nomTipo
     * @return SwTipoTransferencia
     */
    public function setNomTipo($nomTipo)
    {
        $this->nomTipo = $nomTipo;
        return $this;
    }

    /**
     * Get nomTipo
     *
     * @return string
     */
    public function getNomTipo()
    {
        return $this->nomTipo;
    }

    /**
     * Set lancamentoContabil
     *
     * @param boolean $lancamentoContabil
     * @return SwTipoTransferencia
     */
    public function setLancamentoContabil($lancamentoContabil)
    {
        $this->lancamentoContabil = $lancamentoContabil;
        return $this;
    }

    /**
     * Get lancamentoContabil
     *
     * @return boolean
     */
    public function getLancamentoContabil()
    {
        return $this->lancamentoContabil;
    }

    /**
     * OneToMany (owning side)
     * Add SwLancamentoTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\SwLancamentoTransferencia $fkSwLancamentoTransferencia
     * @return SwTipoTransferencia
     */
    public function addFkSwLancamentoTransferencias(\Urbem\CoreBundle\Entity\SwLancamentoTransferencia $fkSwLancamentoTransferencia)
    {
        if (false === $this->fkSwLancamentoTransferencias->contains($fkSwLancamentoTransferencia)) {
            $fkSwLancamentoTransferencia->setFkSwTipoTransferencia($this);
            $this->fkSwLancamentoTransferencias->add($fkSwLancamentoTransferencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwLancamentoTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\SwLancamentoTransferencia $fkSwLancamentoTransferencia
     */
    public function removeFkSwLancamentoTransferencias(\Urbem\CoreBundle\Entity\SwLancamentoTransferencia $fkSwLancamentoTransferencia)
    {
        $this->fkSwLancamentoTransferencias->removeElement($fkSwLancamentoTransferencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwLancamentoTransferencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwLancamentoTransferencia
     */
    public function getFkSwLancamentoTransferencias()
    {
        return $this->fkSwLancamentoTransferencias;
    }
}
