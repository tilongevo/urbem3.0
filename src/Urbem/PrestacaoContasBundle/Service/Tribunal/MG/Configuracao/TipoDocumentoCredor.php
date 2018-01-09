<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Licitacao\Documento;
use Urbem\CoreBundle\Entity\Tcemg\DeParaDocumento;
use Urbem\CoreBundle\Entity\Tcemg\TipoDocCredor;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Symfony\Bridge\Twig\TwigEngine;

/**
 * Class TipoDocumentoCredor
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao
 */
final class TipoDocumentoCredor extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    const FIELD_TIPO_DOC_CREDOR = 'tipoDocCredor';
    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/ExternalLib/jquery.dataTables.min.js',
            '/prestacaocontas/js/ExternalLib/dataTables.scroller.min.js',
            '/prestacaocontas/js/Tribunal/MG/TipoDocumentoCredor.js',
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
                $tipoDocCredor = $formData[self::FIELD_TIPO_DOC_CREDOR];

                $repository = $entityManager->getRepository(DeParaDocumento::class);
                foreach ($tipoDocCredor as $codDocumento => $tipo) {
                    $entity = $repository->findOneBy(["codDocUrbem" => (int) $codDocumento]);
                    if ($entity instanceof DeParaDocumento) {
                        if (empty($tipo)) {
                            $entityManager->remove($entity);
                        } else {
                            $entity->setCodDocUrbem($codDocumento);
                            $entity->setCodDocTce($tipo);
                            $entityManager->persist($entity);
                        }
                    } else {
                        if (!empty($tipo)) {
                            $entity = $this->getDeParaDocumento();
                            $entity->setCodDocUrbem($codDocumento);
                            $entity->setCodDocTce($tipo);
                            $entityManager->persist($entity);
                        }
                    }
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
        $tipoDocumento = $this->factory->getEntityManager()->getRepository(Documento::class)->findAllTipoDocumento();
        $tipoDocCredor = $this->factory->getEntityManager()->getRepository(TipoDocCredor::class)->findAllToArray();

        return [
            'tipoDocumento' => $tipoDocumento,
            'tipoDocCredor' => $tipoDocCredor,
        ];
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface $objectAdmin
     */
    public function view(FormMapper $formMapper, TceInterface $objectAdmin)
    {
        $formMapper = parent::view($formMapper, $objectAdmin);

        $this->relatorioConfiguracao->setCustomBodyTemplate("PrestacaoContasBundle::Tribunal/MG/Configuracao/TipoDocumentoCredor/list.html.twig");
    }

    /**
    * @return DeParaDocumento
    */
    protected function getDeParaDocumento()
    {
        return new DeParaDocumento();
    }
}