<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * ImovelCorrespondencia
 */
class ImovelCorrespondencia
{
    /**
     * PK
     * @var integer
     */
    private $inscricaoMunicipal;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codUf;

    /**
     * @var integer
     */
    private $codMunicipio;

    /**
     * @var integer
     */
    private $codBairro;

    /**
     * @var integer
     */
    private $codLogradouro;

    /**
     * @var string
     */
    private $cep;

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
    private $caixaPostal;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Imovel
     */
    private $fkImobiliarioImovel;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwBairroLogradouro
     */
    private $fkSwBairroLogradouro;

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
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set inscricaoMunicipal
     *
     * @param integer $inscricaoMunicipal
     * @return ImovelCorrespondencia
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return ImovelCorrespondencia
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimePK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set codUf
     *
     * @param integer $codUf
     * @return ImovelCorrespondencia
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
     * Set codMunicipio
     *
     * @param integer $codMunicipio
     * @return ImovelCorrespondencia
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
     * Set codBairro
     *
     * @param integer $codBairro
     * @return ImovelCorrespondencia
     */
    public function setCodBairro($codBairro)
    {
        $this->codBairro = $codBairro;
        return $this;
    }

    /**
     * Get codBairro
     *
     * @return integer
     */
    public function getCodBairro()
    {
        return $this->codBairro;
    }

    /**
     * Set codLogradouro
     *
     * @param integer $codLogradouro
     * @return ImovelCorrespondencia
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
     * Set cep
     *
     * @param string $cep
     * @return ImovelCorrespondencia
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
     * Set numero
     *
     * @param string $numero
     * @return ImovelCorrespondencia
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
     * @return ImovelCorrespondencia
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
     * Set caixaPostal
     *
     * @param string $caixaPostal
     * @return ImovelCorrespondencia
     */
    public function setCaixaPostal($caixaPostal = null)
    {
        $this->caixaPostal = $caixaPostal;
        return $this;
    }

    /**
     * Get caixaPostal
     *
     * @return string
     */
    public function getCaixaPostal()
    {
        return $this->caixaPostal;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioImovel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Imovel $fkImobiliarioImovel
     * @return ImovelCorrespondencia
     */
    public function setFkImobiliarioImovel(\Urbem\CoreBundle\Entity\Imobiliario\Imovel $fkImobiliarioImovel)
    {
        $this->inscricaoMunicipal = $fkImobiliarioImovel->getInscricaoMunicipal();
        $this->fkImobiliarioImovel = $fkImobiliarioImovel;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioImovel
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Imovel
     */
    public function getFkImobiliarioImovel()
    {
        return $this->fkImobiliarioImovel;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwBairroLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwBairroLogradouro $fkSwBairroLogradouro
     * @return ImovelCorrespondencia
     */
    public function setFkSwBairroLogradouro(\Urbem\CoreBundle\Entity\SwBairroLogradouro $fkSwBairroLogradouro)
    {
        $this->codUf = $fkSwBairroLogradouro->getCodUf();
        $this->codMunicipio = $fkSwBairroLogradouro->getCodMunicipio();
        $this->codBairro = $fkSwBairroLogradouro->getCodBairro();
        $this->codLogradouro = $fkSwBairroLogradouro->getCodLogradouro();
        $this->fkSwBairroLogradouro = $fkSwBairroLogradouro;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwBairroLogradouro
     *
     * @return \Urbem\CoreBundle\Entity\SwBairroLogradouro
     */
    public function getFkSwBairroLogradouro()
    {
        return $this->fkSwBairroLogradouro;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwLogradouro $fkSwLogradouro
     * @return ImovelCorrespondencia
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
}
