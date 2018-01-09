<?php
 
namespace Urbem\CoreBundle\Entity\Tcern;

/**
 * Fundeb
 */
class Fundeb
{
    /**
     * PK
     * @var integer
     */
    private $codFundeb;

    /**
     * @var string
     */
    private $codigo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\FundebEmpenho
     */
    private $fkTcernFundebEmpenhos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcernFundebEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codFundeb
     *
     * @param integer $codFundeb
     * @return Fundeb
     */
    public function setCodFundeb($codFundeb)
    {
        $this->codFundeb = $codFundeb;
        return $this;
    }

    /**
     * Get codFundeb
     *
     * @return integer
     */
    public function getCodFundeb()
    {
        return $this->codFundeb;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     * @return Fundeb
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
     * Add TcernFundebEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\FundebEmpenho $fkTcernFundebEmpenho
     * @return Fundeb
     */
    public function addFkTcernFundebEmpenhos(\Urbem\CoreBundle\Entity\Tcern\FundebEmpenho $fkTcernFundebEmpenho)
    {
        if (false === $this->fkTcernFundebEmpenhos->contains($fkTcernFundebEmpenho)) {
            $fkTcernFundebEmpenho->setFkTcernFundeb($this);
            $this->fkTcernFundebEmpenhos->add($fkTcernFundebEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcernFundebEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\FundebEmpenho $fkTcernFundebEmpenho
     */
    public function removeFkTcernFundebEmpenhos(\Urbem\CoreBundle\Entity\Tcern\FundebEmpenho $fkTcernFundebEmpenho)
    {
        $this->fkTcernFundebEmpenhos->removeElement($fkTcernFundebEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcernFundebEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\FundebEmpenho
     */
    public function getFkTcernFundebEmpenhos()
    {
        return $this->fkTcernFundebEmpenhos;
    }
}
