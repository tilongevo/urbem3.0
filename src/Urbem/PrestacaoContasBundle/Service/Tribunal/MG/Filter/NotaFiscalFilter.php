<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Filter;

use Urbem\CoreBundle\Entity\Empenho\Empenho;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;

final class NotaFiscalFilter
{
    /**
     * @var integer
     */
    private $numNota;

    /**
     * @var integer
     */
    private $numSerie;

    /**
     * @var \DateTime
     */
    private $dtEmissao;

    /**
     * @var string
     */
    private $exercicioNota;

    /**
     * @var string
     */
    private $exercicioEmpenho;

    /**
     * @var Entidade
     */
    private $entidade;

    /**
     * @var Empenho
     */
    private $empenho;

    /**
     * @return int
     */
    public function getNumNota()
    {
        return $this->numNota;
    }

    /**
     * @param int $numNota
     */
    public function setNumNota($numNota = null)
    {
        $this->numNota = $numNota;
    }

    /**
     * @return int
     */
    public function getNumSerie()
    {
        return $this->numSerie;
    }

    /**
     * @param int $numSerie
     */
    public function setNumSerie($numSerie = null)
    {
        $this->numSerie = $numSerie;
    }

    /**
     * @return \DateTime
     */
    public function getDtEmissao()
    {
        return $this->dtEmissao;
    }

    /**
     * @param \DateTime $dtEmissao
     */
    public function setDtEmissao($dtEmissao = null)
    {
        $this->dtEmissao = $dtEmissao;
    }

    /**
     * @return string
     */
    public function getExercicioNota()
    {
        return $this->exercicioNota;
    }

    /**
     * @param string $exercicioNota
     */
    public function setExercicioNota($exercicioNota = null)
    {
        $this->exercicioNota = $exercicioNota;
    }

    /**
     * @return string
     */
    public function getExercicioEmpenho()
    {
        return $this->exercicioEmpenho;
    }

    /**
     * @param string $exercicioEmpenho
     */
    public function setExercicioEmpenho($exercicioEmpenho = null)
    {
        $this->exercicioEmpenho = $exercicioEmpenho;
    }

    /**
     * @return Entidade
     */
    public function getEntidade()
    {
        return $this->entidade;
    }

    /**
     * @param Entidade $entidade
     */
    public function setEntidade($entidade)
    {
        $this->entidade = $entidade;
    }

    /**
     * @return Empenho
     */
    public function getEmpenho()
    {
        return $this->empenho;
    }

    /**
     * @param Empenho $empenho
     */
    public function setEmpenho($empenho)
    {
        $this->empenho = $empenho;
    }
}