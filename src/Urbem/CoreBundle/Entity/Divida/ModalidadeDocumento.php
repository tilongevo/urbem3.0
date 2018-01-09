<?php
 
namespace Urbem\CoreBundle\Entity\Divida;

/**
 * ModalidadeDocumento
 */
class ModalidadeDocumento
{
    /**
     * PK
     * @var integer
     */
    private $codModalidade;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codDocumento;

    /**
     * @var integer
     */
    private $codTipoDocumento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia
     */
    private $fkDividaModalidadeVigencia;

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
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return ModalidadeDocumento
     */
    public function setCodModalidade($codModalidade)
    {
        $this->codModalidade = $codModalidade;
        return $this;
    }

    /**
     * Get codModalidade
     *
     * @return integer
     */
    public function getCodModalidade()
    {
        return $this->codModalidade;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ModalidadeDocumento
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return ModalidadeDocumento
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
     * Set codTipoDocumento
     *
     * @param integer $codTipoDocumento
     * @return ModalidadeDocumento
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
     * ManyToOne (inverse side)
     * Set fkDividaModalidadeVigencia
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia $fkDividaModalidadeVigencia
     * @return ModalidadeDocumento
     */
    public function setFkDividaModalidadeVigencia(\Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia $fkDividaModalidadeVigencia)
    {
        $this->codModalidade = $fkDividaModalidadeVigencia->getCodModalidade();
        $this->timestamp = $fkDividaModalidadeVigencia->getTimestamp();
        $this->fkDividaModalidadeVigencia = $fkDividaModalidadeVigencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkDividaModalidadeVigencia
     *
     * @return \Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia
     */
    public function getFkDividaModalidadeVigencia()
    {
        return $this->fkDividaModalidadeVigencia;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoModeloDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento
     * @return ModalidadeDocumento
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
