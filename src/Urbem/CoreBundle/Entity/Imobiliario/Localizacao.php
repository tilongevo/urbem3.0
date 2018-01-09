<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * Localizacao
 */
class Localizacao
{
    /**
     * PK
     * @var integer
     */
    private $codLocalizacao;

    /**
     * @var string
     */
    private $nomLocalizacao;

    /**
     * @var string
     */
    private $codigoComposto;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\BaixaLocalizacao
     */
    private $fkImobiliarioBaixaLocalizacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoNivel
     */
    private $fkImobiliarioLocalizacaoNiveis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LoteLocalizacao
     */
    private $fkImobiliarioLoteLocalizacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoAliquota
     */
    private $fkImobiliarioLocalizacaoAliquotas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoValorM2
     */
    private $fkImobiliarioLocalizacaoValorM2s;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoNivelValor
     */
    private $fkImobiliarioAtributoNivelValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\FaceQuadra
     */
    private $fkImobiliarioFaceQuadras;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImobiliarioBaixaLocalizacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioLocalizacaoNiveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioLoteLocalizacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioLocalizacaoAliquotas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioLocalizacaoValorM2s = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioAtributoNivelValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioFaceQuadras = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codLocalizacao
     *
     * @param integer $codLocalizacao
     * @return Localizacao
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
     * Set nomLocalizacao
     *
     * @param string $nomLocalizacao
     * @return Localizacao
     */
    public function setNomLocalizacao($nomLocalizacao)
    {
        $this->nomLocalizacao = $nomLocalizacao;
        return $this;
    }

    /**
     * Get nomLocalizacao
     *
     * @return string
     */
    public function getNomLocalizacao()
    {
        return $this->nomLocalizacao;
    }

    /**
     * Set codigoComposto
     *
     * @param string $codigoComposto
     * @return Localizacao
     */
    public function setCodigoComposto($codigoComposto)
    {
        $this->codigoComposto = $codigoComposto;
        return $this;
    }

