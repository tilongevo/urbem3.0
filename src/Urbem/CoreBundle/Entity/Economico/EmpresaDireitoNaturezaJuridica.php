<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * EmpresaDireitoNaturezaJuridica
 */
class EmpresaDireitoNaturezaJuridica
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
    private $codNatureza;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoEmpDireitoNatJuridica
     */
    private $fkEconomicoProcessoEmpDireitoNatJuridicas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaDireito
     */
    private $fkEconomicoCadastroEconomicoEmpresaDireito;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\NaturezaJuridica
     */
    private $fkEconomicoNaturezaJuridica;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoProcessoEmpDireitoNatJuridicas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return EmpresaDireitoNaturezaJuridica
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
     * @return EmpresaDireitoNaturezaJuridica
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
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return EmpresaDireitoNaturezaJuridica
     */
    public function setCodNatureza($codNatureza)
    {
        $this->codNatureza = $codNatureza;
        return $this;
    }

    /**
     * Get codNatureza
     *
     * @return integer
     */
    public function getCodNatureza()
    {
        return $this->codNatureza;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoProcessoEmpDireitoNatJuridica
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoEmpDireitoNatJuridica $fkEconomicoProcessoEmpDireitoNatJuridica
     * @return EmpresaDireitoNaturezaJuridica
     */
    public function addFkEconomicoProcessoEmpDireitoNatJuridicas(\Urbem\CoreBundle\Entity\Economico\ProcessoEmpDireitoNatJuridica $fkEconomicoProcessoEmpDireitoNatJuridica)
    {
        if (false === $this->fkEconomicoProcessoEmpDireitoNatJuridicas->contains($fkEconomicoProcessoEmpDireitoNatJuridica)) {
            $fkEconomicoProcessoEmpDireitoNatJuridica->setFkEconomicoEmpresaDireitoNaturezaJuridica($this);
            $this->fkEconomicoProcessoEmpDireitoNatJuridicas->add($fkEconomicoProcessoEmpDireitoNatJuridica);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoProcessoEmpDireitoNatJuridica
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoEmpDireitoNatJuridica $fkEconomicoProcessoEmpDireitoNatJuridica
     */
    public function removeFkEconomicoProcessoEmpDireitoNatJuridicas(\Urbem\CoreBundle\Entity\Economico\ProcessoEmpDireitoNatJuridica $fkEconomicoProcessoEmpDireitoNatJuridica)
    {
        $this->fkEconomicoProcessoEmpDireitoNatJuridicas->removeElement($fkEconomicoProcessoEmpDireitoNatJuridica);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoProcessoEmpDireitoNatJuridicas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoEmpDireitoNatJuridica
     */
    public function getFkEconomicoProcessoEmpDireitoNatJuridicas()
    {
        return $this->fkEconomicoProcessoEmpDireitoNatJuridicas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoCadastroEconomicoEmpresaDireito
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaDireito $fkEconomicoCadastroEconomicoEmpresaDireito
     * @return EmpresaDireitoNaturezaJuridica
     */
    public function setFkEconomicoCadastroEconomicoEmpresaDireito(\Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaDireito $fkEconomicoCadastroEconomicoEmpresaDireito)
    {
        $this->inscricaoEconomica = $fkEconomicoCadastroEconomicoEmpresaDireito->getInscricaoEconomica();
        $this->fkEconomicoCadastroEconomicoEmpresaDireito = $fkEconomicoCadastroEconomicoEmpresaDireito;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoCadastroEconomicoEmpresaDireito
     *
     * @return \Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaDireito
     */
    public function getFkEconomicoCadastroEconomicoEmpresaDireito()
    {
        return $this->fkEconomicoCadastroEconomicoEmpresaDireito;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoNaturezaJuridica
     *
     * @param \Urbem\CoreBundle\Entity\Economico\NaturezaJuridica $fkEconomicoNaturezaJuridica
     * @return EmpresaDireitoNaturezaJuridica
     */
    public function setFkEconomicoNaturezaJuridica(\Urbem\CoreBundle\Entity\Economico\NaturezaJuridica $fkEconomicoNaturezaJuridica)
    {
        $this->codNatureza = $fkEconomicoNaturezaJuridica->getCodNatureza();
        $this->fkEconomicoNaturezaJuridica = $fkEconomicoNaturezaJuridica;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoNaturezaJuridica
     *
     * @return \Urbem\CoreBundle\Entity\Economico\NaturezaJuridica
     */
    public function getFkEconomicoNaturezaJuridica()
    {
        return $this->fkEconomicoNaturezaJuridica;
    }
}
