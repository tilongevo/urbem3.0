<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * DomicilioInformado
 */
class DomicilioInformado
{
    /**
     * PK
     * @var integer
     */
    private $inscricaoEconomica;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codLogradouro;

    /**
     * @var integer
     */
    private $codBairro;

    /**
     * @var integer
     */
    private $codMunicipio;

    /**
     * @var integer
     */
    private $codUf;

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
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoDomicilioInformado
     */
    private $fkEconomicoProcessoDomicilioInformados;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\CadastroEconomico
     */
    private $fkEconomicoCadastroEconomico;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwLogradouro
     */
    private $fkSwLogradouro;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwBairroLogradouro
     */
    private $fkSwBairroLogradouro;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoProcessoDomicilioInformados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return DomicilioInformado
     */
    public function setInscricaoEconomica($inscricaoEconomica)
    {
        $this->inscricaoEconomica = $inscricaoEconomica;
        return $this;
    }

    /**
     * Get inscricaoEconomica
     *
     * @return integer
     */
    public function getInscricaoEconomica()
    {
        return $this->inscricaoEconomica;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return DomicilioInformado
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
     * Set codLogradouro
     *
     * @param integer $codLogradouro
     * @return DomicilioInformado
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
     * Set codBairro
     *
     * @param integer $codBairro
     * @return DomicilioInformado
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
     * Set codMunicipio
     *
     * @param integer $codMunicipio
     * @return DomicilioInformado
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
     * @return DomicilioInformado
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
     * Set cep
     *
     * @param string $cep
     * @return DomicilioInformado
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
     * @return DomicilioInformado
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
     * @return DomicilioInformado
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
     * Set caixaPostal
     *
     * @param string $caixaPostal
     * @return DomicilioInformado
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
     * OneToMany (owning side)
     * Add EconomicoProcessoDomicilioInformado
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoDomicilioInformado $fkEconomicoProcessoDomicilioInformado
     * @return DomicilioInformado
     */
    public function addFkEconomicoProcessoDomicilioInformados(\Urbem\CoreBundle\Entity\Economico\ProcessoDomicilioInformado $fkEconomicoProcessoDomicilioInformado)
    {
        if (false === $this->fkEconomicoProcessoDomicilioInformados->contains($fkEconomicoProcessoDomicilioInformado)) {
            $fkEconomicoProcessoDomicilioInformado->setFkEconomicoDomicilioInformado($this);
            $this->fkEconomicoProcessoDomicilioInformados->add($fkEconomicoProcessoDomicilioInformado);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoProcessoDomicilioInformado
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoDomicilioInformado $fkEconomicoProcessoDomicilioInformado
     */
    public function removeFkEconomicoProcessoDomicilioInformados(\Urbem\CoreBundle\Entity\Economico\ProcessoDomicilioInformado $fkEconomicoProcessoDomicilioInformado)
    {
        $this->fkEconomicoProcessoDomicilioInformados->removeElement($fkEconomicoProcessoDomicilioInformado);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoProcessoDomicilioInformados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoDomicilioInformado
     */
    public function getFkEconomicoProcessoDomicilioInformados()
    {
        return $this->fkEconomicoProcessoDomicilioInformados;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoCadastroEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconomico $fkEconomicoCadastroEconomico
     * @return DomicilioInformado
     */
    public function setFkEconomicoCadastroEconomico(\Urbem\CoreBundle\Entity\Economico\CadastroEconomico $fkEconomicoCadastroEconomico)
    {
        $this->inscricaoEconomica = $fkEconomicoCadastroEconomico->getInscricaoEconomica();
        $this->fkEconomicoCadastroEconomico = $fkEconomicoCadastroEconomico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoCadastroEconomico
     *
     * @return \Urbem\CoreBundle\Entity\Economico\CadastroEconomico
     */
    public function getFkEconomicoCadastroEconomico()
    {
        return $this->fkEconomicoCadastroEconomico;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwLogradouro $fkSwLogradouro
     * @return DomicilioInformado
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
     * ManyToOne (inverse side)
     * Set fkSwBairroLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwBairroLogradouro $fkSwBairroLogradouro
     * @return DomicilioInformado
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
}
