<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * AutoInfracao
 */
class AutoInfracao
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
    private $codAutoFiscalizacao;

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
     * @var string
     */
    private $observacao;

    /**
     * @var integer
     */
    private $codTipoDocumento;

    /**
     * @var integer
     */
    private $codDocumento;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\AutoInfracaoMulta
     */
    private $fkFiscalizacaoAutoInfracaoMulta;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\AutoInfracaoOutros
     */
    private $fkFiscalizacaoAutoInfracaoOutros;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\AutoFiscalizacao
     */
    private $fkFiscalizacaoAutoFiscalizacao;

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
     * @return AutoInfracao
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
     * Set codAutoFiscalizacao
     *
     * @param integer $codAutoFiscalizacao
     * @return AutoInfracao
     */
    public function setCodAutoFiscalizacao($codAutoFiscalizacao)
    {
        $this->codAutoFiscalizacao = $codAutoFiscalizacao;
        return $this;
    }

    /**
     * Get codAutoFiscalizacao
     *
     * @return integer
     */
    public function getCodAutoFiscalizacao()
    {
        return $this->codAutoFiscalizacao;
    }

    /**
     * Set codPenalidade
     *
     * @param integer $codPenalidade
     * @return AutoInfracao
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
     * @return AutoInfracao
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
     * @return AutoInfracao
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
     * Set observacao
     *
     * @param string $observacao
     * @return AutoInfracao
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
     * Set codTipoDocumento
     *
     * @param integer $codTipoDocumento
     * @return AutoInfracao
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
     * @return AutoInfracao
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
     * Set fkFiscalizacaoAutoFiscalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\AutoFiscalizacao $fkFiscalizacaoAutoFiscalizacao
     * @return AutoInfracao
     */
    public function setFkFiscalizacaoAutoFiscalizacao(\Urbem\CoreBundle\Entity\Fiscalizacao\AutoFiscalizacao $fkFiscalizacaoAutoFiscalizacao)
    {
        $this->codProcesso = $fkFiscalizacaoAutoFiscalizacao->getCodProcesso();
        $this->codAutoFiscalizacao = $fkFiscalizacaoAutoFiscalizacao->getCodAutoFiscalizacao();
        $this->fkFiscalizacaoAutoFiscalizacao = $fkFiscalizacaoAutoFiscalizacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoAutoFiscalizacao
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\AutoFiscalizacao
     */
    public function getFkFiscalizacaoAutoFiscalizacao()
    {
        return $this->fkFiscalizacaoAutoFiscalizacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoInfracaoPenalidade
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\InfracaoPenalidade $fkFiscalizacaoInfracaoPenalidade
     * @return AutoInfracao
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
     * @return AutoInfracao
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

    /**
     * OneToOne (inverse side)
     * Set FiscalizacaoAutoInfracaoMulta
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\AutoInfracaoMulta $fkFiscalizacaoAutoInfracaoMulta
     * @return AutoInfracao
     */
    public function setFkFiscalizacaoAutoInfracaoMulta(\Urbem\CoreBundle\Entity\Fiscalizacao\AutoInfracaoMulta $fkFiscalizacaoAutoInfracaoMulta)
    {
        $fkFiscalizacaoAutoInfracaoMulta->setFkFiscalizacaoAutoInfracao($this);
        $this->fkFiscalizacaoAutoInfracaoMulta = $fkFiscalizacaoAutoInfracaoMulta;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFiscalizacaoAutoInfracaoMulta
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\AutoInfracaoMulta
     */
    public function getFkFiscalizacaoAutoInfracaoMulta()
    {
        return $this->fkFiscalizacaoAutoInfracaoMulta;
    }

    /**
     * OneToOne (inverse side)
     * Set FiscalizacaoAutoInfracaoOutros
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\AutoInfracaoOutros $fkFiscalizacaoAutoInfracaoOutros
     * @return AutoInfracao
     */
    public function setFkFiscalizacaoAutoInfracaoOutros(\Urbem\CoreBundle\Entity\Fiscalizacao\AutoInfracaoOutros $fkFiscalizacaoAutoInfracaoOutros)
    {
        $fkFiscalizacaoAutoInfracaoOutros->setFkFiscalizacaoAutoInfracao($this);
        $this->fkFiscalizacaoAutoInfracaoOutros = $fkFiscalizacaoAutoInfracaoOutros;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFiscalizacaoAutoInfracaoOutros
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\AutoInfracaoOutros
     */
    public function getFkFiscalizacaoAutoInfracaoOutros()
    {
        return $this->fkFiscalizacaoAutoInfracaoOutros;
    }
}
