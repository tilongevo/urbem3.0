<?php
 
namespace Urbem\CoreBundle\Entity\Patrimonio;

/**
 * Especie
 */
class Especie
{
    /**
     * PK
     * @var integer
     */
    private $codEspecie;

    /**
     * PK
     * @var integer
     */
    private $codGrupo;

    /**
     * PK
     * @var integer
     */
    private $codNatureza;

    /**
     * @var string
     */
    private $nomEspecie;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\EspecieAtributo
     */
    private $fkPatrimonioEspecieAtributos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\BalancoApbaaaaEspecie
     */
    private $fkTcmgoBalancoApbaaaaEspecies;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\Bem
     */
    private $fkPatrimonioBens;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Patrimonio\Grupo
     */
    private $fkPatrimonioGrupo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPatrimonioEspecieAtributos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoBalancoApbaaaaEspecies = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioBens = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codEspecie
     *
     * @param integer $codEspecie
     * @return Especie
     */
    public function setCodEspecie($codEspecie)
    {
        $this->codEspecie = $codEspecie;
        return $this;
    }

    /**
     * Get codEspecie
     *
     * @return integer
     */
    public function getCodEspecie()
    {
        return $this->codEspecie;
    }

    /**
     * Set codGrupo
     *
     * @param integer $codGrupo
     * @return Especie
     */
    public function setCodGrupo($codGrupo)
    {
        $this->codGrupo = $codGrupo;
        return $this;
    }

    /**
     * Get codGrupo
     *
     * @return integer
     */
    public function getCodGrupo()
    {
        return $this->codGrupo;
    }

    /**
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return Especie
     */
    public function setCodNatureza($codNatureza)
    {
        $this->codNatureza = $codNatureza;
        return $this;
    }

    /**
     * Get codNatureza
     *
     * @return integer
     */
    public function getCodNatureza()
    {
        return $this->codNatureza;
    }

    /**
     * Set nomEspecie
     *
     * @param string $nomEspecie
     * @return Especie
     */
    public function setNomEspecie($nomEspecie)
    {
        $this->nomEspecie = $nomEspecie;
        return $this;
    }

    /**
     * Get nomEspecie
     *
     * @return string
     */
    public function getNomEspecie()
    {
        return $this->nomEspecie;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioEspecieAtributo
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\EspecieAtributo $fkPatrimonioEspecieAtributo
     * @return Especie
     */
    public function addFkPatrimonioEspecieAtributos(\Urbem\CoreBundle\Entity\Patrimonio\EspecieAtributo $fkPatrimonioEspecieAtributo)
    {
        if (false === $this->fkPatrimonioEspecieAtributos->contains($fkPatrimonioEspecieAtributo)) {
            $fkPatrimonioEspecieAtributo->setFkPatrimonioEspecie($this);
            $this->fkPatrimonioEspecieAtributos->add($fkPatrimonioEspecieAtributo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioEspecieAtributo
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\EspecieAtributo $fkPatrimonioEspecieAtributo
     */
    public function removeFkPatrimonioEspecieAtributos(\Urbem\CoreBundle\Entity\Patrimonio\EspecieAtributo $fkPatrimonioEspecieAtributo)
    {
        $this->fkPatrimonioEspecieAtributos->removeElement($fkPatrimonioEspecieAtributo);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioEspecieAtributos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\EspecieAtributo
     */
    public function getFkPatrimonioEspecieAtributos()
    {
        return $this->fkPatrimonioEspecieAtributos;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoBalancoApbaaaaEspecie
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\BalancoApbaaaaEspecie $fkTcmgoBalancoApbaaaaEspecie
     * @return Especie
     */
    public function addFkTcmgoBalancoApbaaaaEspecies(\Urbem\CoreBundle\Entity\Tcmgo\BalancoApbaaaaEspecie $fkTcmgoBalancoApbaaaaEspecie)
    {
        if (false === $this->fkTcmgoBalancoApbaaaaEspecies->contains($fkTcmgoBalancoApbaaaaEspecie)) {
            $fkTcmgoBalancoApbaaaaEspecie->setFkPatrimonioEspecie($this);
            $this->fkTcmgoBalancoApbaaaaEspecies->add($fkTcmgoBalancoApbaaaaEspecie);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoBalancoApbaaaaEspecie
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\BalancoApbaaaaEspecie $fkTcmgoBalancoApbaaaaEspecie
     */
    public function removeFkTcmgoBalancoApbaaaaEspecies(\Urbem\CoreBundle\Entity\Tcmgo\BalancoApbaaaaEspecie $fkTcmgoBalancoApbaaaaEspecie)
    {
        $this->fkTcmgoBalancoApbaaaaEspecies->removeElement($fkTcmgoBalancoApbaaaaEspecie);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoBalancoApbaaaaEspecies
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\BalancoApbaaaaEspecie
     */
    public function getFkTcmgoBalancoApbaaaaEspecies()
    {
        return $this->fkTcmgoBalancoApbaaaaEspecies;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Bem $fkPatrimonioBem
     * @return Especie
     */
    public function addFkPatrimonioBens(\Urbem\CoreBundle\Entity\Patrimonio\Bem $fkPatrimonioBem)
    {
        if (false === $this->fkPatrimonioBens->contains($fkPatrimonioBem)) {
            $fkPatrimonioBem->setFkPatrimonioEspecie($this);
            $this->fkPatrimonioBens->add($fkPatrimonioBem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Bem $fkPatrimonioBem
     */
    public function removeFkPatrimonioBens(\Urbem\CoreBundle\Entity\Patrimonio\Bem $fkPatrimonioBem)
    {
        $this->fkPatrimonioBens->removeElement($fkPatrimonioBem);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioBens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\Bem
     */
    public function getFkPatrimonioBens()
    {
        return $this->fkPatrimonioBens;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPatrimonioGrupo
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Grupo $fkPatrimonioGrupo
     * @return Especie
     */
    public function setFkPatrimonioGrupo(\Urbem\CoreBundle\Entity\Patrimonio\Grupo $fkPatrimonioGrupo)
    {
        $this->codGrupo = $fkPatrimonioGrupo->getCodGrupo();
        $this->codNatureza = $fkPatrimonioGrupo->getCodNatureza();
        $this->fkPatrimonioGrupo = $fkPatrimonioGrupo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPatrimonioGrupo
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\Grupo
     */
    public function getFkPatrimonioGrupo()
    {
        return $this->fkPatrimonioGrupo;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '%s - %s',
            $this->codEspecie,
            $this->nomEspecie
        );
    }
}
