<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * Sexo
 */
class Sexo
{
    /**
     * PK
     * @var integer
     */
    private $codSexo;

    /**
     * @var string
     */
    private $nomSexo;

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
     * Set codSexo
     *
     * @param integer $codSexo
     * @return Sexo
     */
    public function setCodSexo($codSexo)
    {
        $this->codSexo = $codSexo;
        return $this;
    }

    /**
     * Get codSexo
     *
     * @return integer
     */
    public function getCodSexo()
    {
        return $this->codSexo;
    }

    /**
     * Set nomSexo
     *
     * @param string $nomSexo
     * @return Sexo
     */
    public function setNomSexo($nomSexo)
    {
        $this->nomSexo = $nomSexo;
        return $this;
    }

    /**
     * Get nomSexo
     *
     * @return string
     */
    public function getNomSexo()
    {
        return $this->nomSexo;
    }

    /**
     * OneToMany (owning side)
     * Add CseCidadao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao
     * @return Sexo
     */
    public function addFkCseCidadoes(\Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao)
    {
        if (false === $this->fkCseCidadoes->contains($fkCseCidadao)) {
            $fkCseCidadao->setFkCseSexo($this);
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
