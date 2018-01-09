<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ConfiguracaoIpePensionista
 */
class ConfiguracaoIpePensionista
{
    /**
     * PK
     * @var integer
     */
    private $codConfiguracao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DatePK
     */
    private $vigencia;

    /**
     * @var integer
     */
    private $codAtributoData;

    /**
     * @var integer
     */
    private $codModuloData;

    /**
     * @var integer
     */
    private $codCadastroData;

    /**
     * @var integer
     */
    private $codAtributoMat;

    /**
     * @var integer
     */
    private $codModuloMat;

    /**
     * @var integer
     */
    private $codCadastroMat;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoIpe
     */
    private $fkFolhapagamentoConfiguracaoIpe;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    private $fkAdministracaoAtributoDinamico;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    private $fkAdministracaoAtributoDinamico1;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->vigencia = new \Urbem\CoreBundle\Helper\DatePK;
    }

    /**
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return ConfiguracaoIpePensionista
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
     * Set vigencia
     *
     * @param \Urbem\CoreBundle\Helper\DatePK $vigencia
     * @return ConfiguracaoIpePensionista
     */
    public function setVigencia(\Urbem\CoreBundle\Helper\DatePK $vigencia)
    {
        $this->vigencia = $vigencia;
        return $this;
    }

    /**
     * Get vigencia
     *
     * @return \Urbem\CoreBundle\Helper\DatePK
     */
    public function getVigencia()
    {
        return $this->vigencia;
    }

    /**
     * Set codAtributoData
     *
     * @param integer $codAtributoData
     * @return ConfiguracaoIpePensionista
     */
    public function setCodAtributoData($codAtributoData)
    {
        $this->codAtributoData = $codAtributoData;
        return $this;
    }

    /**
     * Get codAtributoData
     *
     * @return integer
     */
    public function getCodAtributoData()
    {
        return $this->codAtributoData;
    }

    /**
     * Set codModuloData
     *
     * @param integer $codModuloData
     * @return ConfiguracaoIpePensionista
     */
    public function setCodModuloData($codModuloData)
    {
        $this->codModuloData = $codModuloData;
        return $this;
    }

    /**
     * Get codModuloData
     *
     * @return integer
     */
    public function getCodModuloData()
    {
        return $this->codModuloData;
    }

    /**
     * Set codCadastroData
     *
     * @param integer $codCadastroData
     * @return ConfiguracaoIpePensionista
     */
    public function setCodCadastroData($codCadastroData)
    {
        $this->codCadastroData = $codCadastroData;
        return $this;
    }

    /**
     * Get codCadastroData
     *
     * @return integer
     */
    public function getCodCadastroData()
    {
        return $this->codCadastroData;
    }

    /**
     * Set codAtributoMat
     *
     * @param integer $codAtributoMat
     * @return ConfiguracaoIpePensionista
     */
    public function setCodAtributoMat($codAtributoMat)
    {
        $this->codAtributoMat = $codAtributoMat;
        return $this;
    }

    /**
     * Get codAtributoMat
     *
     * @return integer
     */
    public function getCodAtributoMat()
    {
        return $this->codAtributoMat;
    }

    /**
     * Set codModuloMat
     *
     * @param integer $codModuloMat
     * @return ConfiguracaoIpePensionista
     */
    public function setCodModuloMat($codModuloMat)
    {
        $this->codModuloMat = $codModuloMat;
        return $this;
    }

    /**
     * Get codModuloMat
     *
     * @return integer
     */
    public function getCodModuloMat()
    {
        return $this->codModuloMat;
    }

    /**
     * Set codCadastroMat
     *
     * @param integer $codCadastroMat
     * @return ConfiguracaoIpePensionista
     */
    public function setCodCadastroMat($codCadastroMat)
    {
        $this->codCadastroMat = $codCadastroMat;
        return $this;
    }

    /**
     * Get codCadastroMat
     *
     * @return integer
     */
    public function getCodCadastroMat()
    {
        return $this->codCadastroMat;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico
     * @return ConfiguracaoIpePensionista
     */
    public function setFkAdministracaoAtributoDinamico(\Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico)
    {
        $this->codModuloData = $fkAdministracaoAtributoDinamico->getCodModulo();
        $this->codCadastroData = $fkAdministracaoAtributoDinamico->getCodCadastro();
        $this->codAtributoData = $fkAdministracaoAtributoDinamico->getCodAtributo();
        $this->fkAdministracaoAtributoDinamico = $fkAdministracaoAtributoDinamico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoAtributoDinamico
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    public function getFkAdministracaoAtributoDinamico()
    {
        return $this->fkAdministracaoAtributoDinamico;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoAtributoDinamico1
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico1
     * @return ConfiguracaoIpePensionista
     */
    public function setFkAdministracaoAtributoDinamico1(\Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico1)
    {
        $this->codModuloMat = $fkAdministracaoAtributoDinamico1->getCodModulo();
        $this->codCadastroMat = $fkAdministracaoAtributoDinamico1->getCodCadastro();
        $this->codAtributoMat = $fkAdministracaoAtributoDinamico1->getCodAtributo();
        $this->fkAdministracaoAtributoDinamico1 = $fkAdministracaoAtributoDinamico1;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoAtributoDinamico1
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    public function getFkAdministracaoAtributoDinamico1()
    {
        return $this->fkAdministracaoAtributoDinamico1;
    }

    /**
     * OneToOne (owning side)
     * Set FolhapagamentoConfiguracaoIpe
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoIpe $fkFolhapagamentoConfiguracaoIpe
     * @return ConfiguracaoIpePensionista
     */
    public function setFkFolhapagamentoConfiguracaoIpe(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoIpe $fkFolhapagamentoConfiguracaoIpe)
    {
        $this->codConfiguracao = $fkFolhapagamentoConfiguracaoIpe->getCodConfiguracao();
        $this->vigencia = $fkFolhapagamentoConfiguracaoIpe->getVigencia();
        $this->fkFolhapagamentoConfiguracaoIpe = $fkFolhapagamentoConfiguracaoIpe;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFolhapagamentoConfiguracaoIpe
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoIpe
     */
    public function getFkFolhapagamentoConfiguracaoIpe()
    {
        return $this->fkFolhapagamentoConfiguracaoIpe;
    }
}
