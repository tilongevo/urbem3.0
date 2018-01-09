<?php

namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ConfiguracaoContracheque
 */
class ConfiguracaoContracheque
{
    /**
     * PK
     * @var integer
     */
    private $codConfiguracaoContra;

    /**
     * @var string
     */
    private $nomCampo;

    /**
     * @var integer
     */
    private $linha;

    /**
     * @var integer
     */
    private $coluna;

    /**
     * Set codConfiguracaoContra
     *
     * @param integer $codConfiguracaoContra
     * @return ConfiguracaoContracheque
     */
    public function setCodConfiguracaoContra($codConfiguracaoContra)
    {
        $this->codConfiguracaoContra = $codConfiguracaoContra;
        return $this;
    }

    /**
     * Get codConfiguracaoContra
     *
     * @return integer
     */
    public function getCodConfiguracaoContra()
    {
        return $this->codConfiguracaoContra;
    }

    /**
     * Set nomCampo
     *
     * @param string $nomCampo
     * @return ConfiguracaoContracheque
     */
    public function setNomCampo($nomCampo)
    {
        $this->nomCampo = $nomCampo;
        return $this;
    }

    /**
     * Get nomCampo
     *
     * @return string
     */
    public function getNomCampo()
    {
        return $this->nomCampo;
    }

    /**
     * Set linha
     *
     * @param integer $linha
     * @return ConfiguracaoContracheque
     */
    public function setLinha($linha)
    {
        $this->linha = $linha;
        return $this;
    }

    /**
     * Get linha
     *
     * @return integer
     */
    public function getLinha()
    {
        return $this->linha;
    }

    /**
     * Set coluna
     *
     * @param integer $coluna
     * @return ConfiguracaoContracheque
     */
    public function setColuna($coluna)
    {
        $this->coluna = $coluna;
        return $this;
    }

    /**
     * Get coluna
     *
     * @return integer
     */
    public function getColuna()
    {
        return $this->coluna;
    }

    /**
     * @return string
     */
    public function getNomCampoDescricao()
    {
        return 'label.configuracaoContracheque.choices.' . $this->nomCampo;
    }
}
