<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * TerminoFiscalizacao
 */
class TerminoFiscalizacao
{
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
     * @var integer
     */
    private $codTipoDocumento;

    /**
     * @var integer
     */
    private $codDocumento;

    /**
     * @var \DateTime
     */
    private $dtTermino;

    /**
     * @var string
     */
    private $observacao;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal
     */
    private $fkFiscalizacaoProcessoFiscal;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\FiscalProcessoFiscal
     */
    private $fkFiscalizacaoFiscalProcessoFiscal;

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
        $this->timestamp = new \DateTime;
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return TerminoFiscalizacao
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
     * @return TerminoFiscalizacao
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
     * Set codTipoDocumento
     *
     * @param integer $codTipoDocumento
     * @return TerminoFiscalizacao
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
     * @return TerminoFiscalizacao
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
     * Set dtTermino
     *
     * @param \DateTime $dtTermino
     * @return TerminoFiscalizacao
     */
    public function setDtTermino(\DateTime $dtTermino)
    {
        $this->dtTermino = $dtTermino;
        return $this;
    }

    /**
     * Get dtTermino
     *
     * @return \DateTime
     */
    public function getDtTermino()
    {
        return $this->dtTermino;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return TerminoFiscalizacao
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
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return TerminoFiscalizacao
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
     * Set fkFiscalizacaoFiscalProcessoFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\FiscalProcessoFiscal $fkFiscalizacaoFiscalProcessoFiscal
     * @return TerminoFiscalizacao
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

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoModeloDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento
     * @return TerminoFiscalizacao
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
     * OneToOne (owning side)
     * Set FiscalizacaoProcessoFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal $fkFiscalizacaoProcessoFiscal
     * @return TerminoFiscalizacao
     */
    public function setFkFiscalizacaoProcessoFiscal(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal $fkFiscalizacaoProcessoFiscal)
    {
        $this->codProcesso = $fkFiscalizacaoProcessoFiscal->getCodProcesso();
        $this->fkFiscalizacaoProcessoFiscal = $fkFiscalizacaoProcessoFiscal;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFiscalizacaoProcessoFiscal
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal
     */
    public function getFkFiscalizacaoProcessoFiscal()
    {
        return $this->fkFiscalizacaoProcessoFiscal;
    }
}
