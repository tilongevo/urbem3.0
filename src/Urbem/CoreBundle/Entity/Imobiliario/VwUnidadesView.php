<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * VwUnidadesView
 */
class VwUnidadesView
{
    /**
     * PK
     * @var integer
     */
    private $inscricaoMunicipal;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * @var integer
     */
    private $codTipoDependente;

    /**
     * @var integer
     */
    private $codConstrucao;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codConstrucaoDependente;

    /**
     * @var integer
     */
    private $area;

    /**
     * @var string
     */
    private $nomTipo;

    /**
     * @var string
     */
    private $dataConstrucao;

    /**
     * @var string
     */
    private $tipoUnidade;


    /**
     * Set inscricaoMunicipal
     *
     * @param integer $inscricaoMunicipal
     * @return VwUnidades
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return VwUnidades
     */
    public function setCodTipo($codTipo = null)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set codTipoDependente
     *
     * @param integer $codTipoDependente
     * @return VwUnidades
     */
    public function setCodTipoDependente($codTipoDependente = null)
    {
        $this->codTipoDependente = $codTipoDependente;
        return $this;
    }

    /**
     * Get codTipoDependente
     *
     * @return integer
     */
    public function getCodTipoDependente()
    {
        return $this->codTipoDependente;
    }

    /**
     * Set codConstrucao
     *
     * @param integer $codConstrucao
     * @return VwUnidades
     */
    public function setCodConstrucao($codConstrucao = null)
    {
        $this->codConstrucao = $codConstrucao;
        return $this;
    }

    /**
     * Get codConstrucao
     *
     * @return integer
     */
    public function getCodConstrucao()
    {
        return $this->codConstrucao;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return VwUnidades
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
     * Set codConstrucaoDependente
     *
     * @param integer $codConstrucaoDependente
     * @return VwUnidades
     */
    public function setCodConstrucaoDependente($codConstrucaoDependente = null)
    {
        $this->codConstrucaoDependente = $codConstrucaoDependente;
        return $this;
    }

    /**
     * Get codConstrucaoDependente
     *
     * @return integer
     */
    public function getCodConstrucaoDependente()
    {
        return $this->codConstrucaoDependente;
    }

    /**
     * Set area
     *
     * @param integer $area
     * @return VwUnidades
     */
    public function setArea($area = null)
    {
        $this->area = $area;
        return $this;
    }

    /**
     * Get area
     *
     * @return integer
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * Set nomTipo
     *
     * @param string $nomTipo
     * @return VwUnidades
     */
    public function setNomTipo($nomTipo = null)
    {
        $this->nomTipo = $nomTipo;
        return $this;
    }

    /**
     * Get nomTipo
     *
     * @return string
     */
    public function getNomTipo()
    {
        return $this->nomTipo;
    }

    /**
     * Set dataConstrucao
     *
     * @param string $dataConstrucao
     * @return VwUnidades
     */
    public function setDataConstrucao($dataConstrucao = null)
    {
        $this->dataConstrucao = $dataConstrucao;
        return $this;
    }

    /**
     * Get dataConstrucao
     *
     * @return string
     */
    public function getDataConstrucao()
    {
        return $this->dataConstrucao;
    }

    /**
     * Set tipoUnidade
     *
     * @param string $tipoUnidade
     * @return VwUnidades
     */
    public function setTipoUnidade($tipoUnidade = null)
    {
        $this->tipoUnidade = $tipoUnidade;
        return $this;
    }

    /**
     * Get tipoUnidade
     *
     * @return string
     */
    public function getTipoUnidade()
    {
        return $this->tipoUnidade;
    }
}
