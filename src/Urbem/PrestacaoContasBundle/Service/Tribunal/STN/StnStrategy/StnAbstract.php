<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\STN\StnStrategy;

use Symfony\Component\Form\Form;
use Urbem\CoreBundle\Model\Orcamento\EntidadeModel;

/**
 * Class StnAbstract
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\StnStrategy
 */
abstract class StnAbstract
{
    /**
     * @var \Urbem\PrestacaoContasBundle\Service\Tribunal\STN\StnStrategy\StnFactory
     */
    protected $factory;

    /**
     * @var \Symfony\Component\Form\Form $form
     */
    private $form;

    /**
     * StnAbstract constructor.
     * @param \Urbem\PrestacaoContasBundle\Service\Tribunal\STN\StnStrategy\StnFactory $factory
     */
    public function __construct(StnFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param \Symfony\Component\Form\Form $form
     */
    public function setContentForm(Form $form)
    {
        $this->form = $form;
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @return array
     */
    public function processParameters()
    {
        /** @var \Symfony\Component\Form\Form $field */
        foreach ($this->getForm() as $field) {
            $value[$field->getName()] = $field->getData();
        }

        // Assinaturas
        $entidadeAssinatura = $timestampAssinatura = $numcgmAssinatura = [];
        if (isset($value['assinaturas'])) {
            list($entidadeAssinatura, $timestampAssinatura, $numcgmAssinatura) = $this->getAssinaturas($value['assinaturas']);
        }

        //Prefeitura
        $codEntidade = 0;
        $stNomeEntidade = null;
        $entidades = [];
        if (isset($value['entidade'])) {
            list($entidades, $stNomeEntidade, $codEntidade) = $this->getEntidades($value['entidade']);
        }

        // Recurso
        if (isset($value['cod_recurso'])) {
            list($codRecursos) = $this->getRecursos($value['cod_recurso']);
            $value['cod_recurso'] = implode(",", $codRecursos);
        }

        // Data emissão
        $dtDataEmissao = date('d/m/Y');
        $dtHoraEmissao = date('H:i');
        $value['data_emissao'] = sprintf("Data da emissão %s e hora da emissão %s", $dtDataEmissao, $dtHoraEmissao);

        $exercicio = $this->factory->getSession()->getExercicio();
        $value['exercicio'] = $exercicio;
        $value['exercicio_anterior'] = $exercicio - 1;
        $value['exercicio_restos'] = $exercicio + 1;
        $value['cod_entidade'] = $codEntidade;

        $params = [
            "term_user" => $this->factory->getUser()->getUsername(),
            "unidade_responsavel" => $this->factory->getUser()->getCodOrgao(),
            "nom_entidade" => $stNomeEntidade,
            "poder" => count($entidades) ? "Executivo" : "Legislativo", // Exatamente igual ao urbem velho =/
            "numero_assinatura" => count($entidadeAssinatura), // count(array)
            "entidade_assinatura" => implode(",", $entidadeAssinatura), // exemplo: 2,3,4
            "timestamp_assinatura" => implode(",", $timestampAssinatura), // exemplo: '12345646797', '1231546987';
            "numcgm_assinatura" => implode(",", $numcgmAssinatura)// exemplo: 2,4,5,7,8
        ];

        return array_merge($value, $params);
    }

    /**
     * @param array $entidades
     * @return array
     */
    protected function getEntidades(array $entidades)
    {
        $entidadeModel = new EntidadeModel($this->factory->getEntityManager());
        $entidadesList = [];
        $stNomeEntidade = '';
        $codEntidadeList = '';

        foreach($entidades as $entidade) {
            list($exercicioEntidade, $codEntidade) = explode('~', $entidade);
            $objEntidade = $entidadeModel->findOneByCodEntidadeAndExercicio($codEntidade, $exercicioEntidade);
            if (empty($objEntidade)) {
                continue;
            }

            $entidadesList[] = $objEntidade;
            $codEntidadeList .= "," . $objEntidade->getCodEntidade();
            if (strpos(strtolower($objEntidade->getFkSwCgm()->getNomCgm()), 'prefeitura') !== false) {
                $stNomeEntidade = $objEntidade->getFkSwCgm()->getNomCgm();
            }
        }

        return [$entidadesList, $stNomeEntidade, substr($codEntidadeList, 1)];
    }

    /**
     * @param array $assinaturas
     * @return array
     */
    protected function getAssinaturas(array $assinaturas)
    {
        $entidade_assinatura = $timestamp_assinatura = $numcgm_assinatura = [];
        foreach($assinaturas as $assinatura) {
            list($exercicioAssinatura, $entidadeAssinatura, $numcgmAssinatura, $timestampAssinatura) = explode('~', $assinatura);
            $entidade_assinatura[] = $entidadeAssinatura;
            $timestamp_assinatura[] = sprintf("'%s'", $timestampAssinatura);
            $numcgm_assinatura[] = $numcgmAssinatura;
        }

        return [$entidade_assinatura, $timestamp_assinatura, $numcgm_assinatura];
    }

    /**
     * @param array $recursos
     * @return array
     */
    protected function getRecursos(array $recursos)
    {
        $recursoList = [];
        foreach($recursos as $recurso) {
            list($exercicioRecurso, $codRecurso) = explode('~', $recurso);
            $recursoList[] = $codRecurso;
        }

        return [$recursoList];
    }

    /**
     * @param array $parameters
     * @param array|null $form
     * @return array
     */
    public function preBuildForm(array $parameters, array $form = null)
    {
        return $parameters;
    }
}
