<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * VwResponsavelTecnicoView
 */
class VwResponsavelTecnicoView
{
    /**
     * PK
     * @var string
     */
    private $numRegistro;

    /**
     * @var integer
     */
    private $sequencia;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var integer
     */
    private $codMunicipio;

    /**
     * @var integer
     */
    private $codUfCgm;

    /**
     * @var integer
     */
    private $codMunicipioCorresp;

    /**
     * @var integer
     */
    private $codUfCorresp;

    /**
     * @var integer
     */
    private $codResponsavel;

    /**
     * @var string
     */
    private $nomCgm;

    /**
     * @var string
     */
    private $tipoLogradouro;

    /**
     * @var string
     */
    private $logradouro;

    /**
     * @var string
     */
    private $numero;

    /**
     * @var string
     */
    private $complemento;

    /**
     * @var string
     */
    private $bairro;

    /**
     * @var string
     */
    private $cep;

    /**
     * @var string
     */
    private $tipoLogradouroCorresp;

    /**
     * @var string
     */
    private $logradouroCorresp;

    /**
     * @var string
     */
    private $numeroCorresp;

    /**
     * @var string
     */
    private $complementoCorresp;

    /**
     * @var string
     */
    private $bairroCorresp;

    /**
     * @var string
     */
    private $cepCorresp;

    /**
     * @var string
     */
    private $foneResidencial;

    /**
     * @var string
     */
    private $ramalResidencial;

    /**
     * @var string
     */
    private $foneComercial;

    /**
     * @var string
     */
    private $ramalComercial;

    /**
     * @var string
     */
    private $foneCelular;

    /**
     * @var string
     */
    private $eMail;

    /**
     * @var string
     */
    private $eMailAdcional;

    /**
     * @var \DateTime
     */
    private $dtCadastro;

    /**
     * @var integer
     */
    private $codUf;

    /**
     * @var integer
     */
    private $codPais;

    /**
     * @var string
     */
    private $nomUf;

    /**
     * @var string
     */
    private $siglaUf;

    /**
     * @var integer
     */
    private $codProfissao;

    /**
     * @var string
     */
    private $nomProfissao;

    /**
     * @var integer
     */
    private $codConselho;

    /**
     * @var string
     */
    private $nomConselho;

    /**
     * @var string
     */
    private $nomRegistro;


    /**
     * Set numRegistro
     *
     * @param string $numRegistro
     * @return VwResponsavelTecnico
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
     * Set sequencia
     *
     * @param integer $sequencia
     * @return VwResponsavelTecnico
     */
    public function setSequencia($sequencia = null)
    {
        $this->sequencia = $sequencia;
        return $this;
    }

