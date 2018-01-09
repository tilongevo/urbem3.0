<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * VwConstrucaoOutrosView
 */
class VwConstrucaoOutrosView
{
    /**
     * PK
     * @var integer
     */
    private $codConstrucao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codProcesso;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var \DateTime
     */
    private $dataConstrucao;

    /**
     * @var string
     */
    private $dataBaixa;

    /**
     * @var string
     */
    private $justificativa;

    /**
     * @var \DateTime
     */
    private $timestampBaixa;

    /**
     * @var string
     */
    private $situacao;

    /**
     * @var integer
     */
    private $imovelCond;

    /**
     * @var string
     */
    private $nomCondominio;

    /**
     * @var string
     */
    private $tipoVinculo;

    /**
     * @var integer
     */
    private $areaReal;


    /**
     * Set codConstrucao
     *
     * @param integer $codConstrucao
     * @return VwConstrucaoOutros
     */
    public function setCodConstrucao($codConstrucao)
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
     * Set descricao
     *
     * @param string $descricao
     * @return VwConstrucaoOutros
     */
    public function setDescricao($descricao = null)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return VwConstrucaoOutros
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
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return VwConstrucaoOutros
     */
    public function setCodProcesso($codProcesso = null)
    {
        $this->codProcesso = $codProcesso;
        return $this;
    }

    /**
     * Get codProcesso
     *
     * @return integer
     */
    public function getCodProcesso()
    {
        return $this->codProcesso;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return VwConstrucaoOutros
     */
    public function setExercicio($exercicio = null)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set dataConstrucao
     *
     * @param \DateTime $dataConstrucao
     * @return VwConstrucaoOutros
     */
    public function setDataConstrucao(\DateTime $dataConstrucao = null)
    {
        $this->dataConstrucao = $dataConstrucao;
        return $this;
    }

    /**
     * Get dataConstrucao
     *
     * @return \DateTime
     */
    public function getDataConstrucao()
    {
        return $this->dataConstrucao;
    }

    /**
     * Set dataBaixa
     *
     * @param string $dataBaixa
     * @return VwConstrucaoOutros
     */
    public function setDataBaixa($dataBaixa = null)
    {
        $this->dataBaixa = $dataBaixa;
        return $this;
    }

    /**
     * Get dataBaixa
     *
     * @return string
     */
    public function getDataBaixa()
    {
        return $this->dataBaixa;
    }

    /**
     * Set justificativa
     *
     * @param string $justificativa
     * @return VwConstrucaoOutros
     */
    public function setJustificativa($justificativa = null)
    {
        $this->justificativa = $justificativa;
        return $this;
    }

    /**
     * Get justificativa
     *
     * @return string
     */
    public function getJustificativa()
    {
        return $this->justificativa;
    }

    /**
     * Set timestampBaixa
     *
     * @param \DateTime $timestampBaixa
     * @return VwConstrucaoOutros
     */
    public function setTimestampBaixa(\DateTime $timestampBaixa = null)
    {
        $this->timestampBaixa = $timestampBaixa;
        return $this;
    }

    /**
     * Get timestampBaixa
     *
     * @return \DateTime
     */
    public function getTimestampBaixa()
    {
        return $this->timestampBaixa;
    }

    /**
     * Set situacao
     *
     * @param string $situacao
     * @return VwConstrucaoOutros
     */
    public function setSituacao($situacao = null)
    {
        $this->situacao = $situacao;
        return $this;
    }

    /**
     * Get situacao
     *
     * @return string
     */
    public function getSituacao()
    {
        return $this->situacao;
    }

    /**
     * Set imovelCond
     *
     * @param integer $imovelCond
     * @return VwConstrucaoOutros
     */
    public function setImovelCond($imovelCond = null)
    {
        $this->imovelCond = $imovelCond;
        return $this;
    }

    /**
     * Get imovelCond
     *
     * @return integer
     */
    public function getImovelCond()
    {
        return $this->imovelCond;
    }

    /**
     * Set nomCondominio
     *
     * @param string $nomCondominio
     * @return VwConstrucaoOutros
     */
    public function setNomCondominio($nomCondominio = null)
    {
        $this->nomCondominio = $nomCondominio;
        return $this;
    }

    /**
     * Get nomCondominio
     *
     * @return string
     */
    public function getNomCondominio()
    {
        return $this->nomCondominio;
    }

    /**
     * Set tipoVinculo
     *
     * @param string $tipoVinculo
     * @return VwConstrucaoOutros
     */
    public function setTipoVinculo($tipoVinculo = null)
    {
        $this->tipoVinculo = $tipoVinculo;
        return $this;
    }

    /**
     * Get tipoVinculo
     *
     * @return string
     */
    public function getTipoVinculo()
    {
        return $this->tipoVinculo;
    }

    /**
     * Set areaReal
     *
     * @param integer $areaReal
     * @return VwConstrucaoOutros
     */
    public function setAreaReal($areaReal = null)
    {
        $this->areaReal = $areaReal;
        return $this;
    }

    /**
     * Get areaReal
     *
     * @return integer
     */
    public function getAreaReal()
    {
        return $this->areaReal;
    }
}
