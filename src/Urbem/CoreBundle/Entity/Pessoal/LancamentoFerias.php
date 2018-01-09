<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * LancamentoFerias
 */
class LancamentoFerias
{
    /**
     * PK
     * @var integer
     */
    private $codFerias;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * @var \DateTime
     */
    private $dtInicio;

    /**
     * @var \DateTime
     */
    private $dtFim;

    /**
     * @var \DateTime
     */
    private $dtRetorno;

    /**
     * @var string
     */
    private $mesCompetencia;

    /**
     * @var string
     */
    private $anoCompetencia;

    /**
     * @var boolean
     */
    private $pagar13 = false;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\Ferias
     */
    private $fkPessoalFerias;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\TipoFolha
     */
    private $fkFolhapagamentoTipoFolha;


    /**
     * Set codFerias
     *
     * @param integer $codFerias
     * @return LancamentoFerias
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return LancamentoFerias
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
     * Set dtInicio
     *
     * @param \DateTime $dtInicio
     * @return LancamentoFerias
     */
    public function setDtInicio(\DateTime $dtInicio)
    {
        $this->dtInicio = $dtInicio;
        return $this;
    }

    /**
     * Get dtInicio
     *
     * @return \DateTime
     */
    public function getDtInicio()
    {
        return $this->dtInicio;
    }

    /**
     * Set dtFim
     *
     * @param \DateTime $dtFim
     * @return LancamentoFerias
     */
    public function setDtFim(\DateTime $dtFim)
    {
        $this->dtFim = $dtFim;
        return $this;
    }

    /**
     * Get dtFim
     *
     * @return \DateTime
     */
    public function getDtFim()
    {
        return $this->dtFim;
    }

    /**
     * Set dtRetorno
     *
     * @param \DateTime $dtRetorno
     * @return LancamentoFerias
     */
    public function setDtRetorno(\DateTime $dtRetorno)
    {
        $this->dtRetorno = $dtRetorno;
        return $this;
    }

    /**
     * Get dtRetorno
     *
     * @return \DateTime
     */
    public function getDtRetorno()
    {
        return $this->dtRetorno;
    }

    /**
     * Set mesCompetencia
     *
     * @param string $mesCompetencia
     * @return LancamentoFerias
     */
    public function setMesCompetencia($mesCompetencia)
    {
        $this->mesCompetencia = $mesCompetencia;
        return $this;
    }

    /**
     * Get mesCompetencia
     *
     * @return string
     */
    public function getMesCompetencia()
    {
        return $this->mesCompetencia;
    }

    /**
     * Set anoCompetencia
     *
     * @param string $anoCompetencia
     * @return LancamentoFerias
     */
    public function setAnoCompetencia($anoCompetencia)
    {
        $this->anoCompetencia = $anoCompetencia;
        return $this;
    }

    /**
     * Get anoCompetencia
     *
     * @return string
     */
    public function getAnoCompetencia()
    {
        return $this->anoCompetencia;
    }

    /**
     * Set pagar13
     *
     * @param boolean $pagar13
     * @return LancamentoFerias
     */
    public function setPagar13($pagar13)
    {
        $this->pagar13 = $pagar13;
        return $this;
    }

    /**
     * Get pagar13
     *
     * @return boolean
     */
    public function getPagar13()
    {
        return $this->pagar13;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoTipoFolha
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TipoFolha $fkFolhapagamentoTipoFolha
     * @return LancamentoFerias
     */
    public function setFkFolhapagamentoTipoFolha(\Urbem\CoreBundle\Entity\Folhapagamento\TipoFolha $fkFolhapagamentoTipoFolha)
    {
        $this->codTipo = $fkFolhapagamentoTipoFolha->getCodTipo();
        $this->fkFolhapagamentoTipoFolha = $fkFolhapagamentoTipoFolha;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoTipoFolha
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\TipoFolha
     */
    public function getFkFolhapagamentoTipoFolha()
    {
        return $this->fkFolhapagamentoTipoFolha;
    }

    /**
     * OneToOne (owning side)
     * Set PessoalFerias
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Ferias $fkPessoalFerias
     * @return LancamentoFerias
     */
    public function setFkPessoalFerias(\Urbem\CoreBundle\Entity\Pessoal\Ferias $fkPessoalFerias)
    {
        $this->codFerias = $fkPessoalFerias->getCodFerias();
        $this->fkPessoalFerias = $fkPessoalFerias;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPessoalFerias
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Ferias
     */
    public function getFkPessoalFerias()
    {
        return $this->fkPessoalFerias;
    }
}
