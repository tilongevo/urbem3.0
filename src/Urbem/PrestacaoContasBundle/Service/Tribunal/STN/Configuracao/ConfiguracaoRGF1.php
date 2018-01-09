<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Symfony\Bridge\Twig\TwigEngine;

/**
 * Class ConfiguracaoRGF1
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\STN\Configuracao
 */
final class ConfiguracaoRGF1 extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @see gestaoPrestacaoContas/fontes/PHP/STN/instancias/configuracao/FMConfigurarRGF1.php:65
     */
    const PARAMETRO = 'stn_rgf1_despesas_exercicios_anteriores';

    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/STN/ConfiguracaoRGF1.js',
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
        $formData = (array) $this->getFormSonata();

        try {
            $em = $this->factory->getEntityManager();

            return $em->transactional(function ($entityManager) use ($formData) {
                $exercicio = $this->factory->getSession()->getExercicio();
                $formData = array_shift($formData);

                $entity = $entityManager->getRepository(Configuracao::class)->findOneBy([
                    'exercicio' => $exercicio,
                    'codModulo' => Modulo::MODULO_STN,
                    'parametro' => self::PARAMETRO,
                ]);

                if ($entity instanceof Configuracao) {
                    $entityManager->remove($entity);
                    $entityManager->flush();
                }

                if (!empty($formData['codDespesa'])) {
                    $entity = $this->getConfiguracao();
                    $entity->setExercicio($exercicio);
                    $entity->setCodModulo(Modulo::MODULO_STN);
                    $entity->setParametro(self::PARAMETRO);
                    $entity->setValor($formData['codDespesa']);
                    $entityManager->persist($entity);
                    $entityManager->flush();
                }

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
        $exercicio = $this->factory->getSession()->getExercicio();
        $em = $this->factory->getEntityManager();

        /**
         * @see gestaoPrestacaoContas/fontes/PHP/STN/instancias/configuracao/FMConfigurarRGF1.php:61
         * @var $configuracao Configuracao
         */
        $configuracao = $em->getRepository(Configuracao::class)->findOneBy([
            'exercicio' => $exercicio,
            'codModulo' => Modulo::MODULO_STN,
            'parametro' => self::PARAMETRO,
        ]);

        return [
            'response' => true,
            'codDespesa' => ($configuracao instanceof Configuracao) ? $configuracao->getValor() : false,
        ];
    }

    /**
     * @return Configuracao
     */
    protected function getConfiguracao()
    {
        return new Configuracao();
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