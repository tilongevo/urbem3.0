<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * Impressora
 */
class Impressora
{
    /**
     * PK
     * @var integer
     */
    private $codImpressora;

    /**
     * @var string
     */
    private $nomImpressora;

    /**
     * @var integer
     */
    private $codOrgao;

    /**
     * @var integer
     */
    private $codLocal;

    /**
     * @var string
     */
    private $filaImpressao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ChequeImpressoraTerminal
     */
    private $fkTesourariaChequeImpressoraTerminais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\UsuarioImpressora
     */
    private $fkAdministracaoUsuarioImpressoras;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    private $fkOrganogramaOrgao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Organograma\Local
     */
    private $fkOrganogramaLocal;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTesourariaChequeImpressoraTerminais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAdministracaoUsuarioImpressoras = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codImpressora
     *
     * @param integer $codImpressora
     * @return Impressora
     */
    public function setCodImpressora($codImpressora)
    {
        $this->codImpressora = $codImpressora;
        return $this;
    }

    /**
     * Get codImpressora
     *
     * @return integer
     */
    public function getCodImpressora()
    {
        return $this->codImpressora;
    }

    /**
     * Set nomImpressora
     *
     * @param string $nomImpressora
     * @return Impressora
     */
    public function setNomImpressora($nomImpressora)
    {
        $this->nomImpressora = $nomImpressora;
        return $this;
    }

    /**
     * Get nomImpressora
     *
     * @return string
     */
    public function getNomImpressora()
    {
        return $this->nomImpressora;
    }

    /**
     * Set codOrgao
     *
     * @param integer $codOrgao
     * @return Impressora
     */
    public function setCodOrgao($codOrgao)
    {
        $this->codOrgao = $codOrgao;
        return $this;
    }

    /**
     * Get codOrgao
     *
     * @return integer
     */
    public function getCodOrgao()
    {
        return $this->codOrgao;
    }

    /**
     * Set codLocal
     *
     * @param integer $codLocal
     * @return Impressora
     */
    public function setCodLocal($codLocal)
    {
        $this->codLocal = $codLocal;
        return $this;
    }

    /**
     * Get codLocal
     *
     * @return integer
     */
    public function getCodLocal()
    {
        return $this->codLocal;
    }

    /**
     * Set filaImpressao
     *
     * @param string $filaImpressao
     * @return Impressora
     */
    public function setFilaImpressao($filaImpressao)
    {
        $this->filaImpressao = $filaImpressao;
        return $this;
    }

    /**
     * Get filaImpressao
     *
     * @return string
     */
    public function getFilaImpressao()
    {
        return $this->filaImpressao;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaChequeImpressoraTerminal
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ChequeImpressoraTerminal $fkTesourariaChequeImpressoraTerminal
     * @return Impressora
     */
    public function addFkTesourariaChequeImpressoraTerminais(\Urbem\CoreBundle\Entity\Tesouraria\ChequeImpressoraTerminal $fkTesourariaChequeImpressoraTerminal)
    {
        if (false === $this->fkTesourariaChequeImpressoraTerminais->contains($fkTesourariaChequeImpressoraTerminal)) {
            $fkTesourariaChequeImpressoraTerminal->setFkAdministracaoImpressora($this);
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
     * Add AdministracaoUsuarioImpressora
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\UsuarioImpressora $fkAdministracaoUsuarioImpressora
     * @return Impressora
     */
    public function addFkAdministracaoUsuarioImpressoras(\Urbem\CoreBundle\Entity\Administracao\UsuarioImpressora $fkAdministracaoUsuarioImpressora)
    {
        if (false === $this->fkAdministracaoUsuarioImpressoras->contains($fkAdministracaoUsuarioImpressora)) {
            $fkAdministracaoUsuarioImpressora->setFkAdministracaoImpressora($this);
            $this->fkAdministracaoUsuarioImpressoras->add($fkAdministracaoUsuarioImpressora);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoUsuarioImpressora
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\UsuarioImpressora $fkAdministracaoUsuarioImpressora
     */
    public function removeFkAdministracaoUsuarioImpressoras(\Urbem\CoreBundle\Entity\Administracao\UsuarioImpressora $fkAdministracaoUsuarioImpressora)
    {
        $this->fkAdministracaoUsuarioImpressoras->removeElement($fkAdministracaoUsuarioImpressora);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoUsuarioImpressoras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\UsuarioImpressora
     */
    public function getFkAdministracaoUsuarioImpressoras()
    {
        return $this->fkAdministracaoUsuarioImpressoras;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrganogramaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao
     * @return Impressora
     */
    public function setFkOrganogramaOrgao(\Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao)
    {
        $this->codOrgao = $fkOrganogramaOrgao->getCodOrgao();
        $this->fkOrganogramaOrgao = $fkOrganogramaOrgao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrganogramaOrgao
     *
     * @return \Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    public function getFkOrganogramaOrgao()
    {
        return $this->fkOrganogramaOrgao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrganogramaLocal
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Local $fkOrganogramaLocal
     * @return Impressora
     */
    public function setFkOrganogramaLocal(\Urbem\CoreBundle\Entity\Organograma\Local $fkOrganogramaLocal)
    {
        $this->codLocal = $fkOrganogramaLocal->getCodLocal();
        $this->fkOrganogramaLocal = $fkOrganogramaLocal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrganogramaLocal
     *
     * @return \Urbem\CoreBundle\Entity\Organograma\Local
     */
    public function getFkOrganogramaLocal()
    {
        return $this->fkOrganogramaLocal;
    }
}
