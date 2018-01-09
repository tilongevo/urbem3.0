<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwCgmPessoaJuridica
 */
class SwCgmPessoaJuridica
{
    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * @var string
     */
    private $nomFantasia;

    /**
     * @var string
     */
    private $cnpj;

    /**
     * @var string
     */
    private $inscEstadual;

    /**
     * @var integer
     */
    private $codOrgaoRegistro = 0;

    /**
     * @var string
     */
    private $numRegistro;

    /**
     * @var \DateTime
     */
    private $dtRegistro;

    /**
     * @var string
     */
    private $numRegistroCvm;

    /**
     * @var \DateTime
     */
    private $dtRegistroCvm;

    /**
     * @var string
     */
    private $objetoSocial;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Estagio\EntidadeIntermediadora
     */
    private $fkEstagioEntidadeIntermediadora;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Estagio\InstituicaoEnsino
     */
    private $fkEstagioInstituicaoEnsino;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Sindicato
     */
    private $fkFolhapagamentoSindicato;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Frota\Posto
     */
    private $fkFrotaPosto;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Beneficio\Fornecedor
     */
    private $fkBeneficioFornecedor;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\CondominioCgm
     */
    private $fkImobiliarioCondominioCgm;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaDireito
     */
    private $fkEconomicoCadastroEconomicoEmpresaDireitos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\VeiculoLocacao
     */
    private $fkFrotaVeiculoLocacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfPlano
     */
    private $fkImaConfiguracaoDirfPlanos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\Imobiliaria
     */
    private $fkImobiliarioImobiliarias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Manad\Uniorcam
     */
    private $fkManadUniorcans;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceal\Uniorcam
     */
    private $fkTcealUniorcans;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcers\Uniorcam
     */
    private $fkTcersUniorcans;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceto\Uniorcam
     */
    private $fkTcetoUniorcans;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\TermoParceria
     */
    private $fkTcmbaTermoParcerias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ContadorTerceirizado
     */
    private $fkTcmgoContadorTerceirizados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\JuridicoTerceirizado
     */
    private $fkTcmgoJuridicoTerceirizados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\Orgao
     */
    private $fkTcmgoOrgoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\VeiculoCessao
     */
    private $fkFrotaVeiculoCessoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\Agencia
     */
    private $fkMonetarioAgencias;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\OrgaoRegistro
     */
    private $fkAdministracaoOrgaoRegistro;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoCadastroEconomicoEmpresaDireitos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaVeiculoLocacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoDirfPlanos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioImobiliarias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkManadUniorcans = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcealUniorcans = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcersUniorcans = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcetoUniorcans = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmbaTermoParcerias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoContadorTerceirizados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoJuridicoTerceirizados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoOrgoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaVeiculoCessoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkMonetarioAgencias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return SwCgmPessoaJuridica
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set nomFantasia
     *
     * @param string $nomFantasia
     * @return SwCgmPessoaJuridica
     */
    public function setNomFantasia($nomFantasia)
    {
        $this->nomFantasia = $nomFantasia;
        return $this;
    }

    /**
     * Get nomFantasia
     *
     * @return string
     */
    public function getNomFantasia()
    {
        return $this->nomFantasia;
    }

    /**
     * Set cnpj
     *
     * @param string $cnpj
     * @return SwCgmPessoaJuridica
     */
    public function setCnpj($cnpj = null)
    {
        $this->cnpj = $cnpj;
        return $this;
    }

    /**
     * Get cnpj
     *
     * @return string
     */
    public function getCnpj()
    {
        return $this->cnpj;
    }

    /**
     * Set inscEstadual
     *
     * @param string $inscEstadual
     * @return SwCgmPessoaJuridica
     */
    public function setInscEstadual($inscEstadual)
    {
        $this->inscEstadual = $inscEstadual;
        return $this;
    }

    /**
     * Get inscEstadual
     *
     * @return string
     */
    public function getInscEstadual()
    {
        return $this->inscEstadual;
    }

    /**
     * Set codOrgaoRegistro
     *
     * @param integer $codOrgaoRegistro
     * @return SwCgmPessoaJuridica
     */
    public function setCodOrgaoRegistro($codOrgaoRegistro)
    {
        $this->codOrgaoRegistro = $codOrgaoRegistro;
        return $this;
    }

