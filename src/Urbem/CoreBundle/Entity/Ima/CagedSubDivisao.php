<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * CagedSubDivisao
 */
class CagedSubDivisao
{
    /**
     * PK
     * @var integer
     */
    private $codConfiguracao;

    /**
     * PK
     * @var integer
     */
    private $codSubDivisao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ima\ConfiguracaoCaged
     */
    private $fkImaConfiguracaoCaged;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\SubDivisao
     */
    private $fkPessoalSubDivisao;


    /**
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return CagedSubDivisao
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
     * Set codSubDivisao
     *
     * @param integer $codSubDivisao
     * @return CagedSubDivisao
     */
    public function setCodSubDivisao($codSubDivisao)
    {
        $this->codSubDivisao = $codSubDivisao;
        return $this;
    }

    /**
     * Get codSubDivisao
     *
     * @return integer
     */
    public function getCodSubDivisao()
    {
        return $this->codSubDivisao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImaConfiguracaoCaged
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoCaged $fkImaConfiguracaoCaged
     * @return CagedSubDivisao
     */
    public function setFkImaConfiguracaoCaged(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoCaged $fkImaConfiguracaoCaged)
    {
        $this->codConfiguracao = $fkImaConfiguracaoCaged->getCodConfiguracao();
        $this->fkImaConfiguracaoCaged = $fkImaConfiguracaoCaged;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImaConfiguracaoCaged
     *
     * @return \Urbem\CoreBundle\Entity\Ima\ConfiguracaoCaged
     */
    public function getFkImaConfiguracaoCaged()
    {
        return $this->fkImaConfiguracaoCaged;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\SubDivisao $fkPessoalSubDivisao
     * @return CagedSubDivisao
     */
    public function setFkPessoalSubDivisao(\Urbem\CoreBundle\Entity\Pessoal\SubDivisao $fkPessoalSubDivisao)
    {
        $this->codSubDivisao = $fkPessoalSubDivisao->getCodSubDivisao();
        $this->fkPessoalSubDivisao = $fkPessoalSubDivisao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalSubDivisao
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\SubDivisao
     */
    public function getFkPessoalSubDivisao()
    {
        return $this->fkPessoalSubDivisao;
    }
}
