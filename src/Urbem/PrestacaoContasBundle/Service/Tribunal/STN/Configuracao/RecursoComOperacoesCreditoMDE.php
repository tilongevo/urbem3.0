<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Configuracao;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\Entity\Orcamento\Recurso;
use Urbem\CoreBundle\Entity\Stn\TipoVinculoRecurso;
use Urbem\CoreBundle\Entity\Stn\VinculoRecurso;
use Urbem\CoreBundle\Entity\Stn\VinculoStnRecurso;
use Urbem\CoreBundle\Repository\Orcamento\RecursoRepository;
use Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Form\RecursoOperacaoCreditoMDEType;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Symfony\Bridge\Twig\TwigEngine;

class RecursoComOperacoesCreditoMDE extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/STN/RecursoComOperacoesCreditoMDE.js',
        ];
    }

    /**
     * @return bool
     */
    public function save()
    {
        try {
            /* gestaoPrestacaoContas/fontes/PHP/STN/instancias/configuracao/PRManterRecurso.php:121 */
            return $this->factory->getEntityManager()->transactional(function (EntityManager $em) {
                $parameters = $this->processParameters();
                $parameters = array_shift($parameters);

                /** @var TipoVinculoRecurso $tipoVinculoRecurso */
                $tipoVinculoRecurso = $em->getRepository(TipoVinculoRecurso::class)->findOneBy([
                    'codTipo' => TipoVinculoRecurso::COD_TIPO_RECURSOS_OUTRAS_DESPESAS
                ]);

                /** @var VinculoStnRecurso $vinculoStnRecurso */
                $vinculoStnRecurso = $em->getRepository(VinculoStnRecurso::class)->findOneBy([
                   'codVinculo' => VinculoStnRecurso::COD_VINCULO_OPERACOES_DE_CREDITO
                ]);

                foreach ($parameters['recursos'] as $recurso) {
                    $vinculoRecurso = new VinculoRecurso();
                    $vinculoRecurso->setFkOrcamentoEntidade($parameters['entidade']);
                    $vinculoRecurso->setFkOrcamentoUnidade($parameters['unidade']);
                    $vinculoRecurso->setFkOrcamentoRecurso($recurso);
                    $vinculoRecurso->setFkStnTipoVinculoRecurso($tipoVinculoRecurso);
                    $vinculoRecurso->setFkStnVinculoStnRecurso($vinculoStnRecurso);

                    $em->persist($vinculoRecurso);
                }

                $em->flush();

                return true;
            });

        } catch (\Exception $e) {
            $this->setErrorMessage($e->getMessage());
            return false;
        }
    }

    /**
     * @return array
     */
    public function buildServiceProvider(TwigEngine $templating = null)
    {
        $action = (string) $this->getRequest()->get('action');
        $action = sprintf('action%s', ucfirst($action));

        if (false === method_exists($this, $action)) {
            return [
                'response' => false,
                'message' => sprintf('action %s not found', $action)
            ];
        }

        try {
            return [
                'response' => true,
            ] + call_user_func_array([$this, $action], [$templating]);

        } catch (\Exception $e) {
            return [
                'response' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * @return array
     */
    protected function actionLoadRecursos()
    {
        /** @var RecursoRepository $recursoRepo */
        $recursoRepo = $this->getRepository(Recurso::class);
        $classMetadata = $this->getClassMetadata(Recurso::class);

        $entidade = RecursoOperacaoCreditoMDEType::getEntidadeFromData($this->getRequest()->get('entidade'));
        $unidade = RecursoOperacaoCreditoMDEType::getUnidadeFromData($this->getRequest()->get('unidade'));

        $recursos = [];

        foreach ($recursoRepo->getRecursoOutrasDespesasVinculoOperacoesCreditoAsQueryBuilder($entidade, $unidade)->getQuery()->getResult() as $recurso) {
            $recursos[] = [
                'value' => implode(self::ID_SEPARATOR, $classMetadata->getIdentifierValues($recurso)),
                'text' => (string) $recurso
            ];
        }

        return [
            'recursos' => $recursos
        ];
    }
}