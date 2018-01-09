<?php

namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * DiasTurno
 */
class DiasTurno
{
    /**
     * PK
     * @var integer
     */
    private $codDia;

    /**
     * @var string
     */
    private $nomDia;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\FaixaTurno
     */
    private $fkPessoalFaixaTurnos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\BancoHorasDias
     */
    private $fkPontoBancoHorasDias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\FaixasDias
     */
    private $fkPontoFaixasDias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\DiasUteis
     */
    private $fkPontoDiasUteis;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalFaixaTurnos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPontoBancoHorasDias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPontoFaixasDias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPontoDiasUteis = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codDia
     *
     * @param integer $codDia
     * @return DiasTurno
     */
    public function setCodDia($codDia)
    {
        $this->codDia = $codDia;
        return $this;
    }

    /**
     * Get codDia
     *
     * @return integer
     */
    public function getCodDia()
    {
        return $this->codDia;
    }

    /**
     * Set nomDia
     *
     * @param string $nomDia
     * @return DiasTurno
     */
    public function setNomDia($nomDia)
    {
        $this->nomDia = $nomDia;
        return $this;
    }

    /**
     * Get nomDia
     *
     * @return string
     */
    public function getNomDia()
    {
        return $this->nomDia;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalFaixaTurno
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\FaixaTurno $fkPessoalFaixaTurno
     * @return DiasTurno
     */
    public function addFkPessoalFaixaTurnos(\Urbem\CoreBundle\Entity\Pessoal\FaixaTurno $fkPessoalFaixaTurno)
    {
        if (false === $this->fkPessoalFaixaTurnos->contains($fkPessoalFaixaTurno)) {
            $fkPessoalFaixaTurno->setFkPessoalDiasTurno($this);
            $this->fkPessoalFaixaTurnos->add($fkPessoalFaixaTurno);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalFaixaTurno
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\FaixaTurno $fkPessoalFaixaTurno
     */
    public function removeFkPessoalFaixaTurnos(\Urbem\CoreBundle\Entity\Pessoal\FaixaTurno $fkPessoalFaixaTurno)
    {
        $this->fkPessoalFaixaTurnos->removeElement($fkPessoalFaixaTurno);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalFaixaTurnos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\FaixaTurno
     */
    public function getFkPessoalFaixaTurnos()
    {
        return $this->fkPessoalFaixaTurnos;
    }

    /**
     * OneToMany (owning side)
     * Add PontoBancoHorasDias
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\BancoHorasDias $fkPontoBancoHorasDias
     * @return DiasTurno
     */
    public function addFkPontoBancoHorasDias(\Urbem\CoreBundle\Entity\Ponto\BancoHorasDias $fkPontoBancoHorasDias)
    {
        if (false === $this->fkPontoBancoHorasDias->contains($fkPontoBancoHorasDias)) {
            $fkPontoBancoHorasDias->setFkPessoalDiasTurno($this);
            $this->fkPontoBancoHorasDias->add($fkPontoBancoHorasDias);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoBancoHorasDias
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\BancoHorasDias $fkPontoBancoHorasDias
     */
    public function removeFkPontoBancoHorasDias(\Urbem\CoreBundle\Entity\Ponto\BancoHorasDias $fkPontoBancoHorasDias)
    {
        $this->fkPontoBancoHorasDias->removeElement($fkPontoBancoHorasDias);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoBancoHorasDias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\BancoHorasDias
     */
    public function getFkPontoBancoHorasDias()
    {
        return $this->fkPontoBancoHorasDias;
    }

    /**
     * OneToMany (owning side)
     * Add PontoFaixasDias
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\FaixasDias $fkPontoFaixasDias
     * @return DiasTurno
     */
    public function addFkPontoFaixasDias(\Urbem\CoreBundle\Entity\Ponto\FaixasDias $fkPontoFaixasDias)
    {
        if (false === $this->fkPontoFaixasDias->contains($fkPontoFaixasDias)) {
            $fkPontoFaixasDias->setFkPessoalDiasTurno($this);
            $this->fkPontoFaixasDias->add($fkPontoFaixasDias);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoFaixasDias
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\FaixasDias $fkPontoFaixasDias
     */
    public function removeFkPontoFaixasDias(\Urbem\CoreBundle\Entity\Ponto\FaixasDias $fkPontoFaixasDias)
    {
        $this->fkPontoFaixasDias->removeElement($fkPontoFaixasDias);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoFaixasDias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\FaixasDias
     */
    public function getFkPontoFaixasDias()
    {
        return $this->fkPontoFaixasDias;
    }

    /**
     * OneToMany (owning side)
     * Add PontoDiasUteis
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\DiasUteis $fkPontoDiasUteis
     * @return DiasTurno
     */
    public function addFkPontoDiasUteis(\Urbem\CoreBundle\Entity\Ponto\DiasUteis $fkPontoDiasUteis)
    {
        if (false === $this->fkPontoDiasUteis->contains($fkPontoDiasUteis)) {
            $fkPontoDiasUteis->setFkPessoalDiasTurno($this);
            $this->fkPontoDiasUteis->add($fkPontoDiasUteis);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoDiasUteis
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\DiasUteis $fkPontoDiasUteis
     */
    public function removeFkPontoDiasUteis(\Urbem\CoreBundle\Entity\Ponto\DiasUteis $fkPontoDiasUteis)
    {
        $this->fkPontoDiasUteis->removeElement($fkPontoDiasUteis);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoDiasUteis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\DiasUteis
     */
    public function getFkPontoDiasUteis()
    {
        return $this->fkPontoDiasUteis;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->codDia;
    }
}
