<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Filter;

use Urbem\CoreBundle\Entity\Orcamento\Entidade;

final class DDCFilter
{
    /**
     * @var string
     */
    protected $exercicio;

    /**
     * @var Entidade
     */
    protected $entidade;

    /**
     * @var integer
     */
    protected $mes;

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
     * @return Entidade
     */
    public function getEntidade()
    {
        return $this->entidade;
    }

    /**
     * @param Entidade $entidade
     */
    public function setEntidade(Entidade $entidade = null)
    {
        $this->entidade = $entidade;
    }

    /**
     * @return int
     */
    public function getMes()
    {
        return $this->mes;
    }

    /**
     * @param int $mes
     */
    public function setMes($mes)
    {
        $this->mes = $mes;
    }
}