<?php
 
namespace Urbem\CoreBundle\Entity\Beneficio;

/**
 * LayoutPlanoSaude
 */
class LayoutPlanoSaude
{
    /**
     * PK
     * @var integer
     */
    private $codLayout;

    /**
     * @var string
     */
    private $padrao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\LayoutFornecedor
     */
    private $fkBeneficioLayoutFornecedores;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkBeneficioLayoutFornecedores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codLayout
     *
     * @param integer $codLayout
     * @return LayoutPlanoSaude
     */
    public function setCodLayout($codLayout)
    {
        $this->codLayout = $codLayout;
        return $this;
    }

    /**
     * Get codLayout
     *
     * @return integer
     */
    public function getCodLayout()
    {
        return $this->codLayout;
    }

    /**
     * Set padrao
     *
     * @param string $padrao
     * @return LayoutPlanoSaude
     */
    public function setPadrao($padrao)
    {
        $this->padrao = $padrao;
        return $this;
    }

    /**
     * Get padrao
     *
     * @return string
     */
    public function getPadrao()
    {
        return $this->padrao;
    }

    /**
     * OneToMany (owning side)
     * Add BeneficioLayoutFornecedor
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\LayoutFornecedor $fkBeneficioLayoutFornecedor
     * @return LayoutPlanoSaude
     */
    public function addFkBeneficioLayoutFornecedores(\Urbem\CoreBundle\Entity\Beneficio\LayoutFornecedor $fkBeneficioLayoutFornecedor)
    {
        if (false === $this->fkBeneficioLayoutFornecedores->contains($fkBeneficioLayoutFornecedor)) {
            $fkBeneficioLayoutFornecedor->setFkBeneficioLayoutPlanoSaude($this);
            $this->fkBeneficioLayoutFornecedores->add($fkBeneficioLayoutFornecedor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove BeneficioLayoutFornecedor
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\LayoutFornecedor $fkBeneficioLayoutFornecedor
     */
    public function removeFkBeneficioLayoutFornecedores(\Urbem\CoreBundle\Entity\Beneficio\LayoutFornecedor $fkBeneficioLayoutFornecedor)
    {
        $this->fkBeneficioLayoutFornecedores->removeElement($fkBeneficioLayoutFornecedor);
    }

    /**
     * OneToMany (owning side)
     * Get fkBeneficioLayoutFornecedores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\LayoutFornecedor
     */
    public function getFkBeneficioLayoutFornecedores()
    {
        return $this->fkBeneficioLayoutFornecedores;
    }
}
