<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * DocumentosEntrega
 */
class DocumentosEntrega
{
    /**
     * PK
     * @var string
     */
    private $situacao;

    /**
     * PK
     * @var integer
     */
    private $codDocumento;

    /**
     * PK
     * @var integer
     */
    private $codProcesso;

    /**
     * @var integer
     */
    private $codFiscal;

    /**
     * @var string
     */
    private $observacao;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacaoDocumentos
     */
    private $fkFiscalizacaoInicioFiscalizacaoDocumentos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\FiscalProcessoFiscal
     */
    private $fkFiscalizacaoFiscalProcessoFiscal;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \DateTime;
    }

    /**
     * Set situacao
     *
     * @param string $situacao
     * @return DocumentosEntrega
     */
    public function setSituacao($situacao)
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
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return DocumentosEntrega
     */
    public function setCodDocumento($codDocumento)
    {
        $this->codDocumento = $codDocumento;
        return $this;
    }

    /**
     * Get codDocumento
     *
     * @return integer
     */
    public function getCodDocumento()
    {
        return $this->codDocumento;
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return DocumentosEntrega
     */
    public function setCodProcesso($codProcesso)
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
     * Set codFiscal
     *
     * @param integer $codFiscal
     * @return DocumentosEntrega
     */
    public function setCodFiscal($codFiscal)
    {
        $this->codFiscal = $codFiscal;
        return $this;
    }

    /**
     * Get codFiscal
     *
     * @return integer
     */
    public function getCodFiscal()
    {
        return $this->codFiscal;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return DocumentosEntrega
     */
    public function setObservacao($observacao = null)
    {
        $this->observacao = $observacao;
        return $this;
    }

    /**
     * Get observacao
     *
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return DocumentosEntrega
     */
    public function setTimestamp(\DateTime $timestamp)
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
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoInicioFiscalizacaoDocumentos
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacaoDocumentos $fkFiscalizacaoInicioFiscalizacaoDocumentos
     * @return DocumentosEntrega
     */
    public function setFkFiscalizacaoInicioFiscalizacaoDocumentos(\Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacaoDocumentos $fkFiscalizacaoInicioFiscalizacaoDocumentos)
    {
        $this->codDocumento = $fkFiscalizacaoInicioFiscalizacaoDocumentos->getCodDocumento();
        $this->codProcesso = $fkFiscalizacaoInicioFiscalizacaoDocumentos->getCodProcesso();
        $this->fkFiscalizacaoInicioFiscalizacaoDocumentos = $fkFiscalizacaoInicioFiscalizacaoDocumentos;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoInicioFiscalizacaoDocumentos
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacaoDocumentos
     */
    public function getFkFiscalizacaoInicioFiscalizacaoDocumentos()
    {
        return $this->fkFiscalizacaoInicioFiscalizacaoDocumentos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoFiscalProcessoFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\FiscalProcessoFiscal $fkFiscalizacaoFiscalProcessoFiscal
     * @return DocumentosEntrega
     */
    public function setFkFiscalizacaoFiscalProcessoFiscal(\Urbem\CoreBundle\Entity\Fiscalizacao\FiscalProcessoFiscal $fkFiscalizacaoFiscalProcessoFiscal)
    {
        $this->codProcesso = $fkFiscalizacaoFiscalProcessoFiscal->getCodProcesso();
        $this->codFiscal = $fkFiscalizacaoFiscalProcessoFiscal->getCodFiscal();
        $this->fkFiscalizacaoFiscalProcessoFiscal = $fkFiscalizacaoFiscalProcessoFiscal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoFiscalProcessoFiscal
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\FiscalProcessoFiscal
     */
    public function getFkFiscalizacaoFiscalProcessoFiscal()
    {
        return $this->fkFiscalizacaoFiscalProcessoFiscal;
    }
}
