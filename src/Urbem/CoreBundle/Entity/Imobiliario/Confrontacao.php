<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * Confrontacao
 */
class Confrontacao
{
    /**
     * PK
     * @var integer
     */
    private $codConfrontacao;

    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * @var integer
     */
    private $codPonto;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoTrecho
     */
    private $fkImobiliarioConfrontacaoTrecho;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoLote
     */
    private $fkImobiliarioConfrontacaoLote;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoDiversa
     */
    private $fkImobiliarioConfrontacaoDiversa;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoExtensao
     */
    private $fkImobiliarioConfrontacaoExtensoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Lote
     */
    private $fkImobiliarioLote;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\PontoCardeal
     */
    private $fkImobiliarioPontoCardeal;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImobiliarioConfrontacaoExtensoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codConfrontacao
     *
     * @param integer $codConfrontacao
     * @return Confrontacao
     */
    public function setCodConfrontacao($codConfrontacao)
    {
        $this->codConfrontacao = $codConfrontacao;
        return $this;
    }

    /**
     * Get codConfrontacao
     *
     * @return integer
     */
    public function getCodConfrontacao()
    {
        return $this->codConfrontacao;
    }

    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return Confrontacao
     */
    public function setCodLote($codLote)
    {
        $this->codLote = $codLote;
        return $this;
    }

    /**
     * Get codLote
     *
     * @return integer
     */
    public function getCodLote()
    {
        return $this->codLote;
    }

    /**
     * Set codPonto
     *
     * @param integer $codPonto
     * @return Confrontacao
     */
    public function setCodPonto($codPonto)
    {
        $this->codPonto = $codPonto;
        return $this;
    }

    /**
     * Get codPonto
     *
     * @return integer
     */
    public function getCodPonto()
    {
        return $this->codPonto;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioConfrontacaoExtensao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoExtensao $fkImobiliarioConfrontacaoExtensao
     * @return Confrontacao
     */
    public function addFkImobiliarioConfrontacaoExtensoes(\Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoExtensao $fkImobiliarioConfrontacaoExtensao)
    {
        if (false === $this->fkImobiliarioConfrontacaoExtensoes->contains($fkImobiliarioConfrontacaoExtensao)) {
            $fkImobiliarioConfrontacaoExtensao->setFkImobiliarioConfrontacao($this);
            $this->fkImobiliarioConfrontacaoExtensoes->add($fkImobiliarioConfrontacaoExtensao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioConfrontacaoExtensao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoExtensao $fkImobiliarioConfrontacaoExtensao
     */
    public function removeFkImobiliarioConfrontacaoExtensoes(\Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoExtensao $fkImobiliarioConfrontacaoExtensao)
    {
        $this->fkImobiliarioConfrontacaoExtensoes->removeElement($fkImobiliarioConfrontacaoExtensao);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioConfrontacaoExtensoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoExtensao
     */
    public function getFkImobiliarioConfrontacaoExtensoes()
    {
        return $this->fkImobiliarioConfrontacaoExtensoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioLote
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Lote $fkImobiliarioLote
     * @return Confrontacao
     */
    public function setFkImobiliarioLote(\Urbem\CoreBundle\Entity\Imobiliario\Lote $fkImobiliarioLote)
    {
        $this->codLote = $fkImobiliarioLote->getCodLote();
        $this->fkImobiliarioLote = $fkImobiliarioLote;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioLote
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Lote
     */
    public function getFkImobiliarioLote()
    {
        return $this->fkImobiliarioLote;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioPontoCardeal
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\PontoCardeal $fkImobiliarioPontoCardeal
     * @return Confrontacao
     */
    public function setFkImobiliarioPontoCardeal(\Urbem\CoreBundle\Entity\Imobiliario\PontoCardeal $fkImobiliarioPontoCardeal)
    {
        $this->codPonto = $fkImobiliarioPontoCardeal->getCodPonto();
        $this->fkImobiliarioPontoCardeal = $fkImobiliarioPontoCardeal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioPontoCardeal
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\PontoCardeal
     */
    public function getFkImobiliarioPontoCardeal()
    {
        return $this->fkImobiliarioPontoCardeal;
    }

    /**
     * OneToOne (inverse side)
     * Set ImobiliarioConfrontacaoTrecho
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoTrecho $fkImobiliarioConfrontacaoTrecho
     * @return Confrontacao
     */
    public function setFkImobiliarioConfrontacaoTrecho(\Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoTrecho $fkImobiliarioConfrontacaoTrecho)
    {
        $fkImobiliarioConfrontacaoTrecho->setFkImobiliarioConfrontacao($this);
        $this->fkImobiliarioConfrontacaoTrecho = $fkImobiliarioConfrontacaoTrecho;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkImobiliarioConfrontacaoTrecho
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoTrecho
     */
    public function getFkImobiliarioConfrontacaoTrecho()
    {
        return $this->fkImobiliarioConfrontacaoTrecho;
    }

    /**
     * OneToOne (inverse side)
     * Set ImobiliarioConfrontacaoLote
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoLote $fkImobiliarioConfrontacaoLote
     * @return Confrontacao
     */
    public function setFkImobiliarioConfrontacaoLote(\Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoLote $fkImobiliarioConfrontacaoLote)
    {
        $fkImobiliarioConfrontacaoLote->setFkImobiliarioConfrontacao($this);
        $this->fkImobiliarioConfrontacaoLote = $fkImobiliarioConfrontacaoLote;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkImobiliarioConfrontacaoLote
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoLote
     */
    public function getFkImobiliarioConfrontacaoLote()
    {
        return $this->fkImobiliarioConfrontacaoLote;
    }

    /**
     * OneToOne (inverse side)
     * Set ImobiliarioConfrontacaoDiversa
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoDiversa $fkImobiliarioConfrontacaoDiversa
     * @return Confrontacao
     */
    public function setFkImobiliarioConfrontacaoDiversa(\Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoDiversa $fkImobiliarioConfrontacaoDiversa)
    {
        $fkImobiliarioConfrontacaoDiversa->setFkImobiliarioConfrontacao($this);
        $this->fkImobiliarioConfrontacaoDiversa = $fkImobiliarioConfrontacaoDiversa;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkImobiliarioConfrontacaoDiversa
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoDiversa
     */
    public function getFkImobiliarioConfrontacaoDiversa()
    {
        return $this->fkImobiliarioConfrontacaoDiversa;
    }
}
