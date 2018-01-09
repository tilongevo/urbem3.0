<?php
 
namespace Urbem\CoreBundle\Entity\Tcern;

/**
 * Royalties
 */
class Royalties
{
    /**
     * PK
     * @var integer
     */
    private $codRoyalties;

    /**
     * @var string
     */
    private $codigo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\RoyaltiesEmpenho
     */
    private $fkTcernRoyaltiesEmpenhos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcernRoyaltiesEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codRoyalties
     *
     * @param integer $codRoyalties
     * @return Royalties
     */
    public function setCodRoyalties($codRoyalties)
    {
        $this->codRoyalties = $codRoyalties;
        return $this;
    }

    /**
     * Get codRoyalties
     *
     * @return integer
     */
    public function getCodRoyalties()
    {
        return $this->codRoyalties;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     * @return Royalties
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
        return $this;
    }

    /**
     * Get codigo
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * OneToMany (owning side)
     * Add TcernRoyaltiesEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\RoyaltiesEmpenho $fkTcernRoyaltiesEmpenho
     * @return Royalties
     */
    public function addFkTcernRoyaltiesEmpenhos(\Urbem\CoreBundle\Entity\Tcern\RoyaltiesEmpenho $fkTcernRoyaltiesEmpenho)
    {
        if (false === $this->fkTcernRoyaltiesEmpenhos->contains($fkTcernRoyaltiesEmpenho)) {
            $fkTcernRoyaltiesEmpenho->setFkTcernRoyalties($this);
            $this->fkTcernRoyaltiesEmpenhos->add($fkTcernRoyaltiesEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcernRoyaltiesEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\RoyaltiesEmpenho $fkTcernRoyaltiesEmpenho
     */
    public function removeFkTcernRoyaltiesEmpenhos(\Urbem\CoreBundle\Entity\Tcern\RoyaltiesEmpenho $fkTcernRoyaltiesEmpenho)
    {
        $this->fkTcernRoyaltiesEmpenhos->removeElement($fkTcernRoyaltiesEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcernRoyaltiesEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\RoyaltiesEmpenho
     */
    public function getFkTcernRoyaltiesEmpenhos()
    {
        return $this->fkTcernRoyaltiesEmpenhos;
    }
}
