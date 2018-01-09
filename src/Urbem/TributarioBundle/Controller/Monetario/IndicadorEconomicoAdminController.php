<?php

namespace Urbem\TributarioBundle\Controller\Monetario;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Monetario\IndicadorEconomico;
use Urbem\CoreBundle\Entity\Monetario\ValorIndicador;
use Urbem\CoreBundle\Helper\BreadCrumbsHelper;
use Urbem\CoreBundle\Helper\DatePK;
use Symfony\Component\HttpFoundation\RedirectResponse;

class IndicadorEconomicoAdminController extends CRUDController
{

    /**
     * @param array $param
     * @param null $route
     */
    public function setBreadCrumb($param = [], $route = null)
    {
        $entityManager = $this->getDoctrine()->getManager();

        BreadCrumbsHelper::getBreadCrumb(
            $this->get("white_october_breadcrumbs"),
            $this->get("router"),
            $route,
            $entityManager,
            $param
        );
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function definirValorAction(Request $request)
    {
        $id = $this->admin->getIdParameter();
        $this->setBreadCrumb($id ? ['id' => $id] : [], $request->get('_route'));

        $container = $this->container;

        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();

        try {
            $id = $request->get($this->admin->getIdParameter());

            $indicador_economico = $em->getRepository(IndicadorEconomico::class)
                -> findOneBy([
                    'codIndicador' => $id
                ]);

            $valoresIndicador = $em->getRepository(ValorIndicador::class)
                ->findBy([
                    'codIndicador' => $indicador_economico->getCodIndicador()
                ]);

            $form = $this->createForm(
                'Urbem\TributarioBundle\Form\Monetario\IndicadorEconomico\DefinirValorType',
                null,
                array('action' => $this->generateUrl('urbem_tributario_monetario_indicador_economico_salvar_valor'))
            );

            $form->handleRequest($request);

            return $this->render('TributarioBundle::Monetario/IndicadorEconomico/definir_valor.html.twig', array(
                'indicador' => $indicador_economico,
                'valoresIndicador' => $valoresIndicador,
                'form' => $form->createView(),
                'errors' => $form->getErrors()
            ));
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.monetarioIndicadorEconomico.erroDefinirValor'));
            throw $e;
        }
    }

    /**
     * @param Request $request
     * @throws \Exception
     */
    public function salvarValorAction(Request $request)
    {
        $container = $this->container;
        $em = $this->getDoctrine()->getManager();

        try {
            $dataForm = $request->request->all();

            $indicador_economico = $em->getRepository(IndicadorEconomico::class)
                ->findOneBy([
                    'codIndicador' => $dataForm['indicador_id']
                ]);

            // Remove ValorIndicador
            $valorIndicadores = $em->getRepository(ValorIndicador::class)
                ->findBy([
                    'codIndicador' => $dataForm['indicador_id']
                ]);

            foreach ($valorIndicadores as $valorIndicadore) {
                $em->remove($valorIndicadore);
            }
            $em->flush();

            $valores = isset($dataForm['valores']) ? $dataForm['valores'] : null;

            if (!is_null($valores)) {
                foreach ($valores as $definir_valor) {
                    list($valor, $vigencia) = explode('__', $definir_valor);
                    $dtVigencia = \DateTime::createFromFormat('d/m/Y', $vigencia);

                    $valorIndicador = $em->getRepository(ValorIndicador::class)
                        ->findOneBy([
                            'codIndicador' => $dataForm['indicador_id'],
                            'inicioVigencia' => $dtVigencia->format('Y-m-d')
                        ]);

                    if ($valorIndicador) {
                        continue;
                    }

                    $valorIndicador = new ValorIndicador();
                    $valorIndicador->setFkMonetarioIndicadorEconomico($indicador_economico);
                    $valorIndicador->setInicioVigencia(new DatePK($dtVigencia->format('Y-m-d')));
                    $valorIndicador->setValor($valor);

                    $em->persist($valorIndicador);
                    $em->flush();
                }
            }
            $container->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('label.monetarioIndicadorEconomico.sucessoDefinirValor'));
            (new RedirectResponse("/tributario/cadastro-monetario/indicador-economico/list"))->send();
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.monetarioIndicadorEconomico.erroDefinirValor'));
            throw $e;
        }
    }
}
