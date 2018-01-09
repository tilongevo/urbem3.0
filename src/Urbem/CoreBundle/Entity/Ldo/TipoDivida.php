<?php
 
namespace Urbem\CoreBundle\Entity\Ldo;

/**
 * TipoDivida
 */
class TipoDivida
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ldo\ConfiguracaoDivida
     */
    private $fkLdoConfiguracaoDividas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkLdoConfiguracaoDividas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoDivida
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
     * @return TipoDivida
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
     * Add LdoConfiguracaoDivida
     *
     * @param \Urbem\CoreBundle\Entity\Ldo\ConfiguracaoDivida $fkLdoConfiguracaoDivida
     * @return TipoDivida
     */
    public function addFkLdoConfiguracaoDividas(\Urbem\CoreBundle\Entity\Ldo\ConfiguracaoDivida $fkLdoConfiguracaoDivida)
    {
        if (false === $this->fkLdoConfiguracaoDividas->contains($fkLdoConfiguracaoDivida)) {
            $fkLdoConfiguracaoDivida->setFkLdoTipoDivida($this);
            $this->fkLdoConfiguracaoDividas->add($fkLdoConfiguracaoDivida);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LdoConfiguracaoDivida
     *
     * @param \Urbem\CoreBundle\Entity\Ldo\ConfiguracaoDivida $fkLdoConfiguracaoDivida
     */
    public function removeFkLdoConfiguracaoDividas(\Urbem\CoreBundle\Entity\Ldo\ConfiguracaoDivida $fkLdoConfiguracaoDivida)
    {
        $this->fkLdoConfiguracaoDividas->removeElement($fkLdoConfiguracaoDivida);
    }

    /**
     * OneToMany (owning side)
     * Get fkLdoConfiguracaoDividas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ldo\ConfiguracaoDivida
     */
    public function getFkLdoConfiguracaoDividas()
    {
        return $this->fkLdoConfiguracaoDividas;
    }
}
