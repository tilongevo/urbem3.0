<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Filter;

use Doctrine\Common\Collections\ArrayCollection;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;

final class ContratoAditivoFilter
{
    /**
     * @var string
     */
    protected $nroContrato;

    /**
     * @var \DateTime
     */
    protected $dataAssinatura;

    /**
     * @var string
     */
    protected $nroAditivo;

    /**
     * @var ArrayCollection
     */
    protected $entidades;

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
    public function getDataAssinatura()
    {
        return $this->dataAssinatura;
    }

    /**
     * @param \DateTime $dataAssinatura
     */
    public function setDataAssinatura(\DateTime $dataAssinatura = null)
    {
        $this->dataAssinatura = $dataAssinatura;
    }

    /**
     * @return string
     */
    public function getNroAditivo()
    {
        return $this->nroAditivo;
    }

    /**
     * @param string $nroAditivo
     */
    public function setNroAditivo($nroAditivo = null)
    {
        $this->nroAditivo = $nroAditivo;
    }

    /**
     * @return ArrayCollection|Entidade
     */
    public function getEntidades()
    {
        return $this->entidades;
    }

    /**
     * @param Entidade $entidade
     */
    public function setEntidades($entidades = null)
    {
        $entidades = null === $entidades ? new ArrayCollection() : $entidades;
        $entidades = true === $entidades instanceof ArrayCollection ? $entidades->toArray() : $entidades;
        $entidades = true === is_array($entidades) ? $entidades : [$entidades];

        $this->entidades = new ArrayCollection($entidades);
    }
}