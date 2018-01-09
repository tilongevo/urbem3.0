<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * ImportacaoPontoErro
 */
class ImportacaoPontoErro
{
    /**
     * PK
     * @var integer
     */
    private $codPontoErro;

    /**
     * @var integer
     */
    private $codFormato;

    /**
     * @var integer
     */
    private $codImportacaoErro;

    /**
     * @var string
     */
    private $linha;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ponto\FormatoImportacao
     */
    private $fkPontoFormatoImportacao;


    /**
     * Set codPontoErro
     *
     * @param integer $codPontoErro
     * @return ImportacaoPontoErro
     */
    public function setCodPontoErro($codPontoErro)
    {
        $this->codPontoErro = $codPontoErro;
        return $this;
    }

    /**
     * Get codPontoErro
     *
     * @return integer
     */
    public function getCodPontoErro()
    {
        return $this->codPontoErro;
    }

    /**
     * Set codFormato
     *
     * @param integer $codFormato
     * @return ImportacaoPontoErro
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
     * Set codImportacaoErro
     *
     * @param integer $codImportacaoErro
     * @return ImportacaoPontoErro
     */
    public function setCodImportacaoErro($codImportacaoErro)
    {
        $this->codImportacaoErro = $codImportacaoErro;
        return $this;
    }

    /**
     * Get codImportacaoErro
     *
     * @return integer
     */
    public function getCodImportacaoErro()
    {
        return $this->codImportacaoErro;
    }

    /**
     * Set linha
     *
     * @param string $linha
     * @return ImportacaoPontoErro
     */
    public function setLinha($linha)
    {
        $this->linha = $linha;
        return $this;
    }

    /**
     * Get linha
     *
     * @return string
     */
    public function getLinha()
    {
        return $this->linha;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPontoFormatoImportacao
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\FormatoImportacao $fkPontoFormatoImportacao
     * @return ImportacaoPontoErro
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
}
