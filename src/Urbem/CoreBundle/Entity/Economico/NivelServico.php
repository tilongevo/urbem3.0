<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * NivelServico
 */
class NivelServico
{
    /**
     * PK
     * @var integer
     */
    private $codVigencia;

    /**
     * PK
     * @var integer
     */
    private $codNivel;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\NivelServicoValor
     */
    private $fkEconomicoNivelServicoValores;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\VigenciaServico
     */
    private $fkEconomicoVigenciaServico;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoNivelServicoValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codVigencia
     *
     * @param integer $codVigencia
     * @return NivelServico
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
     * Set codNivel
     *
     * @param integer $codNivel
     * @return NivelServico
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
     * Set nomNivel
     *
     * @param string $nomNivel
     * @return NivelServico
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
     * @return NivelServico
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
     * @return NivelServico
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
     * Add EconomicoNivelServicoValor
     *
     * @param \Urbem\CoreBundle\Entity\Economico\NivelServicoValor $fkEconomicoNivelServicoValor
     * @return NivelServico
     */
    public function addFkEconomicoNivelServicoValores(\Urbem\CoreBundle\Entity\Economico\NivelServicoValor $fkEconomicoNivelServicoValor)
    {
        if (false === $this->fkEconomicoNivelServicoValores->contains($fkEconomicoNivelServicoValor)) {
            $fkEconomicoNivelServicoValor->setFkEconomicoNivelServico($this);
            $this->fkEconomicoNivelServicoValores->add($fkEconomicoNivelServicoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoNivelServicoValor
     *
     * @param \Urbem\CoreBundle\Entity\Economico\NivelServicoValor $fkEconomicoNivelServicoValor
     */
    public function removeFkEconomicoNivelServicoValores(\Urbem\CoreBundle\Entity\Economico\NivelServicoValor $fkEconomicoNivelServicoValor)
    {
        $this->fkEconomicoNivelServicoValores->removeElement($fkEconomicoNivelServicoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoNivelServicoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\NivelServicoValor
     */
    public function getFkEconomicoNivelServicoValores()
    {
        return $this->fkEconomicoNivelServicoValores;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoVigenciaServico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\VigenciaServico $fkEconomicoVigenciaServico
     * @return NivelServico
     */
    public function setFkEconomicoVigenciaServico(\Urbem\CoreBundle\Entity\Economico\VigenciaServico $fkEconomicoVigenciaServico)
    {
        $this->codVigencia = $fkEconomicoVigenciaServico->getCodVigencia();
        $this->fkEconomicoVigenciaServico = $fkEconomicoVigenciaServico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoVigenciaServico
     *
     * @return \Urbem\CoreBundle\Entity\Economico\VigenciaServico
     */
    public function getFkEconomicoVigenciaServico()
    {
        return $this->fkEconomicoVigenciaServico;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->getCodNivel(), $this->getNomNivel());
    }
}
