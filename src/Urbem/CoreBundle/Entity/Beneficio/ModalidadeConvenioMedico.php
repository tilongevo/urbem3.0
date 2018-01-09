<?php

namespace Urbem\CoreBundle\Entity\Beneficio;

/**
 * ModalidadeConvenioMedico
 */
class ModalidadeConvenioMedico
{
    /**
     * PK
     * @var integer
     */
    private $codModalidade;

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
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return ModalidadeConvenioMedico
     */
    public function setCodModalidade($codModalidade)
    {
        $this->codModalidade = $codModalidade;
        return $this;
    }

    /**
     * Get codModalidade
     *
     * @return integer
     */
    public function getCodModalidade()
    {
        return $this->codModalidade;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return ModalidadeConvenioMedico
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
     * @return ModalidadeConvenioMedico
     */
    public function addFkBeneficioBeneficiarios(\Urbem\CoreBundle\Entity\Beneficio\Beneficiario $fkBeneficioBeneficiario)
    {
        if (false === $this->fkBeneficioBeneficiarios->contains($fkBeneficioBeneficiario)) {
            $fkBeneficioBeneficiario->setFkBeneficioModalidadeConvenioMedico($this);
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
        return sprintf('%d - %s', $this->codModalidade, $this->descricao);
    }
}
