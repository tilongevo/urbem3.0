<?php
 
namespace Urbem\CoreBundle\Entity\Tcers;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcers\ReceitaCaracPeculiarReceita
     */
    private $fkTcersReceitaCaracPeculiarReceitas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcersReceitaCaracPeculiarReceitas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add TcersReceitaCaracPeculiarReceita
     *
     * @param \Urbem\CoreBundle\Entity\Tcers\ReceitaCaracPeculiarReceita $fkTcersReceitaCaracPeculiarReceita
     * @return CaracPeculiarReceita
     */
    public function addFkTcersReceitaCaracPeculiarReceitas(\Urbem\CoreBundle\Entity\Tcers\ReceitaCaracPeculiarReceita $fkTcersReceitaCaracPeculiarReceita)
    {
        if (false === $this->fkTcersReceitaCaracPeculiarReceitas->contains($fkTcersReceitaCaracPeculiarReceita)) {
            $fkTcersReceitaCaracPeculiarReceita->setFkTcersCaracPeculiarReceita($this);
            $this->fkTcersReceitaCaracPeculiarReceitas->add($fkTcersReceitaCaracPeculiarReceita);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcersReceitaCaracPeculiarReceita
     *
     * @param \Urbem\CoreBundle\Entity\Tcers\ReceitaCaracPeculiarReceita $fkTcersReceitaCaracPeculiarReceita
     */
    public function removeFkTcersReceitaCaracPeculiarReceitas(\Urbem\CoreBundle\Entity\Tcers\ReceitaCaracPeculiarReceita $fkTcersReceitaCaracPeculiarReceita)
    {
        $this->fkTcersReceitaCaracPeculiarReceitas->removeElement($fkTcersReceitaCaracPeculiarReceita);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcersReceitaCaracPeculiarReceitas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcers\ReceitaCaracPeculiarReceita
     */
    public function getFkTcersReceitaCaracPeculiarReceitas()
    {
        return $this->fkTcersReceitaCaracPeculiarReceitas;
    }
}
