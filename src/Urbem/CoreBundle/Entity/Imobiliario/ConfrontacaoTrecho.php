<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * ConfrontacaoTrecho
 */
class ConfrontacaoTrecho
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
    private $codTrecho;

    /**
     * @var integer
     */
    private $codLogradouro;

    /**
     * @var boolean
     */
    private $principal = false;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Confrontacao
     */
    private $fkImobiliarioConfrontacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ImovelConfrontacao
     */
    private $fkImobiliarioImovelConfrontacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Trecho
     */
    private $fkImobiliarioTrecho;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImobiliarioImovelConfrontacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codConfrontacao
     *
     * @param integer $codConfrontacao
     * @return ConfrontacaoTrecho
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
     * @return ConfrontacaoTrecho
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
     * Set codTrecho
     *
     * @param integer $codTrecho
     * @return ConfrontacaoTrecho
     */
    public function setCodTrecho($codTrecho)
    {
        $this->codTrecho = $codTrecho;
        return $this;
    }

    /**
     * Get codTrecho
     *
     * @return integer
     */
    public function getCodTrecho()
    {
        return $this->codTrecho;
    }

    /**
     * Set codLogradouro
     *
     * @param integer $codLogradouro
     * @return ConfrontacaoTrecho
     */
    public function setCodLogradouro($codLogradouro)
    {
        $this->codLogradouro = $codLogradouro;
        return $this;
    }

    /**
     * Get codLogradouro
     *
     * @return integer
     */
    public function getCodLogradouro()
    {
        return $this->codLogradouro;
    }

    /**
     * Set principal
     *
     * @param boolean $principal
     * @return ConfrontacaoTrecho
     */
    public function setPrincipal($principal)
    {
        $this->principal = $principal;
        return $this;
    }

    /**
     * Get principal
     *
     * @return boolean
     */
    public function getPrincipal()
    {
        return $this->principal;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioImovelConfrontacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ImovelConfrontacao $fkImobiliarioImovelConfrontacao
     * @return ConfrontacaoTrecho
     */
    public function addFkImobiliarioImovelConfrontacoes(\Urbem\CoreBundle\Entity\Imobiliario\ImovelConfrontacao $fkImobiliarioImovelConfrontacao)
    {
        if (false === $this->fkImobiliarioImovelConfrontacoes->contains($fkImobiliarioImovelConfrontacao)) {
            $fkImobiliarioImovelConfrontacao->setFkImobiliarioConfrontacaoTrecho($this);
            $this->fkImobiliarioImovelConfrontacoes->add($fkImobiliarioImovelConfrontacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioImovelConfrontacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ImovelConfrontacao $fkImobiliarioImovelConfrontacao
     */
    public function removeFkImobiliarioImovelConfrontacoes(\Urbem\CoreBundle\Entity\Imobiliario\ImovelConfrontacao $fkImobiliarioImovelConfrontacao)
    {
        $this->fkImobiliarioImovelConfrontacoes->removeElement($fkImobiliarioImovelConfrontacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioImovelConfrontacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ImovelConfrontacao
     */
    public function getFkImobiliarioImovelConfrontacoes()
    {
        return $this->fkImobiliarioImovelConfrontacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioTrecho
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Trecho $fkImobiliarioTrecho
     * @return ConfrontacaoTrecho
     */
    public function setFkImobiliarioTrecho(\Urbem\CoreBundle\Entity\Imobiliario\Trecho $fkImobiliarioTrecho)
    {
        $this->codTrecho = $fkImobiliarioTrecho->getCodTrecho();
        $this->codLogradouro = $fkImobiliarioTrecho->getCodLogradouro();
        $this->fkImobiliarioTrecho = $fkImobiliarioTrecho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioTrecho
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Trecho
     */
    public function getFkImobiliarioTrecho()
    {
        return $this->fkImobiliarioTrecho;
    }

    /**
     * OneToOne (owning side)
     * Set ImobiliarioConfrontacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Confrontacao $fkImobiliarioConfrontacao
     * @return ConfrontacaoTrecho
     */
    public function setFkImobiliarioConfrontacao(\Urbem\CoreBundle\Entity\Imobiliario\Confrontacao $fkImobiliarioConfrontacao)
    {
        $this->codConfrontacao = $fkImobiliarioConfrontacao->getCodConfrontacao();
        $this->codLote = $fkImobiliarioConfrontacao->getCodLote();
        $this->fkImobiliarioConfrontacao = $fkImobiliarioConfrontacao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkImobiliarioConfrontacao
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Confrontacao
     */
    public function getFkImobiliarioConfrontacao()
    {
        return $this->fkImobiliarioConfrontacao;
    }
}
