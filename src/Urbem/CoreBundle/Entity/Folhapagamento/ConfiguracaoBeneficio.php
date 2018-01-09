<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ConfiguracaoBeneficio
 */
class ConfiguracaoBeneficio
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
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoBeneficioFornecedor
     */
    private $fkFolhapagamentoConfiguracaoBeneficioFornecedor;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\BeneficioEvento
     */
    private $fkFolhapagamentoBeneficioEventos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoBeneficioEventos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return ConfiguracaoBeneficio
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
     * @return ConfiguracaoBeneficio
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
     * OneToMany (owning side)
     * Add FolhapagamentoBeneficioEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\BeneficioEvento $fkFolhapagamentoBeneficioEvento
     * @return ConfiguracaoBeneficio
     */
    public function addFkFolhapagamentoBeneficioEventos(\Urbem\CoreBundle\Entity\Folhapagamento\BeneficioEvento $fkFolhapagamentoBeneficioEvento)
    {
        if (false === $this->fkFolhapagamentoBeneficioEventos->contains($fkFolhapagamentoBeneficioEvento)) {
            $fkFolhapagamentoBeneficioEvento->setFkFolhapagamentoConfiguracaoBeneficio($this);
            $this->fkFolhapagamentoBeneficioEventos->add($fkFolhapagamentoBeneficioEvento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoBeneficioEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\BeneficioEvento $fkFolhapagamentoBeneficioEvento
     */
    public function removeFkFolhapagamentoBeneficioEventos(\Urbem\CoreBundle\Entity\Folhapagamento\BeneficioEvento $fkFolhapagamentoBeneficioEvento)
    {
        $this->fkFolhapagamentoBeneficioEventos->removeElement($fkFolhapagamentoBeneficioEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoBeneficioEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\BeneficioEvento
     */
    public function getFkFolhapagamentoBeneficioEventos()
    {
        return $this->fkFolhapagamentoBeneficioEventos;
    }

    /**
     * OneToOne (inverse side)
     * Set FolhapagamentoConfiguracaoBeneficioFornecedor
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoBeneficioFornecedor $fkFolhapagamentoConfiguracaoBeneficioFornecedor
     * @return ConfiguracaoBeneficio
     */
    public function setFkFolhapagamentoConfiguracaoBeneficioFornecedor(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoBeneficioFornecedor $fkFolhapagamentoConfiguracaoBeneficioFornecedor)
    {
        $fkFolhapagamentoConfiguracaoBeneficioFornecedor->setFkFolhapagamentoConfiguracaoBeneficio($this);
        $this->fkFolhapagamentoConfiguracaoBeneficioFornecedor = $fkFolhapagamentoConfiguracaoBeneficioFornecedor;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoConfiguracaoBeneficioFornecedor
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoBeneficioFornecedor
     */
    public function getFkFolhapagamentoConfiguracaoBeneficioFornecedor()
    {
        return $this->fkFolhapagamentoConfiguracaoBeneficioFornecedor;
    }
}
