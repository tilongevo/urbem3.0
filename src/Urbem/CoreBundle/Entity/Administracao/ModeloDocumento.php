<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * ModeloDocumento
 */
class ModeloDocumento
{
    /**
     * PK
     * @var integer
     */
    private $codDocumento;

    /**
     * PK
     * @var integer
     */
    private $codTipoDocumento;

    /**
     * @var string
     */
    private $nomeDocumento;

    /**
     * @var string
     */
    private $nomeArquivoAgt;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Documento
     */
    private $fkArrecadacaoDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\Homologacao
     */
    private $fkComprasHomologacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\Documento
     */
    private $fkDividaDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ModalidadeDocumento
     */
    private $fkDividaModalidadeDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\EmissaoDocumento
     */
    private $fkEconomicoEmissaoDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\LicencaDocumento
     */
    private $fkEconomicoLicencaDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\AutenticacaoDocumento
     */
    private $fkFiscalizacaoAutenticacaoDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\AutoFiscalizacao
     */
    private $fkFiscalizacaoAutoFiscalizacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\AutorizacaoDocumento
     */
    private $fkFiscalizacaoAutorizacaoDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacao
     */
    private $fkFiscalizacaoInicioFiscalizacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoInfracao
     */
    private $fkFiscalizacaoNotificacaoInfracoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoTermo
     */
    private $fkFiscalizacaoNotificacaoTermos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeDocumento
     */
    private $fkFiscalizacaoPenalidadeDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\TerminoFiscalizacao
     */
    private $fkFiscalizacaoTerminoFiscalizacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaDocumento
     */
    private $fkImobiliarioLicencaDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\TipoLicencaDocumento
     */
    private $fkImobiliarioTipoLicencaDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Adjudicacao
     */
    private $fkLicitacaoAdjudicacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Convenio
     */
    private $fkLicitacaoConvenios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Contrato
     */
    private $fkLicitacaoContratos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacaoPenalidade
     */
    private $fkLicitacaoParticipanteCertificacaoPenalidades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Homologacao
     */
    private $fkLicitacaoHomologacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Edital
     */
    private $fkLicitacaoEditais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\ModeloArquivosDocumento
     */
    private $fkAdministracaoModeloArquivosDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\BaixaEmissao
     */
    private $fkEconomicoBaixaEmissoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\TipoLicencaModeloDocumento
     */
    private $fkEconomicoTipoLicencaModeloDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\AutoInfracao
     */
    private $fkFiscalizacaoAutoInfracoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\BaixaDocumento
     */
    private $fkFiscalizacaoBaixaDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoFiscalizacao
     */
    private $fkFiscalizacaoNotificacaoFiscalizacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacao
     */
    private $fkLicitacaoParticipanteCertificacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\TipoDocumento
     */
    private $fkAdministracaoTipoDocumento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasHomologacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaModalidadeDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoEmissaoDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoLicencaDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoAutenticacaoDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoAutoFiscalizacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoAutorizacaoDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoInicioFiscalizacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoNotificacaoInfracoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoNotificacaoTermos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoPenalidadeDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoTerminoFiscalizacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioLicencaDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioTipoLicencaDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoAdjudicacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoConvenios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoContratos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoParticipanteCertificacaoPenalidades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoHomologacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoEditais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAdministracaoModeloArquivosDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoBaixaEmissoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoTipoLicencaModeloDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoAutoInfracoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoBaixaDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoNotificacaoFiscalizacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoParticipanteCertificacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return ModeloDocumento
     */
    public function setCodDocumento($codDocumento)
    {
        $this->codDocumento = $codDocumento;
        return $this;
    }

    /**
     * Get codDocumento
     *
     * @return integer
     */
    public function getCodDocumento()
    {
        return $this->codDocumento;
    }

    /**
     * Set codTipoDocumento
     *
     * @param integer $codTipoDocumento
     * @return ModeloDocumento
     */
    public function setCodTipoDocumento($codTipoDocumento)
    {
        $this->codTipoDocumento = $codTipoDocumento;
        return $this;
    }

    /**
     * Get codTipoDocumento
     *
     * @return integer
     */
    public function getCodTipoDocumento()
    {
        return $this->codTipoDocumento;
    }

    /**
     * Set nomeDocumento
     *
     * @param string $nomeDocumento
     * @return ModeloDocumento
     */
    public function setNomeDocumento($nomeDocumento)
    {
        $this->nomeDocumento = $nomeDocumento;
        return $this;
    }

    /**
     * Get nomeDocumento
     *
     * @return string
     */
    public function getNomeDocumento()
    {
        return $this->nomeDocumento;
    }

    /**
     * Set nomeArquivoAgt
     *
     * @param string $nomeArquivoAgt
     * @return ModeloDocumento
     */
    public function setNomeArquivoAgt($nomeArquivoAgt)
    {
        $this->nomeArquivoAgt = $nomeArquivoAgt;
        return $this;
    }

