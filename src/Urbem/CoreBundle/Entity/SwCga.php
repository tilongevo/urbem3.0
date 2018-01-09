<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwCga
 */
class SwCga
{
    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codMunicipio;

    /**
     * @var integer
     */
    private $codUf;

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
     * @var integer
     */
    private $codResponsavelAlteracao;

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
    private $codPais;

    /**
     * @var integer
     */
    private $codPaisCorresp;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\SwCgaPessoaFisica
     */
    private $fkSwCgaPessoaFisica;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\SwCgaPessoaJuridica
     */
    private $fkSwCgaPessoaJuridica;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgaAtributoValor
     */
    private $fkSwCgaAtributoValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgaLogradouroCorrespondencia
     */
    private $fkSwCgaLogradouroCorrespondencias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgaLogradouro
     */
    private $fkSwCgaLogradouros;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwMunicipio
     */
    private $fkSwMunicipio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwMunicipio
     */
    private $fkSwMunicipio1;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario1;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkSwCgaAtributoValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwCgaLogradouroCorrespondencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwCgaLogradouros = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->dtCadastro = new \DateTime;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return SwCga
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return SwCga
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
     * Set codMunicipio
     *
     * @param integer $codMunicipio
     * @return SwCga
     */
    public function setCodMunicipio($codMunicipio)
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
     * Set codUf
     *
     * @param integer $codUf
     * @return SwCga
     */
    public function setCodUf($codUf)
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
     * Set codMunicipioCorresp
     *
     * @param integer $codMunicipioCorresp
     * @return SwCga
     */
    public function setCodMunicipioCorresp($codMunicipioCorresp)
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
     * @return SwCga
     */
    public function setCodUfCorresp($codUfCorresp)
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
     * @return SwCga
     */
    public function setCodResponsavel($codResponsavel)
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
     * Set codResponsavelAlteracao
     *
     * @param integer $codResponsavelAlteracao
     * @return SwCga
     */
    public function setCodResponsavelAlteracao($codResponsavelAlteracao)
    {
        $this->codResponsavelAlteracao = $codResponsavelAlteracao;
        return $this;
    }

    /**
     * Get codResponsavelAlteracao
     *
     * @return integer
     */
    public function getCodResponsavelAlteracao()
    {
        return $this->codResponsavelAlteracao;
    }

    /**
     * Set nomCgm
     *
     * @param string $nomCgm
     * @return SwCga
     */
    public function setNomCgm($nomCgm)
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
     * @return SwCga
     */
    public function setTipoLogradouro($tipoLogradouro)
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
     * @return SwCga
     */
    public function setLogradouro($logradouro)
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
     * @return SwCga
     */
    public function setNumero($numero)
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
     * @return SwCga
     */
    public function setComplemento($complemento)
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
     * @return SwCga
     */
    public function setBairro($bairro)
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
     * @return SwCga
     */
    public function setCep($cep)
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
     * @return SwCga
     */
    public function setTipoLogradouroCorresp($tipoLogradouroCorresp)
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
     * @return SwCga
     */
    public function setLogradouroCorresp($logradouroCorresp)
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
     * @return SwCga
     */
    public function setNumeroCorresp($numeroCorresp)
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
     * @return SwCga
     */
    public function setComplementoCorresp($complementoCorresp)
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
     * @return SwCga
     */
    public function setBairroCorresp($bairroCorresp)
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
     * @return SwCga
     */
    public function setCepCorresp($cepCorresp)
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
     * @return SwCga
     */
    public function setFoneResidencial($foneResidencial)
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
     * @return SwCga
     */
    public function setRamalResidencial($ramalResidencial)
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
     * @return SwCga
     */
    public function setFoneComercial($foneComercial)
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
     * @return SwCga
     */
    public function setRamalComercial($ramalComercial)
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
     * @return SwCga
     */
    public function setFoneCelular($foneCelular)
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
     * @return SwCga
     */
    public function setEMail($eMail)
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
     * @return SwCga
     */
    public function setEMailAdcional($eMailAdcional)
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
     * @return SwCga
     */
    public function setDtCadastro(\DateTime $dtCadastro)
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
     * Set codPais
     *
     * @param integer $codPais
     * @return SwCga
     */
    public function setCodPais($codPais)
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
     * Set codPaisCorresp
     *
     * @param integer $codPaisCorresp
     * @return SwCga
     */
    public function setCodPaisCorresp($codPaisCorresp)
    {
        $this->codPaisCorresp = $codPaisCorresp;
        return $this;
    }

