<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * TipoControlePonto
 */
class TipoControlePonto
{
    /**
     * PK
     * @var integer
     */
    private $codTipoControlePonto;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoRais
     */
    private $fkImaConfiguracaoRais;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImaConfiguracaoRais = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoControlePonto
     *
     * @param integer $codTipoControlePonto
     * @return TipoControlePonto
     */
    public function setCodTipoControlePonto($codTipoControlePonto)
    {
        $this->codTipoControlePonto = $codTipoControlePonto;
        return $this;
    }

    /**
     * Get codTipoControlePonto
     *
     * @return integer
     */
    public function getCodTipoControlePonto()
    {
        return $this->codTipoControlePonto;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoControlePonto
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
     * Add ImaConfiguracaoRais
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoRais $fkImaConfiguracaoRais
     * @return TipoControlePonto
     */
    public function addFkImaConfiguracaoRais(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoRais $fkImaConfiguracaoRais)
    {
        if (false === $this->fkImaConfiguracaoRais->contains($fkImaConfiguracaoRais)) {
            $fkImaConfiguracaoRais->setFkImaTipoControlePonto($this);
            $this->fkImaConfiguracaoRais->add($fkImaConfiguracaoRais);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoRais
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoRais $fkImaConfiguracaoRais
     */
    public function removeFkImaConfiguracaoRais(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoRais $fkImaConfiguracaoRais)
    {
        $this->fkImaConfiguracaoRais->removeElement($fkImaConfiguracaoRais);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoRais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoRais
     */
    public function getFkImaConfiguracaoRais()
    {
        return $this->fkImaConfiguracaoRais;
    }
}
