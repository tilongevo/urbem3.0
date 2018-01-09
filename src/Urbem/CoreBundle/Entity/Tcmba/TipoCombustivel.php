<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * TipoCombustivel
 */
class TipoCombustivel
{
    /**
     * PK
     * @var integer
     */
    private $codTipoTcm;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\TipoCombustivelVinculo
     */
    private $fkTcmbaTipoCombustivelVinculos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmbaTipoCombustivelVinculos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoTcm
     *
     * @param integer $codTipoTcm
     * @return TipoCombustivel
     */
    public function setCodTipoTcm($codTipoTcm)
    {
        $this->codTipoTcm = $codTipoTcm;
        return $this;
    }

    /**
     * Get codTipoTcm
     *
     * @return integer
     */
    public function getCodTipoTcm()
    {
        return $this->codTipoTcm;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoCombustivel
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
     * Add TcmbaTipoCombustivelVinculo
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\TipoCombustivelVinculo $fkTcmbaTipoCombustivelVinculo
     * @return TipoCombustivel
     */
    public function addFkTcmbaTipoCombustivelVinculos(\Urbem\CoreBundle\Entity\Tcmba\TipoCombustivelVinculo $fkTcmbaTipoCombustivelVinculo)
    {
        if (false === $this->fkTcmbaTipoCombustivelVinculos->contains($fkTcmbaTipoCombustivelVinculo)) {
            $fkTcmbaTipoCombustivelVinculo->setFkTcmbaTipoCombustivel($this);
            $this->fkTcmbaTipoCombustivelVinculos->add($fkTcmbaTipoCombustivelVinculo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaTipoCombustivelVinculo
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\TipoCombustivelVinculo $fkTcmbaTipoCombustivelVinculo
     */
    public function removeFkTcmbaTipoCombustivelVinculos(\Urbem\CoreBundle\Entity\Tcmba\TipoCombustivelVinculo $fkTcmbaTipoCombustivelVinculo)
    {
        $this->fkTcmbaTipoCombustivelVinculos->removeElement($fkTcmbaTipoCombustivelVinculo);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaTipoCombustivelVinculos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\TipoCombustivelVinculo
     */
    public function getFkTcmbaTipoCombustivelVinculos()
    {
        return $this->fkTcmbaTipoCombustivelVinculos;
    }
}
