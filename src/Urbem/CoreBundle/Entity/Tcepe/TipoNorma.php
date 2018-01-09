<?php
 
namespace Urbem\CoreBundle\Entity\Tcepe;

/**
 * TipoNorma
 */
class TipoNorma
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\VinculoTipoNorma
     */
    private $fkTcepeVinculoTipoNormas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcepeVinculoTipoNormas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoNorma
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
     * @return TipoNorma
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
     * Add TcepeVinculoTipoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\VinculoTipoNorma $fkTcepeVinculoTipoNorma
     * @return TipoNorma
     */
    public function addFkTcepeVinculoTipoNormas(\Urbem\CoreBundle\Entity\Tcepe\VinculoTipoNorma $fkTcepeVinculoTipoNorma)
    {
        if (false === $this->fkTcepeVinculoTipoNormas->contains($fkTcepeVinculoTipoNorma)) {
            $fkTcepeVinculoTipoNorma->setFkTcepeTipoNorma($this);
            $this->fkTcepeVinculoTipoNormas->add($fkTcepeVinculoTipoNorma);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepeVinculoTipoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\VinculoTipoNorma $fkTcepeVinculoTipoNorma
     */
    public function removeFkTcepeVinculoTipoNormas(\Urbem\CoreBundle\Entity\Tcepe\VinculoTipoNorma $fkTcepeVinculoTipoNorma)
    {
        $this->fkTcepeVinculoTipoNormas->removeElement($fkTcepeVinculoTipoNorma);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepeVinculoTipoNormas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\VinculoTipoNorma
     */
    public function getFkTcepeVinculoTipoNormas()
    {
        return $this->fkTcepeVinculoTipoNormas;
    }
}
