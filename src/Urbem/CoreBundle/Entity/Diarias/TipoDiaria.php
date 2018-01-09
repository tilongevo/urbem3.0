<?php

namespace Urbem\CoreBundle\Entity\Diarias;

/**
 * TipoDiaria
 */
class TipoDiaria
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var string
     */
    private $nomTipo;

    /**
     * @var integer
     */
    private $valor;

    /**
     * @var integer
     */
    private $codNorma;

    /**
     * @var \DateTime
     */
    private $vigencia;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Diarias\TipoDiariaDespesa
     */
    private $fkDiariasTipoDiariaDespesa;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Diarias\Diaria
     */
    private $fkDiariasDiarias;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkDiariasDiarias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoDiaria
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return TipoDiaria
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
     * Set nomTipo
     *
     * @param string $nomTipo
     * @return TipoDiaria
     */
    public function setNomTipo($nomTipo)
    {
        $this->nomTipo = $nomTipo;
        return $this;
    }

    /**
     * Get nomTipo
     *
     * @return string
     */
    public function getNomTipo()
    {
        return $this->nomTipo;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return TipoDiaria
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return TipoDiaria
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
     * Set vigencia
     *
     * @param \DateTime $vigencia
     * @return TipoDiaria
     */
    public function setVigencia(\DateTime $vigencia)
    {
        $this->vigencia = $vigencia;
        return $this;
    }

    /**
     * Get vigencia
     *
     * @return \DateTime
     */
    public function getVigencia()
    {
        return $this->vigencia;
    }

    /**
     * OneToMany (owning side)
     * Add DiariasDiaria
     *
     * @param \Urbem\CoreBundle\Entity\Diarias\Diaria $fkDiariasDiaria
     * @return TipoDiaria
     */
    public function addFkDiariasDiarias(\Urbem\CoreBundle\Entity\Diarias\Diaria $fkDiariasDiaria)
    {
        if (false === $this->fkDiariasDiarias->contains($fkDiariasDiaria)) {
            $fkDiariasDiaria->setFkDiariasTipoDiaria($this);
            $this->fkDiariasDiarias->add($fkDiariasDiaria);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DiariasDiaria
     *
     * @param \Urbem\CoreBundle\Entity\Diarias\Diaria $fkDiariasDiaria
     */
    public function removeFkDiariasDiarias(\Urbem\CoreBundle\Entity\Diarias\Diaria $fkDiariasDiaria)
    {
        $this->fkDiariasDiarias->removeElement($fkDiariasDiaria);
    }

    /**
     * OneToMany (owning side)
     * Get fkDiariasDiarias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Diarias\Diaria
     */
    public function getFkDiariasDiarias()
    {
        return $this->fkDiariasDiarias;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return TipoDiaria
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
     * OneToOne (inverse side)
     * Set DiariasTipoDiariaDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Diarias\TipoDiariaDespesa $fkDiariasTipoDiariaDespesa
     * @return TipoDiaria
     */
    public function setFkDiariasTipoDiariaDespesa(\Urbem\CoreBundle\Entity\Diarias\TipoDiariaDespesa $fkDiariasTipoDiariaDespesa)
    {
        $fkDiariasTipoDiariaDespesa->setFkDiariasTipoDiaria($this);
        $this->fkDiariasTipoDiariaDespesa = $fkDiariasTipoDiariaDespesa;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkDiariasTipoDiariaDespesa
     *
     * @return \Urbem\CoreBundle\Entity\Diarias\TipoDiariaDespesa
     */
    public function getFkDiariasTipoDiariaDespesa()
    {
        return $this->fkDiariasTipoDiariaDespesa;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->codTipo) {
            return sprintf('%s - %s', $this->codTipo, $this->fkNormasNorma);
        } else {
            return (string) "Tipo de Diárias";
        }
    }
}
