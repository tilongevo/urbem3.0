<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * TipoAlteracaoOrcamentaria
 */
class TipoAlteracaoOrcamentaria
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\LimiteAlteracaoCredito
     */
    private $fkTcmbaLimiteAlteracaoCreditos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmbaLimiteAlteracaoCreditos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoAlteracaoOrcamentaria
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
     * @return TipoAlteracaoOrcamentaria
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
     * Add TcmbaLimiteAlteracaoCredito
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\LimiteAlteracaoCredito $fkTcmbaLimiteAlteracaoCredito
     * @return TipoAlteracaoOrcamentaria
     */
    public function addFkTcmbaLimiteAlteracaoCreditos(\Urbem\CoreBundle\Entity\Tcmba\LimiteAlteracaoCredito $fkTcmbaLimiteAlteracaoCredito)
    {
        if (false === $this->fkTcmbaLimiteAlteracaoCreditos->contains($fkTcmbaLimiteAlteracaoCredito)) {
            $fkTcmbaLimiteAlteracaoCredito->setFkTcmbaTipoAlteracaoOrcamentaria($this);
            $this->fkTcmbaLimiteAlteracaoCreditos->add($fkTcmbaLimiteAlteracaoCredito);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaLimiteAlteracaoCredito
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\LimiteAlteracaoCredito $fkTcmbaLimiteAlteracaoCredito
     */
    public function removeFkTcmbaLimiteAlteracaoCreditos(\Urbem\CoreBundle\Entity\Tcmba\LimiteAlteracaoCredito $fkTcmbaLimiteAlteracaoCredito)
    {
        $this->fkTcmbaLimiteAlteracaoCreditos->removeElement($fkTcmbaLimiteAlteracaoCredito);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaLimiteAlteracaoCreditos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\LimiteAlteracaoCredito
     */
    public function getFkTcmbaLimiteAlteracaoCreditos()
    {
        return $this->fkTcmbaLimiteAlteracaoCreditos;
    }
}
