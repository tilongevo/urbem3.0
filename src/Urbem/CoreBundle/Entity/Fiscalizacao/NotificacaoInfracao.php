<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * NotificacaoInfracao
 */
class NotificacaoInfracao
{
    /**
     * PK
     * @var integer
     */
    private $codProcesso;

    /**
     * PK
     * @var integer
     */
    private $codPenalidade;

    /**
     * PK
     * @var integer
     */
    private $codInfracao;

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
     * @var string
     */
    private $observacao;

    /**
     * @var integer
     */
    private $valor;

    /**
     * @var integer
     */
    private $quantidade;

    /**
     * @var integer
     */
    private $baseCalculo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoFiscalizacao
     */
    private $fkFiscalizacaoNotificacaoFiscalizacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\InfracaoPenalidade
     */
    private $fkFiscalizacaoInfracaoPenalidade;

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
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return NotificacaoInfracao
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
     * Set codPenalidade
     *
     * @param integer $codPenalidade
     * @return NotificacaoInfracao
     */
    public function setCodPenalidade($codPenalidade)
    {
        $this->codPenalidade = $codPenalidade;
        return $this;
    }

    /**
     * Get codPenalidade
     *
     * @return integer
     */
    public function getCodPenalidade()
    {
        return $this->codPenalidade;
    }

    /**
     * Set codInfracao
     *
     * @param integer $codInfracao
     * @return NotificacaoInfracao
     */
    public function setCodInfracao($codInfracao)
    {
        $this->codInfracao = $codInfracao;
        return $this;
    }

    /**
     * Get codInfracao
     *
     * @return integer
     */
    public function getCodInfracao()
    {
        return $this->codInfracao;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return NotificacaoInfracao
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
     * @return NotificacaoInfracao
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
     * @return NotificacaoInfracao
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
     * Set observacao
     *
     * @param string $observacao
     * @return NotificacaoInfracao
     */
    public function setObservacao($observacao)
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
     * Set valor
     *
     * @param integer $valor
     * @return NotificacaoInfracao
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
     * Set quantidade
     *
     * @param integer $quantidade
     * @return NotificacaoInfracao
     */
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
        return $this;
    }

    /**
     * Get quantidade
     *
     * @return integer
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * Set baseCalculo
     *
     * @param integer $baseCalculo
     * @return NotificacaoInfracao
     */
    public function setBaseCalculo($baseCalculo)
    {
        $this->baseCalculo = $baseCalculo;
        return $this;
    }

    /**
     * Get baseCalculo
     *
     * @return integer
     */
    public function getBaseCalculo()
    {
        return $this->baseCalculo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoNotificacaoFiscalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoFiscalizacao $fkFiscalizacaoNotificacaoFiscalizacao
     * @return NotificacaoInfracao
     */
    public function setFkFiscalizacaoNotificacaoFiscalizacao(\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoFiscalizacao $fkFiscalizacaoNotificacaoFiscalizacao)
    {
        $this->codProcesso = $fkFiscalizacaoNotificacaoFiscalizacao->getCodProcesso();
        $this->fkFiscalizacaoNotificacaoFiscalizacao = $fkFiscalizacaoNotificacaoFiscalizacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoNotificacaoFiscalizacao
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoFiscalizacao
     */
    public function getFkFiscalizacaoNotificacaoFiscalizacao()
    {
        return $this->fkFiscalizacaoNotificacaoFiscalizacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoInfracaoPenalidade
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\InfracaoPenalidade $fkFiscalizacaoInfracaoPenalidade
     * @return NotificacaoInfracao
     */
    public function setFkFiscalizacaoInfracaoPenalidade(\Urbem\CoreBundle\Entity\Fiscalizacao\InfracaoPenalidade $fkFiscalizacaoInfracaoPenalidade)
    {
        $this->codInfracao = $fkFiscalizacaoInfracaoPenalidade->getCodInfracao();
        $this->codPenalidade = $fkFiscalizacaoInfracaoPenalidade->getCodPenalidade();
        $this->timestamp = $fkFiscalizacaoInfracaoPenalidade->getTimestamp();
        $this->fkFiscalizacaoInfracaoPenalidade = $fkFiscalizacaoInfracaoPenalidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoInfracaoPenalidade
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\InfracaoPenalidade
     */
    public function getFkFiscalizacaoInfracaoPenalidade()
    {
        return $this->fkFiscalizacaoInfracaoPenalidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoModeloDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento
     * @return NotificacaoInfracao
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
