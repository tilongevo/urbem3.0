<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwAtributoCgm
 */
class SwAtributoCgm
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
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgaAtributoValor
     */
    private $fkSwCgaAtributoValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgmAtributoValor
     */
    private $fkSwCgmAtributoValores;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkSwCgaAtributoValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwCgmAtributoValores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return SwAtributoCgm
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
     * @return SwAtributoCgm
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
     * @return SwAtributoCgm
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
     * @return SwAtributoCgm
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
     * OneToMany (owning side)
     * Add SwCgaAtributoValor
     *
     * @param \Urbem\CoreBundle\Entity\SwCgaAtributoValor $fkSwCgaAtributoValor
     * @return SwAtributoCgm
     */
    public function addFkSwCgaAtributoValores(\Urbem\CoreBundle\Entity\SwCgaAtributoValor $fkSwCgaAtributoValor)
    {
        if (false === $this->fkSwCgaAtributoValores->contains($fkSwCgaAtributoValor)) {
            $fkSwCgaAtributoValor->setFkSwAtributoCgm($this);
            $this->fkSwCgaAtributoValores->add($fkSwCgaAtributoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwCgaAtributoValor
     *
     * @param \Urbem\CoreBundle\Entity\SwCgaAtributoValor $fkSwCgaAtributoValor
     */
    public function removeFkSwCgaAtributoValores(\Urbem\CoreBundle\Entity\SwCgaAtributoValor $fkSwCgaAtributoValor)
    {
        $this->fkSwCgaAtributoValores->removeElement($fkSwCgaAtributoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwCgaAtributoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgaAtributoValor
     */
    public function getFkSwCgaAtributoValores()
    {
        return $this->fkSwCgaAtributoValores;
    }

    /**
     * OneToMany (owning side)
     * Add SwCgmAtributoValor
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmAtributoValor $fkSwCgmAtributoValor
     * @return SwAtributoCgm
     */
    public function addFkSwCgmAtributoValores(\Urbem\CoreBundle\Entity\SwCgmAtributoValor $fkSwCgmAtributoValor)
    {
        if (false === $this->fkSwCgmAtributoValores->contains($fkSwCgmAtributoValor)) {
            $fkSwCgmAtributoValor->setFkSwAtributoCgm($this);
            $this->fkSwCgmAtributoValores->add($fkSwCgmAtributoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwCgmAtributoValor
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmAtributoValor $fkSwCgmAtributoValor
     */
    public function removeFkSwCgmAtributoValores(\Urbem\CoreBundle\Entity\SwCgmAtributoValor $fkSwCgmAtributoValor)
    {
        $this->fkSwCgmAtributoValores->removeElement($fkSwCgmAtributoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwCgmAtributoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwCgmAtributoValor
     */
    public function getFkSwCgmAtributoValores()
    {
        return $this->fkSwCgmAtributoValores;
    }

    /**
     * @return string|null
     */
    public function getValorFormatado()
    {
        $formatado = ['t' => 'Texto', 'n' => 'Número', 'l' => 'Lista'];

        if (true === array_key_exists($this->tipo, $formatado)) {
            return $formatado[$this->tipo];
        }

        return null;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->nomAtributo;
    }
}
