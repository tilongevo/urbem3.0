<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * TipoEventoConfiguracaoMedia
 */
class TipoEventoConfiguracaoMedia
{
    /**
     * PK
     * @var integer
     */
    private $codConfiguracao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codEvento;

    /**
     * PK
     * @var integer
     */
    private $codCaso;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCaso
     */
    private $fkFolhapagamentoConfiguracaoEventoCaso;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\TipoMedia
     */
    private $fkFolhapagamentoTipoMedia;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return TipoEventoConfiguracaoMedia
     */
    public function setCodConfiguracao($codConfiguracao)
    {
        $this->codConfiguracao = $codConfiguracao;
        return $this;
    }

    /**
     * Get codConfiguracao
     *
     * @return integer
     */
    public function getCodConfiguracao()
    {
        return $this->codConfiguracao;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return TipoEventoConfiguracaoMedia
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
     * Set codEvento
     *
     * @param integer $codEvento
     * @return TipoEventoConfiguracaoMedia
     */
    public function setCodEvento($codEvento)
    {
        $this->codEvento = $codEvento;
        return $this;
    }

    /**
     * Get codEvento
     *
     * @return integer
     */
    public function getCodEvento()
    {
        return $this->codEvento;
    }

    /**
     * Set codCaso
     *
     * @param integer $codCaso
     * @return TipoEventoConfiguracaoMedia
     */
    public function setCodCaso($codCaso)
    {
        $this->codCaso = $codCaso;
        return $this;
    }

    /**
     * Get codCaso
     *
     * @return integer
     */
    public function getCodCaso()
    {
        return $this->codCaso;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoEventoConfiguracaoMedia
     */
    public function setCodTipo($codTipo)
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
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoTipoMedia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TipoMedia $fkFolhapagamentoTipoMedia
     * @return TipoEventoConfiguracaoMedia
     */
    public function setFkFolhapagamentoTipoMedia(\Urbem\CoreBundle\Entity\Folhapagamento\TipoMedia $fkFolhapagamentoTipoMedia)
    {
        $this->codTipo = $fkFolhapagamentoTipoMedia->getCodTipo();
        $this->fkFolhapagamentoTipoMedia = $fkFolhapagamentoTipoMedia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoTipoMedia
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\TipoMedia
     */
    public function getFkFolhapagamentoTipoMedia()
    {
        return $this->fkFolhapagamentoTipoMedia;
    }

    /**
     * OneToOne (owning side)
     * Set FolhapagamentoConfiguracaoEventoCaso
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCaso $fkFolhapagamentoConfiguracaoEventoCaso
     * @return TipoEventoConfiguracaoMedia
     */
    public function setFkFolhapagamentoConfiguracaoEventoCaso(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCaso $fkFolhapagamentoConfiguracaoEventoCaso)
    {
        $this->codCaso = $fkFolhapagamentoConfiguracaoEventoCaso->getCodCaso();
        $this->codEvento = $fkFolhapagamentoConfiguracaoEventoCaso->getCodEvento();
        $this->timestamp = $fkFolhapagamentoConfiguracaoEventoCaso->getTimestamp();
        $this->codConfiguracao = $fkFolhapagamentoConfiguracaoEventoCaso->getCodConfiguracao();
        $this->fkFolhapagamentoConfiguracaoEventoCaso = $fkFolhapagamentoConfiguracaoEventoCaso;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFolhapagamentoConfiguracaoEventoCaso
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCaso
     */
    public function getFkFolhapagamentoConfiguracaoEventoCaso()
    {
        return $this->fkFolhapagamentoConfiguracaoEventoCaso;
    }
}
