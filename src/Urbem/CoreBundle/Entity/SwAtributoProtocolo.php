<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwAtributoProtocolo
 */
class SwAtributoProtocolo
{
    /**
     * PK
     * @var integer
     */
    private $codAtributo;

    /**
     * @var string
     */
    private $nomAtributo;

    /**
     * @var string
     */
    private $tipo;

    /**
     * @var string
     */
    private $valorPadrao;

    /**
     * @var boolean
     */
    private $obrigatorio = false;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\SwProcessoAtributo
     */
    private $fkSwProcessoAtributo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwProcessoAtributoValor
     */
    private $fkSwProcessoAtributoValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwAssuntoAtributo
     */
    private $fkSwAssuntoAtributos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkSwProcessoAtributoValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwAssuntoAtributos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return SwAtributoProtocolo
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
     * Set nomAtributo
     *
     * @param string $nomAtributo
     * @return SwAtributoProtocolo
     */
    public function setNomAtributo($nomAtributo)
    {
        $this->nomAtributo = $nomAtributo;
        return $this;
    }

    /**
     * Get nomAtributo
     *
     * @return string
     */
    public function getNomAtributo()
    {
        return $this->nomAtributo;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return SwAtributoProtocolo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set valorPadrao
     *
     * @param string $valorPadrao
     * @return SwAtributoProtocolo
     */
    public function setValorPadrao($valorPadrao)
    {
        $this->valorPadrao = $valorPadrao;
        return $this;
    }

    /**
     * Get valorPadrao
     *
     * @return string
     */
    public function getValorPadrao()
    {
        return $this->valorPadrao;
    }

    /**
     * Set obrigatorio
     *
     * @param boolean $obrigatorio
     * @return SwAtributoProtocolo
     */
    public function setObrigatorio($obrigatorio)
    {
        $this->obrigatorio = $obrigatorio;
        return $this;
    }

    /**
     * Get obrigatorio
     *
     * @return boolean
     */
    public function getObrigatorio()
    {
        return $this->obrigatorio;
    }

    /**
     * OneToMany (owning side)
     * Add SwProcessoAtributoValor
     *
     * @param \Urbem\CoreBundle\Entity\SwProcessoAtributoValor $fkSwProcessoAtributoValor
     * @return SwAtributoProtocolo
     */
    public function addFkSwProcessoAtributoValores(\Urbem\CoreBundle\Entity\SwProcessoAtributoValor $fkSwProcessoAtributoValor)
    {
        if (false === $this->fkSwProcessoAtributoValores->contains($fkSwProcessoAtributoValor)) {
            $fkSwProcessoAtributoValor->setFkSwAtributoProtocolo($this);
            $this->fkSwProcessoAtributoValores->add($fkSwProcessoAtributoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwProcessoAtributoValor
     *
     * @param \Urbem\CoreBundle\Entity\SwProcessoAtributoValor $fkSwProcessoAtributoValor
     */
    public function removeFkSwProcessoAtributoValores(\Urbem\CoreBundle\Entity\SwProcessoAtributoValor $fkSwProcessoAtributoValor)
    {
        $this->fkSwProcessoAtributoValores->removeElement($fkSwProcessoAtributoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwProcessoAtributoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwProcessoAtributoValor
     */
    public function getFkSwProcessoAtributoValores()
    {
        return $this->fkSwProcessoAtributoValores;
    }

    /**
     * OneToMany (owning side)
     * Add SwAssuntoAtributo
     *
     * @param \Urbem\CoreBundle\Entity\SwAssuntoAtributo $fkSwAssuntoAtributo
     * @return SwAtributoProtocolo
     */
    public function addFkSwAssuntoAtributos(\Urbem\CoreBundle\Entity\SwAssuntoAtributo $fkSwAssuntoAtributo)
    {
        if (false === $this->fkSwAssuntoAtributos->contains($fkSwAssuntoAtributo)) {
            $fkSwAssuntoAtributo->setFkSwAtributoProtocolo($this);
            $this->fkSwAssuntoAtributos->add($fkSwAssuntoAtributo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwAssuntoAtributo
     *
     * @param \Urbem\CoreBundle\Entity\SwAssuntoAtributo $fkSwAssuntoAtributo
     */
    public function removeFkSwAssuntoAtributos(\Urbem\CoreBundle\Entity\SwAssuntoAtributo $fkSwAssuntoAtributo)
    {
        $this->fkSwAssuntoAtributos->removeElement($fkSwAssuntoAtributo);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwAssuntoAtributos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwAssuntoAtributo
     */
    public function getFkSwAssuntoAtributos()
    {
        return $this->fkSwAssuntoAtributos;
    }

    /**
     * OneToOne (inverse side)
     * Set SwProcessoAtributo
     *
     * @param \Urbem\CoreBundle\Entity\SwProcessoAtributo $fkSwProcessoAtributo
     * @return SwAtributoProtocolo
     */
    public function setFkSwProcessoAtributo(\Urbem\CoreBundle\Entity\SwProcessoAtributo $fkSwProcessoAtributo)
    {
        $fkSwProcessoAtributo->setFkSwAtributoProtocolo($this);
        $this->fkSwProcessoAtributo = $fkSwProcessoAtributo;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkSwProcessoAtributo
     *
     * @return \Urbem\CoreBundle\Entity\SwProcessoAtributo
     */
    public function getFkSwProcessoAtributo()
    {
        return $this->fkSwProcessoAtributo;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->nomAtributo;
    }
}
