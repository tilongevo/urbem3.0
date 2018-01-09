<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * AdidoCedidoLocal
 */
class AdidoCedidoLocal
{
    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codNorma;

    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * PK
     * @var integer
     */
    private $codLocal;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\AdidoCedido
     */
    private $fkPessoalAdidoCedido;

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
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return AdidoCedidoLocal
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return AdidoCedidoLocal
     */
    public function setCodNorma($codNorma)
    {
        $this->codNorma = $codNorma;
        return $this;
    }

    /**
     * Get codNorma
     *
     * @return integer
     */
    public function getCodNorma()
    {
        return $this->codNorma;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return AdidoCedidoLocal
     */
    public function setCodContrato($codContrato)
    {
        $this->codContrato = $codContrato;
        return $this;
    }

    /**
     * Get codContrato
     *
     * @return integer
     */
    public function getCodContrato()
    {
        return $this->codContrato;
    }

    /**
     * Set codLocal
     *
     * @param integer $codLocal
     * @return AdidoCedidoLocal
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
     * ManyToOne (inverse side)
     * Set fkPessoalAdidoCedido
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AdidoCedido $fkPessoalAdidoCedido
     * @return AdidoCedidoLocal
     */
    public function setFkPessoalAdidoCedido(\Urbem\CoreBundle\Entity\Pessoal\AdidoCedido $fkPessoalAdidoCedido)
    {
        $this->codContrato = $fkPessoalAdidoCedido->getCodContrato();
        $this->codNorma = $fkPessoalAdidoCedido->getCodNorma();
        $this->timestamp = $fkPessoalAdidoCedido->getTimestamp();
        $this->fkPessoalAdidoCedido = $fkPessoalAdidoCedido;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalAdidoCedido
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\AdidoCedido
     */
    public function getFkPessoalAdidoCedido()
    {
        return $this->fkPessoalAdidoCedido;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrganogramaLocal
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Local $fkOrganogramaLocal
     * @return AdidoCedidoLocal
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
