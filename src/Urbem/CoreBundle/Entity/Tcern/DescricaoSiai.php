<?php
 
namespace Urbem\CoreBundle\Entity\Tcern;

/**
 * DescricaoSiai
 */
class DescricaoSiai
{
    /**
     * PK
     * @var integer
     */
    private $codSiai;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\SubDivisaoDescricaoSiai
     */
    private $fkTcernSubDivisaoDescricaoSiais;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcernSubDivisaoDescricaoSiais = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codSiai
     *
     * @param integer $codSiai
     * @return DescricaoSiai
     */
    public function setCodSiai($codSiai)
    {
        $this->codSiai = $codSiai;
        return $this;
    }

    /**
     * Get codSiai
     *
     * @return integer
     */
    public function getCodSiai()
    {
        return $this->codSiai;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return DescricaoSiai
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
     * Add TcernSubDivisaoDescricaoSiai
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\SubDivisaoDescricaoSiai $fkTcernSubDivisaoDescricaoSiai
     * @return DescricaoSiai
     */
    public function addFkTcernSubDivisaoDescricaoSiais(\Urbem\CoreBundle\Entity\Tcern\SubDivisaoDescricaoSiai $fkTcernSubDivisaoDescricaoSiai)
    {
        if (false === $this->fkTcernSubDivisaoDescricaoSiais->contains($fkTcernSubDivisaoDescricaoSiai)) {
            $fkTcernSubDivisaoDescricaoSiai->setFkTcernDescricaoSiai($this);
            $this->fkTcernSubDivisaoDescricaoSiais->add($fkTcernSubDivisaoDescricaoSiai);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcernSubDivisaoDescricaoSiai
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\SubDivisaoDescricaoSiai $fkTcernSubDivisaoDescricaoSiai
     */
    public function removeFkTcernSubDivisaoDescricaoSiais(\Urbem\CoreBundle\Entity\Tcern\SubDivisaoDescricaoSiai $fkTcernSubDivisaoDescricaoSiai)
    {
        $this->fkTcernSubDivisaoDescricaoSiais->removeElement($fkTcernSubDivisaoDescricaoSiai);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcernSubDivisaoDescricaoSiais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\SubDivisaoDescricaoSiai
     */
    public function getFkTcernSubDivisaoDescricaoSiais()
    {
        return $this->fkTcernSubDivisaoDescricaoSiais;
    }
}
