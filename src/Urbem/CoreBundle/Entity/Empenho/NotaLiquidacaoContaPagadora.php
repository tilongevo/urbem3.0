<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * NotaLiquidacaoContaPagadora
 */
class NotaLiquidacaoContaPagadora
{
    /**
     * PK
     * @var string
     */
    private $exercicioLiquidacao;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $codNota;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codPlano;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPaga
     */
    private $fkEmpenhoNotaLiquidacaoPaga;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    private $fkContabilidadePlanoAnalitica;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set exercicioLiquidacao
     *
     * @param string $exercicioLiquidacao
     * @return NotaLiquidacaoContaPagadora
     */
    public function setExercicioLiquidacao($exercicioLiquidacao)
    {
        $this->exercicioLiquidacao = $exercicioLiquidacao;
        return $this;
    }

    /**
     * Get exercicioLiquidacao
     *
     * @return string
     */
    public function getExercicioLiquidacao()
    {
        return $this->exercicioLiquidacao;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return NotaLiquidacaoContaPagadora
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
     * Set codNota
     *
     * @param integer $codNota
     * @return NotaLiquidacaoContaPagadora
     */
    public function setCodNota($codNota)
    {
        $this->codNota = $codNota;
        return $this;
    }

    /**
     * Get codNota
     *
     * @return integer
     */
    public function getCodNota()
    {
        return $this->codNota;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return NotaLiquidacaoContaPagadora
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return NotaLiquidacaoContaPagadora
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
     * Set codPlano
     *
     * @param integer $codPlano
     * @return NotaLiquidacaoContaPagadora
     */
    public function setCodPlano($codPlano)
    {
        $this->codPlano = $codPlano;
        return $this;
    }

    /**
     * Get codPlano
     *
     * @return integer
     */
    public function getCodPlano()
    {
        return $this->codPlano;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadePlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica
     * @return NotaLiquidacaoContaPagadora
     */
    public function setFkContabilidadePlanoAnalitica(\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica)
    {
        $this->codPlano = $fkContabilidadePlanoAnalitica->getCodPlano();
        $this->exercicio = $fkContabilidadePlanoAnalitica->getExercicio();
        $this->fkContabilidadePlanoAnalitica = $fkContabilidadePlanoAnalitica;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadePlanoAnalitica
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    public function getFkContabilidadePlanoAnalitica()
    {
        return $this->fkContabilidadePlanoAnalitica;
    }

    /**
     * OneToOne (owning side)
     * Set EmpenhoNotaLiquidacaoPaga
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPaga $fkEmpenhoNotaLiquidacaoPaga
     * @return NotaLiquidacaoContaPagadora
     */
    public function setFkEmpenhoNotaLiquidacaoPaga(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPaga $fkEmpenhoNotaLiquidacaoPaga)
    {
        $this->codEntidade = $fkEmpenhoNotaLiquidacaoPaga->getCodEntidade();
        $this->codNota = $fkEmpenhoNotaLiquidacaoPaga->getCodNota();
        $this->exercicioLiquidacao = $fkEmpenhoNotaLiquidacaoPaga->getExercicio();
        $this->timestamp = $fkEmpenhoNotaLiquidacaoPaga->getTimestamp();
        $this->fkEmpenhoNotaLiquidacaoPaga = $fkEmpenhoNotaLiquidacaoPaga;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkEmpenhoNotaLiquidacaoPaga
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPaga
     */
    public function getFkEmpenhoNotaLiquidacaoPaga()
    {
        return $this->fkEmpenhoNotaLiquidacaoPaga;
    }
}
