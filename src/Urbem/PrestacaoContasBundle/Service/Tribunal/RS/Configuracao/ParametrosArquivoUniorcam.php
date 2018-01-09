<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\RS\Configuracao;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\CoreBundle\Entity\SwCgmPessoaJuridica;
use Urbem\CoreBundle\Model\SwCgmPessoaJuridicaModel;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Urbem\CoreBundle\Entity\Tcers;

class ParametrosArquivoUniorcam extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/RS/ParametrosArquivoUniorcam.js'
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
                if (!property_exists($formData, "tipo_identificador") || empty($formData->tipo_identificador)) {
                    throw new \Exception("Tipo identificador não informado");
                }

                if (!property_exists($formData, "cgm") || empty($formData->cgm)) {
                    throw new \Exception("CGM não informado");
                }

                $uniorcamRepository = $entityManager->getRepository(Tcers\Uniorcam::class);
                $pessoaJuridicaRepository = $entityManager->getRepository(SwCgmPessoaJuridica::class);
                foreach ($formData->tipo_identificador as $dadosIdentificador => $identificador) {
                    list($exercicio, $numOrgao, $numUnidade) = explode("~", $dadosIdentificador);
                    $uniorcam = $uniorcamRepository->findOneBy(["exercicio" => $exercicio, "numOrgao" => $numOrgao, "numUnidade" => $numUnidade]);
                    $pessoaJuridica = $pessoaJuridicaRepository->findOneByNumcgm($formData->cgm[$dadosIdentificador]);

                    $uniorcam->setIdentificador($identificador);
                    $uniorcam->setFkSwCgmPessoaJuridica($pessoaJuridica);
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
    protected function buildRequestAjaxListCgm()
    {
        $request = $this->getRequest();

        $swCgmPessoaJuridicaModelModel = new SwCgmPessoaJuridicaModel(self::$entityManager);
        $results = $swCgmPessoaJuridicaModelModel->findLike(['cgm.nomCgm'], $request->get('search_autocomplete_cgm'));

        /** @var SwCgmPessoaJuridica $swCgmPessoaJuridica */
        $cgms = [];
        foreach ($results as $swCgmPessoaJuridica) {
            $id = $swCgmPessoaJuridicaModelModel->getObjectIdentifier($swCgmPessoaJuridica->getFkSwCgm());
            $label = $swCgmPessoaJuridica->getFkSwCgm()->getNomCgm();

            array_push($cgms, ['id' => $id, 'label' => $label]);
        }

        return ['items' => $cgms];
    }

    /**
     * @return array
     */
    public function buildServiceProvider(TwigEngine $templating = null)
    {
        $request = $this->getRequest();
        if ($request->getMethod() == 'GET') {
            return $this->buildRequestAjaxListCgm();
        }

        $formData = (object) $this->getFormSonata();
        $ano = null;
        if (property_exists($formData, "filtro") && $formData->filtro == "exercicio") {
            $ano = $formData->exercicio;
        }

        return [
            'response' => true,
            'dadosUniorcam' => self::$entityManager->getRepository(Tcers\Uniorcam::class)->findUniorcamAll($ano),
            'identificadores' => $this->getListaUniorcam()
        ];
    }

    /**
     * @return array
     */
    protected function getListaUniorcam()
    {
        $listUniorcam = Tcers\Uniorcam::$identificadorList;

        $data = [];
        foreach ($listUniorcam as $key => $item) {
            $data[] = ['id' => $key, 'label' => $item];
        }

        return $data;
    }

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @return array|\Urbem\CoreBundle\Entity\Tcers\RdExtra[]
     */
    public static function getListItemsUniorcam(EntityManager $entityManager)
    {
        return $entityManager->getRepository(Tcers\Uniorcam::class)->findAll();
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface $objectAdmin
     */
    public function view(FormMapper $formMapper, TceInterface $objectAdmin)
    {
        $formMapper = parent::view($formMapper, $objectAdmin);

        // Conteúdo específico
        $this->relatorioConfiguracao->setCustomBodyTemplate("PrestacaoContasBundle::Tribunal/RS/Configuracao/formUniorcamList.html.twig");
    }
}
