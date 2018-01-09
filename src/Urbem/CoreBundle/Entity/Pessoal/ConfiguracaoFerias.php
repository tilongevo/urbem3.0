<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ConfiguracaoFerias
 */
class ConfiguracaoFerias
{
    /**
     * PK
     * @var integer
     */
    private $codConfiguracao;

    /**
     * @var integer
     */
    private $faltasInicial;

    /**
     * @var integer
     */
    private $faltasFinal;

    /**
     * @var integer
     */
    private $diasGozo;

    /**
     * @var integer
     */
    private $feriasProporcionais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ConfiguracaoFormaPagamentoFerias
     */
    private $fkPessoalConfiguracaoFormaPagamentoFerias;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalConfiguracaoFormaPagamentoFerias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return ConfiguracaoFerias
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
     * Set faltasInicial
     *
     * @param integer $faltasInicial
     * @return ConfiguracaoFerias
     */
    public function setFaltasInicial($faltasInicial)
    {
        $this->faltasInicial = $faltasInicial;
        return $this;
    }

    /**
     * Get faltasInicial
     *
     * @return integer
     */
    public function getFaltasInicial()
    {
        return $this->faltasInicial;
    }

    /**
     * Set faltasFinal
     *
     * @param integer $faltasFinal
     * @return ConfiguracaoFerias
     */
    public function setFaltasFinal($faltasFinal)
    {
        $this->faltasFinal = $faltasFinal;
        return $this;
    }

    /**
     * Get faltasFinal
     *
     * @return integer
     */
    public function getFaltasFinal()
    {
        return $this->faltasFinal;
    }

    /**
     * Set diasGozo
     *
     * @param integer $diasGozo
     * @return ConfiguracaoFerias
     */
    public function setDiasGozo($diasGozo)
    {
        $this->diasGozo = $diasGozo;
        return $this;
    }

    /**
     * Get diasGozo
     *
     * @return integer
     */
    public function getDiasGozo()
    {
        return $this->diasGozo;
    }

    /**
     * Set feriasProporcionais
     *
     * @param integer $feriasProporcionais
     * @return ConfiguracaoFerias
     */
    public function setFeriasProporcionais($feriasProporcionais)
    {
        $this->feriasProporcionais = $feriasProporcionais;
        return $this;
    }

    /**
     * Get feriasProporcionais
     *
     * @return integer
     */
    public function getFeriasProporcionais()
    {
        return $this->feriasProporcionais;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalConfiguracaoFormaPagamentoFerias
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ConfiguracaoFormaPagamentoFerias $fkPessoalConfiguracaoFormaPagamentoFerias
     * @return ConfiguracaoFerias
     */
    public function addFkPessoalConfiguracaoFormaPagamentoFerias(\Urbem\CoreBundle\Entity\Pessoal\ConfiguracaoFormaPagamentoFerias $fkPessoalConfiguracaoFormaPagamentoFerias)
    {
        if (false === $this->fkPessoalConfiguracaoFormaPagamentoFerias->contains($fkPessoalConfiguracaoFormaPagamentoFerias)) {
            $fkPessoalConfiguracaoFormaPagamentoFerias->setFkPessoalConfiguracaoFerias($this);
            $this->fkPessoalConfiguracaoFormaPagamentoFerias->add($fkPessoalConfiguracaoFormaPagamentoFerias);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalConfiguracaoFormaPagamentoFerias
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ConfiguracaoFormaPagamentoFerias $fkPessoalConfiguracaoFormaPagamentoFerias
     */
    public function removeFkPessoalConfiguracaoFormaPagamentoFerias(\Urbem\CoreBundle\Entity\Pessoal\ConfiguracaoFormaPagamentoFerias $fkPessoalConfiguracaoFormaPagamentoFerias)
    {
        $this->fkPessoalConfiguracaoFormaPagamentoFerias->removeElement($fkPessoalConfiguracaoFormaPagamentoFerias);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalConfiguracaoFormaPagamentoFerias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ConfiguracaoFormaPagamentoFerias
     */
    public function getFkPessoalConfiguracaoFormaPagamentoFerias()
    {
        return $this->fkPessoalConfiguracaoFormaPagamentoFerias;
    }
}
