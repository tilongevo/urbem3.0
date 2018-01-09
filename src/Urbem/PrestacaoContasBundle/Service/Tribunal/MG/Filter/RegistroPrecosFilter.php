<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Filter;

use Urbem\CoreBundle\Entity\Compras\Modalidade;
use Urbem\CoreBundle\Entity\Empenho\Empenho;
use Urbem\CoreBundle\Entity\Licitacao\Licitacao;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;

final class RegistroPrecosFilter
{
    /**
     * @var Entidade
     */
    protected $entidade;

    /**
     * @var integer
     */
    protected $numeroRegistroPrecos;

    /**
     * @var Modalidade
     */
    protected $modalidade;

    /**
     * @var Licitacao
     */
    protected $licitacao;

    /**
     * @var Empenho
     */
    protected $empenho;


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
     * @return int
     */
    public function getNumeroRegistroPrecos()
    {
        return $this->numeroRegistroPrecos;
    }

    /**
     * @param int $numeroRegistroPrecos
     */
    public function setNumeroRegistroPrecos($numeroRegistroPrecos = null)
    {
        $this->numeroRegistroPrecos = $numeroRegistroPrecos;
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
    public function setModalidade($modalidade = null)
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
    public function setLicitacao($licitacao = null)
    {
        $this->licitacao = $licitacao;
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
    public function setEmpenho($empenho = null)
    {
        $this->empenho = $empenho;
    }

}