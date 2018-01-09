<?php
 
namespace Urbem\CoreBundle\Entity\Beneficio;

/**
 * LayoutFornecedor
 */
class LayoutFornecedor
{
    /**
     * PK
     * @var integer
     */
    private $cgmFornecedor;

    /**
     * @var integer
     */
    private $codLayout;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Compras\Fornecedor
     */
    private $fkComprasFornecedor;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoBeneficioFornecedor
     */
    private $fkFolhapagamentoConfiguracaoBeneficioFornecedores;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Beneficio\LayoutPlanoSaude
     */
    private $fkBeneficioLayoutPlanoSaude;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoConfiguracaoBeneficioFornecedores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set cgmFornecedor
     *
     * @param integer $cgmFornecedor
     * @return LayoutFornecedor
     */
    public function setCgmFornecedor($cgmFornecedor)
    {
        $this->cgmFornecedor = $cgmFornecedor;
        return $this;
    }

    /**
     * Get cgmFornecedor
     *
     * @return integer
     */
    public function getCgmFornecedor()
    {
        return $this->cgmFornecedor;
    }

    /**
     * Set codLayout
     *
     * @param integer $codLayout
     * @return LayoutFornecedor
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
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoBeneficioFornecedor
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoBeneficioFornecedor $fkFolhapagamentoConfiguracaoBeneficioFornecedor
     * @return LayoutFornecedor
     */
    public function addFkFolhapagamentoConfiguracaoBeneficioFornecedores(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoBeneficioFornecedor $fkFolhapagamentoConfiguracaoBeneficioFornecedor)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoBeneficioFornecedores->contains($fkFolhapagamentoConfiguracaoBeneficioFornecedor)) {
            $fkFolhapagamentoConfiguracaoBeneficioFornecedor->setFkBeneficioLayoutFornecedor($this);
            $this->fkFolhapagamentoConfiguracaoBeneficioFornecedores->add($fkFolhapagamentoConfiguracaoBeneficioFornecedor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoBeneficioFornecedor
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoBeneficioFornecedor $fkFolhapagamentoConfiguracaoBeneficioFornecedor
     */
    public function removeFkFolhapagamentoConfiguracaoBeneficioFornecedores(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoBeneficioFornecedor $fkFolhapagamentoConfiguracaoBeneficioFornecedor)
    {
        $this->fkFolhapagamentoConfiguracaoBeneficioFornecedores->removeElement($fkFolhapagamentoConfiguracaoBeneficioFornecedor);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoBeneficioFornecedores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoBeneficioFornecedor
     */
    public function getFkFolhapagamentoConfiguracaoBeneficioFornecedores()
    {
        return $this->fkFolhapagamentoConfiguracaoBeneficioFornecedores;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkBeneficioLayoutPlanoSaude
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\LayoutPlanoSaude $fkBeneficioLayoutPlanoSaude
     * @return LayoutFornecedor
     */
    public function setFkBeneficioLayoutPlanoSaude(\Urbem\CoreBundle\Entity\Beneficio\LayoutPlanoSaude $fkBeneficioLayoutPlanoSaude)
    {
        $this->codLayout = $fkBeneficioLayoutPlanoSaude->getCodLayout();
        $this->fkBeneficioLayoutPlanoSaude = $fkBeneficioLayoutPlanoSaude;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkBeneficioLayoutPlanoSaude
     *
     * @return \Urbem\CoreBundle\Entity\Beneficio\LayoutPlanoSaude
     */
    public function getFkBeneficioLayoutPlanoSaude()
    {
        return $this->fkBeneficioLayoutPlanoSaude;
    }

    /**
     * OneToOne (owning side)
     * Set ComprasFornecedor
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Fornecedor $fkComprasFornecedor
     * @return LayoutFornecedor
     */
    public function setFkComprasFornecedor(\Urbem\CoreBundle\Entity\Compras\Fornecedor $fkComprasFornecedor)
    {
        $this->cgmFornecedor = $fkComprasFornecedor->getCgmFornecedor();
        $this->fkComprasFornecedor = $fkComprasFornecedor;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkComprasFornecedor
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Fornecedor
     */
    public function getFkComprasFornecedor()
    {
        return $this->fkComprasFornecedor;
    }
}
