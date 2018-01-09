<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwClassificacao
 */
class SwClassificacao
{
    /**
     * PK
     * @var integer
     */
    private $codClassificacao;

    /**
     * @var string
     */
    private $nomClassificacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwAssunto
     */
    private $fkSwAssuntos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkSwAssuntos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codClassificacao
     *
     * @param integer $codClassificacao
     * @return SwClassificacao
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
     * Set nomClassificacao
     *
     * @param string $nomClassificacao
     * @return SwClassificacao
     */
    public function setNomClassificacao($nomClassificacao)
    {
        $this->nomClassificacao = $nomClassificacao;
        return $this;
    }

    /**
     * Get nomClassificacao
     *
     * @return string
     */
    public function getNomClassificacao()
    {
        return $this->nomClassificacao;
    }

    /**
     * OneToMany (owning side)
     * Add SwAssunto
     *
     * @param \Urbem\CoreBundle\Entity\SwAssunto $fkSwAssunto
     * @return SwClassificacao
     */
    public function addFkSwAssuntos(\Urbem\CoreBundle\Entity\SwAssunto $fkSwAssunto)
    {
        if (false === $this->fkSwAssuntos->contains($fkSwAssunto)) {
            $fkSwAssunto->setFkSwClassificacao($this);
            $this->fkSwAssuntos->add($fkSwAssunto);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwAssunto
     *
     * @param \Urbem\CoreBundle\Entity\SwAssunto $fkSwAssunto
     */
    public function removeFkSwAssuntos(\Urbem\CoreBundle\Entity\SwAssunto $fkSwAssunto)
    {
        $this->fkSwAssuntos->removeElement($fkSwAssunto);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwAssuntos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwAssunto
     */
    public function getFkSwAssuntos()
    {
        return $this->fkSwAssuntos;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            "%03s - %s",
            $this->codClassificacao,
            $this->nomClassificacao
        );
    }
}
