<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Filter;

use Urbem\CoreBundle\Entity\Orcamento\Entidade;

final class ConvenioFilter
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
    protected $numConvenio;

    /**
     * @var \DateTime
     */
    protected $periodicidadeInicio;

    /**
     * @var \DateTime
     */
    protected $periodicidadeFim;

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
    public function getNumConvenio()
    {
        return $this->numConvenio;
    }

    /**
     * @param int $mes
     */
    public function setNumConvenio($numConvenio)
    {
        $this->numConvenio = $numConvenio;
    }

    public function setPeriodicidade(array $periodicidade = null)
    {
        $start = true === empty($periodicidade['start']) ? null : $periodicidade['start'];
        $end = true === empty($periodicidade['end']) ? null : $periodicidade['end'];

        /* src/Urbem/CoreBundle/Resources/config/doctrine/Tcemg.Convenio.orm.yml:39 (dataInicio) */
        if (null !== $start) {
            /** @var $start \DateTime */
            $start->setTime(0, 0, 0);
            $start = new \DateTime($start->format('Y-m-d H:i:s'));
        }

        /* src/Urbem/CoreBundle/Resources/config/doctrine/Tcemg.Convenio.orm.yml:43 (dataFinal) */
        if (null !== $end) {
            /** @var $end \DateTime */
            $end->setTime(23, 59, 59);
            $end = new \DateTime($end->format('Y-m-d H:i:s'));
        }

        $this->periodicidadeInicio = $start;
        $this->periodicidadeFim = $end;
    }

    /**
     * @return \DateTime
     */
    public function getPeriodicidadeInicio()
    {
        return $this->periodicidadeInicio;
    }

    /**
     * @return \DateTime
     */
    public function getPeriodicidadeFim()
    {
        return $this->periodicidadeFim;
    }
}