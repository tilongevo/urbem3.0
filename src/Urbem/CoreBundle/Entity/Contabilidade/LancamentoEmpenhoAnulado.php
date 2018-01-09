<?php

namespace Urbem\CoreBundle\Entity\Contabilidade;

use Doctrine\ORM\Mapping as ORM;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;

/**
 * LancamentoEmpenhoAnulado
 */
class LancamentoEmpenhoAnulado
{
    /**
     * PK
     * @var string
     */
    private $exercicio;
    
    /**
     * PK
     * @var integer
     */
    private $codLote;
    
    /**
     * PK
     * @var string
     */
    private $tipo;
    
    /**
     * PK
     * @var integer
     */
    private $sequencia;
    
    /**
     * PK
     * @var integer
     */
    private $codEntidade;
    
    /**
     * PK
     * @var string
     */
    private $exercicioAnulacao;
    
    /**
     * PK
     * @var integer
     */
    private $codEmpenhoAnulacao;
    
    /**
     * PK
     * @var DateTimeMicrosecondPK
     */
    private $timestampAnulacao;
    
    /**
     * @var \Urbem\CoreBundle\Entity\Contabilidade\LancamentoEmpenho
     */
    private $fkContabilidadeLancamentoEmpenho;
    
    /**
     * @var \Urbem\CoreBundle\Entity\Empenho\EmpenhoAnulado
     */
    private $fkEmpenhoEmpenhoAnulado;

    /**
     * Get the value of Exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Get the value of Cod Lote
     *
     * @return integer
     */
    public function getCodLote()
    {
        return $this->codLote;
    }

    /**
     * Get the value of Tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Get the value of Sequencia
     *
     * @return integer
     */
    public function getSequencia()
    {
        return $this->sequencia;
    }

    /**
     * Get the value of Cod Entidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }
    
    /**
     * Get the value of Exercicio Anulacao
     *
     * @return string
     */
    public function getExercicioAnulacao()
    {
        return $this->exercicioAnulacao;
    }

    /**
     * Get the value of Cod Empenho Anulacao
     *
     * @return integer
     */
    public function getCodEmpenhoAnulacao()
    {
        return $this->codEmpenhoAnulacao;
    }

    /**
     * Get the value of Timestamp Anulacao
     *
     * @return DateTimeMicrosecondPK
     */
    public function getTimestampAnulacao()
    {
        return $this->timestampAnulacao;
    }

    /**
     * @param DateTimeMicrosecondPK $timestampAnulacao
     */
    public function setTimestampAnulacao($timestampAnulacao)
    {
        $this->timestampAnulacao = $timestampAnulacao;
    }


    /**
     * Get the value of Fk Contabilidade Lancamento Empenho
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade.lancamentoEmpenho
     */
    public function getFkContabilidadeLancamentoEmpenho()
    {
        return $this->fkContabilidadeLancamentoEmpenho;
    }

    /**
     * Set the value of Fk Contabilidade Lancamento Empenho
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade.lancamentoEmpenho fkContabilidadeLancamentoEmpenho
     *
     * @return self
     */
    public function setFkContabilidadeLancamentoEmpenho(\Urbem\CoreBundle\Entity\Contabilidade\LancamentoEmpenho $fkContabilidadeLancamentoEmpenho)
    {
        $this->fkContabilidadeLancamentoEmpenho = $fkContabilidadeLancamentoEmpenho;
        $this->exercicio = $fkContabilidadeLancamentoEmpenho->getExercicio();
        $this->codLote = $fkContabilidadeLancamentoEmpenho->getCodLote();
        $this->tipo = $fkContabilidadeLancamentoEmpenho->getTipo();
        $this->sequencia = $fkContabilidadeLancamentoEmpenho->getSequencia();
        $this->codEntidade = $fkContabilidadeLancamentoEmpenho->getCodEntidade();
        return $this;
    }

    /**
     * Get the value of Fk Empenho Anulado
     *
     * @return \Urbem\CoreBundle\Entity\Empenho.empenhoAnulado
     */
    public function getfkEmpenhoEmpenhoAnulado()
    {
        return $this->fkEmpenhoAnulado;
    }

    /**
     * Set the value of Fk Empenho Anulado
     *
     * @param \Urbem\CoreBundle\Entity\Empenho.empenhoAnulado fkEmpenhoAnulado
     *
     * @return self
     */
    public function setfkEmpenhoEmpenhoAnulado(\Urbem\CoreBundle\Entity\Empenho\EmpenhoAnulado $fkEmpenhoAnulado)
    {
        $this->fkEmpenhoAnulado = $fkEmpenhoAnulado;
        $this->exercicioAnulacao = $fkEmpenhoAnulado->getExercicio();
        $this->timestampAnulacao = $fkEmpenhoAnulado->getTimestamp();
        $this->codEmpenhoAnulacao = $fkEmpenhoAnulado->getCodEmpenho();
        return $this;
    }
}
