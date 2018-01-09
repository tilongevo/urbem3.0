<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * ExportacaoTcmBa
 */
class ExportacaoTcmBa
{
    /**
     * PK
     * @var integer
     */
    private $codConfiguracao;

    /**
     * @var string
     */
    private $codEntidade;

    /**
     * @var integer
     */
    private $numEntidade;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ExportacaoTcmBaSubDivisao
     */
    private $fkImaExportacaoTcmBaSubDivisoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImaExportacaoTcmBaSubDivisoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return ExportacaoTcmBa
     */
    public function setCodConfiguracao($codConfiguracao)
    {
        $this->codConfiguracao = $codConfiguracao;
        return $this;
    }

    /**
     * Get codConfiguracao
     *
     * @return integer
     */
    public function getCodConfiguracao()
    {
        return $this->codConfiguracao;
    }

    /**
     * Set codEntidade
     *
     * @param string $codEntidade
     * @return ExportacaoTcmBa
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return string
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set numEntidade
     *
     * @param integer $numEntidade
     * @return ExportacaoTcmBa
     */
    public function setNumEntidade($numEntidade)
    {
        $this->numEntidade = $numEntidade;
        return $this;
    }

    /**
     * Get numEntidade
     *
     * @return integer
     */
    public function getNumEntidade()
    {
        return $this->numEntidade;
    }

    /**
     * OneToMany (owning side)
     * Add ImaExportacaoTcmBaSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ExportacaoTcmBaSubDivisao $fkImaExportacaoTcmBaSubDivisao
     * @return ExportacaoTcmBa
     */
    public function addFkImaExportacaoTcmBaSubDivisoes(\Urbem\CoreBundle\Entity\Ima\ExportacaoTcmBaSubDivisao $fkImaExportacaoTcmBaSubDivisao)
    {
        if (false === $this->fkImaExportacaoTcmBaSubDivisoes->contains($fkImaExportacaoTcmBaSubDivisao)) {
            $fkImaExportacaoTcmBaSubDivisao->setFkImaExportacaoTcmBa($this);
            $this->fkImaExportacaoTcmBaSubDivisoes->add($fkImaExportacaoTcmBaSubDivisao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaExportacaoTcmBaSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ExportacaoTcmBaSubDivisao $fkImaExportacaoTcmBaSubDivisao
     */
    public function removeFkImaExportacaoTcmBaSubDivisoes(\Urbem\CoreBundle\Entity\Ima\ExportacaoTcmBaSubDivisao $fkImaExportacaoTcmBaSubDivisao)
    {
        $this->fkImaExportacaoTcmBaSubDivisoes->removeElement($fkImaExportacaoTcmBaSubDivisao);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaExportacaoTcmBaSubDivisoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ExportacaoTcmBaSubDivisao
     */
    public function getFkImaExportacaoTcmBaSubDivisoes()
    {
        return $this->fkImaExportacaoTcmBaSubDivisoes;
    }
}
