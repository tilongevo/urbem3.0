<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao;

use Symfony\Bridge\Twig\TwigEngine;
use Urbem\CoreBundle\Entity\Tcemg\TetoRemuneratorio;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;

final class ConfigurarTetoRemuneratorio extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/MG/ConfigurarTetoRemuneratorio.js',
        ];
    }

    /**
     * @return bool
     */
    public function save()
    {
        try {
            $em = $this->factory->getEntityManager();
            $parameters = $this->getParameters();

            return $em->transactional(function ($entityManager) use ($parameters) {
                $exercicio = $this->factory->getSession()->getExercicio();
                $codEntidade = $this->getCodEntidade($parameters['entidade']);

                $tetoRemuneratorios = $entityManager->getRepository(TetoRemuneratorio::class)->findBy(['exercicio' => $exercicio, 'codEntidade' => $codEntidade]);
                foreach ($tetoRemuneratorios as $item) {
                    $entityManager->remove($item);
                }
                $entityManager->flush();

                $registros = isset($parameters['registros']) ? $parameters['registros'] : null;
                if (!is_null($registros)) {
                    foreach (array_shift($registros) as $registro) {
                        $vigencia = new DatePK($registro['vigencia']);
                        $evento = empty($registro['evento']) ? null : $registro['evento'];
                        $entity = $this->getTetoRemuneratorio();
                        $entity->setCodEntidade($codEntidade);
                        $entity->setExercicio($exercicio);
                        $entity->setVigencia($vigencia);
                        $entity->setTeto($registro['teto']);
                        $entity->setJustificativa($registro['justificativa']);
                        $entity->setCodEvento($evento);
                        $entityManager->persist($entity);
                    }
                    $entityManager->flush();
                }

                return;
            });
        } catch (\Exception $e) {
            $this->setErrorMessage($e->getMessage());

            return false;
        }
    }

    /**
     * @return array
     */
    protected function getParameters()
    {
        $formId = $this->getForm()->getName();

        return $this->getFormSonata()[$formId]['teto_remuneratorio_filter'];
    }

    /**
     * @param TwigEngine|null $templating
     * @return array
     */
    public function buildServiceProvider(TwigEngine $templating = null)
    {
        try {
            $em = $this->factory->getEntityManager();
            $data = [];
            list($exercicio, $codEntidade) = explode('~', $this->getRequest()->get('entidade'));
            $tetoRemuneratorios = $em->getRepository(TetoRemuneratorio::class)->findBy(['exercicio' => $exercicio, 'codEntidade' => $codEntidade]);

            /** @var TetoRemuneratorio $item */
            foreach ($tetoRemuneratorios as $item) {
                $data[] = [
                    'teto' => $item->getTeto(),
                    'vigencia' => $item->getVigencia()->format('d/m/Y'),
                    'justificativa' => (string) $item->getJustificativa(),
                    'evento' => $item->getCodEvento(),
                ];
            }

            return [
                'response' => true,
                'tetoRemuneratorios' => $data,
            ];

        } catch (\Exception $e) {
            return [
                'response' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * @return TetoRemuneratorio
     */
    protected function getTetoRemuneratorio()
    {
        return new TetoRemuneratorio();
    }
}