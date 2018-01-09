<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * ResponsavelTecnico
 */
class ResponsavelTecnico
{
    /**
     * PK
     * @var integer
     */
    private $cgmResponsavel;

    /**
     * @var integer
     */
    private $codEntidade;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $crc;

    /**
     * @var \DateTime
     */
    private $dtInicio;

    /**
     * @var \DateTime
     */
    private $dtFim;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmgo\TipoResponsavelTecnico
     */
    private $fkTcmgoTipoResponsavelTecnico;


    /**
     * Set cgmResponsavel
     *
     * @param integer $cgmResponsavel
     * @return ResponsavelTecnico
     */
    public function setCgmResponsavel($cgmResponsavel)
    {
        $this->cgmResponsavel = $cgmResponsavel;
        return $this;
    }

    /**
     * Get cgmResponsavel
     *
     * @return integer
     */
    public function getCgmResponsavel()
    {
        return $this->cgmResponsavel;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return ResponsavelTecnico
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ResponsavelTecnico
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return ResponsavelTecnico
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
     * Set crc
     *
     * @param string $crc
     * @return ResponsavelTecnico
     */
    public function setCrc($crc = null)
    {
        $this->crc = $crc;
        return $this;
    }

    /**
     * Get crc
     *
     * @return string
     */
    public function getCrc()
    {
        return $this->crc;
    }

    /**
     * Set dtInicio
     *
     * @param \DateTime $dtInicio
     * @return ResponsavelTecnico
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
     * @return ResponsavelTecnico
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
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return ResponsavelTecnico
     */
    public function setFkOrcamentoEntidade(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
        $this->exercicio = $fkOrcamentoEntidade->getExercicio();
        $this->codEntidade = $fkOrcamentoEntidade->getCodEntidade();
        $this->fkOrcamentoEntidade = $fkOrcamentoEntidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoEntidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    public function getFkOrcamentoEntidade()
    {
        return $this->fkOrcamentoEntidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcmgoTipoResponsavelTecnico
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\TipoResponsavelTecnico $fkTcmgoTipoResponsavelTecnico
     * @return ResponsavelTecnico
     */
    public function setFkTcmgoTipoResponsavelTecnico(\Urbem\CoreBundle\Entity\Tcmgo\TipoResponsavelTecnico $fkTcmgoTipoResponsavelTecnico)
    {
        $this->codTipo = $fkTcmgoTipoResponsavelTecnico->getCodTipo();
        $this->fkTcmgoTipoResponsavelTecnico = $fkTcmgoTipoResponsavelTecnico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmgoTipoResponsavelTecnico
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\TipoResponsavelTecnico
     */
    public function getFkTcmgoTipoResponsavelTecnico()
    {
        return $this->fkTcmgoTipoResponsavelTecnico;
    }

    /**
     * OneToOne (owning side)
     * Set SwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return ResponsavelTecnico
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->cgmResponsavel = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }
}
