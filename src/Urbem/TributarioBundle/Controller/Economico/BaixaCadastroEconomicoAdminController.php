<?php

namespace Urbem\TributarioBundle\Controller\Economico;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Administracao\Assinatura;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\Economico\BaixaCadastroEconomico;
use Urbem\CoreBundle\Entity\SwUf;
use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;

/**
 * Class BaixaCadastroEconomicoAdminController
 * @package Urbem\TributarioBundle\Controller\Economico
 */
class BaixaCadastroEconomicoAdminController extends CRUDController
{
    const MODULO = 14;
    const CADASTRO_EMPRESA_FATO = 1;
    const CARGO_PREFEITO = 'Prefeito Municipal';

    protected $em;

    /**
     * @return Response
     */
    public function createAction()
    {
        $this->em = $this->getDoctrine()->getEntityManager();

        $baixaCadastroEconomico = $this->em->getRepository(BaixaCadastroEconomico::class)
            ->findOneBy(['inscricaoEconomica' => $this->getRequest()->get('inscricaoEconomica'), 'dtTermino' => null], ['timestamp' => 'desc']);

        if ($baixaCadastroEconomico) {
            return $this->redirect($request->server->get('HTTP_REFERER'));
        }

        return parent::createAction();
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function certidaoAction(Request $request)
    {
        setlocale(LC_ALL, 'pt_BR.utf8');

        $this->em = $this->getDoctrine()->getEntityManager();

        $baixaCadastroEconomico = $this->em->getRepository(BaixaCadastroEconomico::class)
            ->findOneBy(['inscricaoEconomica' => $request->get('id'), 'dtTermino' => null], ['timestamp' => 'desc']);

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml(
                $this->renderView(
                    'TributarioBundle:Economico/BaixaCadastroEconomico:pdf.html.twig',
                    [
                        'object' => $baixaCadastroEconomico,
                        'uf' => $this->getUf(),
                        'secretaria' => $this->getSecretaria(),
                        'processo' => $this->getProcesso($baixaCadastroEconomico),
                        'dataAtual' => strftime('%d de %B de %Y'),
                        'responsavel1' => $this->getResponsavel1(),
                        'responsavel2' => $this->getResponsavel2(),
                        'atividadesEmpresaFato' => $this->getAtributoAtividadesEmpresaFato(),
                    ]
                ),
                [
                    'encoding' => 'utf-8',
                    'enable-javascript' => true,
                    'margin-top'    => 30,
                ]
            ),
            200,
            [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => sprintf(
                    'inline; filename="%s-%d-%s.pdf"',
                    'Certidao-Baixa',
                    $baixaCadastroEconomico->getInscricaoEconomica(),
                    date('d-m-Y')
                )
            ]
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function reativarAction(Request $request)
    {
        $this->em = $this->getDoctrine()->getEntityManager();

        $baixaCadastroEconomico = $this->em->getRepository(BaixaCadastroEconomico::class)
            ->findOneBy(['inscricaoEconomica' => $request->get('inscricaoEconomica'), 'dtTermino' => null], ['timestamp' => 'desc']);

        if (!$baixaCadastroEconomico) {
            return $this->redirect($request->server->get('HTTP_REFERER'));
        }

        $request->attributes->set(
            'id',
            sprintf(
                '%s~%s~%s',
                $baixaCadastroEconomico->getInscricaoEconomica(),
                $baixaCadastroEconomico->getDtInicio(),
                $baixaCadastroEconomico->getTimestamp()
            )
        );

        return $this->editAction();
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function oficioAction(Request $request)
    {
        return $this->createAction();
    }

    /**
    * @return SwUf|null
    */
    protected function getUf()
    {
        $uf = $this->em->getRepository(Configuracao::class)->findOneBy(
            [
                'parametro' => 'cod_uf',
                'exercicio' => $this->get('urbem.session.service')->getExercicio(),
            ]
        );

        if (!$uf) {
            return;
        }

        return $this->em->getRepository(SwUf::class)->find($uf->getValor());
    }

    /**
    * @return Configuracao|null
    */
    protected function getSecretaria()
    {
        return $this->em->getRepository(Configuracao::class)->findOneBy(
            [
                'parametro' => 'secretaria_1',
                'exercicio' => $this->get('urbem.session.service')->getExercicio(),
            ]
        );
    }

    /**
    * @param BaixaCadastroEconomico $baixaCadastroEconomico
    * @return Urbem\CoreBundle\Entity\SwProcesso|null
    */
    protected function getProcesso(BaixaCadastroEconomico $baixaCadastroEconomico)
    {
        if (!$baixaCadastroEconomico->getFkEconomicoProcessoBaixaCadEconomicos()->count()) {
            return;
        }

        return $baixaCadastroEconomico->getFkEconomicoProcessoBaixaCadEconomicos()->first()->getFkSwProcesso();
    }

    /**
    * @return Urbem\CoreBundle\Entity\SwCgmPessoaFisica|null
    */
    protected function getResponsavel1()
    {
        return $this->em->getRepository(Configuracao::class)->findOneBy(
            [
                'parametro' => 'chefe_departamento_1',
                'exercicio' => $this->get('urbem.session.service')->getExercicio(),
            ]
        );
    }

    /**
    * @return Configuracao|null
    */
    protected function getResponsavel2()
    {
        return $this->em->getRepository(Configuracao::class)->findOneBy(
            [
                'parametro' => 'chefe_departamento_2',
                'exercicio' => $this->get('urbem.session.service')->getExercicio(),
            ]
        );
    }

    /**
    * @return array
    */
    protected function getAtributoAtividadesEmpresaFato()
    {
        $atributos = (new AtributoDinamicoModel($this->em))->getAtributosDinamicosPessoal(
            [
                'cod_modulo' => $this::MODULO,
                'cod_cadastro' => $this::CADASTRO_EMPRESA_FATO,
            ]
        );

        $atividades = [];
        if (list($atributo) = $atributos) {
            $atividades = array_combine(explode(',', $atributo->valor_padrao), explode('[][][]', $atributo->valor_padrao_desc));
            asort($atividades);
        }

        return $atividades;
    }
}
