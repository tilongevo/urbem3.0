<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * Licenca
 */
class Licenca
{
    /**
     * PK
     * @var integer
     */
    private $codLicenca;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var \DateTime
     */
    private $dtInicio;

    /**
     * @var \DateTime
     */
    private $dtTermino;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Economico\LicencaObservacao
     */
    private $fkEconomicoLicencaObservacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Economico\LicencaDiversa
     */
    private $fkEconomicoLicencaDiversa;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\EmissaoDocumento
     */
    private $fkEconomicoEmissaoDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\BaixaLicenca
     */
    private $fkEconomicoBaixaLicencas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\LicencaAtividade
     */
    private $fkEconomicoLicencaAtividades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\LicencaDiasSemana
     */
    private $fkEconomicoLicencaDiasSemanas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\LicencaDocumento
     */
    private $fkEconomicoLicencaDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\LicencaEspecial
     */
    private $fkEconomicoLicencaEspeciais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoLicenca
     */
    private $fkEconomicoProcessoLicencas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoEmissaoDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoBaixaLicencas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoLicencaAtividades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoLicencaDiasSemanas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoLicencaDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoLicencaEspeciais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoProcessoLicencas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codLicenca
     *
     * @param integer $codLicenca
     * @return Licenca
     */
    public function setCodLicenca($codLicenca)
    {
        $this->codLicenca = $codLicenca;
        return $this;
    }

