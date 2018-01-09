<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Filter;

use Urbem\CoreBundle\Entity\Compras\Objeto;

final class ContratoFilter
{
    /**
     * @var string
     */
    protected $nroContrato;

    /**
     * @var \DateTime
     */
    protected $dataPublicacao;

    /**
     * @var \DateTime
     */
    protected $periodicidadeInicio;

    /**
     * @var \DateTime
     */
    protected $periodicidadeFim;

    /**
     * @var string
     */
    protected $objetoContrato;

    /**
     * @return string
     */
    public function getNroContrato()
    {
        return $this->nroContrato;
    }

    /**
     * @param string $nroContrato
     */
    public function setNroContrato($nroContrato = null)
    {
        $this->nroContrato = $nroContrato;
    }

    /**
     * @return \DateTime
     */
    public function getDataPublicacao()
    {
        return $this->dataPublicacao;
    }

    /**
     * @param \DateTime $dataPublicacao
     */
    public function setDataPublicacao(\DateTime $dataPublicacao = null)
    {
        $this->dataPublicacao = $dataPublicacao;
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

    /**
     * @return string
     */
    public function getObjetoContrato()
    {
        return $this->objetoContrato;
    }

    /**
     * @param string $objeto
     */
    public function setObjetoContrato($objetoContrato = null)
    {
        $this->objetoContrato = $objetoContrato;
    }

    public function setPeriodicidade(array $periodicidade = null)
    {
        $start = true === empty($periodicidade['start']) ? null : $periodicidade['start'];
        $end = true === empty($periodicidade['end']) ? null : $periodicidade['end'];

        /* src/Urbem/CoreBundle/Resources/config/doctrine/Tcemg.Contrato.orm.yml:78 (dataInicio) */
        if (null !== $start) {
            /** @var $start \DateTime */
            $start->setTime(0, 0, 0);
            $start = new \DateTime($start->format('Y-m-d H:i:s'));
        }

        /* src/Urbem/CoreBundle/Resources/config/doctrine/Tcemg.Contrato.orm.yml:82 (dataFinal) */
        if (null !== $end) {
            /** @var $end \DateTime */
            $end->setTime(23, 59, 59);
            $end = new \DateTime($end->format('Y-m-d H:i:s'));
        }

        $this->periodicidadeInicio = $start;
        $this->periodicidadeFim = $end;
    }
}