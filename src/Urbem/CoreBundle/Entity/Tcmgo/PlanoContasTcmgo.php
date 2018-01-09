<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * PlanoContasTcmgo
 */
class PlanoContasTcmgo
{
    /**
     * PK
     * @var integer
     */
    private $codPlano;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $estrutural;

    /**
     * @var string
     */
    private $titulo;

    /**
     * @var string
     */
    private $natureza;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\VinculoPlanoContasTcmgo
     */
    private $fkTcmgoVinculoPlanoContasTcmgos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmgoVinculoPlanoContasTcmgos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codPlano
     *
     * @param integer $codPlano
     * @return PlanoContasTcmgo
     */
    public function setCodPlano($codPlano)
    {
        $this->codPlano = $codPlano;
        return $this;
    }

    /**
     * Get codPlano
     *
     * @return integer
     */
    public function getCodPlano()
    {
        return $this->codPlano;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return PlanoContasTcmgo
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
     * Set estrutural
     *
     * @param string $estrutural
     * @return PlanoContasTcmgo
     */
    public function setEstrutural($estrutural)
    {
        $this->estrutural = $estrutural;
        return $this;
    }

    /**
     * Get estrutural
     *
     * @return string
     */
    public function getEstrutural()
    {
        return $this->estrutural;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     * @return PlanoContasTcmgo
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
        return $this;
    }

    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set natureza
     *
     * @param string $natureza
     * @return PlanoContasTcmgo
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
     * Add TcmgoVinculoPlanoContasTcmgo
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\VinculoPlanoContasTcmgo $fkTcmgoVinculoPlanoContasTcmgo
     * @return PlanoContasTcmgo
     */
    public function addFkTcmgoVinculoPlanoContasTcmgos(\Urbem\CoreBundle\Entity\Tcmgo\VinculoPlanoContasTcmgo $fkTcmgoVinculoPlanoContasTcmgo)
    {
        if (false === $this->fkTcmgoVinculoPlanoContasTcmgos->contains($fkTcmgoVinculoPlanoContasTcmgo)) {
            $fkTcmgoVinculoPlanoContasTcmgo->setFkTcmgoPlanoContasTcmgo($this);
            $this->fkTcmgoVinculoPlanoContasTcmgos->add($fkTcmgoVinculoPlanoContasTcmgo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoVinculoPlanoContasTcmgo
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\VinculoPlanoContasTcmgo $fkTcmgoVinculoPlanoContasTcmgo
     */
    public function removeFkTcmgoVinculoPlanoContasTcmgos(\Urbem\CoreBundle\Entity\Tcmgo\VinculoPlanoContasTcmgo $fkTcmgoVinculoPlanoContasTcmgo)
    {
        $this->fkTcmgoVinculoPlanoContasTcmgos->removeElement($fkTcmgoVinculoPlanoContasTcmgo);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoVinculoPlanoContasTcmgos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\VinculoPlanoContasTcmgo
     */
    public function getFkTcmgoVinculoPlanoContasTcmgos()
    {
        return $this->fkTcmgoVinculoPlanoContasTcmgos;
    }
}
