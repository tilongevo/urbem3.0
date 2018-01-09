<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ContratoServidorCasoCausa
 */
class ContratoServidorCasoCausa
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * @var \DateTime
     */
    private $dtRescisao;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codCasoCausa;

    /**
     * @var boolean
     */
    private $incFolhaSalario = false;

    /**
     * @var boolean
     */
    private $incFolhaDecimo = false;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\CausaObito
     */
    private $fkPessoalCausaObito;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCasoCausaNorma
     */
    private $fkPessoalContratoServidorCasoCausaNorma;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\AvisoPrevio
     */
    private $fkPessoalAvisoPrevio;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    private $fkPessoalContratoServidor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\CasoCausa
     */
    private $fkPessoalCasoCausa;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ContratoServidorCasoCausa
     */
    public function setCodContrato($codContrato)
    {
        $this->codContrato = $codContrato;
        return $this;
    }

    /**
     * Get codContrato
     *
     * @return integer
     */
    public function getCodContrato()
    {
        return $this->codContrato;
    }

    /**
     * Set dtRescisao
     *
     * @param \DateTime $dtRescisao
     * @return ContratoServidorCasoCausa
     */
    public function setDtRescisao(\DateTime $dtRescisao)
    {
        $this->dtRescisao = $dtRescisao;
        return $this;
    }

    /**
     * Get dtRescisao
     *
     * @return \DateTime
     */
    public function getDtRescisao()
    {
        return $this->dtRescisao;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ContratoServidorCasoCausa
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp = null)
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
     * Set codCasoCausa
     *
     * @param integer $codCasoCausa
     * @return ContratoServidorCasoCausa
     */
    public function setCodCasoCausa($codCasoCausa)
    {
        $this->codCasoCausa = $codCasoCausa;
        return $this;
    }

    /**
     * Get codCasoCausa
     *
     * @return integer
     */
    public function getCodCasoCausa()
    {
        return $this->codCasoCausa;
    }

    /**
     * Set incFolhaSalario
     *
     * @param boolean $incFolhaSalario
     * @return ContratoServidorCasoCausa
     */
    public function setIncFolhaSalario($incFolhaSalario = null)
    {
        $this->incFolhaSalario = $incFolhaSalario;
        return $this;
    }

    /**
     * Get incFolhaSalario
     *
     * @return boolean
     */
    public function getIncFolhaSalario()
    {
        return $this->incFolhaSalario;
    }

    /**
     * Set incFolhaDecimo
     *
     * @param boolean $incFolhaDecimo
     * @return ContratoServidorCasoCausa
     */
    public function setIncFolhaDecimo($incFolhaDecimo = null)
    {
        $this->incFolhaDecimo = $incFolhaDecimo;
        return $this;
    }

    /**
     * Get incFolhaDecimo
     *
     * @return boolean
     */
    public function getIncFolhaDecimo()
    {
        return $this->incFolhaDecimo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalCasoCausa
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CasoCausa $fkPessoalCasoCausa
     * @return ContratoServidorCasoCausa
     */
    public function setFkPessoalCasoCausa(\Urbem\CoreBundle\Entity\Pessoal\CasoCausa $fkPessoalCasoCausa)
    {
        $this->codCasoCausa = $fkPessoalCasoCausa->getCodCasoCausa();
        $this->fkPessoalCasoCausa = $fkPessoalCasoCausa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalCasoCausa
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\CasoCausa
     */
    public function getFkPessoalCasoCausa()
    {
        return $this->fkPessoalCasoCausa;
    }

    /**
     * OneToOne (inverse side)
     * Set PessoalCausaObito
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CausaObito $fkPessoalCausaObito
     * @return ContratoServidorCasoCausa
     */
    public function setFkPessoalCausaObito(\Urbem\CoreBundle\Entity\Pessoal\CausaObito $fkPessoalCausaObito)
    {
        $fkPessoalCausaObito->setFkPessoalContratoServidorCasoCausa($this);
        $this->fkPessoalCausaObito = $fkPessoalCausaObito;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalCausaObito
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\CausaObito
     */
    public function getFkPessoalCausaObito()
    {
        return $this->fkPessoalCausaObito;
    }

    /**
     * OneToOne (inverse side)
     * Set PessoalContratoServidorCasoCausaNorma
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCasoCausaNorma $fkPessoalContratoServidorCasoCausaNorma
     * @return ContratoServidorCasoCausa
     */
    public function setFkPessoalContratoServidorCasoCausaNorma(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCasoCausaNorma $fkPessoalContratoServidorCasoCausaNorma)
    {
        $fkPessoalContratoServidorCasoCausaNorma->setFkPessoalContratoServidorCasoCausa($this);
        $this->fkPessoalContratoServidorCasoCausaNorma = $fkPessoalContratoServidorCasoCausaNorma;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalContratoServidorCasoCausaNorma
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCasoCausaNorma
     */
    public function getFkPessoalContratoServidorCasoCausaNorma()
    {
        return $this->fkPessoalContratoServidorCasoCausaNorma;
    }

    /**
     * OneToOne (inverse side)
     * Set PessoalAvisoPrevio
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AvisoPrevio $fkPessoalAvisoPrevio
     * @return ContratoServidorCasoCausa
     */
    public function setFkPessoalAvisoPrevio(\Urbem\CoreBundle\Entity\Pessoal\AvisoPrevio $fkPessoalAvisoPrevio)
    {
        $fkPessoalAvisoPrevio->setFkPessoalContratoServidorCasoCausa($this);
        $this->fkPessoalAvisoPrevio = $fkPessoalAvisoPrevio;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalAvisoPrevio
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\AvisoPrevio
     */
    public function getFkPessoalAvisoPrevio()
    {
        return $this->fkPessoalAvisoPrevio;
    }

    /**
     * OneToOne (owning side)
     * Set PessoalContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor
     * @return ContratoServidorCasoCausa
     */
    public function setFkPessoalContratoServidor(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor)
    {
        $this->codContrato = $fkPessoalContratoServidor->getCodContrato();
        $this->fkPessoalContratoServidor = $fkPessoalContratoServidor;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPessoalContratoServidor
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    public function getFkPessoalContratoServidor()
    {
        return $this->fkPessoalContratoServidor;
    }
}
