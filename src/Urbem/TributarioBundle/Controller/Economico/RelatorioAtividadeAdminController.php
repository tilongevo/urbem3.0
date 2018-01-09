<?php

namespace Urbem\TributarioBundle\Controller\Economico;

use DateTime;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Economico\Atividade;

/**
 * Class RelatorioAtividadeAdminController
 * @package Urbem\TributarioBundle\Controller\Economico
 */
class RelatorioAtividadeAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function filtroAction(Request $request)
    {
        return parent::createAction();
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction()
    {
        $em = $this->getDoctrine()->getManager();
        $container = $this->container;

        $html = $this->renderView(
            'TributarioBundle:Economico/RelatorioAtividade:relatorio_atividade.html.twig',
            [
                'modulo' => 'Economico',
                'subModulo' => 'Relatórios',
                'funcao' => 'Atividade',
                'nomRelatorio' => 'Relatório de Atividades',
                'dtEmissao' => new DateTime(),
                'usuario' => $container->get('security.token_storage')->getToken()->getUser(),
                'versao' => $container->getParameter('version'),
                'entidade' => $this->get('urbem.entidade')->getEntidade(),
                'atividades' => $this->getAtividades(),
            ]
        );

        $now = new DateTime();
        $filename = sprintf('RelatorioDeAtividades_%s.pdf', $now->format('Y-m-d_His'));

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml(
                $html,
                [
                    'encoding' => 'utf-8',
                    'enable-javascript' => true,
                    'footer-line' => true,
                    'footer-left' => 'URBEM - CNM',
                    'footer-right' => '[page]',
                    'footer-center' => 'www.cnm.org.br',
                    'orientation'=>'Landscape'
                ]
            ),
            200,
            [
                'Content-Description' => 'File Transfer',
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename),
            ]
        );
    }

    /**
    * @return array
    */
    protected function getAtividades()
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->admin->getForm();
        $form->handleRequest($this->getRequest());

        $qb = $em->getRepository(Atividade::class)->createQueryBuilder('o');

        $qb->join('o.fkEconomicoNivelAtividade', 'nivel_atividade');
        $qb->join('nivel_atividade.fkEconomicoNivelAtividadeValores', 'nivel_atividade_valores');
        $qb->join('nivel_atividade.fkEconomicoVigenciaAtividade', 'vigencia_atividade');

        $qb->andWhere('vigencia_atividade.codVigencia = :codVigencia');
        $qb->setParameter('codVigencia', $form->get('vigencia')->getData()->getCodVigencia());

        if ($nomAtividade = $form->get('nomAtividade')->getData()) {
            $qb->andWhere('o.nomAtividade LIKE :nomAtividade');
            $qb->setParameter('nomAtividade', sprintf('%%%s%%', strtolower($nomAtividade)));
        }

        if ($atividadeInicial = $form->get('atividadeInicial')->getData()) {
            $qb->andWhere('o.codEstrutural >= :codEstruturalInicial');
            $qb->setParameter('codEstruturalInicial', $atividadeInicial->getCodEstrutural());
        }

        if ($atividadeFinal = $form->get('atividadeFinal')->getData()) {
            $qb->andWhere('o.codEstrutural <= :codEstruturalFinal');
            $qb->setParameter('codEstruturalFinal', $atividadeFinal->getCodEstrutural());
        }

        $qb->orderBy(sprintf('o.%s', $form->get('ordenacao')->getData()), 'ASC');

        return $qb->getQuery()->getResult();
    }
}
