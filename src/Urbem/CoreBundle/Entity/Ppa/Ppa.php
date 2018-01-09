<?php
 
namespace Urbem\CoreBundle\Entity\Ppa;

/**
 * Ppa
 */
class Ppa
{
    /**
     * PK
     * @var integer
     */
    private $codPpa;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var string
     */
    private $anoInicio;

    /**
     * @var string
     */
    private $anoFinal;

    /**
     * @var integer
     */
    private $valorTotalPpa;

    /**
     * @var boolean
     */
    private $destinacaoRecurso = false;

    /**
     * @var boolean
     */
    private $importado = false;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ppa\PpaPrecisao
     */
    private $fkPpaPpaPrecisao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ldo\Ldo
     */
    private $fkLdoLdos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\MacroObjetivo
     */
    private $fkPpaMacroObjetivos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\PpaPublicacao
     */
    private $fkPpaPpaPublicacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\PpaEstimativaOrcamentariaBase
     */
    private $fkPpaPpaEstimativaOrcamentariaBases;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkLdoLdos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPpaMacroObjetivos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPpaPpaPublicacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPpaPpaEstimativaOrcamentariaBases = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \DateTime;
    }

    /**
     * Set codPpa
     *
     * @param integer $codPpa
     * @return Ppa
     */
    public function setCodPpa($codPpa)
    {
        $this->codPpa = $codPpa;
        return $this;
    }

    /**
     * Get codPpa
     *
     * @return integer
     */
    public function getCodPpa()
    {
        return $this->codPpa;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return Ppa
     */
    public function setTimestamp(\DateTime $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set anoInicio
     *
     * @param string $anoInicio
     * @return Ppa
     */
    public function setAnoInicio($anoInicio)
    {
        $this->anoInicio = $anoInicio;
        return $this;
    }

    /**
     * Get anoInicio
     *
     * @return string
     */
    public function getAnoInicio()
    {
        return $this->anoInicio;
    }

    /**
     * Set anoFinal
     *
     * @param string $anoFinal
     * @return Ppa
     */
    public function setAnoFinal($anoFinal)
    {
        $this->anoFinal = $anoFinal;
        return $this;
    }

    /**
     * Get anoFinal
     *
     * @return string
     */
    public function getAnoFinal()
    {
        return $this->anoFinal;
    }

    /**
     * Set valorTotalPpa
     *
     * @param integer $valorTotalPpa
     * @return Ppa
     */
    public function setValorTotalPpa($valorTotalPpa)
    {
        $this->valorTotalPpa = $valorTotalPpa;
        return $this;
    }

    /**
     * Get valorTotalPpa
     *
     * @return integer
     */
    public function getValorTotalPpa()
    {
        return $this->valorTotalPpa;
    }

    /**
     * Set destinacaoRecurso
     *
     * @param boolean $destinacaoRecurso
     * @return Ppa
     */
    public function setDestinacaoRecurso($destinacaoRecurso)
    {
        $this->destinacaoRecurso = $destinacaoRecurso;
        return $this;
    }

    /**
     * Get destinacaoRecurso
     *
     * @return boolean
     */
    public function getDestinacaoRecurso()
    {
        return $this->destinacaoRecurso;
    }

    /**
     * Set importado
     *
     * @param boolean $importado
     * @return Ppa
     */
    public function setImportado($importado)
    {
        $this->importado = $importado;
        return $this;
    }

    /**
     * Get importado
     *
     * @return boolean
     */
    public function getImportado()
    {
        return $this->importado;
    }

    /**
     * OneToMany (owning side)
     * Add LdoLdo
     *
     * @param \Urbem\CoreBundle\Entity\Ldo\Ldo $fkLdoLdo
     * @return Ppa
     */
    public function addFkLdoLdos(\Urbem\CoreBundle\Entity\Ldo\Ldo $fkLdoLdo)
    {
        if (false === $this->fkLdoLdos->contains($fkLdoLdo)) {
            $fkLdoLdo->setFkPpaPpa($this);
            $this->fkLdoLdos->add($fkLdoLdo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LdoLdo
     *
     * @param \Urbem\CoreBundle\Entity\Ldo\Ldo $fkLdoLdo
     */
    public function removeFkLdoLdos(\Urbem\CoreBundle\Entity\Ldo\Ldo $fkLdoLdo)
    {
        $this->fkLdoLdos->removeElement($fkLdoLdo);
    }

    /**
     * OneToMany (owning side)
     * Get fkLdoLdos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ldo\Ldo
     */
    public function getFkLdoLdos()
    {
        return $this->fkLdoLdos;
    }

    /**
     * OneToMany (owning side)
     * Add PpaMacroObjetivo
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\MacroObjetivo $fkPpaMacroObjetivo
     * @return Ppa
     */
    public function addFkPpaMacroObjetivos(\Urbem\CoreBundle\Entity\Ppa\MacroObjetivo $fkPpaMacroObjetivo)
    {
        if (false === $this->fkPpaMacroObjetivos->contains($fkPpaMacroObjetivo)) {
            $fkPpaMacroObjetivo->setFkPpaPpa($this);
            $this->fkPpaMacroObjetivos->add($fkPpaMacroObjetivo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PpaMacroObjetivo
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\MacroObjetivo $fkPpaMacroObjetivo
     */
    public function removeFkPpaMacroObjetivos(\Urbem\CoreBundle\Entity\Ppa\MacroObjetivo $fkPpaMacroObjetivo)
    {
        $this->fkPpaMacroObjetivos->removeElement($fkPpaMacroObjetivo);
    }

    /**
     * OneToMany (owning side)
     * Get fkPpaMacroObjetivos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\MacroObjetivo
     */
    public function getFkPpaMacroObjetivos()
    {
        return $this->fkPpaMacroObjetivos;
    }

    /**
     * OneToMany (owning side)
     * Add PpaPpaPublicacao
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\PpaPublicacao $fkPpaPpaPublicacao
     * @return Ppa
     */
    public function addFkPpaPpaPublicacoes(\Urbem\CoreBundle\Entity\Ppa\PpaPublicacao $fkPpaPpaPublicacao)
    {
        if (false === $this->fkPpaPpaPublicacoes->contains($fkPpaPpaPublicacao)) {
            $fkPpaPpaPublicacao->setFkPpaPpa($this);
            $this->fkPpaPpaPublicacoes->add($fkPpaPpaPublicacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PpaPpaPublicacao
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\PpaPublicacao $fkPpaPpaPublicacao
     */
    public function removeFkPpaPpaPublicacoes(\Urbem\CoreBundle\Entity\Ppa\PpaPublicacao $fkPpaPpaPublicacao)
    {
        $this->fkPpaPpaPublicacoes->removeElement($fkPpaPpaPublicacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPpaPpaPublicacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\PpaPublicacao
     */
    public function getFkPpaPpaPublicacoes()
    {
        return $this->fkPpaPpaPublicacoes;
    }

    /**
     * OneToMany (owning side)
     * Add PpaPpaEstimativaOrcamentariaBase
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\PpaEstimativaOrcamentariaBase $fkPpaPpaEstimativaOrcamentariaBase
     * @return Ppa
     */
    public function addFkPpaPpaEstimativaOrcamentariaBases(\Urbem\CoreBundle\Entity\Ppa\PpaEstimativaOrcamentariaBase $fkPpaPpaEstimativaOrcamentariaBase)
    {
        if (false === $this->fkPpaPpaEstimativaOrcamentariaBases->contains($fkPpaPpaEstimativaOrcamentariaBase)) {
            $fkPpaPpaEstimativaOrcamentariaBase->setFkPpaPpa($this);
            $this->fkPpaPpaEstimativaOrcamentariaBases->add($fkPpaPpaEstimativaOrcamentariaBase);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PpaPpaEstimativaOrcamentariaBase
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\PpaEstimativaOrcamentariaBase $fkPpaPpaEstimativaOrcamentariaBase
     */
    public function removeFkPpaPpaEstimativaOrcamentariaBases(\Urbem\CoreBundle\Entity\Ppa\PpaEstimativaOrcamentariaBase $fkPpaPpaEstimativaOrcamentariaBase)
    {
        $this->fkPpaPpaEstimativaOrcamentariaBases->removeElement($fkPpaPpaEstimativaOrcamentariaBase);
    }

    /**
     * OneToMany (owning side)
     * Get fkPpaPpaEstimativaOrcamentariaBases
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\PpaEstimativaOrcamentariaBase
     */
    public function getFkPpaPpaEstimativaOrcamentariaBases()
    {
        return $this->fkPpaPpaEstimativaOrcamentariaBases;
    }

    /**
     * OneToOne (inverse side)
     * Set PpaPpaPrecisao
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\PpaPrecisao $fkPpaPpaPrecisao
     * @return Ppa
     */
    public function setFkPpaPpaPrecisao(\Urbem\CoreBundle\Entity\Ppa\PpaPrecisao $fkPpaPpaPrecisao)
    {
        $fkPpaPpaPrecisao->setFkPpaPpa($this);
        $this->fkPpaPpaPrecisao = $fkPpaPpaPrecisao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPpaPpaPrecisao
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\PpaPrecisao
     */
    public function getFkPpaPpaPrecisao()
    {
        return $this->fkPpaPpaPrecisao;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s à %s', $this->anoInicio, $this->anoFinal);
    }
}
