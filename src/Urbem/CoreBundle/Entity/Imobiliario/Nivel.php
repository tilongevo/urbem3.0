<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * Nivel
 */
class Nivel
{
    /**
     * PK
     * @var integer
     */
    private $codNivel;

    /**
     * PK
     * @var integer
     */
    private $codVigencia;

    /**
     * @var string
     */
    private $nomNivel;

    /**
     * @var string
     */
    private $mascara;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoNivel
     */
    private $fkImobiliarioLocalizacaoNiveis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoNivel
     */
    private $fkImobiliarioAtributoNiveis;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Vigencia
     */
    private $fkImobiliarioVigencia;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImobiliarioLocalizacaoNiveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioAtributoNiveis = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codNivel
     *
     * @param integer $codNivel
     * @return Nivel
     */
    public function setCodNivel($codNivel)
    {
        $this->codNivel = $codNivel;
        return $this;
    }

    /**
     * Get codNivel
     *
     * @return integer
     */
    public function getCodNivel()
    {
        return $this->codNivel;
    }

    /**
     * Set codVigencia
     *
     * @param integer $codVigencia
     * @return Nivel
     */
    public function setCodVigencia($codVigencia)
    {
        $this->codVigencia = $codVigencia;
        return $this;
    }

    /**
     * Get codVigencia
     *
     * @return integer
     */
    public function getCodVigencia()
    {
        return $this->codVigencia;
    }

    /**
     * Set nomNivel
     *
     * @param string $nomNivel
     * @return Nivel
     */
    public function setNomNivel($nomNivel)
    {
        $this->nomNivel = $nomNivel;
        return $this;
    }

    /**
     * Get nomNivel
     *
     * @return string
     */
    public function getNomNivel()
    {
        return $this->nomNivel;
    }

    /**
     * Set mascara
     *
     * @param string $mascara
     * @return Nivel
     */
    public function setMascara($mascara)
    {
        $this->mascara = $mascara;
        return $this;
    }

    /**
     * Get mascara
     *
     * @return string
     */
    public function getMascara()
    {
        return $this->mascara;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLocalizacaoNivel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoNivel $fkImobiliarioLocalizacaoNivel
     * @return Nivel
     */
    public function addFkImobiliarioLocalizacaoNiveis(\Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoNivel $fkImobiliarioLocalizacaoNivel)
    {
        if (false === $this->fkImobiliarioLocalizacaoNiveis->contains($fkImobiliarioLocalizacaoNivel)) {
            $fkImobiliarioLocalizacaoNivel->setFkImobiliarioNivel($this);
            $this->fkImobiliarioLocalizacaoNiveis->add($fkImobiliarioLocalizacaoNivel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioLocalizacaoNivel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoNivel $fkImobiliarioLocalizacaoNivel
     */
    public function removeFkImobiliarioLocalizacaoNiveis(\Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoNivel $fkImobiliarioLocalizacaoNivel)
    {
        $this->fkImobiliarioLocalizacaoNiveis->removeElement($fkImobiliarioLocalizacaoNivel);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioLocalizacaoNiveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoNivel
     */
    public function getFkImobiliarioLocalizacaoNiveis()
    {
        return $this->fkImobiliarioLocalizacaoNiveis;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioAtributoNivel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoNivel $fkImobiliarioAtributoNivel
     * @return Nivel
     */
    public function addFkImobiliarioAtributoNiveis(\Urbem\CoreBundle\Entity\Imobiliario\AtributoNivel $fkImobiliarioAtributoNivel)
    {
        if (false === $this->fkImobiliarioAtributoNiveis->contains($fkImobiliarioAtributoNivel)) {
            $fkImobiliarioAtributoNivel->setFkImobiliarioNivel($this);
            $this->fkImobiliarioAtributoNiveis->add($fkImobiliarioAtributoNivel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioAtributoNivel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoNivel $fkImobiliarioAtributoNivel
     */
    public function removeFkImobiliarioAtributoNiveis(\Urbem\CoreBundle\Entity\Imobiliario\AtributoNivel $fkImobiliarioAtributoNivel)
    {
        $this->fkImobiliarioAtributoNiveis->removeElement($fkImobiliarioAtributoNivel);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioAtributoNiveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoNivel
     */
    public function getFkImobiliarioAtributoNiveis()
    {
        return $this->fkImobiliarioAtributoNiveis;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioVigencia
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Vigencia $fkImobiliarioVigencia
     * @return Nivel
     */
    public function setFkImobiliarioVigencia(\Urbem\CoreBundle\Entity\Imobiliario\Vigencia $fkImobiliarioVigencia)
    {
        $this->codVigencia = $fkImobiliarioVigencia->getCodVigencia();
        $this->fkImobiliarioVigencia = $fkImobiliarioVigencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioVigencia
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Vigencia
     */
    public function getFkImobiliarioVigencia()
    {
        return $this->fkImobiliarioVigencia;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->nomNivel;
    }
}
