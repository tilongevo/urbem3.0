<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

use Doctrine\Common\Collections\Collection;

/**
 * Terminal
 */
class Terminal
{
    /**
     * PK
     * @var integer
     */
    private $codTerminal;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampTerminal;

    /**
     * @var string
     */
    private $codVerificador;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tesouraria\TerminalDesativado
     */
    private $fkTesourariaTerminalDesativado;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Abertura
     */
    private $fkTesourariaAberturas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ChequeImpressoraTerminal
     */
    private $fkTesourariaChequeImpressoraTerminais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\PermissaoTerminal
     */
    private $fkTesourariaPermissaoTerminais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal
     */
    private $fkTesourariaUsuarioTerminais;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTesourariaAberturas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaChequeImpressoraTerminais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaPermissaoTerminais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaUsuarioTerminais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestampTerminal = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codTerminal
     *
     * @param integer $codTerminal
     * @return Terminal
     */
    public function setCodTerminal($codTerminal)
    {
        $this->codTerminal = $codTerminal;
        return $this;
    }

    /**
     * Get codTerminal
     *
     * @return integer
     */
    public function getCodTerminal()
    {
        return $this->codTerminal;
    }

    /**
     * Set timestampTerminal
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampTerminal
     * @return Terminal
     */
    public function setTimestampTerminal(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampTerminal)
    {
        $this->timestampTerminal = $timestampTerminal;
        return $this;
    }

    /**
     * Get timestampTerminal
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampTerminal()
    {
        return $this->timestampTerminal;
    }

    /**
     * Set codVerificador
     *
     * @param string $codVerificador
     * @return Terminal
     */
    public function setCodVerificador($codVerificador)
    {
        $this->codVerificador = $codVerificador;
        return $this;
    }

    /**
     * Get codVerificador
     *
     * @return string
     */
    public function getCodVerificador()
    {
        return $this->codVerificador;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaAbertura
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Abertura $fkTesourariaAbertura
     * @return Terminal
     */
    public function addFkTesourariaAberturas(\Urbem\CoreBundle\Entity\Tesouraria\Abertura $fkTesourariaAbertura)
    {
        if (false === $this->fkTesourariaAberturas->contains($fkTesourariaAbertura)) {
            $fkTesourariaAbertura->setFkTesourariaTerminal($this);
            $this->fkTesourariaAberturas->add($fkTesourariaAbertura);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaAbertura
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Abertura $fkTesourariaAbertura
     */
    public function removeFkTesourariaAberturas(\Urbem\CoreBundle\Entity\Tesouraria\Abertura $fkTesourariaAbertura)
    {
        $this->fkTesourariaAberturas->removeElement($fkTesourariaAbertura);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaAberturas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Abertura
     */
    public function getFkTesourariaAberturas()
    {
        return $this->fkTesourariaAberturas;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaChequeImpressoraTerminal
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ChequeImpressoraTerminal $fkTesourariaChequeImpressoraTerminal
     * @return Terminal
     */
    public function addFkTesourariaChequeImpressoraTerminais(\Urbem\CoreBundle\Entity\Tesouraria\ChequeImpressoraTerminal $fkTesourariaChequeImpressoraTerminal)
    {
        if (false === $this->fkTesourariaChequeImpressoraTerminais->contains($fkTesourariaChequeImpressoraTerminal)) {
            $fkTesourariaChequeImpressoraTerminal->setFkTesourariaTerminal($this);
            $this->fkTesourariaChequeImpressoraTerminais->add($fkTesourariaChequeImpressoraTerminal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaChequeImpressoraTerminal
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ChequeImpressoraTerminal $fkTesourariaChequeImpressoraTerminal
     */
    public function removeFkTesourariaChequeImpressoraTerminais(\Urbem\CoreBundle\Entity\Tesouraria\ChequeImpressoraTerminal $fkTesourariaChequeImpressoraTerminal)
    {
        $this->fkTesourariaChequeImpressoraTerminais->removeElement($fkTesourariaChequeImpressoraTerminal);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaChequeImpressoraTerminais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ChequeImpressoraTerminal
     */
    public function getFkTesourariaChequeImpressoraTerminais()
    {
        return $this->fkTesourariaChequeImpressoraTerminais;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaPermissaoTerminal
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\PermissaoTerminal $fkTesourariaPermissaoTerminal
     * @return Terminal
     */
    public function addFkTesourariaPermissaoTerminais(\Urbem\CoreBundle\Entity\Tesouraria\PermissaoTerminal $fkTesourariaPermissaoTerminal)
    {
        if (false === $this->fkTesourariaPermissaoTerminais->contains($fkTesourariaPermissaoTerminal)) {
            $fkTesourariaPermissaoTerminal->setFkTesourariaTerminal($this);
            $this->fkTesourariaPermissaoTerminais->add($fkTesourariaPermissaoTerminal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaPermissaoTerminal
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\PermissaoTerminal $fkTesourariaPermissaoTerminal
     */
    public function removeFkTesourariaPermissaoTerminais(\Urbem\CoreBundle\Entity\Tesouraria\PermissaoTerminal $fkTesourariaPermissaoTerminal)
    {
        $this->fkTesourariaPermissaoTerminais->removeElement($fkTesourariaPermissaoTerminal);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaPermissaoTerminais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\PermissaoTerminal
     */
    public function getFkTesourariaPermissaoTerminais()
    {
        return $this->fkTesourariaPermissaoTerminais;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaUsuarioTerminal
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal $fkTesourariaUsuarioTerminal
     * @return Terminal
     */
    public function addFkTesourariaUsuarioTerminais(\Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal $fkTesourariaUsuarioTerminal)
    {
        if (false === $this->fkTesourariaUsuarioTerminais->contains($fkTesourariaUsuarioTerminal)) {
            $fkTesourariaUsuarioTerminal->setFkTesourariaTerminal($this);
            $this->fkTesourariaUsuarioTerminais->add($fkTesourariaUsuarioTerminal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaUsuarioTerminal
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal $fkTesourariaUsuarioTerminal
     */
    public function removeFkTesourariaUsuarioTerminais(\Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal $fkTesourariaUsuarioTerminal)
    {
        $this->fkTesourariaUsuarioTerminais->removeElement($fkTesourariaUsuarioTerminal);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaUsuarioTerminais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal
     */
    public function getFkTesourariaUsuarioTerminais()
    {
        return $this->fkTesourariaUsuarioTerminais;
    }

    /**
     * OneToOne (inverse side)
     * Set TesourariaTerminalDesativado
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TerminalDesativado $fkTesourariaTerminalDesativado
     * @return Terminal
     */
    public function setFkTesourariaTerminalDesativado(\Urbem\CoreBundle\Entity\Tesouraria\TerminalDesativado $fkTesourariaTerminalDesativado)
    {
        $fkTesourariaTerminalDesativado->setFkTesourariaTerminal($this);
        $this->fkTesourariaTerminalDesativado = $fkTesourariaTerminalDesativado;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTesourariaTerminalDesativado
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\TerminalDesativado
     */
    public function getFkTesourariaTerminalDesativado()
    {
        return $this->fkTesourariaTerminalDesativado;
    }

    /**
     * @param Collection|\Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminal $fkTesourariaUsuarioTerminais
     * @return $this
     */
    public function setFkTesourariaUsuarioTerminais(Collection $fkTesourariaUsuarioTerminais)
    {
        foreach ($fkTesourariaUsuarioTerminais as $fkTesourariaUsuarioTerminal) {
            $this->addFkTesourariaUsuarioTerminais($fkTesourariaUsuarioTerminal);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s', $this->codTerminal);
    }
}
