<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * FormatoInformacao
 */
class FormatoInformacao
{
    /**
     * PK
     * @var integer
     */
    private $codFormato;

    /**
     * PK
     * @var integer
     */
    private $codDado;

    /**
     * @var string
     */
    private $formato;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Ponto\DadosExportacao
     */
    private $fkPontoDadosExportacao;


    /**
     * Set codFormato
     *
     * @param integer $codFormato
     * @return FormatoInformacao
     */
    public function setCodFormato($codFormato)
    {
        $this->codFormato = $codFormato;
        return $this;
    }

    /**
     * Get codFormato
     *
     * @return integer
     */
    public function getCodFormato()
    {
        return $this->codFormato;
    }

    /**
     * Set codDado
     *
     * @param integer $codDado
     * @return FormatoInformacao
     */
    public function setCodDado($codDado)
    {
        $this->codDado = $codDado;
        return $this;
    }

    /**
     * Get codDado
     *
     * @return integer
     */
    public function getCodDado()
    {
        return $this->codDado;
    }

    /**
     * Set formato
     *
     * @param string $formato
     * @return FormatoInformacao
     */
    public function setFormato($formato)
    {
        $this->formato = $formato;
        return $this;
    }

    /**
     * Get formato
     *
     * @return string
     */
    public function getFormato()
    {
        return $this->formato;
    }

    /**
     * OneToOne (owning side)
     * Set PontoDadosExportacao
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\DadosExportacao $fkPontoDadosExportacao
     * @return FormatoInformacao
     */
    public function setFkPontoDadosExportacao(\Urbem\CoreBundle\Entity\Ponto\DadosExportacao $fkPontoDadosExportacao)
    {
        $this->codFormato = $fkPontoDadosExportacao->getCodFormato();
        $this->codDado = $fkPontoDadosExportacao->getCodDado();
        $this->fkPontoDadosExportacao = $fkPontoDadosExportacao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPontoDadosExportacao
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\DadosExportacao
     */
    public function getFkPontoDadosExportacao()
    {
        return $this->fkPontoDadosExportacao;
    }
}
