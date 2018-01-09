<?php
 
namespace Urbem\CoreBundle\Entity\Frota;

/**
 * Posto
 */
class Posto
{
    /**
     * PK
     * @var integer
     */
    private $cgmPosto;

    /**
     * @var boolean
     */
    private $interno;

    /**
     * @var boolean
     */
    private $ativo;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica
     */
    private $fkSwCgmPessoaJuridica;


    /**
     * Set cgmPosto
     *
     * @param integer $cgmPosto
     * @return Posto
     */
    public function setCgmPosto($cgmPosto)
    {
        $this->cgmPosto = $cgmPosto;
        return $this;
    }

    /**
     * Get cgmPosto
     *
     * @return integer
     */
    public function getCgmPosto()
    {
        return $this->cgmPosto;
    }

    /**
     * Set interno
     *
     * @param boolean $interno
     * @return Posto
     */
    public function setInterno($interno)
    {
        $this->interno = $interno;
        return $this;
    }

    /**
     * Get interno
     *
     * @return boolean
     */
    public function getInterno()
    {
        return $this->interno;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return Posto
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
        return $this;
    }

    /**
     * Get ativo
     *
     * @return boolean
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * OneToOne (owning side)
     * Set SwCgmPessoaJuridica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica $fkSwCgmPessoaJuridica
     * @return Posto
     */
    public function setFkSwCgmPessoaJuridica(\Urbem\CoreBundle\Entity\SwCgmPessoaJuridica $fkSwCgmPessoaJuridica)
    {
        $this->cgmPosto = $fkSwCgmPessoaJuridica->getNumcgm();
        $this->fkSwCgmPessoaJuridica = $fkSwCgmPessoaJuridica;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkSwCgmPessoaJuridica
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica
     */
    public function getFkSwCgmPessoaJuridica()
    {
        return $this->fkSwCgmPessoaJuridica;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->fkSwCgmPessoaJuridica;
    }
}
