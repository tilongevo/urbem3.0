<?php
 
namespace Urbem\CoreBundle\Entity\Tcepb;

/**
 * TipoFonteObras
 */
class TipoFonteObras
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepb\Obras
     */
    private $fkTcepbObras;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcepbObras = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return TipoFonteObras
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoFonteObras
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
     * @return TipoFonteObras
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
     * Add TcepbObras
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\Obras $fkTcepbObras
     * @return TipoFonteObras
     */
    public function addFkTcepbObras(\Urbem\CoreBundle\Entity\Tcepb\Obras $fkTcepbObras)
    {
        if (false === $this->fkTcepbObras->contains($fkTcepbObras)) {
            $fkTcepbObras->setFkTcepbTipoFonteObras($this);
            $this->fkTcepbObras->add($fkTcepbObras);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepbObras
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\Obras $fkTcepbObras
     */
    public function removeFkTcepbObras(\Urbem\CoreBundle\Entity\Tcepb\Obras $fkTcepbObras)
    {
        $this->fkTcepbObras->removeElement($fkTcepbObras);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepbObras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepb\Obras
     */
    public function getFkTcepbObras()
    {
        return $this->fkTcepbObras;
    }
}
