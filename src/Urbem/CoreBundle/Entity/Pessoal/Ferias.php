<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * Ferias
 */
class Ferias
{
    /**
     * PK
     * @var integer
     */
    private $codFerias;

    /**
     * @var integer
     */
    private $codForma;

    /**
     * @var integer
     */
    private $codContrato;

    /**
     * @var integer
     */
    private $faltas = 0;

    /**
     * @var integer
     */
    private $diasFerias;

    /**
     * @var integer
     */
    private $diasAbono = 0;

    /**
     * @var \DateTime
     */
    private $dtInicialAquisitivo;

    /**
     * @var \DateTime
     */
    private $dtFinalAquisitivo;

    /**
     * @var boolean
     */
    private $rescisao = false;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\LancamentoFerias
     */
    private $fkPessoalLancamentoFerias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasLote
     */
    private $fkPessoalLoteFeriasLotes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\FormaPagamentoFerias
     */
    private $fkPessoalFormaPagamentoFerias;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    private $fkPessoalContratoServidor;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalLoteFeriasLotes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codFerias
     *
     * @param integer $codFerias
     * @return Ferias
     */
    public function setCodFerias($codFerias)
    {
        $this->codFerias = $codFerias;
        return $this;
    }

    /**
     * Get codFerias
     *
     * @return integer
     */
    public function getCodFerias()
    {
        return $this->codFerias;
    }

    /**
     * Set codForma
     *
     * @param integer $codForma
     * @return Ferias
     */
    public function setCodForma($codForma)
    {
        $this->codForma = $codForma;
        return $this;
    }

    /**
     * Get codForma
     *
     * @return integer
     */
    public function getCodForma()
    {
        return $this->codForma;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return Ferias
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
     * Set faltas
     *
     * @param integer $faltas
     * @return Ferias
     */
    public function setFaltas($faltas)
    {
        $this->faltas = $faltas;
        return $this;
    }

    /**
     * Get faltas
     *
     * @return integer
     */
    public function getFaltas()
    {
        return $this->faltas;
    }

    /**
     * Set diasFerias
     *
     * @param integer $diasFerias
     * @return Ferias
     */
    public function setDiasFerias($diasFerias)
    {
        $this->diasFerias = $diasFerias;
        return $this;
    }

    /**
     * Get diasFerias
     *
     * @return integer
     */
    public function getDiasFerias()
    {
        return $this->diasFerias;
    }

    /**
     * Set diasAbono
     *
     * @param integer $diasAbono
     * @return Ferias
     */
    public function setDiasAbono($diasAbono)
    {
        $this->diasAbono = $diasAbono;
        return $this;
    }

    /**
     * Get diasAbono
     *
     * @return integer
     */
    public function getDiasAbono()
    {
        return $this->diasAbono;
    }

    /**
     * Set dtInicialAquisitivo
     *
     * @param \DateTime $dtInicialAquisitivo
     * @return Ferias
     */
    public function setDtInicialAquisitivo(\DateTime $dtInicialAquisitivo)
    {
        $this->dtInicialAquisitivo = $dtInicialAquisitivo;
        return $this;
    }

    /**
     * Get dtInicialAquisitivo
     *
     * @return \DateTime
     */
    public function getDtInicialAquisitivo()
    {
        return $this->dtInicialAquisitivo;
    }

    /**
     * Set dtFinalAquisitivo
     *
     * @param \DateTime $dtFinalAquisitivo
     * @return Ferias
     */
    public function setDtFinalAquisitivo(\DateTime $dtFinalAquisitivo)
    {
        $this->dtFinalAquisitivo = $dtFinalAquisitivo;
        return $this;
    }

    /**
     * Get dtFinalAquisitivo
     *
     * @return \DateTime
     */
    public function getDtFinalAquisitivo()
    {
        return $this->dtFinalAquisitivo;
    }

    /**
     * Set rescisao
     *
     * @param boolean $rescisao
     * @return Ferias
     */
    public function setRescisao($rescisao)
    {
        $this->rescisao = $rescisao;
        return $this;
    }

    /**
     * Get rescisao
     *
     * @return boolean
     */
    public function getRescisao()
    {
        return $this->rescisao;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalLoteFeriasLote
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\LoteFeriasLote $fkPessoalLoteFeriasLote
     * @return Ferias
     */
    public function addFkPessoalLoteFeriasLotes(\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasLote $fkPessoalLoteFeriasLote)
    {
        if (false === $this->fkPessoalLoteFeriasLotes->contains($fkPessoalLoteFeriasLote)) {
            $fkPessoalLoteFeriasLote->setFkPessoalFerias($this);
            $this->fkPessoalLoteFeriasLotes->add($fkPessoalLoteFeriasLote);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalLoteFeriasLote
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\LoteFeriasLote $fkPessoalLoteFeriasLote
     */
    public function removeFkPessoalLoteFeriasLotes(\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasLote $fkPessoalLoteFeriasLote)
    {
        $this->fkPessoalLoteFeriasLotes->removeElement($fkPessoalLoteFeriasLote);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalLoteFeriasLotes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasLote
     */
    public function getFkPessoalLoteFeriasLotes()
    {
        return $this->fkPessoalLoteFeriasLotes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalFormaPagamentoFerias
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\FormaPagamentoFerias $fkPessoalFormaPagamentoFerias
     * @return Ferias
     */
    public function setFkPessoalFormaPagamentoFerias(\Urbem\CoreBundle\Entity\Pessoal\FormaPagamentoFerias $fkPessoalFormaPagamentoFerias)
    {
        $this->codForma = $fkPessoalFormaPagamentoFerias->getCodForma();
        $this->fkPessoalFormaPagamentoFerias = $fkPessoalFormaPagamentoFerias;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalFormaPagamentoFerias
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\FormaPagamentoFerias
     */
    public function getFkPessoalFormaPagamentoFerias()
    {
        return $this->fkPessoalFormaPagamentoFerias;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor
     * @return Ferias
     */
    public function setFkPessoalContratoServidor(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor)
    {
        $this->codContrato = $fkPessoalContratoServidor->getCodContrato();
        $this->fkPessoalContratoServidor = $fkPessoalContratoServidor;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalContratoServidor
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    public function getFkPessoalContratoServidor()
    {
        return $this->fkPessoalContratoServidor;
    }

    /**
     * OneToOne (inverse side)
     * Set PessoalLancamentoFerias
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\LancamentoFerias $fkPessoalLancamentoFerias
     * @return Ferias
     */
    public function setFkPessoalLancamentoFerias(\Urbem\CoreBundle\Entity\Pessoal\LancamentoFerias $fkPessoalLancamentoFerias)
    {
        $fkPessoalLancamentoFerias->setFkPessoalFerias($this);
        $this->fkPessoalLancamentoFerias = $fkPessoalLancamentoFerias;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalLancamentoFerias
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\LancamentoFerias
     */
    public function getFkPessoalLancamentoFerias()
    {
        return $this->fkPessoalLancamentoFerias;
    }
}
