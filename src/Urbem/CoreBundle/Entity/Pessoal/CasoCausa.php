<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * CasoCausa
 */
class CasoCausa
{
    /**
     * PK
     * @var integer
     */
    private $codCasoCausa;

    /**
     * @var integer
     */
    private $codCausaRescisao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var boolean
     */
    private $pagaAvisoPrevio;

    /**
     * @var boolean
     */
    private $pagaFeriasVencida;

    /**
     * @var string
     */
    private $codSaqueFgts;

    /**
     * @var integer
     */
    private $percContSocial;

    /**
     * @var boolean
     */
    private $incFgtsFerias;

    /**
     * @var boolean
     */
    private $incFgtsAvisoPrevio;

    /**
     * @var boolean
     */
    private $incFgts13;

    /**
     * @var boolean
     */
    private $incIrrfFerias;

    /**
     * @var boolean
     */
    private $incIrrfAvisoPrevio;

    /**
     * @var boolean
     */
    private $incIrrf13;

    /**
     * @var boolean
     */
    private $incPrevFerias;

    /**
     * @var boolean
     */
    private $incPrevAvisoPrevio;

    /**
     * @var boolean
     */
    private $incPrev13;

    /**
     * @var boolean
     */
    private $pagaFeriasProporcional;

    /**
     * @var boolean
     */
    private $indenArt479;

    /**
     * @var integer
     */
    private $multaFgts;

    /**
     * @var integer
     */
    private $codPeriodo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CasoCausaSubDivisao
     */
    private $fkPessoalCasoCausaSubDivisoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCasoCausa
     */
    private $fkPessoalContratoServidorCasoCausas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaCasoCausa
     */
    private $fkPessoalContratoPensionistaCasoCausas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\CausaRescisao
     */
    private $fkPessoalCausaRescisao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\PeriodoCaso
     */
    private $fkPessoalPeriodoCaso;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalCasoCausaSubDivisoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorCasoCausas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoPensionistaCasoCausas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codCasoCausa
     *
     * @param integer $codCasoCausa
     * @return CasoCausa
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
     * Set codCausaRescisao
     *
     * @param integer $codCausaRescisao
     * @return CasoCausa
     */
    public function setCodCausaRescisao($codCausaRescisao)
    {
        $this->codCausaRescisao = $codCausaRescisao;
        return $this;
    }

