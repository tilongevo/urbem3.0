<?php

namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * DocumentoNatureza
 */
class DocumentoNatureza
{
    /**
     * PK
     * @var integer
     */
    private $codDocumento;

    /**
     * @var integer
     */
    private $codNatureza;

    /**
     * @var string
     */
    private $nomDocumento;

    /**
     * @var boolean
     */
    private $cadastro = false;

    /**
     * @var boolean
     */
    private $transferencia = false;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaDocumento
     */
    private $fkImobiliarioTransferenciaDocumentos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\NaturezaTransferencia
     */
    private $fkImobiliarioNaturezaTransferencia;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImobiliarioTransferenciaDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return DocumentoNatureza
     */
    public function setCodDocumento($codDocumento)
    {
        $this->codDocumento = $codDocumento;
        return $this;
    }

    /**
     * Get codDocumento
     *
     * @return integer
     */
    public function getCodDocumento()
    {
        return $this->codDocumento;
    }

    /**
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return DocumentoNatureza
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
     * Set nomDocumento
     *
     * @param string $nomDocumento
     * @return DocumentoNatureza
     */
    public function setNomDocumento($nomDocumento)
    {
        $this->nomDocumento = $nomDocumento;
        return $this;
    }

    /**
     * Get nomDocumento
     *
     * @return string
     */
    public function getNomDocumento()
    {
        return $this->nomDocumento;
    }

    /**
     * Set cadastro
     *
     * @param boolean $cadastro
     * @return DocumentoNatureza
     */
    public function setCadastro($cadastro)
    {
        $this->cadastro = $cadastro;
        return $this;
    }

    /**
     * Get cadastro
     *
     * @return boolean
     */
    public function getCadastro()
    {
        return $this->cadastro;
    }

    /**
     * Set transferencia
     *
     * @param boolean $transferencia
     * @return DocumentoNatureza
     */
    public function setTransferencia($transferencia)
    {
        $this->transferencia = $transferencia;
        return $this;
    }

    /**
     * Get transferencia
     *
     * @return boolean
     */
    public function getTransferencia()
    {
        return $this->transferencia;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioTransferenciaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaDocumento $fkImobiliarioTransferenciaDocumento
     * @return DocumentoNatureza
     */
    public function addFkImobiliarioTransferenciaDocumentos(\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaDocumento $fkImobiliarioTransferenciaDocumento)
    {
        if (false === $this->fkImobiliarioTransferenciaDocumentos->contains($fkImobiliarioTransferenciaDocumento)) {
            $fkImobiliarioTransferenciaDocumento->setFkImobiliarioDocumentoNatureza($this);
            $this->fkImobiliarioTransferenciaDocumentos->add($fkImobiliarioTransferenciaDocumento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioTransferenciaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaDocumento $fkImobiliarioTransferenciaDocumento
     */
    public function removeFkImobiliarioTransferenciaDocumentos(\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaDocumento $fkImobiliarioTransferenciaDocumento)
    {
        $this->fkImobiliarioTransferenciaDocumentos->removeElement($fkImobiliarioTransferenciaDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioTransferenciaDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaDocumento
     */
    public function getFkImobiliarioTransferenciaDocumentos()
    {
        return $this->fkImobiliarioTransferenciaDocumentos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioNaturezaTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\NaturezaTransferencia $fkImobiliarioNaturezaTransferencia
     * @return DocumentoNatureza
     */
    public function setFkImobiliarioNaturezaTransferencia(\Urbem\CoreBundle\Entity\Imobiliario\NaturezaTransferencia $fkImobiliarioNaturezaTransferencia)
    {
        $this->codNatureza = $fkImobiliarioNaturezaTransferencia->getCodNatureza();
        $this->fkImobiliarioNaturezaTransferencia = $fkImobiliarioNaturezaTransferencia;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioNaturezaTransferencia
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\NaturezaTransferencia
     */
    public function getFkImobiliarioNaturezaTransferencia()
    {
        return $this->fkImobiliarioNaturezaTransferencia;
    }

    /**
    * @return string
    */
    public function __toString()
    {
        return (string) $this->nomDocumento;
    }
}
