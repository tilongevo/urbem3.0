<?php

namespace Urbem\CoreBundle\Entity\Beneficio;

/**
 * TipoConvenioMedico
 */
class TipoConvenioMedico
{
    /**
     * PK
     * @var integer
     */
    private $codTipoConvenio;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\Beneficiario
     */
    private $fkBeneficioBeneficiarios;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkBeneficioBeneficiarios = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoConvenio
     *
     * @param integer $codTipoConvenio
     * @return TipoConvenioMedico
     */
    public function setCodTipoConvenio($codTipoConvenio)
    {
        $this->codTipoConvenio = $codTipoConvenio;
        return $this;
    }

    /**
     * Get codTipoConvenio
     *
     * @return integer
     */
    public function getCodTipoConvenio()
    {
        return $this->codTipoConvenio;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoConvenioMedico
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * OneToMany (owning side)
     * Add BeneficioBeneficiario
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\Beneficiario $fkBeneficioBeneficiario
     * @return TipoConvenioMedico
     */
    public function addFkBeneficioBeneficiarios(\Urbem\CoreBundle\Entity\Beneficio\Beneficiario $fkBeneficioBeneficiario)
    {
        if (false === $this->fkBeneficioBeneficiarios->contains($fkBeneficioBeneficiario)) {
            $fkBeneficioBeneficiario->setFkBeneficioTipoConvenioMedico($this);
            $this->fkBeneficioBeneficiarios->add($fkBeneficioBeneficiario);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove BeneficioBeneficiario
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\Beneficiario $fkBeneficioBeneficiario
     */
    public function removeFkBeneficioBeneficiarios(\Urbem\CoreBundle\Entity\Beneficio\Beneficiario $fkBeneficioBeneficiario)
    {
        $this->fkBeneficioBeneficiarios->removeElement($fkBeneficioBeneficiario);
    }

    /**
     * OneToMany (owning side)
     * Get fkBeneficioBeneficiarios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\Beneficiario
     */
    public function getFkBeneficioBeneficiarios()
    {
        return $this->fkBeneficioBeneficiarios;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%d - %s', $this->codTipoConvenio, $this->descricao);
    }
}
