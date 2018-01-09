<?php
 
namespace Urbem\CoreBundle\Entity\Patrimonio;

/**
 * Inventario
 */
class Inventario
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
    private $idInventario;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var \DateTime
     */
    private $dtInicio;

    /**
     * @var \DateTime
     */
    private $dtFim;

    /**
     * @var string
     */
    private $observacao;

    /**
     * @var boolean
     */
    private $processado = false;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem
     */
    private $fkPatrimonioInventarioHistoricoBens;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPatrimonioInventarioHistoricoBens = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Inventario
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
     * Set idInventario
     *
     * @param integer $idInventario
     * @return Inventario
     */
    public function setIdInventario($idInventario)
    {
        $this->idInventario = $idInventario;
        return $this;
    }

    /**
     * Get idInventario
     *
     * @return integer
     */
    public function getIdInventario()
    {
        return $this->idInventario;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return Inventario
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set dtInicio
     *
     * @param \DateTime $dtInicio
     * @return Inventario
     */
    public function setDtInicio(\DateTime $dtInicio)
    {
        $this->dtInicio = $dtInicio;
        return $this;
    }

    /**
     * Get dtInicio
     *
     * @return \DateTime
     */
    public function getDtInicio()
    {
        return $this->dtInicio;
    }

    /**
     * Set dtFim
     *
     * @param \DateTime $dtFim
     * @return Inventario
     */
    public function setDtFim(\DateTime $dtFim = null)
    {
        $this->dtFim = $dtFim;
        return $this;
    }

    /**
     * Get dtFim
     *
     * @return \DateTime
     */
    public function getDtFim()
    {
        return $this->dtFim;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return Inventario
     */
    public function setObservacao($observacao = null)
    {
        $this->observacao = $observacao;
        return $this;
    }

    /**
     * Get observacao
     *
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * Set processado
     *
     * @param boolean $processado
     * @return Inventario
     */
    public function setProcessado($processado)
    {
        $this->processado = $processado;
        return $this;
    }

    /**
     * Get processado
     *
     * @return boolean
     */
    public function getProcessado()
    {
        return $this->processado;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioInventarioHistoricoBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem $fkPatrimonioInventarioHistoricoBem
     * @return Inventario
     */
    public function addFkPatrimonioInventarioHistoricoBens(\Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem $fkPatrimonioInventarioHistoricoBem)
    {
        if (false === $this->fkPatrimonioInventarioHistoricoBens->contains($fkPatrimonioInventarioHistoricoBem)) {
            $fkPatrimonioInventarioHistoricoBem->setFkPatrimonioInventario($this);
            $this->fkPatrimonioInventarioHistoricoBens->add($fkPatrimonioInventarioHistoricoBem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioInventarioHistoricoBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem $fkPatrimonioInventarioHistoricoBem
     */
    public function removeFkPatrimonioInventarioHistoricoBens(\Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem $fkPatrimonioInventarioHistoricoBem)
    {
        $this->fkPatrimonioInventarioHistoricoBens->removeElement($fkPatrimonioInventarioHistoricoBem);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioInventarioHistoricoBens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem
     */
    public function getFkPatrimonioInventarioHistoricoBens()
    {
        return $this->fkPatrimonioInventarioHistoricoBens;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return Inventario
     */
    public function setFkAdministracaoUsuario(\Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario)
    {
        $this->numcgm = $fkAdministracaoUsuario->getNumcgm();
        $this->fkAdministracaoUsuario = $fkAdministracaoUsuario;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoUsuario
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    public function getFkAdministracaoUsuario()
    {
        return $this->fkAdministracaoUsuario;
    }
}
