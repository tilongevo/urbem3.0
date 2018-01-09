<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\RS\Configuracao;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Urbem\CoreBundle\Entity\Tcers;

class ReceitaCaracPeculiarReceita extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/RS/ReceitaCaracPeculiarReceita.js'
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
        $formData = (object) $this->getFormSonata();

        try {
            $em = $this->factory->getEntityManager();

            return $em->transactional(function ($entityManager) use ($formData) {
                if (!property_exists($formData, "tipo_caracteristica") || empty($formData->tipo_caracteristica)) {
                    throw new \Exception("Tipo característica não informado");
                }

                $receitaCaracPeculiarRepository = $entityManager->getRepository(Tcers\ReceitaCaracPeculiarReceita::class);
                $caracPeculiarReceitaRepository = $entityManager->getRepository(Tcers\CaracPeculiarReceita::class);
                foreach ($formData->tipo_caracteristica as $dadosReceita => $caracteristica) {
                    list($exercicio, $codReceita) = explode("~", $dadosReceita);
                    $receitaCarac = $receitaCaracPeculiarRepository->findOneBy(["exercicio" => $exercicio, "codReceita" => $codReceita]);

                    $caracPeculiarReceita = $caracPeculiarReceitaRepository->findOneByCodCaracteristica((int) $caracteristica);
                    $receitaCarac->setFkTcersCaracPeculiarReceita($caracPeculiarReceita);
                }

                $entityManager->flush();
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
        $formData = (object) $this->getFormSonata();
        $ano = null;
        if (property_exists($formData, "filtro") && $formData->filtro == "exercicio") {
            $ano = $formData->exercicio;
        }

        return [
            'response' => true,
            'dadosReceitaPeculiar' => self::$entityManager->getRepository(Tcers\ReceitaCaracPeculiarReceita::class)->findReceitaCaracPeculiarReceitaByExercicio($ano),
            'caracteristica' => $this->getListaReceitasPeculiares()
        ];
    }

    /**
     * @return array
     */
    protected function getListaReceitasPeculiares()
    {
        $listReceitasPeculiares = self::$entityManager->getRepository(Tcers\CaracPeculiarReceita::class)->findAll();

        $data = [];
        foreach ($listReceitasPeculiares as $caracPeculiarReceita) {
            $data[] = ['id' => $caracPeculiarReceita->getCodCaracteristica(), 'label' => $caracPeculiarReceita->getDescricao()];
        }

        return $data;
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface $objectAdmin
     */
    public function view(FormMapper $formMapper, TceInterface $objectAdmin)
    {
        $formMapper = parent::view($formMapper, $objectAdmin);

        // Conteúdo específico
        $this->relatorioConfiguracao->setCustomBodyTemplate("PrestacaoContasBundle::Tribunal/RS/Configuracao/formReceitaCaracPeculiarReceitaList.html.twig");
    }
}
