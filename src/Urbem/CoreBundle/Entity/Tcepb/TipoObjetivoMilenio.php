<?php
 
namespace Urbem\CoreBundle\Entity\Tcepb;

/**
 * TipoObjetivoMilenio
 */
class TipoObjetivoMilenio
{
    /**
     * PK
     * @var integer
     */
    private $codTipoObjetivo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepb\ProgramaObjetivoMilenio
     */
    private $fkTcepbProgramaObjetivoMilenios;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcepbProgramaObjetivoMilenios = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoObjetivo
     *
     * @param integer $codTipoObjetivo
     * @return TipoObjetivoMilenio
     */
    public function setCodTipoObjetivo($codTipoObjetivo)
    {
        $this->codTipoObjetivo = $codTipoObjetivo;
        return $this;
    }

    /**
     * Get codTipoObjetivo
     *
     * @return integer
     */
    public function getCodTipoObjetivo()
    {
        return $this->codTipoObjetivo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoObjetivoMilenio
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
     * Add TcepbProgramaObjetivoMilenio
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\ProgramaObjetivoMilenio $fkTcepbProgramaObjetivoMilenio
     * @return TipoObjetivoMilenio
     */
    public function addFkTcepbProgramaObjetivoMilenios(\Urbem\CoreBundle\Entity\Tcepb\ProgramaObjetivoMilenio $fkTcepbProgramaObjetivoMilenio)
    {
        if (false === $this->fkTcepbProgramaObjetivoMilenios->contains($fkTcepbProgramaObjetivoMilenio)) {
            $fkTcepbProgramaObjetivoMilenio->setFkTcepbTipoObjetivoMilenio($this);
            $this->fkTcepbProgramaObjetivoMilenios->add($fkTcepbProgramaObjetivoMilenio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepbProgramaObjetivoMilenio
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\ProgramaObjetivoMilenio $fkTcepbProgramaObjetivoMilenio
     */
    public function removeFkTcepbProgramaObjetivoMilenios(\Urbem\CoreBundle\Entity\Tcepb\ProgramaObjetivoMilenio $fkTcepbProgramaObjetivoMilenio)
    {
        $this->fkTcepbProgramaObjetivoMilenios->removeElement($fkTcepbProgramaObjetivoMilenio);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepbProgramaObjetivoMilenios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepb\ProgramaObjetivoMilenio
     */
    public function getFkTcepbProgramaObjetivoMilenios()
    {
        return $this->fkTcepbProgramaObjetivoMilenios;
    }
}
