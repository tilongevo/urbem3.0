<?php
 
namespace Urbem\CoreBundle\Entity\Divida;

/**
 * Autoridade
 */
class Autoridade
{
    /**
     * PK
     * @var integer
     */
    private $codAutoridade;

    /**
     * @var integer
     */
    private $codContrato;

    /**
     * @var integer
     */
    private $codNorma;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var string
     */
    private $assinatura;

    /**
     * @var string
     */
    private $tipoAssinatura;

    /**
     * @var integer
     */
    private $tamanhoAssinatura;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Divida\Procurador
     */
    private $fkDividaProcurador;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DividaAtiva
     */
    private $fkDividaDividaAtivas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Contrato
     */
    private $fkPessoalContrato;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    private $fkSwCgmPessoaFisica;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkDividaDividaAtivas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codAutoridade
     *
     * @param integer $codAutoridade
     * @return Autoridade
     */
    public function setCodAutoridade($codAutoridade)
    {
        $this->codAutoridade = $codAutoridade;
        return $this;
    }

    /**
     * Get codAutoridade
     *
     * @return integer
     */
    public function getCodAutoridade()
    {
        return $this->codAutoridade;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return Autoridade
     */
    public function setCodContrato($codContrato)
    {
        $this->codContrato = $codContrato;
        return $this;
    }

    /**
     * Get codContrato
     *
     * @return integer
     */
    public function getCodContrato()
    {
        return $this->codContrato;
    }

    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return Autoridade
     */
    public function setCodNorma($codNorma)
    {
        $this->codNorma = $codNorma;
        return $this;
    }

    /**
     * Get codNorma
     *
     * @return integer
     */
    public function getCodNorma()
    {
        return $this->codNorma;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return Autoridade
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
     * Set assinatura
     *
     * @param string $assinatura
     * @return Autoridade
     */
    public function setAssinatura($assinatura)
    {
        $this->assinatura = $assinatura;
        return $this;
    }

    /**
     * Get assinatura
     *
     * @return string
     */
    public function getAssinatura()
    {
        return $this->assinatura;
    }

    /**
     * Set tipoAssinatura
     *
     * @param string $tipoAssinatura
     * @return Autoridade
     */
    public function setTipoAssinatura($tipoAssinatura)
    {
        $this->tipoAssinatura = $tipoAssinatura;
        return $this;
    }

    /**
     * Get tipoAssinatura
     *
     * @return string
     */
    public function getTipoAssinatura()
    {
        return $this->tipoAssinatura;
    }

    /**
     * Set tamanhoAssinatura
     *
     * @param integer $tamanhoAssinatura
     * @return Autoridade
     */
    public function setTamanhoAssinatura($tamanhoAssinatura)
    {
        $this->tamanhoAssinatura = $tamanhoAssinatura;
        return $this;
    }

    /**
     * Get tamanhoAssinatura
     *
     * @return integer
     */
    public function getTamanhoAssinatura()
    {
        return $this->tamanhoAssinatura;
    }

    /**
     * OneToMany (owning side)
     * Add DividaDividaAtiva
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaAtiva $fkDividaDividaAtiva
     * @return Autoridade
     */
    public function addFkDividaDividaAtivas(\Urbem\CoreBundle\Entity\Divida\DividaAtiva $fkDividaDividaAtiva)
    {
        if (false === $this->fkDividaDividaAtivas->contains($fkDividaDividaAtiva)) {
            $fkDividaDividaAtiva->setFkDividaAutoridade($this);
            $this->fkDividaDividaAtivas->add($fkDividaDividaAtiva);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaDividaAtiva
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaAtiva $fkDividaDividaAtiva
     */
    public function removeFkDividaDividaAtivas(\Urbem\CoreBundle\Entity\Divida\DividaAtiva $fkDividaDividaAtiva)
    {
        $this->fkDividaDividaAtivas->removeElement($fkDividaDividaAtiva);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaDividaAtivas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DividaAtiva
     */
    public function getFkDividaDividaAtivas()
    {
        return $this->fkDividaDividaAtivas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalContrato
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Contrato $fkPessoalContrato
     * @return Autoridade
     */
    public function setFkPessoalContrato(\Urbem\CoreBundle\Entity\Pessoal\Contrato $fkPessoalContrato)
    {
        $this->codContrato = $fkPessoalContrato->getCodContrato();
        $this->fkPessoalContrato = $fkPessoalContrato;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalContrato
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Contrato
     */
    public function getFkPessoalContrato()
    {
        return $this->fkPessoalContrato;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return Autoridade
     */
    public function setFkNormasNorma(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        $this->codNorma = $fkNormasNorma->getCodNorma();
        $this->fkNormasNorma = $fkNormasNorma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNorma()
    {
        return $this->fkNormasNorma;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgmPessoaFisica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica
     * @return Autoridade
     */
    public function setFkSwCgmPessoaFisica(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica)
    {
        $this->numcgm = $fkSwCgmPessoaFisica->getNumcgm();
        $this->fkSwCgmPessoaFisica = $fkSwCgmPessoaFisica;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgmPessoaFisica
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    public function getFkSwCgmPessoaFisica()
    {
        return $this->fkSwCgmPessoaFisica;
    }

    /**
     * OneToOne (inverse side)
     * Set DividaProcurador
     *
     * @param \Urbem\CoreBundle\Entity\Divida\Procurador $fkDividaProcurador
     * @return Autoridade
     */
    public function setFkDividaProcurador(\Urbem\CoreBundle\Entity\Divida\Procurador $fkDividaProcurador)
    {
        $fkDividaProcurador->setFkDividaAutoridade($this);
        $this->fkDividaProcurador = $fkDividaProcurador;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkDividaProcurador
     *
     * @return \Urbem\CoreBundle\Entity\Divida\Procurador
     */
    public function getFkDividaProcurador()
    {
        return $this->fkDividaProcurador;
    }

    /**
     * @return string
     */
    public function getFuncaoCargo()
    {
        return ( !empty($this->getFkPessoalContrato()->getFkPessoalContratoServidor()) ? $this->getFkPessoalContrato()->getFkPessoalContratoServidor()->getFkPessoalCargo()->getDescricao() : '');
    }

    /**
     * @return string
     */
    public function getNomCgm()
    {
        return $this->getFkSwCgmPessoaFisica()->getFkSwCgm()->getNomCgm();
    }

    /**
     * @return string
     */
    public function getTipoAutoridade()
    {
        $retorno = 'Autoridade Competente';
        if (!empty($this->getFkDividaProcurador())) {
            $retorno = 'Procurador Municipal';
        }
        return $retorno;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->codAutoridade;
    }
}
