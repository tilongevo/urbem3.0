<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Filter;

final class RecDescExtraFilter
{
    /**
     * @var string
     */
    protected $exercicio;

    /**
     * @var integer
     */
    protected $categoria;

    /**
     * @var integer
     */
    protected $tipoLancamento;

    /**
     * @var integer
     */
    protected $subTipoLancamento;

    /**
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * @param string $exercicio
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
    }

    /**
     * @return int
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * @param int $categoria
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
    }

    /**
     * @return int
     */
    public function getTipoLancamento()
    {
        return $this->tipoLancamento;
    }

    /**
     * @param int $tipoLancamento
     */
    public function setTipoLancamento($tipoLancamento)
    {
        $this->tipoLancamento = $tipoLancamento;
    }

    /**
     * @return int
     */
    public function getSubTipoLancamento()
    {
        return $this->subTipoLancamento;
    }

    /**
     * @param int $subTipoLancamento
     */
    public function setSubTipoLancamento($subTipoLancamento)
    {
        $this->subTipoLancamento = $subTipoLancamento;
    }
}