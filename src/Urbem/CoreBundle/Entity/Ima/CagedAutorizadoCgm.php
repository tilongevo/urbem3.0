<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * CagedAutorizadoCgm
 */
class CagedAutorizadoCgm
{
    /**
     * PK
     * @var integer
     */
    private $codConfiguracao;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var string
     */
    private $numAutorizacao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Ima\ConfiguracaoCaged
     */
    private $fkImaConfiguracaoCaged;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;


    /**
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return CagedAutorizadoCgm
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
     * Set numcgm
     *
     * @param integer $numcgm
     * @return CagedAutorizadoCgm
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
     * Set numAutorizacao
     *
     * @param string $numAutorizacao
     * @return CagedAutorizadoCgm
     */
    public function setNumAutorizacao($numAutorizacao)
    {
        $this->numAutorizacao = $numAutorizacao;
        return $this;
    }

    /**
     * Get numAutorizacao
     *
     * @return string
     */
    public function getNumAutorizacao()
    {
        return $this->numAutorizacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return CagedAutorizadoCgm
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
     * OneToOne (owning side)
     * Set ImaConfiguracaoCaged
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoCaged $fkImaConfiguracaoCaged
     * @return CagedAutorizadoCgm
     */
    public function setFkImaConfiguracaoCaged(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoCaged $fkImaConfiguracaoCaged)
    {
        $this->codConfiguracao = $fkImaConfiguracaoCaged->getCodConfiguracao();
        $this->fkImaConfiguracaoCaged = $fkImaConfiguracaoCaged;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkImaConfiguracaoCaged
     *
     * @return \Urbem\CoreBundle\Entity\Ima\ConfiguracaoCaged
     */
    public function getFkImaConfiguracaoCaged()
    {
        return $this->fkImaConfiguracaoCaged;
    }
}
