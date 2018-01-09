<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\RS\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\CoreBundle\Entity\Tcers\Credor;
use Urbem\CoreBundle\Model\Tcers\CredorModel;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;

/**
 * Class ParametrosArquivoCredor
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\RS\Configuracao
 */
class ParametrosArquivoCredor extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/ExternalLib/jquery.dataTables.min.js',
            '/prestacaocontas/js/ExternalLib/dataTables.scroller.min.js',
            '/prestacaocontas/js/Tribunal/RS/ParametrosArquivoCredor.js'
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
                if (!property_exists($formData, "tipo_credor") || empty($formData->tipo_credor)) {
                    throw new \Exception("Tipo credor não informado");
                }

                $credorRepository = $entityManager->getRepository(Credor::class);
                foreach ($formData->tipo_credor as $exercicioCgm => $tipoCredor) {
                    list($exercicio, $numcgm) = explode("~", $exercicioCgm);
                    $credor = $credorRepository->findOneBy(["exercicio" => $exercicio, "numcgm" => $numcgm]);
                    $credor->setTipo($tipoCredor);
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
        $credorModel = new CredorModel(self::$entityManager);
        $formData = (object) $this->getFormSonata();
        $ano = null;
        $credoresExercicioAtual = null;
        $response = "Dados inválidos para consulta";

        if (property_exists($formData, "filtro") && $formData->filtro == "todos") {
            $credoresExercicioAtual = $this->getRecuperaDadosCredor($credorModel);
        } elseif (property_exists($formData, "filtro") && $formData->filtro == "exercicio") {
            $ano = $formData->exercicio;
        }

        $tipoCredores = $this->getListaTiposCredores();
        $dadosCredorConversao = $this->getRecuperaDadosCredorConversao($credorModel, $ano);

        return [
            'response' => true,
            'content' => $response,
            'tipoCredores' => $tipoCredores,
            'dadosCredorConversao' => $dadosCredorConversao,
            'credoresExercicioAtual' => $credoresExercicioAtual
        ];
    }

    /**
     * @param \Urbem\CoreBundle\Model\Tcers\CredorModel $credorModel
     * @param null $ano
     * @return string
     */
    protected function getRecuperaDadosCredorConversao(CredorModel $credorModel, $ano = null)
    {
        return $credorModel->getRecuperaDadosCredorConversao($this->factory->getSession()->getExercicio(), $ano);
    }

    /**
     * @param \Urbem\CoreBundle\Model\Tcers\CredorModel $credorModel
     * @return mixed
     */
    protected function getRecuperaDadosCredor(CredorModel $credorModel)
    {
        return $credorModel->getRecuperaDadosCredor($this->factory->getUser(), $this->factory->getSession()->getExercicio());
    }

    /**
     * @return array
     */
    protected function getListaTiposCredores()
    {
        return [
            [
                'id' => 1,
                'label' => "01 - Credores da Administração Pública Municipal",
            ],
            [
                'id' => 2,
                'label' => "02 - Credores que não pertencem à Administração Pública Municipal",
            ]
        ];
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface $objectAdmin
     */
    public function view(FormMapper $formMapper, TceInterface $objectAdmin)
    {
        $formMapper = parent::view($formMapper, $objectAdmin);

        // Conteúdo específico
        $this->relatorioConfiguracao->setCustomBodyTemplate("PrestacaoContasBundle::Tribunal/RS/Configuracao/formList.html.twig");
    }
}