    /**
     * Get codigoComposto
     *
     * @return string
     */
    public function getCodigoComposto()
    {
        return $this->codigoComposto;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioBaixaLocalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\BaixaLocalizacao $fkImobiliarioBaixaLocalizacao
     * @return Localizacao
     */
    public function addFkImobiliarioBaixaLocalizacoes(\Urbem\CoreBundle\Entity\Imobiliario\BaixaLocalizacao $fkImobiliarioBaixaLocalizacao)
    {
        if (false === $this->fkImobiliarioBaixaLocalizacoes->contains($fkImobiliarioBaixaLocalizacao)) {
            $fkImobiliarioBaixaLocalizacao->setFkImobiliarioLocalizacao($this);
            $this->fkImobiliarioBaixaLocalizacoes->add($fkImobiliarioBaixaLocalizacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioBaixaLocalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\BaixaLocalizacao $fkImobiliarioBaixaLocalizacao
     */
    public function removeFkImobiliarioBaixaLocalizacoes(\Urbem\CoreBundle\Entity\Imobiliario\BaixaLocalizacao $fkImobiliarioBaixaLocalizacao)
    {
        $this->fkImobiliarioBaixaLocalizacoes->removeElement($fkImobiliarioBaixaLocalizacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioBaixaLocalizacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\BaixaLocalizacao
     */
    public function getFkImobiliarioBaixaLocalizacoes()
    {
        return $this->fkImobiliarioBaixaLocalizacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLocalizacaoNivel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoNivel $fkImobiliarioLocalizacaoNivel
     * @return Localizacao
     */
    public function addFkImobiliarioLocalizacaoNiveis(\Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoNivel $fkImobiliarioLocalizacaoNivel)
    {
        if (false === $this->fkImobiliarioLocalizacaoNiveis->contains($fkImobiliarioLocalizacaoNivel)) {
            $fkImobiliarioLocalizacaoNivel->setFkImobiliarioLocalizacao($this);
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
     * Add ImobiliarioLoteLocalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LoteLocalizacao $fkImobiliarioLoteLocalizacao
     * @return Localizacao
     */
    public function addFkImobiliarioLoteLocalizacoes(\Urbem\CoreBundle\Entity\Imobiliario\LoteLocalizacao $fkImobiliarioLoteLocalizacao)
    {
        if (false === $this->fkImobiliarioLoteLocalizacoes->contains($fkImobiliarioLoteLocalizacao)) {
            $fkImobiliarioLoteLocalizacao->setFkImobiliarioLocalizacao($this);
            $this->fkImobiliarioLoteLocalizacoes->add($fkImobiliarioLoteLocalizacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioLoteLocalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LoteLocalizacao $fkImobiliarioLoteLocalizacao
     */
    public function removeFkImobiliarioLoteLocalizacoes(\Urbem\CoreBundle\Entity\Imobiliario\LoteLocalizacao $fkImobiliarioLoteLocalizacao)
    {
        $this->fkImobiliarioLoteLocalizacoes->removeElement($fkImobiliarioLoteLocalizacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioLoteLocalizacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LoteLocalizacao
     */
    public function getFkImobiliarioLoteLocalizacoes()
    {
        return $this->fkImobiliarioLoteLocalizacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLocalizacaoAliquota
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoAliquota $fkImobiliarioLocalizacaoAliquota
     * @return Localizacao
     */
    public function addFkImobiliarioLocalizacaoAliquotas(\Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoAliquota $fkImobiliarioLocalizacaoAliquota)
    {
        if (false === $this->fkImobiliarioLocalizacaoAliquotas->contains($fkImobiliarioLocalizacaoAliquota)) {
            $fkImobiliarioLocalizacaoAliquota->setFkImobiliarioLocalizacao($this);
            $this->fkImobiliarioLocalizacaoAliquotas->add($fkImobiliarioLocalizacaoAliquota);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioLocalizacaoAliquota
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoAliquota $fkImobiliarioLocalizacaoAliquota
     */
    public function removeFkImobiliarioLocalizacaoAliquotas(\Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoAliquota $fkImobiliarioLocalizacaoAliquota)
    {
        $this->fkImobiliarioLocalizacaoAliquotas->removeElement($fkImobiliarioLocalizacaoAliquota);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioLocalizacaoAliquotas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoAliquota
     */
    public function getFkImobiliarioLocalizacaoAliquotas()
    {
        return $this->fkImobiliarioLocalizacaoAliquotas;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLocalizacaoValorM2
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoValorM2 $fkImobiliarioLocalizacaoValorM2
     * @return Localizacao
     */
    public function addFkImobiliarioLocalizacaoValorM2s(\Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoValorM2 $fkImobiliarioLocalizacaoValorM2)
    {
        if (false === $this->fkImobiliarioLocalizacaoValorM2s->contains($fkImobiliarioLocalizacaoValorM2)) {
            $fkImobiliarioLocalizacaoValorM2->setFkImobiliarioLocalizacao($this);
            $this->fkImobiliarioLocalizacaoValorM2s->add($fkImobiliarioLocalizacaoValorM2);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioLocalizacaoValorM2
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoValorM2 $fkImobiliarioLocalizacaoValorM2
     */
    public function removeFkImobiliarioLocalizacaoValorM2s(\Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoValorM2 $fkImobiliarioLocalizacaoValorM2)
    {
        $this->fkImobiliarioLocalizacaoValorM2s->removeElement($fkImobiliarioLocalizacaoValorM2);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioLocalizacaoValorM2s
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoValorM2
     */
    public function getFkImobiliarioLocalizacaoValorM2s()
    {
        return $this->fkImobiliarioLocalizacaoValorM2s;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioAtributoNivelValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoNivelValor $fkImobiliarioAtributoNivelValor
     * @return Localizacao
     */
    public function addFkImobiliarioAtributoNivelValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoNivelValor $fkImobiliarioAtributoNivelValor)
    {
        if (false === $this->fkImobiliarioAtributoNivelValores->contains($fkImobiliarioAtributoNivelValor)) {
            $fkImobiliarioAtributoNivelValor->setFkImobiliarioLocalizacao($this);
            $this->fkImobiliarioAtributoNivelValores->add($fkImobiliarioAtributoNivelValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioAtributoNivelValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoNivelValor $fkImobiliarioAtributoNivelValor
     */
    public function removeFkImobiliarioAtributoNivelValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoNivelValor $fkImobiliarioAtributoNivelValor)
    {
        $this->fkImobiliarioAtributoNivelValores->removeElement($fkImobiliarioAtributoNivelValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioAtributoNivelValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoNivelValor
     */
    public function getFkImobiliarioAtributoNivelValores()
    {
        return $this->fkImobiliarioAtributoNivelValores;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioFaceQuadra
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\FaceQuadra $fkImobiliarioFaceQuadra
     * @return Localizacao
     */
    public function addFkImobiliarioFaceQuadras(\Urbem\CoreBundle\Entity\Imobiliario\FaceQuadra $fkImobiliarioFaceQuadra)
    {
        if (false === $this->fkImobiliarioFaceQuadras->contains($fkImobiliarioFaceQuadra)) {
            $fkImobiliarioFaceQuadra->setFkImobiliarioLocalizacao($this);
            $this->fkImobiliarioFaceQuadras->add($fkImobiliarioFaceQuadra);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioFaceQuadra
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\FaceQuadra $fkImobiliarioFaceQuadra
     */
    public function removeFkImobiliarioFaceQuadras(\Urbem\CoreBundle\Entity\Imobiliario\FaceQuadra $fkImobiliarioFaceQuadra)
    {
        $this->fkImobiliarioFaceQuadras->removeElement($fkImobiliarioFaceQuadra);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioFaceQuadras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\FaceQuadra
     */
    public function getFkImobiliarioFaceQuadras()
    {
        return $this->fkImobiliarioFaceQuadras;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->codigoComposto;
    }
}
