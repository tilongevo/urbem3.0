<?php
 
namespace Urbem\CoreBundle\Entity\Tcern;

/**
 * NotaFiscal
 */
class NotaFiscal
{
    /**
     * PK
     * @var integer
     */
    private $codNotaLiquidacao;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $nroNota;

    /**
     * @var string
     */
    private $nroSerie;

    /**
     * @var \DateTime
     */
    private $dataEmissao;

    /**
     * @var string
     */
    private $codValidacao;

    /**
     * @var string
     */
    private $modelo;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao
     */
    private $fkEmpenhoNotaLiquidacao;


    /**
     * Set codNotaLiquidacao
     *
     * @param integer $codNotaLiquidacao
     * @return NotaFiscal
     */
    public function setCodNotaLiquidacao($codNotaLiquidacao)
    {
        $this->codNotaLiquidacao = $codNotaLiquidacao;
        return $this;
    }

    /**
     * Get codNotaLiquidacao
     *
     * @return integer
     */
    public function getCodNotaLiquidacao()
    {
        return $this->codNotaLiquidacao;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return NotaFiscal
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return NotaFiscal
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set nroNota
     *
     * @param string $nroNota
     * @return NotaFiscal
     */
    public function setNroNota($nroNota = null)
    {
        $this->nroNota = $nroNota;
        return $this;
    }

    /**
     * Get nroNota
     *
     * @return string
     */
    public function getNroNota()
    {
        return $this->nroNota;
    }

    /**
     * Set nroSerie
     *
     * @param string $nroSerie
     * @return NotaFiscal
     */
    public function setNroSerie($nroSerie = null)
    {
        $this->nroSerie = $nroSerie;
        return $this;
    }

    /**
     * Get nroSerie
     *
     * @return string
     */
    public function getNroSerie()
    {
        return $this->nroSerie;
    }

    /**
     * Set dataEmissao
     *
     * @param \DateTime $dataEmissao
     * @return NotaFiscal
     */
    public function setDataEmissao(\DateTime $dataEmissao = null)
    {
        $this->dataEmissao = $dataEmissao;
        return $this;
    }

    /**
     * Get dataEmissao
     *
     * @return \DateTime
     */
    public function getDataEmissao()
    {
        return $this->dataEmissao;
    }

    /**
     * Set codValidacao
     *
     * @param string $codValidacao
     * @return NotaFiscal
     */
    public function setCodValidacao($codValidacao = null)
    {
        $this->codValidacao = $codValidacao;
        return $this;
    }

    /**
     * Get codValidacao
     *
     * @return string
     */
    public function getCodValidacao()
    {
        return $this->codValidacao;
    }

    /**
     * Set modelo
     *
     * @param string $modelo
     * @return NotaFiscal
     */
    public function setModelo($modelo = null)
    {
        $this->modelo = $modelo;
        return $this;
    }

    /**
     * Get modelo
     *
     * @return string
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * OneToOne (owning side)
     * Set EmpenhoNotaLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao $fkEmpenhoNotaLiquidacao
     * @return NotaFiscal
     */
    public function setFkEmpenhoNotaLiquidacao(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao $fkEmpenhoNotaLiquidacao)
    {
        $this->exercicio = $fkEmpenhoNotaLiquidacao->getExercicio();
        $this->codNotaLiquidacao = $fkEmpenhoNotaLiquidacao->getCodNota();
        $this->codEntidade = $fkEmpenhoNotaLiquidacao->getCodEntidade();
        $this->fkEmpenhoNotaLiquidacao = $fkEmpenhoNotaLiquidacao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkEmpenhoNotaLiquidacao
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao
     */
    public function getFkEmpenhoNotaLiquidacao()
    {
        return $this->fkEmpenhoNotaLiquidacao;
    }
}
