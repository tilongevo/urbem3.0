<?php

namespace Urbem\CoreBundle\Entity\Monetario;

/**
 * TipoConvenio
 */
class TipoConvenio
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $nomTipo;

    /**
     * @var integer
     */
    private $codModulo;

    /**
     * @var integer
     */
    private $codBiblioteca;

    /**
     * @var integer
     */
    private $codFuncao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\Convenio
     */
    private $fkMonetarioConvenios;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Funcao
     */
    private $fkAdministracaoFuncao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkMonetarioConvenios = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoConvenio
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
     * Set nomTipo
     *
     * @param string $nomTipo
     * @return TipoConvenio
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
     * Set codModulo
     *
     * @param integer $codModulo
     * @return TipoConvenio
     */
    public function setCodModulo($codModulo)
    {
        $this->codModulo = $codModulo;
        return $this;
    }

    /**
     * Get codModulo
     *
     * @return integer
     */
    public function getCodModulo()
    {
        return $this->codModulo;
    }

    /**
     * Set codBiblioteca
     *
     * @param integer $codBiblioteca
     * @return TipoConvenio
     */
    public function setCodBiblioteca($codBiblioteca)
    {
        $this->codBiblioteca = $codBiblioteca;
        return $this;
    }

    /**
     * Get codBiblioteca
     *
     * @return integer
     */
    public function getCodBiblioteca()
    {
        return $this->codBiblioteca;
    }

    /**
     * Set codFuncao
     *
     * @param integer $codFuncao
     * @return TipoConvenio
     */
    public function setCodFuncao($codFuncao)
    {
        $this->codFuncao = $codFuncao;
        return $this;
    }

    /**
     * Get codFuncao
     *
     * @return integer
     */
    public function getCodFuncao()
    {
        return $this->codFuncao;
    }

    /**
     * OneToMany (owning side)
     * Add MonetarioConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Convenio $fkMonetarioConvenio
     * @return TipoConvenio
     */
    public function addFkMonetarioConvenios(\Urbem\CoreBundle\Entity\Monetario\Convenio $fkMonetarioConvenio)
    {
        if (false === $this->fkMonetarioConvenios->contains($fkMonetarioConvenio)) {
            $fkMonetarioConvenio->setFkMonetarioTipoConvenio($this);
            $this->fkMonetarioConvenios->add($fkMonetarioConvenio);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove MonetarioConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Convenio $fkMonetarioConvenio
     */
    public function removeFkMonetarioConvenios(\Urbem\CoreBundle\Entity\Monetario\Convenio $fkMonetarioConvenio)
    {
        $this->fkMonetarioConvenios->removeElement($fkMonetarioConvenio);
    }

    /**
     * OneToMany (owning side)
     * Get fkMonetarioConvenios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\Convenio
     */
    public function getFkMonetarioConvenios()
    {
        return $this->fkMonetarioConvenios;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Funcao $fkAdministracaoFuncao
     * @return TipoConvenio
     */
    public function setFkAdministracaoFuncao(\Urbem\CoreBundle\Entity\Administracao\Funcao $fkAdministracaoFuncao)
    {
        $this->codModulo = $fkAdministracaoFuncao->getCodModulo();
        $this->codBiblioteca = $fkAdministracaoFuncao->getCodBiblioteca();
        $this->codFuncao = $fkAdministracaoFuncao->getCodFuncao();
        $this->fkAdministracaoFuncao = $fkAdministracaoFuncao;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoFuncao
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Funcao
     */
    public function getFkAdministracaoFuncao()
    {
        return $this->fkAdministracaoFuncao;
    }

    /**
    *
    * @return string
    */
    public function __toString()
    {
        return (string) $this->nomTipo;
    }
}
