<?php
 
namespace Urbem\CoreBundle\Entity\Manad;

/**
 * CaracPeculiarReceita
 */
class CaracPeculiarReceita
{
    /**
     * PK
     * @var integer
     */
    private $codCaracteristica;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Manad\ReceitaCaracPeculiarReceita
     */
    private $fkManadReceitaCaracPeculiarReceitas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkManadReceitaCaracPeculiarReceitas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codCaracteristica
     *
     * @param integer $codCaracteristica
     * @return CaracPeculiarReceita
     */
    public function setCodCaracteristica($codCaracteristica)
    {
        $this->codCaracteristica = $codCaracteristica;
        return $this;
    }

    /**
     * Get codCaracteristica
     *
     * @return integer
     */
    public function getCodCaracteristica()
    {
        return $this->codCaracteristica;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return CaracPeculiarReceita
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * OneToMany (owning side)
     * Add ManadReceitaCaracPeculiarReceita
     *
     * @param \Urbem\CoreBundle\Entity\Manad\ReceitaCaracPeculiarReceita $fkManadReceitaCaracPeculiarReceita
     * @return CaracPeculiarReceita
     */
    public function addFkManadReceitaCaracPeculiarReceitas(\Urbem\CoreBundle\Entity\Manad\ReceitaCaracPeculiarReceita $fkManadReceitaCaracPeculiarReceita)
    {
        if (false === $this->fkManadReceitaCaracPeculiarReceitas->contains($fkManadReceitaCaracPeculiarReceita)) {
            $fkManadReceitaCaracPeculiarReceita->setFkManadCaracPeculiarReceita($this);
            $this->fkManadReceitaCaracPeculiarReceitas->add($fkManadReceitaCaracPeculiarReceita);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ManadReceitaCaracPeculiarReceita
     *
     * @param \Urbem\CoreBundle\Entity\Manad\ReceitaCaracPeculiarReceita $fkManadReceitaCaracPeculiarReceita
     */
    public function removeFkManadReceitaCaracPeculiarReceitas(\Urbem\CoreBundle\Entity\Manad\ReceitaCaracPeculiarReceita $fkManadReceitaCaracPeculiarReceita)
    {
        $this->fkManadReceitaCaracPeculiarReceitas->removeElement($fkManadReceitaCaracPeculiarReceita);
    }

    /**
     * OneToMany (owning side)
     * Get fkManadReceitaCaracPeculiarReceitas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Manad\ReceitaCaracPeculiarReceita
     */
    public function getFkManadReceitaCaracPeculiarReceitas()
    {
        return $this->fkManadReceitaCaracPeculiarReceitas;
    }
}
