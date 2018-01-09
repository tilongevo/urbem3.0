<?php

namespace Urbem\AdministrativoBundle\Controller\Administracao;

use Sonata\AdminBundle\Controller\CRUDController;

use Sonata\DoctrineORMAdminBundle\Model\ModelManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Urbem\CoreBundle\Entity\Administracao\AssinaturaModulo;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Model\Administracao\AssinaturaModuloModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class AssinaturaController
 * @package Urbem\AdministrativoBundle\Controller\Administracao
 */
class AssinaturaController extends CRUDController
{
    /** @var AbstractSonataAdmin */
    protected $admin;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function carregaOrcamentoEntidadesAction(Request $request)
    {
        $filtro = $request->get('q');
        $codEntidade = $request->get('codEntidade');
        $em = $this->getDoctrine()->getManager();

        $searchSql = is_numeric($filtro) ?
            sprintf("AND a.num_cgm = %s", $filtro) :
            sprintf(
                "AND lower(c.nom_cgm) LIKE '%%%s%%'
                AND a.cod_entidade = %s",
                strtolower($filtro),
                strtolower($codEntidade)
            );
        $params = [$searchSql];
        $entidadeModel = new Model\Administracao\AssinaturaModel($em);
        $result = $entidadeModel->carregaAdministracaoAssinatura($this->getExercicio(), $params);
        $entidades = [];

        foreach ($result as $entidade) {
            array_push(
                $entidades,
                [
                    'id'    => $entidade->exercicio . '~' . $entidade->cod_entidade . '~' . $entidade->numcgm,
                    'label' => $entidade->numcgm . " - " . $entidade->nom_cgm
                ]
            );
        }

        $items = [
            'items' => $entidades
        ];
        return new JsonResponse($items);
    }

    public function searchByEntidadeModuloAction(Request $request)
    {
        $entidade = $request->get('entidade');
        $modulo = $request->get('modulo');

        /** @var ModelManager $modelManager */
        $modelManager = $this->admin->getModelManager();
        $entityManager = $modelManager->getEntityManager(AssinaturaModulo::class);

        /** @var Entidade $entidade */
        $entidade = $modelManager->find(Entidade::class, $entidade);

        /** @var Modulo $modulo */
        $modulo = $modelManager->find(Modulo::class, $modulo);

        $exercicio = $this->admin->getExercicio();

        $assinaturaModuloArray = (new AssinaturaModuloModel($entityManager))
            ->getAssinaturasByEntidadeModulo($entidade, $modulo, $exercicio);

        $assinaturaArray = [];

        /** @var AssinaturaModulo $assinaturaModulo */
        foreach ($assinaturaModuloArray as $assinaturaModulo) {
            $assinatura = $assinaturaModulo->getFkAdministracaoAssinatura();
            $swCgm = $assinatura->getFkSwCgmPessoaFisica()->getFkSwCgm();

            $assinaturaArray[] = [
                'value' => $modelManager->getNormalizedIdentifier($assinatura),
                'label' => sprintf('%s - %s', strtoupper($swCgm->getNomCgm()), $assinatura->getCargo())
            ];
        }

        return new JsonResponse([
            'items' => $assinaturaArray
        ]);
    }
}