    /**
     * Get codOrgaoRegistro
     *
     * @return integer
     */
    public function getCodOrgaoRegistro()
    {
        return $this->codOrgaoRegistro;
    }

    /**
     * Set numRegistro
     *
     * @param string $numRegistro
     * @return SwCgmPessoaJuridica
     */
    public function setNumRegistro($numRegistro)
    {
        $this->numRegistro = $numRegistro;
        return $this;
    }

    /**
     * Get numRegistro
     *
     * @return string
     */
    public function getNumRegistro()
    {
        return $this->numRegistro;
    }

    /**
     * Set dtRegistro
     *
     * @param \DateTime $dtRegistro
     * @return SwCgmPessoaJuridica
     */
    public function setDtRegistro(\DateTime $dtRegistro = null)
    {
        $this->dtRegistro = $dtRegistro;
        return $this;
    }

    /**
     * Get dtRegistro
     *
     * @return \DateTime
     */
    public function getDtRegistro()
    {
        return $this->dtRegistro;
    }

    /**
     * Set numRegistroCvm
     *
     * @param string $numRegistroCvm
     * @return SwCgmPessoaJuridica
     */
    public function setNumRegistroCvm($numRegistroCvm)
    {
        $this->numRegistroCvm = $numRegistroCvm;
        return $this;
    }

    /**
     * Get numRegistroCvm
     *
     * @return string
     */
    public function getNumRegistroCvm()
    {
        return $this->numRegistroCvm;
    }

    /**
     * Set dtRegistroCvm
     *
     * @param \DateTime $dtRegistroCvm
     * @return SwCgmPessoaJuridica
     */
    public function setDtRegistroCvm(\DateTime $dtRegistroCvm = null)
    {
        $this->dtRegistroCvm = $dtRegistroCvm;
        return $this;
    }

    /**
     * Get dtRegistroCvm
     *
     * @return \DateTime
     */
    public function getDtRegistroCvm()
    {
        return $this->dtRegistroCvm;
    }

    /**
     * Set objetoSocial
     *
     * @param string $objetoSocial
     * @return SwCgmPessoaJuridica
     */
    public function setObjetoSocial($objetoSocial)
    {
        $this->objetoSocial = $objetoSocial;
        return $this;
    }

