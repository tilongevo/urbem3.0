<?php
 
namespace Urbem\CoreBundle\Entity\Tceal;

/**
 * TipoCargo
 */
class TipoCargo
{
    /**
     * PK
     * @var integer
     */
    private $codTipoCargo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceal\DeParaTipoCargo
     */
    private $fkTcealDeParaTipoCargos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcealDeParaTipoCargos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoCargo
     *
     * @param integer $codTipoCargo
     * @return TipoCargo
     */
    public function setCodTipoCargo($codTipoCargo)
    {
        $this->codTipoCargo = $codTipoCargo;
        return $this;
    }

    /**
     * Get codTipoCargo
     *
     * @return integer
     */
    public function getCodTipoCargo()
    {
        return $this->codTipoCargo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoCargo
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
     * Add TcealDeParaTipoCargo
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\DeParaTipoCargo $fkTcealDeParaTipoCargo
     * @return TipoCargo
     */
    public function addFkTcealDeParaTipoCargos(\Urbem\CoreBundle\Entity\Tceal\DeParaTipoCargo $fkTcealDeParaTipoCargo)
    {
        if (false === $this->fkTcealDeParaTipoCargos->contains($fkTcealDeParaTipoCargo)) {
            $fkTcealDeParaTipoCargo->setFkTcealTipoCargo($this);
            $this->fkTcealDeParaTipoCargos->add($fkTcealDeParaTipoCargo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcealDeParaTipoCargo
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\DeParaTipoCargo $fkTcealDeParaTipoCargo
     */
    public function removeFkTcealDeParaTipoCargos(\Urbem\CoreBundle\Entity\Tceal\DeParaTipoCargo $fkTcealDeParaTipoCargo)
    {
        $this->fkTcealDeParaTipoCargos->removeElement($fkTcealDeParaTipoCargo);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcealDeParaTipoCargos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceal\DeParaTipoCargo
     */
    public function getFkTcealDeParaTipoCargos()
    {
        return $this->fkTcealDeParaTipoCargos;
    }
}
