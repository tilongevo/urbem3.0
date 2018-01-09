<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * ContadorTerceirizado
 */
class ContadorTerceirizado
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $numUnidade;

    /**
     * PK
     * @var integer
     */
    private $numOrgao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel
     */
    private $fkTcmgoUnidadeResponsavel;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica
     */
    private $fkSwCgmPessoaJuridica;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ContadorTerceirizado
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
     * Set numUnidade
     *
     * @param integer $numUnidade
     * @return ContadorTerceirizado
     */
    public function setNumUnidade($numUnidade)
    {
        $this->numUnidade = $numUnidade;
        return $this;
    }

    /**
     * Get numUnidade
     *
     * @return integer
     */
    public function getNumUnidade()
    {
        return $this->numUnidade;
    }

    /**
     * Set numOrgao
     *
     * @param integer $numOrgao
     * @return ContadorTerceirizado
     */
    public function setNumOrgao($numOrgao)
    {
        $this->numOrgao = $numOrgao;
        return $this;
    }

    /**
     * Get numOrgao
     *
     * @return integer
     */
    public function getNumOrgao()
    {
        return $this->numOrgao;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return ContadorTerceirizado
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
     * Set numcgm
     *
     * @param integer $numcgm
     * @return ContadorTerceirizado
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcmgoUnidadeResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel
     * @return ContadorTerceirizado
     */
    public function setFkTcmgoUnidadeResponsavel(\Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel $fkTcmgoUnidadeResponsavel)
    {
        $this->exercicio = $fkTcmgoUnidadeResponsavel->getExercicio();
        $this->numUnidade = $fkTcmgoUnidadeResponsavel->getNumUnidade();
        $this->numOrgao = $fkTcmgoUnidadeResponsavel->getNumOrgao();
        $this->timestamp = $fkTcmgoUnidadeResponsavel->getTimestamp();
        $this->fkTcmgoUnidadeResponsavel = $fkTcmgoUnidadeResponsavel;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmgoUnidadeResponsavel
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\UnidadeResponsavel
     */
    public function getFkTcmgoUnidadeResponsavel()
    {
        return $this->fkTcmgoUnidadeResponsavel;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgmPessoaJuridica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica $fkSwCgmPessoaJuridica
     * @return ContadorTerceirizado
     */
    public function setFkSwCgmPessoaJuridica(\Urbem\CoreBundle\Entity\SwCgmPessoaJuridica $fkSwCgmPessoaJuridica)
    {
        $this->numcgm = $fkSwCgmPessoaJuridica->getNumcgm();
        $this->fkSwCgmPessoaJuridica = $fkSwCgmPessoaJuridica;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgmPessoaJuridica
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica
     */
    public function getFkSwCgmPessoaJuridica()
    {
        return $this->fkSwCgmPessoaJuridica;
    }
}