    /**
     * Get codLicenca
     *
     * @return integer
     */
    public function getCodLicenca()
    {
        return $this->codLicenca;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Licenca
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set dtInicio
     *
     * @param \DateTime $dtInicio
     * @return Licenca
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
     * @return Licenca
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
     * OneToMany (owning side)
     * Add EconomicoEmissaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Economico\EmissaoDocumento $fkEconomicoEmissaoDocumento
     * @return Licenca
     */
    public function addFkEconomicoEmissaoDocumentos(\Urbem\CoreBundle\Entity\Economico\EmissaoDocumento $fkEconomicoEmissaoDocumento)
    {
        if (false === $this->fkEconomicoEmissaoDocumentos->contains($fkEconomicoEmissaoDocumento)) {
            $fkEconomicoEmissaoDocumento->setFkEconomicoLicenca($this);
            $this->fkEconomicoEmissaoDocumentos->add($fkEconomicoEmissaoDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoEmissaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Economico\EmissaoDocumento $fkEconomicoEmissaoDocumento
     */
    public function removeFkEconomicoEmissaoDocumentos(\Urbem\CoreBundle\Entity\Economico\EmissaoDocumento $fkEconomicoEmissaoDocumento)
    {
        $this->fkEconomicoEmissaoDocumentos->removeElement($fkEconomicoEmissaoDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoEmissaoDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\EmissaoDocumento
     */
    public function getFkEconomicoEmissaoDocumentos()
    {
        return $this->fkEconomicoEmissaoDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoBaixaLicenca
     *
     * @param \Urbem\CoreBundle\Entity\Economico\BaixaLicenca $fkEconomicoBaixaLicenca
     * @return Licenca
     */
    public function addFkEconomicoBaixaLicencas(\Urbem\CoreBundle\Entity\Economico\BaixaLicenca $fkEconomicoBaixaLicenca)
    {
        if (false === $this->fkEconomicoBaixaLicencas->contains($fkEconomicoBaixaLicenca)) {
            $fkEconomicoBaixaLicenca->setFkEconomicoLicenca($this);
            $this->fkEconomicoBaixaLicencas->add($fkEconomicoBaixaLicenca);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoBaixaLicenca
     *
     * @param \Urbem\CoreBundle\Entity\Economico\BaixaLicenca $fkEconomicoBaixaLicenca
     */
    public function removeFkEconomicoBaixaLicencas(\Urbem\CoreBundle\Entity\Economico\BaixaLicenca $fkEconomicoBaixaLicenca)
    {
        $this->fkEconomicoBaixaLicencas->removeElement($fkEconomicoBaixaLicenca);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoBaixaLicencas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\BaixaLicenca
     */
    public function getFkEconomicoBaixaLicencas()
    {
        return $this->fkEconomicoBaixaLicencas;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoLicencaAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\LicencaAtividade $fkEconomicoLicencaAtividade
     * @return Licenca
     */
    public function addFkEconomicoLicencaAtividades(\Urbem\CoreBundle\Entity\Economico\LicencaAtividade $fkEconomicoLicencaAtividade)
    {
        if (false === $this->fkEconomicoLicencaAtividades->contains($fkEconomicoLicencaAtividade)) {
            $fkEconomicoLicencaAtividade->setFkEconomicoLicenca($this);
            $this->fkEconomicoLicencaAtividades->add($fkEconomicoLicencaAtividade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoLicencaAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\LicencaAtividade $fkEconomicoLicencaAtividade
     */
    public function removeFkEconomicoLicencaAtividades(\Urbem\CoreBundle\Entity\Economico\LicencaAtividade $fkEconomicoLicencaAtividade)
    {
        $this->fkEconomicoLicencaAtividades->removeElement($fkEconomicoLicencaAtividade);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoLicencaAtividades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\LicencaAtividade
     */
    public function getFkEconomicoLicencaAtividades()
    {
        return $this->fkEconomicoLicencaAtividades;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoLicencaDiasSemana
     *
     * @param \Urbem\CoreBundle\Entity\Economico\LicencaDiasSemana $fkEconomicoLicencaDiasSemana
     * @return Licenca
     */
    public function addFkEconomicoLicencaDiasSemanas(\Urbem\CoreBundle\Entity\Economico\LicencaDiasSemana $fkEconomicoLicencaDiasSemana)
    {
        if (false === $this->fkEconomicoLicencaDiasSemanas->contains($fkEconomicoLicencaDiasSemana)) {
            $fkEconomicoLicencaDiasSemana->setFkEconomicoLicenca($this);
            $this->fkEconomicoLicencaDiasSemanas->add($fkEconomicoLicencaDiasSemana);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoLicencaDiasSemana
     *
     * @param \Urbem\CoreBundle\Entity\Economico\LicencaDiasSemana $fkEconomicoLicencaDiasSemana
     */
    public function removeFkEconomicoLicencaDiasSemanas(\Urbem\CoreBundle\Entity\Economico\LicencaDiasSemana $fkEconomicoLicencaDiasSemana)
    {
        $this->fkEconomicoLicencaDiasSemanas->removeElement($fkEconomicoLicencaDiasSemana);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoLicencaDiasSemanas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\LicencaDiasSemana
     */
    public function getFkEconomicoLicencaDiasSemanas()
    {
        return $this->fkEconomicoLicencaDiasSemanas;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoLicencaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Economico\LicencaDocumento $fkEconomicoLicencaDocumento
     * @return Licenca
     */
    public function addFkEconomicoLicencaDocumentos(\Urbem\CoreBundle\Entity\Economico\LicencaDocumento $fkEconomicoLicencaDocumento)
    {
        if (false === $this->fkEconomicoLicencaDocumentos->contains($fkEconomicoLicencaDocumento)) {
            $fkEconomicoLicencaDocumento->setFkEconomicoLicenca($this);
            $this->fkEconomicoLicencaDocumentos->add($fkEconomicoLicencaDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoLicencaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Economico\LicencaDocumento $fkEconomicoLicencaDocumento
     */
    public function removeFkEconomicoLicencaDocumentos(\Urbem\CoreBundle\Entity\Economico\LicencaDocumento $fkEconomicoLicencaDocumento)
    {
        $this->fkEconomicoLicencaDocumentos->removeElement($fkEconomicoLicencaDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoLicencaDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\LicencaDocumento
     */
    public function getFkEconomicoLicencaDocumentos()
    {
        return $this->fkEconomicoLicencaDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoLicencaEspecial
     *
     * @param \Urbem\CoreBundle\Entity\Economico\LicencaEspecial $fkEconomicoLicencaEspecial
     * @return Licenca
     */
    public function addFkEconomicoLicencaEspeciais(\Urbem\CoreBundle\Entity\Economico\LicencaEspecial $fkEconomicoLicencaEspecial)
    {
        if (false === $this->fkEconomicoLicencaEspeciais->contains($fkEconomicoLicencaEspecial)) {
            $fkEconomicoLicencaEspecial->setFkEconomicoLicenca($this);
            $this->fkEconomicoLicencaEspeciais->add($fkEconomicoLicencaEspecial);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoLicencaEspecial
     *
     * @param \Urbem\CoreBundle\Entity\Economico\LicencaEspecial $fkEconomicoLicencaEspecial
     */
    public function removeFkEconomicoLicencaEspeciais(\Urbem\CoreBundle\Entity\Economico\LicencaEspecial $fkEconomicoLicencaEspecial)
    {
        $this->fkEconomicoLicencaEspeciais->removeElement($fkEconomicoLicencaEspecial);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoLicencaEspeciais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\LicencaEspecial
     */
    public function getFkEconomicoLicencaEspeciais()
    {
        return $this->fkEconomicoLicencaEspeciais;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoProcessoLicenca
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoLicenca $fkEconomicoProcessoLicenca
     * @return Licenca
     */
    public function addFkEconomicoProcessoLicencas(\Urbem\CoreBundle\Entity\Economico\ProcessoLicenca $fkEconomicoProcessoLicenca)
    {
        if (false === $this->fkEconomicoProcessoLicencas->contains($fkEconomicoProcessoLicenca)) {
            $fkEconomicoProcessoLicenca->setFkEconomicoLicenca($this);
            $this->fkEconomicoProcessoLicencas->add($fkEconomicoProcessoLicenca);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoProcessoLicenca
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoLicenca $fkEconomicoProcessoLicenca
     */
    public function removeFkEconomicoProcessoLicencas(\Urbem\CoreBundle\Entity\Economico\ProcessoLicenca $fkEconomicoProcessoLicenca)
    {
        $this->fkEconomicoProcessoLicencas->removeElement($fkEconomicoProcessoLicenca);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoProcessoLicencas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoLicenca
     */
    public function getFkEconomicoProcessoLicencas()
    {
        return $this->fkEconomicoProcessoLicencas;
    }

    /**
     * OneToOne (inverse side)
     * Set EconomicoLicencaObservacao
     *
     * @param \Urbem\CoreBundle\Entity\Economico\LicencaObservacao $fkEconomicoLicencaObservacao
     * @return Licenca
     */
    public function setFkEconomicoLicencaObservacao(\Urbem\CoreBundle\Entity\Economico\LicencaObservacao $fkEconomicoLicencaObservacao)
    {
        $fkEconomicoLicencaObservacao->setFkEconomicoLicenca($this);
        $this->fkEconomicoLicencaObservacao = $fkEconomicoLicencaObservacao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEconomicoLicencaObservacao
     *
     * @return \Urbem\CoreBundle\Entity\Economico\LicencaObservacao
     */
    public function getFkEconomicoLicencaObservacao()
    {
        return $this->fkEconomicoLicencaObservacao;
    }

    /**
     * OneToOne (inverse side)
     * Set EconomicoLicencaDiversa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\LicencaDiversa $fkEconomicoLicencaDiversa
     * @return Licenca
     */
    public function setFkEconomicoLicencaDiversa(\Urbem\CoreBundle\Entity\Economico\LicencaDiversa $fkEconomicoLicencaDiversa)
    {
        $fkEconomicoLicencaDiversa->setFkEconomicoLicenca($this);
        $this->fkEconomicoLicencaDiversa = $fkEconomicoLicencaDiversa;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEconomicoLicencaDiversa
     *
     * @return \Urbem\CoreBundle\Entity\Economico\LicencaDiversa
     */
    public function getFkEconomicoLicencaDiversa()
    {
        return $this->fkEconomicoLicencaDiversa;
    }
}
