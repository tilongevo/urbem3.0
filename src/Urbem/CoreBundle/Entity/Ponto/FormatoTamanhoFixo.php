<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * FormatoTamanhoFixo
 */
class FormatoTamanhoFixo
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
    private $posicaoInicial;

    /**
     * @var integer
     */
    private $posicaoFinal;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ponto\FormatoImportacao
     */
    private $fkPontoFormatoImportacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ponto\FormatoCampos
     */
    private $fkPontoFormatoCampos;


    /**
     * Set codFormato
     *
     * @param integer $codFormato
     * @return FormatoTamanhoFixo
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
     * @return FormatoTamanhoFixo
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
     * Set posicaoInicial
     *
     * @param integer $posicaoInicial
     * @return FormatoTamanhoFixo
     */
    public function setPosicaoInicial($posicaoInicial)
    {
        $this->posicaoInicial = $posicaoInicial;
        return $this;
    }

    /**
     * Get posicaoInicial
     *
     * @return integer
     */
    public function getPosicaoInicial()
    {
        return $this->posicaoInicial;
    }

    /**
     * Set posicaoFinal
     *
     * @param integer $posicaoFinal
     * @return FormatoTamanhoFixo
     */
    public function setPosicaoFinal($posicaoFinal)
    {
        $this->posicaoFinal = $posicaoFinal;
        return $this;
    }

    /**
     * Get posicaoFinal
     *
     * @return integer
     */
    public function getPosicaoFinal()
    {
        return $this->posicaoFinal;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPontoFormatoImportacao
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\FormatoImportacao $fkPontoFormatoImportacao
     * @return FormatoTamanhoFixo
     */
    public function setFkPontoFormatoImportacao(\Urbem\CoreBundle\Entity\Ponto\FormatoImportacao $fkPontoFormatoImportacao)
    {
        $this->codFormato = $fkPontoFormatoImportacao->getCodFormato();
        $this->fkPontoFormatoImportacao = $fkPontoFormatoImportacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPontoFormatoImportacao
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\FormatoImportacao
     */
    public function getFkPontoFormatoImportacao()
    {
        return $this->fkPontoFormatoImportacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPontoFormatoCampos
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\FormatoCampos $fkPontoFormatoCampos
     * @return FormatoTamanhoFixo
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
