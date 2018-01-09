<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ConfiguracaoBeneficioFornecedor
 */
class ConfiguracaoBeneficioFornecedor
{
    /**
     * PK
     * @var integer
     */
    private $codConfiguracao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $cgmFornecedor;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoBeneficio
     */
    private $fkFolhapagamentoConfiguracaoBeneficio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Beneficio\LayoutFornecedor
     */
    private $fkBeneficioLayoutFornecedor;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return ConfiguracaoBeneficioFornecedor
     */
    public function setCodConfiguracao($codConfiguracao)
    {
        $this->codConfiguracao = $codConfiguracao;
        return $this;
    }

    /**
     * Get codConfiguracao
     *
     * @return integer
     */
    public function getCodConfiguracao()
    {
        return $this->codConfiguracao;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ConfiguracaoBeneficioFornecedor
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set cgmFornecedor
     *
     * @param integer $cgmFornecedor
     * @return ConfiguracaoBeneficioFornecedor
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
     * ManyToOne (inverse side)
     * Set fkBeneficioLayoutFornecedor
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\LayoutFornecedor $fkBeneficioLayoutFornecedor
     * @return ConfiguracaoBeneficioFornecedor
     */
    public function setFkBeneficioLayoutFornecedor(\Urbem\CoreBundle\Entity\Beneficio\LayoutFornecedor $fkBeneficioLayoutFornecedor)
    {
        $this->cgmFornecedor = $fkBeneficioLayoutFornecedor->getCgmFornecedor();
        $this->fkBeneficioLayoutFornecedor = $fkBeneficioLayoutFornecedor;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkBeneficioLayoutFornecedor
     *
     * @return \Urbem\CoreBundle\Entity\Beneficio\LayoutFornecedor
     */
    public function getFkBeneficioLayoutFornecedor()
    {
        return $this->fkBeneficioLayoutFornecedor;
    }

    /**
     * OneToOne (owning side)
     * Set FolhapagamentoConfiguracaoBeneficio
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoBeneficio $fkFolhapagamentoConfiguracaoBeneficio
     * @return ConfiguracaoBeneficioFornecedor
     */
    public function setFkFolhapagamentoConfiguracaoBeneficio(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoBeneficio $fkFolhapagamentoConfiguracaoBeneficio)
    {
        $this->codConfiguracao = $fkFolhapagamentoConfiguracaoBeneficio->getCodConfiguracao();
        $this->timestamp = $fkFolhapagamentoConfiguracaoBeneficio->getTimestamp();
        $this->fkFolhapagamentoConfiguracaoBeneficio = $fkFolhapagamentoConfiguracaoBeneficio;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFolhapagamentoConfiguracaoBeneficio
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoBeneficio
     */
    public function getFkFolhapagamentoConfiguracaoBeneficio()
    {
        return $this->fkFolhapagamentoConfiguracaoBeneficio;
    }
}
