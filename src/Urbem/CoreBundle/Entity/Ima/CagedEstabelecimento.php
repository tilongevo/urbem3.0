<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * CagedEstabelecimento
 */
class CagedEstabelecimento
{
    /**
     * PK
     * @var integer
     */
    private $codConfiguracao;

    /**
     * @var string
     */
    private $numCei;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Ima\ConfiguracaoCaged
     */
    private $fkImaConfiguracaoCaged;


    /**
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return CagedEstabelecimento
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
     * Set numCei
     *
     * @param string $numCei
     * @return CagedEstabelecimento
     */
    public function setNumCei($numCei)
    {
        $this->numCei = $numCei;
        return $this;
    }

    /**
     * Get numCei
     *
     * @return string
     */
    public function getNumCei()
    {
        return $this->numCei;
    }

    /**
     * OneToOne (owning side)
     * Set ImaConfiguracaoCaged
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoCaged $fkImaConfiguracaoCaged
     * @return CagedEstabelecimento
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
