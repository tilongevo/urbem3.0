<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * DadosRelogioPonto
 */
class DadosRelogioPonto
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\Contrato
     */
    private $fkPessoalContrato;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\DadosRelogioPontoExtras
     */
    private $fkPontoDadosRelogioPontoExtras;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\RelogioPontoDias
     */
    private $fkPontoRelogioPontoDias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\RelogioPontoJustificativa
     */
    private $fkPontoRelogioPontoJustificativas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPontoDadosRelogioPontoExtras = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPontoRelogioPontoDias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPontoRelogioPontoJustificativas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return DadosRelogioPonto
     */
    public function setCodContrato($codContrato)
    {
        $this->codContrato = $codContrato;
        return $this;
    }

    /**
     * Get codContrato
     *
     * @return integer
     */
    public function getCodContrato()
    {
        return $this->codContrato;
    }

    /**
     * OneToMany (owning side)
     * Add PontoDadosRelogioPontoExtras
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\DadosRelogioPontoExtras $fkPontoDadosRelogioPontoExtras
     * @return DadosRelogioPonto
     */
    public function addFkPontoDadosRelogioPontoExtras(\Urbem\CoreBundle\Entity\Ponto\DadosRelogioPontoExtras $fkPontoDadosRelogioPontoExtras)
    {
        if (false === $this->fkPontoDadosRelogioPontoExtras->contains($fkPontoDadosRelogioPontoExtras)) {
            $fkPontoDadosRelogioPontoExtras->setFkPontoDadosRelogioPonto($this);
            $this->fkPontoDadosRelogioPontoExtras->add($fkPontoDadosRelogioPontoExtras);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoDadosRelogioPontoExtras
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\DadosRelogioPontoExtras $fkPontoDadosRelogioPontoExtras
     */
    public function removeFkPontoDadosRelogioPontoExtras(\Urbem\CoreBundle\Entity\Ponto\DadosRelogioPontoExtras $fkPontoDadosRelogioPontoExtras)
    {
        $this->fkPontoDadosRelogioPontoExtras->removeElement($fkPontoDadosRelogioPontoExtras);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoDadosRelogioPontoExtras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\DadosRelogioPontoExtras
     */
    public function getFkPontoDadosRelogioPontoExtras()
    {
        return $this->fkPontoDadosRelogioPontoExtras;
    }

    /**
     * OneToMany (owning side)
     * Add PontoRelogioPontoDias
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\RelogioPontoDias $fkPontoRelogioPontoDias
     * @return DadosRelogioPonto
     */
    public function addFkPontoRelogioPontoDias(\Urbem\CoreBundle\Entity\Ponto\RelogioPontoDias $fkPontoRelogioPontoDias)
    {
        if (false === $this->fkPontoRelogioPontoDias->contains($fkPontoRelogioPontoDias)) {
            $fkPontoRelogioPontoDias->setFkPontoDadosRelogioPonto($this);
            $this->fkPontoRelogioPontoDias->add($fkPontoRelogioPontoDias);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoRelogioPontoDias
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\RelogioPontoDias $fkPontoRelogioPontoDias
     */
    public function removeFkPontoRelogioPontoDias(\Urbem\CoreBundle\Entity\Ponto\RelogioPontoDias $fkPontoRelogioPontoDias)
    {
        $this->fkPontoRelogioPontoDias->removeElement($fkPontoRelogioPontoDias);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoRelogioPontoDias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\RelogioPontoDias
     */
    public function getFkPontoRelogioPontoDias()
    {
        return $this->fkPontoRelogioPontoDias;
    }

    /**
     * OneToMany (owning side)
     * Add PontoRelogioPontoJustificativa
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\RelogioPontoJustificativa $fkPontoRelogioPontoJustificativa
     * @return DadosRelogioPonto
     */
    public function addFkPontoRelogioPontoJustificativas(\Urbem\CoreBundle\Entity\Ponto\RelogioPontoJustificativa $fkPontoRelogioPontoJustificativa)
    {
        if (false === $this->fkPontoRelogioPontoJustificativas->contains($fkPontoRelogioPontoJustificativa)) {
            $fkPontoRelogioPontoJustificativa->setFkPontoDadosRelogioPonto($this);
            $this->fkPontoRelogioPontoJustificativas->add($fkPontoRelogioPontoJustificativa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoRelogioPontoJustificativa
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\RelogioPontoJustificativa $fkPontoRelogioPontoJustificativa
     */
    public function removeFkPontoRelogioPontoJustificativas(\Urbem\CoreBundle\Entity\Ponto\RelogioPontoJustificativa $fkPontoRelogioPontoJustificativa)
    {
        $this->fkPontoRelogioPontoJustificativas->removeElement($fkPontoRelogioPontoJustificativa);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoRelogioPontoJustificativas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\RelogioPontoJustificativa
     */
    public function getFkPontoRelogioPontoJustificativas()
    {
        return $this->fkPontoRelogioPontoJustificativas;
    }

    /**
     * OneToOne (owning side)
     * Set PessoalContrato
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Contrato $fkPessoalContrato
     * @return DadosRelogioPonto
     */
    public function setFkPessoalContrato(\Urbem\CoreBundle\Entity\Pessoal\Contrato $fkPessoalContrato)
    {
        $this->codContrato = $fkPessoalContrato->getCodContrato();
        $this->fkPessoalContrato = $fkPessoalContrato;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPessoalContrato
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Contrato
     */
    public function getFkPessoalContrato()
    {
        return $this->fkPessoalContrato;
    }
}
