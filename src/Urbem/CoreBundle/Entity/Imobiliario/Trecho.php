<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * Trecho
 */
class Trecho
{
    /**
     * PK
     * @var integer
     */
    private $codTrecho;

    /**
     * PK
     * @var integer
     */
    private $codLogradouro;

    /**
     * @var integer
     */
    private $sequencia;

    /**
     * @var integer
     */
    private $extensao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\BaixaTrecho
     */
    private $fkImobiliarioBaixaTrechos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoTrechoValor
     */
    private $fkImobiliarioAtributoTrechoValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoTrecho
     */
    private $fkImobiliarioConfrontacaoTrechos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraTrecho
     */
    private $fkImobiliarioFaceQuadraTrechos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\TrechoValorM2
     */
    private $fkImobiliarioTrechoValorM2s;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\TrechoAliquota
     */
    private $fkImobiliarioTrechoAliquotas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwLogradouro
     */
    private $fkSwLogradouro;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImobiliarioBaixaTrechos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioAtributoTrechoValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioConfrontacaoTrechos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioFaceQuadraTrechos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioTrechoValorM2s = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioTrechoAliquotas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTrecho
     *
     * @param integer $codTrecho
     * @return Trecho
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
     * @return Trecho
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
     * Set sequencia
     *
     * @param integer $sequencia
     * @return Trecho
     */
    public function setSequencia($sequencia)
    {
        $this->sequencia = $sequencia;
        return $this;
    }

    /**
     * Get sequencia
     *
     * @return integer
     */
    public function getSequencia()
    {
        return $this->sequencia;
    }

    /**
     * Set extensao
     *
     * @param integer $extensao
     * @return Trecho
     */
    public function setExtensao($extensao)
    {
        $this->extensao = $extensao;
        return $this;
    }

