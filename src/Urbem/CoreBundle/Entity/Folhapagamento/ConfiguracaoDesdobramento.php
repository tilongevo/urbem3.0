<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ConfiguracaoDesdobramento
 */
class ConfiguracaoDesdobramento
{
    /**
     * PK
     * @var integer
     */
    private $codConfiguracao;

    /**
     * PK
     * @var string
     */
    private $desdobramento;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var string
     */
    private $abreviacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEvento
     */
    private $fkFolhapagamentoConfiguracaoEvento;


    /**
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return ConfiguracaoDesdobramento
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
     * Set desdobramento
     *
     * @param string $desdobramento
     * @return ConfiguracaoDesdobramento
     */
    public function setDesdobramento($desdobramento)
    {
        $this->desdobramento = $desdobramento;
        return $this;
    }

    /**
     * Get desdobramento
     *
     * @return string
     */
    public function getDesdobramento()
    {
        return $this->desdobramento;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return ConfiguracaoDesdobramento
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
     * Set abreviacao
     *
     * @param string $abreviacao
     * @return ConfiguracaoDesdobramento
     */
    public function setAbreviacao($abreviacao)
    {
        $this->abreviacao = $abreviacao;
        return $this;
    }

    /**
     * Get abreviacao
     *
     * @return string
     */
    public function getAbreviacao()
    {
        return $this->abreviacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoConfiguracaoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEvento $fkFolhapagamentoConfiguracaoEvento
     * @return ConfiguracaoDesdobramento
     */
    public function setFkFolhapagamentoConfiguracaoEvento(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEvento $fkFolhapagamentoConfiguracaoEvento)
    {
        $this->codConfiguracao = $fkFolhapagamentoConfiguracaoEvento->getCodConfiguracao();
        $this->fkFolhapagamentoConfiguracaoEvento = $fkFolhapagamentoConfiguracaoEvento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoConfiguracaoEvento
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEvento
     */
    public function getFkFolhapagamentoConfiguracaoEvento()
    {
        return $this->fkFolhapagamentoConfiguracaoEvento;
    }
}
