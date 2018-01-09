<?php
 
namespace Urbem\CoreBundle\Entity\Tcepe;

/**
 * TipoContaBanco
 */
class TipoContaBanco
{
    /**
     * PK
     * @var integer
     */
    private $codTipoContaBanco;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\PlanoBancoTipoContaBanco
     */
    private $fkTcepePlanoBancoTipoContaBancos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcepePlanoBancoTipoContaBancos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoContaBanco
     *
     * @param integer $codTipoContaBanco
     * @return TipoContaBanco
     */
    public function setCodTipoContaBanco($codTipoContaBanco)
    {
        $this->codTipoContaBanco = $codTipoContaBanco;
        return $this;
    }

    /**
     * Get codTipoContaBanco
     *
     * @return integer
     */
    public function getCodTipoContaBanco()
    {
        return $this->codTipoContaBanco;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoContaBanco
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
     * Add TcepePlanoBancoTipoContaBanco
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\PlanoBancoTipoContaBanco $fkTcepePlanoBancoTipoContaBanco
     * @return TipoContaBanco
     */
    public function addFkTcepePlanoBancoTipoContaBancos(\Urbem\CoreBundle\Entity\Tcepe\PlanoBancoTipoContaBanco $fkTcepePlanoBancoTipoContaBanco)
    {
        if (false === $this->fkTcepePlanoBancoTipoContaBancos->contains($fkTcepePlanoBancoTipoContaBanco)) {
            $fkTcepePlanoBancoTipoContaBanco->setFkTcepeTipoContaBanco($this);
            $this->fkTcepePlanoBancoTipoContaBancos->add($fkTcepePlanoBancoTipoContaBanco);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepePlanoBancoTipoContaBanco
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\PlanoBancoTipoContaBanco $fkTcepePlanoBancoTipoContaBanco
     */
    public function removeFkTcepePlanoBancoTipoContaBancos(\Urbem\CoreBundle\Entity\Tcepe\PlanoBancoTipoContaBanco $fkTcepePlanoBancoTipoContaBanco)
    {
        $this->fkTcepePlanoBancoTipoContaBancos->removeElement($fkTcepePlanoBancoTipoContaBanco);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepePlanoBancoTipoContaBancos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\PlanoBancoTipoContaBanco
     */
    public function getFkTcepePlanoBancoTipoContaBancos()
    {
        return $this->fkTcepePlanoBancoTipoContaBancos;
    }
}
