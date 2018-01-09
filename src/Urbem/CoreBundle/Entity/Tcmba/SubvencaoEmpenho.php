<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * SubvencaoEmpenho
 */
class SubvencaoEmpenho
{
    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * @var \DateTime
     */
    private $dtInicio;

    /**
     * @var \DateTime
     */
    private $dtTermino;

    /**
     * @var integer
     */
    private $prazoAplicacao;

    /**
     * @var integer
     */
    private $prazoComprovacao;

    /**
     * @var integer
     */
    private $codNormaUtilidade;

    /**
     * @var integer
     */
    private $codNormaValor;

    /**
     * @var integer
     */
    private $codBanco;

    /**
     * @var integer
     */
    private $codAgencia;

    /**
     * @var integer
     */
    private $codContaCorrente;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\ContaCorrente
     */
    private $fkMonetarioContaCorrente;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma1;


    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return SubvencaoEmpenho
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
     * Set dtInicio
     *
     * @param \DateTime $dtInicio
     * @return SubvencaoEmpenho
     */
    public function setDtInicio(\DateTime $dtInicio)
    {
        $this->dtInicio = $dtInicio;
        return $this;
    }

    /**
     * Get dtInicio
     *
     * @return \DateTime
     */
    public function getDtInicio()
    {
        return $this->dtInicio;
    }

    /**
     * Set dtTermino
     *
     * @param \DateTime $dtTermino
     * @return SubvencaoEmpenho
     */
    public function setDtTermino(\DateTime $dtTermino)
    {
        $this->dtTermino = $dtTermino;
        return $this;
    }

    /**
     * Get dtTermino
     *
     * @return \DateTime
     */
    public function getDtTermino()
    {
        return $this->dtTermino;
    }

    /**
     * Set prazoAplicacao
     *
     * @param integer $prazoAplicacao
     * @return SubvencaoEmpenho
     */
    public function setPrazoAplicacao($prazoAplicacao)
    {
        $this->prazoAplicacao = $prazoAplicacao;
        return $this;
    }

    /**
     * Get prazoAplicacao
     *
     * @return integer
     */
    public function getPrazoAplicacao()
    {
        return $this->prazoAplicacao;
    }

    /**
     * Set prazoComprovacao
     *
     * @param integer $prazoComprovacao
     * @return SubvencaoEmpenho
     */
    public function setPrazoComprovacao($prazoComprovacao)
    {
        $this->prazoComprovacao = $prazoComprovacao;
        return $this;
    }

    /**
     * Get prazoComprovacao
     *
     * @return integer
     */
    public function getPrazoComprovacao()
    {
        return $this->prazoComprovacao;
    }

    /**
     * Set codNormaUtilidade
     *
     * @param integer $codNormaUtilidade
     * @return SubvencaoEmpenho
     */
    public function setCodNormaUtilidade($codNormaUtilidade)
    {
        $this->codNormaUtilidade = $codNormaUtilidade;
        return $this;
    }

    /**
     * Get codNormaUtilidade
     *
     * @return integer
     */
    public function getCodNormaUtilidade()
    {
        return $this->codNormaUtilidade;
    }

    /**
     * Set codNormaValor
     *
     * @param integer $codNormaValor
     * @return SubvencaoEmpenho
     */
    public function setCodNormaValor($codNormaValor)
    {
        $this->codNormaValor = $codNormaValor;
        return $this;
    }

    /**
     * Get codNormaValor
     *
     * @return integer
     */
    public function getCodNormaValor()
    {
        return $this->codNormaValor;
    }

    /**
     * Set codBanco
     *
     * @param integer $codBanco
     * @return SubvencaoEmpenho
     */
    public function setCodBanco($codBanco)
    {
        $this->codBanco = $codBanco;
        return $this;
    }

    /**
     * Get codBanco
     *
     * @return integer
     */
    public function getCodBanco()
    {
        return $this->codBanco;
    }

    /**
     * Set codAgencia
     *
     * @param integer $codAgencia
     * @return SubvencaoEmpenho
     */
    public function setCodAgencia($codAgencia)
    {
        $this->codAgencia = $codAgencia;
        return $this;
    }

    /**
     * Get codAgencia
     *
     * @return integer
     */
    public function getCodAgencia()
    {
        return $this->codAgencia;
    }

    /**
     * Set codContaCorrente
     *
     * @param integer $codContaCorrente
     * @return SubvencaoEmpenho
     */
    public function setCodContaCorrente($codContaCorrente)
    {
        $this->codContaCorrente = $codContaCorrente;
        return $this;
    }

    /**
     * Get codContaCorrente
     *
     * @return integer
     */
    public function getCodContaCorrente()
    {
        return $this->codContaCorrente;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return SubvencaoEmpenho
     */
    public function setFkNormasNorma(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        $this->codNormaUtilidade = $fkNormasNorma->getCodNorma();
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
     * Set fkMonetarioContaCorrente
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\ContaCorrente $fkMonetarioContaCorrente
     * @return SubvencaoEmpenho
     */
    public function setFkMonetarioContaCorrente(\Urbem\CoreBundle\Entity\Monetario\ContaCorrente $fkMonetarioContaCorrente)
    {
        $this->codBanco = $fkMonetarioContaCorrente->getCodBanco();
        $this->codAgencia = $fkMonetarioContaCorrente->getCodAgencia();
        $this->codContaCorrente = $fkMonetarioContaCorrente->getCodContaCorrente();
        $this->fkMonetarioContaCorrente = $fkMonetarioContaCorrente;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioContaCorrente
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\ContaCorrente
     */
    public function getFkMonetarioContaCorrente()
    {
        return $this->fkMonetarioContaCorrente;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma1
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma1
     * @return SubvencaoEmpenho
     */
    public function setFkNormasNorma1(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma1)
    {
        $this->codNormaValor = $fkNormasNorma1->getCodNorma();
        $this->fkNormasNorma1 = $fkNormasNorma1;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasNorma1
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNorma1()
    {
        return $this->fkNormasNorma1;
    }

    /**
     * OneToOne (owning side)
     * Set SwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return SubvencaoEmpenho
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
}
