<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * DiasCadastroEconomico
 */
class DiasCadastroEconomico
{
    /**
     * PK
     * @var integer
     */
    private $codDia;

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
     * @var \DateTime
     */
    private $hrInicio;

    /**
     * @var \DateTime
     */
    private $hrTermino;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoDiasCadEcon
     */
    private $fkEconomicoProcessoDiasCadEcons;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\DiasSemana
     */
    private $fkAdministracaoDiasSemana;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\CadastroEconomico
     */
    private $fkEconomicoCadastroEconomico;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoProcessoDiasCadEcons = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codDia
     *
     * @param integer $codDia
     * @return DiasCadastroEconomico
     */
    public function setCodDia($codDia)
    {
        $this->codDia = $codDia;
        return $this;
    }

    /**
     * Get codDia
     *
     * @return integer
     */
    public function getCodDia()
    {
        return $this->codDia;
    }

    /**
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return DiasCadastroEconomico
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
     * @return DiasCadastroEconomico
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
     * Set hrInicio
     *
     * @param \DateTime $hrInicio
     * @return DiasCadastroEconomico
     */
    public function setHrInicio(\DateTime $hrInicio)
    {
        $this->hrInicio = $hrInicio;
        return $this;
    }

    /**
     * Get hrInicio
     *
     * @return \DateTime
     */
    public function getHrInicio()
    {
        return $this->hrInicio;
    }

    /**
     * Set hrTermino
     *
     * @param \DateTime $hrTermino
     * @return DiasCadastroEconomico
     */
    public function setHrTermino(\DateTime $hrTermino)
    {
        $this->hrTermino = $hrTermino;
        return $this;
    }

    /**
     * Get hrTermino
     *
     * @return \DateTime
     */
    public function getHrTermino()
    {
        return $this->hrTermino;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoProcessoDiasCadEcon
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoDiasCadEcon $fkEconomicoProcessoDiasCadEcon
     * @return DiasCadastroEconomico
     */
    public function addFkEconomicoProcessoDiasCadEcons(\Urbem\CoreBundle\Entity\Economico\ProcessoDiasCadEcon $fkEconomicoProcessoDiasCadEcon)
    {
        if (false === $this->fkEconomicoProcessoDiasCadEcons->contains($fkEconomicoProcessoDiasCadEcon)) {
            $fkEconomicoProcessoDiasCadEcon->setFkEconomicoDiasCadastroEconomico($this);
            $this->fkEconomicoProcessoDiasCadEcons->add($fkEconomicoProcessoDiasCadEcon);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoProcessoDiasCadEcon
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoDiasCadEcon $fkEconomicoProcessoDiasCadEcon
     */
    public function removeFkEconomicoProcessoDiasCadEcons(\Urbem\CoreBundle\Entity\Economico\ProcessoDiasCadEcon $fkEconomicoProcessoDiasCadEcon)
    {
        $this->fkEconomicoProcessoDiasCadEcons->removeElement($fkEconomicoProcessoDiasCadEcon);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoProcessoDiasCadEcons
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoDiasCadEcon
     */
    public function getFkEconomicoProcessoDiasCadEcons()
    {
        return $this->fkEconomicoProcessoDiasCadEcons;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoDiasSemana
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\DiasSemana $fkAdministracaoDiasSemana
     * @return DiasCadastroEconomico
     */
    public function setFkAdministracaoDiasSemana(\Urbem\CoreBundle\Entity\Administracao\DiasSemana $fkAdministracaoDiasSemana)
    {
        $this->codDia = $fkAdministracaoDiasSemana->getCodDia();
        $this->fkAdministracaoDiasSemana = $fkAdministracaoDiasSemana;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoDiasSemana
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\DiasSemana
     */
    public function getFkAdministracaoDiasSemana()
    {
        return $this->fkAdministracaoDiasSemana;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoCadastroEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconomico $fkEconomicoCadastroEconomico
     * @return DiasCadastroEconomico
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
}
