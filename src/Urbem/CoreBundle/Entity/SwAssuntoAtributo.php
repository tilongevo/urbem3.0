<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwAssuntoAtributo
 */
class SwAssuntoAtributo
{
    /**
     * PK
     * @var integer
     */
    private $codAtributo;

    /**
     * PK
     * @var integer
     */
    private $codAssunto;

    /**
     * PK
     * @var integer
     */
    private $codClassificacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwAssuntoAtributoValor
     */
    private $fkSwAssuntoAtributoValores;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwAtributoProtocolo
     */
    private $fkSwAtributoProtocolo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwAssunto
     */
    private $fkSwAssunto;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkSwAssuntoAtributoValores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return SwAssuntoAtributo
     */
    public function setCodAtributo($codAtributo)
    {
        $this->codAtributo = $codAtributo;
        return $this;
    }

    /**
     * Get codAtributo
     *
     * @return integer
     */
    public function getCodAtributo()
    {
        return $this->codAtributo;
    }

    /**
     * Set codAssunto
     *
     * @param integer $codAssunto
     * @return SwAssuntoAtributo
     */
    public function setCodAssunto($codAssunto)
    {
        $this->codAssunto = $codAssunto;
        return $this;
    }

    /**
     * Get codAssunto
     *
     * @return integer
     */
    public function getCodAssunto()
    {
        return $this->codAssunto;
    }

    /**
     * Set codClassificacao
     *
     * @param integer $codClassificacao
     * @return SwAssuntoAtributo
     */
    public function setCodClassificacao($codClassificacao)
    {
        $this->codClassificacao = $codClassificacao;
        return $this;
    }

    /**
     * Get codClassificacao
     *
     * @return integer
     */
    public function getCodClassificacao()
    {
        return $this->codClassificacao;
    }

    /**
     * OneToMany (owning side)
     * Add SwAssuntoAtributoValor
     *
     * @param \Urbem\CoreBundle\Entity\SwAssuntoAtributoValor $fkSwAssuntoAtributoValor
     * @return SwAssuntoAtributo
     */
    public function addFkSwAssuntoAtributoValores(\Urbem\CoreBundle\Entity\SwAssuntoAtributoValor $fkSwAssuntoAtributoValor)
    {
        if (false === $this->fkSwAssuntoAtributoValores->contains($fkSwAssuntoAtributoValor)) {
            $fkSwAssuntoAtributoValor->setFkSwAssuntoAtributo($this);
            $this->fkSwAssuntoAtributoValores->add($fkSwAssuntoAtributoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwAssuntoAtributoValor
     *
     * @param \Urbem\CoreBundle\Entity\SwAssuntoAtributoValor $fkSwAssuntoAtributoValor
     */
    public function removeFkSwAssuntoAtributoValores(\Urbem\CoreBundle\Entity\SwAssuntoAtributoValor $fkSwAssuntoAtributoValor)
    {
        $this->fkSwAssuntoAtributoValores->removeElement($fkSwAssuntoAtributoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwAssuntoAtributoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwAssuntoAtributoValor
     */
    public function getFkSwAssuntoAtributoValores()
    {
        return $this->fkSwAssuntoAtributoValores;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwAtributoProtocolo
     *
     * @param \Urbem\CoreBundle\Entity\SwAtributoProtocolo $fkSwAtributoProtocolo
     * @return SwAssuntoAtributo
     */
    public function setFkSwAtributoProtocolo(\Urbem\CoreBundle\Entity\SwAtributoProtocolo $fkSwAtributoProtocolo)
    {
        $this->codAtributo = $fkSwAtributoProtocolo->getCodAtributo();
        $this->fkSwAtributoProtocolo = $fkSwAtributoProtocolo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwAtributoProtocolo
     *
     * @return \Urbem\CoreBundle\Entity\SwAtributoProtocolo
     */
    public function getFkSwAtributoProtocolo()
    {
        return $this->fkSwAtributoProtocolo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwAssunto
     *
     * @param \Urbem\CoreBundle\Entity\SwAssunto $fkSwAssunto
     * @return SwAssuntoAtributo
     */
    public function setFkSwAssunto(\Urbem\CoreBundle\Entity\SwAssunto $fkSwAssunto)
    {
        $this->codAssunto = $fkSwAssunto->getCodAssunto();
        $this->codClassificacao = $fkSwAssunto->getCodClassificacao();
        $this->fkSwAssunto = $fkSwAssunto;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwAssunto
     *
     * @return \Urbem\CoreBundle\Entity\SwAssunto
     */
    public function getFkSwAssunto()
    {
        return $this->fkSwAssunto;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->fkSwAtributoProtocolo;
    }
}
