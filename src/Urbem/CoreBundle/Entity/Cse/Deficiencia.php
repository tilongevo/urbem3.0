<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * Deficiencia
 */
class Deficiencia
{
    /**
     * PK
     * @var integer
     */
    private $codDeficiencia;

    /**
     * @var string
     */
    private $nomDeficiencia;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\Cidadao
     */
    private $fkCseCidadoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkCseCidadoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codDeficiencia
     *
     * @param integer $codDeficiencia
     * @return Deficiencia
     */
    public function setCodDeficiencia($codDeficiencia)
    {
        $this->codDeficiencia = $codDeficiencia;
        return $this;
    }

    /**
     * Get codDeficiencia
     *
     * @return integer
     */
    public function getCodDeficiencia()
    {
        return $this->codDeficiencia;
    }

    /**
     * Set nomDeficiencia
     *
     * @param string $nomDeficiencia
     * @return Deficiencia
     */
    public function setNomDeficiencia($nomDeficiencia)
    {
        $this->nomDeficiencia = $nomDeficiencia;
        return $this;
    }

    /**
     * Get nomDeficiencia
     *
     * @return string
     */
    public function getNomDeficiencia()
    {
        return $this->nomDeficiencia;
    }

    /**
     * OneToMany (owning side)
     * Add CseCidadao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao
     * @return Deficiencia
     */
    public function addFkCseCidadoes(\Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao)
    {
        if (false === $this->fkCseCidadoes->contains($fkCseCidadao)) {
            $fkCseCidadao->setFkCseDeficiencia($this);
            $this->fkCseCidadoes->add($fkCseCidadao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CseCidadao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao
     */
    public function removeFkCseCidadoes(\Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao)
    {
        $this->fkCseCidadoes->removeElement($fkCseCidadao);
    }

    /**
     * OneToMany (owning side)
     * Get fkCseCidadoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\Cidadao
     */
    public function getFkCseCidadoes()
    {
        return $this->fkCseCidadoes;
    }
}
