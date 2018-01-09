<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ConfiguracaoTotaisFolha
 */
class ConfiguracaoTotaisFolha
{
    /**
     * PK
     * @var integer
     */
    private $codConfiguracao;

    /**
     * @var string
     */
    private $descricao;


    /**
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return ConfiguracaoTotaisFolha
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
     * Set descricao
     *
     * @param string $descricao
     * @return ConfiguracaoTotaisFolha
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
    * @return string
    */
    public function __toString()
    {
        return (string) $this->descricao;
    }
}
