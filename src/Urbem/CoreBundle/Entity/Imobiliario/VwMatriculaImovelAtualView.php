<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * VwMatriculaImovelAtualView
 */
class VwMatriculaImovelAtualView
{
    /**
     * PK
     * @var integer
     */
    private $inscricaoMunicipal;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var string
     */
    private $matRegistroImovel;

    /**
     * @var string
     */
    private $zona;


    /**
     * Set inscricaoMunicipal
     *
     * @param integer $inscricaoMunicipal
     * @return VwMatriculaImovelAtual
     */
    public function setInscricaoMunicipal($inscricaoMunicipal)
    {
        $this->inscricaoMunicipal = $inscricaoMunicipal;
        return $this;
    }

    /**
     * Get inscricaoMunicipal
     *
     * @return integer
     */
    public function getInscricaoMunicipal()
    {
        return $this->inscricaoMunicipal;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return VwMatriculaImovelAtual
     */
    public function setTimestamp(\DateTime $timestamp = null)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set matRegistroImovel
     *
     * @param string $matRegistroImovel
     * @return VwMatriculaImovelAtual
     */
    public function setMatRegistroImovel($matRegistroImovel = null)
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
     * Set zona
     *
     * @param string $zona
     * @return VwMatriculaImovelAtual
     */
    public function setZona($zona = null)
    {
        $this->zona = $zona;
        return $this;
    }

    /**
     * Get zona
     *
     * @return string
     */
    public function getZona()
    {
        return $this->zona;
    }
}
