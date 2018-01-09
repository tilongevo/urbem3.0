<?php

namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * Imovel
 */
class Imovel
{
    /**
     * PK
     * @var integer
     */
    private $inscricaoMunicipal;

    /**
     * @var integer
     */
    private $codSublote;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var \DateTime
     */
    private $dtCadastro;

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
    private $cep;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\ImovelConfrontacao
     */
    private $fkImobiliarioImovelConfrontacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\ImovelImobiliaria
     */
    private $fkImobiliarioImovelImobiliaria;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\ImovelCondominio
     */
    private $fkImobiliarioImovelCondominio;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\DesoneradoImovel
     */
    private $fkArrecadacaoDesoneradoImoveis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\DocumentoImovel
     */
    private $fkArrecadacaoDocumentoImoveis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ImovelVVenal
     */
    private $fkArrecadacaoImovelVVenais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DividaImovel
     */
    private $fkDividaDividaImoveis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\DomicilioFiscal
     */
    private $fkEconomicoDomicilioFiscais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\UsoSoloImovel
     */
    private $fkEconomicoUsoSoloImoveis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoImovelValor
     */
    private $fkImobiliarioAtributoImovelValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\BaixaImovel
     */
    private $fkImobiliarioBaixaImoveis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ImovelFoto
     */
    private $fkImobiliarioImovelFotos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ExProprietario
     */
    private $fkImobiliarioExProprietarios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ImovelCorrespondencia
     */
    private $fkImobiliarioImovelCorrespondencias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ImovelProcesso
     */
    private $fkImobiliarioImovelProcessos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\Proprietario
     */
    private $fkImobiliarioProprietarios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaImovel
     */
    private $fkImobiliarioTransferenciaImoveis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalObras
     */
    private $fkFiscalizacaoProcessoFiscalObras;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\UnidadeAutonoma
     */
    private $fkImobiliarioUnidadeAutonomas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaImovel
     */
    private $fkImobiliarioLicencaImoveis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ImovelLote
     */
    private $fkImobiliarioImovelLotes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\MatriculaImovel
     */
    private $fkImobiliarioMatriculaImoveis;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoDesoneradoImoveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoDocumentoImoveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoImovelVVenais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaDividaImoveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoDomicilioFiscais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoUsoSoloImoveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioAtributoImovelValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioBaixaImoveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioImovelFotos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioExProprietarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioImovelCorrespondencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioImovelProcessos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioProprietarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioTransferenciaImoveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoProcessoFiscalObras = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioUnidadeAutonomas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioLicencaImoveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioImovelLotes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioMatriculaImoveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set inscricaoMunicipal
     *
     * @param integer $inscricaoMunicipal
     * @return Imovel
     */
    public function setInscricaoMunicipal($inscricaoMunicipal)
    {
        $this->inscricaoMunicipal = $inscricaoMunicipal;
        return $this;
    }

    /**
     * Get inscricaoMunicipal
     *
     * @return integer
     */
    public function getInscricaoMunicipal()
    {
        return $this->inscricaoMunicipal;
    }

    /**
     * Set codSublote
     *
     * @param integer $codSublote
     * @return Imovel
     */
    public function setCodSublote($codSublote)
    {
        $this->codSublote = $codSublote;
        return $this;
    }

