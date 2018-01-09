<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Stn\NotaExplicativa;
use Urbem\CoreBundle\Entity\Stn\RiscosFiscais;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Symfony\Bridge\Twig\TwigEngine;

/**
 * Class ManterNotasExplicativas
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Configuracao
 */
final class ManterNotasExplicativas extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    const COD_FUNCIONALIDADE = 406;

    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/STN/ManterNotasExplicativas.js',
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
     * @return bool
     */
    public function save()
    {
        $parameters = $this->getParameters();

        try {
            $em = $this->factory->getEntityManager();

            return $em->transactional(function ($entityManager) use ($parameters) {
                $notas = $entityManager->getRepository(NotaExplicativa::class)->findAll();
                foreach ($notas as $nota) {
                    $entityManager->remove($nota);
                }
                $entityManager->flush();

                if ($parameters) {
                    $parameters = array_shift($parameters);
                    $data = $parameters['dynamic_collection'];

                    $this->validateData($data);
                    foreach ($data as $nota) {
                        $dataInicial = DatePK::toPHPValue('d/m/Y', $nota['dataInicial']);
                        $dataFinal = DatePK::toPHPValue('d/m/Y', $nota['dataFinal']);

                        $entity = $this->getNotaExplicativa();
                        $entity->setCodAcao($nota['anexo']);
                        $entity->setDtInicial($dataInicial);
                        $entity->setDtFinal($dataFinal);
                        $entity->setNotaExplicativa($nota['notaExplicativa']);

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
     * @see gestaoPrestacaoContas/fontes/PHP/STN/instancias/configuracao/OCManterNotasExplicativas.php:143
     *
     * @param array $data
     * @throws \Exception
     */
    protected function validateData(array $data)
    {
        foreach ($data as $key => $item) {
            unset($data[$key]);
            $anexo = $item['anexo'];
            $dataInicial = $item['dataInicial'];
            $dataFinal = $item['dataFinal'];
            if ($this->isEquals($data, $anexo, $dataInicial, $dataFinal)) {
                throw new \Exception('Esse item já consta na listagem.');
            }
        }
    }

    /**
     * @see gestaoPrestacaoContas/fontes/PHP/STN/instancias/configuracao/OCManterNotasExplicativas.php:143
     *
     * @param array $data
     * @param $anexo
     * @param $dataInicial
     * @param $dataFinal
     * @return bool
     */
    protected function isEquals(array $data, $anexo, $dataInicial, $dataFinal)
    {
        foreach ($data as $value) {
            if ($anexo == $value['anexo'] && $dataInicial == $value['dataInicial'] && $dataFinal == $value['dataFinal']) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param TwigEngine|null $templating
     * @return array|mixed
     */
    public function buildServiceProvider(TwigEngine $templating = null)
    {
        $notas = [];
        $em = $this->factory->getEntityManager();
        try {
            $entities = $em->getRepository(NotaExplicativa::class)->findAll();
            /** @var NotaExplicativa $entity */
            foreach ($entities as $entity) {
                $notas[] = [
                    'codAcao' => $entity->getCodAcao(),
                    'dataInicial' => $entity->getDtInicial()->format('d/m/Y'),
                    'dataFinal' => $entity->getDtFinal()->format('d/m/Y'),
                    'notaExplicativa' => $entity->getNotaExplicativa(),
                ];
            }

            return [
                'response' => true,
                'notas' => $notas,
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
        $form = (array) $this->getFormSonata();
        $form = array_shift($form);

        return isset($form['stn_manter_notas_explicativas']) ? $form['stn_manter_notas_explicativas'] : false;
    }

    /**
     * @return NotaExplicativa
     */
    protected function getNotaExplicativa()
    {
        return new NotaExplicativa();
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