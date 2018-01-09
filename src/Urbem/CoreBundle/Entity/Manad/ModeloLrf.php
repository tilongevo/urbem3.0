<?php
 
namespace Urbem\CoreBundle\Entity\Manad;

/**
 * ModeloLrf
 */
class ModeloLrf
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codModelo;

    /**
     * @var string
     */
    private $nomModelo;

    /**
     * @var string
     */
    private $nomModeloOrcamento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Manad\QuadroModeloLrf
     */
    private $fkManadQuadroModeloLrfs;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkManadQuadroModeloLrfs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ModeloLrf
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
     * Set codModelo
     *
     * @param integer $codModelo
     * @return ModeloLrf
     */
    public function setCodModelo($codModelo)
    {
        $this->codModelo = $codModelo;
        return $this;
    }

    /**
     * Get codModelo
     *
     * @return integer
     */
    public function getCodModelo()
    {
        return $this->codModelo;
    }

    /**
     * Set nomModelo
     *
     * @param string $nomModelo
     * @return ModeloLrf
     */
    public function setNomModelo($nomModelo)
    {
        $this->nomModelo = $nomModelo;
        return $this;
    }

    /**
     * Get nomModelo
     *
     * @return string
     */
    public function getNomModelo()
    {
        return $this->nomModelo;
    }

    /**
     * Set nomModeloOrcamento
     *
     * @param string $nomModeloOrcamento
     * @return ModeloLrf
     */
    public function setNomModeloOrcamento($nomModeloOrcamento = null)
    {
        $this->nomModeloOrcamento = $nomModeloOrcamento;
        return $this;
    }

    /**
     * Get nomModeloOrcamento
     *
     * @return string
     */
    public function getNomModeloOrcamento()
    {
        return $this->nomModeloOrcamento;
    }

    /**
     * OneToMany (owning side)
     * Add ManadQuadroModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Manad\QuadroModeloLrf $fkManadQuadroModeloLrf
     * @return ModeloLrf
     */
    public function addFkManadQuadroModeloLrfs(\Urbem\CoreBundle\Entity\Manad\QuadroModeloLrf $fkManadQuadroModeloLrf)
    {
        if (false === $this->fkManadQuadroModeloLrfs->contains($fkManadQuadroModeloLrf)) {
            $fkManadQuadroModeloLrf->setFkManadModeloLrf($this);
            $this->fkManadQuadroModeloLrfs->add($fkManadQuadroModeloLrf);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ManadQuadroModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Manad\QuadroModeloLrf $fkManadQuadroModeloLrf
     */
    public function removeFkManadQuadroModeloLrfs(\Urbem\CoreBundle\Entity\Manad\QuadroModeloLrf $fkManadQuadroModeloLrf)
    {
        $this->fkManadQuadroModeloLrfs->removeElement($fkManadQuadroModeloLrf);
    }

    /**
     * OneToMany (owning side)
     * Get fkManadQuadroModeloLrfs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Manad\QuadroModeloLrf
     */
    public function getFkManadQuadroModeloLrfs()
    {
        return $this->fkManadQuadroModeloLrfs;
    }
}
