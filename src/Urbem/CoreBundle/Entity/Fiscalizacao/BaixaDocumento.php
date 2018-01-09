<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * BaixaDocumento
 */
class BaixaDocumento
{
    /**
     * PK
     * @var integer
     */
    private $codBaixa;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codTipoDocumento;

    /**
     * @var integer
     */
    private $codDocumento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\BaixaAutorizacao
     */
    private $fkFiscalizacaoBaixaAutorizacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento
     */
    private $fkAdministracaoModeloDocumento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codBaixa
     *
     * @param integer $codBaixa
     * @return BaixaDocumento
     */
    public function setCodBaixa($codBaixa)
    {
        $this->codBaixa = $codBaixa;
        return $this;
    }

    /**
     * Get codBaixa
     *
     * @return integer
     */
    public function getCodBaixa()
    {
        return $this->codBaixa;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return BaixaDocumento
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
     * Set codTipoDocumento
     *
     * @param integer $codTipoDocumento
     * @return BaixaDocumento
     */
    public function setCodTipoDocumento($codTipoDocumento)
    {
        $this->codTipoDocumento = $codTipoDocumento;
        return $this;
    }

    /**
     * Get codTipoDocumento
     *
     * @return integer
     */
    public function getCodTipoDocumento()
    {
        return $this->codTipoDocumento;
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return BaixaDocumento
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
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoBaixaAutorizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\BaixaAutorizacao $fkFiscalizacaoBaixaAutorizacao
     * @return BaixaDocumento
     */
    public function setFkFiscalizacaoBaixaAutorizacao(\Urbem\CoreBundle\Entity\Fiscalizacao\BaixaAutorizacao $fkFiscalizacaoBaixaAutorizacao)
    {
        $this->codBaixa = $fkFiscalizacaoBaixaAutorizacao->getCodBaixa();
        $this->fkFiscalizacaoBaixaAutorizacao = $fkFiscalizacaoBaixaAutorizacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoBaixaAutorizacao
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\BaixaAutorizacao
     */
    public function getFkFiscalizacaoBaixaAutorizacao()
    {
        return $this->fkFiscalizacaoBaixaAutorizacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoModeloDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento
     * @return BaixaDocumento
     */
    public function setFkAdministracaoModeloDocumento(\Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento)
    {
        $this->codDocumento = $fkAdministracaoModeloDocumento->getCodDocumento();
        $this->codTipoDocumento = $fkAdministracaoModeloDocumento->getCodTipoDocumento();
        $this->fkAdministracaoModeloDocumento = $fkAdministracaoModeloDocumento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoModeloDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento
     */
    public function getFkAdministracaoModeloDocumento()
    {
        return $this->fkAdministracaoModeloDocumento;
    }
}