    /**
     * Get codSublote
     *
     * @return integer
     */
    public function getCodSublote()
    {
        return $this->codSublote;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return Imovel
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
     * Set dtCadastro
     *
     * @param \DateTime $dtCadastro
     * @return Imovel
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
     * Set numero
     *
     * @param string $numero
     * @return Imovel
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
     * @return Imovel
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
     * Set cep
     *
     * @param string $cep
     * @return Imovel
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
     * OneToMany (owning side)
     * Add ArrecadacaoDesoneradoImovel
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\DesoneradoImovel $fkArrecadacaoDesoneradoImovel
     * @return Imovel
     */
    public function addFkArrecadacaoDesoneradoImoveis(\Urbem\CoreBundle\Entity\Arrecadacao\DesoneradoImovel $fkArrecadacaoDesoneradoImovel)
    {
        if (false === $this->fkArrecadacaoDesoneradoImoveis->contains($fkArrecadacaoDesoneradoImovel)) {
            $fkArrecadacaoDesoneradoImovel->setFkImobiliarioImovel($this);
            $this->fkArrecadacaoDesoneradoImoveis->add($fkArrecadacaoDesoneradoImovel);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoDesoneradoImovel
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\DesoneradoImovel $fkArrecadacaoDesoneradoImovel
     */
    public function removeFkArrecadacaoDesoneradoImoveis(\Urbem\CoreBundle\Entity\Arrecadacao\DesoneradoImovel $fkArrecadacaoDesoneradoImovel)
    {
        $this->fkArrecadacaoDesoneradoImoveis->removeElement($fkArrecadacaoDesoneradoImovel);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoDesoneradoImoveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\DesoneradoImovel
     */
    public function getFkArrecadacaoDesoneradoImoveis()
    {
        return $this->fkArrecadacaoDesoneradoImoveis;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoDocumentoImovel
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\DocumentoImovel $fkArrecadacaoDocumentoImovel
     * @return Imovel
     */
    public function addFkArrecadacaoDocumentoImoveis(\Urbem\CoreBundle\Entity\Arrecadacao\DocumentoImovel $fkArrecadacaoDocumentoImovel)
    {
        if (false === $this->fkArrecadacaoDocumentoImoveis->contains($fkArrecadacaoDocumentoImovel)) {
            $fkArrecadacaoDocumentoImovel->setFkImobiliarioImovel($this);
            $this->fkArrecadacaoDocumentoImoveis->add($fkArrecadacaoDocumentoImovel);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoDocumentoImovel
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\DocumentoImovel $fkArrecadacaoDocumentoImovel
     */
    public function removeFkArrecadacaoDocumentoImoveis(\Urbem\CoreBundle\Entity\Arrecadacao\DocumentoImovel $fkArrecadacaoDocumentoImovel)
    {
        $this->fkArrecadacaoDocumentoImoveis->removeElement($fkArrecadacaoDocumentoImovel);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoDocumentoImoveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\DocumentoImovel
     */
    public function getFkArrecadacaoDocumentoImoveis()
    {
        return $this->fkArrecadacaoDocumentoImoveis;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoImovelVVenal
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ImovelVVenal $fkArrecadacaoImovelVVenal
     * @return Imovel
     */
    public function addFkArrecadacaoImovelVVenais(\Urbem\CoreBundle\Entity\Arrecadacao\ImovelVVenal $fkArrecadacaoImovelVVenal)
    {
        if (false === $this->fkArrecadacaoImovelVVenais->contains($fkArrecadacaoImovelVVenal)) {
            $fkArrecadacaoImovelVVenal->setFkImobiliarioImovel($this);
            $this->fkArrecadacaoImovelVVenais->add($fkArrecadacaoImovelVVenal);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoImovelVVenal
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ImovelVVenal $fkArrecadacaoImovelVVenal
     */
    public function removeFkArrecadacaoImovelVVenais(\Urbem\CoreBundle\Entity\Arrecadacao\ImovelVVenal $fkArrecadacaoImovelVVenal)
    {
        $this->fkArrecadacaoImovelVVenais->removeElement($fkArrecadacaoImovelVVenal);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoImovelVVenais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ImovelVVenal
     */
    public function getFkArrecadacaoImovelVVenais()
    {
        return $this->fkArrecadacaoImovelVVenais;
    }

    /**
     * OneToMany (owning side)
     * Add DividaDividaImovel
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaImovel $fkDividaDividaImovel
     * @return Imovel
     */
    public function addFkDividaDividaImoveis(\Urbem\CoreBundle\Entity\Divida\DividaImovel $fkDividaDividaImovel)
    {
        if (false === $this->fkDividaDividaImoveis->contains($fkDividaDividaImovel)) {
            $fkDividaDividaImovel->setFkImobiliarioImovel($this);
            $this->fkDividaDividaImoveis->add($fkDividaDividaImovel);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaDividaImovel
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaImovel $fkDividaDividaImovel
     */
    public function removeFkDividaDividaImoveis(\Urbem\CoreBundle\Entity\Divida\DividaImovel $fkDividaDividaImovel)
    {
        $this->fkDividaDividaImoveis->removeElement($fkDividaDividaImovel);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaDividaImoveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DividaImovel
     */
    public function getFkDividaDividaImoveis()
    {
        return $this->fkDividaDividaImoveis;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoDomicilioFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Economico\DomicilioFiscal $fkEconomicoDomicilioFiscal
     * @return Imovel
     */
    public function addFkEconomicoDomicilioFiscais(\Urbem\CoreBundle\Entity\Economico\DomicilioFiscal $fkEconomicoDomicilioFiscal)
    {
        if (false === $this->fkEconomicoDomicilioFiscais->contains($fkEconomicoDomicilioFiscal)) {
            $fkEconomicoDomicilioFiscal->setFkImobiliarioImovel($this);
            $this->fkEconomicoDomicilioFiscais->add($fkEconomicoDomicilioFiscal);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoDomicilioFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Economico\DomicilioFiscal $fkEconomicoDomicilioFiscal
     */
    public function removeFkEconomicoDomicilioFiscais(\Urbem\CoreBundle\Entity\Economico\DomicilioFiscal $fkEconomicoDomicilioFiscal)
    {
        $this->fkEconomicoDomicilioFiscais->removeElement($fkEconomicoDomicilioFiscal);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoDomicilioFiscais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\DomicilioFiscal
     */
    public function getFkEconomicoDomicilioFiscais()
    {
        return $this->fkEconomicoDomicilioFiscais;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoUsoSoloImovel
     *
     * @param \Urbem\CoreBundle\Entity\Economico\UsoSoloImovel $fkEconomicoUsoSoloImovel
     * @return Imovel
     */
    public function addFkEconomicoUsoSoloImoveis(\Urbem\CoreBundle\Entity\Economico\UsoSoloImovel $fkEconomicoUsoSoloImovel)
    {
        if (false === $this->fkEconomicoUsoSoloImoveis->contains($fkEconomicoUsoSoloImovel)) {
            $fkEconomicoUsoSoloImovel->setFkImobiliarioImovel($this);
            $this->fkEconomicoUsoSoloImoveis->add($fkEconomicoUsoSoloImovel);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoUsoSoloImovel
     *
     * @param \Urbem\CoreBundle\Entity\Economico\UsoSoloImovel $fkEconomicoUsoSoloImovel
     */
    public function removeFkEconomicoUsoSoloImoveis(\Urbem\CoreBundle\Entity\Economico\UsoSoloImovel $fkEconomicoUsoSoloImovel)
    {
        $this->fkEconomicoUsoSoloImoveis->removeElement($fkEconomicoUsoSoloImovel);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoUsoSoloImoveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\UsoSoloImovel
     */
    public function getFkEconomicoUsoSoloImoveis()
    {
        return $this->fkEconomicoUsoSoloImoveis;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioAtributoImovelValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoImovelValor $fkImobiliarioAtributoImovelValor
     * @return Imovel
     */
    public function addFkImobiliarioAtributoImovelValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoImovelValor $fkImobiliarioAtributoImovelValor)
    {
        if (false === $this->fkImobiliarioAtributoImovelValores->contains($fkImobiliarioAtributoImovelValor)) {
            $fkImobiliarioAtributoImovelValor->setFkImobiliarioImovel($this);
            $this->fkImobiliarioAtributoImovelValores->add($fkImobiliarioAtributoImovelValor);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioAtributoImovelValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoImovelValor $fkImobiliarioAtributoImovelValor
     */
    public function removeFkImobiliarioAtributoImovelValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoImovelValor $fkImobiliarioAtributoImovelValor)
    {
        $this->fkImobiliarioAtributoImovelValores->removeElement($fkImobiliarioAtributoImovelValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioAtributoImovelValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoImovelValor
     */
    public function getFkImobiliarioAtributoImovelValores()
    {
        return $this->fkImobiliarioAtributoImovelValores;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioBaixaImovel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\BaixaImovel $fkImobiliarioBaixaImovel
     * @return Imovel
     */
    public function addFkImobiliarioBaixaImoveis(\Urbem\CoreBundle\Entity\Imobiliario\BaixaImovel $fkImobiliarioBaixaImovel)
    {
        if (false === $this->fkImobiliarioBaixaImoveis->contains($fkImobiliarioBaixaImovel)) {
            $fkImobiliarioBaixaImovel->setFkImobiliarioImovel($this);
            $this->fkImobiliarioBaixaImoveis->add($fkImobiliarioBaixaImovel);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioBaixaImovel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\BaixaImovel $fkImobiliarioBaixaImovel
     */
    public function removeFkImobiliarioBaixaImoveis(\Urbem\CoreBundle\Entity\Imobiliario\BaixaImovel $fkImobiliarioBaixaImovel)
    {
        $this->fkImobiliarioBaixaImoveis->removeElement($fkImobiliarioBaixaImovel);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioBaixaImoveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\BaixaImovel
     */
    public function getFkImobiliarioBaixaImoveis()
    {
        return $this->fkImobiliarioBaixaImoveis;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioImovelFoto
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ImovelFoto $fkImobiliarioImovelFoto
     * @return Imovel
     */
    public function addFkImobiliarioImovelFotos(\Urbem\CoreBundle\Entity\Imobiliario\ImovelFoto $fkImobiliarioImovelFoto)
    {
        if (false === $this->fkImobiliarioImovelFotos->contains($fkImobiliarioImovelFoto)) {
            $fkImobiliarioImovelFoto->setFkImobiliarioImovel($this);
            $this->fkImobiliarioImovelFotos->add($fkImobiliarioImovelFoto);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioImovelFoto
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ImovelFoto $fkImobiliarioImovelFoto
     */
    public function removeFkImobiliarioImovelFotos(\Urbem\CoreBundle\Entity\Imobiliario\ImovelFoto $fkImobiliarioImovelFoto)
    {
        $this->fkImobiliarioImovelFotos->removeElement($fkImobiliarioImovelFoto);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioImovelFotos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ImovelFoto
     */
    public function getFkImobiliarioImovelFotos()
    {
        return $this->fkImobiliarioImovelFotos;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioExProprietario
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ExProprietario $fkImobiliarioExProprietario
     * @return Imovel
     */
    public function addFkImobiliarioExProprietarios(\Urbem\CoreBundle\Entity\Imobiliario\ExProprietario $fkImobiliarioExProprietario)
    {
        if (false === $this->fkImobiliarioExProprietarios->contains($fkImobiliarioExProprietario)) {
            $fkImobiliarioExProprietario->setFkImobiliarioImovel($this);
            $this->fkImobiliarioExProprietarios->add($fkImobiliarioExProprietario);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioExProprietario
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ExProprietario $fkImobiliarioExProprietario
     */
    public function removeFkImobiliarioExProprietarios(\Urbem\CoreBundle\Entity\Imobiliario\ExProprietario $fkImobiliarioExProprietario)
    {
        $this->fkImobiliarioExProprietarios->removeElement($fkImobiliarioExProprietario);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioExProprietarios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ExProprietario
     */
    public function getFkImobiliarioExProprietarios()
    {
        return $this->fkImobiliarioExProprietarios;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioImovelCorrespondencia
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ImovelCorrespondencia $fkImobiliarioImovelCorrespondencia
     * @return Imovel
     */
    public function addFkImobiliarioImovelCorrespondencias(\Urbem\CoreBundle\Entity\Imobiliario\ImovelCorrespondencia $fkImobiliarioImovelCorrespondencia)
    {
        if (false === $this->fkImobiliarioImovelCorrespondencias->contains($fkImobiliarioImovelCorrespondencia)) {
            $fkImobiliarioImovelCorrespondencia->setFkImobiliarioImovel($this);
            $this->fkImobiliarioImovelCorrespondencias->add($fkImobiliarioImovelCorrespondencia);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioImovelCorrespondencia
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ImovelCorrespondencia $fkImobiliarioImovelCorrespondencia
     */
    public function removeFkImobiliarioImovelCorrespondencias(\Urbem\CoreBundle\Entity\Imobiliario\ImovelCorrespondencia $fkImobiliarioImovelCorrespondencia)
    {
        $this->fkImobiliarioImovelCorrespondencias->removeElement($fkImobiliarioImovelCorrespondencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioImovelCorrespondencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ImovelCorrespondencia
     */
    public function getFkImobiliarioImovelCorrespondencias()
    {
        return $this->fkImobiliarioImovelCorrespondencias;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioImovelProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ImovelProcesso $fkImobiliarioImovelProcesso
     * @return Imovel
     */
    public function addFkImobiliarioImovelProcessos(\Urbem\CoreBundle\Entity\Imobiliario\ImovelProcesso $fkImobiliarioImovelProcesso)
    {
        if (false === $this->fkImobiliarioImovelProcessos->contains($fkImobiliarioImovelProcesso)) {
            $fkImobiliarioImovelProcesso->setFkImobiliarioImovel($this);
            $this->fkImobiliarioImovelProcessos->add($fkImobiliarioImovelProcesso);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioImovelProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ImovelProcesso $fkImobiliarioImovelProcesso
     */
    public function removeFkImobiliarioImovelProcessos(\Urbem\CoreBundle\Entity\Imobiliario\ImovelProcesso $fkImobiliarioImovelProcesso)
    {
        $this->fkImobiliarioImovelProcessos->removeElement($fkImobiliarioImovelProcesso);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioImovelProcessos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ImovelProcesso
     */
    public function getFkImobiliarioImovelProcessos()
    {
        return $this->fkImobiliarioImovelProcessos;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioProprietario
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Proprietario $fkImobiliarioProprietario
     * @return Imovel
     */
    public function addFkImobiliarioProprietarios(\Urbem\CoreBundle\Entity\Imobiliario\Proprietario $fkImobiliarioProprietario)
    {
        if (false === $this->fkImobiliarioProprietarios->contains($fkImobiliarioProprietario)) {
            $fkImobiliarioProprietario->setFkImobiliarioImovel($this);
            $this->fkImobiliarioProprietarios->add($fkImobiliarioProprietario);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioProprietario
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Proprietario $fkImobiliarioProprietario
     */
    public function removeFkImobiliarioProprietarios(\Urbem\CoreBundle\Entity\Imobiliario\Proprietario $fkImobiliarioProprietario)
    {
        $this->fkImobiliarioProprietarios->removeElement($fkImobiliarioProprietario);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioProprietarios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\Proprietario
     */
    public function getFkImobiliarioProprietarios()
    {
        return $this->fkImobiliarioProprietarios;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioTransferenciaImovel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaImovel $fkImobiliarioTransferenciaImovel
     * @return Imovel
     */
    public function addFkImobiliarioTransferenciaImoveis(\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaImovel $fkImobiliarioTransferenciaImovel)
    {
        if (false === $this->fkImobiliarioTransferenciaImoveis->contains($fkImobiliarioTransferenciaImovel)) {
            $fkImobiliarioTransferenciaImovel->setFkImobiliarioImovel($this);
            $this->fkImobiliarioTransferenciaImoveis->add($fkImobiliarioTransferenciaImovel);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioTransferenciaImovel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaImovel $fkImobiliarioTransferenciaImovel
     */
    public function removeFkImobiliarioTransferenciaImoveis(\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaImovel $fkImobiliarioTransferenciaImovel)
    {
        $this->fkImobiliarioTransferenciaImoveis->removeElement($fkImobiliarioTransferenciaImovel);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioTransferenciaImoveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaImovel
     */
    public function getFkImobiliarioTransferenciaImoveis()
    {
        return $this->fkImobiliarioTransferenciaImoveis;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoProcessoFiscalObras
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalObras $fkFiscalizacaoProcessoFiscalObras
     * @return Imovel
     */
    public function addFkFiscalizacaoProcessoFiscalObras(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalObras $fkFiscalizacaoProcessoFiscalObras)
    {
        if (false === $this->fkFiscalizacaoProcessoFiscalObras->contains($fkFiscalizacaoProcessoFiscalObras)) {
            $fkFiscalizacaoProcessoFiscalObras->setFkImobiliarioImovel($this);
            $this->fkFiscalizacaoProcessoFiscalObras->add($fkFiscalizacaoProcessoFiscalObras);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoProcessoFiscalObras
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalObras $fkFiscalizacaoProcessoFiscalObras
     */
    public function removeFkFiscalizacaoProcessoFiscalObras(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalObras $fkFiscalizacaoProcessoFiscalObras)
    {
        $this->fkFiscalizacaoProcessoFiscalObras->removeElement($fkFiscalizacaoProcessoFiscalObras);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoProcessoFiscalObras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalObras
     */
    public function getFkFiscalizacaoProcessoFiscalObras()
    {
        return $this->fkFiscalizacaoProcessoFiscalObras;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioUnidadeAutonoma
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\UnidadeAutonoma $fkImobiliarioUnidadeAutonoma
     * @return Imovel
     */
    public function addFkImobiliarioUnidadeAutonomas(\Urbem\CoreBundle\Entity\Imobiliario\UnidadeAutonoma $fkImobiliarioUnidadeAutonoma)
    {
        if (false === $this->fkImobiliarioUnidadeAutonomas->contains($fkImobiliarioUnidadeAutonoma)) {
            $fkImobiliarioUnidadeAutonoma->setFkImobiliarioImovel($this);
            $this->fkImobiliarioUnidadeAutonomas->add($fkImobiliarioUnidadeAutonoma);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioUnidadeAutonoma
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\UnidadeAutonoma $fkImobiliarioUnidadeAutonoma
     */
    public function removeFkImobiliarioUnidadeAutonomas(\Urbem\CoreBundle\Entity\Imobiliario\UnidadeAutonoma $fkImobiliarioUnidadeAutonoma)
    {
        $this->fkImobiliarioUnidadeAutonomas->removeElement($fkImobiliarioUnidadeAutonoma);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioUnidadeAutonomas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\UnidadeAutonoma
     */
    public function getFkImobiliarioUnidadeAutonomas()
    {
        return $this->fkImobiliarioUnidadeAutonomas;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLicencaImovel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaImovel $fkImobiliarioLicencaImovel
     * @return Imovel
     */
    public function addFkImobiliarioLicencaImoveis(\Urbem\CoreBundle\Entity\Imobiliario\LicencaImovel $fkImobiliarioLicencaImovel)
    {
        if (false === $this->fkImobiliarioLicencaImoveis->contains($fkImobiliarioLicencaImovel)) {
            $fkImobiliarioLicencaImovel->setFkImobiliarioImovel($this);
            $this->fkImobiliarioLicencaImoveis->add($fkImobiliarioLicencaImovel);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioLicencaImovel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaImovel $fkImobiliarioLicencaImovel
     */
    public function removeFkImobiliarioLicencaImoveis(\Urbem\CoreBundle\Entity\Imobiliario\LicencaImovel $fkImobiliarioLicencaImovel)
    {
        $this->fkImobiliarioLicencaImoveis->removeElement($fkImobiliarioLicencaImovel);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioLicencaImoveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaImovel
     */
    public function getFkImobiliarioLicencaImoveis()
    {
        return $this->fkImobiliarioLicencaImoveis;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioImovelLote
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ImovelLote $fkImobiliarioImovelLote
     * @return Imovel
     */
    public function addFkImobiliarioImovelLotes(\Urbem\CoreBundle\Entity\Imobiliario\ImovelLote $fkImobiliarioImovelLote)
    {
        if (false === $this->fkImobiliarioImovelLotes->contains($fkImobiliarioImovelLote)) {
            $fkImobiliarioImovelLote->setFkImobiliarioImovel($this);
            $this->fkImobiliarioImovelLotes->add($fkImobiliarioImovelLote);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioImovelLote
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ImovelLote $fkImobiliarioImovelLote
     */
    public function removeFkImobiliarioImovelLotes(\Urbem\CoreBundle\Entity\Imobiliario\ImovelLote $fkImobiliarioImovelLote)
    {
        $this->fkImobiliarioImovelLotes->removeElement($fkImobiliarioImovelLote);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioImovelLotes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ImovelLote
     */
    public function getFkImobiliarioImovelLotes()
    {
        return $this->fkImobiliarioImovelLotes;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioMatriculaImovel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\MatriculaImovel $fkImobiliarioMatriculaImovel
     * @return Imovel
     */
    public function addFkImobiliarioMatriculaImoveis(\Urbem\CoreBundle\Entity\Imobiliario\MatriculaImovel $fkImobiliarioMatriculaImovel)
    {
        if (false === $this->fkImobiliarioMatriculaImoveis->contains($fkImobiliarioMatriculaImovel)) {
            $fkImobiliarioMatriculaImovel->setFkImobiliarioImovel($this);
            $this->fkImobiliarioMatriculaImoveis->add($fkImobiliarioMatriculaImovel);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioMatriculaImovel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\MatriculaImovel $fkImobiliarioMatriculaImovel
     */
    public function removeFkImobiliarioMatriculaImoveis(\Urbem\CoreBundle\Entity\Imobiliario\MatriculaImovel $fkImobiliarioMatriculaImovel)
    {
        $this->fkImobiliarioMatriculaImoveis->removeElement($fkImobiliarioMatriculaImovel);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioMatriculaImoveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\MatriculaImovel
     */
    public function getFkImobiliarioMatriculaImoveis()
    {
        return $this->fkImobiliarioMatriculaImoveis;
    }

    /**
     * OneToOne (inverse side)
     * Set ImobiliarioImovelConfrontacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ImovelConfrontacao $fkImobiliarioImovelConfrontacao
     * @return Imovel
     */
    public function setFkImobiliarioImovelConfrontacao(\Urbem\CoreBundle\Entity\Imobiliario\ImovelConfrontacao $fkImobiliarioImovelConfrontacao)
    {
        $fkImobiliarioImovelConfrontacao->setFkImobiliarioImovel($this);
        $this->fkImobiliarioImovelConfrontacao = $fkImobiliarioImovelConfrontacao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkImobiliarioImovelConfrontacao
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\ImovelConfrontacao
     */
    public function getFkImobiliarioImovelConfrontacao()
    {
        return $this->fkImobiliarioImovelConfrontacao;
    }

    /**
     * OneToOne (inverse side)
     * Set ImobiliarioImovelImobiliaria
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ImovelImobiliaria $fkImobiliarioImovelImobiliaria
     * @return Imovel
     */
    public function setFkImobiliarioImovelImobiliaria(\Urbem\CoreBundle\Entity\Imobiliario\ImovelImobiliaria $fkImobiliarioImovelImobiliaria)
    {
        $fkImobiliarioImovelImobiliaria->setFkImobiliarioImovel($this);
        $this->fkImobiliarioImovelImobiliaria = $fkImobiliarioImovelImobiliaria;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkImobiliarioImovelImobiliaria
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\ImovelImobiliaria
     */
    public function getFkImobiliarioImovelImobiliaria()
    {
        return $this->fkImobiliarioImovelImobiliaria;
    }

    /**
     * OneToOne (inverse side)
     * Set ImobiliarioImovelCondominio
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ImovelCondominio $fkImobiliarioImovelCondominio
     * @return Imovel
     */
    public function setFkImobiliarioImovelCondominio(\Urbem\CoreBundle\Entity\Imobiliario\ImovelCondominio $fkImobiliarioImovelCondominio)
    {
        $fkImobiliarioImovelCondominio->setFkImobiliarioImovel($this);
        $this->fkImobiliarioImovelCondominio = $fkImobiliarioImovelCondominio;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkImobiliarioImovelCondominio
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\ImovelCondominio
     */
    public function getFkImobiliarioImovelCondominio()
    {
        return $this->fkImobiliarioImovelCondominio;
    }

    /**
     * @return Lote
     */
    public function getLote()
    {
        return $this->fkImobiliarioImovelConfrontacao
            ->getFkImobiliarioConfrontacaoTrecho()
            ->getFkImobiliarioConfrontacao()
            ->getFkImobiliarioLote();
    }

    /**
     * @return Localizacao
     */
    public function getLocalizacao()
    {
        return $this->fkImobiliarioImovelConfrontacao
            ->getFkImobiliarioConfrontacaoTrecho()
            ->getFkImobiliarioConfrontacao()
            ->getFkImobiliarioLote()
            ->getFkImobiliarioLoteLocalizacao()
            ->getFkImobiliarioLocalizacao();
    }

    /**
     * @return string
     */
    public function getMatRegistroImovel()
    {
        return ($this->fkImobiliarioMatriculaImoveis->count())
            ? (string) $this->fkImobiliarioMatriculaImoveis->last()->getMatRegistroImovel()
            : null;
    }

    /**
     * @return string
     */
    public function getZona()
    {
        return ($this->fkImobiliarioMatriculaImoveis->count())
            ? (string) $this->fkImobiliarioMatriculaImoveis->last()->getZona()
            : null;
    }

    /**
     * @return string
     */
    public function getLogradouro()
    {
        return (string) $this->fkImobiliarioImovelConfrontacao
            ->getFkImobiliarioConfrontacaoTrecho()
            ->getFkImobiliarioTrecho()
            ->getFkSwLogradouro();
    }

    /**
     * @return string
     */
    public function getBairro()
    {
        return (string) $this->fkImobiliarioImovelConfrontacao
            ->getFkImobiliarioConfrontacaoTrecho()
            ->getFkImobiliarioConfrontacao()
            ->getFkImobiliarioLote()
            ->getFkImobiliarioLoteBairros()
            ->last()
            ->getFkSwBairro();
    }

    public function getEndereco()
    {
        return sprintf(
            '%s, %s %s - %s',
            $this->getLogradouro(),
            $this->numero,
            $this->complemento,
            $this->getBairro()
        );
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getInscricaoMunicipal();
    }
}
