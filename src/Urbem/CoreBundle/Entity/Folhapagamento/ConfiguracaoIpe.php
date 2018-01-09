<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ConfiguracaoIpe
 */
class ConfiguracaoIpe
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
     * @var integer
     */
    private $codEventoAutomatico;

    /**
     * @var integer
     */
    private $codEventoBase;

    /**
     * @var integer
     */
    private $codigoOrgao;

    /**
     * @var integer
     */
    private $contribuicaoPat;

    /**
     * @var integer
     */
    private $contibuicaoServ;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoIpePensionista
     */
    private $fkFolhapagamentoConfiguracaoIpePensionista;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    private $fkAdministracaoAtributoDinamico;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    private $fkFolhapagamentoEvento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    private $fkAdministracaoAtributoDinamico1;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    private $fkFolhapagamentoEvento1;

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
     * @return ConfiguracaoIpe
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
     * @return ConfiguracaoIpe
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
     * @return ConfiguracaoIpe
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
     * @return ConfiguracaoIpe
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
     * @return ConfiguracaoIpe
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
     * @return ConfiguracaoIpe
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
     * @return ConfiguracaoIpe
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
     * @return ConfiguracaoIpe
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
     * Set codEventoAutomatico
     *
     * @param integer $codEventoAutomatico
     * @return ConfiguracaoIpe
     */
    public function setCodEventoAutomatico($codEventoAutomatico)
    {
        $this->codEventoAutomatico = $codEventoAutomatico;
        return $this;
    }

    /**
     * Get codEventoAutomatico
     *
     * @return integer
     */
    public function getCodEventoAutomatico()
    {
        return $this->codEventoAutomatico;
    }

    /**
     * Set codEventoBase
     *
     * @param integer $codEventoBase
     * @return ConfiguracaoIpe
     */
    public function setCodEventoBase($codEventoBase)
    {
        $this->codEventoBase = $codEventoBase;
        return $this;
    }

    /**
     * Get codEventoBase
     *
     * @return integer
     */
    public function getCodEventoBase()
    {
        return $this->codEventoBase;
    }

    /**
     * Set codigoOrgao
     *
     * @param integer $codigoOrgao
     * @return ConfiguracaoIpe
     */
    public function setCodigoOrgao($codigoOrgao)
    {
        $this->codigoOrgao = $codigoOrgao;
        return $this;
    }

    /**
     * Get codigoOrgao
     *
     * @return integer
     */
    public function getCodigoOrgao()
    {
        return $this->codigoOrgao;
    }

    /**
     * Set contribuicaoPat
     *
     * @param integer $contribuicaoPat
     * @return ConfiguracaoIpe
     */
    public function setContribuicaoPat($contribuicaoPat)
    {
        $this->contribuicaoPat = $contribuicaoPat;
        return $this;
    }

    /**
     * Get contribuicaoPat
     *
     * @return integer
     */
    public function getContribuicaoPat()
    {
        return $this->contribuicaoPat;
    }

    /**
     * Set contibuicaoServ
     *
     * @param integer $contibuicaoServ
     * @return ConfiguracaoIpe
     */
    public function setContibuicaoServ($contibuicaoServ)
    {
        $this->contibuicaoServ = $contibuicaoServ;
        return $this;
    }

    /**
     * Get contibuicaoServ
     *
     * @return integer
     */
    public function getContibuicaoServ()
    {
        return $this->contibuicaoServ;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico
     * @return ConfiguracaoIpe
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
     * Set fkFolhapagamentoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento
     * @return ConfiguracaoIpe
     */
    public function setFkFolhapagamentoEvento(\Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento)
    {
        $this->codEventoAutomatico = $fkFolhapagamentoEvento->getCodEvento();
        $this->fkFolhapagamentoEvento = $fkFolhapagamentoEvento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoEvento
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    public function getFkFolhapagamentoEvento()
    {
        return $this->fkFolhapagamentoEvento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoAtributoDinamico1
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico1
     * @return ConfiguracaoIpe
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
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoEvento1
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento1
     * @return ConfiguracaoIpe
     */
    public function setFkFolhapagamentoEvento1(\Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento1)
    {
        $this->codEventoBase = $fkFolhapagamentoEvento1->getCodEvento();
        $this->fkFolhapagamentoEvento1 = $fkFolhapagamentoEvento1;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoEvento1
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    public function getFkFolhapagamentoEvento1()
    {
        return $this->fkFolhapagamentoEvento1;
    }

    /**
     * OneToOne (inverse side)
     * Set FolhapagamentoConfiguracaoIpePensionista
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoIpePensionista $fkFolhapagamentoConfiguracaoIpePensionista
     * @return ConfiguracaoIpe
     */
    public function setFkFolhapagamentoConfiguracaoIpePensionista(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoIpePensionista $fkFolhapagamentoConfiguracaoIpePensionista)
    {
        $fkFolhapagamentoConfiguracaoIpePensionista->setFkFolhapagamentoConfiguracaoIpe($this);
        $this->fkFolhapagamentoConfiguracaoIpePensionista = $fkFolhapagamentoConfiguracaoIpePensionista;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoConfiguracaoIpePensionista
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoIpePensionista
     */
    public function getFkFolhapagamentoConfiguracaoIpePensionista()
    {
        return $this->fkFolhapagamentoConfiguracaoIpePensionista;
    }

    /**
     *
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->getCodConfiguracao(), $this->getVigencia()->format('d/m/Y'));
    }
}
