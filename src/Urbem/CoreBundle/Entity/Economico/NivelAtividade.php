<?php

namespace Urbem\CoreBundle\Entity\Economico;

/**
 * NivelAtividade
 */
class NivelAtividade
{
    /**
     * PK
     * @var integer
     */
    private $codNivel;

    /**
     * PK
     * @var integer
     */
    private $codVigencia;

    /**
     * @var string
     */
    private $nomNivel;

    /**
     * @var string
     */
    private $mascara;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\Atividade
     */
    private $fkEconomicoAtividades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\NivelAtividadeValor
     */
    private $fkEconomicoNivelAtividadeValores;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\VigenciaAtividade
     */
    private $fkEconomicoVigenciaAtividade;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoAtividades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoNivelAtividadeValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codNivel
     *
     * @param integer $codNivel
     * @return NivelAtividade
     */
    public function setCodNivel($codNivel)
    {
        $this->codNivel = $codNivel;
        return $this;
    }

    /**
     * Get codNivel
     *
     * @return integer
     */
    public function getCodNivel()
    {
        return $this->codNivel;
    }

    /**
     * Set codVigencia
     *
     * @param integer $codVigencia
     * @return NivelAtividade
     */
    public function setCodVigencia($codVigencia)
    {
        $this->codVigencia = $codVigencia;
        return $this;
    }

    /**
     * Get codVigencia
     *
     * @return integer
     */
    public function getCodVigencia()
    {
        return $this->codVigencia;
    }

    /**
     * Set nomNivel
     *
     * @param string $nomNivel
     * @return NivelAtividade
     */
    public function setNomNivel($nomNivel)
    {
        $this->nomNivel = $nomNivel;
        return $this;
    }

    /**
     * Get nomNivel
     *
     * @return string
     */
    public function getNomNivel()
    {
        return $this->nomNivel;
    }

    /**
     * Set mascara
     *
     * @param string $mascara
     * @return NivelAtividade
     */
    public function setMascara($mascara)
    {
        $this->mascara = $mascara;
        return $this;
    }

    /**
     * Get mascara
     *
     * @return string
     */
    public function getMascara()
    {
        return $this->mascara;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return NivelAtividade
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
     * OneToMany (owning side)
     * Add EconomicoAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Atividade $fkEconomicoAtividade
     * @return NivelAtividade
     */
    public function addFkEconomicoAtividades(\Urbem\CoreBundle\Entity\Economico\Atividade $fkEconomicoAtividade)
    {
        if (false === $this->fkEconomicoAtividades->contains($fkEconomicoAtividade)) {
            $fkEconomicoAtividade->setFkEconomicoNivelAtividade($this);
            $this->fkEconomicoAtividades->add($fkEconomicoAtividade);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Atividade $fkEconomicoAtividade
     */
    public function removeFkEconomicoAtividades(\Urbem\CoreBundle\Entity\Economico\Atividade $fkEconomicoAtividade)
    {
        $this->fkEconomicoAtividades->removeElement($fkEconomicoAtividade);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoAtividades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\Atividade
     */
    public function getFkEconomicoAtividades()
    {
        return $this->fkEconomicoAtividades;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoNivelAtividadeValor
     *
     * @param \Urbem\CoreBundle\Entity\Economico\NivelAtividadeValor $fkEconomicoNivelAtividadeValor
     * @return NivelAtividade
     */
    public function addFkEconomicoNivelAtividadeValores(\Urbem\CoreBundle\Entity\Economico\NivelAtividadeValor $fkEconomicoNivelAtividadeValor)
    {
        if (false === $this->fkEconomicoNivelAtividadeValores->contains($fkEconomicoNivelAtividadeValor)) {
            $fkEconomicoNivelAtividadeValor->setFkEconomicoNivelAtividade($this);
            $this->fkEconomicoNivelAtividadeValores->add($fkEconomicoNivelAtividadeValor);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoNivelAtividadeValor
     *
     * @param \Urbem\CoreBundle\Entity\Economico\NivelAtividadeValor $fkEconomicoNivelAtividadeValor
     */
    public function removeFkEconomicoNivelAtividadeValores(\Urbem\CoreBundle\Entity\Economico\NivelAtividadeValor $fkEconomicoNivelAtividadeValor)
    {
        $this->fkEconomicoNivelAtividadeValores->removeElement($fkEconomicoNivelAtividadeValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoNivelAtividadeValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\NivelAtividadeValor
     */
    public function getFkEconomicoNivelAtividadeValores()
    {
        return $this->fkEconomicoNivelAtividadeValores;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoVigenciaAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\VigenciaAtividade $fkEconomicoVigenciaAtividade
     * @return NivelAtividade
     */
    public function setFkEconomicoVigenciaAtividade(\Urbem\CoreBundle\Entity\Economico\VigenciaAtividade $fkEconomicoVigenciaAtividade)
    {
        $this->codVigencia = $fkEconomicoVigenciaAtividade->getCodVigencia();
        $this->fkEconomicoVigenciaAtividade = $fkEconomicoVigenciaAtividade;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoVigenciaAtividade
     *
     * @return \Urbem\CoreBundle\Entity\Economico\VigenciaAtividade
     */
    public function getFkEconomicoVigenciaAtividade()
    {
        return $this->fkEconomicoVigenciaAtividade;
    }

    /**
    * @return string
    */
    public function __toString()
    {
        return (string) $this->nomNivel;
    }
}
