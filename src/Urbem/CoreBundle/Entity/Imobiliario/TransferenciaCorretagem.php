<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * TransferenciaCorretagem
 */
class TransferenciaCorretagem
{
    /**
     * PK
     * @var integer
     */
    private $codTransferencia;

    /**
     * @var string
     */
    private $creci;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaImovel
     */
    private $fkImobiliarioTransferenciaImovel;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Corretagem
     */
    private $fkImobiliarioCorretagem;


    /**
     * Set codTransferencia
     *
     * @param integer $codTransferencia
     * @return TransferenciaCorretagem
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
     * Set creci
     *
     * @param string $creci
     * @return TransferenciaCorretagem
     */
    public function setCreci($creci)
    {
        $this->creci = $creci;
        return $this;
    }

    /**
     * Get creci
     *
     * @return string
     */
    public function getCreci()
    {
        return $this->creci;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioCorretagem
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Corretagem $fkImobiliarioCorretagem
     * @return TransferenciaCorretagem
     */
    public function setFkImobiliarioCorretagem(\Urbem\CoreBundle\Entity\Imobiliario\Corretagem $fkImobiliarioCorretagem)
    {
        $this->creci = $fkImobiliarioCorretagem->getCreci();
        $this->fkImobiliarioCorretagem = $fkImobiliarioCorretagem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioCorretagem
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Corretagem
     */
    public function getFkImobiliarioCorretagem()
    {
        return $this->fkImobiliarioCorretagem;
    }

    /**
     * OneToOne (owning side)
     * Set ImobiliarioTransferenciaImovel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaImovel $fkImobiliarioTransferenciaImovel
     * @return TransferenciaCorretagem
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
