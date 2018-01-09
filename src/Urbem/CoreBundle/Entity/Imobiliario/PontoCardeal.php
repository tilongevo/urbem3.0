<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * PontoCardeal
 */
class PontoCardeal
{
    /**
     * PK
     * @var integer
     */
    private $codPonto;

    /**
     * @var integer
     */
    private $codPontoOposto;

    /**
     * @var string
     */
    private $nomPonto;

    /**
     * @var string
     */
    private $sigla;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\Confrontacao
     */
    private $fkImobiliarioConfrontacoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImobiliarioConfrontacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codPonto
     *
     * @param integer $codPonto
     * @return PontoCardeal
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
     * Set codPontoOposto
     *
     * @param integer $codPontoOposto
     * @return PontoCardeal
     */
    public function setCodPontoOposto($codPontoOposto)
    {
        $this->codPontoOposto = $codPontoOposto;
        return $this;
    }

    /**
     * Get codPontoOposto
     *
     * @return integer
     */
    public function getCodPontoOposto()
    {
        return $this->codPontoOposto;
    }

    /**
     * Set nomPonto
     *
     * @param string $nomPonto
     * @return PontoCardeal
     */
    public function setNomPonto($nomPonto)
    {
        $this->nomPonto = $nomPonto;
        return $this;
    }

    /**
     * Get nomPonto
     *
     * @return string
     */
    public function getNomPonto()
    {
        return $this->nomPonto;
    }

    /**
     * Set sigla
     *
     * @param string $sigla
     * @return PontoCardeal
     */
    public function setSigla($sigla)
    {
        $this->sigla = $sigla;
        return $this;
    }

    /**
     * Get sigla
     *
     * @return string
     */
    public function getSigla()
    {
        return $this->sigla;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioConfrontacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Confrontacao $fkImobiliarioConfrontacao
     * @return PontoCardeal
     */
    public function addFkImobiliarioConfrontacoes(\Urbem\CoreBundle\Entity\Imobiliario\Confrontacao $fkImobiliarioConfrontacao)
    {
        if (false === $this->fkImobiliarioConfrontacoes->contains($fkImobiliarioConfrontacao)) {
            $fkImobiliarioConfrontacao->setFkImobiliarioPontoCardeal($this);
            $this->fkImobiliarioConfrontacoes->add($fkImobiliarioConfrontacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioConfrontacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Confrontacao $fkImobiliarioConfrontacao
     */
    public function removeFkImobiliarioConfrontacoes(\Urbem\CoreBundle\Entity\Imobiliario\Confrontacao $fkImobiliarioConfrontacao)
    {
        $this->fkImobiliarioConfrontacoes->removeElement($fkImobiliarioConfrontacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioConfrontacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\Confrontacao
     */
    public function getFkImobiliarioConfrontacoes()
    {
        return $this->fkImobiliarioConfrontacoes;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->nomPonto;
    }
}
