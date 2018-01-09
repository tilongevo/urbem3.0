<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Tcemg\ProjecaoAtuarial;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Symfony\Bridge\Twig\TwigEngine;

/**
 * Class ConfiguracaoProjecaoAtuarial
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao
 */
final class ConfiguracaoProjecaoAtuarial extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterConfiguracaoProjecaoAtuarial.php:63
     */
    const FINAL_EXERCICIO_CONTROLLER = 75;

    /**
     * @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterConfiguracaoProjecaoAtuarial.php:62
     */
    const INITIAL_EXERCICIO_CONTROLLER = 1;

    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/MG/ConfiguracaoProjecaoAtuarial.js',
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
                $exercicioEntidade = $this->factory->getSession()->getExercicio();
                $parameters = array_shift($formData);
                $codEntidade = $parameters['entidade'];
                $projecoes = $formData['projecoes'];

                foreach ($projecoes as $exercicio => $projecao) {
                    $entity = $entityManager->getRepository(ProjecaoAtuarial::class)->findOneBy([
                        ProjecaoAtuarial::EXERCICIO_ENTIDADE => $exercicioEntidade,
                        ProjecaoAtuarial::COD_ENTIDADE => $codEntidade,
                        ProjecaoAtuarial::EXERCICIO => $exercicio,
                    ]);
                    if (!$entity instanceof ProjecaoAtuarial) {
                        $entity = $this->getProjecaoAtuarial();
                        $entity->setExercicio($exercicio);
                        $entity->setExercicioEntidade($exercicioEntidade);
                        $entity->setCodEntidade($codEntidade);
                    }
                    $entity->setVlPatronal($projecao[ProjecaoAtuarial::VL_PATRONAL]);
                    $entity->setVlReceita($projecao[ProjecaoAtuarial::VL_RECEITA]);
                    $entity->setVlDespesa($projecao[ProjecaoAtuarial::VL_DESPESA]);
                    $entity->setVlRpps($projecao[ProjecaoAtuarial::VL_RPPS]);
                    $entityManager->persist($entity);
                }
                $entityManager->flush();
            });
        } catch (\Exception $e) {
            $this->setErrorMessage($e->getMessage());

            return false;
        }
    }

    /**
     * @param TwigEngine|null $templating
     * @return array
     */
    public function buildServiceProvider(TwigEngine $templating = null)
    {
        $formData = (object) $this->getFormSonata();
        $exercicio = $this->factory->getSession()->getExercicio();

        $projecoes = $this->factory->getEntityManager()->getRepository(ProjecaoAtuarial::class)->findToArray($exercicio, $formData->entidade);
        $data = $this->normalizeData($projecoes);

        return [
            'response' => true,
            'projecoes' => $data,
        ];
    }

    /**
     * @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterConfiguracaoProjecaoAtuarial.php:63
     *
     * @return array
     */
    protected function getExerciciosList()
    {
        $exercicios = [];
        $projecao = [
            ProjecaoAtuarial::VL_PATRONAL => '',
            ProjecaoAtuarial::VL_RECEITA => '',
            ProjecaoAtuarial::VL_DESPESA => '',
            ProjecaoAtuarial::VL_RPPS => '',
        ];

        $initialExercicio = ((int) $this->factory->getSession()->getExercicio()) - self::INITIAL_EXERCICIO_CONTROLLER;
        for ($i = 0; $i < self::FINAL_EXERCICIO_CONTROLLER; $i++) {
            $exercicios[$initialExercicio + $i] = $projecao;
        }

        return $exercicios;
    }

    /**
     * @param array $projecoes
     * @return array
     */
    protected function normalizeData(array $projecoes)
    {
        $exercicios = $this->getExerciciosList();

        foreach ($projecoes as $projecao) {
            $exercicio = $projecao[ProjecaoAtuarial::EXERCICIO];
            $exercicios[$exercicio] = [
                ProjecaoAtuarial::VL_PATRONAL => (float) $projecao[ProjecaoAtuarial::VL_PATRONAL],
                ProjecaoAtuarial::VL_RECEITA => (float) $projecao[ProjecaoAtuarial::VL_RECEITA],
                ProjecaoAtuarial::VL_DESPESA => (float) $projecao[ProjecaoAtuarial::VL_DESPESA],
                ProjecaoAtuarial::VL_RPPS => (float) $projecao[ProjecaoAtuarial::VL_RPPS],
            ];
        }

        return $exercicios;
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface $objectAdmin
     */
    public function view(FormMapper $formMapper, TceInterface $objectAdmin)
    {
        $formMapper = parent::view($formMapper, $objectAdmin);

        $this->relatorioConfiguracao->setCustomBodyTemplate("PrestacaoContasBundle::Tribunal/MG/Configuracao/ConfiguracaoProjecaoAtuarial/list.html.twig");
    }

    /**
     * @return ProjecaoAtuarial
     */
    protected function getProjecaoAtuarial()
    {
        return new ProjecaoAtuarial();
    }
}