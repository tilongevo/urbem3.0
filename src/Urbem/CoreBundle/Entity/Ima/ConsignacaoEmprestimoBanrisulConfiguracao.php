<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * ConsignacaoEmprestimoBanrisulConfiguracao
 */
class ConsignacaoEmprestimoBanrisulConfiguracao
{
    /**
     * PK
     * @var integer
     */
    private $codPeriodoMovimentacao;

    /**
     * @var integer
     */
    private $codConvenio;

    /**
     * @var string
     */
    private $nomConvenio;

    /**
     * @var string
     */
    private $anoMes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConsignacaoEmprestimoBanrisul
     */
    private $fkImaConsignacaoEmprestimoBanrisuis;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImaConsignacaoEmprestimoBanrisuis = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codPeriodoMovimentacao
     *
     * @param integer $codPeriodoMovimentacao
     * @return ConsignacaoEmprestimoBanrisulConfiguracao
     */
    public function setCodPeriodoMovimentacao($codPeriodoMovimentacao)
    {
        $this->codPeriodoMovimentacao = $codPeriodoMovimentacao;
        return $this;
    }

    /**
     * Get codPeriodoMovimentacao
     *
     * @return integer
     */
    public function getCodPeriodoMovimentacao()
    {
        return $this->codPeriodoMovimentacao;
    }

    /**
     * Set codConvenio
     *
     * @param integer $codConvenio
     * @return ConsignacaoEmprestimoBanrisulConfiguracao
     */
    public function setCodConvenio($codConvenio)
    {
        $this->codConvenio = $codConvenio;
        return $this;
    }

    /**
     * Get codConvenio
     *
     * @return integer
     */
    public function getCodConvenio()
    {
        return $this->codConvenio;
    }

    /**
     * Set nomConvenio
     *
     * @param string $nomConvenio
     * @return ConsignacaoEmprestimoBanrisulConfiguracao
     */
    public function setNomConvenio($nomConvenio)
    {
        $this->nomConvenio = $nomConvenio;
        return $this;
    }

    /**
     * Get nomConvenio
     *
     * @return string
     */
    public function getNomConvenio()
    {
        return $this->nomConvenio;
    }

    /**
     * Set anoMes
     *
     * @param string $anoMes
     * @return ConsignacaoEmprestimoBanrisulConfiguracao
     */
    public function setAnoMes($anoMes)
    {
        $this->anoMes = $anoMes;
        return $this;
    }

    /**
     * Get anoMes
     *
     * @return string
     */
    public function getAnoMes()
    {
        return $this->anoMes;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConsignacaoEmprestimoBanrisul
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConsignacaoEmprestimoBanrisul $fkImaConsignacaoEmprestimoBanrisul
     * @return ConsignacaoEmprestimoBanrisulConfiguracao
     */
    public function addFkImaConsignacaoEmprestimoBanrisuis(\Urbem\CoreBundle\Entity\Ima\ConsignacaoEmprestimoBanrisul $fkImaConsignacaoEmprestimoBanrisul)
    {
        if (false === $this->fkImaConsignacaoEmprestimoBanrisuis->contains($fkImaConsignacaoEmprestimoBanrisul)) {
            $fkImaConsignacaoEmprestimoBanrisul->setFkImaConsignacaoEmprestimoBanrisulConfiguracao($this);
            $this->fkImaConsignacaoEmprestimoBanrisuis->add($fkImaConsignacaoEmprestimoBanrisul);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConsignacaoEmprestimoBanrisul
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConsignacaoEmprestimoBanrisul $fkImaConsignacaoEmprestimoBanrisul
     */
    public function removeFkImaConsignacaoEmprestimoBanrisuis(\Urbem\CoreBundle\Entity\Ima\ConsignacaoEmprestimoBanrisul $fkImaConsignacaoEmprestimoBanrisul)
    {
        $this->fkImaConsignacaoEmprestimoBanrisuis->removeElement($fkImaConsignacaoEmprestimoBanrisul);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConsignacaoEmprestimoBanrisuis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConsignacaoEmprestimoBanrisul
     */
    public function getFkImaConsignacaoEmprestimoBanrisuis()
    {
        return $this->fkImaConsignacaoEmprestimoBanrisuis;
    }
}