    /**
     * Get objetoSocial
     *
     * @return string
     */
    public function getObjetoSocial()
    {
        return $this->objetoSocial;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoCadastroEconomicoEmpresaDireito
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaDireito $fkEconomicoCadastroEconomicoEmpresaDireito
     * @return SwCgmPessoaJuridica
     */
    public function addFkEconomicoCadastroEconomicoEmpresaDireitos(\Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaDireito $fkEconomicoCadastroEconomicoEmpresaDireito)
    {
        if (false === $this->fkEconomicoCadastroEconomicoEmpresaDireitos->contains($fkEconomicoCadastroEconomicoEmpresaDireito)) {
            $fkEconomicoCadastroEconomicoEmpresaDireito->setFkSwCgmPessoaJuridica($this);
            $this->fkEconomicoCadastroEconomicoEmpresaDireitos->add($fkEconomicoCadastroEconomicoEmpresaDireito);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoCadastroEconomicoEmpresaDireito
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaDireito $fkEconomicoCadastroEconomicoEmpresaDireito
     */
    public function removeFkEconomicoCadastroEconomicoEmpresaDireitos(\Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaDireito $fkEconomicoCadastroEconomicoEmpresaDireito)
    {
        $this->fkEconomicoCadastroEconomicoEmpresaDireitos->removeElement($fkEconomicoCadastroEconomicoEmpresaDireito);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoCadastroEconomicoEmpresaDireitos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaDireito
     */
    public function getFkEconomicoCadastroEconomicoEmpresaDireitos()
    {
        return $this->fkEconomicoCadastroEconomicoEmpresaDireitos;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaVeiculoLocacao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\VeiculoLocacao $fkFrotaVeiculoLocacao
     * @return SwCgmPessoaJuridica
     */
    public function addFkFrotaVeiculoLocacoes(\Urbem\CoreBundle\Entity\Frota\VeiculoLocacao $fkFrotaVeiculoLocacao)
    {
        if (false === $this->fkFrotaVeiculoLocacoes->contains($fkFrotaVeiculoLocacao)) {
            $fkFrotaVeiculoLocacao->setFkSwCgmPessoaJuridica($this);
            $this->fkFrotaVeiculoLocacoes->add($fkFrotaVeiculoLocacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaVeiculoLocacao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\VeiculoLocacao $fkFrotaVeiculoLocacao
     */
    public function removeFkFrotaVeiculoLocacoes(\Urbem\CoreBundle\Entity\Frota\VeiculoLocacao $fkFrotaVeiculoLocacao)
    {
        $this->fkFrotaVeiculoLocacoes->removeElement($fkFrotaVeiculoLocacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaVeiculoLocacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\VeiculoLocacao
     */
    public function getFkFrotaVeiculoLocacoes()
    {
        return $this->fkFrotaVeiculoLocacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoDirfPlano
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfPlano $fkImaConfiguracaoDirfPlano
     * @return SwCgmPessoaJuridica
     */
    public function addFkImaConfiguracaoDirfPlanos(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfPlano $fkImaConfiguracaoDirfPlano)
    {
        if (false === $this->fkImaConfiguracaoDirfPlanos->contains($fkImaConfiguracaoDirfPlano)) {
            $fkImaConfiguracaoDirfPlano->setFkSwCgmPessoaJuridica($this);
            $this->fkImaConfiguracaoDirfPlanos->add($fkImaConfiguracaoDirfPlano);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoDirfPlano
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfPlano $fkImaConfiguracaoDirfPlano
     */
    public function removeFkImaConfiguracaoDirfPlanos(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfPlano $fkImaConfiguracaoDirfPlano)
    {
        $this->fkImaConfiguracaoDirfPlanos->removeElement($fkImaConfiguracaoDirfPlano);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoDirfPlanos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirfPlano
     */
    public function getFkImaConfiguracaoDirfPlanos()
    {
        return $this->fkImaConfiguracaoDirfPlanos;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioImobiliaria
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Imobiliaria $fkImobiliarioImobiliaria
     * @return SwCgmPessoaJuridica
     */
    public function addFkImobiliarioImobiliarias(\Urbem\CoreBundle\Entity\Imobiliario\Imobiliaria $fkImobiliarioImobiliaria)
    {
        if (false === $this->fkImobiliarioImobiliarias->contains($fkImobiliarioImobiliaria)) {
            $fkImobiliarioImobiliaria->setFkSwCgmPessoaJuridica($this);
            $this->fkImobiliarioImobiliarias->add($fkImobiliarioImobiliaria);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioImobiliaria
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Imobiliaria $fkImobiliarioImobiliaria
     */
    public function removeFkImobiliarioImobiliarias(\Urbem\CoreBundle\Entity\Imobiliario\Imobiliaria $fkImobiliarioImobiliaria)
    {
        $this->fkImobiliarioImobiliarias->removeElement($fkImobiliarioImobiliaria);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioImobiliarias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\Imobiliaria
     */
    public function getFkImobiliarioImobiliarias()
    {
        return $this->fkImobiliarioImobiliarias;
    }

    /**
     * OneToMany (owning side)
     * Add ManadUniorcam
     *
     * @param \Urbem\CoreBundle\Entity\Manad\Uniorcam $fkManadUniorcam
     * @return SwCgmPessoaJuridica
     */
    public function addFkManadUniorcans(\Urbem\CoreBundle\Entity\Manad\Uniorcam $fkManadUniorcam)
    {
        if (false === $this->fkManadUniorcans->contains($fkManadUniorcam)) {
            $fkManadUniorcam->setFkSwCgmPessoaJuridica($this);
            $this->fkManadUniorcans->add($fkManadUniorcam);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ManadUniorcam
     *
     * @param \Urbem\CoreBundle\Entity\Manad\Uniorcam $fkManadUniorcam
     */
    public function removeFkManadUniorcans(\Urbem\CoreBundle\Entity\Manad\Uniorcam $fkManadUniorcam)
    {
        $this->fkManadUniorcans->removeElement($fkManadUniorcam);
    }

    /**
     * OneToMany (owning side)
     * Get fkManadUniorcans
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Manad\Uniorcam
     */
    public function getFkManadUniorcans()
    {
        return $this->fkManadUniorcans;
    }

    /**
     * OneToMany (owning side)
     * Add TcealUniorcam
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\Uniorcam $fkTcealUniorcam
     * @return SwCgmPessoaJuridica
     */
    public function addFkTcealUniorcans(\Urbem\CoreBundle\Entity\Tceal\Uniorcam $fkTcealUniorcam)
    {
        if (false === $this->fkTcealUniorcans->contains($fkTcealUniorcam)) {
            $fkTcealUniorcam->setFkSwCgmPessoaJuridica($this);
            $this->fkTcealUniorcans->add($fkTcealUniorcam);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcealUniorcam
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\Uniorcam $fkTcealUniorcam
     */
    public function removeFkTcealUniorcans(\Urbem\CoreBundle\Entity\Tceal\Uniorcam $fkTcealUniorcam)
    {
        $this->fkTcealUniorcans->removeElement($fkTcealUniorcam);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcealUniorcans
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceal\Uniorcam
     */
    public function getFkTcealUniorcans()
    {
        return $this->fkTcealUniorcans;
    }

    /**
     * OneToMany (owning side)
     * Add TcersUniorcam
     *
     * @param \Urbem\CoreBundle\Entity\Tcers\Uniorcam $fkTcersUniorcam
     * @return SwCgmPessoaJuridica
     */
    public function addFkTcersUniorcans(\Urbem\CoreBundle\Entity\Tcers\Uniorcam $fkTcersUniorcam)
    {
        if (false === $this->fkTcersUniorcans->contains($fkTcersUniorcam)) {
            $fkTcersUniorcam->setFkSwCgmPessoaJuridica($this);
            $this->fkTcersUniorcans->add($fkTcersUniorcam);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcersUniorcam
     *
     * @param \Urbem\CoreBundle\Entity\Tcers\Uniorcam $fkTcersUniorcam
     */
    public function removeFkTcersUniorcans(\Urbem\CoreBundle\Entity\Tcers\Uniorcam $fkTcersUniorcam)
    {
        $this->fkTcersUniorcans->removeElement($fkTcersUniorcam);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcersUniorcans
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcers\Uniorcam
     */
    public function getFkTcersUniorcans()
    {
        return $this->fkTcersUniorcans;
    }

    /**
     * OneToMany (owning side)
     * Add TcetoUniorcam
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\Uniorcam $fkTcetoUniorcam
     * @return SwCgmPessoaJuridica
     */
    public function addFkTcetoUniorcans(\Urbem\CoreBundle\Entity\Tceto\Uniorcam $fkTcetoUniorcam)
    {
        if (false === $this->fkTcetoUniorcans->contains($fkTcetoUniorcam)) {
            $fkTcetoUniorcam->setFkSwCgmPessoaJuridica($this);
            $this->fkTcetoUniorcans->add($fkTcetoUniorcam);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcetoUniorcam
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\Uniorcam $fkTcetoUniorcam
     */
    public function removeFkTcetoUniorcans(\Urbem\CoreBundle\Entity\Tceto\Uniorcam $fkTcetoUniorcam)
    {
        $this->fkTcetoUniorcans->removeElement($fkTcetoUniorcam);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcetoUniorcans
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceto\Uniorcam
     */
    public function getFkTcetoUniorcans()
    {
        return $this->fkTcetoUniorcans;
    }

    /**
     * OneToMany (owning side)
     * Add TcmbaTermoParceria
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\TermoParceria $fkTcmbaTermoParceria
     * @return SwCgmPessoaJuridica
     */
    public function addFkTcmbaTermoParcerias(\Urbem\CoreBundle\Entity\Tcmba\TermoParceria $fkTcmbaTermoParceria)
    {
        if (false === $this->fkTcmbaTermoParcerias->contains($fkTcmbaTermoParceria)) {
            $fkTcmbaTermoParceria->setFkSwCgmPessoaJuridica($this);
            $this->fkTcmbaTermoParcerias->add($fkTcmbaTermoParceria);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaTermoParceria
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\TermoParceria $fkTcmbaTermoParceria
     */
    public function removeFkTcmbaTermoParcerias(\Urbem\CoreBundle\Entity\Tcmba\TermoParceria $fkTcmbaTermoParceria)
    {
        $this->fkTcmbaTermoParcerias->removeElement($fkTcmbaTermoParceria);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaTermoParcerias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\TermoParceria
     */
    public function getFkTcmbaTermoParcerias()
    {
        return $this->fkTcmbaTermoParcerias;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoContadorTerceirizado
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ContadorTerceirizado $fkTcmgoContadorTerceirizado
     * @return SwCgmPessoaJuridica
     */
    public function addFkTcmgoContadorTerceirizados(\Urbem\CoreBundle\Entity\Tcmgo\ContadorTerceirizado $fkTcmgoContadorTerceirizado)
    {
        if (false === $this->fkTcmgoContadorTerceirizados->contains($fkTcmgoContadorTerceirizado)) {
            $fkTcmgoContadorTerceirizado->setFkSwCgmPessoaJuridica($this);
            $this->fkTcmgoContadorTerceirizados->add($fkTcmgoContadorTerceirizado);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoContadorTerceirizado
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ContadorTerceirizado $fkTcmgoContadorTerceirizado
     */
    public function removeFkTcmgoContadorTerceirizados(\Urbem\CoreBundle\Entity\Tcmgo\ContadorTerceirizado $fkTcmgoContadorTerceirizado)
    {
        $this->fkTcmgoContadorTerceirizados->removeElement($fkTcmgoContadorTerceirizado);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoContadorTerceirizados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\ContadorTerceirizado
     */
    public function getFkTcmgoContadorTerceirizados()
    {
        return $this->fkTcmgoContadorTerceirizados;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoJuridicoTerceirizado
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\JuridicoTerceirizado $fkTcmgoJuridicoTerceirizado
     * @return SwCgmPessoaJuridica
     */
    public function addFkTcmgoJuridicoTerceirizados(\Urbem\CoreBundle\Entity\Tcmgo\JuridicoTerceirizado $fkTcmgoJuridicoTerceirizado)
    {
        if (false === $this->fkTcmgoJuridicoTerceirizados->contains($fkTcmgoJuridicoTerceirizado)) {
            $fkTcmgoJuridicoTerceirizado->setFkSwCgmPessoaJuridica($this);
            $this->fkTcmgoJuridicoTerceirizados->add($fkTcmgoJuridicoTerceirizado);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoJuridicoTerceirizado
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\JuridicoTerceirizado $fkTcmgoJuridicoTerceirizado
     */
    public function removeFkTcmgoJuridicoTerceirizados(\Urbem\CoreBundle\Entity\Tcmgo\JuridicoTerceirizado $fkTcmgoJuridicoTerceirizado)
    {
        $this->fkTcmgoJuridicoTerceirizados->removeElement($fkTcmgoJuridicoTerceirizado);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoJuridicoTerceirizados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\JuridicoTerceirizado
     */
    public function getFkTcmgoJuridicoTerceirizados()
    {
        return $this->fkTcmgoJuridicoTerceirizados;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\Orgao $fkTcmgoOrgao
     * @return SwCgmPessoaJuridica
     */
    public function addFkTcmgoOrgoes(\Urbem\CoreBundle\Entity\Tcmgo\Orgao $fkTcmgoOrgao)
    {
        if (false === $this->fkTcmgoOrgoes->contains($fkTcmgoOrgao)) {
            $fkTcmgoOrgao->setFkSwCgmPessoaJuridica($this);
            $this->fkTcmgoOrgoes->add($fkTcmgoOrgao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\Orgao $fkTcmgoOrgao
     */
    public function removeFkTcmgoOrgoes(\Urbem\CoreBundle\Entity\Tcmgo\Orgao $fkTcmgoOrgao)
    {
        $this->fkTcmgoOrgoes->removeElement($fkTcmgoOrgao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoOrgoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\Orgao
     */
    public function getFkTcmgoOrgoes()
    {
        return $this->fkTcmgoOrgoes;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaVeiculoCessao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\VeiculoCessao $fkFrotaVeiculoCessao
     * @return SwCgmPessoaJuridica
     */
    public function addFkFrotaVeiculoCessoes(\Urbem\CoreBundle\Entity\Frota\VeiculoCessao $fkFrotaVeiculoCessao)
    {
        if (false === $this->fkFrotaVeiculoCessoes->contains($fkFrotaVeiculoCessao)) {
            $fkFrotaVeiculoCessao->setFkSwCgmPessoaJuridica($this);
            $this->fkFrotaVeiculoCessoes->add($fkFrotaVeiculoCessao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaVeiculoCessao
     *
     * @param \Urbem\CoreBundle\Entity\Frota\VeiculoCessao $fkFrotaVeiculoCessao
     */
    public function removeFkFrotaVeiculoCessoes(\Urbem\CoreBundle\Entity\Frota\VeiculoCessao $fkFrotaVeiculoCessao)
    {
        $this->fkFrotaVeiculoCessoes->removeElement($fkFrotaVeiculoCessao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaVeiculoCessoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\VeiculoCessao
     */
    public function getFkFrotaVeiculoCessoes()
    {
        return $this->fkFrotaVeiculoCessoes;
    }

    /**
     * OneToMany (owning side)
     * Add MonetarioAgencia
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Agencia $fkMonetarioAgencia
     * @return SwCgmPessoaJuridica
     */
    public function addFkMonetarioAgencias(\Urbem\CoreBundle\Entity\Monetario\Agencia $fkMonetarioAgencia)
    {
        if (false === $this->fkMonetarioAgencias->contains($fkMonetarioAgencia)) {
            $fkMonetarioAgencia->setFkSwCgmPessoaJuridica($this);
            $this->fkMonetarioAgencias->add($fkMonetarioAgencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove MonetarioAgencia
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Agencia $fkMonetarioAgencia
     */
    public function removeFkMonetarioAgencias(\Urbem\CoreBundle\Entity\Monetario\Agencia $fkMonetarioAgencia)
    {
        $this->fkMonetarioAgencias->removeElement($fkMonetarioAgencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkMonetarioAgencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\Agencia
     */
    public function getFkMonetarioAgencias()
    {
        return $this->fkMonetarioAgencias;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoOrgaoRegistro
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\OrgaoRegistro $fkAdministracaoOrgaoRegistro
     * @return SwCgmPessoaJuridica
     */
    public function setFkAdministracaoOrgaoRegistro(\Urbem\CoreBundle\Entity\Administracao\OrgaoRegistro $fkAdministracaoOrgaoRegistro)
    {
        $this->codOrgaoRegistro = $fkAdministracaoOrgaoRegistro->getCodigo();
        $this->fkAdministracaoOrgaoRegistro = $fkAdministracaoOrgaoRegistro;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoOrgaoRegistro
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\OrgaoRegistro
     */
    public function getFkAdministracaoOrgaoRegistro()
    {
        return $this->fkAdministracaoOrgaoRegistro;
    }

    /**
     * OneToOne (inverse side)
     * Set EstagioEntidadeIntermediadora
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EntidadeIntermediadora $fkEstagioEntidadeIntermediadora
     * @return SwCgmPessoaJuridica
     */
    public function setFkEstagioEntidadeIntermediadora(\Urbem\CoreBundle\Entity\Estagio\EntidadeIntermediadora $fkEstagioEntidadeIntermediadora)
    {
        $fkEstagioEntidadeIntermediadora->setFkSwCgmPessoaJuridica($this);
        $this->fkEstagioEntidadeIntermediadora = $fkEstagioEntidadeIntermediadora;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEstagioEntidadeIntermediadora
     *
     * @return \Urbem\CoreBundle\Entity\Estagio\EntidadeIntermediadora
     */
    public function getFkEstagioEntidadeIntermediadora()
    {
        return $this->fkEstagioEntidadeIntermediadora;
    }

    /**
     * OneToOne (inverse side)
     * Set EstagioInstituicaoEnsino
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\InstituicaoEnsino $fkEstagioInstituicaoEnsino
     * @return SwCgmPessoaJuridica
     */
    public function setFkEstagioInstituicaoEnsino(\Urbem\CoreBundle\Entity\Estagio\InstituicaoEnsino $fkEstagioInstituicaoEnsino)
    {
        $fkEstagioInstituicaoEnsino->setFkSwCgmPessoaJuridica($this);
        $this->fkEstagioInstituicaoEnsino = $fkEstagioInstituicaoEnsino;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEstagioInstituicaoEnsino
     *
     * @return \Urbem\CoreBundle\Entity\Estagio\InstituicaoEnsino
     */
    public function getFkEstagioInstituicaoEnsino()
    {
        return $this->fkEstagioInstituicaoEnsino;
    }

    /**
     * OneToOne (inverse side)
     * Set FolhapagamentoSindicato
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Sindicato $fkFolhapagamentoSindicato
     * @return SwCgmPessoaJuridica
     */
    public function setFkFolhapagamentoSindicato(\Urbem\CoreBundle\Entity\Folhapagamento\Sindicato $fkFolhapagamentoSindicato)
    {
        $fkFolhapagamentoSindicato->setFkSwCgmPessoaJuridica($this);
        $this->fkFolhapagamentoSindicato = $fkFolhapagamentoSindicato;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoSindicato
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\Sindicato
     */
    public function getFkFolhapagamentoSindicato()
    {
        return $this->fkFolhapagamentoSindicato;
    }

    /**
     * OneToOne (inverse side)
     * Set FrotaPosto
     *
     * @param \Urbem\CoreBundle\Entity\Frota\Posto $fkFrotaPosto
     * @return SwCgmPessoaJuridica
     */
    public function setFkFrotaPosto(\Urbem\CoreBundle\Entity\Frota\Posto $fkFrotaPosto)
    {
        $fkFrotaPosto->setFkSwCgmPessoaJuridica($this);
        $this->fkFrotaPosto = $fkFrotaPosto;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFrotaPosto
     *
     * @return \Urbem\CoreBundle\Entity\Frota\Posto
     */
    public function getFkFrotaPosto()
    {
        return $this->fkFrotaPosto;
    }

    /**
     * OneToOne (inverse side)
     * Set BeneficioFornecedor
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\Fornecedor $fkBeneficioFornecedor
     * @return SwCgmPessoaJuridica
     */
    public function setFkBeneficioFornecedor(\Urbem\CoreBundle\Entity\Beneficio\Fornecedor $fkBeneficioFornecedor)
    {
        $fkBeneficioFornecedor->setFkSwCgmPessoaJuridica($this);
        $this->fkBeneficioFornecedor = $fkBeneficioFornecedor;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkBeneficioFornecedor
     *
     * @return \Urbem\CoreBundle\Entity\Beneficio\Fornecedor
     */
    public function getFkBeneficioFornecedor()
    {
        return $this->fkBeneficioFornecedor;
    }

    /**
     * OneToOne (inverse side)
     * Set ImobiliarioCondominioCgm
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\CondominioCgm $fkImobiliarioCondominioCgm
     * @return SwCgmPessoaJuridica
     */
    public function setFkImobiliarioCondominioCgm(\Urbem\CoreBundle\Entity\Imobiliario\CondominioCgm $fkImobiliarioCondominioCgm)
    {
        $fkImobiliarioCondominioCgm->setFkSwCgmPessoaJuridica($this);
        $this->fkImobiliarioCondominioCgm = $fkImobiliarioCondominioCgm;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkImobiliarioCondominioCgm
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\CondominioCgm
     */
    public function getFkImobiliarioCondominioCgm()
    {
        return $this->fkImobiliarioCondominioCgm;
    }

    /**
     * OneToOne (owning side)
     * Set SwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return SwCgmPessoaJuridica
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgm = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }

    /**
     * @param integer $numcgm
     * @return SwCgmPessoaJuridica
     */
    public function findOneByNumcgm($numcgm)
    {
        return $this->repository->findOneByNumcgm($numcgm);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (!is_null($this->getFkSwCgm())) {
            return (string) $this->getFkSwCgm();
        }

        return "Pessoa Juridica";
    }
}