    /**
     * Get sequencia
     *
     * @return integer
     */
    public function getSequencia()
    {
        return $this->sequencia;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return VwResponsavelTecnico
     */
    public function setNumcgm($numcgm = null)
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
     * Set codMunicipio
     *
     * @param integer $codMunicipio
     * @return VwResponsavelTecnico
     */
    public function setCodMunicipio($codMunicipio = null)
    {
        $this->codMunicipio = $codMunicipio;
        return $this;
    }

    /**
     * Get codMunicipio
     *
     * @return integer
     */
    public function getCodMunicipio()
    {
        return $this->codMunicipio;
    }

    /**
     * Set codUfCgm
     *
     * @param integer $codUfCgm
     * @return VwResponsavelTecnico
     */
    public function setCodUfCgm($codUfCgm = null)
    {
        $this->codUfCgm = $codUfCgm;
        return $this;
    }

    /**
     * Get codUfCgm
     *
     * @return integer
     */
    public function getCodUfCgm()
    {
        return $this->codUfCgm;
    }

    /**
     * Set codMunicipioCorresp
     *
     * @param integer $codMunicipioCorresp
     * @return VwResponsavelTecnico
     */
    public function setCodMunicipioCorresp($codMunicipioCorresp = null)
    {
        $this->codMunicipioCorresp = $codMunicipioCorresp;
        return $this;
    }

    /**
     * Get codMunicipioCorresp
     *
     * @return integer
     */
    public function getCodMunicipioCorresp()
    {
        return $this->codMunicipioCorresp;
    }

    /**
     * Set codUfCorresp
     *
     * @param integer $codUfCorresp
     * @return VwResponsavelTecnico
     */
    public function setCodUfCorresp($codUfCorresp = null)
    {
        $this->codUfCorresp = $codUfCorresp;
        return $this;
    }

    /**
     * Get codUfCorresp
     *
     * @return integer
     */
    public function getCodUfCorresp()
    {
        return $this->codUfCorresp;
    }

    /**
     * Set codResponsavel
     *
     * @param integer $codResponsavel
     * @return VwResponsavelTecnico
     */
    public function setCodResponsavel($codResponsavel = null)
    {
        $this->codResponsavel = $codResponsavel;
        return $this;
    }

    /**
     * Get codResponsavel
     *
     * @return integer
     */
    public function getCodResponsavel()
    {
        return $this->codResponsavel;
    }

    /**
     * Set nomCgm
     *
     * @param string $nomCgm
     * @return VwResponsavelTecnico
     */
    public function setNomCgm($nomCgm = null)
    {
        $this->nomCgm = $nomCgm;
        return $this;
    }

    /**
     * Get nomCgm
     *
     * @return string
     */
    public function getNomCgm()
    {
        return $this->nomCgm;
    }

    /**
     * Set tipoLogradouro
     *
     * @param string $tipoLogradouro
     * @return VwResponsavelTecnico
     */
    public function setTipoLogradouro($tipoLogradouro = null)
    {
        $this->tipoLogradouro = $tipoLogradouro;
        return $this;
    }

    /**
     * Get tipoLogradouro
     *
     * @return string
     */
    public function getTipoLogradouro()
    {
        return $this->tipoLogradouro;
    }

    /**
     * Set logradouro
     *
     * @param string $logradouro
     * @return VwResponsavelTecnico
     */
    public function setLogradouro($logradouro = null)
    {
        $this->logradouro = $logradouro;
        return $this;
    }

    /**
     * Get logradouro
     *
     * @return string
     */
    public function getLogradouro()
    {
        return $this->logradouro;
    }

    /**
     * Set numero
     *
     * @param string $numero
     * @return VwResponsavelTecnico
     */
    public function setNumero($numero = null)
    {
        $this->numero = $numero;
        return $this;
    }

    /**
     * Get numero
     *
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set complemento
     *
     * @param string $complemento
     * @return VwResponsavelTecnico
     */
    public function setComplemento($complemento = null)
    {
        $this->complemento = $complemento;
        return $this;
    }

    /**
     * Get complemento
     *
     * @return string
     */
    public function getComplemento()
    {
        return $this->complemento;
    }

    /**
     * Set bairro
     *
     * @param string $bairro
     * @return VwResponsavelTecnico
     */
    public function setBairro($bairro = null)
    {
        $this->bairro = $bairro;
        return $this;
    }

    /**
     * Get bairro
     *
     * @return string
     */
    public function getBairro()
    {
        return $this->bairro;
    }

    /**
     * Set cep
     *
     * @param string $cep
     * @return VwResponsavelTecnico
     */
    public function setCep($cep = null)
    {
        $this->cep = $cep;
        return $this;
    }

    /**
     * Get cep
     *
     * @return string
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * Set tipoLogradouroCorresp
     *
     * @param string $tipoLogradouroCorresp
     * @return VwResponsavelTecnico
     */
    public function setTipoLogradouroCorresp($tipoLogradouroCorresp = null)
    {
        $this->tipoLogradouroCorresp = $tipoLogradouroCorresp;
        return $this;
    }

    /**
     * Get tipoLogradouroCorresp
     *
     * @return string
     */
    public function getTipoLogradouroCorresp()
    {
        return $this->tipoLogradouroCorresp;
    }

    /**
     * Set logradouroCorresp
     *
     * @param string $logradouroCorresp
     * @return VwResponsavelTecnico
     */
    public function setLogradouroCorresp($logradouroCorresp = null)
    {
        $this->logradouroCorresp = $logradouroCorresp;
        return $this;
    }

    /**
     * Get logradouroCorresp
     *
     * @return string
     */
    public function getLogradouroCorresp()
    {
        return $this->logradouroCorresp;
    }

    /**
     * Set numeroCorresp
     *
     * @param string $numeroCorresp
     * @return VwResponsavelTecnico
     */
    public function setNumeroCorresp($numeroCorresp = null)
    {
        $this->numeroCorresp = $numeroCorresp;
        return $this;
    }

    /**
     * Get numeroCorresp
     *
     * @return string
     */
    public function getNumeroCorresp()
    {
        return $this->numeroCorresp;
    }

    /**
     * Set complementoCorresp
     *
     * @param string $complementoCorresp
     * @return VwResponsavelTecnico
     */
    public function setComplementoCorresp($complementoCorresp = null)
    {
        $this->complementoCorresp = $complementoCorresp;
        return $this;
    }

    /**
     * Get complementoCorresp
     *
     * @return string
     */
    public function getComplementoCorresp()
    {
        return $this->complementoCorresp;
    }

    /**
     * Set bairroCorresp
     *
     * @param string $bairroCorresp
     * @return VwResponsavelTecnico
     */
    public function setBairroCorresp($bairroCorresp = null)
    {
        $this->bairroCorresp = $bairroCorresp;
        return $this;
    }

    /**
     * Get bairroCorresp
     *
     * @return string
     */
    public function getBairroCorresp()
    {
        return $this->bairroCorresp;
    }

    /**
     * Set cepCorresp
     *
     * @param string $cepCorresp
     * @return VwResponsavelTecnico
     */
    public function setCepCorresp($cepCorresp = null)
    {
        $this->cepCorresp = $cepCorresp;
        return $this;
    }

    /**
     * Get cepCorresp
     *
     * @return string
     */
    public function getCepCorresp()
    {
        return $this->cepCorresp;
    }

    /**
     * Set foneResidencial
     *
     * @param string $foneResidencial
     * @return VwResponsavelTecnico
     */
    public function setFoneResidencial($foneResidencial = null)
    {
        $this->foneResidencial = $foneResidencial;
        return $this;
    }

    /**
     * Get foneResidencial
     *
     * @return string
     */
    public function getFoneResidencial()
    {
        return $this->foneResidencial;
    }

    /**
     * Set ramalResidencial
     *
     * @param string $ramalResidencial
     * @return VwResponsavelTecnico
     */
    public function setRamalResidencial($ramalResidencial = null)
    {
        $this->ramalResidencial = $ramalResidencial;
        return $this;
    }

    /**
     * Get ramalResidencial
     *
     * @return string
     */
    public function getRamalResidencial()
    {
        return $this->ramalResidencial;
    }

    /**
     * Set foneComercial
     *
     * @param string $foneComercial
     * @return VwResponsavelTecnico
     */
    public function setFoneComercial($foneComercial = null)
    {
        $this->foneComercial = $foneComercial;
        return $this;
    }

    /**
     * Get foneComercial
     *
     * @return string
     */
    public function getFoneComercial()
    {
        return $this->foneComercial;
    }

    /**
     * Set ramalComercial
     *
     * @param string $ramalComercial
     * @return VwResponsavelTecnico
     */
    public function setRamalComercial($ramalComercial = null)
    {
        $this->ramalComercial = $ramalComercial;
        return $this;
    }

    /**
     * Get ramalComercial
     *
     * @return string
     */
    public function getRamalComercial()
    {
        return $this->ramalComercial;
    }

    /**
     * Set foneCelular
     *
     * @param string $foneCelular
     * @return VwResponsavelTecnico
     */
    public function setFoneCelular($foneCelular = null)
    {
        $this->foneCelular = $foneCelular;
        return $this;
    }

    /**
     * Get foneCelular
     *
     * @return string
     */
    public function getFoneCelular()
    {
        return $this->foneCelular;
    }

    /**
     * Set eMail
     *
     * @param string $eMail
     * @return VwResponsavelTecnico
     */
    public function setEMail($eMail = null)
    {
        $this->eMail = $eMail;
        return $this;
    }

    /**
     * Get eMail
     *
     * @return string
     */
    public function getEMail()
    {
        return $this->eMail;
    }

    /**
     * Set eMailAdcional
     *
     * @param string $eMailAdcional
     * @return VwResponsavelTecnico
     */
    public function setEMailAdcional($eMailAdcional = null)
    {
        $this->eMailAdcional = $eMailAdcional;
        return $this;
    }

    /**
     * Get eMailAdcional
     *
     * @return string
     */
    public function getEMailAdcional()
    {
        return $this->eMailAdcional;
    }

    /**
     * Set dtCadastro
     *
     * @param \DateTime $dtCadastro
     * @return VwResponsavelTecnico
     */
    public function setDtCadastro(\DateTime $dtCadastro = null)
    {
        $this->dtCadastro = $dtCadastro;
        return $this;
    }

    /**
     * Get dtCadastro
     *
     * @return \DateTime
     */
    public function getDtCadastro()
    {
        return $this->dtCadastro;
    }

    /**
     * Set codUf
     *
     * @param integer $codUf
     * @return VwResponsavelTecnico
     */
    public function setCodUf($codUf = null)
    {
        $this->codUf = $codUf;
        return $this;
    }

    /**
     * Get codUf
     *
     * @return integer
     */
    public function getCodUf()
    {
        return $this->codUf;
    }

    /**
     * Set codPais
     *
     * @param integer $codPais
     * @return VwResponsavelTecnico
     */
    public function setCodPais($codPais = null)
    {
        $this->codPais = $codPais;
        return $this;
    }

    /**
     * Get codPais
     *
     * @return integer
     */
    public function getCodPais()
    {
        return $this->codPais;
    }

    /**
     * Set nomUf
     *
     * @param string $nomUf
     * @return VwResponsavelTecnico
     */
    public function setNomUf($nomUf = null)
    {
        $this->nomUf = $nomUf;
        return $this;
    }

    /**
     * Get nomUf
     *
     * @return string
     */
    public function getNomUf()
    {
        return $this->nomUf;
    }

    /**
     * Set siglaUf
     *
     * @param string $siglaUf
     * @return VwResponsavelTecnico
     */
    public function setSiglaUf($siglaUf = null)
    {
        $this->siglaUf = $siglaUf;
        return $this;
    }

    /**
     * Get siglaUf
     *
     * @return string
     */
    public function getSiglaUf()
    {
        return $this->siglaUf;
    }

    /**
     * Set codProfissao
     *
     * @param integer $codProfissao
     * @return VwResponsavelTecnico
     */
    public function setCodProfissao($codProfissao = null)
    {
        $this->codProfissao = $codProfissao;
        return $this;
    }

    /**
     * Get codProfissao
     *
     * @return integer
     */
    public function getCodProfissao()
    {
        return $this->codProfissao;
    }

    /**
     * Set nomProfissao
     *
     * @param string $nomProfissao
     * @return VwResponsavelTecnico
     */
    public function setNomProfissao($nomProfissao = null)
    {
        $this->nomProfissao = $nomProfissao;
        return $this;
    }

    /**
     * Get nomProfissao
     *
     * @return string
     */
    public function getNomProfissao()
    {
        return $this->nomProfissao;
    }

    /**
     * Set codConselho
     *
     * @param integer $codConselho
     * @return VwResponsavelTecnico
     */
    public function setCodConselho($codConselho = null)
    {
        $this->codConselho = $codConselho;
        return $this;
    }

    /**
     * Get codConselho
     *
     * @return integer
     */
    public function getCodConselho()
    {
        return $this->codConselho;
    }

    /**
     * Set nomConselho
     *
     * @param string $nomConselho
     * @return VwResponsavelTecnico
     */
    public function setNomConselho($nomConselho = null)
    {
        $this->nomConselho = $nomConselho;
        return $this;
    }

    /**
     * Get nomConselho
     *
     * @return string
     */
    public function getNomConselho()
    {
        return $this->nomConselho;
    }

    /**
     * Set nomRegistro
     *
     * @param string $nomRegistro
     * @return VwResponsavelTecnico
     */
    public function setNomRegistro($nomRegistro = null)
    {
        $this->nomRegistro = $nomRegistro;
        return $this;
    }

    /**
     * Get nomRegistro
     *
     * @return string
     */
    public function getNomRegistro()
    {
        return $this->nomRegistro;
    }
}
