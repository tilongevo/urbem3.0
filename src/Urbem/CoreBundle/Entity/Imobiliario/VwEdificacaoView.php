<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * VwEdificacaoView
 */
class VwEdificacaoView
{
    /**
     * PK
     * @var integer
     */
    private $codConstrucao;

    /**
     * @var \DateTime
     */
    private $timestampConstrucao;

    /**
     * @var integer
     */
    private $codConstrucaoAutonoma;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * @var integer
     */
    private $codTipoAutonoma;

    /**
     * @var integer
     */
    private $areaReal;

    /**
     * @var string
     */
    private $nomTipo;

    /**
     * @var integer
     */
    private $codProcesso;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $dataBaixa;

    /**
     * @var string
     */
    private $dataReativacao;

    /**
     * @var \DateTime
     */
    private $timestampBaixa;

    /**
     * @var string
     */
    private $justificativa;

    /**
     * @var \DateTime
     */
    private $dataConstrucao;

    /**
     * @var boolean
     */
    private $sistema;

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
    private $areaUnidade;

    /**
     * @var string
     */
    private $tipoVinculo;


    /**
     * Set codConstrucao
     *
     * @param integer $codConstrucao
     * @return VwEdificacao
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
     * Set timestampConstrucao
     *
     * @param \DateTime $timestampConstrucao
     * @return VwEdificacao
     */
    public function setTimestampConstrucao(\DateTime $timestampConstrucao = null)
    {
        $this->timestampConstrucao = $timestampConstrucao;
        return $this;
    }

    /**
     * Get timestampConstrucao
     *
     * @return \DateTime
     */
    public function getTimestampConstrucao()
    {
        return $this->timestampConstrucao;
    }

    /**
     * Set codConstrucaoAutonoma
     *
     * @param integer $codConstrucaoAutonoma
     * @return VwEdificacao
     */
    public function setCodConstrucaoAutonoma($codConstrucaoAutonoma = null)
    {
        $this->codConstrucaoAutonoma = $codConstrucaoAutonoma;
        return $this;
    }

    /**
     * Get codConstrucaoAutonoma
     *
     * @return integer
     */
    public function getCodConstrucaoAutonoma()
    {
        return $this->codConstrucaoAutonoma;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return VwEdificacao
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
     * Set codTipoAutonoma
     *
     * @param integer $codTipoAutonoma
     * @return VwEdificacao
     */
    public function setCodTipoAutonoma($codTipoAutonoma = null)
    {
        $this->codTipoAutonoma = $codTipoAutonoma;
        return $this;
    }

    /**
     * Get codTipoAutonoma
     *
     * @return integer
     */
    public function getCodTipoAutonoma()
    {
        return $this->codTipoAutonoma;
    }

    /**
     * Set areaReal
     *
     * @param integer $areaReal
     * @return VwEdificacao
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

    /**
     * Set nomTipo
     *
     * @param string $nomTipo
     * @return VwEdificacao
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
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return VwEdificacao
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
     * @return VwEdificacao
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
     * Set dataBaixa
     *
     * @param string $dataBaixa
     * @return VwEdificacao
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
     * Set dataReativacao
     *
     * @param string $dataReativacao
     * @return VwEdificacao
     */
    public function setDataReativacao($dataReativacao = null)
    {
        $this->dataReativacao = $dataReativacao;
        return $this;
    }

    /**
     * Get dataReativacao
     *
     * @return string
     */
    public function getDataReativacao()
    {
        return $this->dataReativacao;
    }

    /**
     * Set timestampBaixa
     *
     * @param \DateTime $timestampBaixa
     * @return VwEdificacao
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
     * Set justificativa
     *
     * @param string $justificativa
     * @return VwEdificacao
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
     * Set dataConstrucao
     *
     * @param \DateTime $dataConstrucao
     * @return VwEdificacao
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
     * Set sistema
     *
     * @param boolean $sistema
     * @return VwEdificacao
     */
    public function setSistema($sistema = null)
    {
        $this->sistema = $sistema;
        return $this;
    }

    /**
     * Get sistema
     *
     * @return boolean
     */
    public function getSistema()
    {
        return $this->sistema;
    }

    /**
     * Set imovelCond
     *
     * @param integer $imovelCond
     * @return VwEdificacao
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
     * @return VwEdificacao
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
     * Set areaUnidade
     *
     * @param string $areaUnidade
     * @return VwEdificacao
     */
    public function setAreaUnidade($areaUnidade = null)
    {
        $this->areaUnidade = $areaUnidade;
        return $this;
    }

    /**
     * Get areaUnidade
     *
     * @return string
     */
    public function getAreaUnidade()
    {
        return $this->areaUnidade;
    }

    /**
     * Set tipoVinculo
     *
     * @param string $tipoVinculo
     * @return VwEdificacao
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
}
