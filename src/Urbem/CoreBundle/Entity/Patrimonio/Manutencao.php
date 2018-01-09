<?php
 
namespace Urbem\CoreBundle\Entity\Patrimonio;

/**
 * Manutencao
 */
class Manutencao
{
    /**
     * PK
     * @var integer
     */
    private $codBem;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DatePK
     */
    private $dtAgendamento;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var \DateTime
     */
    private $dtGarantia;

    /**
     * @var \DateTime
     */
    private $dtRealizacao;

    /**
     * @var string
     */
    private $observacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Patrimonio\ManutencaoPaga
     */
    private $fkPatrimonioManutencaoPaga;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Patrimonio\Bem
     */
    private $fkPatrimonioBem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * Set codBem
     *
     * @param integer $codBem
     * @return Manutencao
     */
    public function setCodBem($codBem)
    {
        $this->codBem = $codBem;
        return $this;
    }

    /**
     * Get codBem
     *
     * @return integer
     */
    public function getCodBem()
    {
        return $this->codBem;
    }

    /**
     * Set dtAgendamento
     *
     * @param \Urbem\CoreBundle\Helper\DatePK $dtAgendamento
     * @return Manutencao
     */
    public function setDtAgendamento(\Urbem\CoreBundle\Helper\DatePK $dtAgendamento)
    {
        $this->dtAgendamento = $dtAgendamento;
        return $this;
    }

    /**
     * Get dtAgendamento
     *
     * @return \Urbem\CoreBundle\Helper\DatePK
     */
    public function getDtAgendamento()
    {
        return $this->dtAgendamento;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return Manutencao
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
     * Set dtGarantia
     *
     * @param \DateTime $dtGarantia
     * @return Manutencao
     */
    public function setDtGarantia(\DateTime $dtGarantia = null)
    {
        $this->dtGarantia = $dtGarantia;
        return $this;
    }

    /**
     * Get dtGarantia
     *
     * @return \DateTime
     */
    public function getDtGarantia()
    {
        return $this->dtGarantia;
    }

    /**
     * Set dtRealizacao
     *
     * @param \DateTime $dtRealizacao
     * @return Manutencao
     */
    public function setDtRealizacao(\DateTime $dtRealizacao = null)
    {
        $this->dtRealizacao = $dtRealizacao;
        return $this;
    }

    /**
     * Get dtRealizacao
     *
     * @return \DateTime
     */
    public function getDtRealizacao()
    {
        return $this->dtRealizacao;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return Manutencao
     */
    public function setObservacao($observacao = null)
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
     * ManyToOne (inverse side)
     * Set fkPatrimonioBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Bem $fkPatrimonioBem
     * @return Manutencao
     */
    public function setFkPatrimonioBem(\Urbem\CoreBundle\Entity\Patrimonio\Bem $fkPatrimonioBem)
    {
        $this->codBem = $fkPatrimonioBem->getCodBem();
        $this->fkPatrimonioBem = $fkPatrimonioBem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPatrimonioBem
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\Bem
     */
    public function getFkPatrimonioBem()
    {
        return $this->fkPatrimonioBem;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return Manutencao
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgm = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }

    /**
     * OneToOne (inverse side)
     * Set PatrimonioManutencaoPaga
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\ManutencaoPaga $fkPatrimonioManutencaoPaga
     * @return Manutencao
     */
    public function setFkPatrimonioManutencaoPaga(\Urbem\CoreBundle\Entity\Patrimonio\ManutencaoPaga $fkPatrimonioManutencaoPaga)
    {
        $fkPatrimonioManutencaoPaga->setFkPatrimonioManutencao($this);
        $this->fkPatrimonioManutencaoPaga = $fkPatrimonioManutencaoPaga;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPatrimonioManutencaoPaga
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\ManutencaoPaga
     */
    public function getFkPatrimonioManutencaoPaga()
    {
        return $this->fkPatrimonioManutencaoPaga;
    }

    /**
     * @return Bem
     */
    public function __toString()
    {
        return (string) $this->getFkPatrimonioBem();
    }
}
