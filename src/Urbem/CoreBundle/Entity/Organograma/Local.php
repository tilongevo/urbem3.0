<?php
 
namespace Urbem\CoreBundle\Entity\Organograma;

/**
 * Local
 */
class Local
{
    /**
     * PK
     * @var integer
     */
    private $codLocal;

    /**
     * @var integer
     */
    private $codLogradouro;

    /**
     * @var integer
     */
    private $numero;

    /**
     * @var string
     */
    private $fone;

    /**
     * @var integer
     */
    private $ramal;

    /**
     * @var boolean
     */
    private $dificilAcesso;

    /**
     * @var boolean
     */
    private $insalubre;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Impressora
     */
    private $fkAdministracaoImpressoras;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\DespesasFixas
     */
    private $fkEmpenhoDespesasFixas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioLocal
     */
    private $fkEstagioEstagiarioEstagioLocais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLocal
     */
    private $fkFolhapagamentoConfiguracaoEmpenhoLlaLocais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLocal
     */
    private $fkFolhapagamentoConfiguracaoEmpenhoLocais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\TerceirosHistorico
     */
    private $fkFrotaTerceirosHistoricos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanparaLocal
     */
    private $fkImaConfiguracaoBanparaLocais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulLocal
     */
    private $fkImaConfiguracaoBanrisulLocais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbLocal
     */
    private $fkImaConfiguracaoBbLocais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescLocal
     */
    private $fkImaConfiguracaoBescLocais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcLocal
     */
    private $fkImaConfiguracaoHsbcLocais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\ArquivoColetoraDados
     */
    private $fkPatrimonioArquivoColetoraDados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AdidoCedidoLocal
     */
    private $fkPessoalAdidoCedidoLocais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorLocal
     */
    private $fkPessoalContratoServidorLocais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasLocal
     */
    private $fkPessoalLoteFeriasLocais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\FonteRecursoLocal
     */
    private $fkTcepeFonteRecursoLocais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\DeParaLocal
     */
    private $fkOrganogramaDeParaLocais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem
     */
    private $fkPatrimonioInventarioHistoricoBens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\HistoricoBem
     */
    private $fkPatrimonioHistoricoBens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\FonteRecursoLocal
     */
    private $fkTcmbaFonteRecursoLocais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorLocalHistorico
     */
    private $fkPessoalContratoServidorLocalHistoricos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwLogradouro
     */
    private $fkSwLogradouro;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAdministracaoImpressoras = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoDespesasFixas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEstagioEstagiarioEstagioLocais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoEmpenhoLlaLocais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoEmpenhoLocais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFrotaTerceirosHistoricos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoBanparaLocais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoBanrisulLocais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoBbLocais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoBescLocais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoHsbcLocais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioArquivoColetoraDados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalAdidoCedidoLocais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorLocais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalLoteFeriasLocais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepeFonteRecursoLocais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrganogramaDeParaLocais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioInventarioHistoricoBens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioHistoricoBens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmbaFonteRecursoLocais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorLocalHistoricos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codLocal
     *
     * @param integer $codLocal
     * @return Local
     */
    public function setCodLocal($codLocal)
    {
        $this->codLocal = $codLocal;
        return $this;
    }

    /**
     * Get codLocal
     *
     * @return integer
     */
    public function getCodLocal()
    {
        return $this->codLocal;
    }

    /**
     * Set codLogradouro
     *
     * @param integer $codLogradouro
     * @return Local
     */
    public function setCodLogradouro($codLogradouro)
    {
        $this->codLogradouro = $codLogradouro;
        return $this;
    }

    /**
     * Get codLogradouro
     *
     * @return integer
     */
    public function getCodLogradouro()
    {
        return $this->codLogradouro;
    }

    /**
     * Set numero
     *
     * @param integer $numero
     * @return Local
     */
    public function setNumero($numero = null)
    {
        $this->numero = $numero;
        return $this;
    }

