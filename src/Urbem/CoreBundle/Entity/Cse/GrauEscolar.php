<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * GrauEscolar
 */
class GrauEscolar
{
    /**
     * PK
     * @var integer
     */
    private $codGrau;

    /**
     * @var string
     */
    private $nomGrau;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\QualificacaoEscolar
     */
    private $fkCseQualificacaoEscolares;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkCseQualificacaoEscolares = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codGrau
     *
     * @param integer $codGrau
     * @return GrauEscolar
     */
    public function setCodGrau($codGrau)
    {
        $this->codGrau = $codGrau;
        return $this;
    }

    /**
     * Get codGrau
     *
     * @return integer
     */
    public function getCodGrau()
    {
        return $this->codGrau;
    }

    /**
     * Set nomGrau
     *
     * @param string $nomGrau
     * @return GrauEscolar
     */
    public function setNomGrau($nomGrau)
    {
        $this->nomGrau = $nomGrau;
        return $this;
    }

    /**
     * Get nomGrau
     *
     * @return string
     */
    public function getNomGrau()
    {
        return $this->nomGrau;
    }

    /**
     * OneToMany (owning side)
     * Add CseQualificacaoEscolar
     *
     * @param \Urbem\CoreBundle\Entity\Cse\QualificacaoEscolar $fkCseQualificacaoEscolar
     * @return GrauEscolar
     */
    public function addFkCseQualificacaoEscolares(\Urbem\CoreBundle\Entity\Cse\QualificacaoEscolar $fkCseQualificacaoEscolar)
    {
        if (false === $this->fkCseQualificacaoEscolares->contains($fkCseQualificacaoEscolar)) {
            $fkCseQualificacaoEscolar->setFkCseGrauEscolar($this);
            $this->fkCseQualificacaoEscolares->add($fkCseQualificacaoEscolar);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CseQualificacaoEscolar
     *
     * @param \Urbem\CoreBundle\Entity\Cse\QualificacaoEscolar $fkCseQualificacaoEscolar
     */
    public function removeFkCseQualificacaoEscolares(\Urbem\CoreBundle\Entity\Cse\QualificacaoEscolar $fkCseQualificacaoEscolar)
    {
        $this->fkCseQualificacaoEscolares->removeElement($fkCseQualificacaoEscolar);
    }

    /**
     * OneToMany (owning side)
     * Get fkCseQualificacaoEscolares
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\QualificacaoEscolar
     */
    public function getFkCseQualificacaoEscolares()
    {
        return $this->fkCseQualificacaoEscolares;
    }
}
