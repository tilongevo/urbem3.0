<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * ConfiguracaoBanparaEmpresa
 */
class ConfiguracaoBanparaEmpresa
{
    /**
     * PK
     * @var integer
     */
    private $codEmpresa;

    /**
     * @var integer
     */
    private $codigo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanpara
     */
    private $fkImaConfiguracaoBanparas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImaConfiguracaoBanparas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codEmpresa
     *
     * @param integer $codEmpresa
     * @return ConfiguracaoBanparaEmpresa
     */
    public function setCodEmpresa($codEmpresa)
    {
        $this->codEmpresa = $codEmpresa;
        return $this;
    }

    /**
     * Get codEmpresa
     *
     * @return integer
     */
    public function getCodEmpresa()
    {
        return $this->codEmpresa;
    }

    /**
     * Set codigo
     *
     * @param integer $codigo
     * @return ConfiguracaoBanparaEmpresa
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
        return $this;
    }

    /**
     * Get codigo
     *
     * @return integer
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoBanpara
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanpara $fkImaConfiguracaoBanpara
     * @return ConfiguracaoBanparaEmpresa
     */
    public function addFkImaConfiguracaoBanparas(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanpara $fkImaConfiguracaoBanpara)
    {
        if (false === $this->fkImaConfiguracaoBanparas->contains($fkImaConfiguracaoBanpara)) {
            $fkImaConfiguracaoBanpara->setFkImaConfiguracaoBanparaEmpresa($this);
            $this->fkImaConfiguracaoBanparas->add($fkImaConfiguracaoBanpara);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoBanpara
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanpara $fkImaConfiguracaoBanpara
     */
    public function removeFkImaConfiguracaoBanparas(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanpara $fkImaConfiguracaoBanpara)
    {
        $this->fkImaConfiguracaoBanparas->removeElement($fkImaConfiguracaoBanpara);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoBanparas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanpara
     */
    public function getFkImaConfiguracaoBanparas()
    {
        return $this->fkImaConfiguracaoBanparas;
    }
}
