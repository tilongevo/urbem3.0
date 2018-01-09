<?php
 
namespace Urbem\CoreBundle\Entity\Tcepe;

/**
 * TipoCredor
 */
class TipoCredor
{
    /**
     * PK
     * @var integer
     */
    private $codTipoCredor;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\CgmTipoCredor
     */
    private $fkTcepeCgmTipoCredores;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcepeCgmTipoCredores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoCredor
     *
     * @param integer $codTipoCredor
     * @return TipoCredor
     */
    public function setCodTipoCredor($codTipoCredor)
    {
        $this->codTipoCredor = $codTipoCredor;
        return $this;
    }

    /**
     * Get codTipoCredor
     *
     * @return integer
     */
    public function getCodTipoCredor()
    {
        return $this->codTipoCredor;
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
     * Add TcepeCgmTipoCredor
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\CgmTipoCredor $fkTcepeCgmTipoCredor
     * @return TipoCredor
     */
    public function addFkTcepeCgmTipoCredores(\Urbem\CoreBundle\Entity\Tcepe\CgmTipoCredor $fkTcepeCgmTipoCredor)
    {
        if (false === $this->fkTcepeCgmTipoCredores->contains($fkTcepeCgmTipoCredor)) {
            $fkTcepeCgmTipoCredor->setFkTcepeTipoCredor($this);
            $this->fkTcepeCgmTipoCredores->add($fkTcepeCgmTipoCredor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepeCgmTipoCredor
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\CgmTipoCredor $fkTcepeCgmTipoCredor
     */
    public function removeFkTcepeCgmTipoCredores(\Urbem\CoreBundle\Entity\Tcepe\CgmTipoCredor $fkTcepeCgmTipoCredor)
    {
        $this->fkTcepeCgmTipoCredores->removeElement($fkTcepeCgmTipoCredor);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepeCgmTipoCredores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\CgmTipoCredor
     */
    public function getFkTcepeCgmTipoCredores()
    {
        return $this->fkTcepeCgmTipoCredores;
    }
}
