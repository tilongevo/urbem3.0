<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * BaixaCadastroEconomico
 */
class BaixaCadastroEconomico
{
    /**
     * PK
     * @var integer
     */
    private $inscricaoEconomica;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DatePK
     */
    private $dtInicio;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var \DateTime
     */
    private $dtTermino;

    /**
     * @var boolean
     */
    private $deOficio;

    /**
     * @var string
     */
    private $motivo;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Economico\BaixaEmissao
     */
    private $fkEconomicoBaixaEmissao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoBaixaCadEconomico
     */
    private $fkEconomicoProcessoBaixaCadEconomicos;

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
        $this->fkEconomicoProcessoBaixaCadEconomicos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dtInicio = new \Urbem\CoreBundle\Helper\DatePK;
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return BaixaCadastroEconomico
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
     * Set dtInicio
     *
     * @param \Urbem\CoreBundle\Helper\DatePK $dtInicio
     * @return BaixaCadastroEconomico
     */
    public function setDtInicio(\Urbem\CoreBundle\Helper\DatePK $dtInicio)
    {
        $this->dtInicio = $dtInicio;
        return $this;
    }

    /**
     * Get dtInicio
     *
     * @return \Urbem\CoreBundle\Helper\DatePK
     */
    public function getDtInicio()
    {
        return $this->dtInicio;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return BaixaCadastroEconomico
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
     * Set dtTermino
     *
     * @param \DateTime $dtTermino
     * @return BaixaCadastroEconomico
     */
    public function setDtTermino(\DateTime $dtTermino = null)
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
     * Set deOficio
     *
     * @param boolean $deOficio
     * @return BaixaCadastroEconomico
     */
    public function setDeOficio($deOficio)
    {
        $this->deOficio = $deOficio;
        return $this;
    }

    /**
     * Get deOficio
     *
     * @return boolean
     */
    public function getDeOficio()
    {
        return $this->deOficio;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     * @return BaixaCadastroEconomico
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;
        return $this;
    }

    /**
     * Get motivo
     *
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return BaixaCadastroEconomico
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoProcessoBaixaCadEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoBaixaCadEconomico $fkEconomicoProcessoBaixaCadEconomico
     * @return BaixaCadastroEconomico
     */
    public function addFkEconomicoProcessoBaixaCadEconomicos(\Urbem\CoreBundle\Entity\Economico\ProcessoBaixaCadEconomico $fkEconomicoProcessoBaixaCadEconomico)
    {
        if (false === $this->fkEconomicoProcessoBaixaCadEconomicos->contains($fkEconomicoProcessoBaixaCadEconomico)) {
            $fkEconomicoProcessoBaixaCadEconomico->setFkEconomicoBaixaCadastroEconomico($this);
            $this->fkEconomicoProcessoBaixaCadEconomicos->add($fkEconomicoProcessoBaixaCadEconomico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoProcessoBaixaCadEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoBaixaCadEconomico $fkEconomicoProcessoBaixaCadEconomico
     */
    public function removeFkEconomicoProcessoBaixaCadEconomicos(\Urbem\CoreBundle\Entity\Economico\ProcessoBaixaCadEconomico $fkEconomicoProcessoBaixaCadEconomico)
    {
        $this->fkEconomicoProcessoBaixaCadEconomicos->removeElement($fkEconomicoProcessoBaixaCadEconomico);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoProcessoBaixaCadEconomicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoBaixaCadEconomico
     */
    public function getFkEconomicoProcessoBaixaCadEconomicos()
    {
        return $this->fkEconomicoProcessoBaixaCadEconomicos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoCadastroEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconomico $fkEconomicoCadastroEconomico
     * @return BaixaCadastroEconomico
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
     * OneToOne (inverse side)
     * Set EconomicoBaixaEmissao
     *
     * @param \Urbem\CoreBundle\Entity\Economico\BaixaEmissao $fkEconomicoBaixaEmissao
     * @return BaixaCadastroEconomico
     */
    public function setFkEconomicoBaixaEmissao(\Urbem\CoreBundle\Entity\Economico\BaixaEmissao $fkEconomicoBaixaEmissao)
    {
        $fkEconomicoBaixaEmissao->setFkEconomicoBaixaCadastroEconomico($this);
        $this->fkEconomicoBaixaEmissao = $fkEconomicoBaixaEmissao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEconomicoBaixaEmissao
     *
     * @return \Urbem\CoreBundle\Entity\Economico\BaixaEmissao
     */
    public function getFkEconomicoBaixaEmissao()
    {
        return $this->fkEconomicoBaixaEmissao;
    }
}
