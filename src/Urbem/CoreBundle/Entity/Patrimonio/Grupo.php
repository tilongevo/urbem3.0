<?php
 
namespace Urbem\CoreBundle\Entity\Patrimonio;

/**
 * Grupo
 */
class Grupo
{
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
    private $nomGrupo;

    /**
     * @var integer
     */
    private $depreciacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tcmba\TipoBem
     */
    private $fkTcmbaTipoBem;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\Especie
     */
    private $fkPatrimonioEspecies;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica
     */
    private $fkPatrimonioGrupoPlanoAnaliticas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoDepreciacao
     */
    private $fkPatrimonioGrupoPlanoDepreciacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Patrimonio\Natureza
     */
    private $fkPatrimonioNatureza;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPatrimonioEspecies = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioGrupoPlanoAnaliticas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioGrupoPlanoDepreciacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codGrupo
     *
     * @param integer $codGrupo
     * @return Grupo
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
     * @return Grupo
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
     * Set nomGrupo
     *
     * @param string $nomGrupo
     * @return Grupo
     */
    public function setNomGrupo($nomGrupo)
    {
        $this->nomGrupo = $nomGrupo;
        return $this;
    }

    /**
     * Get nomGrupo
     *
     * @return string
     */
    public function getNomGrupo()
    {
        return $this->nomGrupo;
    }

    /**
     * Set depreciacao
     *
     * @param integer $depreciacao
     * @return Grupo
     */
    public function setDepreciacao($depreciacao)
    {
        $this->depreciacao = $depreciacao;
        return $this;
    }

    /**
     * Get depreciacao
     *
     * @return integer
     */
    public function getDepreciacao()
    {
        return $this->depreciacao;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioEspecie
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Especie $fkPatrimonioEspecie
     * @return Grupo
     */
    public function addFkPatrimonioEspecies(\Urbem\CoreBundle\Entity\Patrimonio\Especie $fkPatrimonioEspecie)
    {
        if (false === $this->fkPatrimonioEspecies->contains($fkPatrimonioEspecie)) {
            $fkPatrimonioEspecie->setFkPatrimonioGrupo($this);
            $this->fkPatrimonioEspecies->add($fkPatrimonioEspecie);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioEspecie
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Especie $fkPatrimonioEspecie
     */
    public function removeFkPatrimonioEspecies(\Urbem\CoreBundle\Entity\Patrimonio\Especie $fkPatrimonioEspecie)
    {
        $this->fkPatrimonioEspecies->removeElement($fkPatrimonioEspecie);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioEspecies
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\Especie
     */
    public function getFkPatrimonioEspecies()
    {
        return $this->fkPatrimonioEspecies;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioGrupoPlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica $fkPatrimonioGrupoPlanoAnalitica
     * @return Grupo
     */
    public function addFkPatrimonioGrupoPlanoAnaliticas(\Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica $fkPatrimonioGrupoPlanoAnalitica)
    {
        if (false === $this->fkPatrimonioGrupoPlanoAnaliticas->contains($fkPatrimonioGrupoPlanoAnalitica)) {
            $fkPatrimonioGrupoPlanoAnalitica->setFkPatrimonioGrupo($this);
            $this->fkPatrimonioGrupoPlanoAnaliticas->add($fkPatrimonioGrupoPlanoAnalitica);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioGrupoPlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica $fkPatrimonioGrupoPlanoAnalitica
     */
    public function removeFkPatrimonioGrupoPlanoAnaliticas(\Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica $fkPatrimonioGrupoPlanoAnalitica)
    {
        $this->fkPatrimonioGrupoPlanoAnaliticas->removeElement($fkPatrimonioGrupoPlanoAnalitica);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioGrupoPlanoAnaliticas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica
     */
    public function getFkPatrimonioGrupoPlanoAnaliticas()
    {
        return $this->fkPatrimonioGrupoPlanoAnaliticas;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioGrupoPlanoDepreciacao
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoDepreciacao $fkPatrimonioGrupoPlanoDepreciacao
     * @return Grupo
     */
    public function addFkPatrimonioGrupoPlanoDepreciacoes(\Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoDepreciacao $fkPatrimonioGrupoPlanoDepreciacao)
    {
        if (false === $this->fkPatrimonioGrupoPlanoDepreciacoes->contains($fkPatrimonioGrupoPlanoDepreciacao)) {
            $fkPatrimonioGrupoPlanoDepreciacao->setFkPatrimonioGrupo($this);
            $this->fkPatrimonioGrupoPlanoDepreciacoes->add($fkPatrimonioGrupoPlanoDepreciacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioGrupoPlanoDepreciacao
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoDepreciacao $fkPatrimonioGrupoPlanoDepreciacao
     */
    public function removeFkPatrimonioGrupoPlanoDepreciacoes(\Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoDepreciacao $fkPatrimonioGrupoPlanoDepreciacao)
    {
        $this->fkPatrimonioGrupoPlanoDepreciacoes->removeElement($fkPatrimonioGrupoPlanoDepreciacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioGrupoPlanoDepreciacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoDepreciacao
     */
    public function getFkPatrimonioGrupoPlanoDepreciacoes()
    {
        return $this->fkPatrimonioGrupoPlanoDepreciacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPatrimonioNatureza
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Natureza $fkPatrimonioNatureza
     * @return Grupo
     */
    public function setFkPatrimonioNatureza(\Urbem\CoreBundle\Entity\Patrimonio\Natureza $fkPatrimonioNatureza)
    {
        $this->codNatureza = $fkPatrimonioNatureza->getCodNatureza();
        $this->fkPatrimonioNatureza = $fkPatrimonioNatureza;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPatrimonioNatureza
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\Natureza
     */
    public function getFkPatrimonioNatureza()
    {
        return $this->fkPatrimonioNatureza;
    }

    /**
     * OneToOne (inverse side)
     * Set TcmbaTipoBem
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\TipoBem $fkTcmbaTipoBem
     * @return Grupo
     */
    public function setFkTcmbaTipoBem(\Urbem\CoreBundle\Entity\Tcmba\TipoBem $fkTcmbaTipoBem)
    {
        $fkTcmbaTipoBem->setFkPatrimonioGrupo($this);
        $this->fkTcmbaTipoBem = $fkTcmbaTipoBem;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTcmbaTipoBem
     *
     * @return \Urbem\CoreBundle\Entity\Tcmba\TipoBem
     */
    public function getFkTcmbaTipoBem()
    {
        return $this->fkTcmbaTipoBem;
    }

    /**
     * PrePersist
     * @param \Doctrine\Common\Persistence\Event\LifecycleEventArgs $args
     */
    public function generatePkSequence(\Doctrine\Common\Persistence\Event\LifecycleEventArgs $args)
    {
        $this->codGrupo = (new \Doctrine\ORM\Id\SequenceGenerator('patrimonio.grupo_seq', 1))->generate($args->getObjectManager(), $this);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '%s - %s',
            $this->codGrupo,
            $this->nomGrupo
        );
    }
}
