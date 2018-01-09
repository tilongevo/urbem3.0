<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Filter;

use Doctrine\Common\Collections\ArrayCollection;
use Urbem\CoreBundle\Entity\Compras\Mapa;
use Urbem\CoreBundle\Entity\Compras\Modalidade;
use Urbem\CoreBundle\Entity\Compras\Objeto;
use Urbem\CoreBundle\Entity\Compras\TipoLicitacao;
use Urbem\CoreBundle\Entity\Compras\TipoObjeto;
use Urbem\CoreBundle\Entity\Licitacao\CriterioJulgamento;
use Urbem\CoreBundle\Entity\Licitacao\Licitacao;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;

final class ResponsavelLicitacaoFilter
{
    /**
     * @var string
     */
    protected $exercicio;

    /**
     * @var ArrayCollection|Entidade
     */
    protected $entidades;

    /**
     * @var Modalidade
     */
    protected $modalidade;

    /**
     * @var Licitacao
     */
    protected $licitacao;

    /**
     * @var SwProcesso
     */
    protected $swProcesso;

    /**
     * @var Mapa
     */
    protected $mapa;

    /**
     * @var DateTimeMicrosecondPK
     */
    protected $periodicidadeInicio;

    /**
     * @var DateTimeMicrosecondPK
     */
    protected $periodicidadeFim;

    /**
     * @var TipoLicitacao
     */
    protected $tipoLicitacao;

    /**
     * @var CriterioJulgamento
     */
    protected $criterioJulgamento;

    /**
     * @var TipoObjeto
     */
    protected $tipoObjeto;

    /**
     * @var Objeto
     */
    protected $objeto;

    public function __construct()
    {
        $this->entidades = new ArrayCollection();
    }

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

    /**
     * @return Modalidade
     */
    public function getModalidade()
    {
        return $this->modalidade;
    }

    /**
     * @param Modalidade $modalidade
     */
    public function setModalidade($modalidade)
    {
        $this->modalidade = $modalidade;
    }

    /**
     * @return Licitacao
     */
    public function getLicitacao()
    {
        return $this->licitacao;
    }

    /**
     * @param Licitacao $licitacao
     */
    public function setLicitacao($licitacao)
    {
        $this->licitacao = $licitacao;
    }

    /**
     * @return SwProcesso
     */
    public function getSwProcesso()
    {
        return $this->swProcesso;
    }

    /**
     * @param SwProcesso $swProcesso
     */
    public function setSwProcesso($swProcesso)
    {
        $this->swProcesso = $swProcesso;
    }

    /**
     * @return Mapa
     */
    public function getMapa()
    {
        return $this->mapa;
    }

    /**
     * @param Mapa $mapa
     */
    public function setMapa($mapa)
    {
        $this->mapa = $mapa;
    }

    /**
     * @return TipoLicitacao
     */
    public function getTipoLicitacao()
    {
        return $this->tipoLicitacao;
    }

    /**
     * @param TipoLicitacao $tipoLicitacao
     */
    public function setTipoLicitacao($tipoLicitacao)
    {
        $this->tipoLicitacao = $tipoLicitacao;
    }

    /**
     * @return CriterioJulgamento
     */
    public function getCriterioJulgamento()
    {
        return $this->criterioJulgamento;
    }

    /**
     * @param CriterioJulgamento $criterioJulgamento
     */
    public function setCriterioJulgamento($criterioJulgamento)
    {
        $this->criterioJulgamento = $criterioJulgamento;
    }

    /**
     * @return TipoObjeto
     */
    public function getTipoObjeto()
    {
        return $this->tipoObjeto;
    }

    /**
     * @param TipoObjeto $tipoObjeto
     */
    public function setTipoObjeto($tipoObjeto)
    {
        $this->tipoObjeto = $tipoObjeto;
    }

    /**
     * @return Objeto
     */
    public function getObjeto()
    {
        return $this->objeto;
    }

    /**
     * @param Objeto $objeto
     */
    public function setObjeto($objeto)
    {
        $this->objeto = $objeto;
    }

    public function setPeriodicidade(array $periodicidade = null)
    {
        $start = true === empty($periodicidade['start']) ? null : $periodicidade['start'];
        $end = true === empty($periodicidade['end']) ? null : $periodicidade['end'];

        /* src/Urbem/CoreBundle/Resources/config/doctrine/Licitacao.Licitacao.orm.yml:66 (timestamp) */
        if (null !== $start) {
            /** @var $start \DateTime */
            $start->setTime(0, 0, 0);
            $start = new DateTimeMicrosecondPK($start->format('Y-m-d H:i:s'));
        }

        /* src/Urbem/CoreBundle/Resources/config/doctrine/Licitacao.Licitacao.orm.yml:66 (timestamp) */
        if (null !== $end) {
            /** @var $end \DateTime */
            $end->setTime(23, 59, 59);
            $end = new DateTimeMicrosecondPK($end->format('Y-m-d H:i:s'));
        }

        $this->periodicidadeInicio = $start;
        $this->periodicidadeFim = $end;
    }

    /**
     * @return DateTimeMicrosecondPK
     */
    public function getPeriodicidadeInicio()
    {
        return $this->periodicidadeInicio;
    }

    /**
     * @return DateTimeMicrosecondPK
     */
    public function getPeriodicidadeFim()
    {
        return $this->periodicidadeFim;
    }
}