<?php

namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * Corretor
 */
class Corretor
{
    /**
     * PK
     * @var string
     */
    private $creci;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Corretagem
     */
    private $fkImobiliarioCorretagem;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\Imobiliaria
     */
    private $fkImobiliarioImobiliarias;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    private $fkSwCgmPessoaFisica;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImobiliarioImobiliarias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set creci
     *
     * @param string $creci
     * @return Corretor
     */
    public function setCreci($creci)
    {
        $this->creci = $creci;
        return $this;
    }

    /**
     * Get creci
     *
     * @return string
     */
    public function getCreci()
    {
        return $this->creci;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return Corretor
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioImobiliaria
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Imobiliaria $fkImobiliarioImobiliaria
     * @return Corretor
     */
    public function addFkImobiliarioImobiliarias(\Urbem\CoreBundle\Entity\Imobiliario\Imobiliaria $fkImobiliarioImobiliaria)
    {
        if (false === $this->fkImobiliarioImobiliarias->contains($fkImobiliarioImobiliaria)) {
            $fkImobiliarioImobiliaria->setFkImobiliarioCorretor($this);
            $this->fkImobiliarioImobiliarias->add($fkImobiliarioImobiliaria);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioImobiliaria
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Imobiliaria $fkImobiliarioImobiliaria
     */
    public function removeFkImobiliarioImobiliarias(\Urbem\CoreBundle\Entity\Imobiliario\Imobiliaria $fkImobiliarioImobiliaria)
    {
        $this->fkImobiliarioImobiliarias->removeElement($fkImobiliarioImobiliaria);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioImobiliarias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\Imobiliaria
     */
    public function getFkImobiliarioImobiliarias()
    {
        return $this->fkImobiliarioImobiliarias;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgmPessoaFisica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica
     * @return Corretor
     */
    public function setFkSwCgmPessoaFisica(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica)
    {
        $this->numcgm = $fkSwCgmPessoaFisica->getNumcgm();
        $this->fkSwCgmPessoaFisica = $fkSwCgmPessoaFisica;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgmPessoaFisica
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    public function getFkSwCgmPessoaFisica()
    {
        return $this->fkSwCgmPessoaFisica;
    }

    /**
     * OneToOne (owning side)
     * Set ImobiliarioCorretagem
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Corretagem $fkImobiliarioCorretagem
     * @return Corretor
     */
    public function setFkImobiliarioCorretagem(\Urbem\CoreBundle\Entity\Imobiliario\Corretagem $fkImobiliarioCorretagem)
    {
        $this->creci = $fkImobiliarioCorretagem->getCreci();
        $this->fkImobiliarioCorretagem = $fkImobiliarioCorretagem;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkImobiliarioCorretagem
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Corretagem
     */
    public function getFkImobiliarioCorretagem()
    {
        return $this->fkImobiliarioCorretagem;
    }

    /**
    * @return string
    */
    public function __toString()
    {
        return (string) $this->fkSwCgmPessoaFisica;
    }
}
