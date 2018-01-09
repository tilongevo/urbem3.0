<?php
 
namespace Urbem\CoreBundle\Entity\Ppa;

/**
 * Periodicidade
 */
class Periodicidade
{
    /**
     * PK
     * @var integer
     */
    private $codPeriodicidade;

    /**
     * @var string
     */
    private $nomPeriodicidade;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ldo\Homologacao
     */
    private $fkLdoHomologacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\PpaEncaminhamento
     */
    private $fkPpaPpaEncaminhamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\ProgramaIndicadores
     */
    private $fkPpaProgramaIndicadoreses;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkLdoHomologacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPpaPpaEncaminhamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPpaProgramaIndicadoreses = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codPeriodicidade
     *
     * @param integer $codPeriodicidade
     * @return Periodicidade
     */
    public function setCodPeriodicidade($codPeriodicidade)
    {
        $this->codPeriodicidade = $codPeriodicidade;
        return $this;
    }

    /**
     * Get codPeriodicidade
     *
     * @return integer
     */
    public function getCodPeriodicidade()
    {
        return $this->codPeriodicidade;
    }

    /**
     * Set nomPeriodicidade
     *
     * @param string $nomPeriodicidade
     * @return Periodicidade
     */
    public function setNomPeriodicidade($nomPeriodicidade)
    {
        $this->nomPeriodicidade = $nomPeriodicidade;
        return $this;
    }

    /**
     * Get nomPeriodicidade
     *
     * @return string
     */
    public function getNomPeriodicidade()
    {
        return $this->nomPeriodicidade;
    }

    /**
     * OneToMany (owning side)
     * Add LdoHomologacao
     *
     * @param \Urbem\CoreBundle\Entity\Ldo\Homologacao $fkLdoHomologacao
     * @return Periodicidade
     */
    public function addFkLdoHomologacoes(\Urbem\CoreBundle\Entity\Ldo\Homologacao $fkLdoHomologacao)
    {
        if (false === $this->fkLdoHomologacoes->contains($fkLdoHomologacao)) {
            $fkLdoHomologacao->setFkPpaPeriodicidade($this);
            $this->fkLdoHomologacoes->add($fkLdoHomologacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LdoHomologacao
     *
     * @param \Urbem\CoreBundle\Entity\Ldo\Homologacao $fkLdoHomologacao
     */
    public function removeFkLdoHomologacoes(\Urbem\CoreBundle\Entity\Ldo\Homologacao $fkLdoHomologacao)
    {
        $this->fkLdoHomologacoes->removeElement($fkLdoHomologacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkLdoHomologacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ldo\Homologacao
     */
    public function getFkLdoHomologacoes()
    {
        return $this->fkLdoHomologacoes;
    }

    /**
     * OneToMany (owning side)
     * Add PpaPpaEncaminhamento
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\PpaEncaminhamento $fkPpaPpaEncaminhamento
     * @return Periodicidade
     */
    public function addFkPpaPpaEncaminhamentos(\Urbem\CoreBundle\Entity\Ppa\PpaEncaminhamento $fkPpaPpaEncaminhamento)
    {
        if (false === $this->fkPpaPpaEncaminhamentos->contains($fkPpaPpaEncaminhamento)) {
            $fkPpaPpaEncaminhamento->setFkPpaPeriodicidade($this);
            $this->fkPpaPpaEncaminhamentos->add($fkPpaPpaEncaminhamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PpaPpaEncaminhamento
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\PpaEncaminhamento $fkPpaPpaEncaminhamento
     */
    public function removeFkPpaPpaEncaminhamentos(\Urbem\CoreBundle\Entity\Ppa\PpaEncaminhamento $fkPpaPpaEncaminhamento)
    {
        $this->fkPpaPpaEncaminhamentos->removeElement($fkPpaPpaEncaminhamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkPpaPpaEncaminhamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\PpaEncaminhamento
     */
    public function getFkPpaPpaEncaminhamentos()
    {
        return $this->fkPpaPpaEncaminhamentos;
    }

    /**
     * OneToMany (owning side)
     * Add PpaProgramaIndicadores
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\ProgramaIndicadores $fkPpaProgramaIndicadores
     * @return Periodicidade
     */
    public function addFkPpaProgramaIndicadoreses(\Urbem\CoreBundle\Entity\Ppa\ProgramaIndicadores $fkPpaProgramaIndicadores)
    {
        if (false === $this->fkPpaProgramaIndicadoreses->contains($fkPpaProgramaIndicadores)) {
            $fkPpaProgramaIndicadores->setFkPpaPeriodicidade($this);
            $this->fkPpaProgramaIndicadoreses->add($fkPpaProgramaIndicadores);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PpaProgramaIndicadores
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\ProgramaIndicadores $fkPpaProgramaIndicadores
     */
    public function removeFkPpaProgramaIndicadoreses(\Urbem\CoreBundle\Entity\Ppa\ProgramaIndicadores $fkPpaProgramaIndicadores)
    {
        $this->fkPpaProgramaIndicadoreses->removeElement($fkPpaProgramaIndicadores);
    }

    /**
     * OneToMany (owning side)
     * Get fkPpaProgramaIndicadoreses
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\ProgramaIndicadores
     */
    public function getFkPpaProgramaIndicadoreses()
    {
        return $this->fkPpaProgramaIndicadoreses;
    }
}
