<?php

namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * NaturezaTransferencia
 */
class NaturezaTransferencia
{
    /**
     * PK
     * @var integer
     */
    private $codNatureza;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var boolean
     */
    private $automatica = false;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\DocumentoNatureza
     */
    private $fkImobiliarioDocumentoNaturezas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaImovel
     */
    private $fkImobiliarioTransferenciaImoveis;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImobiliarioDocumentoNaturezas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioTransferenciaImoveis = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return NaturezaTransferencia
     */
    public function setCodNatureza($codNatureza)
    {
        $this->codNatureza = $codNatureza;
        return $this;
    }

    /**
     * Get codNatureza
     *
     * @return integer
     */
    public function getCodNatureza()
    {
        return $this->codNatureza;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return NaturezaTransferencia
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set automatica
     *
     * @param boolean $automatica
     * @return NaturezaTransferencia
     */
    public function setAutomatica($automatica)
    {
        $this->automatica = $automatica;
        return $this;
    }

    /**
     * Get automatica
     *
     * @return boolean
     */
    public function getAutomatica()
    {
        return $this->automatica;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioDocumentoNatureza
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\DocumentoNatureza $fkImobiliarioDocumentoNatureza
     * @return NaturezaTransferencia
     */
    public function addFkImobiliarioDocumentoNaturezas(\Urbem\CoreBundle\Entity\Imobiliario\DocumentoNatureza $fkImobiliarioDocumentoNatureza)
    {
        if (false === $this->fkImobiliarioDocumentoNaturezas->contains($fkImobiliarioDocumentoNatureza)) {
            $fkImobiliarioDocumentoNatureza->setFkImobiliarioNaturezaTransferencia($this);
            $this->fkImobiliarioDocumentoNaturezas->add($fkImobiliarioDocumentoNatureza);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioDocumentoNatureza
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\DocumentoNatureza $fkImobiliarioDocumentoNatureza
     */
    public function removeFkImobiliarioDocumentoNaturezas(\Urbem\CoreBundle\Entity\Imobiliario\DocumentoNatureza $fkImobiliarioDocumentoNatureza)
    {
        $this->fkImobiliarioDocumentoNaturezas->removeElement($fkImobiliarioDocumentoNatureza);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioDocumentoNaturezas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\DocumentoNatureza
     */
    public function getFkImobiliarioDocumentoNaturezas()
    {
        return $this->fkImobiliarioDocumentoNaturezas;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioTransferenciaImovel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaImovel $fkImobiliarioTransferenciaImovel
     * @return NaturezaTransferencia
     */
    public function addFkImobiliarioTransferenciaImoveis(\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaImovel $fkImobiliarioTransferenciaImovel)
    {
        if (false === $this->fkImobiliarioTransferenciaImoveis->contains($fkImobiliarioTransferenciaImovel)) {
            $fkImobiliarioTransferenciaImovel->setFkImobiliarioNaturezaTransferencia($this);
            $this->fkImobiliarioTransferenciaImoveis->add($fkImobiliarioTransferenciaImovel);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioTransferenciaImovel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaImovel $fkImobiliarioTransferenciaImovel
     */
    public function removeFkImobiliarioTransferenciaImoveis(\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaImovel $fkImobiliarioTransferenciaImovel)
    {
        $this->fkImobiliarioTransferenciaImoveis->removeElement($fkImobiliarioTransferenciaImovel);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioTransferenciaImoveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaImovel
     */
    public function getFkImobiliarioTransferenciaImoveis()
    {
        return $this->fkImobiliarioTransferenciaImoveis;
    }

    /**
    * @return string
    */
    public function __toString()
    {
        return (string) $this->descricao;
    }
}