    /**
     * Get codPaisCorresp
     *
     * @return integer
     */
    public function getCodPaisCorresp()
    {
        return $this->codPaisCorresp;
    }

    /**
     * OneToMany (owning side)
     * Add SwCgaAtributoValor
     *
     * @param \Urbem\CoreBundle\Entity\SwCgaAtributoValor $fkSwCgaAtributoValor
     * @return SwCga
     */
    public function addFkSwCgaAtributoValores(\Urbem\CoreBundle\Entity\SwCgaAtributoValor $fkSwCgaAtributoValor)
    {
        if (false === $this->fkSwCgaAtributoValores->contains($fkSwCgaAtributoValor)) {
            $fkSwCgaAtributoValor->setFkSwCga($this);
            $this->fkSwCgaAtributoValores->add($fkSwCgaAtributoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwCgaAtributoValor
     *
     * @param \Urbem\CoreBundle\Entity\SwCgaAtributoValor $fkSwCgaAtributoValor
     */
    public function removeFkSwCgaAtributoValores(\Urbem\CoreBundle\Entity\SwCgaAtributoValor $fkSwCgaAtributoValor)
    {
        $this->fkSwCgaAtributoValores->removeElement($fkSwCgaAtributoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwCgaAtributoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgaAtributoValor
     */
    public function getFkSwCgaAtributoValores()
    {
        return $this->fkSwCgaAtributoValores;
    }

    /**
     * OneToMany (owning side)
     * Add SwCgaLogradouroCorrespondencia
     *
     * @param \Urbem\CoreBundle\Entity\SwCgaLogradouroCorrespondencia $fkSwCgaLogradouroCorrespondencia
     * @return SwCga
     */
    public function addFkSwCgaLogradouroCorrespondencias(\Urbem\CoreBundle\Entity\SwCgaLogradouroCorrespondencia $fkSwCgaLogradouroCorrespondencia)
    {
        if (false === $this->fkSwCgaLogradouroCorrespondencias->contains($fkSwCgaLogradouroCorrespondencia)) {
            $fkSwCgaLogradouroCorrespondencia->setFkSwCga($this);
            $this->fkSwCgaLogradouroCorrespondencias->add($fkSwCgaLogradouroCorrespondencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwCgaLogradouroCorrespondencia
     *
     * @param \Urbem\CoreBundle\Entity\SwCgaLogradouroCorrespondencia $fkSwCgaLogradouroCorrespondencia
     */
    public function removeFkSwCgaLogradouroCorrespondencias(\Urbem\CoreBundle\Entity\SwCgaLogradouroCorrespondencia $fkSwCgaLogradouroCorrespondencia)
    {
        $this->fkSwCgaLogradouroCorrespondencias->removeElement($fkSwCgaLogradouroCorrespondencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwCgaLogradouroCorrespondencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgaLogradouroCorrespondencia
     */
    public function getFkSwCgaLogradouroCorrespondencias()
    {
        return $this->fkSwCgaLogradouroCorrespondencias;
    }

    /**
     * OneToMany (owning side)
     * Add SwCgaLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwCgaLogradouro $fkSwCgaLogradouro
     * @return SwCga
     */
    public function addFkSwCgaLogradouros(\Urbem\CoreBundle\Entity\SwCgaLogradouro $fkSwCgaLogradouro)
    {
        if (false === $this->fkSwCgaLogradouros->contains($fkSwCgaLogradouro)) {
            $fkSwCgaLogradouro->setFkSwCga($this);
            $this->fkSwCgaLogradouros->add($fkSwCgaLogradouro);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwCgaLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwCgaLogradouro $fkSwCgaLogradouro
     */
    public function removeFkSwCgaLogradouros(\Urbem\CoreBundle\Entity\SwCgaLogradouro $fkSwCgaLogradouro)
    {
        $this->fkSwCgaLogradouros->removeElement($fkSwCgaLogradouro);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwCgaLogradouros
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgaLogradouro
     */
    public function getFkSwCgaLogradouros()
    {
        return $this->fkSwCgaLogradouros;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return SwCga
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgm = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwMunicipio
     *
     * @param \Urbem\CoreBundle\Entity\SwMunicipio $fkSwMunicipio
     * @return SwCga
     */
    public function setFkSwMunicipio(\Urbem\CoreBundle\Entity\SwMunicipio $fkSwMunicipio)
    {
        $this->codMunicipio = $fkSwMunicipio->getCodMunicipio();
        $this->codUf = $fkSwMunicipio->getCodUf();
        $this->fkSwMunicipio = $fkSwMunicipio;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwMunicipio
     *
     * @return \Urbem\CoreBundle\Entity\SwMunicipio
     */
    public function getFkSwMunicipio()
    {
        return $this->fkSwMunicipio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return SwCga
     */
    public function setFkAdministracaoUsuario(\Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario)
    {
        $this->codResponsavel = $fkAdministracaoUsuario->getNumcgm();
        $this->fkAdministracaoUsuario = $fkAdministracaoUsuario;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoUsuario
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    public function getFkAdministracaoUsuario()
    {
        return $this->fkAdministracaoUsuario;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwMunicipio1
     *
     * @param \Urbem\CoreBundle\Entity\SwMunicipio $fkSwMunicipio1
     * @return SwCga
     */
    public function setFkSwMunicipio1(\Urbem\CoreBundle\Entity\SwMunicipio $fkSwMunicipio1)
    {
        $this->codMunicipioCorresp = $fkSwMunicipio1->getCodMunicipio();
        $this->codUfCorresp = $fkSwMunicipio1->getCodUf();
        $this->fkSwMunicipio1 = $fkSwMunicipio1;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwMunicipio1
     *
     * @return \Urbem\CoreBundle\Entity\SwMunicipio
     */
    public function getFkSwMunicipio1()
    {
        return $this->fkSwMunicipio1;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario1
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario1
     * @return SwCga
     */
    public function setFkAdministracaoUsuario1(\Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario1)
    {
        $this->codResponsavelAlteracao = $fkAdministracaoUsuario1->getNumcgm();
        $this->fkAdministracaoUsuario1 = $fkAdministracaoUsuario1;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoUsuario1
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    public function getFkAdministracaoUsuario1()
    {
        return $this->fkAdministracaoUsuario1;
    }

    /**
     * OneToOne (inverse side)
     * Set SwCgaPessoaFisica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgaPessoaFisica $fkSwCgaPessoaFisica
     * @return SwCga
     */
    public function setFkSwCgaPessoaFisica(\Urbem\CoreBundle\Entity\SwCgaPessoaFisica $fkSwCgaPessoaFisica)
    {
        $fkSwCgaPessoaFisica->setFkSwCga($this);
        $this->fkSwCgaPessoaFisica = $fkSwCgaPessoaFisica;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkSwCgaPessoaFisica
     *
     * @return \Urbem\CoreBundle\Entity\SwCgaPessoaFisica
     */
    public function getFkSwCgaPessoaFisica()
    {
        return $this->fkSwCgaPessoaFisica;
    }

    /**
     * OneToOne (inverse side)
     * Set SwCgaPessoaJuridica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgaPessoaJuridica $fkSwCgaPessoaJuridica
     * @return SwCga
     */
    public function setFkSwCgaPessoaJuridica(\Urbem\CoreBundle\Entity\SwCgaPessoaJuridica $fkSwCgaPessoaJuridica)
    {
        $fkSwCgaPessoaJuridica->setFkSwCga($this);
        $this->fkSwCgaPessoaJuridica = $fkSwCgaPessoaJuridica;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkSwCgaPessoaJuridica
     *
     * @return \Urbem\CoreBundle\Entity\SwCgaPessoaJuridica
     */
    public function getFkSwCgaPessoaJuridica()
    {
        return $this->fkSwCgaPessoaJuridica;
    }
}
