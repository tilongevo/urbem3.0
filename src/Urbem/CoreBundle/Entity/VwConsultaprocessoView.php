<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * VwConsultaprocessoView
 */
class VwConsultaprocessoView
{
    /**
     * PK
     * @var integer
     */
    private $codprocesso;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codsituacao;

    /**
     * @var \DateTime
     */
    private $datainclusao;

    /**
     * @var integer
     */
    private $codusuarioinclusao;

    /**
     * @var integer
     */
    private $codinteressado;

    /**
     * @var integer
     */
    private $codclassificacao;

    /**
     * @var integer
     */
    private $codassunto;

    /**
     * @var string
     */
    private $resumoAssunto;

    /**
     * @var boolean
     */
    private $confidencial;

    /**
     * @var string
     */
    private $nomsituacao;

    /**
     * @var string
     */
    private $usuarioinclusao;

    /**
     * @var string
     */
    private $nominteressado;

    /**
     * @var integer
     */
    private $codultimoandamento;

    /**
     * @var integer
     */
    private $codusuarioultimoandamento;

    /**
     * @var integer
     */
    private $codorgao;

    /**
     * @var \DateTime
     */
    private $dataultimoandamento;

    /**
     * @var string
     */
    private $usuarioultimoandamento;

    /**
     * @var string
     */
    private $nomclassificacao;

    /**
     * @var string
     */
    private $nomassunto;

    /**
     * @var \DateTime
     */
    private $datarecebimento;

    /**
     * @var string
     */
    private $recebido;

    /**
     * @var string
     */
    private $usuariorecebimento;

    /**
     * @var integer
     */
    private $codusuariorecebimento;

    /**
     * @var string
     */
    private $arquivado;

    /**
     * @var string
     */
    private $nomhistoricoarquivamento;

    /**
     * @var integer
     */
    private $numreciboimpresso;

    /**
     * @var integer
     */
    private $codprocessoapensado;

    /**
     * @var string
     */
    private $exercicioprocessoapensado;

    /**
     * @var \DateTime
     */
    private $dataProcessoApensado;

    /**
     * @var \DateTime
     */
    private $timestampArquivamento;

    /**
     * @var string
     */
    private $apensado;


    /**
     * Set codprocesso
     *
     * @param integer $codprocesso
     * @return SwVwConsultaprocesso
     */
    public function setCodprocesso($codprocesso)
    {
        $this->codprocesso = $codprocesso;
        return $this;
    }

