<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * FaceQuadra
 */
class FaceQuadra
{
    /**
     * PK
     * @var integer
     */
    private $codFace;

    /**
     * PK
     * @var integer
     */
    private $codLocalizacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoFaceQuadraValor
     */
    private $fkImobiliarioAtributoFaceQuadraValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\BaixaFaceQuadra
     */
    private $fkImobiliarioBaixaFaceQuadras;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraTrecho
     */
    private $fkImobiliarioFaceQuadraTrechos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraAliquota
     */
    private $fkImobiliarioFaceQuadraAliquotas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraValorM2
     */
    private $fkImobiliarioFaceQuadraValorM2s;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Localizacao
     */
    private $fkImobiliarioLocalizacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImobiliarioAtributoFaceQuadraValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioBaixaFaceQuadras = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioFaceQuadraTrechos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioFaceQuadraAliquotas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioFaceQuadraValorM2s = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codFace
     *
     * @param integer $codFace
     * @return FaceQuadra
     */
    public function setCodFace($codFace)
    {
        $this->codFace = $codFace;
        return $this;
    }

    /**
     * Get codFace
     *
     * @return integer
     */
    public function getCodFace()
    {
        return $this->codFace;
    }

    /**
     * Set codLocalizacao
     *
     * @param integer $codLocalizacao
     * @return FaceQuadra
     */
    public function setCodLocalizacao($codLocalizacao)
    {
        $this->codLocalizacao = $codLocalizacao;
        return $this;
    }

