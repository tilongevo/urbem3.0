<?php

namespace Urbem\CoreBundle\Entity\Organograma;

/**
 * VwOrgaoNivelView
 */
class VwOrgaoNivelView
{
    /**
     * PK
     * @var integer
     */
    private $codOrgao;

    /**
     * @var integer
     */
    private $numCgmPf;

    /**
     * @var integer
     */
    private $codCalendar;

    /**
     * @var integer
     */
    private $codNorma;

    /**
     * @var \DateTime
     */
    private $criacao;

    /**
     * @var \DateTime
     */
    private $inativacao;

    /**
     * @var string
     */
    private $siglaOrgao;

    /**
     * @var integer
     */
    private $codOrganograma;

    /**
     * @var string
     */
    private $orgao;

    /**
     * @var string
     */
    private $orgaoReduzido;

    /**
     * @var integer
     */
    private $nivel;


    /**
     * Set codOrgao
     *
     * @param integer $codOrgao
     * @return VwOrgaoNivel
     */
    public function setCodOrgao($codOrgao)
    {
        $this->codOrgao = $codOrgao;
        return $this;
    }

    /**
     * Get codOrgao
     *
     * @return integer
     */
    public function getCodOrgao()
    {
        return $this->codOrgao;
    }

    /**
     * Set numCgmPf
     *
     * @param integer $numCgmPf
     * @return VwOrgaoNivel
     */
    public function setNumCgmPf($numCgmPf = null)
    {
        $this->numCgmPf = $numCgmPf;
        return $this;
    }

    /**
     * Get numCgmPf
     *
     * @return integer
     */
    public function getNumCgmPf()
    {
        return $this->numCgmPf;
    }

    /**
     * Set codCalendar
     *
     * @param integer $codCalendar
     * @return VwOrgaoNivel
     */
    public function setCodCalendar($codCalendar = null)
    {
        $this->codCalendar = $codCalendar;
        return $this;
    }

    /**
     * Get codCalendar
     *
     * @return integer
     */
    public function getCodCalendar()
    {
        return $this->codCalendar;
    }

    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return VwOrgaoNivel
     */
    public function setCodNorma($codNorma = null)
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
     * Set criacao
     *
     * @param \DateTime $criacao
     * @return VwOrgaoNivel
     */
    public function setCriacao(\DateTime $criacao = null)
    {
        $this->criacao = $criacao;
        return $this;
    }

    /**
     * Get criacao
     *
     * @return \DateTime
     */
    public function getCriacao()
    {
        return $this->criacao;
    }

    /**
     * Set inativacao
     *
     * @param \DateTime $inativacao
     * @return VwOrgaoNivel
     */
    public function setInativacao(\DateTime $inativacao = null)
    {
        $this->inativacao = $inativacao;
        return $this;
    }

    /**
     * Get inativacao
     *
     * @return \DateTime
     */
    public function getInativacao()
    {
        return $this->inativacao;
    }

    /**
     * Set siglaOrgao
     *
     * @param string $siglaOrgao
     * @return VwOrgaoNivel
     */
    public function setSiglaOrgao($siglaOrgao = null)
    {
        $this->siglaOrgao = $siglaOrgao;
        return $this;
    }

    /**
     * Get siglaOrgao
     *
     * @return string
     */
    public function getSiglaOrgao()
    {
        return $this->siglaOrgao;
    }

    /**
     * Set codOrganograma
     *
     * @param integer $codOrganograma
     * @return VwOrgaoNivel
     */
    public function setCodOrganograma($codOrganograma = null)
    {
        $this->codOrganograma = $codOrganograma;
        return $this;
    }

    /**
     * Get codOrganograma
     *
     * @return integer
     */
    public function getCodOrganograma()
    {
        return $this->codOrganograma;
    }

    /**
     * Set orgao
     *
     * @param string $orgao
     * @return VwOrgaoNivel
     */
    public function setOrgao($orgao = null)
    {
        $this->orgao = $orgao;
        return $this;
    }

    /**
     * Get orgao
     *
     * @return string
     */
    public function getOrgao()
    {
        return $this->orgao;
    }

    /**
     * Set orgaoReduzido
     *
     * @param string $orgaoReduzido
     * @return VwOrgaoNivel
     */
    public function setOrgaoReduzido($orgaoReduzido = null)
    {
        $this->orgaoReduzido = $orgaoReduzido;
        return $this;
    }

    /**
     * Get orgaoReduzido
     *
     * @return string
     */
    public function getOrgaoReduzido()
    {
        return $this->orgaoReduzido;
    }

    /**
     * Set nivel
     *
     * @param integer $nivel
     * @return VwOrgaoNivel
     */
    public function setNivel($nivel = null)
    {
        $this->nivel = $nivel;
        return $this;
    }

    /**
     * Get nivel
     *
     * @return integer
     */
    public function getNivel()
    {
        return $this->nivel;
    }

    public function getSituacao()
    {
        $inativacao = $this->getInativacao();
        $situacao = false;
        if ($inativacao == null) {
            $situacao = true;
        }
        return $situacao;
    }
}
