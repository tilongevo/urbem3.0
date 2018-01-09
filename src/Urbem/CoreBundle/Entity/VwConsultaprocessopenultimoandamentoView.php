<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * VwConsultaprocessopenultimoandamentoView
 */
class VwConsultaprocessopenultimoandamentoView
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
     * @var string
     */
    private $nomsituacao;

    /**
     * @var \DateTime
     */
    private $datainclusao;

    /**
     * @var integer
     */
    private $codusuarioinclusao;

    /**
     * @var string
     */
    private $usuarioinclusao;

    /**
     * @var integer
     */
    private $codinteressado;

    /**
     * @var string
     */
    private $nominteressado;

    /**
     * @var integer
     */
    private $codclassificacao;

    /**
     * @var string
     */
    private $nomclassificacao;

    /**
     * @var integer
     */
    private $codassunto;

    /**
     * @var string
     */
    private $nomassunto;

    /**
     * @var string
     */
    private $usuariorecebimento;

    /**
     * @var integer
     */
    private $codusuariorecebimento;

    /**
     * @var \DateTime
     */
    private $datarecebimento;

    /**
     * @var string
     */
    private $recebido;

    /**
     * @var integer
     */
    private $codpenultimoandamento;

    /**
     * @var integer
     */
    private $codusuariopenultimoandamento;

    /**
     * @var string
     */
    private $usuariopenultimoandamento;

    /**
     * @var integer
     */
    private $codpenultimoorgao;

    /**
     * @var \DateTime
     */
    private $datapenultimoandamento;

    /**
     * @var integer
     */
    private $codprocessoapensado;

    /**
     * @var string
     */
    private $exercicioprocessoapensado;

    /**
     * @var string
     */
    private $apensado;

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
     * Set codprocesso
     *
     * @param integer $codprocesso
     * @return SwVwConsultaprocessopenultimoandamento
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
     * @return SwVwConsultaprocessopenultimoandamento
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
     * @return SwVwConsultaprocessopenultimoandamento
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
     * Set nomsituacao
     *
     * @param string $nomsituacao
     * @return SwVwConsultaprocessopenultimoandamento
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
     * Set datainclusao
     *
     * @param \DateTime $datainclusao
     * @return SwVwConsultaprocessopenultimoandamento
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
     * @return SwVwConsultaprocessopenultimoandamento
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
     * Set usuarioinclusao
     *
     * @param string $usuarioinclusao
     * @return SwVwConsultaprocessopenultimoandamento
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
     * Set codinteressado
     *
     * @param integer $codinteressado
     * @return SwVwConsultaprocessopenultimoandamento
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
     * Set nominteressado
     *
     * @param string $nominteressado
     * @return SwVwConsultaprocessopenultimoandamento
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
     * Set codclassificacao
     *
     * @param integer $codclassificacao
     * @return SwVwConsultaprocessopenultimoandamento
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
     * Set nomclassificacao
     *
     * @param string $nomclassificacao
     * @return SwVwConsultaprocessopenultimoandamento
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
     * Set codassunto
     *
     * @param integer $codassunto
     * @return SwVwConsultaprocessopenultimoandamento
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
     * Set nomassunto
     *
     * @param string $nomassunto
     * @return SwVwConsultaprocessopenultimoandamento
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
     * Set usuariorecebimento
     *
     * @param string $usuariorecebimento
     * @return SwVwConsultaprocessopenultimoandamento
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
     * @return SwVwConsultaprocessopenultimoandamento
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
     * Set datarecebimento
     *
     * @param \DateTime $datarecebimento
     * @return SwVwConsultaprocessopenultimoandamento
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
     * @return SwVwConsultaprocessopenultimoandamento
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
     * Set codpenultimoandamento
     *
     * @param integer $codpenultimoandamento
     * @return SwVwConsultaprocessopenultimoandamento
     */
    public function setCodpenultimoandamento($codpenultimoandamento = null)
    {
        $this->codpenultimoandamento = $codpenultimoandamento;
        return $this;
    }

    /**
     * Get codpenultimoandamento
     *
     * @return integer
     */
    public function getCodpenultimoandamento()
    {
        return $this->codpenultimoandamento;
    }

    /**
     * Set codusuariopenultimoandamento
     *
     * @param integer $codusuariopenultimoandamento
     * @return SwVwConsultaprocessopenultimoandamento
     */
    public function setCodusuariopenultimoandamento($codusuariopenultimoandamento = null)
    {
        $this->codusuariopenultimoandamento = $codusuariopenultimoandamento;
        return $this;
    }

    /**
     * Get codusuariopenultimoandamento
     *
     * @return integer
     */
    public function getCodusuariopenultimoandamento()
    {
        return $this->codusuariopenultimoandamento;
    }

    /**
     * Set usuariopenultimoandamento
     *
     * @param string $usuariopenultimoandamento
     * @return SwVwConsultaprocessopenultimoandamento
     */
    public function setUsuariopenultimoandamento($usuariopenultimoandamento = null)
    {
        $this->usuariopenultimoandamento = $usuariopenultimoandamento;
        return $this;
    }

    /**
     * Get usuariopenultimoandamento
     *
     * @return string
     */
    public function getUsuariopenultimoandamento()
    {
        return $this->usuariopenultimoandamento;
    }

    /**
     * Set codpenultimoorgao
     *
     * @param integer $codpenultimoorgao
     * @return SwVwConsultaprocessopenultimoandamento
     */
    public function setCodpenultimoorgao($codpenultimoorgao = null)
    {
        $this->codpenultimoorgao = $codpenultimoorgao;
        return $this;
    }

    /**
     * Get codpenultimoorgao
     *
     * @return integer
     */
    public function getCodpenultimoorgao()
    {
        return $this->codpenultimoorgao;
    }

    /**
     * Set datapenultimoandamento
     *
     * @param \DateTime $datapenultimoandamento
     * @return SwVwConsultaprocessopenultimoandamento
     */
    public function setDatapenultimoandamento(\DateTime $datapenultimoandamento = null)
    {
        $this->datapenultimoandamento = $datapenultimoandamento;
        return $this;
    }

    /**
     * Get datapenultimoandamento
     *
     * @return \DateTime
     */
    public function getDatapenultimoandamento()
    {
        return $this->datapenultimoandamento;
    }

    /**
     * Set codprocessoapensado
     *
     * @param integer $codprocessoapensado
     * @return SwVwConsultaprocessopenultimoandamento
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
     * @return SwVwConsultaprocessopenultimoandamento
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
     * Set apensado
     *
     * @param string $apensado
     * @return SwVwConsultaprocessopenultimoandamento
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

    /**
     * Set arquivado
     *
     * @param string $arquivado
     * @return SwVwConsultaprocessopenultimoandamento
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
     * @return SwVwConsultaprocessopenultimoandamento
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
     * @return SwVwConsultaprocessopenultimoandamento
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
}
