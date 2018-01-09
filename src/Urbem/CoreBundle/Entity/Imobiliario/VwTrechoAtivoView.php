<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * VwTrechoAtivoView
 */
class VwTrechoAtivoView
{
    /**
     * PK
     * @var integer
     */
    private $codTrecho;

    /**
     * @var integer
     */
    private $codLogradouro;

    /**
     * @var integer
     */
    private $sequencia;

    /**
     * @var integer
     */
    private $extensao;


    /**
     * Set codTrecho
     *
     * @param integer $codTrecho
     * @return VwTrechoAtivo
     */
    public function setCodTrecho($codTrecho)
    {
        $this->codTrecho = $codTrecho;
        return $this;
    }

    /**
     * Get codTrecho
     *
     * @return integer
     */
    public function getCodTrecho()
    {
        return $this->codTrecho;
    }

    /**
     * Set codLogradouro
     *
     * @param integer $codLogradouro
     * @return VwTrechoAtivo
     */
    public function setCodLogradouro($codLogradouro = null)
    {
        $this->codLogradouro = $codLogradouro;
        return $this;
    }

    /**
     * Get codLogradouro
     *
     * @return integer
     */
    public function getCodLogradouro()
    {
        return $this->codLogradouro;
    }

    /**
     * Set sequencia
     *
     * @param integer $sequencia
     * @return VwTrechoAtivo
     */
    public function setSequencia($sequencia = null)
    {
        $this->sequencia = $sequencia;
        return $this;
    }

    /**
     * Get sequencia
     *
     * @return integer
     */
    public function getSequencia()
    {
        return $this->sequencia;
    }

    /**
     * Set extensao
     *
     * @param integer $extensao
     * @return VwTrechoAtivo
     */
    public function setExtensao($extensao = null)
    {
        $this->extensao = $extensao;
        return $this;
    }

    /**
     * Get extensao
     *
     * @return integer
     */
    public function getExtensao()
    {
        return $this->extensao;
    }
}
