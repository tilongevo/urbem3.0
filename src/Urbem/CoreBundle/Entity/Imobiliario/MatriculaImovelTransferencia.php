<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * MatriculaImovelTransferencia
 */
class MatriculaImovelTransferencia
{
    /**
     * PK
     * @var integer
     */
    private $codTransferencia;

    /**
     * @var string
     */
    private $matRegistroImovel;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaImovel
     */
    private $fkImobiliarioTransferenciaImovel;


    /**
     * Set codTransferencia
     *
     * @param integer $codTransferencia
     * @return MatriculaImovelTransferencia
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
     * Set matRegistroImovel
     *
     * @param string $matRegistroImovel
     * @return MatriculaImovelTransferencia
     */
    public function setMatRegistroImovel($matRegistroImovel)
    {
        $this->matRegistroImovel = $matRegistroImovel;
        return $this;
    }

    /**
     * Get matRegistroImovel
     *
     * @return string
     */
    public function getMatRegistroImovel()
    {
        return $this->matRegistroImovel;
    }

    /**
     * OneToOne (owning side)
     * Set ImobiliarioTransferenciaImovel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaImovel $fkImobiliarioTransferenciaImovel
     * @return MatriculaImovelTransferencia
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
