<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwCgaPessoaFisica
 */
class SwCgaPessoaFisica
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
    private $codCategoriaCnh;

    /**
     * @var \DateTime
     */
    private $dtEmissaoRg;

    /**
     * @var string
     */
    private $orgaoEmissor;

    /**
     * @var string
     */
    private $cpf;

    /**
     * @var string
     */
    private $numCnh;

    /**
     * @var \DateTime
     */
    private $dtValidadeCnh;

    /**
     * @var integer
     */
    private $codNacionalidade;

    /**
     * @var integer
     */
    private $codEscolaridade;

    /**
     * @var string
     */
    private $rg;

    /**
     * @var \DateTime
     */
    private $dtNascimento;

    /**
     * @var string
     */
    private $sexo;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\SwCga
     */
    private $fkSwCga;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCategoriaHabilitacao
     */
    private $fkSwCategoriaHabilitacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwPais
     */
    private $fkSwPais;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwEscolaridade
     */
    private $fkSwEscolaridade;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return SwCgaPessoaFisica
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
     * @return SwCgaPessoaFisica
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
     * Set codCategoriaCnh
     *
     * @param integer $codCategoriaCnh
     * @return SwCgaPessoaFisica
     */
    public function setCodCategoriaCnh($codCategoriaCnh)
    {
        $this->codCategoriaCnh = $codCategoriaCnh;
        return $this;
    }

    /**
     * Get codCategoriaCnh
     *
     * @return integer
     */
    public function getCodCategoriaCnh()
    {
        return $this->codCategoriaCnh;
    }

    /**
     * Set dtEmissaoRg
     *
     * @param \DateTime $dtEmissaoRg
     * @return SwCgaPessoaFisica
     */
    public function setDtEmissaoRg(\DateTime $dtEmissaoRg = null)
    {
        $this->dtEmissaoRg = $dtEmissaoRg;
        return $this;
    }

    /**
     * Get dtEmissaoRg
     *
     * @return \DateTime
     */
    public function getDtEmissaoRg()
    {
        return $this->dtEmissaoRg;
    }

    /**
     * Set orgaoEmissor
     *
     * @param string $orgaoEmissor
     * @return SwCgaPessoaFisica
     */
    public function setOrgaoEmissor($orgaoEmissor)
    {
        $this->orgaoEmissor = $orgaoEmissor;
        return $this;
    }

    /**
     * Get orgaoEmissor
     *
     * @return string
     */
    public function getOrgaoEmissor()
    {
        return $this->orgaoEmissor;
    }

    /**
     * Set cpf
     *
     * @param string $cpf
     * @return SwCgaPessoaFisica
     */
    public function setCpf($cpf = null)
    {
        $this->cpf = $cpf;
        return $this;
    }

    /**
     * Get cpf
     *
     * @return string
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * Set numCnh
     *
     * @param string $numCnh
     * @return SwCgaPessoaFisica
     */
    public function setNumCnh($numCnh)
    {
        $this->numCnh = $numCnh;
        return $this;
    }

    /**
     * Get numCnh
     *
     * @return string
     */
    public function getNumCnh()
    {
        return $this->numCnh;
    }

    /**
     * Set dtValidadeCnh
     *
     * @param \DateTime $dtValidadeCnh
     * @return SwCgaPessoaFisica
     */
    public function setDtValidadeCnh(\DateTime $dtValidadeCnh = null)
    {
        $this->dtValidadeCnh = $dtValidadeCnh;
        return $this;
    }

    /**
     * Get dtValidadeCnh
     *
     * @return \DateTime
     */
    public function getDtValidadeCnh()
    {
        return $this->dtValidadeCnh;
    }

    /**
     * Set codNacionalidade
     *
     * @param integer $codNacionalidade
     * @return SwCgaPessoaFisica
     */
    public function setCodNacionalidade($codNacionalidade)
    {
        $this->codNacionalidade = $codNacionalidade;
        return $this;
    }

    /**
     * Get codNacionalidade
     *
     * @return integer
     */
    public function getCodNacionalidade()
    {
        return $this->codNacionalidade;
    }

    /**
     * Set codEscolaridade
     *
     * @param integer $codEscolaridade
     * @return SwCgaPessoaFisica
     */
    public function setCodEscolaridade($codEscolaridade = null)
    {
        $this->codEscolaridade = $codEscolaridade;
        return $this;
    }

    /**
     * Get codEscolaridade
     *
     * @return integer
     */
    public function getCodEscolaridade()
    {
        return $this->codEscolaridade;
    }

    /**
     * Set rg
     *
     * @param string $rg
     * @return SwCgaPessoaFisica
     */
    public function setRg($rg)
    {
        $this->rg = $rg;
        return $this;
    }

    /**
     * Get rg
     *
     * @return string
     */
    public function getRg()
    {
        return $this->rg;
    }

    /**
     * Set dtNascimento
     *
     * @param \DateTime $dtNascimento
     * @return SwCgaPessoaFisica
     */
    public function setDtNascimento(\DateTime $dtNascimento = null)
    {
        $this->dtNascimento = $dtNascimento;
        return $this;
    }

    /**
     * Get dtNascimento
     *
     * @return \DateTime
     */
    public function getDtNascimento()
    {
        return $this->dtNascimento;
    }

    /**
     * Set sexo
     *
     * @param string $sexo
     * @return SwCgaPessoaFisica
     */
    public function setSexo($sexo = null)
    {
        $this->sexo = $sexo;
        return $this;
    }

    /**
     * Get sexo
     *
     * @return string
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCategoriaHabilitacao
     *
     * @param \Urbem\CoreBundle\Entity\SwCategoriaHabilitacao $fkSwCategoriaHabilitacao
     * @return SwCgaPessoaFisica
     */
    public function setFkSwCategoriaHabilitacao(\Urbem\CoreBundle\Entity\SwCategoriaHabilitacao $fkSwCategoriaHabilitacao)
    {
        $this->codCategoriaCnh = $fkSwCategoriaHabilitacao->getCodCategoria();
        $this->fkSwCategoriaHabilitacao = $fkSwCategoriaHabilitacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCategoriaHabilitacao
     *
     * @return \Urbem\CoreBundle\Entity\SwCategoriaHabilitacao
     */
    public function getFkSwCategoriaHabilitacao()
    {
        return $this->fkSwCategoriaHabilitacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwPais
     *
     * @param \Urbem\CoreBundle\Entity\SwPais $fkSwPais
     * @return SwCgaPessoaFisica
     */
    public function setFkSwPais(\Urbem\CoreBundle\Entity\SwPais $fkSwPais)
    {
        $this->codNacionalidade = $fkSwPais->getCodPais();
        $this->fkSwPais = $fkSwPais;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwPais
     *
     * @return \Urbem\CoreBundle\Entity\SwPais
     */
    public function getFkSwPais()
    {
        return $this->fkSwPais;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwEscolaridade
     *
     * @param \Urbem\CoreBundle\Entity\SwEscolaridade $fkSwEscolaridade
     * @return SwCgaPessoaFisica
     */
    public function setFkSwEscolaridade(\Urbem\CoreBundle\Entity\SwEscolaridade $fkSwEscolaridade)
    {
        $this->codEscolaridade = $fkSwEscolaridade->getCodEscolaridade();
        $this->fkSwEscolaridade = $fkSwEscolaridade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwEscolaridade
     *
     * @return \Urbem\CoreBundle\Entity\SwEscolaridade
     */
    public function getFkSwEscolaridade()
    {
        return $this->fkSwEscolaridade;
    }

    /**
     * OneToOne (owning side)
     * Set SwCga
     *
     * @param \Urbem\CoreBundle\Entity\SwCga $fkSwCga
     * @return SwCgaPessoaFisica
     */
    public function setFkSwCga(\Urbem\CoreBundle\Entity\SwCga $fkSwCga)
    {
        $this->numcgm = $fkSwCga->getNumcgm();
        $this->timestamp = $fkSwCga->getTimestamp();
        $this->fkSwCga = $fkSwCga;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkSwCga
     *
     * @return \Urbem\CoreBundle\Entity\SwCga
     */
    public function getFkSwCga()
    {
        return $this->fkSwCga;
    }
}
