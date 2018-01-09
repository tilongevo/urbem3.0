<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * VwUltimoDomicilioCidadaoView
 */
class VwUltimoDomicilioCidadaoView
{
    /**
     * PK
     * @var \DateTime
     */
    private $dtInclusao;

    /**
     * @var integer
     */
    private $codCidadao;

    /**
     * @var string
     */
    private $nomCidadao;

    /**
     * @var integer
     */
    private $codDomicilio;


    /**
     * Set dtInclusao
     *
     * @param \DateTime $dtInclusao
     * @return VwUltimoDomicilioCidadao
     */
    public function setDtInclusao(\DateTime $dtInclusao)
    {
        $this->dtInclusao = $dtInclusao;
        return $this;
    }

    /**
     * Get dtInclusao
     *
     * @return \DateTime
     */
    public function getDtInclusao()
    {
        return $this->dtInclusao;
    }

    /**
     * Set codCidadao
     *
     * @param integer $codCidadao
     * @return VwUltimoDomicilioCidadao
     */
    public function setCodCidadao($codCidadao = null)
    {
        $this->codCidadao = $codCidadao;
        return $this;
    }

    /**
     * Get codCidadao
     *
     * @return integer
     */
    public function getCodCidadao()
    {
        return $this->codCidadao;
    }

    /**
     * Set nomCidadao
     *
     * @param string $nomCidadao
     * @return VwUltimoDomicilioCidadao
     */
    public function setNomCidadao($nomCidadao = null)
    {
        $this->nomCidadao = $nomCidadao;
        return $this;
    }

    /**
     * Get nomCidadao
     *
     * @return string
     */
    public function getNomCidadao()
    {
        return $this->nomCidadao;
    }

    /**
     * Set codDomicilio
     *
     * @param integer $codDomicilio
     * @return VwUltimoDomicilioCidadao
     */
    public function setCodDomicilio($codDomicilio = null)
    {
        $this->codDomicilio = $codDomicilio;
        return $this;
    }

    /**
     * Get codDomicilio
     *
     * @return integer
     */
    public function getCodDomicilio()
    {
        return $this->codDomicilio;
    }
}