    /**
     * Get codCausaRescisao
     *
     * @return integer
     */
    public function getCodCausaRescisao()
    {
        return $this->codCausaRescisao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return CasoCausa
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set pagaAvisoPrevio
     *
     * @param boolean $pagaAvisoPrevio
     * @return CasoCausa
     */
    public function setPagaAvisoPrevio($pagaAvisoPrevio)
    {
        $this->pagaAvisoPrevio = $pagaAvisoPrevio;
        return $this;
    }

    /**
     * Get pagaAvisoPrevio
     *
     * @return boolean
     */
    public function getPagaAvisoPrevio()
    {
        return $this->pagaAvisoPrevio;
    }

    /**
     * Set pagaFeriasVencida
     *
     * @param boolean $pagaFeriasVencida
     * @return CasoCausa
     */
    public function setPagaFeriasVencida($pagaFeriasVencida)
    {
        $this->pagaFeriasVencida = $pagaFeriasVencida;
        return $this;
    }

    /**
     * Get pagaFeriasVencida
     *
     * @return boolean
     */
    public function getPagaFeriasVencida()
    {
        return $this->pagaFeriasVencida;
    }

    /**
     * Set codSaqueFgts
     *
     * @param string $codSaqueFgts
     * @return CasoCausa
     */
    public function setCodSaqueFgts($codSaqueFgts = null)
    {
        $this->codSaqueFgts = $codSaqueFgts;
        return $this;
    }

    /**
     * Get codSaqueFgts
     *
     * @return string
     */
    public function getCodSaqueFgts()
    {
        return $this->codSaqueFgts;
    }

    /**
     * Set percContSocial
     *
     * @param integer $percContSocial
     * @return CasoCausa
     */
    public function setPercContSocial($percContSocial = null)
    {
        $this->percContSocial = $percContSocial;
        return $this;
    }

    /**
     * Get percContSocial
     *
     * @return integer
     */
    public function getPercContSocial()
    {
        return $this->percContSocial;
    }

    /**
     * Set incFgtsFerias
     *
     * @param boolean $incFgtsFerias
     * @return CasoCausa
     */
    public function setIncFgtsFerias($incFgtsFerias)
    {
        $this->incFgtsFerias = $incFgtsFerias;
        return $this;
    }

    /**
     * Get incFgtsFerias
     *
     * @return boolean
     */
    public function getIncFgtsFerias()
    {
        return $this->incFgtsFerias;
    }

    /**
     * Set incFgtsAvisoPrevio
     *
     * @param boolean $incFgtsAvisoPrevio
     * @return CasoCausa
     */
    public function setIncFgtsAvisoPrevio($incFgtsAvisoPrevio)
    {
        $this->incFgtsAvisoPrevio = $incFgtsAvisoPrevio;
        return $this;
    }

    /**
     * Get incFgtsAvisoPrevio
     *
     * @return boolean
     */
    public function getIncFgtsAvisoPrevio()
    {
        return $this->incFgtsAvisoPrevio;
    }

    /**
     * Set incFgts13
     *
     * @param boolean $incFgts13
     * @return CasoCausa
     */
    public function setIncFgts13($incFgts13)
    {
        $this->incFgts13 = $incFgts13;
        return $this;
    }

    /**
     * Get incFgts13
     *
     * @return boolean
     */
    public function getIncFgts13()
    {
        return $this->incFgts13;
    }

    /**
     * Set incIrrfFerias
     *
     * @param boolean $incIrrfFerias
     * @return CasoCausa
     */
    public function setIncIrrfFerias($incIrrfFerias)
    {
        $this->incIrrfFerias = $incIrrfFerias;
        return $this;
    }

    /**
     * Get incIrrfFerias
     *
     * @return boolean
     */
    public function getIncIrrfFerias()
    {
        return $this->incIrrfFerias;
    }

    /**
     * Set incIrrfAvisoPrevio
     *
     * @param boolean $incIrrfAvisoPrevio
     * @return CasoCausa
     */
    public function setIncIrrfAvisoPrevio($incIrrfAvisoPrevio)
    {
        $this->incIrrfAvisoPrevio = $incIrrfAvisoPrevio;
        return $this;
    }

    /**
     * Get incIrrfAvisoPrevio
     *
     * @return boolean
     */
    public function getIncIrrfAvisoPrevio()
    {
        return $this->incIrrfAvisoPrevio;
    }

    /**
     * Set incIrrf13
     *
     * @param boolean $incIrrf13
     * @return CasoCausa
     */
    public function setIncIrrf13($incIrrf13)
    {
        $this->incIrrf13 = $incIrrf13;
        return $this;
    }

    /**
     * Get incIrrf13
     *
     * @return boolean
     */
    public function getIncIrrf13()
    {
        return $this->incIrrf13;
    }

    /**
     * Set incPrevFerias
     *
     * @param boolean $incPrevFerias
     * @return CasoCausa
     */
    public function setIncPrevFerias($incPrevFerias)
    {
        $this->incPrevFerias = $incPrevFerias;
        return $this;
    }

    /**
     * Get incPrevFerias
     *
     * @return boolean
     */
    public function getIncPrevFerias()
    {
        return $this->incPrevFerias;
    }

    /**
     * Set incPrevAvisoPrevio
     *
     * @param boolean $incPrevAvisoPrevio
     * @return CasoCausa
     */
    public function setIncPrevAvisoPrevio($incPrevAvisoPrevio)
    {
        $this->incPrevAvisoPrevio = $incPrevAvisoPrevio;
        return $this;
    }

    /**
     * Get incPrevAvisoPrevio
     *
     * @return boolean
     */
    public function getIncPrevAvisoPrevio()
    {
        return $this->incPrevAvisoPrevio;
    }

    /**
     * Set incPrev13
     *
     * @param boolean $incPrev13
     * @return CasoCausa
     */
    public function setIncPrev13($incPrev13)
    {
        $this->incPrev13 = $incPrev13;
        return $this;
    }

    /**
     * Get incPrev13
     *
     * @return boolean
     */
    public function getIncPrev13()
    {
        return $this->incPrev13;
    }

    /**
     * Set pagaFeriasProporcional
     *
     * @param boolean $pagaFeriasProporcional
     * @return CasoCausa
     */
    public function setPagaFeriasProporcional($pagaFeriasProporcional)
    {
        $this->pagaFeriasProporcional = $pagaFeriasProporcional;
        return $this;
    }

    /**
     * Get pagaFeriasProporcional
     *
     * @return boolean
     */
    public function getPagaFeriasProporcional()
    {
        return $this->pagaFeriasProporcional;
    }

    /**
     * Set indenArt479
     *
     * @param boolean $indenArt479
     * @return CasoCausa
     */
    public function setIndenArt479($indenArt479)
    {
        $this->indenArt479 = $indenArt479;
        return $this;
    }

    /**
     * Get indenArt479
     *
     * @return boolean
     */
    public function getIndenArt479()
    {
        return $this->indenArt479;
    }

    /**
     * Set multaFgts
     *
     * @param integer $multaFgts
     * @return CasoCausa
     */
    public function setMultaFgts($multaFgts = null)
    {
        $this->multaFgts = $multaFgts;
        return $this;
    }

    /**
     * Get multaFgts
     *
     * @return integer
     */
    public function getMultaFgts()
    {
        return $this->multaFgts;
    }

    /**
     * Set codPeriodo
     *
     * @param integer $codPeriodo
     * @return CasoCausa
     */
    public function setCodPeriodo($codPeriodo)
    {
        $this->codPeriodo = $codPeriodo;
        return $this;
    }

    /**
     * Get codPeriodo
     *
     * @return integer
     */
    public function getCodPeriodo()
    {
        return $this->codPeriodo;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalCasoCausaSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CasoCausaSubDivisao $fkPessoalCasoCausaSubDivisao
     * @return CasoCausa
     */
    public function addFkPessoalCasoCausaSubDivisoes(\Urbem\CoreBundle\Entity\Pessoal\CasoCausaSubDivisao $fkPessoalCasoCausaSubDivisao)
    {
        if (false === $this->fkPessoalCasoCausaSubDivisoes->contains($fkPessoalCasoCausaSubDivisao)) {
            $fkPessoalCasoCausaSubDivisao->setFkPessoalCasoCausa($this);
            $this->fkPessoalCasoCausaSubDivisoes->add($fkPessoalCasoCausaSubDivisao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalCasoCausaSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CasoCausaSubDivisao $fkPessoalCasoCausaSubDivisao
     */
    public function removeFkPessoalCasoCausaSubDivisoes(\Urbem\CoreBundle\Entity\Pessoal\CasoCausaSubDivisao $fkPessoalCasoCausaSubDivisao)
    {
        $this->fkPessoalCasoCausaSubDivisoes->removeElement($fkPessoalCasoCausaSubDivisao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalCasoCausaSubDivisoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CasoCausaSubDivisao
     */
    public function getFkPessoalCasoCausaSubDivisoes()
    {
        return $this->fkPessoalCasoCausaSubDivisoes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorCasoCausa
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCasoCausa $fkPessoalContratoServidorCasoCausa
     * @return CasoCausa
     */
    public function addFkPessoalContratoServidorCasoCausas(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCasoCausa $fkPessoalContratoServidorCasoCausa)
    {
        if (false === $this->fkPessoalContratoServidorCasoCausas->contains($fkPessoalContratoServidorCasoCausa)) {
            $fkPessoalContratoServidorCasoCausa->setFkPessoalCasoCausa($this);
            $this->fkPessoalContratoServidorCasoCausas->add($fkPessoalContratoServidorCasoCausa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorCasoCausa
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCasoCausa $fkPessoalContratoServidorCasoCausa
     */
    public function removeFkPessoalContratoServidorCasoCausas(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCasoCausa $fkPessoalContratoServidorCasoCausa)
    {
        $this->fkPessoalContratoServidorCasoCausas->removeElement($fkPessoalContratoServidorCasoCausa);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorCasoCausas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCasoCausa
     */
    public function getFkPessoalContratoServidorCasoCausas()
    {
        return $this->fkPessoalContratoServidorCasoCausas;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoPensionistaCasoCausa
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaCasoCausa $fkPessoalContratoPensionistaCasoCausa
     * @return CasoCausa
     */
    public function addFkPessoalContratoPensionistaCasoCausas(\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaCasoCausa $fkPessoalContratoPensionistaCasoCausa)
    {
        if (false === $this->fkPessoalContratoPensionistaCasoCausas->contains($fkPessoalContratoPensionistaCasoCausa)) {
            $fkPessoalContratoPensionistaCasoCausa->setFkPessoalCasoCausa($this);
            $this->fkPessoalContratoPensionistaCasoCausas->add($fkPessoalContratoPensionistaCasoCausa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoPensionistaCasoCausa
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaCasoCausa $fkPessoalContratoPensionistaCasoCausa
     */
    public function removeFkPessoalContratoPensionistaCasoCausas(\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaCasoCausa $fkPessoalContratoPensionistaCasoCausa)
    {
        $this->fkPessoalContratoPensionistaCasoCausas->removeElement($fkPessoalContratoPensionistaCasoCausa);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoPensionistaCasoCausas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaCasoCausa
     */
    public function getFkPessoalContratoPensionistaCasoCausas()
    {
        return $this->fkPessoalContratoPensionistaCasoCausas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalCausaRescisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CausaRescisao $fkPessoalCausaRescisao
     * @return CasoCausa
     */
    public function setFkPessoalCausaRescisao(\Urbem\CoreBundle\Entity\Pessoal\CausaRescisao $fkPessoalCausaRescisao)
    {
        $this->codCausaRescisao = $fkPessoalCausaRescisao->getCodCausaRescisao();
        $this->fkPessoalCausaRescisao = $fkPessoalCausaRescisao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalCausaRescisao
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\CausaRescisao
     */
    public function getFkPessoalCausaRescisao()
    {
        return $this->fkPessoalCausaRescisao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalPeriodoCaso
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\PeriodoCaso $fkPessoalPeriodoCaso
     * @return CasoCausa
     */
    public function setFkPessoalPeriodoCaso(\Urbem\CoreBundle\Entity\Pessoal\PeriodoCaso $fkPessoalPeriodoCaso)
    {
        $this->codPeriodo = $fkPessoalPeriodoCaso->getCodPeriodo();
        $this->fkPessoalPeriodoCaso = $fkPessoalPeriodoCaso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalPeriodoCaso
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\PeriodoCaso
     */
    public function getFkPessoalPeriodoCaso()
    {
        return $this->fkPessoalPeriodoCaso;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->descricao;
    }
}
