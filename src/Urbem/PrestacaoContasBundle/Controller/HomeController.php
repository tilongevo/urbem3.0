<?php

namespace Urbem\PrestacaoContasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Entity\Tcemg\RegistroPrecos;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\PrestacaoContasBundle\Helper\TribunaisHelper;
use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form\ConfiguracaoContratoType;
use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form\RegistroPrecos\RegistroPrecosType;

class HomeController extends BaseController
{
    public function indexAction()
    {
        $this->setBreadCrumb();

        $info = $this->get('prefeitura.info');
        $uf = $info->getUf();
        $tribunal = TribunaisHelper::getContentJsonReportListByUF(strtoupper($uf));
        $stn = TribunaisHelper::getContentJsonReportListByUF('STN');

        return $this->render(
            'PrestacaoContasBundle:Home:index.html.twig',
            [
                'tribunal' => $tribunal,
                'tce_uf' => $uf,
                'stn' => $stn
            ]
        );
    }

    /**
     * @see src/Urbem/PrestacaoContasBundle/Resources/config/routing/stn/stn.yml
     * @param $uf
     * @param $group
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function configuracaoAction($uf, $group)
    {
        return $this->parseDetailContent($uf, $group, 'prestacao_contas_relatorio_configuracao_create');
    }

    /**
     * @see src/Urbem/PrestacaoContasBundle/Resources/config/routing/stn/stn.yml
     * @param $uf
     * @param $group
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function configuracaoTceAction($uf, $group)
    {
        return $this->parseDetailContent($uf, $group, 'prestacao_contas_relatorio_configuracao_create', 'TCE ');
    }

    /**
     * @see src/Urbem/PrestacaoContasBundle/Resources/config/routing/stn/stn.yml
     * @param $uf
     * @param $group
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function stnAction($uf, $group)
    {
        return $this->parseDetailContent($uf, $group, 'prestacao_contas_relatorio_stn_create');
    }

    /**
     * @see src/Urbem/PrestacaoContasBundle/Resources/config/routing/tce/tce.yml
     * @param $uf
     * @param $group
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function tceAction($uf, $group)
    {
        return $this->parseDetailContent($uf, $group, 'prestacao_contas_relatorio_tce_list', 'TCE ');
    }

    /**
     * @param $uf
     * @param $group
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function parseDetailContent($uf, $group, $routeName, $groupName = null)
    {
        $this->setBreadCrumb(
            [
                'uf' => $uf,
                'group' => $group,
            ]
        );

        $tribunal = TribunaisHelper::getContentJsonReportListByUF(strtoupper($uf));
        $itemsReport = array_key_exists($group, $tribunal) ?  $tribunal[$group] : [];
        $items = $itemsReport['itens'];
        $groupName = sprintf("%s%s - %s", $groupName, strtoupper($uf), $itemsReport['title']);
        $configuracoes = [];

        foreach ($items as $item) {
            $item = [
                'icon' => 'low_priority',
                'title' => $item['label'],
                'hash' => $item['reportHash'],
                'parameters' => isset($item['parameters']) ? $item['parameters'] : null
            ];

            array_push($configuracoes, $item);
        }

        return $this->processRequestDefaultTemplate($groupName, $configuracoes, $group, $uf, $routeName);
    }

    /**
     * @param $title
     * @param $configuracoes
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function processRequestDefaultTemplate($title, $configuracoes, $group, $uf, $routeName)
    {
        return $this->render(
            'PrestacaoContasBundle::Tce/home.html.twig',
            [
                'titlePage' => $title,
                'configuracoes' => $configuracoes,
                'group' => $group,
                'uf' => $uf,
                'route' => $routeName
            ]
        );
    }

    /**
     * Se a url chegar nesse método significa que o projeto
     * Portal da Transparencia não foi configurado corretamente.
     *
     * @return \Symfony\Component\HttpFoundation\Response|static
     */
    public function transparenciaAction()
    {
        $this->container
            ->get('session')
            ->getFlashBag()
            ->add('error', 'Portal da Transparencia nao esta configurado corretamente.');

        return RedirectResponse::create('/');
    }

    public function debugAction(Request $request)
    {
        $registoPrecos = $this->getDoctrine()->getManager()->getRepository(RegistroPrecos::class)->findOneBy(['exercicio' => '2016']);

        $form = $this->createForm(RegistroPrecosType::class, $registoPrecos, [
            'csrf_protection' => false,
            'exercicio' => $this->getExercicio(),
            'usuario' => $this->getUser()
        ]);

        if ('POST' === $request->getMethod()) {
            $form->submit($request->get('registro_precos'));

            if (true === $form->isValid()) {
                $this->getDoctrine()->getManager()->persist($form->getData());
                $this->getDoctrine()->getManager()->flush();
            }
        }

        return $this->render(
            'PrestacaoContasBundle::Debug/debug.html.twig',
            [
                'content' => $this->renderView(
                    'PrestacaoContasBundle::Tribunal/MG/Configuracao/RegistroPrecos/form.html.twig',
                    [
                        'form' => $form->createView(),
                        'exercicio' => $this->getExercicio(),
                        'key' => 1,
                    ]
                )
            ]
        );
    }
}
