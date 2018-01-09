<?php

namespace Urbem\CoreBundle\Entity\PrestacaoContas;

use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Helper\DateTimePK;

/**
 * FilaRelatorio
 */
class FilaRelatorio
{
    const STATUS_CRIADO = 'CRIADO';
    const STATUS_ENVIANDO = 'ENVIANDO';
    const STATUS_ENVIADO = 'ENVIADO';
    const STATUS_PROCESSANDO = 'PROCESSANDO';
    const STATUS_ERRO = 'ERRO';
    const STATUS_PRONTO = 'PRONTO';
    const STATUS_TRANSFORMANDO = 'TRANSFORMANDO';
    const STATUS_CANCELANDO = 'CANCELANDO';
    const STATUS_CANCELADO = 'CANCELADO';
    const STATUS_FINALIZADO = 'FINALIZADO';

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $relatorio;

    /**
     * @var string
     */
    private $nome;

    /**
     * @var array
     */
    private $parametros;

    /**
     * @var array
     */
    private $valor;

    /**
     * @var array
     */
    private $resposta;

    /**
     * @var array
     */
    private $relatorioLog;

    /**
     * @var string
     */
    private $classeProcessamento;

    /**
     * @var string
     */
    private $identificadorExterno;

    /**
     * @var string
     */
    private $caminhoDownload;

    /**
     * @var string
     */
    private $status;

    /**
     * @var DateTimePK
     */
    private $dataCriacao;

    /**
     * @var DateTimePK
     */
    private $dataResposta;

    /**
     * @var Usuario
     */
    private $fkAdministracaoUsuario;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dataCriacao = new DateTimePK();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set relatorio
     *
     * @param string $relatorio
     *
     * @return FilaRelatorio
     */
    public function setRelatorio($relatorio)
    {
        $this->relatorio = $relatorio;

        return $this;
    }

    /**
     * Get relatorio
     *
     * @return string
     */
    public function getRelatorio()
    {
        return $this->relatorio;
    }

    /**
     * Set nome
     *
     * @param string $nome
     *
     * @return FilaRelatorio
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set parametros
     *
     * @param array $parametros
     *
     * @return FilaRelatorio
     */
    public function setParametros(array $parametros)
    {
        $this->parametros = $parametros;

        return $this;
    }

    /**
     * Get parametros
     *
     * @return array
     */
    public function getParametros()
    {
        return $this->parametros;
    }

    /**
     * Set valor
     *
     * @param array $valor
     *
     * @return FilaRelatorio
     */
    public function setValor(array $valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return array
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set resposta
     *
     * @param array $resposta
     *
     * @return FilaRelatorio
     */
    public function setResposta(array $resposta)
    {
        $this->resposta = $resposta;

        return $this;
    }

    /**
     * Get resposta
     *
     * @return array
     */
    public function getResposta()
    {
        return $this->resposta;
    }

    /**
     * Set relatorioLog
     *
     * @param array $relatorioLog
     *
     * @return FilaRelatorio
     */
    public function setRelatorioLog(array $relatorioLog)
    {
        $this->relatorioLog = $relatorioLog;

        return $this;
    }

    /**
     * Get relatorioLog
     *
     * @return array
     */
    public function getRelatorioLog()
    {
        return $this->relatorioLog;
    }

    /**
     * Set classeProcessamento
     *
     * @param string $classeProcessamento
     *
     * @return FilaRelatorio
     */
    public function setClasseProcessamento($classeProcessamento)
    {
        $this->classeProcessamento = $classeProcessamento;

        return $this;
    }

    /**
     * Get identificadorExterno
     *
     * @return string
     */
    public function getIdentificadorExterno()
    {
        return $this->identificadorExterno;
    }

    /**
     * Set identificadorExterno
     *
     * @param string $identificadorExterno
     *
     * @return FilaRelatorio
     */
    public function setIdentificadorExterno($identificadorExterno)
    {
        $this->identificadorExterno = $identificadorExterno;

        return $this;
    }

    /**
     * Get caminhoDownload
     *
     * @return string
     */
    public function getCaminhoDownload()
    {
        return $this->caminhoDownload;
    }

    /**
     * Set caminhoDownload
     *
     * @param string $caminhoDownload
     *
     * @return FilaRelatorio
     */
    public function setCaminhoDownload($caminhoDownload)
    {
        $this->caminhoDownload = $caminhoDownload;

        return $this;
    }

    /**
     * Get classeProcessamento
     *
     * @return string
     */
    public function getClasseProcessamento()
    {
        return $this->classeProcessamento;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return FilaRelatorio
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set dataCriacao
     *
     * @param DateTimePK $dataCriacao
     *
     * @return FilaRelatorio
     */
    public function setDataCriacao(DateTimePK $dataCriacao)
    {
        $this->dataCriacao = $dataCriacao;

        return $this;
    }

    /**
     * Get dataCriacao
     *
     * @return string|null
     */
    public function getDataCriacao()
    {
        return $this->dataCriacao;
    }

    /**
     * Set dataResposta
     *
     * @param DateTimePK $dataResposta
     *
     * @return FilaRelatorio
     */
    public function setDataResposta(DateTimePK $dataResposta = null)
    {
        $this->dataResposta = $dataResposta;

        return $this;
    }

    /**
     * Get dataResposta
     *
     * @return string|null
     */
    public function getDataResposta()
    {
        return $this->dataResposta;
    }

    /**
     * Set fkAdministracaoUsuario
     *
     * @param Usuario $fkAdministracaoUsuario
     *
     * @return FilaRelatorio
     */
    public function setFkAdministracaoUsuario(Usuario $fkAdministracaoUsuario)
    {
        $this->fkAdministracaoUsuario = $fkAdministracaoUsuario;

        return $this;
    }

    /**
     * Get fkAdministracaoUsuario
     *
     * @return Usuario
     */
    public function getFkAdministracaoUsuario()
    {
        return $this->fkAdministracaoUsuario;
    }
}
