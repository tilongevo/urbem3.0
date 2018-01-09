<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * ArquivoCtb
 */
class ArquivoCtb
{
    /**
     * PK
     * @var string
     */
    private $codCtbView;

    /**
     * @var integer
     */
    private $codCtb;

    /**
     * @var integer
     */
    private $codOrgao;

    /**
     * @var integer
     */
    private $tipoConta;

    /**
     * @var string
     */
    private $tipoAplicacao;

    /**
     * @var string
     */
    private $ano;

    /**
     * @var integer
     */
    private $mes;


    /**
     * Set codCtbView
     *
     * @param string $codCtbView
     * @return ArquivoCtb
     */
    public function setCodCtbView($codCtbView)
    {
        $this->codCtbView = $codCtbView;
        return $this;
    }

    /**
     * Get codCtbView
     *
     * @return string
     */
    public function getCodCtbView()
    {
        return $this->codCtbView;
    }

    /**
     * Set codCtb
     *
     * @param integer $codCtb
     * @return ArquivoCtb
     */
    public function setCodCtb($codCtb)
    {
        $this->codCtb = $codCtb;
        return $this;
    }

    /**
     * Get codCtb
     *
     * @return integer
     */
    public function getCodCtb()
    {
        return $this->codCtb;
    }

    /**
     * Set codOrgao
     *
     * @param integer $codOrgao
     * @return ArquivoCtb
     */
    public function setCodOrgao($codOrgao)
    {
        $this->codOrgao = $codOrgao;
        return $this;
    }

    /**
     * Get codOrgao
     *
     * @return integer
     */
    public function getCodOrgao()
    {
        return $this->codOrgao;
    }

    /**
     * Set tipoConta
     *
     * @param integer $tipoConta
     * @return ArquivoCtb
     */
    public function setTipoConta($tipoConta)
    {
        $this->tipoConta = $tipoConta;
        return $this;
    }

    /**
     * Get tipoConta
     *
     * @return integer
     */
    public function getTipoConta()
    {
        return $this->tipoConta;
    }

    /**
     * Set tipoAplicacao
     *
     * @param string $tipoAplicacao
     * @return ArquivoCtb
     */
    public function setTipoAplicacao($tipoAplicacao = null)
    {
        $this->tipoAplicacao = $tipoAplicacao;
        return $this;
    }

    /**
     * Get tipoAplicacao
     *
     * @return string
     */
    public function getTipoAplicacao()
    {
        return $this->tipoAplicacao;
    }

    /**
     * Set ano
     *
     * @param string $ano
     * @return ArquivoCtb
     */
    public function setAno($ano)
    {
        $this->ano = $ano;
        return $this;
    }

    /**
     * Get ano
     *
     * @return string
     */
    public function getAno()
    {
        return $this->ano;
    }

    /**
     * Set mes
     *
     * @param integer $mes
     * @return ArquivoCtb
     */
    public function setMes($mes)
    {
        $this->mes = $mes;
        return $this;
    }

    /**
     * Get mes
     *
     * @return integer
     */
    public function getMes()
    {
        return $this->mes;
    }
}
