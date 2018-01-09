<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\Empenho\Empenho;
use Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeRequisitosCargo;
use Urbem\CoreBundle\Entity\Tcemg\ArquivoEmp;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Symfony\Bridge\Twig\TwigEngine;
use WebDriver\Exception;

/**
 * Class ConfiguracaoEMP
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao
 */
final class ConfiguracaoEMP extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/MG/ConfiguracaoEMP.js',
        ];
    }

    /**
     * @return string
     */
    public function dynamicBlockJs()
    {
        return parent::dynamicBlockJs();
    }

    /**
     * @return array
     */
    public function processParameters()
    {
        $params = parent::processParameters();
        return $params;
    }

    /**
     * @return bool
     */
    public function save()
    {
        $formData = (array) $this->getFormSonata();

        try {
            $em = $this->factory->getEntityManager();

            return $em->transactional(function ($entityManager) use ($formData) {
                $parameters = array_shift($formData);
                $exercicio = $parameters['exercicio'];
                $codEntidade = $this->getCodEntidade($parameters['entidade']);
                $exercicioLicitacao = $parameters['exercicioLicitacao'];
                $codLicitacao = $parameters['codLicitacao'];
                $codModalidade = $parameters['codModalidade'];
                $codEmpenho = $parameters['search_autocomplete_empenho'];

                $entity = $entityManager->getRepository(ArquivoEmp::class)->findOneBy([
                    'exercicio' => $exercicio,
                    'codEntidade' => $codEntidade,
                    'codEmpenho' => $codEmpenho,
                ]);

                if (!$entity instanceof ArquivoEmp) {
                    $entity = $this->getArquivoEmp();
                    $entity->setExercicio($exercicio);
                    $entity->setCodEntidade($codEntidade);
                    $entity->setCodEmpenho($codEmpenho);
                }
                $entity->setCodLicitacao($codLicitacao);
                $entity->setExercicioLicitacao($exercicioLicitacao);
                $entity->setCodModalidade($codModalidade);

                $entityManager->persist($entity);
                $entityManager->flush();

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
    protected function actionLoadEmpenhos()
    {
        $em = $this->factory->getEntityManager();
        $result = $em->getRepository(ArquivoEmp::class)->getEmpenhos();

        return [
            'content' => $result,
        ];
    }

    /**
     * @return array
     */
    protected function actionSave()
    {
        $message = 'Configurar EMP concluído com sucesso! (Configuração EMP)';
        $result = $this->save();
        if (!$result) {
            $message = $this->getErrorMessage();
        }

        return [
            'message' => $message
        ];
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function actionDelete()
    {
        $entityManager = $this->factory->getEntityManager();

        $exercicio = $this->getRequest()->get('exercicio');
        $codEntidade = $this->getRequest()->get('codEntidade');
        $exercicioLicitacao = $this->getRequest()->get('exercicioLicitacao');
        $codLicitacao = $this->getRequest()->get('codLicitacao');
        $codModalidade = $this->getRequest()->get('codModalidade');
        $codEmpenho = $this->getRequest()->get('codEmpenho');

        $entity = $entityManager->getRepository(ArquivoEmp::class)->findOneBy([
            'exercicio' => $exercicio,
            'codEntidade' => $codEntidade,
            'codEmpenho' => $codEmpenho,
            'codLicitacao' => $codLicitacao,
            'exercicioLicitacao' => $exercicioLicitacao,
            'codModalidade' => $codModalidade,
        ]);
        if (!$entity instanceof ArquivoEmp) {
            throw new \Exception('Erro ao remover a Configuração EMP');
        }
        $entityManager->remove($entity);
        $entityManager->flush();

        return [
            'message' => 'Configuração Removida com Sucesso!',
        ];
    }

    /**
     * @param $term
     * @param $codEntidade
     * @return array
     */
    protected function actionRequestAjaxListEmpenhos($term, $codEntidade)
    {
        $empenhos = [];
        $qb = $this->factory->getEntityManager()
            ->getRepository(Empenho::class)
            ->getEmpenhoByAsExercicioAndTerm($this->factory->getSession()->getExercicio(), $codEntidade, $term);
        
        $results = $qb->getQuery()->getResult();
        if (count($results)) {
            foreach ($results as $result) {
                $id = $result['codEmpenho'];
                $label = $result['codEmpenho'] . "/" . $result['exercicio'] . " - " . $result['nomCgm'];
                array_push($empenhos, ['id' => $id, 'label' => $label]);
            }
        }

        return ['items' => $empenhos];
    }

    /**
     * @param TwigEngine|null $templating
     * @return array
     * @throws \Exception
     */
    public function buildServiceProvider(TwigEngine $templating = null)
    {
        $actionBuscaEmpenho = (string) $this->getRequest()->get('search_autocomplete_empenho');
        if (!empty($actionBuscaEmpenho)) {
            $entidade = $this->getCodEntidade($this->getRequest()->get('entidade'));

            return $this->actionRequestAjaxListEmpenhos($actionBuscaEmpenho, $entidade);
        }

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
                    'exercicioAtual' => $this->factory->getSession()->getExercicio(),
                    'response' => true,
                    // action* methods must always return an array
                ] + call_user_func_array([$this, $action], [$templating]);

        } catch (\Exception $e) {
            return [
                'response' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface $objectAdmin
     */
    public function view(FormMapper $formMapper, TceInterface $objectAdmin)
    {
        $formMapper = parent::view($formMapper, $objectAdmin);

        $this->relatorioConfiguracao->setCustomBodyTemplate("PrestacaoContasBundle::Tribunal/MG/Configuracao/ConfiguracaoEMP/list.html.twig");
    }

    /**
     * @return ArquivoEmp
     */
    protected function getArquivoEmp()
    {
        return new ArquivoEmp();
    }
}