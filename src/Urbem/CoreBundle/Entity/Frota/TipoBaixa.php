<?php
 
namespace Urbem\CoreBundle\Entity\Frota;

/**
 * TipoBaixa
 */
class TipoBaixa
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\VeiculoBaixado
     */
    private $fkFrotaVeiculoBaixados;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFrotaVeiculoBaixados = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoBaixa
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
     * @return TipoBaixa
     */
    public function setDescricao($descricao = null)
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
     * Add FrotaVeiculoBaixado
     *
     * @param \Urbem\CoreBundle\Entity\Frota\VeiculoBaixado $fkFrotaVeiculoBaixado
     * @return TipoBaixa
     */
    public function addFkFrotaVeiculoBaixados(\Urbem\CoreBundle\Entity\Frota\VeiculoBaixado $fkFrotaVeiculoBaixado)
    {
        if (false === $this->fkFrotaVeiculoBaixados->contains($fkFrotaVeiculoBaixado)) {
            $fkFrotaVeiculoBaixado->setFkFrotaTipoBaixa($this);
            $this->fkFrotaVeiculoBaixados->add($fkFrotaVeiculoBaixado);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaVeiculoBaixado
     *
     * @param \Urbem\CoreBundle\Entity\Frota\VeiculoBaixado $fkFrotaVeiculoBaixado
     */
    public function removeFkFrotaVeiculoBaixados(\Urbem\CoreBundle\Entity\Frota\VeiculoBaixado $fkFrotaVeiculoBaixado)
    {
        $this->fkFrotaVeiculoBaixados->removeElement($fkFrotaVeiculoBaixado);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaVeiculoBaixados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\VeiculoBaixado
     */
    public function getFkFrotaVeiculoBaixados()
    {
        return $this->fkFrotaVeiculoBaixados;
    }
}
