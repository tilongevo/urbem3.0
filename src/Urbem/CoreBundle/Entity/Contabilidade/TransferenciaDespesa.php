<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * TransferenciaDespesa
 */
class TransferenciaDespesa
{
    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $sequencia;

    /**
     * PK
     * @var string
     */
    private $tipo;

    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * PK
     * @var integer
     */
    private $codSuplementacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\LancamentoTransferencia
     */
    private $fkContabilidadeLancamentoTransferencia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Suplementacao
     */
    private $fkOrcamentoSuplementacao;


    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return TransferenciaDespesa
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TransferenciaDespesa
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return TransferenciaDespesa
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
     * Set sequencia
     *
     * @param integer $sequencia
     * @return TransferenciaDespesa
     */
    public function setSequencia($sequencia)
    {
        $this->sequencia = $sequencia;
        return $this;
    }

    /**
     * Get sequencia
     *
     * @return integer
     */
    public function getSequencia()
    {
        return $this->sequencia;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return TransferenciaDespesa
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return TransferenciaDespesa
     */
    public function setCodLote($codLote)
    {
        $this->codLote = $codLote;
        return $this;
    }

    /**
     * Get codLote
     *
     * @return integer
     */
    public function getCodLote()
    {
        return $this->codLote;
    }

    /**
     * Set codSuplementacao
     *
     * @param integer $codSuplementacao
     * @return TransferenciaDespesa
     */
    public function setCodSuplementacao($codSuplementacao)
    {
        $this->codSuplementacao = $codSuplementacao;
        return $this;
    }

    /**
     * Get codSuplementacao
     *
     * @return integer
     */
    public function getCodSuplementacao()
    {
        return $this->codSuplementacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadeLancamentoTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LancamentoTransferencia $fkContabilidadeLancamentoTransferencia
     * @return TransferenciaDespesa
     */
    public function setFkContabilidadeLancamentoTransferencia(\Urbem\CoreBundle\Entity\Contabilidade\LancamentoTransferencia $fkContabilidadeLancamentoTransferencia)
    {
        $this->codLote = $fkContabilidadeLancamentoTransferencia->getCodLote();
        $this->tipo = $fkContabilidadeLancamentoTransferencia->getTipo();
        $this->sequencia = $fkContabilidadeLancamentoTransferencia->getSequencia();
        $this->exercicio = $fkContabilidadeLancamentoTransferencia->getExercicio();
        $this->codTipo = $fkContabilidadeLancamentoTransferencia->getCodTipo();
        $this->codEntidade = $fkContabilidadeLancamentoTransferencia->getCodEntidade();
        $this->fkContabilidadeLancamentoTransferencia = $fkContabilidadeLancamentoTransferencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadeLancamentoTransferencia
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\LancamentoTransferencia
     */
    public function getFkContabilidadeLancamentoTransferencia()
    {
        return $this->fkContabilidadeLancamentoTransferencia;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoSuplementacao
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Suplementacao $fkOrcamentoSuplementacao
     * @return TransferenciaDespesa
     */
    public function setFkOrcamentoSuplementacao(\Urbem\CoreBundle\Entity\Orcamento\Suplementacao $fkOrcamentoSuplementacao)
    {
        $this->exercicio = $fkOrcamentoSuplementacao->getExercicio();
        $this->codSuplementacao = $fkOrcamentoSuplementacao->getCodSuplementacao();
        $this->fkOrcamentoSuplementacao = $fkOrcamentoSuplementacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoSuplementacao
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Suplementacao
     */
    public function getFkOrcamentoSuplementacao()
    {
        return $this->fkOrcamentoSuplementacao;
    }
}