    /**
     * Get codLocalizacao
     *
     * @return integer
     */
    public function getCodLocalizacao()
    {
        return $this->codLocalizacao;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioAtributoFaceQuadraValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoFaceQuadraValor $fkImobiliarioAtributoFaceQuadraValor
     * @return FaceQuadra
     */
    public function addFkImobiliarioAtributoFaceQuadraValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoFaceQuadraValor $fkImobiliarioAtributoFaceQuadraValor)
    {
        if (false === $this->fkImobiliarioAtributoFaceQuadraValores->contains($fkImobiliarioAtributoFaceQuadraValor)) {
            $fkImobiliarioAtributoFaceQuadraValor->setFkImobiliarioFaceQuadra($this);
            $this->fkImobiliarioAtributoFaceQuadraValores->add($fkImobiliarioAtributoFaceQuadraValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioAtributoFaceQuadraValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoFaceQuadraValor $fkImobiliarioAtributoFaceQuadraValor
     */
    public function removeFkImobiliarioAtributoFaceQuadraValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoFaceQuadraValor $fkImobiliarioAtributoFaceQuadraValor)
    {
        $this->fkImobiliarioAtributoFaceQuadraValores->removeElement($fkImobiliarioAtributoFaceQuadraValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioAtributoFaceQuadraValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoFaceQuadraValor
     */
    public function getFkImobiliarioAtributoFaceQuadraValores()
    {
        return $this->fkImobiliarioAtributoFaceQuadraValores;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioBaixaFaceQuadra
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\BaixaFaceQuadra $fkImobiliarioBaixaFaceQuadra
     * @return FaceQuadra
     */
    public function addFkImobiliarioBaixaFaceQuadras(\Urbem\CoreBundle\Entity\Imobiliario\BaixaFaceQuadra $fkImobiliarioBaixaFaceQuadra)
    {
        if (false === $this->fkImobiliarioBaixaFaceQuadras->contains($fkImobiliarioBaixaFaceQuadra)) {
            $fkImobiliarioBaixaFaceQuadra->setFkImobiliarioFaceQuadra($this);
            $this->fkImobiliarioBaixaFaceQuadras->add($fkImobiliarioBaixaFaceQuadra);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioBaixaFaceQuadra
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\BaixaFaceQuadra $fkImobiliarioBaixaFaceQuadra
     */
    public function removeFkImobiliarioBaixaFaceQuadras(\Urbem\CoreBundle\Entity\Imobiliario\BaixaFaceQuadra $fkImobiliarioBaixaFaceQuadra)
    {
        $this->fkImobiliarioBaixaFaceQuadras->removeElement($fkImobiliarioBaixaFaceQuadra);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioBaixaFaceQuadras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\BaixaFaceQuadra
     */
    public function getFkImobiliarioBaixaFaceQuadras()
    {
        return $this->fkImobiliarioBaixaFaceQuadras;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioFaceQuadraTrecho
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraTrecho $fkImobiliarioFaceQuadraTrecho
     * @return FaceQuadra
     */
    public function addFkImobiliarioFaceQuadraTrechos(\Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraTrecho $fkImobiliarioFaceQuadraTrecho)
    {
        if (false === $this->fkImobiliarioFaceQuadraTrechos->contains($fkImobiliarioFaceQuadraTrecho)) {
            $fkImobiliarioFaceQuadraTrecho->setFkImobiliarioFaceQuadra($this);
            $this->fkImobiliarioFaceQuadraTrechos->add($fkImobiliarioFaceQuadraTrecho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioFaceQuadraTrecho
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraTrecho $fkImobiliarioFaceQuadraTrecho
     */
    public function removeFkImobiliarioFaceQuadraTrechos(\Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraTrecho $fkImobiliarioFaceQuadraTrecho)
    {
        $this->fkImobiliarioFaceQuadraTrechos->removeElement($fkImobiliarioFaceQuadraTrecho);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioFaceQuadraTrechos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraTrecho
     */
    public function getFkImobiliarioFaceQuadraTrechos()
    {
        return $this->fkImobiliarioFaceQuadraTrechos;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioFaceQuadraAliquota
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraAliquota $fkImobiliarioFaceQuadraAliquota
     * @return FaceQuadra
     */
    public function addFkImobiliarioFaceQuadraAliquotas(\Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraAliquota $fkImobiliarioFaceQuadraAliquota)
    {
        if (false === $this->fkImobiliarioFaceQuadraAliquotas->contains($fkImobiliarioFaceQuadraAliquota)) {
            $fkImobiliarioFaceQuadraAliquota->setFkImobiliarioFaceQuadra($this);
            $this->fkImobiliarioFaceQuadraAliquotas->add($fkImobiliarioFaceQuadraAliquota);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioFaceQuadraAliquota
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraAliquota $fkImobiliarioFaceQuadraAliquota
     */
    public function removeFkImobiliarioFaceQuadraAliquotas(\Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraAliquota $fkImobiliarioFaceQuadraAliquota)
    {
        $this->fkImobiliarioFaceQuadraAliquotas->removeElement($fkImobiliarioFaceQuadraAliquota);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioFaceQuadraAliquotas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraAliquota
     */
    public function getFkImobiliarioFaceQuadraAliquotas()
    {
        return $this->fkImobiliarioFaceQuadraAliquotas;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioFaceQuadraValorM2
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraValorM2 $fkImobiliarioFaceQuadraValorM2
     * @return FaceQuadra
     */
    public function addFkImobiliarioFaceQuadraValorM2s(\Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraValorM2 $fkImobiliarioFaceQuadraValorM2)
    {
        if (false === $this->fkImobiliarioFaceQuadraValorM2s->contains($fkImobiliarioFaceQuadraValorM2)) {
            $fkImobiliarioFaceQuadraValorM2->setFkImobiliarioFaceQuadra($this);
            $this->fkImobiliarioFaceQuadraValorM2s->add($fkImobiliarioFaceQuadraValorM2);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioFaceQuadraValorM2
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraValorM2 $fkImobiliarioFaceQuadraValorM2
     */
    public function removeFkImobiliarioFaceQuadraValorM2s(\Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraValorM2 $fkImobiliarioFaceQuadraValorM2)
    {
        $this->fkImobiliarioFaceQuadraValorM2s->removeElement($fkImobiliarioFaceQuadraValorM2);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioFaceQuadraValorM2s
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraValorM2
     */
    public function getFkImobiliarioFaceQuadraValorM2s()
    {
        return $this->fkImobiliarioFaceQuadraValorM2s;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioLocalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Localizacao $fkImobiliarioLocalizacao
     * @return FaceQuadra
     */
    public function setFkImobiliarioLocalizacao(\Urbem\CoreBundle\Entity\Imobiliario\Localizacao $fkImobiliarioLocalizacao)
    {
        $this->codLocalizacao = $fkImobiliarioLocalizacao->getCodLocalizacao();
        $this->fkImobiliarioLocalizacao = $fkImobiliarioLocalizacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioLocalizacao
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Localizacao
     */
    public function getFkImobiliarioLocalizacao()
    {
        return $this->fkImobiliarioLocalizacao;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return ($this->fkImobiliarioLocalizacao)
            ? sprintf('%s - %s', $this->codFace, $this->fkImobiliarioLocalizacao->getCodigoComposto())
            : (string) $this->codFace;
    }
}
