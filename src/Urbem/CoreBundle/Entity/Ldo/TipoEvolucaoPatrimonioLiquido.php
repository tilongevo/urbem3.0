<?php
 
namespace Urbem\CoreBundle\Entity\Ldo;

/**
 * TipoEvolucaoPatrimonioLiquido
 */
class TipoEvolucaoPatrimonioLiquido
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * PK
     * @var boolean
     */
    private $rpps;

    /**
     * @var string
     */
    private $codEstrutural;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ldo\ConfiguracaoEvolucaoPatrimonioLiquido
     */
    private $fkLdoConfiguracaoEvolucaoPatrimonioLiquidos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkLdoConfiguracaoEvolucaoPatrimonioLiquidos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoEvolucaoPatrimonioLiquido
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
     * Set rpps
     *
     * @param boolean $rpps
     * @return TipoEvolucaoPatrimonioLiquido
     */
    public function setRpps($rpps)
    {
        $this->rpps = $rpps;
        return $this;
    }

    /**
     * Get rpps
     *
     * @return boolean
     */
    public function getRpps()
    {
        return $this->rpps;
    }

    /**
     * Set codEstrutural
     *
     * @param string $codEstrutural
     * @return TipoEvolucaoPatrimonioLiquido
     */
    public function setCodEstrutural($codEstrutural)
    {
        $this->codEstrutural = $codEstrutural;
        return $this;
    }

    /**
     * Get codEstrutural
     *
     * @return string
     */
    public function getCodEstrutural()
    {
        return $this->codEstrutural;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoEvolucaoPatrimonioLiquido
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
     * Add LdoConfiguracaoEvolucaoPatrimonioLiquido
     *
     * @param \Urbem\CoreBundle\Entity\Ldo\ConfiguracaoEvolucaoPatrimonioLiquido $fkLdoConfiguracaoEvolucaoPatrimonioLiquido
     * @return TipoEvolucaoPatrimonioLiquido
     */
    public function addFkLdoConfiguracaoEvolucaoPatrimonioLiquidos(\Urbem\CoreBundle\Entity\Ldo\ConfiguracaoEvolucaoPatrimonioLiquido $fkLdoConfiguracaoEvolucaoPatrimonioLiquido)
    {
        if (false === $this->fkLdoConfiguracaoEvolucaoPatrimonioLiquidos->contains($fkLdoConfiguracaoEvolucaoPatrimonioLiquido)) {
            $fkLdoConfiguracaoEvolucaoPatrimonioLiquido->setFkLdoTipoEvolucaoPatrimonioLiquido($this);
            $this->fkLdoConfiguracaoEvolucaoPatrimonioLiquidos->add($fkLdoConfiguracaoEvolucaoPatrimonioLiquido);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LdoConfiguracaoEvolucaoPatrimonioLiquido
     *
     * @param \Urbem\CoreBundle\Entity\Ldo\ConfiguracaoEvolucaoPatrimonioLiquido $fkLdoConfiguracaoEvolucaoPatrimonioLiquido
     */
    public function removeFkLdoConfiguracaoEvolucaoPatrimonioLiquidos(\Urbem\CoreBundle\Entity\Ldo\ConfiguracaoEvolucaoPatrimonioLiquido $fkLdoConfiguracaoEvolucaoPatrimonioLiquido)
    {
        $this->fkLdoConfiguracaoEvolucaoPatrimonioLiquidos->removeElement($fkLdoConfiguracaoEvolucaoPatrimonioLiquido);
    }

    /**
     * OneToMany (owning side)
     * Get fkLdoConfiguracaoEvolucaoPatrimonioLiquidos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ldo\ConfiguracaoEvolucaoPatrimonioLiquido
     */
    public function getFkLdoConfiguracaoEvolucaoPatrimonioLiquidos()
    {
        return $this->fkLdoConfiguracaoEvolucaoPatrimonioLiquidos;
    }
}
