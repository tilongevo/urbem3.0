<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * PensaoEvento
 */
class PensaoEvento
{
    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * PK
     * @var integer
     */
    private $codConfiguracaoPensao;

    /**
     * @var integer
     */
    private $codEvento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\PensaoFuncaoPadrao
     */
    private $fkFolhapagamentoPensaoFuncaoPadrao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoPensao
     */
    private $fkFolhapagamentoTipoEventoPensao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    private $fkFolhapagamentoEvento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return PensaoEvento
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return PensaoEvento
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
     * Set codConfiguracaoPensao
     *
     * @param integer $codConfiguracaoPensao
     * @return PensaoEvento
     */
    public function setCodConfiguracaoPensao($codConfiguracaoPensao)
    {
        $this->codConfiguracaoPensao = $codConfiguracaoPensao;
        return $this;
    }

    /**
     * Get codConfiguracaoPensao
     *
     * @return integer
     */
    public function getCodConfiguracaoPensao()
    {
        return $this->codConfiguracaoPensao;
    }

    /**
     * Set codEvento
     *
     * @param integer $codEvento
     * @return PensaoEvento
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
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoPensaoFuncaoPadrao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PensaoFuncaoPadrao $fkFolhapagamentoPensaoFuncaoPadrao
     * @return PensaoEvento
     */
    public function setFkFolhapagamentoPensaoFuncaoPadrao(\Urbem\CoreBundle\Entity\Folhapagamento\PensaoFuncaoPadrao $fkFolhapagamentoPensaoFuncaoPadrao)
    {
        $this->timestamp = $fkFolhapagamentoPensaoFuncaoPadrao->getTimestamp();
        $this->codConfiguracaoPensao = $fkFolhapagamentoPensaoFuncaoPadrao->getCodConfiguracaoPensao();
        $this->fkFolhapagamentoPensaoFuncaoPadrao = $fkFolhapagamentoPensaoFuncaoPadrao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoPensaoFuncaoPadrao
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\PensaoFuncaoPadrao
     */
    public function getFkFolhapagamentoPensaoFuncaoPadrao()
    {
        return $this->fkFolhapagamentoPensaoFuncaoPadrao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoTipoEventoPensao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoPensao $fkFolhapagamentoTipoEventoPensao
     * @return PensaoEvento
     */
    public function setFkFolhapagamentoTipoEventoPensao(\Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoPensao $fkFolhapagamentoTipoEventoPensao)
    {
        $this->codTipo = $fkFolhapagamentoTipoEventoPensao->getCodTipo();
        $this->fkFolhapagamentoTipoEventoPensao = $fkFolhapagamentoTipoEventoPensao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoTipoEventoPensao
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoPensao
     */
    public function getFkFolhapagamentoTipoEventoPensao()
    {
        return $this->fkFolhapagamentoTipoEventoPensao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento
     * @return PensaoEvento
     */
    public function setFkFolhapagamentoEvento(\Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento)
    {
        $this->codEvento = $fkFolhapagamentoEvento->getCodEvento();
        $this->fkFolhapagamentoEvento = $fkFolhapagamentoEvento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoEvento
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    public function getFkFolhapagamentoEvento()
    {
        return $this->fkFolhapagamentoEvento;
    }
}
