<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Stn\VinculoSaudeRreo12;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Symfony\Bridge\Twig\TwigEngine;

/**
 * Class VincularReceitaSaudeAnexo12
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Configuracao
 */
final class VincularReceitaSaudeAnexo12 extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/STN/VincularReceitaSaudeAnexo12.js',
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
        $parameters = $this->getParameters();

        try {
            $em = $this->factory->getEntityManager();

            return $em->transactional(function ($entityManager) use ($parameters) {
                $exercicio = $this->factory->getSession()->getExercicio();
                $vinculos = $entityManager->getRepository(VinculoSaudeRreo12::class)->findBy(['exercicio' => $exercicio]);

                foreach ($vinculos as $vinculo) {
                    $entityManager->remove($vinculo);
                }
                $entityManager->flush();

                if ($parameters) {
                    $parameters = array_shift($parameters);
                    $data = $parameters['dynamic_collection'];

                    $this->validateReceita($data);
                    foreach ($data as $item) {
                        if (!is_numeric($item['exercicio']) || strlen($item['exercicio']) < 4) {
                            throw new \Exception('Exercicio Inválido!');
                        }
                        $entity = $this->getVinculoSaudeRreo12();
                        list($exercicio, $codReceita) = explode("~", $item['codReceita']);
                        $entity->setCodReceita($codReceita);
                        $entity->setExercicio($exercicio);

                        $entityManager->persist($entity);
                        $entityManager->flush();
                    }
                }

                return true;
            });
        } catch (\Exception $e) {
            $this->setErrorMessage($e->getMessage());
            return false;
        }
    }

    /**
     * @see gestaoPrestacaoContas/fontes/PHP/STN/instancias/configuracao/OCConfigurarRREO12.php:55
     * @param array $data
     * @throws \Exception
     */
    protected function validateReceita(array $data)
    {
        foreach ($data as $key => $item) {
            unset($data[$key]);
            if (in_array($item['codReceita'], array_column($data, 'codReceita'))) {
                throw new \Exception('Existe Receita duplicada na lista!');
            }
        }
    }

    /**
     * @param TwigEngine|null $templating
     * @return array|mixed
     */
    public function buildServiceProvider(TwigEngine $templating = null)
    {
        $data = [];
        $em = $this->factory->getEntityManager();
        $exercicio = $this->factory->getSession()->getExercicio();
        try {
            $qb = $em->getRepository(VinculoSaudeRreo12::class)->findByExercicio($exercicio);
            $entities = $qb->getQuery()->getResult();
            /** @var VinculoSaudeRreo12 $entity */
            foreach ($entities as $entity) {
                $data[]= [
                    'exercicio' => $entity->getExercicio(),
                    'codReceita' => $exercicio . "~" . $entity->getCodReceita(),
                    'descricao' => $entity->getCodReceita() . " - " . $entity->getFkOrcamentoReceita()->getFkOrcamentoContaReceita()->getDescricao(),
                ];
            }

            return [
                'response' => true,
                'receitas' => $data,
            ];

        } catch (\Exception $e) {
            return [
                'response' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * @return mixed
     */
    protected function getParameters()
    {
        $form = (array)$this->getFormSonata();
        $form = array_shift($form);

        return isset($form['stn_vincular_receita_saude_anexo_12']) ? $form['stn_vincular_receita_saude_anexo_12'] : false;
    }

    /**
     * @return VinculoSaudeRreo12
     */
    protected function getVinculoSaudeRreo12()
    {
        return new VinculoSaudeRreo12();
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface $objectAdmin
     */
    public function view(FormMapper $formMapper, TceInterface $objectAdmin)
    {
        $formMapper = parent::view($formMapper, $objectAdmin);
    }
}