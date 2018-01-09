<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * TransferenciaDocumento
 */
class TransferenciaDocumento
{
    /**
     * PK
     * @var integer
     */
    private $codTransferencia;

    /**
     * PK
     * @var integer
     */
    private $codDocumento;

    /**
     * @var \DateTime
     */
    private $dtEntrega;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaImovel
     */
    private $fkImobiliarioTransferenciaImovel;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\DocumentoNatureza
     */
    private $fkImobiliarioDocumentoNatureza;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dtEntrega = new \DateTime;
    }

    /**
     * Set codTransferencia
     *
     * @param integer $codTransferencia
     * @return TransferenciaDocumento
     */
    public function setCodTransferencia($codTransferencia)
    {
        $this->codTransferencia = $codTransferencia;
        return $this;
    }

    /**
     * Get codTransferencia
     *
     * @return integer
     */
    public function getCodTransferencia()
    {
        return $this->codTransferencia;
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return TransferenciaDocumento
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
     * Set dtEntrega
     *
     * @param \DateTime $dtEntrega
     * @return TransferenciaDocumento
     */
    public function setDtEntrega(\DateTime $dtEntrega)
    {
        $this->dtEntrega = $dtEntrega;
        return $this;
    }

    /**
     * Get dtEntrega
     *
     * @return \DateTime
     */
    public function getDtEntrega()
    {
        return $this->dtEntrega;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioTransferenciaImovel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaImovel $fkImobiliarioTransferenciaImovel
     * @return TransferenciaDocumento
     */
    public function setFkImobiliarioTransferenciaImovel(\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaImovel $fkImobiliarioTransferenciaImovel)
    {
        $this->codTransferencia = $fkImobiliarioTransferenciaImovel->getCodTransferencia();
        $this->fkImobiliarioTransferenciaImovel = $fkImobiliarioTransferenciaImovel;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioTransferenciaImovel
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaImovel
     */
    public function getFkImobiliarioTransferenciaImovel()
    {
        return $this->fkImobiliarioTransferenciaImovel;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioDocumentoNatureza
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\DocumentoNatureza $fkImobiliarioDocumentoNatureza
     * @return TransferenciaDocumento
     */
    public function setFkImobiliarioDocumentoNatureza(\Urbem\CoreBundle\Entity\Imobiliario\DocumentoNatureza $fkImobiliarioDocumentoNatureza)
    {
        $this->codDocumento = $fkImobiliarioDocumentoNatureza->getCodDocumento();
        $this->fkImobiliarioDocumentoNatureza = $fkImobiliarioDocumentoNatureza;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioDocumentoNatureza
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\DocumentoNatureza
     */
    public function getFkImobiliarioDocumentoNatureza()
    {
        return $this->fkImobiliarioDocumentoNatureza;
    }
}
