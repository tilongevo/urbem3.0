<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * TipoObra
 */
class TipoObra
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\Obra
     */
    private $fkTcmbaObras;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmbaObras = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoObra
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
     * @return TipoObra
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
     * Add TcmbaObra
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\Obra $fkTcmbaObra
     * @return TipoObra
     */
    public function addFkTcmbaObras(\Urbem\CoreBundle\Entity\Tcmba\Obra $fkTcmbaObra)
    {
        if (false === $this->fkTcmbaObras->contains($fkTcmbaObra)) {
            $fkTcmbaObra->setFkTcmbaTipoObra($this);
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
}
