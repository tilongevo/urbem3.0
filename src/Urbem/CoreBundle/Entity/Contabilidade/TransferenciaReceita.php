<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * TransferenciaReceita
 */
class TransferenciaReceita
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
    private $codReceita;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\LancamentoTransferencia
     */
    private $fkContabilidadeLancamentoTransferencia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Receita
     */
    private $fkOrcamentoReceita;


    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return TransferenciaReceita
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
     * @return TransferenciaReceita
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
     * @return TransferenciaReceita
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
     * @return TransferenciaReceita
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
     * @return TransferenciaReceita
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
     * @return TransferenciaReceita
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
     * Set codReceita
     *
     * @param integer $codReceita
     * @return TransferenciaReceita
     */
    public function setCodReceita($codReceita)
    {
        $this->codReceita = $codReceita;
        return $this;
    }

    /**
     * Get codReceita
     *
     * @return integer
     */
    public function getCodReceita()
    {
        return $this->codReceita;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadeLancamentoTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LancamentoTransferencia $fkContabilidadeLancamentoTransferencia
     * @return TransferenciaReceita
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
     * Set fkOrcamentoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita
     * @return TransferenciaReceita
     */
    public function setFkOrcamentoReceita(\Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita)
    {
        $this->exercicio = $fkOrcamentoReceita->getExercicio();
        $this->codReceita = $fkOrcamentoReceita->getCodReceita();
        $this->fkOrcamentoReceita = $fkOrcamentoReceita;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoReceita
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Receita
     */
    public function getFkOrcamentoReceita()
    {
        return $this->fkOrcamentoReceita;
    }
}
