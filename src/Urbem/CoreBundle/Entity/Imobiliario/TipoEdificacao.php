<?php

namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * TipoEdificacao
 */
class TipoEdificacao
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $nomTipo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoEdificacao
     */
    private $fkImobiliarioAtributoTipoEdificacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacaoValorM2
     */
    private $fkImobiliarioTipoEdificacaoValorM2s;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacaoAliquota
     */
    private $fkImobiliarioTipoEdificacaoAliquotas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoEdificacao
     */
    private $fkImobiliarioConstrucaoEdificacoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImobiliarioAtributoTipoEdificacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioTipoEdificacaoValorM2s = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioTipoEdificacaoAliquotas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioConstrucaoEdificacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoEdificacao
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set nomTipo
     *
     * @param string $nomTipo
     * @return TipoEdificacao
     */
    public function setNomTipo($nomTipo)
    {
        $this->nomTipo = $nomTipo;
        return $this;
    }

    /**
     * Get nomTipo
     *
     * @return string
     */
    public function getNomTipo()
    {
        return $this->nomTipo;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioAtributoTipoEdificacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoEdificacao $fkImobiliarioAtributoTipoEdificacao
     * @return TipoEdificacao
     */
    public function addFkImobiliarioAtributoTipoEdificacoes(\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoEdificacao $fkImobiliarioAtributoTipoEdificacao)
    {
        if (false === $this->fkImobiliarioAtributoTipoEdificacoes->contains($fkImobiliarioAtributoTipoEdificacao)) {
            $fkImobiliarioAtributoTipoEdificacao->setFkImobiliarioTipoEdificacao($this);
            $this->fkImobiliarioAtributoTipoEdificacoes->add($fkImobiliarioAtributoTipoEdificacao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioAtributoTipoEdificacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoEdificacao $fkImobiliarioAtributoTipoEdificacao
     */
    public function removeFkImobiliarioAtributoTipoEdificacoes(\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoEdificacao $fkImobiliarioAtributoTipoEdificacao)
    {
        $this->fkImobiliarioAtributoTipoEdificacoes->removeElement($fkImobiliarioAtributoTipoEdificacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioAtributoTipoEdificacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoEdificacao
     */
    public function getFkImobiliarioAtributoTipoEdificacoes()
    {
        return $this->fkImobiliarioAtributoTipoEdificacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioTipoEdificacaoValorM2
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacaoValorM2 $fkImobiliarioTipoEdificacaoValorM2
     * @return TipoEdificacao
     */
    public function addFkImobiliarioTipoEdificacaoValorM2s(\Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacaoValorM2 $fkImobiliarioTipoEdificacaoValorM2)
    {
        if (false === $this->fkImobiliarioTipoEdificacaoValorM2s->contains($fkImobiliarioTipoEdificacaoValorM2)) {
            $fkImobiliarioTipoEdificacaoValorM2->setFkImobiliarioTipoEdificacao($this);
            $this->fkImobiliarioTipoEdificacaoValorM2s->add($fkImobiliarioTipoEdificacaoValorM2);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioTipoEdificacaoValorM2
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacaoValorM2 $fkImobiliarioTipoEdificacaoValorM2
     */
    public function removeFkImobiliarioTipoEdificacaoValorM2s(\Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacaoValorM2 $fkImobiliarioTipoEdificacaoValorM2)
    {
        $this->fkImobiliarioTipoEdificacaoValorM2s->removeElement($fkImobiliarioTipoEdificacaoValorM2);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioTipoEdificacaoValorM2s
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacaoValorM2
     */
    public function getFkImobiliarioTipoEdificacaoValorM2s()
    {
        return $this->fkImobiliarioTipoEdificacaoValorM2s;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioTipoEdificacaoAliquota
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacaoAliquota $fkImobiliarioTipoEdificacaoAliquota
     * @return TipoEdificacao
     */
    public function addFkImobiliarioTipoEdificacaoAliquotas(\Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacaoAliquota $fkImobiliarioTipoEdificacaoAliquota)
    {
        if (false === $this->fkImobiliarioTipoEdificacaoAliquotas->contains($fkImobiliarioTipoEdificacaoAliquota)) {
            $fkImobiliarioTipoEdificacaoAliquota->setFkImobiliarioTipoEdificacao($this);
            $this->fkImobiliarioTipoEdificacaoAliquotas->add($fkImobiliarioTipoEdificacaoAliquota);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioTipoEdificacaoAliquota
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacaoAliquota $fkImobiliarioTipoEdificacaoAliquota
     */
    public function removeFkImobiliarioTipoEdificacaoAliquotas(\Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacaoAliquota $fkImobiliarioTipoEdificacaoAliquota)
    {
        $this->fkImobiliarioTipoEdificacaoAliquotas->removeElement($fkImobiliarioTipoEdificacaoAliquota);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioTipoEdificacaoAliquotas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacaoAliquota
     */
    public function getFkImobiliarioTipoEdificacaoAliquotas()
    {
        return $this->fkImobiliarioTipoEdificacaoAliquotas;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioConstrucaoEdificacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoEdificacao $fkImobiliarioConstrucaoEdificacao
     * @return TipoEdificacao
     */
    public function addFkImobiliarioConstrucaoEdificacoes(\Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoEdificacao $fkImobiliarioConstrucaoEdificacao)
    {
        if (false === $this->fkImobiliarioConstrucaoEdificacoes->contains($fkImobiliarioConstrucaoEdificacao)) {
            $fkImobiliarioConstrucaoEdificacao->setFkImobiliarioTipoEdificacao($this);
            $this->fkImobiliarioConstrucaoEdificacoes->add($fkImobiliarioConstrucaoEdificacao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioConstrucaoEdificacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoEdificacao $fkImobiliarioConstrucaoEdificacao
     */
    public function removeFkImobiliarioConstrucaoEdificacoes(\Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoEdificacao $fkImobiliarioConstrucaoEdificacao)
    {
        $this->fkImobiliarioConstrucaoEdificacoes->removeElement($fkImobiliarioConstrucaoEdificacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioConstrucaoEdificacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoEdificacao
     */
    public function getFkImobiliarioConstrucaoEdificacoes()
    {
        return $this->fkImobiliarioConstrucaoEdificacoes;
    }

    /**
    * @return string
    */
    public function __toString()
    {
        return (string) $this->nomTipo;
    }
}
