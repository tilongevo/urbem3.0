<?php

namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * Imobiliaria
 */
class Imobiliaria
{
    /**
     * PK
     * @var string
     */
    private $creci;

    /**
     * @var string
     */
    private $responsavel;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Corretagem
     */
    private $fkImobiliarioCorretagem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Corretor
     */
    private $fkImobiliarioCorretor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica
     */
    private $fkSwCgmPessoaJuridica;


    /**
     * Set creci
     *
     * @param string $creci
     * @return Imobiliaria
     */
    public function setCreci($creci)
    {
        $this->creci = $creci;
        return $this;
    }

    /**
     * Get creci
     *
     * @return string
     */
    public function getCreci()
    {
        return $this->creci;
    }

    /**
     * Set responsavel
     *
     * @param string $responsavel
     * @return Imobiliaria
     */
    public function setResponsavel($responsavel)
    {
        $this->responsavel = $responsavel;
        return $this;
    }

    /**
     * Get responsavel
     *
     * @return string
     */
    public function getResponsavel()
    {
        return $this->responsavel;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return Imobiliaria
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioCorretor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Corretor $fkImobiliarioCorretor
     * @return Imobiliaria
     */
    public function setFkImobiliarioCorretor(\Urbem\CoreBundle\Entity\Imobiliario\Corretor $fkImobiliarioCorretor)
    {
        $this->responsavel = $fkImobiliarioCorretor->getCreci();
        $this->fkImobiliarioCorretor = $fkImobiliarioCorretor;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioCorretor
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Corretor
     */
    public function getFkImobiliarioCorretor()
    {
        return $this->fkImobiliarioCorretor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgmPessoaJuridica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica $fkSwCgmPessoaJuridica
     * @return Imobiliaria
     */
    public function setFkSwCgmPessoaJuridica(\Urbem\CoreBundle\Entity\SwCgmPessoaJuridica $fkSwCgmPessoaJuridica)
    {
        $this->numcgm = $fkSwCgmPessoaJuridica->getNumcgm();
        $this->fkSwCgmPessoaJuridica = $fkSwCgmPessoaJuridica;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgmPessoaJuridica
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica
     */
    public function getFkSwCgmPessoaJuridica()
    {
        return $this->fkSwCgmPessoaJuridica;
    }

    /**
     * OneToOne (owning side)
     * Set ImobiliarioCorretagem
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Corretagem $fkImobiliarioCorretagem
     * @return Imobiliaria
     */
    public function setFkImobiliarioCorretagem(\Urbem\CoreBundle\Entity\Imobiliario\Corretagem $fkImobiliarioCorretagem)
    {
        $this->creci = $fkImobiliarioCorretagem->getCreci();
        $this->fkImobiliarioCorretagem = $fkImobiliarioCorretagem;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkImobiliarioCorretagem
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Corretagem
     */
    public function getFkImobiliarioCorretagem()
    {
        return $this->fkImobiliarioCorretagem;
    }

    /**
    * @return string
    */
    public function __toString()
    {
        return (string) $this->creci;
    }
}
