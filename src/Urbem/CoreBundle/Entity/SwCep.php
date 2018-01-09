<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwCep
 */
class SwCep
{
    /**
     * PK
     * @var string
     */
    private $cep;

    /**
     * @var string
     */
    private $cepAnterior;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\Obra
     */
    private $fkTcmbaObras;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCepLogradouro
     */
    private $fkSwCepLogradouros;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmbaObras = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwCepLogradouros = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set cep
     *
     * @param string $cep
     * @return SwCep
     */
    public function setCep($cep)
    {
        $this->cep = $cep;
        return $this;
    }

    /**
     * Get cep
     *
     * @return string
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * Set cepAnterior
     *
     * @param string $cepAnterior
     * @return SwCep
     */
    public function setCepAnterior($cepAnterior)
    {
        $this->cepAnterior = $cepAnterior;
        return $this;
    }

    /**
     * Get cepAnterior
     *
     * @return string
     */
    public function getCepAnterior()
    {
        return $this->cepAnterior;
    }

    /**
     * OneToMany (owning side)
     * Add TcmbaObra
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\Obra $fkTcmbaObra
     * @return SwCep
     */
    public function addFkTcmbaObras(\Urbem\CoreBundle\Entity\Tcmba\Obra $fkTcmbaObra)
    {
        if (false === $this->fkTcmbaObras->contains($fkTcmbaObra)) {
            $fkTcmbaObra->setFkSwCep($this);
            $this->fkTcmbaObras->add($fkTcmbaObra);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaObra
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\Obra $fkTcmbaObra
     */
    public function removeFkTcmbaObras(\Urbem\CoreBundle\Entity\Tcmba\Obra $fkTcmbaObra)
    {
        $this->fkTcmbaObras->removeElement($fkTcmbaObra);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaObras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\Obra
     */
    public function getFkTcmbaObras()
    {
        return $this->fkTcmbaObras;
    }

    /**
     * OneToMany (owning side)
     * Add SwCepLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwCepLogradouro $fkSwCepLogradouro
     * @return SwCep
     */
    public function addFkSwCepLogradouros(\Urbem\CoreBundle\Entity\SwCepLogradouro $fkSwCepLogradouro)
    {
        if (false === $this->fkSwCepLogradouros->contains($fkSwCepLogradouro)) {
            $fkSwCepLogradouro->setFkSwCep($this);
            $this->fkSwCepLogradouros->add($fkSwCepLogradouro);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwCepLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwCepLogradouro $fkSwCepLogradouro
     */
    public function removeFkSwCepLogradouros(\Urbem\CoreBundle\Entity\SwCepLogradouro $fkSwCepLogradouro)
    {
        $this->fkSwCepLogradouros->removeElement($fkSwCepLogradouro);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwCepLogradouros
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCepLogradouro
     */
    public function getFkSwCepLogradouros()
    {
        return $this->fkSwCepLogradouros;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getCep();
    }
}
