<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * TransferenciaEfetivacao
 */
class TransferenciaEfetivacao
{
    /**
     * PK
     * @var integer
     */
    private $codTransferencia;

    /**
     * @var \DateTime
     */
    private $dtEfetivacao;

    /**
     * @var string
     */
    private $observacao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaImovel
     */
    private $fkImobiliarioTransferenciaImovel;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dtEfetivacao = new \DateTime;
    }

    /**
     * Set codTransferencia
     *
     * @param integer $codTransferencia
     * @return TransferenciaEfetivacao
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
     * Set dtEfetivacao
     *
     * @param \DateTime $dtEfetivacao
     * @return TransferenciaEfetivacao
     */
    public function setDtEfetivacao(\DateTime $dtEfetivacao)
    {
        $this->dtEfetivacao = $dtEfetivacao;
        return $this;
    }

    /**
     * Get dtEfetivacao
     *
     * @return \DateTime
     */
    public function getDtEfetivacao()
    {
        return $this->dtEfetivacao;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return TransferenciaEfetivacao
     */
    public function setObservacao($observacao)
    {
        $this->observacao = $observacao;
        return $this;
    }

    /**
     * Get observacao
     *
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * OneToOne (owning side)
     * Set ImobiliarioTransferenciaImovel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaImovel $fkImobiliarioTransferenciaImovel
     * @return TransferenciaEfetivacao
     */
    public function setFkImobiliarioTransferenciaImovel(\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaImovel $fkImobiliarioTransferenciaImovel)
    {
        $this->codTransferencia = $fkImobiliarioTransferenciaImovel->getCodTransferencia();
        $this->fkImobiliarioTransferenciaImovel = $fkImobiliarioTransferenciaImovel;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkImobiliarioTransferenciaImovel
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaImovel
     */
    public function getFkImobiliarioTransferenciaImovel()
    {
        return $this->fkImobiliarioTransferenciaImovel;
    }
}
