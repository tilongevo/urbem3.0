<?php
 
namespace Urbem\CoreBundle\Entity\Beneficio;

/**
 * BeneficioCadastro
 */
class BeneficioCadastro
{
    /**
     * PK
     * @var integer
     */
    private $codBeneficio;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoBeneficio
     */
    private $fkFolhapagamentoTipoEventoBeneficios;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoTipoEventoBeneficios = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codBeneficio
     *
     * @param integer $codBeneficio
     * @return BeneficioCadastro
     */
    public function setCodBeneficio($codBeneficio)
    {
        $this->codBeneficio = $codBeneficio;
        return $this;
    }

    /**
     * Get codBeneficio
     *
     * @return integer
     */
    public function getCodBeneficio()
    {
        return $this->codBeneficio;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return BeneficioCadastro
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
     * Add FolhapagamentoTipoEventoBeneficio
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoBeneficio $fkFolhapagamentoTipoEventoBeneficio
     * @return BeneficioCadastro
     */
    public function addFkFolhapagamentoTipoEventoBeneficios(\Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoBeneficio $fkFolhapagamentoTipoEventoBeneficio)
    {
        if (false === $this->fkFolhapagamentoTipoEventoBeneficios->contains($fkFolhapagamentoTipoEventoBeneficio)) {
            $fkFolhapagamentoTipoEventoBeneficio->setFkBeneficioBeneficioCadastro($this);
            $this->fkFolhapagamentoTipoEventoBeneficios->add($fkFolhapagamentoTipoEventoBeneficio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTipoEventoBeneficio
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoBeneficio $fkFolhapagamentoTipoEventoBeneficio
     */
    public function removeFkFolhapagamentoTipoEventoBeneficios(\Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoBeneficio $fkFolhapagamentoTipoEventoBeneficio)
    {
        $this->fkFolhapagamentoTipoEventoBeneficios->removeElement($fkFolhapagamentoTipoEventoBeneficio);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTipoEventoBeneficios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoBeneficio
     */
    public function getFkFolhapagamentoTipoEventoBeneficios()
    {
        return $this->fkFolhapagamentoTipoEventoBeneficios;
    }
}
