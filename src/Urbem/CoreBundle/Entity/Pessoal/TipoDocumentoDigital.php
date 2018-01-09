<?php

namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * TipoDocumentoDigital
 */
class TipoDocumentoDigital
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ServidorDocumentoDigital
     */
    private $fkPessoalServidorDocumentoDigitais;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalServidorDocumentoDigitais = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoDocumentoDigital
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
     * Set descricao
     *
     * @param string $descricao
     * @return TipoDocumentoDigital
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
     * Add PessoalServidorDocumentoDigital
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ServidorDocumentoDigital $fkPessoalServidorDocumentoDigital
     * @return TipoDocumentoDigital
     */
    public function addFkPessoalServidorDocumentoDigitais(\Urbem\CoreBundle\Entity\Pessoal\ServidorDocumentoDigital $fkPessoalServidorDocumentoDigital)
    {
        if (false === $this->fkPessoalServidorDocumentoDigitais->contains($fkPessoalServidorDocumentoDigital)) {
            $fkPessoalServidorDocumentoDigital->setFkPessoalTipoDocumentoDigital($this);
            $this->fkPessoalServidorDocumentoDigitais->add($fkPessoalServidorDocumentoDigital);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalServidorDocumentoDigital
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ServidorDocumentoDigital $fkPessoalServidorDocumentoDigital
     */
    public function removeFkPessoalServidorDocumentoDigitais(\Urbem\CoreBundle\Entity\Pessoal\ServidorDocumentoDigital $fkPessoalServidorDocumentoDigital)
    {
        $this->fkPessoalServidorDocumentoDigitais->removeElement($fkPessoalServidorDocumentoDigital);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalServidorDocumentoDigitais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ServidorDocumentoDigital
     */
    public function getFkPessoalServidorDocumentoDigitais()
    {
        return $this->fkPessoalServidorDocumentoDigitais;
    }
}
