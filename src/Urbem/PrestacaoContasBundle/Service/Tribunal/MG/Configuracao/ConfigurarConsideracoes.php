<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Tcemg\ConsideracaoArquivoDescricao;
use Urbem\CoreBundle\Model\Tcemg\ConsideracaoArquivoModel;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Symfony\Bridge\Twig\TwigEngine;

/**
 * Class ConfigurarConsideracoes
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuraca
 */
final class ConfigurarConsideracoes extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/ExternalLib/jquery.dataTables.min.js',
            '/prestacaocontas/js/ExternalLib/dataTables.scroller.min.js',
            '/prestacaocontas/js/Tribunal/MG/ConfigurarConsideracoes.js',
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
                $data = array_shift($formData);
                $exercicio = $this->factory->getSession()->getExercicio();
                $codEntidade = $this->getCodEntidade($data[ConsideracaoArquivoModel::FIELD_ENTIDADE]);
                $periodo = $data[ConsideracaoArquivoModel::FIELD_PERIODO];
                $modulo = $data[ConsideracaoArquivoModel::FIELD_MODULO];
                $consideracoes = array_shift($formData);

                $repository = $entityManager->getRepository(ConsideracaoArquivoDescricao::class);
                foreach ($consideracoes as $codArquivo => $descricao) {
                    $entity = $repository->findOneBy([
                        ConsideracaoArquivoModel::FIELD_EXERCICIO => $exercicio,
                        ConsideracaoArquivoModel::FIELD_ENTIDADE => $codEntidade,
                        ConsideracaoArquivoModel::FIELD_PERIODO => $periodo,
                        ConsideracaoArquivoModel::FIELD_MODULO => $modulo,
                        ConsideracaoArquivoModel::FIELD_COD_ARQUIVO => $codArquivo
                        ]);

                    $entity->setDescricao((string) $descricao);
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

        $model = $this->getModel();

        $codEntidade = $this->getCodEntidade($formData->codEntidade);
        $exercicio = $this->factory->getSession()->getExercicio();
        $periodo = $formData->periodo;
        $modulo = $formData->moduloSicom;
        $result = $model->findConsideracoesToArray($exercicio, $codEntidade, $periodo, $modulo);

        return [
            'arquivos' => $result
        ];
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface $objectAdmin
     */
    public function view(FormMapper $formMapper, TceInterface $objectAdmin)
    {
        $formMapper = parent::view($formMapper, $objectAdmin);

        $this->relatorioConfiguracao->setCustomBodyTemplate("PrestacaoContasBundle::Tribunal/MG/Configuracao/ConfigurarConsideracoes/list.html.twig");
    }

    protected function getModel()
    {
        return new ConsideracaoArquivoModel($this->factory->getEntityManager());
    }
}