    /**
     * Get extensao
     *
     * @return integer
     */
    public function getExtensao()
    {
        return $this->extensao;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioBaixaTrecho
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\BaixaTrecho $fkImobiliarioBaixaTrecho
     * @return Trecho
     */
    public function addFkImobiliarioBaixaTrechos(\Urbem\CoreBundle\Entity\Imobiliario\BaixaTrecho $fkImobiliarioBaixaTrecho)
    {
        if (false === $this->fkImobiliarioBaixaTrechos->contains($fkImobiliarioBaixaTrecho)) {
            $fkImobiliarioBaixaTrecho->setFkImobiliarioTrecho($this);
            $this->fkImobiliarioBaixaTrechos->add($fkImobiliarioBaixaTrecho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioBaixaTrecho
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\BaixaTrecho $fkImobiliarioBaixaTrecho
     */
    public function removeFkImobiliarioBaixaTrechos(\Urbem\CoreBundle\Entity\Imobiliario\BaixaTrecho $fkImobiliarioBaixaTrecho)
    {
        $this->fkImobiliarioBaixaTrechos->removeElement($fkImobiliarioBaixaTrecho);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioBaixaTrechos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\BaixaTrecho
     */
    public function getFkImobiliarioBaixaTrechos()
    {
        return $this->fkImobiliarioBaixaTrechos;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioAtributoTrechoValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoTrechoValor $fkImobiliarioAtributoTrechoValor
     * @return Trecho
     */
    public function addFkImobiliarioAtributoTrechoValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoTrechoValor $fkImobiliarioAtributoTrechoValor)
    {
        if (false === $this->fkImobiliarioAtributoTrechoValores->contains($fkImobiliarioAtributoTrechoValor)) {
            $fkImobiliarioAtributoTrechoValor->setFkImobiliarioTrecho($this);
            $this->fkImobiliarioAtributoTrechoValores->add($fkImobiliarioAtributoTrechoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioAtributoTrechoValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoTrechoValor $fkImobiliarioAtributoTrechoValor
     */
    public function removeFkImobiliarioAtributoTrechoValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoTrechoValor $fkImobiliarioAtributoTrechoValor)
    {
        $this->fkImobiliarioAtributoTrechoValores->removeElement($fkImobiliarioAtributoTrechoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioAtributoTrechoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoTrechoValor
     */
    public function getFkImobiliarioAtributoTrechoValores()
    {
        return $this->fkImobiliarioAtributoTrechoValores;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioConfrontacaoTrecho
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoTrecho $fkImobiliarioConfrontacaoTrecho
     * @return Trecho
     */
    public function addFkImobiliarioConfrontacaoTrechos(\Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoTrecho $fkImobiliarioConfrontacaoTrecho)
    {
        if (false === $this->fkImobiliarioConfrontacaoTrechos->contains($fkImobiliarioConfrontacaoTrecho)) {
            $fkImobiliarioConfrontacaoTrecho->setFkImobiliarioTrecho($this);
            $this->fkImobiliarioConfrontacaoTrechos->add($fkImobiliarioConfrontacaoTrecho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioConfrontacaoTrecho
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoTrecho $fkImobiliarioConfrontacaoTrecho
     */
    public function removeFkImobiliarioConfrontacaoTrechos(\Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoTrecho $fkImobiliarioConfrontacaoTrecho)
    {
        $this->fkImobiliarioConfrontacaoTrechos->removeElement($fkImobiliarioConfrontacaoTrecho);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioConfrontacaoTrechos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoTrecho
     */
    public function getFkImobiliarioConfrontacaoTrechos()
    {
        return $this->fkImobiliarioConfrontacaoTrechos;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioFaceQuadraTrecho
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraTrecho $fkImobiliarioFaceQuadraTrecho
     * @return Trecho
     */
    public function addFkImobiliarioFaceQuadraTrechos(\Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraTrecho $fkImobiliarioFaceQuadraTrecho)
    {
        if (false === $this->fkImobiliarioFaceQuadraTrechos->contains($fkImobiliarioFaceQuadraTrecho)) {
            $fkImobiliarioFaceQuadraTrecho->setFkImobiliarioTrecho($this);
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
     * Add ImobiliarioTrechoValorM2
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TrechoValorM2 $fkImobiliarioTrechoValorM2
     * @return Trecho
     */
    public function addFkImobiliarioTrechoValorM2s(\Urbem\CoreBundle\Entity\Imobiliario\TrechoValorM2 $fkImobiliarioTrechoValorM2)
    {
        if (false === $this->fkImobiliarioTrechoValorM2s->contains($fkImobiliarioTrechoValorM2)) {
            $fkImobiliarioTrechoValorM2->setFkImobiliarioTrecho($this);
            $this->fkImobiliarioTrechoValorM2s->add($fkImobiliarioTrechoValorM2);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioTrechoValorM2
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TrechoValorM2 $fkImobiliarioTrechoValorM2
     */
    public function removeFkImobiliarioTrechoValorM2s(\Urbem\CoreBundle\Entity\Imobiliario\TrechoValorM2 $fkImobiliarioTrechoValorM2)
    {
        $this->fkImobiliarioTrechoValorM2s->removeElement($fkImobiliarioTrechoValorM2);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioTrechoValorM2s
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\TrechoValorM2
     */
    public function getFkImobiliarioTrechoValorM2s()
    {
        return $this->fkImobiliarioTrechoValorM2s;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioTrechoAliquota
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TrechoAliquota $fkImobiliarioTrechoAliquota
     * @return Trecho
     */
    public function addFkImobiliarioTrechoAliquotas(\Urbem\CoreBundle\Entity\Imobiliario\TrechoAliquota $fkImobiliarioTrechoAliquota)
    {
        if (false === $this->fkImobiliarioTrechoAliquotas->contains($fkImobiliarioTrechoAliquota)) {
            $fkImobiliarioTrechoAliquota->setFkImobiliarioTrecho($this);
            $this->fkImobiliarioTrechoAliquotas->add($fkImobiliarioTrechoAliquota);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioTrechoAliquota
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TrechoAliquota $fkImobiliarioTrechoAliquota
     */
    public function removeFkImobiliarioTrechoAliquotas(\Urbem\CoreBundle\Entity\Imobiliario\TrechoAliquota $fkImobiliarioTrechoAliquota)
    {
        $this->fkImobiliarioTrechoAliquotas->removeElement($fkImobiliarioTrechoAliquota);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioTrechoAliquotas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\TrechoAliquota
     */
    public function getFkImobiliarioTrechoAliquotas()
    {
        return $this->fkImobiliarioTrechoAliquotas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwLogradouro
     *
     * @param \Urbem\CoreBundle\Entity\SwLogradouro $fkSwLogradouro
     * @return Trecho
     */
    public function setFkSwLogradouro(\Urbem\CoreBundle\Entity\SwLogradouro $fkSwLogradouro)
    {
        $this->codLogradouro = $fkSwLogradouro->getCodLogradouro();
        $this->fkSwLogradouro = $fkSwLogradouro;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwLogradouro
     *
     * @return \Urbem\CoreBundle\Entity\SwLogradouro
     */
    public function getFkSwLogradouro()
    {
        return $this->fkSwLogradouro;
    }

    /**
     * @return string
     */
    public function getCodigoComposto()
    {
        return sprintf('%s.%s', $this->codLogradouro, $this->sequencia);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->getCodigoComposto(), (string) $this->fkSwLogradouro);
    }
}