    /**
     * Get codprocesso
     *
     * @return integer
     */
    public function getCodprocesso()
    {
        return $this->codprocesso;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return SwVwConsultaprocesso
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
     * Set codsituacao
     *
     * @param integer $codsituacao
     * @return SwVwConsultaprocesso
     */
    public function setCodsituacao($codsituacao = null)
    {
        $this->codsituacao = $codsituacao;
        return $this;
    }

    /**
     * Get codsituacao
     *
     * @return integer
     */
    public function getCodsituacao()
    {
        return $this->codsituacao;
    }

    /**
     * Set datainclusao
     *
     * @param \DateTime $datainclusao
     * @return SwVwConsultaprocesso
     */
    public function setDatainclusao(\DateTime $datainclusao = null)
    {
        $this->datainclusao = $datainclusao;
        return $this;
    }

    /**
     * Get datainclusao
     *
     * @return \DateTime
     */
    public function getDatainclusao()
    {
        return $this->datainclusao;
    }

    /**
     * Set codusuarioinclusao
     *
     * @param integer $codusuarioinclusao
     * @return SwVwConsultaprocesso
     */
    public function setCodusuarioinclusao($codusuarioinclusao = null)
    {
        $this->codusuarioinclusao = $codusuarioinclusao;
        return $this;
    }

    /**
     * Get codusuarioinclusao
     *
     * @return integer
     */
    public function getCodusuarioinclusao()
    {
        return $this->codusuarioinclusao;
    }

    /**
     * Set codinteressado
     *
     * @param integer $codinteressado
     * @return SwVwConsultaprocesso
     */
    public function setCodinteressado($codinteressado = null)
    {
        $this->codinteressado = $codinteressado;
        return $this;
    }

    /**
     * Get codinteressado
     *
     * @return integer
     */
    public function getCodinteressado()
    {
        return $this->codinteressado;
    }

    /**
     * Set codclassificacao
     *
     * @param integer $codclassificacao
     * @return SwVwConsultaprocesso
     */
    public function setCodclassificacao($codclassificacao = null)
    {
        $this->codclassificacao = $codclassificacao;
        return $this;
    }

    /**
     * Get codclassificacao
     *
     * @return integer
     */
    public function getCodclassificacao()
    {
        return $this->codclassificacao;
    }

    /**
     * Set codassunto
     *
     * @param integer $codassunto
     * @return SwVwConsultaprocesso
     */
    public function setCodassunto($codassunto = null)
    {
        $this->codassunto = $codassunto;
        return $this;
    }

    /**
     * Get codassunto
     *
     * @return integer
     */
    public function getCodassunto()
    {
        return $this->codassunto;
    }

    /**
     * Set resumoAssunto
     *
     * @param string $resumoAssunto
     * @return SwVwConsultaprocesso
     */
    public function setResumoAssunto($resumoAssunto = null)
    {
        $this->resumoAssunto = $resumoAssunto;
        return $this;
    }

    /**
     * Get resumoAssunto
     *
     * @return string
     */
    public function getResumoAssunto()
    {
        return $this->resumoAssunto;
    }

    /**
     * Set confidencial
     *
     * @param boolean $confidencial
     * @return SwVwConsultaprocesso
     */
    public function setConfidencial($confidencial = null)
    {
        $this->confidencial = $confidencial;
        return $this;
    }

    /**
     * Get confidencial
     *
     * @return boolean
     */
    public function getConfidencial()
    {
        return $this->confidencial;
    }

    /**
     * Set nomsituacao
     *
     * @param string $nomsituacao
     * @return SwVwConsultaprocesso
     */
    public function setNomsituacao($nomsituacao = null)
    {
        $this->nomsituacao = $nomsituacao;
        return $this;
    }

    /**
     * Get nomsituacao
     *
     * @return string
     */
    public function getNomsituacao()
    {
        return $this->nomsituacao;
    }

    /**
     * Set usuarioinclusao
     *
     * @param string $usuarioinclusao
     * @return SwVwConsultaprocesso
     */
    public function setUsuarioinclusao($usuarioinclusao = null)
    {
        $this->usuarioinclusao = $usuarioinclusao;
        return $this;
    }

    /**
     * Get usuarioinclusao
     *
     * @return string
     */
    public function getUsuarioinclusao()
    {
        return $this->usuarioinclusao;
    }

    /**
     * Set nominteressado
     *
     * @param string $nominteressado
     * @return SwVwConsultaprocesso
     */
    public function setNominteressado($nominteressado = null)
    {
        $this->nominteressado = $nominteressado;
        return $this;
    }

    /**
     * Get nominteressado
     *
     * @return string
     */
    public function getNominteressado()
    {
        return $this->nominteressado;
    }

    /**
     * Set codultimoandamento
     *
     * @param integer $codultimoandamento
     * @return SwVwConsultaprocesso
     */
    public function setCodultimoandamento($codultimoandamento = null)
    {
        $this->codultimoandamento = $codultimoandamento;
        return $this;
    }

    /**
     * Get codultimoandamento
     *
     * @return integer
     */
    public function getCodultimoandamento()
    {
        return $this->codultimoandamento;
    }

    /**
     * Set codusuarioultimoandamento
     *
     * @param integer $codusuarioultimoandamento
     * @return SwVwConsultaprocesso
     */
    public function setCodusuarioultimoandamento($codusuarioultimoandamento = null)
    {
        $this->codusuarioultimoandamento = $codusuarioultimoandamento;
        return $this;
    }

    /**
     * Get codusuarioultimoandamento
     *
     * @return integer
     */
    public function getCodusuarioultimoandamento()
    {
        return $this->codusuarioultimoandamento;
    }

    /**
     * Set codorgao
     *
     * @param integer $codorgao
     * @return SwVwConsultaprocesso
     */
    public function setCodorgao($codorgao = null)
    {
        $this->codorgao = $codorgao;
        return $this;
    }

    /**
     * Get codorgao
     *
     * @return integer
     */
    public function getCodorgao()
    {
        return $this->codorgao;
    }

    /**
     * Set dataultimoandamento
     *
     * @param \DateTime $dataultimoandamento
     * @return SwVwConsultaprocesso
     */
    public function setDataultimoandamento(\DateTime $dataultimoandamento = null)
    {
        $this->dataultimoandamento = $dataultimoandamento;
        return $this;
    }

    /**
     * Get dataultimoandamento
     *
     * @return \DateTime
     */
    public function getDataultimoandamento()
    {
        return $this->dataultimoandamento;
    }

    /**
     * Set usuarioultimoandamento
     *
     * @param string $usuarioultimoandamento
     * @return SwVwConsultaprocesso
     */
    public function setUsuarioultimoandamento($usuarioultimoandamento = null)
    {
        $this->usuarioultimoandamento = $usuarioultimoandamento;
        return $this;
    }

    /**
     * Get usuarioultimoandamento
     *
     * @return string
     */
    public function getUsuarioultimoandamento()
    {
        return $this->usuarioultimoandamento;
    }

    /**
     * Set nomclassificacao
     *
     * @param string $nomclassificacao
     * @return SwVwConsultaprocesso
     */
    public function setNomclassificacao($nomclassificacao = null)
    {
        $this->nomclassificacao = $nomclassificacao;
        return $this;
    }

    /**
     * Get nomclassificacao
     *
     * @return string
     */
    public function getNomclassificacao()
    {
        return $this->nomclassificacao;
    }

    /**
     * Set nomassunto
     *
     * @param string $nomassunto
     * @return SwVwConsultaprocesso
     */
    public function setNomassunto($nomassunto = null)
    {
        $this->nomassunto = $nomassunto;
        return $this;
    }

    /**
     * Get nomassunto
     *
     * @return string
     */
    public function getNomassunto()
    {
        return $this->nomassunto;
    }

    /**
     * Set datarecebimento
     *
     * @param \DateTime $datarecebimento
     * @return SwVwConsultaprocesso
     */
    public function setDatarecebimento(\DateTime $datarecebimento = null)
    {
        $this->datarecebimento = $datarecebimento;
        return $this;
    }

    /**
     * Get datarecebimento
     *
     * @return \DateTime
     */
    public function getDatarecebimento()
    {
        return $this->datarecebimento;
    }

    /**
     * Set recebido
     *
     * @param string $recebido
     * @return SwVwConsultaprocesso
     */
    public function setRecebido($recebido = null)
    {
        $this->recebido = $recebido;
        return $this;
    }

    /**
     * Get recebido
     *
     * @return string
     */
    public function getRecebido()
    {
        return $this->recebido;
    }

    /**
     * Set usuariorecebimento
     *
     * @param string $usuariorecebimento
     * @return SwVwConsultaprocesso
     */
    public function setUsuariorecebimento($usuariorecebimento = null)
    {
        $this->usuariorecebimento = $usuariorecebimento;
        return $this;
    }

    /**
     * Get usuariorecebimento
     *
     * @return string
     */
    public function getUsuariorecebimento()
    {
        return $this->usuariorecebimento;
    }

    /**
     * Set codusuariorecebimento
     *
     * @param integer $codusuariorecebimento
     * @return SwVwConsultaprocesso
     */
    public function setCodusuariorecebimento($codusuariorecebimento = null)
    {
        $this->codusuariorecebimento = $codusuariorecebimento;
        return $this;
    }

    /**
     * Get codusuariorecebimento
     *
     * @return integer
     */
    public function getCodusuariorecebimento()
    {
        return $this->codusuariorecebimento;
    }

    /**
     * Set arquivado
     *
     * @param string $arquivado
     * @return SwVwConsultaprocesso
     */
    public function setArquivado($arquivado = null)
    {
        $this->arquivado = $arquivado;
        return $this;
    }

    /**
     * Get arquivado
     *
     * @return string
     */
    public function getArquivado()
    {
        return $this->arquivado;
    }

    /**
     * Set nomhistoricoarquivamento
     *
     * @param string $nomhistoricoarquivamento
     * @return SwVwConsultaprocesso
     */
    public function setNomhistoricoarquivamento($nomhistoricoarquivamento = null)
    {
        $this->nomhistoricoarquivamento = $nomhistoricoarquivamento;
        return $this;
    }

    /**
     * Get nomhistoricoarquivamento
     *
     * @return string
     */
    public function getNomhistoricoarquivamento()
    {
        return $this->nomhistoricoarquivamento;
    }

    /**
     * Set numreciboimpresso
     *
     * @param integer $numreciboimpresso
     * @return SwVwConsultaprocesso
     */
    public function setNumreciboimpresso($numreciboimpresso = null)
    {
        $this->numreciboimpresso = $numreciboimpresso;
        return $this;
    }

    /**
     * Get numreciboimpresso
     *
     * @return integer
     */
    public function getNumreciboimpresso()
    {
        return $this->numreciboimpresso;
    }

    /**
     * Set codprocessoapensado
     *
     * @param integer $codprocessoapensado
     * @return SwVwConsultaprocesso
     */
    public function setCodprocessoapensado($codprocessoapensado = null)
    {
        $this->codprocessoapensado = $codprocessoapensado;
        return $this;
    }

    /**
     * Get codprocessoapensado
     *
     * @return integer
     */
    public function getCodprocessoapensado()
    {
        return $this->codprocessoapensado;
    }

    /**
     * Set exercicioprocessoapensado
     *
     * @param string $exercicioprocessoapensado
     * @return SwVwConsultaprocesso
     */
    public function setExercicioprocessoapensado($exercicioprocessoapensado = null)
    {
        $this->exercicioprocessoapensado = $exercicioprocessoapensado;
        return $this;
    }

    /**
     * Get exercicioprocessoapensado
     *
     * @return string
     */
    public function getExercicioprocessoapensado()
    {
        return $this->exercicioprocessoapensado;
    }

    /**
     * Set dataProcessoApensado
     *
     * @param \DateTime $dataProcessoApensado
     * @return SwVwConsultaprocesso
     */
    public function setDataProcessoApensado(\DateTime $dataProcessoApensado = null)
    {
        $this->dataProcessoApensado = $dataProcessoApensado;
        return $this;
    }

    /**
     * Get dataProcessoApensado
     *
     * @return \DateTime
     */
    public function getDataProcessoApensado()
    {
        return $this->dataProcessoApensado;
    }

    /**
     * Set timestampArquivamento
     *
     * @param \DateTime $timestampArquivamento
     * @return SwVwConsultaprocesso
     */
    public function setTimestampArquivamento(\DateTime $timestampArquivamento = null)
    {
        $this->timestampArquivamento = $timestampArquivamento;
        return $this;
    }

    /**
     * Get timestampArquivamento
     *
     * @return \DateTime
     */
    public function getTimestampArquivamento()
    {
        return $this->timestampArquivamento;
    }

    /**
     * Set apensado
     *
     * @param string $apensado
     * @return SwVwConsultaprocesso
     */
    public function setApensado($apensado = null)
    {
        $this->apensado = $apensado;
        return $this;
    }

    /**
     * Get apensado
     *
     * @return string
     */
    public function getApensado()
    {
        return $this->apensado;
    }
}
