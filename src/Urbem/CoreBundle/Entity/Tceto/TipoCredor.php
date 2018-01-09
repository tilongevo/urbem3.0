<?php
 
namespace Urbem\CoreBundle\Entity\Tceto;

/**
 * TipoCredor
 */
class TipoCredor
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceto\Credor
     */
    private $fkTcetoCredores;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcetoCredores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoCredor
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoCredor
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
     * Add TcetoCredor
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\Credor $fkTcetoCredor
     * @return TipoCredor
     */
    public function addFkTcetoCredores(\Urbem\CoreBundle\Entity\Tceto\Credor $fkTcetoCredor)
    {
        if (false === $this->fkTcetoCredores->contains($fkTcetoCredor)) {
            $fkTcetoCredor->setFkTcetoTipoCredor($this);
            $this->fkTcetoCredores->add($fkTcetoCredor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcetoCredor
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\Credor $fkTcetoCredor
     */
    public function removeFkTcetoCredores(\Urbem\CoreBundle\Entity\Tceto\Credor $fkTcetoCredor)
    {
        $this->fkTcetoCredores->removeElement($fkTcetoCredor);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcetoCredores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceto\Credor
     */
    public function getFkTcetoCredores()
    {
        return $this->fkTcetoCredores;
    }
}
