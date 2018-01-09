<?php

namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * Corretagem
 */
class Corretagem
{
    /**
     * PK
     * @var string
     */
    private $creci;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Imobiliaria
     */
    private $fkImobiliarioImobiliaria;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Corretor
     */
    private $fkImobiliarioCorretor;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ImovelImobiliaria
     */
    private $fkImobiliarioImovelImobiliarias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaCorretagem
     */
    private $fkImobiliarioTransferenciaCorretagens;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImobiliarioImovelImobiliarias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioTransferenciaCorretagens = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set creci
     *
     * @param string $creci
     * @return Corretagem
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
     * OneToMany (owning side)
     * Add ImobiliarioImovelImobiliaria
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ImovelImobiliaria $fkImobiliarioImovelImobiliaria
     * @return Corretagem
     */
    public function addFkImobiliarioImovelImobiliarias(\Urbem\CoreBundle\Entity\Imobiliario\ImovelImobiliaria $fkImobiliarioImovelImobiliaria)
    {
        if (false === $this->fkImobiliarioImovelImobiliarias->contains($fkImobiliarioImovelImobiliaria)) {
            $fkImobiliarioImovelImobiliaria->setFkImobiliarioCorretagem($this);
            $this->fkImobiliarioImovelImobiliarias->add($fkImobiliarioImovelImobiliaria);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioImovelImobiliaria
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ImovelImobiliaria $fkImobiliarioImovelImobiliaria
     */
    public function removeFkImobiliarioImovelImobiliarias(\Urbem\CoreBundle\Entity\Imobiliario\ImovelImobiliaria $fkImobiliarioImovelImobiliaria)
    {
        $this->fkImobiliarioImovelImobiliarias->removeElement($fkImobiliarioImovelImobiliaria);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioImovelImobiliarias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ImovelImobiliaria
     */
    public function getFkImobiliarioImovelImobiliarias()
    {
        return $this->fkImobiliarioImovelImobiliarias;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioTransferenciaCorretagem
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaCorretagem $fkImobiliarioTransferenciaCorretagem
     * @return Corretagem
     */
    public function addFkImobiliarioTransferenciaCorretagens(\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaCorretagem $fkImobiliarioTransferenciaCorretagem)
    {
        if (false === $this->fkImobiliarioTransferenciaCorretagens->contains($fkImobiliarioTransferenciaCorretagem)) {
            $fkImobiliarioTransferenciaCorretagem->setFkImobiliarioCorretagem($this);
            $this->fkImobiliarioTransferenciaCorretagens->add($fkImobiliarioTransferenciaCorretagem);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioTransferenciaCorretagem
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaCorretagem $fkImobiliarioTransferenciaCorretagem
     */
    public function removeFkImobiliarioTransferenciaCorretagens(\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaCorretagem $fkImobiliarioTransferenciaCorretagem)
    {
        $this->fkImobiliarioTransferenciaCorretagens->removeElement($fkImobiliarioTransferenciaCorretagem);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioTransferenciaCorretagens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaCorretagem
     */
    public function getFkImobiliarioTransferenciaCorretagens()
    {
        return $this->fkImobiliarioTransferenciaCorretagens;
    }

    /**
     * OneToOne (inverse side)
     * Set ImobiliarioImobiliaria
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Imobiliaria $fkImobiliarioImobiliaria
     * @return Corretagem
     */
    public function setFkImobiliarioImobiliaria(\Urbem\CoreBundle\Entity\Imobiliario\Imobiliaria $fkImobiliarioImobiliaria)
    {
        $fkImobiliarioImobiliaria->setFkImobiliarioCorretagem($this);
        $this->fkImobiliarioImobiliaria = $fkImobiliarioImobiliaria;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkImobiliarioImobiliaria
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Imobiliaria
     */
    public function getFkImobiliarioImobiliaria()
    {
        return $this->fkImobiliarioImobiliaria;
    }

    /**
     * OneToOne (inverse side)
     * Set ImobiliarioCorretor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Corretor $fkImobiliarioCorretor
     * @return Corretagem
     */
    public function setFkImobiliarioCorretor(\Urbem\CoreBundle\Entity\Imobiliario\Corretor $fkImobiliarioCorretor)
    {
        $fkImobiliarioCorretor->setFkImobiliarioCorretagem($this);
        $this->fkImobiliarioCorretor = $fkImobiliarioCorretor;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkImobiliarioCorretor
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Corretor
     */
    public function getFkImobiliarioCorretor()
    {
        return $this->fkImobiliarioCorretor;
    }

    /**
    * @return string
    */
    public function __toString()
    {
        return (string) $this->creci;
    }
}