    /**
     * Get nomeArquivoAgt
     *
     * @return string
     */
    public function getNomeArquivoAgt()
    {
        return $this->nomeArquivoAgt;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Documento $fkArrecadacaoDocumento
     * @return ModeloDocumento
     */
    public function addFkArrecadacaoDocumentos(\Urbem\CoreBundle\Entity\Arrecadacao\Documento $fkArrecadacaoDocumento)
    {
        if (false === $this->fkArrecadacaoDocumentos->contains($fkArrecadacaoDocumento)) {
            $fkArrecadacaoDocumento->setFkAdministracaoModeloDocumento($this);
            $this->fkArrecadacaoDocumentos->add($fkArrecadacaoDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Documento $fkArrecadacaoDocumento
     */
    public function removeFkArrecadacaoDocumentos(\Urbem\CoreBundle\Entity\Arrecadacao\Documento $fkArrecadacaoDocumento)
    {
        $this->fkArrecadacaoDocumentos->removeElement($fkArrecadacaoDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Documento
     */
    public function getFkArrecadacaoDocumentos()
    {
        return $this->fkArrecadacaoDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasHomologacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Homologacao $fkComprasHomologacao
     * @return ModeloDocumento
     */
    public function addFkComprasHomologacoes(\Urbem\CoreBundle\Entity\Compras\Homologacao $fkComprasHomologacao)
    {
        if (false === $this->fkComprasHomologacoes->contains($fkComprasHomologacao)) {
            $fkComprasHomologacao->setFkAdministracaoModeloDocumento($this);
            $this->fkComprasHomologacoes->add($fkComprasHomologacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasHomologacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Homologacao $fkComprasHomologacao
     */
    public function removeFkComprasHomologacoes(\Urbem\CoreBundle\Entity\Compras\Homologacao $fkComprasHomologacao)
    {
        $this->fkComprasHomologacoes->removeElement($fkComprasHomologacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasHomologacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\Homologacao
     */
    public function getFkComprasHomologacoes()
    {
        return $this->fkComprasHomologacoes;
    }

    /**
     * OneToMany (owning side)
     * Add DividaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Divida\Documento $fkDividaDocumento
     * @return ModeloDocumento
     */
    public function addFkDividaDocumentos(\Urbem\CoreBundle\Entity\Divida\Documento $fkDividaDocumento)
    {
        if (false === $this->fkDividaDocumentos->contains($fkDividaDocumento)) {
            $fkDividaDocumento->setFkAdministracaoModeloDocumento($this);
            $this->fkDividaDocumentos->add($fkDividaDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Divida\Documento $fkDividaDocumento
     */
    public function removeFkDividaDocumentos(\Urbem\CoreBundle\Entity\Divida\Documento $fkDividaDocumento)
    {
        $this->fkDividaDocumentos->removeElement($fkDividaDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\Documento
     */
    public function getFkDividaDocumentos()
    {
        return $this->fkDividaDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add DividaModalidadeDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeDocumento $fkDividaModalidadeDocumento
     * @return ModeloDocumento
     */
    public function addFkDividaModalidadeDocumentos(\Urbem\CoreBundle\Entity\Divida\ModalidadeDocumento $fkDividaModalidadeDocumento)
    {
        if (false === $this->fkDividaModalidadeDocumentos->contains($fkDividaModalidadeDocumento)) {
            $fkDividaModalidadeDocumento->setFkAdministracaoModeloDocumento($this);
            $this->fkDividaModalidadeDocumentos->add($fkDividaModalidadeDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaModalidadeDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeDocumento $fkDividaModalidadeDocumento
     */
    public function removeFkDividaModalidadeDocumentos(\Urbem\CoreBundle\Entity\Divida\ModalidadeDocumento $fkDividaModalidadeDocumento)
    {
        $this->fkDividaModalidadeDocumentos->removeElement($fkDividaModalidadeDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaModalidadeDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ModalidadeDocumento
     */
    public function getFkDividaModalidadeDocumentos()
    {
        return $this->fkDividaModalidadeDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoEmissaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Economico\EmissaoDocumento $fkEconomicoEmissaoDocumento
     * @return ModeloDocumento
     */
    public function addFkEconomicoEmissaoDocumentos(\Urbem\CoreBundle\Entity\Economico\EmissaoDocumento $fkEconomicoEmissaoDocumento)
    {
        if (false === $this->fkEconomicoEmissaoDocumentos->contains($fkEconomicoEmissaoDocumento)) {
            $fkEconomicoEmissaoDocumento->setFkAdministracaoModeloDocumento($this);
            $this->fkEconomicoEmissaoDocumentos->add($fkEconomicoEmissaoDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoEmissaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Economico\EmissaoDocumento $fkEconomicoEmissaoDocumento
     */
    public function removeFkEconomicoEmissaoDocumentos(\Urbem\CoreBundle\Entity\Economico\EmissaoDocumento $fkEconomicoEmissaoDocumento)
    {
        $this->fkEconomicoEmissaoDocumentos->removeElement($fkEconomicoEmissaoDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoEmissaoDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\EmissaoDocumento
     */
    public function getFkEconomicoEmissaoDocumentos()
    {
        return $this->fkEconomicoEmissaoDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoLicencaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Economico\LicencaDocumento $fkEconomicoLicencaDocumento
     * @return ModeloDocumento
     */
    public function addFkEconomicoLicencaDocumentos(\Urbem\CoreBundle\Entity\Economico\LicencaDocumento $fkEconomicoLicencaDocumento)
    {
        if (false === $this->fkEconomicoLicencaDocumentos->contains($fkEconomicoLicencaDocumento)) {
            $fkEconomicoLicencaDocumento->setFkAdministracaoModeloDocumento($this);
            $this->fkEconomicoLicencaDocumentos->add($fkEconomicoLicencaDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoLicencaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Economico\LicencaDocumento $fkEconomicoLicencaDocumento
     */
    public function removeFkEconomicoLicencaDocumentos(\Urbem\CoreBundle\Entity\Economico\LicencaDocumento $fkEconomicoLicencaDocumento)
    {
        $this->fkEconomicoLicencaDocumentos->removeElement($fkEconomicoLicencaDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoLicencaDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\LicencaDocumento
     */
    public function getFkEconomicoLicencaDocumentos()
    {
        return $this->fkEconomicoLicencaDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoAutenticacaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\AutenticacaoDocumento $fkFiscalizacaoAutenticacaoDocumento
     * @return ModeloDocumento
     */
    public function addFkFiscalizacaoAutenticacaoDocumentos(\Urbem\CoreBundle\Entity\Fiscalizacao\AutenticacaoDocumento $fkFiscalizacaoAutenticacaoDocumento)
    {
        if (false === $this->fkFiscalizacaoAutenticacaoDocumentos->contains($fkFiscalizacaoAutenticacaoDocumento)) {
            $fkFiscalizacaoAutenticacaoDocumento->setFkAdministracaoModeloDocumento($this);
            $this->fkFiscalizacaoAutenticacaoDocumentos->add($fkFiscalizacaoAutenticacaoDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoAutenticacaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\AutenticacaoDocumento $fkFiscalizacaoAutenticacaoDocumento
     */
    public function removeFkFiscalizacaoAutenticacaoDocumentos(\Urbem\CoreBundle\Entity\Fiscalizacao\AutenticacaoDocumento $fkFiscalizacaoAutenticacaoDocumento)
    {
        $this->fkFiscalizacaoAutenticacaoDocumentos->removeElement($fkFiscalizacaoAutenticacaoDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoAutenticacaoDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\AutenticacaoDocumento
     */
    public function getFkFiscalizacaoAutenticacaoDocumentos()
    {
        return $this->fkFiscalizacaoAutenticacaoDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoAutoFiscalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\AutoFiscalizacao $fkFiscalizacaoAutoFiscalizacao
     * @return ModeloDocumento
     */
    public function addFkFiscalizacaoAutoFiscalizacoes(\Urbem\CoreBundle\Entity\Fiscalizacao\AutoFiscalizacao $fkFiscalizacaoAutoFiscalizacao)
    {
        if (false === $this->fkFiscalizacaoAutoFiscalizacoes->contains($fkFiscalizacaoAutoFiscalizacao)) {
            $fkFiscalizacaoAutoFiscalizacao->setFkAdministracaoModeloDocumento($this);
            $this->fkFiscalizacaoAutoFiscalizacoes->add($fkFiscalizacaoAutoFiscalizacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoAutoFiscalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\AutoFiscalizacao $fkFiscalizacaoAutoFiscalizacao
     */
    public function removeFkFiscalizacaoAutoFiscalizacoes(\Urbem\CoreBundle\Entity\Fiscalizacao\AutoFiscalizacao $fkFiscalizacaoAutoFiscalizacao)
    {
        $this->fkFiscalizacaoAutoFiscalizacoes->removeElement($fkFiscalizacaoAutoFiscalizacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoAutoFiscalizacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\AutoFiscalizacao
     */
    public function getFkFiscalizacaoAutoFiscalizacoes()
    {
        return $this->fkFiscalizacaoAutoFiscalizacoes;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoAutorizacaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\AutorizacaoDocumento $fkFiscalizacaoAutorizacaoDocumento
     * @return ModeloDocumento
     */
    public function addFkFiscalizacaoAutorizacaoDocumentos(\Urbem\CoreBundle\Entity\Fiscalizacao\AutorizacaoDocumento $fkFiscalizacaoAutorizacaoDocumento)
    {
        if (false === $this->fkFiscalizacaoAutorizacaoDocumentos->contains($fkFiscalizacaoAutorizacaoDocumento)) {
            $fkFiscalizacaoAutorizacaoDocumento->setFkAdministracaoModeloDocumento($this);
            $this->fkFiscalizacaoAutorizacaoDocumentos->add($fkFiscalizacaoAutorizacaoDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoAutorizacaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\AutorizacaoDocumento $fkFiscalizacaoAutorizacaoDocumento
     */
    public function removeFkFiscalizacaoAutorizacaoDocumentos(\Urbem\CoreBundle\Entity\Fiscalizacao\AutorizacaoDocumento $fkFiscalizacaoAutorizacaoDocumento)
    {
        $this->fkFiscalizacaoAutorizacaoDocumentos->removeElement($fkFiscalizacaoAutorizacaoDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoAutorizacaoDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\AutorizacaoDocumento
     */
    public function getFkFiscalizacaoAutorizacaoDocumentos()
    {
        return $this->fkFiscalizacaoAutorizacaoDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoInicioFiscalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacao $fkFiscalizacaoInicioFiscalizacao
     * @return ModeloDocumento
     */
    public function addFkFiscalizacaoInicioFiscalizacoes(\Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacao $fkFiscalizacaoInicioFiscalizacao)
    {
        if (false === $this->fkFiscalizacaoInicioFiscalizacoes->contains($fkFiscalizacaoInicioFiscalizacao)) {
            $fkFiscalizacaoInicioFiscalizacao->setFkAdministracaoModeloDocumento($this);
            $this->fkFiscalizacaoInicioFiscalizacoes->add($fkFiscalizacaoInicioFiscalizacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoInicioFiscalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacao $fkFiscalizacaoInicioFiscalizacao
     */
    public function removeFkFiscalizacaoInicioFiscalizacoes(\Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacao $fkFiscalizacaoInicioFiscalizacao)
    {
        $this->fkFiscalizacaoInicioFiscalizacoes->removeElement($fkFiscalizacaoInicioFiscalizacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoInicioFiscalizacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacao
     */
    public function getFkFiscalizacaoInicioFiscalizacoes()
    {
        return $this->fkFiscalizacaoInicioFiscalizacoes;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoNotificacaoInfracao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoInfracao $fkFiscalizacaoNotificacaoInfracao
     * @return ModeloDocumento
     */
    public function addFkFiscalizacaoNotificacaoInfracoes(\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoInfracao $fkFiscalizacaoNotificacaoInfracao)
    {
        if (false === $this->fkFiscalizacaoNotificacaoInfracoes->contains($fkFiscalizacaoNotificacaoInfracao)) {
            $fkFiscalizacaoNotificacaoInfracao->setFkAdministracaoModeloDocumento($this);
            $this->fkFiscalizacaoNotificacaoInfracoes->add($fkFiscalizacaoNotificacaoInfracao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoNotificacaoInfracao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoInfracao $fkFiscalizacaoNotificacaoInfracao
     */
    public function removeFkFiscalizacaoNotificacaoInfracoes(\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoInfracao $fkFiscalizacaoNotificacaoInfracao)
    {
        $this->fkFiscalizacaoNotificacaoInfracoes->removeElement($fkFiscalizacaoNotificacaoInfracao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoNotificacaoInfracoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoInfracao
     */
    public function getFkFiscalizacaoNotificacaoInfracoes()
    {
        return $this->fkFiscalizacaoNotificacaoInfracoes;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoNotificacaoTermo
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoTermo $fkFiscalizacaoNotificacaoTermo
     * @return ModeloDocumento
     */
    public function addFkFiscalizacaoNotificacaoTermos(\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoTermo $fkFiscalizacaoNotificacaoTermo)
    {
        if (false === $this->fkFiscalizacaoNotificacaoTermos->contains($fkFiscalizacaoNotificacaoTermo)) {
            $fkFiscalizacaoNotificacaoTermo->setFkAdministracaoModeloDocumento($this);
            $this->fkFiscalizacaoNotificacaoTermos->add($fkFiscalizacaoNotificacaoTermo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoNotificacaoTermo
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoTermo $fkFiscalizacaoNotificacaoTermo
     */
    public function removeFkFiscalizacaoNotificacaoTermos(\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoTermo $fkFiscalizacaoNotificacaoTermo)
    {
        $this->fkFiscalizacaoNotificacaoTermos->removeElement($fkFiscalizacaoNotificacaoTermo);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoNotificacaoTermos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoTermo
     */
    public function getFkFiscalizacaoNotificacaoTermos()
    {
        return $this->fkFiscalizacaoNotificacaoTermos;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoPenalidadeDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeDocumento $fkFiscalizacaoPenalidadeDocumento
     * @return ModeloDocumento
     */
    public function addFkFiscalizacaoPenalidadeDocumentos(\Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeDocumento $fkFiscalizacaoPenalidadeDocumento)
    {
        if (false === $this->fkFiscalizacaoPenalidadeDocumentos->contains($fkFiscalizacaoPenalidadeDocumento)) {
            $fkFiscalizacaoPenalidadeDocumento->setFkAdministracaoModeloDocumento($this);
            $this->fkFiscalizacaoPenalidadeDocumentos->add($fkFiscalizacaoPenalidadeDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoPenalidadeDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeDocumento $fkFiscalizacaoPenalidadeDocumento
     */
    public function removeFkFiscalizacaoPenalidadeDocumentos(\Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeDocumento $fkFiscalizacaoPenalidadeDocumento)
    {
        $this->fkFiscalizacaoPenalidadeDocumentos->removeElement($fkFiscalizacaoPenalidadeDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoPenalidadeDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeDocumento
     */
    public function getFkFiscalizacaoPenalidadeDocumentos()
    {
        return $this->fkFiscalizacaoPenalidadeDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoTerminoFiscalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\TerminoFiscalizacao $fkFiscalizacaoTerminoFiscalizacao
     * @return ModeloDocumento
     */
    public function addFkFiscalizacaoTerminoFiscalizacoes(\Urbem\CoreBundle\Entity\Fiscalizacao\TerminoFiscalizacao $fkFiscalizacaoTerminoFiscalizacao)
    {
        if (false === $this->fkFiscalizacaoTerminoFiscalizacoes->contains($fkFiscalizacaoTerminoFiscalizacao)) {
            $fkFiscalizacaoTerminoFiscalizacao->setFkAdministracaoModeloDocumento($this);
            $this->fkFiscalizacaoTerminoFiscalizacoes->add($fkFiscalizacaoTerminoFiscalizacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoTerminoFiscalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\TerminoFiscalizacao $fkFiscalizacaoTerminoFiscalizacao
     */
    public function removeFkFiscalizacaoTerminoFiscalizacoes(\Urbem\CoreBundle\Entity\Fiscalizacao\TerminoFiscalizacao $fkFiscalizacaoTerminoFiscalizacao)
    {
        $this->fkFiscalizacaoTerminoFiscalizacoes->removeElement($fkFiscalizacaoTerminoFiscalizacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoTerminoFiscalizacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\TerminoFiscalizacao
     */
    public function getFkFiscalizacaoTerminoFiscalizacoes()
    {
        return $this->fkFiscalizacaoTerminoFiscalizacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLicencaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaDocumento $fkImobiliarioLicencaDocumento
     * @return ModeloDocumento
     */
    public function addFkImobiliarioLicencaDocumentos(\Urbem\CoreBundle\Entity\Imobiliario\LicencaDocumento $fkImobiliarioLicencaDocumento)
    {
        if (false === $this->fkImobiliarioLicencaDocumentos->contains($fkImobiliarioLicencaDocumento)) {
            $fkImobiliarioLicencaDocumento->setFkAdministracaoModeloDocumento($this);
            $this->fkImobiliarioLicencaDocumentos->add($fkImobiliarioLicencaDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioLicencaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaDocumento $fkImobiliarioLicencaDocumento
     */
    public function removeFkImobiliarioLicencaDocumentos(\Urbem\CoreBundle\Entity\Imobiliario\LicencaDocumento $fkImobiliarioLicencaDocumento)
    {
        $this->fkImobiliarioLicencaDocumentos->removeElement($fkImobiliarioLicencaDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioLicencaDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaDocumento
     */
    public function getFkImobiliarioLicencaDocumentos()
    {
        return $this->fkImobiliarioLicencaDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioTipoLicencaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TipoLicencaDocumento $fkImobiliarioTipoLicencaDocumento
     * @return ModeloDocumento
     */
    public function addFkImobiliarioTipoLicencaDocumentos(\Urbem\CoreBundle\Entity\Imobiliario\TipoLicencaDocumento $fkImobiliarioTipoLicencaDocumento)
    {
        if (false === $this->fkImobiliarioTipoLicencaDocumentos->contains($fkImobiliarioTipoLicencaDocumento)) {
            $fkImobiliarioTipoLicencaDocumento->setFkAdministracaoModeloDocumento($this);
            $this->fkImobiliarioTipoLicencaDocumentos->add($fkImobiliarioTipoLicencaDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioTipoLicencaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TipoLicencaDocumento $fkImobiliarioTipoLicencaDocumento
     */
    public function removeFkImobiliarioTipoLicencaDocumentos(\Urbem\CoreBundle\Entity\Imobiliario\TipoLicencaDocumento $fkImobiliarioTipoLicencaDocumento)
    {
        $this->fkImobiliarioTipoLicencaDocumentos->removeElement($fkImobiliarioTipoLicencaDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioTipoLicencaDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\TipoLicencaDocumento
     */
    public function getFkImobiliarioTipoLicencaDocumentos()
    {
        return $this->fkImobiliarioTipoLicencaDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoAdjudicacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Adjudicacao $fkLicitacaoAdjudicacao
     * @return ModeloDocumento
     */
    public function addFkLicitacaoAdjudicacoes(\Urbem\CoreBundle\Entity\Licitacao\Adjudicacao $fkLicitacaoAdjudicacao)
    {
        if (false === $this->fkLicitacaoAdjudicacoes->contains($fkLicitacaoAdjudicacao)) {
            $fkLicitacaoAdjudicacao->setFkAdministracaoModeloDocumento($this);
            $this->fkLicitacaoAdjudicacoes->add($fkLicitacaoAdjudicacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoAdjudicacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Adjudicacao $fkLicitacaoAdjudicacao
     */
    public function removeFkLicitacaoAdjudicacoes(\Urbem\CoreBundle\Entity\Licitacao\Adjudicacao $fkLicitacaoAdjudicacao)
    {
        $this->fkLicitacaoAdjudicacoes->removeElement($fkLicitacaoAdjudicacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoAdjudicacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Adjudicacao
     */
    public function getFkLicitacaoAdjudicacoes()
    {
        return $this->fkLicitacaoAdjudicacoes;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Convenio $fkLicitacaoConvenio
     * @return ModeloDocumento
     */
    public function addFkLicitacaoConvenios(\Urbem\CoreBundle\Entity\Licitacao\Convenio $fkLicitacaoConvenio)
    {
        if (false === $this->fkLicitacaoConvenios->contains($fkLicitacaoConvenio)) {
            $fkLicitacaoConvenio->setFkAdministracaoModeloDocumento($this);
            $this->fkLicitacaoConvenios->add($fkLicitacaoConvenio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Convenio $fkLicitacaoConvenio
     */
    public function removeFkLicitacaoConvenios(\Urbem\CoreBundle\Entity\Licitacao\Convenio $fkLicitacaoConvenio)
    {
        $this->fkLicitacaoConvenios->removeElement($fkLicitacaoConvenio);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoConvenios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Convenio
     */
    public function getFkLicitacaoConvenios()
    {
        return $this->fkLicitacaoConvenios;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato
     * @return ModeloDocumento
     */
    public function addFkLicitacaoContratos(\Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato)
    {
        if (false === $this->fkLicitacaoContratos->contains($fkLicitacaoContrato)) {
            $fkLicitacaoContrato->setFkAdministracaoModeloDocumento($this);
            $this->fkLicitacaoContratos->add($fkLicitacaoContrato);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato
     */
    public function removeFkLicitacaoContratos(\Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato)
    {
        $this->fkLicitacaoContratos->removeElement($fkLicitacaoContrato);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoContratos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Contrato
     */
    public function getFkLicitacaoContratos()
    {
        return $this->fkLicitacaoContratos;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoParticipanteCertificacaoPenalidade
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacaoPenalidade $fkLicitacaoParticipanteCertificacaoPenalidade
     * @return ModeloDocumento
     */
    public function addFkLicitacaoParticipanteCertificacaoPenalidades(\Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacaoPenalidade $fkLicitacaoParticipanteCertificacaoPenalidade)
    {
        if (false === $this->fkLicitacaoParticipanteCertificacaoPenalidades->contains($fkLicitacaoParticipanteCertificacaoPenalidade)) {
            $fkLicitacaoParticipanteCertificacaoPenalidade->setFkAdministracaoModeloDocumento($this);
            $this->fkLicitacaoParticipanteCertificacaoPenalidades->add($fkLicitacaoParticipanteCertificacaoPenalidade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoParticipanteCertificacaoPenalidade
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacaoPenalidade $fkLicitacaoParticipanteCertificacaoPenalidade
     */
    public function removeFkLicitacaoParticipanteCertificacaoPenalidades(\Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacaoPenalidade $fkLicitacaoParticipanteCertificacaoPenalidade)
    {
        $this->fkLicitacaoParticipanteCertificacaoPenalidades->removeElement($fkLicitacaoParticipanteCertificacaoPenalidade);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoParticipanteCertificacaoPenalidades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacaoPenalidade
     */
    public function getFkLicitacaoParticipanteCertificacaoPenalidades()
    {
        return $this->fkLicitacaoParticipanteCertificacaoPenalidades;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoHomologacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Homologacao $fkLicitacaoHomologacao
     * @return ModeloDocumento
     */
    public function addFkLicitacaoHomologacoes(\Urbem\CoreBundle\Entity\Licitacao\Homologacao $fkLicitacaoHomologacao)
    {
        if (false === $this->fkLicitacaoHomologacoes->contains($fkLicitacaoHomologacao)) {
            $fkLicitacaoHomologacao->setFkAdministracaoModeloDocumento($this);
            $this->fkLicitacaoHomologacoes->add($fkLicitacaoHomologacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoHomologacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Homologacao $fkLicitacaoHomologacao
     */
    public function removeFkLicitacaoHomologacoes(\Urbem\CoreBundle\Entity\Licitacao\Homologacao $fkLicitacaoHomologacao)
    {
        $this->fkLicitacaoHomologacoes->removeElement($fkLicitacaoHomologacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoHomologacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Homologacao
     */
    public function getFkLicitacaoHomologacoes()
    {
        return $this->fkLicitacaoHomologacoes;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoEdital
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Edital $fkLicitacaoEdital
     * @return ModeloDocumento
     */
    public function addFkLicitacaoEditais(\Urbem\CoreBundle\Entity\Licitacao\Edital $fkLicitacaoEdital)
    {
        if (false === $this->fkLicitacaoEditais->contains($fkLicitacaoEdital)) {
            $fkLicitacaoEdital->setFkAdministracaoModeloDocumento($this);
            $this->fkLicitacaoEditais->add($fkLicitacaoEdital);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoEdital
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Edital $fkLicitacaoEdital
     */
    public function removeFkLicitacaoEditais(\Urbem\CoreBundle\Entity\Licitacao\Edital $fkLicitacaoEdital)
    {
        $this->fkLicitacaoEditais->removeElement($fkLicitacaoEdital);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoEditais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Edital
     */
    public function getFkLicitacaoEditais()
    {
        return $this->fkLicitacaoEditais;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoModeloArquivosDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\ModeloArquivosDocumento $fkAdministracaoModeloArquivosDocumento
     * @return ModeloDocumento
     */
    public function addFkAdministracaoModeloArquivosDocumentos(\Urbem\CoreBundle\Entity\Administracao\ModeloArquivosDocumento $fkAdministracaoModeloArquivosDocumento)
    {
        if (false === $this->fkAdministracaoModeloArquivosDocumentos->contains($fkAdministracaoModeloArquivosDocumento)) {
            $fkAdministracaoModeloArquivosDocumento->setFkAdministracaoModeloDocumento($this);
            $this->fkAdministracaoModeloArquivosDocumentos->add($fkAdministracaoModeloArquivosDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoModeloArquivosDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\ModeloArquivosDocumento $fkAdministracaoModeloArquivosDocumento
     */
    public function removeFkAdministracaoModeloArquivosDocumentos(\Urbem\CoreBundle\Entity\Administracao\ModeloArquivosDocumento $fkAdministracaoModeloArquivosDocumento)
    {
        $this->fkAdministracaoModeloArquivosDocumentos->removeElement($fkAdministracaoModeloArquivosDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoModeloArquivosDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\ModeloArquivosDocumento
     */
    public function getFkAdministracaoModeloArquivosDocumentos()
    {
        return $this->fkAdministracaoModeloArquivosDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoBaixaEmissao
     *
     * @param \Urbem\CoreBundle\Entity\Economico\BaixaEmissao $fkEconomicoBaixaEmissao
     * @return ModeloDocumento
     */
    public function addFkEconomicoBaixaEmissoes(\Urbem\CoreBundle\Entity\Economico\BaixaEmissao $fkEconomicoBaixaEmissao)
    {
        if (false === $this->fkEconomicoBaixaEmissoes->contains($fkEconomicoBaixaEmissao)) {
            $fkEconomicoBaixaEmissao->setFkAdministracaoModeloDocumento($this);
            $this->fkEconomicoBaixaEmissoes->add($fkEconomicoBaixaEmissao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoBaixaEmissao
     *
     * @param \Urbem\CoreBundle\Entity\Economico\BaixaEmissao $fkEconomicoBaixaEmissao
     */
    public function removeFkEconomicoBaixaEmissoes(\Urbem\CoreBundle\Entity\Economico\BaixaEmissao $fkEconomicoBaixaEmissao)
    {
        $this->fkEconomicoBaixaEmissoes->removeElement($fkEconomicoBaixaEmissao);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoBaixaEmissoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\BaixaEmissao
     */
    public function getFkEconomicoBaixaEmissoes()
    {
        return $this->fkEconomicoBaixaEmissoes;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoTipoLicencaModeloDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Economico\TipoLicencaModeloDocumento $fkEconomicoTipoLicencaModeloDocumento
     * @return ModeloDocumento
     */
    public function addFkEconomicoTipoLicencaModeloDocumentos(\Urbem\CoreBundle\Entity\Economico\TipoLicencaModeloDocumento $fkEconomicoTipoLicencaModeloDocumento)
    {
        if (false === $this->fkEconomicoTipoLicencaModeloDocumentos->contains($fkEconomicoTipoLicencaModeloDocumento)) {
            $fkEconomicoTipoLicencaModeloDocumento->setFkAdministracaoModeloDocumento($this);
            $this->fkEconomicoTipoLicencaModeloDocumentos->add($fkEconomicoTipoLicencaModeloDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoTipoLicencaModeloDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Economico\TipoLicencaModeloDocumento $fkEconomicoTipoLicencaModeloDocumento
     */
    public function removeFkEconomicoTipoLicencaModeloDocumentos(\Urbem\CoreBundle\Entity\Economico\TipoLicencaModeloDocumento $fkEconomicoTipoLicencaModeloDocumento)
    {
        $this->fkEconomicoTipoLicencaModeloDocumentos->removeElement($fkEconomicoTipoLicencaModeloDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoTipoLicencaModeloDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\TipoLicencaModeloDocumento
     */
    public function getFkEconomicoTipoLicencaModeloDocumentos()
    {
        return $this->fkEconomicoTipoLicencaModeloDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoAutoInfracao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\AutoInfracao $fkFiscalizacaoAutoInfracao
     * @return ModeloDocumento
     */
    public function addFkFiscalizacaoAutoInfracoes(\Urbem\CoreBundle\Entity\Fiscalizacao\AutoInfracao $fkFiscalizacaoAutoInfracao)
    {
        if (false === $this->fkFiscalizacaoAutoInfracoes->contains($fkFiscalizacaoAutoInfracao)) {
            $fkFiscalizacaoAutoInfracao->setFkAdministracaoModeloDocumento($this);
            $this->fkFiscalizacaoAutoInfracoes->add($fkFiscalizacaoAutoInfracao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoAutoInfracao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\AutoInfracao $fkFiscalizacaoAutoInfracao
     */
    public function removeFkFiscalizacaoAutoInfracoes(\Urbem\CoreBundle\Entity\Fiscalizacao\AutoInfracao $fkFiscalizacaoAutoInfracao)
    {
        $this->fkFiscalizacaoAutoInfracoes->removeElement($fkFiscalizacaoAutoInfracao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoAutoInfracoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\AutoInfracao
     */
    public function getFkFiscalizacaoAutoInfracoes()
    {
        return $this->fkFiscalizacaoAutoInfracoes;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoBaixaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\BaixaDocumento $fkFiscalizacaoBaixaDocumento
     * @return ModeloDocumento
     */
    public function addFkFiscalizacaoBaixaDocumentos(\Urbem\CoreBundle\Entity\Fiscalizacao\BaixaDocumento $fkFiscalizacaoBaixaDocumento)
    {
        if (false === $this->fkFiscalizacaoBaixaDocumentos->contains($fkFiscalizacaoBaixaDocumento)) {
            $fkFiscalizacaoBaixaDocumento->setFkAdministracaoModeloDocumento($this);
            $this->fkFiscalizacaoBaixaDocumentos->add($fkFiscalizacaoBaixaDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoBaixaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\BaixaDocumento $fkFiscalizacaoBaixaDocumento
     */
    public function removeFkFiscalizacaoBaixaDocumentos(\Urbem\CoreBundle\Entity\Fiscalizacao\BaixaDocumento $fkFiscalizacaoBaixaDocumento)
    {
        $this->fkFiscalizacaoBaixaDocumentos->removeElement($fkFiscalizacaoBaixaDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoBaixaDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\BaixaDocumento
     */
    public function getFkFiscalizacaoBaixaDocumentos()
    {
        return $this->fkFiscalizacaoBaixaDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoNotificacaoFiscalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoFiscalizacao $fkFiscalizacaoNotificacaoFiscalizacao
     * @return ModeloDocumento
     */
    public function addFkFiscalizacaoNotificacaoFiscalizacoes(\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoFiscalizacao $fkFiscalizacaoNotificacaoFiscalizacao)
    {
        if (false === $this->fkFiscalizacaoNotificacaoFiscalizacoes->contains($fkFiscalizacaoNotificacaoFiscalizacao)) {
            $fkFiscalizacaoNotificacaoFiscalizacao->setFkAdministracaoModeloDocumento($this);
            $this->fkFiscalizacaoNotificacaoFiscalizacoes->add($fkFiscalizacaoNotificacaoFiscalizacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoNotificacaoFiscalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoFiscalizacao $fkFiscalizacaoNotificacaoFiscalizacao
     */
    public function removeFkFiscalizacaoNotificacaoFiscalizacoes(\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoFiscalizacao $fkFiscalizacaoNotificacaoFiscalizacao)
    {
        $this->fkFiscalizacaoNotificacaoFiscalizacoes->removeElement($fkFiscalizacaoNotificacaoFiscalizacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoNotificacaoFiscalizacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoFiscalizacao
     */
    public function getFkFiscalizacaoNotificacaoFiscalizacoes()
    {
        return $this->fkFiscalizacaoNotificacaoFiscalizacoes;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoParticipanteCertificacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacao $fkLicitacaoParticipanteCertificacao
     * @return ModeloDocumento
     */
    public function addFkLicitacaoParticipanteCertificacoes(\Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacao $fkLicitacaoParticipanteCertificacao)
    {
        if (false === $this->fkLicitacaoParticipanteCertificacoes->contains($fkLicitacaoParticipanteCertificacao)) {
            $fkLicitacaoParticipanteCertificacao->setFkAdministracaoModeloDocumento($this);
            $this->fkLicitacaoParticipanteCertificacoes->add($fkLicitacaoParticipanteCertificacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoParticipanteCertificacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacao $fkLicitacaoParticipanteCertificacao
     */
    public function removeFkLicitacaoParticipanteCertificacoes(\Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacao $fkLicitacaoParticipanteCertificacao)
    {
        $this->fkLicitacaoParticipanteCertificacoes->removeElement($fkLicitacaoParticipanteCertificacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoParticipanteCertificacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacao
     */
    public function getFkLicitacaoParticipanteCertificacoes()
    {
        return $this->fkLicitacaoParticipanteCertificacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoTipoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\TipoDocumento $fkAdministracaoTipoDocumento
     * @return ModeloDocumento
     */
    public function setFkAdministracaoTipoDocumento(\Urbem\CoreBundle\Entity\Administracao\TipoDocumento $fkAdministracaoTipoDocumento)
    {
        $this->codTipoDocumento = $fkAdministracaoTipoDocumento->getCodTipoDocumento();
        $this->fkAdministracaoTipoDocumento = $fkAdministracaoTipoDocumento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoTipoDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\TipoDocumento
     */
    public function getFkAdministracaoTipoDocumento()
    {
        return $this->fkAdministracaoTipoDocumento;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->getCodDocumento(), $this->getNomeDocumento());
    }
}
