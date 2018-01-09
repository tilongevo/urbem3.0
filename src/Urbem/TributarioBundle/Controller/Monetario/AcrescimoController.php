<?php

namespace Urbem\TributarioBundle\Controller\Monetario;

use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Administracao\Funcao;
use Urbem\CoreBundle\Entity\Monetario\Acrescimo;
use Urbem\CoreBundle\Entity\Monetario\FormulaAcrescimo;
use Urbem\CoreBundle\Entity\Monetario\ValorAcrescimo;
use Urbem\CoreBundle\Helper\DatePK;

class AcrescimoController extends BaseController
{
    /**
     * @param Request $request
     */
    public function alterarFormulaCalculoAction(Request $request)
    {
        $container = $this->container;
        $em = $this->getDoctrine()->getManager();

        try {
            $dataForm = $request->request->all();

            list($codAcrescimo, $codTipo) = explode('~', $dataForm['acrescimo_id']);

            $acrescimo = $em->getRepository(Acrescimo::class)
                -> findOneBy([
                    'codAcrescimo' => $codAcrescimo,
                    'codTipo' => $codTipo
                ]);

            list($codModulo, $codBiblioteca, $codFuncao) = explode('.', $dataForm['formula_calculo']['funcao']);

            $funcao = $em->getRepository(Funcao::class)
                ->findOneBy(array('codModulo' => $codModulo, 'codBiblioteca' => $codBiblioteca, 'codFuncao' => $codFuncao));

            $formulaAcrescimo = new FormulaAcrescimo();
            $formulaAcrescimo->setFkMonetarioAcrescimo($acrescimo);
            $formulaAcrescimo->setFkAdministracaoFuncao($funcao);

            $em->persist($formulaAcrescimo);
            $em->flush();

            $container->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('label.monetarioAcrescimo.sucessoFormulaCalculo'));
            (new RedirectResponse("/tributario/cadastro-monetario/acrescimo/list"))->send();
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.monetarioAcrescimo.erroFormulaCalculo'));
            throw $e;
        }
    }

    /**
     * @param Request $request
     */
    public function definirValorAction(Request $request)
    {
        $container = $this->container;
        $em = $this->getDoctrine()->getManager();

        try {
            $dataForm = $request->request->all();

            list($codAcrescimo, $codTipo) = explode('~', $dataForm['acrescimo_id']);

            $acrescimo = $em->getRepository(Acrescimo::class)
                -> findOneBy([
                    'codAcrescimo' => $codAcrescimo,
                    'codTipo' => $codTipo
                ]);

            // Remove ValorAcrescimo
            $valorAcrescimos = $em->getRepository(ValorAcrescimo::class)
                ->findBy([
                    'codAcrescimo' => $codAcrescimo,
                    'codTipo' => $codTipo
                ]);

            foreach ($valorAcrescimos as $valorAcrescimo) {
                $em->remove($valorAcrescimo);
            }
            $em->flush();

            $valores = $dataForm['valores'];

            foreach ($valores as $valor) {
                list($valor, $vigencia) = explode('__', $valor);
                $dtVigencia = \DateTime::createFromFormat('d/m/Y', $vigencia);

                $valorAcrescimo = $em->getRepository(ValorAcrescimo::class)
                    ->findOneBy([
                        'codAcrescimo' => $codAcrescimo,
                        'codTipo' => $codTipo,
                        'inicioVigencia' => $dtVigencia->format('Y-m-d')
                    ]);

                if ($valorAcrescimo) {
                    continue;
                }

                $valorAcrescimo = new ValorAcrescimo();
                $valorAcrescimo->setFkMonetarioAcrescimo($acrescimo);
                $valorAcrescimo->setInicioVigencia(new DatePK($dtVigencia->format('Y-m-d')));
                $valorAcrescimo->setValor(str_replace(',', '.', $valor));

                $em->persist($valorAcrescimo);
                $em->flush();
            }

            $container->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('label.monetarioAcrescimo.sucessoDefinirValor'));
            (new RedirectResponse("/tributario/cadastro-monetario/acrescimo/list"))->send();
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.monetarioAcrescimo.erroDefinirValor'));
            throw $e;
        }
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function carregaAcrescimoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository(Acrescimo::class)->createQueryBuilder('acrescimo');

        $this->filterQueryString($qb, $request);

        $results = [];
        foreach ((array) $qb->getQuery()->getResult() as $acrescimo) {
            $results[] = [
                'id' => $acrescimo->getCodAcrescimo(),
                'label' => $acrescimo->getDescricaoAcrescimo(),
            ];
        }

        return new JsonResponse(['items' => $results]);
    }

    /**
     * @param QueryBuilder $qb
     * @param Request $request
     * @return void
     */
    protected function filterQueryString(QueryBuilder $qb, Request $request)
    {
        $descricaoAcrescimo = $request->get('q');
        $qb->where(sprintf('LOWER(%s.descricaoAcrescimo) LIKE :descricaoAcrescimo', $qb->getRootAlias()));
        if ($descricaoAcrescimo) {
            $qb->setParameter('descricaoAcrescimo', sprintf('%%%s%%', strtolower($descricaoAcrescimo)));
        }

        if (!$descricaoAcrescimo) {
            $qb->setParameter('descricaoAcrescimo', null);
        }
    }
}
