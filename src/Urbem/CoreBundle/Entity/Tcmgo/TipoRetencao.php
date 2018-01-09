<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * TipoRetencao
 */
class TipoRetencao
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\DeParaTipoRetencao
     */
    private $fkTcmgoDeParaTipoRetencoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmgoDeParaTipoRetencoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return TipoRetencao
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
     * @return TipoRetencao
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
     * @return TipoRetencao
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
     * Add TcmgoDeParaTipoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\DeParaTipoRetencao $fkTcmgoDeParaTipoRetencao
     * @return TipoRetencao
     */
    public function addFkTcmgoDeParaTipoRetencoes(\Urbem\CoreBundle\Entity\Tcmgo\DeParaTipoRetencao $fkTcmgoDeParaTipoRetencao)
    {
        if (false === $this->fkTcmgoDeParaTipoRetencoes->contains($fkTcmgoDeParaTipoRetencao)) {
            $fkTcmgoDeParaTipoRetencao->setFkTcmgoTipoRetencao($this);
            $this->fkTcmgoDeParaTipoRetencoes->add($fkTcmgoDeParaTipoRetencao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoDeParaTipoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\DeParaTipoRetencao $fkTcmgoDeParaTipoRetencao
     */
    public function removeFkTcmgoDeParaTipoRetencoes(\Urbem\CoreBundle\Entity\Tcmgo\DeParaTipoRetencao $fkTcmgoDeParaTipoRetencao)
    {
        $this->fkTcmgoDeParaTipoRetencoes->removeElement($fkTcmgoDeParaTipoRetencao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoDeParaTipoRetencoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\DeParaTipoRetencao
     */
    public function getFkTcmgoDeParaTipoRetencoes()
    {
        return $this->fkTcmgoDeParaTipoRetencoes;
    }
}
