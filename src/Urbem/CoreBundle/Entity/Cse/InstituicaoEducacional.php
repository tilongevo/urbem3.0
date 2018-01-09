<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * InstituicaoEducacional
 */
class InstituicaoEducacional
{
    /**
     * PK
     * @var integer
     */
    private $codInstituicao;

    /**
     * @var string
     */
    private $nomInstituicao;

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
     * Set codInstituicao
     *
     * @param integer $codInstituicao
     * @return InstituicaoEducacional
     */
    public function setCodInstituicao($codInstituicao)
    {
        $this->codInstituicao = $codInstituicao;
        return $this;
    }

    /**
     * Get codInstituicao
     *
     * @return integer
     */
    public function getCodInstituicao()
    {
        return $this->codInstituicao;
    }

    /**
     * Set nomInstituicao
     *
     * @param string $nomInstituicao
     * @return InstituicaoEducacional
     */
    public function setNomInstituicao($nomInstituicao)
    {
        $this->nomInstituicao = $nomInstituicao;
        return $this;
    }

    /**
     * Get nomInstituicao
     *
     * @return string
     */
    public function getNomInstituicao()
    {
        return $this->nomInstituicao;
    }

    /**
     * OneToMany (owning side)
     * Add CseQualificacaoEscolar
     *
     * @param \Urbem\CoreBundle\Entity\Cse\QualificacaoEscolar $fkCseQualificacaoEscolar
     * @return InstituicaoEducacional
     */
    public function addFkCseQualificacaoEscolares(\Urbem\CoreBundle\Entity\Cse\QualificacaoEscolar $fkCseQualificacaoEscolar)
    {
        if (false === $this->fkCseQualificacaoEscolares->contains($fkCseQualificacaoEscolar)) {
            $fkCseQualificacaoEscolar->setFkCseInstituicaoEducacional($this);
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