    /**
     * Get numero
     *
     * @return integer
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set fone
     *
     * @param string $fone
     * @return Local
     */
    public function setFone($fone = null)
    {
        $this->fone = $fone;
        return $this;
    }

    /**
     * Get fone
     *
     * @return string
     */
    public function getFone()
    {
        return $this->fone;
    }

    /**
     * Set ramal
     *
     * @param integer $ramal
     * @return Local
     */
    public function setRamal($ramal = null)
    {
        $this->ramal = $ramal;
        return $this;
    }

    /**
     * Get ramal
     *
     * @return integer
     */
    public function getRamal()
    {
        return $this->ramal;
    }

    /**
     * Set dificilAcesso
     *
     * @param boolean $dificilAcesso
     * @return Local
     */
    public function setDificilAcesso($dificilAcesso)
    {
        $this->dificilAcesso = $dificilAcesso;
        return $this;
    }

    /**
     * Get dificilAcesso
     *
     * @return boolean
     */
    public function getDificilAcesso()
    {
        return $this->dificilAcesso;
    }

    /**
     * Set insalubre
     *
     * @param boolean $insalubre
     * @return Local
     */
    public function setInsalubre($insalubre)
    {
        $this->insalubre = $insalubre;
        return $this;
    }

    /**
     * Get insalubre
     *
     * @return boolean
     */
    public function getInsalubre()
    {
        return $this->insalubre;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Local
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
     * Add AdministracaoImpressora
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Impressora $fkAdministracaoImpressora
     * @return Local
     */
    public function addFkAdministracaoImpressoras(\Urbem\CoreBundle\Entity\Administracao\Impressora $fkAdministracaoImpressora)
    {
        if (false === $this->fkAdministracaoImpressoras->contains($fkAdministracaoImpressora)) {
            $fkAdministracaoImpressora->setFkOrganogramaLocal($this);
            $this->fkAdministracaoImpressoras->add($fkAdministracaoImpressora);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoImpressora
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Impressora $fkAdministracaoImpressora
     */
    public function removeFkAdministracaoImpressoras(\Urbem\CoreBundle\Entity\Administracao\Impressora $fkAdministracaoImpressora)
    {
        $this->fkAdministracaoImpressoras->removeElement($fkAdministracaoImpressora);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoImpressoras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Impressora
     */
    public function getFkAdministracaoImpressoras()
    {
        return $this->fkAdministracaoImpressoras;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoDespesasFixas
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\DespesasFixas $fkEmpenhoDespesasFixas
     * @return Local
     */
    public function addFkEmpenhoDespesasFixas(\Urbem\CoreBundle\Entity\Empenho\DespesasFixas $fkEmpenhoDespesasFixas)
    {
        if (false === $this->fkEmpenhoDespesasFixas->contains($fkEmpenhoDespesasFixas)) {
            $fkEmpenhoDespesasFixas->setFkOrganogramaLocal($this);
            $this->fkEmpenhoDespesasFixas->add($fkEmpenhoDespesasFixas);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoDespesasFixas
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\DespesasFixas $fkEmpenhoDespesasFixas
     */
    public function removeFkEmpenhoDespesasFixas(\Urbem\CoreBundle\Entity\Empenho\DespesasFixas $fkEmpenhoDespesasFixas)
    {
        $this->fkEmpenhoDespesasFixas->removeElement($fkEmpenhoDespesasFixas);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoDespesasFixas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\DespesasFixas
     */
    public function getFkEmpenhoDespesasFixas()
    {
        return $this->fkEmpenhoDespesasFixas;
    }

    /**
     * OneToMany (owning side)
     * Add EstagioEstagiarioEstagioLocal
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioLocal $fkEstagioEstagiarioEstagioLocal
     * @return Local
     */
    public function addFkEstagioEstagiarioEstagioLocais(\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioLocal $fkEstagioEstagiarioEstagioLocal)
    {
        if (false === $this->fkEstagioEstagiarioEstagioLocais->contains($fkEstagioEstagiarioEstagioLocal)) {
            $fkEstagioEstagiarioEstagioLocal->setFkOrganogramaLocal($this);
            $this->fkEstagioEstagiarioEstagioLocais->add($fkEstagioEstagiarioEstagioLocal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EstagioEstagiarioEstagioLocal
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioLocal $fkEstagioEstagiarioEstagioLocal
     */
    public function removeFkEstagioEstagiarioEstagioLocais(\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioLocal $fkEstagioEstagiarioEstagioLocal)
    {
        $this->fkEstagioEstagiarioEstagioLocais->removeElement($fkEstagioEstagiarioEstagioLocal);
    }

    /**
     * OneToMany (owning side)
     * Get fkEstagioEstagiarioEstagioLocais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioLocal
     */
    public function getFkEstagioEstagiarioEstagioLocais()
    {
        return $this->fkEstagioEstagiarioEstagioLocais;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoEmpenhoLlaLocal
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLocal $fkFolhapagamentoConfiguracaoEmpenhoLlaLocal
     * @return Local
     */
    public function addFkFolhapagamentoConfiguracaoEmpenhoLlaLocais(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLocal $fkFolhapagamentoConfiguracaoEmpenhoLlaLocal)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEmpenhoLlaLocais->contains($fkFolhapagamentoConfiguracaoEmpenhoLlaLocal)) {
            $fkFolhapagamentoConfiguracaoEmpenhoLlaLocal->setFkOrganogramaLocal($this);
            $this->fkFolhapagamentoConfiguracaoEmpenhoLlaLocais->add($fkFolhapagamentoConfiguracaoEmpenhoLlaLocal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEmpenhoLlaLocal
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLocal $fkFolhapagamentoConfiguracaoEmpenhoLlaLocal
     */
    public function removeFkFolhapagamentoConfiguracaoEmpenhoLlaLocais(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLocal $fkFolhapagamentoConfiguracaoEmpenhoLlaLocal)
    {
        $this->fkFolhapagamentoConfiguracaoEmpenhoLlaLocais->removeElement($fkFolhapagamentoConfiguracaoEmpenhoLlaLocal);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEmpenhoLlaLocais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLocal
     */
    public function getFkFolhapagamentoConfiguracaoEmpenhoLlaLocais()
    {
        return $this->fkFolhapagamentoConfiguracaoEmpenhoLlaLocais;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoEmpenhoLocal
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLocal $fkFolhapagamentoConfiguracaoEmpenhoLocal
     * @return Local
     */
    public function addFkFolhapagamentoConfiguracaoEmpenhoLocais(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLocal $fkFolhapagamentoConfiguracaoEmpenhoLocal)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEmpenhoLocais->contains($fkFolhapagamentoConfiguracaoEmpenhoLocal)) {
            $fkFolhapagamentoConfiguracaoEmpenhoLocal->setFkOrganogramaLocal($this);
            $this->fkFolhapagamentoConfiguracaoEmpenhoLocais->add($fkFolhapagamentoConfiguracaoEmpenhoLocal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEmpenhoLocal
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLocal $fkFolhapagamentoConfiguracaoEmpenhoLocal
     */
    public function removeFkFolhapagamentoConfiguracaoEmpenhoLocais(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLocal $fkFolhapagamentoConfiguracaoEmpenhoLocal)
    {
        $this->fkFolhapagamentoConfiguracaoEmpenhoLocais->removeElement($fkFolhapagamentoConfiguracaoEmpenhoLocal);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEmpenhoLocais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLocal
     */
    public function getFkFolhapagamentoConfiguracaoEmpenhoLocais()
    {
        return $this->fkFolhapagamentoConfiguracaoEmpenhoLocais;
    }

    /**
     * OneToMany (owning side)
     * Add FrotaTerceirosHistorico
     *
     * @param \Urbem\CoreBundle\Entity\Frota\TerceirosHistorico $fkFrotaTerceirosHistorico
     * @return Local
     */
    public function addFkFrotaTerceirosHistoricos(\Urbem\CoreBundle\Entity\Frota\TerceirosHistorico $fkFrotaTerceirosHistorico)
    {
        if (false === $this->fkFrotaTerceirosHistoricos->contains($fkFrotaTerceirosHistorico)) {
            $fkFrotaTerceirosHistorico->setFkOrganogramaLocal($this);
            $this->fkFrotaTerceirosHistoricos->add($fkFrotaTerceirosHistorico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FrotaTerceirosHistorico
     *
     * @param \Urbem\CoreBundle\Entity\Frota\TerceirosHistorico $fkFrotaTerceirosHistorico
     */
    public function removeFkFrotaTerceirosHistoricos(\Urbem\CoreBundle\Entity\Frota\TerceirosHistorico $fkFrotaTerceirosHistorico)
    {
        $this->fkFrotaTerceirosHistoricos->removeElement($fkFrotaTerceirosHistorico);
    }

    /**
     * OneToMany (owning side)
     * Get fkFrotaTerceirosHistoricos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Frota\TerceirosHistorico
     */
    public function getFkFrotaTerceirosHistoricos()
    {
        return $this->fkFrotaTerceirosHistoricos;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoBanparaLocal
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanparaLocal $fkImaConfiguracaoBanparaLocal
     * @return Local
     */
    public function addFkImaConfiguracaoBanparaLocais(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanparaLocal $fkImaConfiguracaoBanparaLocal)
    {
        if (false === $this->fkImaConfiguracaoBanparaLocais->contains($fkImaConfiguracaoBanparaLocal)) {
            $fkImaConfiguracaoBanparaLocal->setFkOrganogramaLocal($this);
            $this->fkImaConfiguracaoBanparaLocais->add($fkImaConfiguracaoBanparaLocal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoBanparaLocal
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanparaLocal $fkImaConfiguracaoBanparaLocal
     */
    public function removeFkImaConfiguracaoBanparaLocais(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanparaLocal $fkImaConfiguracaoBanparaLocal)
    {
        $this->fkImaConfiguracaoBanparaLocais->removeElement($fkImaConfiguracaoBanparaLocal);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoBanparaLocais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanparaLocal
     */
    public function getFkImaConfiguracaoBanparaLocais()
    {
        return $this->fkImaConfiguracaoBanparaLocais;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoBanrisulLocal
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulLocal $fkImaConfiguracaoBanrisulLocal
     * @return Local
     */
    public function addFkImaConfiguracaoBanrisulLocais(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulLocal $fkImaConfiguracaoBanrisulLocal)
    {
        if (false === $this->fkImaConfiguracaoBanrisulLocais->contains($fkImaConfiguracaoBanrisulLocal)) {
            $fkImaConfiguracaoBanrisulLocal->setFkOrganogramaLocal($this);
            $this->fkImaConfiguracaoBanrisulLocais->add($fkImaConfiguracaoBanrisulLocal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoBanrisulLocal
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulLocal $fkImaConfiguracaoBanrisulLocal
     */
    public function removeFkImaConfiguracaoBanrisulLocais(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulLocal $fkImaConfiguracaoBanrisulLocal)
    {
        $this->fkImaConfiguracaoBanrisulLocais->removeElement($fkImaConfiguracaoBanrisulLocal);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoBanrisulLocais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulLocal
     */
    public function getFkImaConfiguracaoBanrisulLocais()
    {
        return $this->fkImaConfiguracaoBanrisulLocais;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoBbLocal
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbLocal $fkImaConfiguracaoBbLocal
     * @return Local
     */
    public function addFkImaConfiguracaoBbLocais(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbLocal $fkImaConfiguracaoBbLocal)
    {
        if (false === $this->fkImaConfiguracaoBbLocais->contains($fkImaConfiguracaoBbLocal)) {
            $fkImaConfiguracaoBbLocal->setFkOrganogramaLocal($this);
            $this->fkImaConfiguracaoBbLocais->add($fkImaConfiguracaoBbLocal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoBbLocal
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbLocal $fkImaConfiguracaoBbLocal
     */
    public function removeFkImaConfiguracaoBbLocais(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbLocal $fkImaConfiguracaoBbLocal)
    {
        $this->fkImaConfiguracaoBbLocais->removeElement($fkImaConfiguracaoBbLocal);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoBbLocais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbLocal
     */
    public function getFkImaConfiguracaoBbLocais()
    {
        return $this->fkImaConfiguracaoBbLocais;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoBescLocal
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescLocal $fkImaConfiguracaoBescLocal
     * @return Local
     */
    public function addFkImaConfiguracaoBescLocais(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescLocal $fkImaConfiguracaoBescLocal)
    {
        if (false === $this->fkImaConfiguracaoBescLocais->contains($fkImaConfiguracaoBescLocal)) {
            $fkImaConfiguracaoBescLocal->setFkOrganogramaLocal($this);
            $this->fkImaConfiguracaoBescLocais->add($fkImaConfiguracaoBescLocal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoBescLocal
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescLocal $fkImaConfiguracaoBescLocal
     */
    public function removeFkImaConfiguracaoBescLocais(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescLocal $fkImaConfiguracaoBescLocal)
    {
        $this->fkImaConfiguracaoBescLocais->removeElement($fkImaConfiguracaoBescLocal);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoBescLocais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescLocal
     */
    public function getFkImaConfiguracaoBescLocais()
    {
        return $this->fkImaConfiguracaoBescLocais;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoHsbcLocal
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcLocal $fkImaConfiguracaoHsbcLocal
     * @return Local
     */
    public function addFkImaConfiguracaoHsbcLocais(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcLocal $fkImaConfiguracaoHsbcLocal)
    {
        if (false === $this->fkImaConfiguracaoHsbcLocais->contains($fkImaConfiguracaoHsbcLocal)) {
            $fkImaConfiguracaoHsbcLocal->setFkOrganogramaLocal($this);
            $this->fkImaConfiguracaoHsbcLocais->add($fkImaConfiguracaoHsbcLocal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoHsbcLocal
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcLocal $fkImaConfiguracaoHsbcLocal
     */
    public function removeFkImaConfiguracaoHsbcLocais(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcLocal $fkImaConfiguracaoHsbcLocal)
    {
        $this->fkImaConfiguracaoHsbcLocais->removeElement($fkImaConfiguracaoHsbcLocal);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoHsbcLocais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcLocal
     */
    public function getFkImaConfiguracaoHsbcLocais()
    {
        return $this->fkImaConfiguracaoHsbcLocais;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioArquivoColetoraDados
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\ArquivoColetoraDados $fkPatrimonioArquivoColetoraDados
     * @return Local
     */
    public function addFkPatrimonioArquivoColetoraDados(\Urbem\CoreBundle\Entity\Patrimonio\ArquivoColetoraDados $fkPatrimonioArquivoColetoraDados)
    {
        if (false === $this->fkPatrimonioArquivoColetoraDados->contains($fkPatrimonioArquivoColetoraDados)) {
            $fkPatrimonioArquivoColetoraDados->setFkOrganogramaLocal($this);
            $this->fkPatrimonioArquivoColetoraDados->add($fkPatrimonioArquivoColetoraDados);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioArquivoColetoraDados
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\ArquivoColetoraDados $fkPatrimonioArquivoColetoraDados
     */
    public function removeFkPatrimonioArquivoColetoraDados(\Urbem\CoreBundle\Entity\Patrimonio\ArquivoColetoraDados $fkPatrimonioArquivoColetoraDados)
    {
        $this->fkPatrimonioArquivoColetoraDados->removeElement($fkPatrimonioArquivoColetoraDados);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioArquivoColetoraDados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\ArquivoColetoraDados
     */
    public function getFkPatrimonioArquivoColetoraDados()
    {
        return $this->fkPatrimonioArquivoColetoraDados;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalAdidoCedidoLocal
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AdidoCedidoLocal $fkPessoalAdidoCedidoLocal
     * @return Local
     */
    public function addFkPessoalAdidoCedidoLocais(\Urbem\CoreBundle\Entity\Pessoal\AdidoCedidoLocal $fkPessoalAdidoCedidoLocal)
    {
        if (false === $this->fkPessoalAdidoCedidoLocais->contains($fkPessoalAdidoCedidoLocal)) {
            $fkPessoalAdidoCedidoLocal->setFkOrganogramaLocal($this);
            $this->fkPessoalAdidoCedidoLocais->add($fkPessoalAdidoCedidoLocal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalAdidoCedidoLocal
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AdidoCedidoLocal $fkPessoalAdidoCedidoLocal
     */
    public function removeFkPessoalAdidoCedidoLocais(\Urbem\CoreBundle\Entity\Pessoal\AdidoCedidoLocal $fkPessoalAdidoCedidoLocal)
    {
        $this->fkPessoalAdidoCedidoLocais->removeElement($fkPessoalAdidoCedidoLocal);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalAdidoCedidoLocais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AdidoCedidoLocal
     */
    public function getFkPessoalAdidoCedidoLocais()
    {
        return $this->fkPessoalAdidoCedidoLocais;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorLocal
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorLocal $fkPessoalContratoServidorLocal
     * @return Local
     */
    public function addFkPessoalContratoServidorLocais(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorLocal $fkPessoalContratoServidorLocal)
    {
        if (false === $this->fkPessoalContratoServidorLocais->contains($fkPessoalContratoServidorLocal)) {
            $fkPessoalContratoServidorLocal->setFkOrganogramaLocal($this);
            $this->fkPessoalContratoServidorLocais->add($fkPessoalContratoServidorLocal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorLocal
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorLocal $fkPessoalContratoServidorLocal
     */
    public function removeFkPessoalContratoServidorLocais(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorLocal $fkPessoalContratoServidorLocal)
    {
        $this->fkPessoalContratoServidorLocais->removeElement($fkPessoalContratoServidorLocal);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorLocais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorLocal
     */
    public function getFkPessoalContratoServidorLocais()
    {
        return $this->fkPessoalContratoServidorLocais;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalLoteFeriasLocal
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\LoteFeriasLocal $fkPessoalLoteFeriasLocal
     * @return Local
     */
    public function addFkPessoalLoteFeriasLocais(\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasLocal $fkPessoalLoteFeriasLocal)
    {
        if (false === $this->fkPessoalLoteFeriasLocais->contains($fkPessoalLoteFeriasLocal)) {
            $fkPessoalLoteFeriasLocal->setFkOrganogramaLocal($this);
            $this->fkPessoalLoteFeriasLocais->add($fkPessoalLoteFeriasLocal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalLoteFeriasLocal
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\LoteFeriasLocal $fkPessoalLoteFeriasLocal
     */
    public function removeFkPessoalLoteFeriasLocais(\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasLocal $fkPessoalLoteFeriasLocal)
    {
        $this->fkPessoalLoteFeriasLocais->removeElement($fkPessoalLoteFeriasLocal);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalLoteFeriasLocais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasLocal
     */
    public function getFkPessoalLoteFeriasLocais()
    {
        return $this->fkPessoalLoteFeriasLocais;
    }

    /**
     * OneToMany (owning side)
     * Add TcepeFonteRecursoLocal
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\FonteRecursoLocal $fkTcepeFonteRecursoLocal
     * @return Local
     */
    public function addFkTcepeFonteRecursoLocais(\Urbem\CoreBundle\Entity\Tcepe\FonteRecursoLocal $fkTcepeFonteRecursoLocal)
    {
        if (false === $this->fkTcepeFonteRecursoLocais->contains($fkTcepeFonteRecursoLocal)) {
            $fkTcepeFonteRecursoLocal->setFkOrganogramaLocal($this);
            $this->fkTcepeFonteRecursoLocais->add($fkTcepeFonteRecursoLocal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepeFonteRecursoLocal
     *
     * @param \Urbem\CoreBundle\Entity\Tcepe\FonteRecursoLocal $fkTcepeFonteRecursoLocal
     */
    public function removeFkTcepeFonteRecursoLocais(\Urbem\CoreBundle\Entity\Tcepe\FonteRecursoLocal $fkTcepeFonteRecursoLocal)
    {
        $this->fkTcepeFonteRecursoLocais->removeElement($fkTcepeFonteRecursoLocal);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepeFonteRecursoLocais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepe\FonteRecursoLocal
     */
    public function getFkTcepeFonteRecursoLocais()
    {
        return $this->fkTcepeFonteRecursoLocais;
    }

    /**
     * OneToMany (owning side)
     * Add OrganogramaDeParaLocal
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\DeParaLocal $fkOrganogramaDeParaLocal
     * @return Local
     */
    public function addFkOrganogramaDeParaLocais(\Urbem\CoreBundle\Entity\Organograma\DeParaLocal $fkOrganogramaDeParaLocal)
    {
        if (false === $this->fkOrganogramaDeParaLocais->contains($fkOrganogramaDeParaLocal)) {
            $fkOrganogramaDeParaLocal->setFkOrganogramaLocal($this);
            $this->fkOrganogramaDeParaLocais->add($fkOrganogramaDeParaLocal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrganogramaDeParaLocal
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\DeParaLocal $fkOrganogramaDeParaLocal
     */
    public function removeFkOrganogramaDeParaLocais(\Urbem\CoreBundle\Entity\Organograma\DeParaLocal $fkOrganogramaDeParaLocal)
    {
        $this->fkOrganogramaDeParaLocais->removeElement($fkOrganogramaDeParaLocal);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrganogramaDeParaLocais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\DeParaLocal
     */
    public function getFkOrganogramaDeParaLocais()
    {
        return $this->fkOrganogramaDeParaLocais;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioInventarioHistoricoBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem $fkPatrimonioInventarioHistoricoBem
     * @return Local
     */
    public function addFkPatrimonioInventarioHistoricoBens(\Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem $fkPatrimonioInventarioHistoricoBem)
    {
        if (false === $this->fkPatrimonioInventarioHistoricoBens->contains($fkPatrimonioInventarioHistoricoBem)) {
            $fkPatrimonioInventarioHistoricoBem->setFkOrganogramaLocal($this);
            $this->fkPatrimonioInventarioHistoricoBens->add($fkPatrimonioInventarioHistoricoBem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioInventarioHistoricoBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem $fkPatrimonioInventarioHistoricoBem
     */
    public function removeFkPatrimonioInventarioHistoricoBens(\Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem $fkPatrimonioInventarioHistoricoBem)
    {
        $this->fkPatrimonioInventarioHistoricoBens->removeElement($fkPatrimonioInventarioHistoricoBem);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioInventarioHistoricoBens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem
     */
    public function getFkPatrimonioInventarioHistoricoBens()
    {
        return $this->fkPatrimonioInventarioHistoricoBens;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioHistoricoBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\HistoricoBem $fkPatrimonioHistoricoBem
     * @return Local
     */
    public function addFkPatrimonioHistoricoBens(\Urbem\CoreBundle\Entity\Patrimonio\HistoricoBem $fkPatrimonioHistoricoBem)
    {
        if (false === $this->fkPatrimonioHistoricoBens->contains($fkPatrimonioHistoricoBem)) {
            $fkPatrimonioHistoricoBem->setFkOrganogramaLocal($this);
            $this->fkPatrimonioHistoricoBens->add($fkPatrimonioHistoricoBem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioHistoricoBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\HistoricoBem $fkPatrimonioHistoricoBem
     */
    public function removeFkPatrimonioHistoricoBens(\Urbem\CoreBundle\Entity\Patrimonio\HistoricoBem $fkPatrimonioHistoricoBem)
    {
        $this->fkPatrimonioHistoricoBens->removeElement($fkPatrimonioHistoricoBem);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioHistoricoBens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\HistoricoBem
     */
    public function getFkPatrimonioHistoricoBens()
    {
        return $this->fkPatrimonioHistoricoBens;
    }

    /**
     * OneToMany (owning side)
     * Add TcmbaFonteRecursoLocal
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\FonteRecursoLocal $fkTcmbaFonteRecursoLocal
     * @return Local
     */
    public function addFkTcmbaFonteRecursoLocais(\Urbem\CoreBundle\Entity\Tcmba\FonteRecursoLocal $fkTcmbaFonteRecursoLocal)
    {
        if (false === $this->fkTcmbaFonteRecursoLocais->contains($fkTcmbaFonteRecursoLocal)) {
            $fkTcmbaFonteRecursoLocal->setFkOrganogramaLocal($this);
            $this->fkTcmbaFonteRecursoLocais->add($fkTcmbaFonteRecursoLocal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaFonteRecursoLocal
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\FonteRecursoLocal $fkTcmbaFonteRecursoLocal
     */
    public function removeFkTcmbaFonteRecursoLocais(\Urbem\CoreBundle\Entity\Tcmba\FonteRecursoLocal $fkTcmbaFonteRecursoLocal)
    {
        $this->fkTcmbaFonteRecursoLocais->removeElement($fkTcmbaFonteRecursoLocal);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaFonteRecursoLocais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\FonteRecursoLocal
     */
    public function getFkTcmbaFonteRecursoLocais()
    {
        return $this->fkTcmbaFonteRecursoLocais;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorLocalHistorico
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorLocalHistorico $fkPessoalContratoServidorLocalHistorico
     * @return Local
     */
    public function addFkPessoalContratoServidorLocalHistoricos(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorLocalHistorico $fkPessoalContratoServidorLocalHistorico)
    {
        if (false === $this->fkPessoalContratoServidorLocalHistoricos->contains($fkPessoalContratoServidorLocalHistorico)) {
            $fkPessoalContratoServidorLocalHistorico->setFkOrganogramaLocal($this);
            $this->fkPessoalContratoServidorLocalHistoricos->add($fkPessoalContratoServidorLocalHistorico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorLocalHistorico
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorLocalHistorico $fkPessoalContratoServidorLocalHistorico
     */
    public function removeFkPessoalContratoServidorLocalHistoricos(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorLocalHistorico $fkPessoalContratoServidorLocalHistorico)
    {
        $this->fkPessoalContratoServidorLocalHistoricos->removeElement($fkPessoalContratoServidorLocalHistorico);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorLocalHistoricos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorLocalHistorico
     */
    public function getFkPessoalContratoServidorLocalHistoricos()
    {
        return $this->fkPessoalContratoServidorLocalHistoricos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwLogradouro $fkSwLogradouro
     * @return Local
     */
    public function setFkSwLogradouro(\Urbem\CoreBundle\Entity\SwLogradouro $fkSwLogradouro)
    {
        $this->codLogradouro = $fkSwLogradouro->getCodLogradouro();
        $this->fkSwLogradouro = $fkSwLogradouro;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwLogradouro
     *
     * @return \Urbem\CoreBundle\Entity\SwLogradouro
     */
    public function getFkSwLogradouro()
    {
        return $this->fkSwLogradouro;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '%s - %s',
            $this->codLocal,
            $this->descricao
        );
    }
}
