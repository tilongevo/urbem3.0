<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * DelimitadorColunas
 */
class DelimitadorColunas
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
    private $codCampo;

    /**
     * @var integer
     */
    private $coluna;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ponto\FormatoDelimitador
     */
    private $fkPontoFormatoDelimitador;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ponto\FormatoCampos
     */
    private $fkPontoFormatoCampos;


    /**
     * Set codFormato
     *
     * @param integer $codFormato
     * @return DelimitadorColunas
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
     * Set codCampo
     *
     * @param integer $codCampo
     * @return DelimitadorColunas
     */
    public function setCodCampo($codCampo)
    {
        $this->codCampo = $codCampo;
        return $this;
    }

    /**
     * Get codCampo
     *
     * @return integer
     */
    public function getCodCampo()
    {
        return $this->codCampo;
    }

    /**
     * Set coluna
     *
     * @param integer $coluna
     * @return DelimitadorColunas
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
     * ManyToOne (inverse side)
     * Set fkPontoFormatoDelimitador
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\FormatoDelimitador $fkPontoFormatoDelimitador
     * @return DelimitadorColunas
     */
    public function setFkPontoFormatoDelimitador(\Urbem\CoreBundle\Entity\Ponto\FormatoDelimitador $fkPontoFormatoDelimitador)
    {
        $this->codFormato = $fkPontoFormatoDelimitador->getCodFormato();
        $this->fkPontoFormatoDelimitador = $fkPontoFormatoDelimitador;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPontoFormatoDelimitador
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\FormatoDelimitador
     */
    public function getFkPontoFormatoDelimitador()
    {
        return $this->fkPontoFormatoDelimitador;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPontoFormatoCampos
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\FormatoCampos $fkPontoFormatoCampos
     * @return DelimitadorColunas
     */
    public function setFkPontoFormatoCampos(\Urbem\CoreBundle\Entity\Ponto\FormatoCampos $fkPontoFormatoCampos)
    {
        $this->codCampo = $fkPontoFormatoCampos->getCodCampo();
        $this->fkPontoFormatoCampos = $fkPontoFormatoCampos;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPontoFormatoCampos
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\FormatoCampos
     */
    public function getFkPontoFormatoCampos()
    {
        return $this->fkPontoFormatoCampos;
    }
}
