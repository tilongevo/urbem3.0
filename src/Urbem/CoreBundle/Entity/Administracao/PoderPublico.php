<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * PoderPublico
 */
class PoderPublico
{
    /**
     * PK
     * @var integer
     */
    private $codPoder;

    /**
     * @var string
     */
    private $nome;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Medidas
     */
    private $fkTcemgMedidas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcemgMedidas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codPoder
     *
     * @param integer $codPoder
     * @return PoderPublico
     */
    public function setCodPoder($codPoder)
    {
        $this->codPoder = $codPoder;
        return $this;
    }

    /**
     * Get codPoder
     *
     * @return integer
     */
    public function getCodPoder()
    {
        return $this->codPoder;
    }

    /**
     * Set nome
     *
     * @param string $nome
     * @return PoderPublico
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgMedidas
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Medidas $fkTcemgMedidas
     * @return PoderPublico
     */
    public function addFkTcemgMedidas(\Urbem\CoreBundle\Entity\Tcemg\Medidas $fkTcemgMedidas)
    {
        if (false === $this->fkTcemgMedidas->contains($fkTcemgMedidas)) {
            $fkTcemgMedidas->setFkAdministracaoPoderPublico($this);
            $this->fkTcemgMedidas->add($fkTcemgMedidas);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgMedidas
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Medidas $fkTcemgMedidas
     */
    public function removeFkTcemgMedidas(\Urbem\CoreBundle\Entity\Tcemg\Medidas $fkTcemgMedidas)
    {
        $this->fkTcemgMedidas->removeElement($fkTcemgMedidas);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgMedidas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Medidas
     */
    public function getFkTcemgMedidas()
    {
        return $this->fkTcemgMedidas;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->nome;
    }
}
