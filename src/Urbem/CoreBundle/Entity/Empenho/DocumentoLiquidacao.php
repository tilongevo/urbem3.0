<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * DocumentoLiquidacao
 */
class DocumentoLiquidacao
{
    /**
     * PK
     * @var integer
     */
    private $codNota;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codTipoDocumentoLiquidacao;

    /**
     * @var string
     */
    private $nroDocumento;

    /**
     * @var \DateTime
     */
    private $dtEmissao;

    /**
     * @var \DateTime
     */
    private $dtEntrada;

    /**
     * @var integer
     */
    private $valor;

    /**
     * @var boolean
     */
    private $excluido = false;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao
     */
    private $fkEmpenhoNotaLiquidacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\TipoDocumentoLiquidacao
     */
    private $fkEmpenhoTipoDocumentoLiquidacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codNota
     *
     * @param integer $codNota
     * @return DocumentoLiquidacao
     */
    public function setCodNota($codNota)
    {
        $this->codNota = $codNota;
        return $this;
    }

    /**
     * Get codNota
     *
     * @return integer
     */
    public function getCodNota()
    {
        return $this->codNota;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return DocumentoLiquidacao
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return DocumentoLiquidacao
     */
    public function setExercicio($exercicio)
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return DocumentoLiquidacao
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimePK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set codTipoDocumentoLiquidacao
     *
     * @param integer $codTipoDocumentoLiquidacao
     * @return DocumentoLiquidacao
     */
    public function setCodTipoDocumentoLiquidacao($codTipoDocumentoLiquidacao)
    {
        $this->codTipoDocumentoLiquidacao = $codTipoDocumentoLiquidacao;
        return $this;
    }

    /**
     * Get codTipoDocumentoLiquidacao
     *
     * @return integer
     */
    public function getCodTipoDocumentoLiquidacao()
    {
        return $this->codTipoDocumentoLiquidacao;
    }

    /**
     * Set nroDocumento
     *
     * @param string $nroDocumento
     * @return DocumentoLiquidacao
     */
    public function setNroDocumento($nroDocumento)
    {
        $this->nroDocumento = $nroDocumento;
        return $this;
    }

    /**
     * Get nroDocumento
     *
     * @return string
     */
    public function getNroDocumento()
    {
        return $this->nroDocumento;
    }

    /**
     * Set dtEmissao
     *
     * @param \DateTime $dtEmissao
     * @return DocumentoLiquidacao
     */
    public function setDtEmissao(\DateTime $dtEmissao)
    {
        $this->dtEmissao = $dtEmissao;
        return $this;
    }

    /**
     * Get dtEmissao
     *
     * @return \DateTime
     */
    public function getDtEmissao()
    {
        return $this->dtEmissao;
    }

    /**
     * Set dtEntrada
     *
     * @param \DateTime $dtEntrada
     * @return DocumentoLiquidacao
     */
    public function setDtEntrada(\DateTime $dtEntrada)
    {
        $this->dtEntrada = $dtEntrada;
        return $this;
    }

    /**
     * Get dtEntrada
     *
     * @return \DateTime
     */
    public function getDtEntrada()
    {
        return $this->dtEntrada;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return DocumentoLiquidacao
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set excluido
     *
     * @param boolean $excluido
     * @return DocumentoLiquidacao
     */
    public function setExcluido($excluido)
    {
        $this->excluido = $excluido;
        return $this;
    }

    /**
     * Get excluido
     *
     * @return boolean
     */
    public function getExcluido()
    {
        return $this->excluido;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoNotaLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao $fkEmpenhoNotaLiquidacao
     * @return DocumentoLiquidacao
     */
    public function setFkEmpenhoNotaLiquidacao(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao $fkEmpenhoNotaLiquidacao)
    {
        $this->exercicio = $fkEmpenhoNotaLiquidacao->getExercicio();
        $this->codNota = $fkEmpenhoNotaLiquidacao->getCodNota();
        $this->codEntidade = $fkEmpenhoNotaLiquidacao->getCodEntidade();
        $this->fkEmpenhoNotaLiquidacao = $fkEmpenhoNotaLiquidacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoNotaLiquidacao
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao
     */
    public function getFkEmpenhoNotaLiquidacao()
    {
        return $this->fkEmpenhoNotaLiquidacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoTipoDocumentoLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\TipoDocumentoLiquidacao $fkEmpenhoTipoDocumentoLiquidacao
     * @return DocumentoLiquidacao
     */
    public function setFkEmpenhoTipoDocumentoLiquidacao(\Urbem\CoreBundle\Entity\Empenho\TipoDocumentoLiquidacao $fkEmpenhoTipoDocumentoLiquidacao)
    {
        $this->codTipoDocumentoLiquidacao = $fkEmpenhoTipoDocumentoLiquidacao->getCodTipoDocumentoLiquidacao();
        $this->fkEmpenhoTipoDocumentoLiquidacao = $fkEmpenhoTipoDocumentoLiquidacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoTipoDocumentoLiquidacao
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\TipoDocumentoLiquidacao
     */
    public function getFkEmpenhoTipoDocumentoLiquidacao()
    {
        return $this->fkEmpenhoTipoDocumentoLiquidacao;
    }
}
