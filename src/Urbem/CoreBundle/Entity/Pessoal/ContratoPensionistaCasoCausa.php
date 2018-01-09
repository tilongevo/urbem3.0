<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ContratoPensionistaCasoCausa
 */
class ContratoPensionistaCasoCausa
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
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codCasoCausa;

    /**
     * @var boolean
     */
    private $incFolhaSalario;

    /**
     * @var boolean
     */
    private $incFolhaDecimo;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\CausaObitoPensionista
     */
    private $fkPessoalCausaObitoPensionista;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaCasoCausaNorma
     */
    private $fkPessoalContratoPensionistaCasoCausaNorma;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista
     */
    private $fkPessoalContratoPensionista;

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
        $this->timestamp = new \DateTime;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ContratoPensionistaCasoCausa
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
     * @return ContratoPensionistaCasoCausa
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
     * @param \DateTime $timestamp
     * @return ContratoPensionistaCasoCausa
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
     * Set codCasoCausa
     *
     * @param integer $codCasoCausa
     * @return ContratoPensionistaCasoCausa
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
     * @return ContratoPensionistaCasoCausa
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
     * @return ContratoPensionistaCasoCausa
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
     * @return ContratoPensionistaCasoCausa
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
     * Set PessoalCausaObitoPensionista
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CausaObitoPensionista $fkPessoalCausaObitoPensionista
     * @return ContratoPensionistaCasoCausa
     */
    public function setFkPessoalCausaObitoPensionista(\Urbem\CoreBundle\Entity\Pessoal\CausaObitoPensionista $fkPessoalCausaObitoPensionista)
    {
        $fkPessoalCausaObitoPensionista->setFkPessoalContratoPensionistaCasoCausa($this);
        $this->fkPessoalCausaObitoPensionista = $fkPessoalCausaObitoPensionista;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalCausaObitoPensionista
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\CausaObitoPensionista
     */
    public function getFkPessoalCausaObitoPensionista()
    {
        return $this->fkPessoalCausaObitoPensionista;
    }

    /**
     * OneToOne (inverse side)
     * Set PessoalContratoPensionistaCasoCausaNorma
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaCasoCausaNorma $fkPessoalContratoPensionistaCasoCausaNorma
     * @return ContratoPensionistaCasoCausa
     */
    public function setFkPessoalContratoPensionistaCasoCausaNorma(\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaCasoCausaNorma $fkPessoalContratoPensionistaCasoCausaNorma)
    {
        $fkPessoalContratoPensionistaCasoCausaNorma->setFkPessoalContratoPensionistaCasoCausa($this);
        $this->fkPessoalContratoPensionistaCasoCausaNorma = $fkPessoalContratoPensionistaCasoCausaNorma;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalContratoPensionistaCasoCausaNorma
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaCasoCausaNorma
     */
    public function getFkPessoalContratoPensionistaCasoCausaNorma()
    {
        return $this->fkPessoalContratoPensionistaCasoCausaNorma;
    }

    /**
     * OneToOne (owning side)
     * Set PessoalContratoPensionista
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista $fkPessoalContratoPensionista
     * @return ContratoPensionistaCasoCausa
     */
    public function setFkPessoalContratoPensionista(\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista $fkPessoalContratoPensionista)
    {
        $this->codContrato = $fkPessoalContratoPensionista->getCodContrato();
        $this->fkPessoalContratoPensionista = $fkPessoalContratoPensionista;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPessoalContratoPensionista
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista
     */
    public function getFkPessoalContratoPensionista()
    {
        return $this->fkPessoalContratoPensionista;
    }
}
