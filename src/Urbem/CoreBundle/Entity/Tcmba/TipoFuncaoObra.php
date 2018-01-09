<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * TipoFuncaoObra
 */
class TipoFuncaoObra
{
    /**
     * PK
     * @var integer
     */
    private $codFuncao;

    /**
     * @var string
     */
    private $nroFuncao;

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
     * Set codFuncao
     *
     * @param integer $codFuncao
     * @return TipoFuncaoObra
     */
    public function setCodFuncao($codFuncao)
    {
        $this->codFuncao = $codFuncao;
        return $this;
    }

    /**
     * Get codFuncao
     *
     * @return integer
     */
    public function getCodFuncao()
    {
        return $this->codFuncao;
    }

    /**
     * Set nroFuncao
     *
     * @param string $nroFuncao
     * @return TipoFuncaoObra
     */
    public function setNroFuncao($nroFuncao)
    {
        $this->nroFuncao = $nroFuncao;
        return $this;
    }

    /**
     * Get nroFuncao
     *
     * @return string
     */
    public function getNroFuncao()
    {
        return $this->nroFuncao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoFuncaoObra
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
     * @return TipoFuncaoObra
     */
    public function addFkTcmbaObras(\Urbem\CoreBundle\Entity\Tcmba\Obra $fkTcmbaObra)
    {
        if (false === $this->fkTcmbaObras->contains($fkTcmbaObra)) {
            $fkTcmbaObra->setFkTcmbaTipoFuncaoObra($this);
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
