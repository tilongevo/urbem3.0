<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ConfiguracaoFormaPagamentoFerias
 */
class ConfiguracaoFormaPagamentoFerias
{
    /**
     * PK
     * @var integer
     */
    private $codRegime;

    /**
     * PK
     * @var integer
     */
    private $codConfiguracao;

    /**
     * PK
     * @var integer
     */
    private $codForma;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Regime
     */
    private $fkPessoalRegime;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\ConfiguracaoFerias
     */
    private $fkPessoalConfiguracaoFerias;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\FormaPagamentoFerias
     */
    private $fkPessoalFormaPagamentoFerias;


    /**
     * Set codRegime
     *
     * @param integer $codRegime
     * @return ConfiguracaoFormaPagamentoFerias
     */
    public function setCodRegime($codRegime)
    {
        $this->codRegime = $codRegime;
        return $this;
    }

    /**
     * Get codRegime
     *
     * @return integer
     */
    public function getCodRegime()
    {
        return $this->codRegime;
    }

    /**
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return ConfiguracaoFormaPagamentoFerias
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
     * Set codForma
     *
     * @param integer $codForma
     * @return ConfiguracaoFormaPagamentoFerias
     */
    public function setCodForma($codForma)
    {
        $this->codForma = $codForma;
        return $this;
    }

    /**
     * Get codForma
     *
     * @return integer
     */
    public function getCodForma()
    {
        return $this->codForma;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalRegime
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Regime $fkPessoalRegime
     * @return ConfiguracaoFormaPagamentoFerias
     */
    public function setFkPessoalRegime(\Urbem\CoreBundle\Entity\Pessoal\Regime $fkPessoalRegime)
    {
        $this->codRegime = $fkPessoalRegime->getCodRegime();
        $this->fkPessoalRegime = $fkPessoalRegime;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalRegime
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Regime
     */
    public function getFkPessoalRegime()
    {
        return $this->fkPessoalRegime;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalConfiguracaoFerias
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ConfiguracaoFerias $fkPessoalConfiguracaoFerias
     * @return ConfiguracaoFormaPagamentoFerias
     */
    public function setFkPessoalConfiguracaoFerias(\Urbem\CoreBundle\Entity\Pessoal\ConfiguracaoFerias $fkPessoalConfiguracaoFerias)
    {
        $this->codConfiguracao = $fkPessoalConfiguracaoFerias->getCodConfiguracao();
        $this->fkPessoalConfiguracaoFerias = $fkPessoalConfiguracaoFerias;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalConfiguracaoFerias
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ConfiguracaoFerias
     */
    public function getFkPessoalConfiguracaoFerias()
    {
        return $this->fkPessoalConfiguracaoFerias;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalFormaPagamentoFerias
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\FormaPagamentoFerias $fkPessoalFormaPagamentoFerias
     * @return ConfiguracaoFormaPagamentoFerias
     */
    public function setFkPessoalFormaPagamentoFerias(\Urbem\CoreBundle\Entity\Pessoal\FormaPagamentoFerias $fkPessoalFormaPagamentoFerias)
    {
        $this->codForma = $fkPessoalFormaPagamentoFerias->getCodForma();
        $this->fkPessoalFormaPagamentoFerias = $fkPessoalFormaPagamentoFerias;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalFormaPagamentoFerias
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\FormaPagamentoFerias
     */
    public function getFkPessoalFormaPagamentoFerias()
    {
        return $this->fkPessoalFormaPagamentoFerias;
    }
}
