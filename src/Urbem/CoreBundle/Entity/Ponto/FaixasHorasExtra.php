<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * FaixasHorasExtra
 */
class FaixasHorasExtra
{
    /**
     * PK
     * @var integer
     */
    private $codConfiguracao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codFaixa;

    /**
     * @var integer
     */
    private $percentual;

    /**
     * @var \DateTime
     */
    private $horas;

    /**
     * @var string
     */
    private $calculoHorasExtra;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\FaixasDias
     */
    private $fkPontoFaixasDias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\FormatoFaixasHorasExtras
     */
    private $fkPontoFormatoFaixasHorasExtras;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoHorasExtras2
     */
    private $fkPontoConfiguracaoHorasExtras2;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPontoFaixasDias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPontoFormatoFaixasHorasExtras = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return FaixasHorasExtra
     */
    public function setCodConfiguracao($codConfiguracao)
    {
        $this->codConfiguracao = $codConfiguracao;
        return $this;
    }

    /**
     * Get codConfiguracao
     *
     * @return integer
     */
    public function getCodConfiguracao()
    {
        return $this->codConfiguracao;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return FaixasHorasExtra
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimePK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set codFaixa
     *
     * @param integer $codFaixa
     * @return FaixasHorasExtra
     */
    public function setCodFaixa($codFaixa)
    {
        $this->codFaixa = $codFaixa;
        return $this;
    }

    /**
     * Get codFaixa
     *
     * @return integer
     */
    public function getCodFaixa()
    {
        return $this->codFaixa;
    }

    /**
     * Set percentual
     *
     * @param integer $percentual
     * @return FaixasHorasExtra
     */
    public function setPercentual($percentual)
    {
        $this->percentual = $percentual;
        return $this;
    }

    /**
     * Get percentual
     *
     * @return integer
     */
    public function getPercentual()
    {
        return $this->percentual;
    }

    /**
     * Set horas
     *
     * @param \DateTime $horas
     * @return FaixasHorasExtra
     */
    public function setHoras(\DateTime $horas)
    {
        $this->horas = $horas;
        return $this;
    }

    /**
     * Get horas
     *
     * @return \DateTime
     */
    public function getHoras()
    {
        return $this->horas;
    }

    /**
     * Set calculoHorasExtra
     *
     * @param string $calculoHorasExtra
     * @return FaixasHorasExtra
     */
    public function setCalculoHorasExtra($calculoHorasExtra)
    {
        $this->calculoHorasExtra = $calculoHorasExtra;
        return $this;
    }

    /**
     * Get calculoHorasExtra
     *
     * @return string
     */
    public function getCalculoHorasExtra()
    {
        return $this->calculoHorasExtra;
    }

    /**
     * OneToMany (owning side)
     * Add PontoFaixasDias
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\FaixasDias $fkPontoFaixasDias
     * @return FaixasHorasExtra
     */
    public function addFkPontoFaixasDias(\Urbem\CoreBundle\Entity\Ponto\FaixasDias $fkPontoFaixasDias)
    {
        if (false === $this->fkPontoFaixasDias->contains($fkPontoFaixasDias)) {
            $fkPontoFaixasDias->setFkPontoFaixasHorasExtra($this);
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
     * Add PontoFormatoFaixasHorasExtras
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\FormatoFaixasHorasExtras $fkPontoFormatoFaixasHorasExtras
     * @return FaixasHorasExtra
     */
    public function addFkPontoFormatoFaixasHorasExtras(\Urbem\CoreBundle\Entity\Ponto\FormatoFaixasHorasExtras $fkPontoFormatoFaixasHorasExtras)
    {
        if (false === $this->fkPontoFormatoFaixasHorasExtras->contains($fkPontoFormatoFaixasHorasExtras)) {
            $fkPontoFormatoFaixasHorasExtras->setFkPontoFaixasHorasExtra($this);
            $this->fkPontoFormatoFaixasHorasExtras->add($fkPontoFormatoFaixasHorasExtras);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoFormatoFaixasHorasExtras
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\FormatoFaixasHorasExtras $fkPontoFormatoFaixasHorasExtras
     */
    public function removeFkPontoFormatoFaixasHorasExtras(\Urbem\CoreBundle\Entity\Ponto\FormatoFaixasHorasExtras $fkPontoFormatoFaixasHorasExtras)
    {
        $this->fkPontoFormatoFaixasHorasExtras->removeElement($fkPontoFormatoFaixasHorasExtras);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoFormatoFaixasHorasExtras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\FormatoFaixasHorasExtras
     */
    public function getFkPontoFormatoFaixasHorasExtras()
    {
        return $this->fkPontoFormatoFaixasHorasExtras;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPontoConfiguracaoHorasExtras2
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoHorasExtras2 $fkPontoConfiguracaoHorasExtras2
     * @return FaixasHorasExtra
     */
    public function setFkPontoConfiguracaoHorasExtras2(\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoHorasExtras2 $fkPontoConfiguracaoHorasExtras2)
    {
        $this->codConfiguracao = $fkPontoConfiguracaoHorasExtras2->getCodConfiguracao();
        $this->timestamp = $fkPontoConfiguracaoHorasExtras2->getTimestamp();
        $this->fkPontoConfiguracaoHorasExtras2 = $fkPontoConfiguracaoHorasExtras2;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPontoConfiguracaoHorasExtras2
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoHorasExtras2
     */
    public function getFkPontoConfiguracaoHorasExtras2()
    {
        return $this->fkPontoConfiguracaoHorasExtras2;
    }
}
