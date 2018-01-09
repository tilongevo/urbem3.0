<?php
 
namespace Urbem\CoreBundle\Entity\Tcers;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcers\QuadroModeloLrf
     */
    private $fkTcersQuadroModeloLrfs;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcersQuadroModeloLrfs = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add TcersQuadroModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Tcers\QuadroModeloLrf $fkTcersQuadroModeloLrf
     * @return ModeloLrf
     */
    public function addFkTcersQuadroModeloLrfs(\Urbem\CoreBundle\Entity\Tcers\QuadroModeloLrf $fkTcersQuadroModeloLrf)
    {
        if (false === $this->fkTcersQuadroModeloLrfs->contains($fkTcersQuadroModeloLrf)) {
            $fkTcersQuadroModeloLrf->setFkTcersModeloLrf($this);
            $this->fkTcersQuadroModeloLrfs->add($fkTcersQuadroModeloLrf);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcersQuadroModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Tcers\QuadroModeloLrf $fkTcersQuadroModeloLrf
     */
    public function removeFkTcersQuadroModeloLrfs(\Urbem\CoreBundle\Entity\Tcers\QuadroModeloLrf $fkTcersQuadroModeloLrf)
    {
        $this->fkTcersQuadroModeloLrfs->removeElement($fkTcersQuadroModeloLrf);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcersQuadroModeloLrfs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcers\QuadroModeloLrf
     */
    public function getFkTcersQuadroModeloLrfs()
    {
        return $this->fkTcersQuadroModeloLrfs;
    }
}
