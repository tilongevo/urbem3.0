<?php

namespace Urbem\CoreBundle\Entity\Patrimonio;

/**
 * Natureza
 */
class Natureza
{
    /**
     * PK
     * @var integer
     */
    private $codNatureza;

    /**
     * @var string
     */
    private $nomNatureza;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\BalancoApbaaaaNatureza
     */
    private $fkTcmgoBalancoApbaaaaNaturezas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\Grupo
     */
    private $fkPatrimonioGrupos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Patrimonio\TipoNatureza
     */
    private $fkPatrimonioTipoNatureza;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmgoBalancoApbaaaaNaturezas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioGrupos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return Natureza
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
     * Set nomNatureza
     *
     * @param string $nomNatureza
     * @return Natureza
     */
    public function setNomNatureza($nomNatureza)
    {
        $this->nomNatureza = $nomNatureza;
        return $this;
    }

    /**
     * Get nomNatureza
     *
     * @return string
     */
    public function getNomNatureza()
    {
        return $this->nomNatureza;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return Natureza
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
     * Add TcmgoBalancoApbaaaaNatureza
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\BalancoApbaaaaNatureza $fkTcmgoBalancoApbaaaaNatureza
     * @return Natureza
     */
    public function addFkTcmgoBalancoApbaaaaNaturezas(\Urbem\CoreBundle\Entity\Tcmgo\BalancoApbaaaaNatureza $fkTcmgoBalancoApbaaaaNatureza)
    {
        if (false === $this->fkTcmgoBalancoApbaaaaNaturezas->contains($fkTcmgoBalancoApbaaaaNatureza)) {
            $fkTcmgoBalancoApbaaaaNatureza->setFkPatrimonioNatureza($this);
            $this->fkTcmgoBalancoApbaaaaNaturezas->add($fkTcmgoBalancoApbaaaaNatureza);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoBalancoApbaaaaNatureza
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\BalancoApbaaaaNatureza $fkTcmgoBalancoApbaaaaNatureza
     */
    public function removeFkTcmgoBalancoApbaaaaNaturezas(\Urbem\CoreBundle\Entity\Tcmgo\BalancoApbaaaaNatureza $fkTcmgoBalancoApbaaaaNatureza)
    {
        $this->fkTcmgoBalancoApbaaaaNaturezas->removeElement($fkTcmgoBalancoApbaaaaNatureza);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoBalancoApbaaaaNaturezas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\BalancoApbaaaaNatureza
     */
    public function getFkTcmgoBalancoApbaaaaNaturezas()
    {
        return $this->fkTcmgoBalancoApbaaaaNaturezas;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioGrupo
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Grupo $fkPatrimonioGrupo
     * @return Natureza
     */
    public function addFkPatrimonioGrupos(\Urbem\CoreBundle\Entity\Patrimonio\Grupo $fkPatrimonioGrupo)
    {
        if (false === $this->fkPatrimonioGrupos->contains($fkPatrimonioGrupo)) {
            $fkPatrimonioGrupo->setFkPatrimonioNatureza($this);
            $this->fkPatrimonioGrupos->add($fkPatrimonioGrupo);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioGrupo
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Grupo $fkPatrimonioGrupo
     */
    public function removeFkPatrimonioGrupos(\Urbem\CoreBundle\Entity\Patrimonio\Grupo $fkPatrimonioGrupo)
    {
        $this->fkPatrimonioGrupos->removeElement($fkPatrimonioGrupo);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioGrupos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\Grupo
     */
    public function getFkPatrimonioGrupos()
    {
        return $this->fkPatrimonioGrupos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPatrimonioTipoNatureza
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\TipoNatureza $fkPatrimonioTipoNatureza
     * @return Natureza
     */
    public function setFkPatrimonioTipoNatureza(\Urbem\CoreBundle\Entity\Patrimonio\TipoNatureza $fkPatrimonioTipoNatureza)
    {
        $this->codTipo = $fkPatrimonioTipoNatureza->getCodigo();
        $this->fkPatrimonioTipoNatureza = $fkPatrimonioTipoNatureza;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPatrimonioTipoNatureza
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\TipoNatureza
     */
    public function getFkPatrimonioTipoNatureza()
    {
        return $this->fkPatrimonioTipoNatureza;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '%s - %s',
            $this->codNatureza,
            $this->nomNatureza
        );
    }
}
