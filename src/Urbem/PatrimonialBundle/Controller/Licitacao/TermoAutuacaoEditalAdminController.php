<?php

namespace Urbem\PatrimonialBundle\Controller\Licitacao;

use Symfony\Component\HttpFoundation\Request;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\Licitacao\ComissaoMembros;
use Urbem\CoreBundle\Entity\Licitacao\Edital;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Entity\Licitacao\Licitacao;
use Urbem\CoreBundle\Helper\MonthsHelper;

class TermoAutuacaoEditalAdminController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id = null)
    {
        $em = $this->getDoctrine()->getManager();
        $objectId = $this->getRequest()->get('id');

        list($codEdital, $exercicio) = explode('~', $objectId);

        $edital = $em->getRepository(Edital::class)->findOneBy(['numEdital' => $codEdital, 'exercicio' => $exercicio]);

        $numeroEdital = $edital->getNumEdital().'/'.$edital->getExercicio();
        $edital->{"numEditalExercicio"} = $numeroEdital;

        $codLicitacaoExercicio = $edital->getCodLicitacao().'/'.$edital->getExercicioLicitacao();
        $edital->{"codLicitacaoExercicio"} = $codLicitacaoExercicio;

        $edital->{"entidade"} = $edital->getFkLicitacaoLicitacao()->getFkOrcamentoEntidade()->getFkSwCgm()->getNomCgm();
        $edital->{"modalidade"} = $edital->getFkLicitacaoLicitacao()->getFkComprasModalidade()->getDescricao();
        $edital->{"objeto"} = $edital->getFkLicitacaoLicitacao()->getFkComprasObjeto()->getDescricao();

        return new RedirectResponse(
            $this->admin->generateUrl('create', (array) $edital)
        );
    }

    /**
     * @param Request $request
     */
    public function geraTermoAutuacaoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $q = $request->get($request->get('uniqid'));
        $filtroForm = array_merge($q, $request->request->all());

        list($numEdital, $exercicio) = explode('/', $filtroForm['edital']);

        $logradouro = $em->getRepository(Configuracao::class)->findOneBy(['parametro' =>  'logradouro', 'exercicio' => $exercicio]);
        $numero = $em->getRepository(Configuracao::class)->findOneBy(['parametro' =>  'numero', 'exercicio' => $exercicio]);
        $complemento = $em->getRepository(Configuracao::class)->findOneBy(['parametro' =>  'complemento', 'exercicio' => $exercicio]);

        $membroComissao = $em->getRepository(ComissaoMembros::class)->findOneBy(['numcgm' => (int) $filtroForm['assinaturas']]);
        $edital = $em->getRepository(Edital::class)->findOneBy(['numEdital' => $numEdital, 'exercicio' => $exercicio]);
        $despesas = $em->getRepository(Licitacao::class)->getOrcamentoDespesa(
            [
                'codLicitacao' => $edital->getCodLicitacao(),
                'exercicio' => $edital->getExercicio(),
                'codEntidade' => $edital->getCodEntidade(),
                'codModalidade' => $edital->getcodModalidade()
            ]
        );

        $valorOrcado = '';
        if ($despesas) {
            foreach ($despesas as $despesa) {
                $valorOrcado += $despesa['vl_reservado'];
            }
        }

        $dados['nomeEntidade'] = $edital->getFkLicitacaoLicitacao()->getFkOrcamentoEntidade()->getFkSwCgm()->getNomCgm();
        $dados['uf'] = $edital->getFkLicitacaoLicitacao()->getFkOrcamentoEntidade()->getFkSwCgm()->getFkSwMunicipio()->getFkSwUf()->getNomUf();
        $dados['logradouro'] = $logradouro ? $logradouro->getValor() : '';
        $dados['numero'] = $numero ? $numero->getValor() : '';
        $dados['complemento'] = $complemento ? $complemento->getValor() : '';
        $dados['nomeServidor'] = $membroComissao->getFkSwCgm()->getNomCgm();
        $dados['tipoNorma'] = $membroComissao->getFkNormasNorma()->getFkNormasNormaTipoNormas()->last()->getFkNormasTipoNorma()->getNomTipoNorma();
        $dados['norma'] = $membroComissao->getFkNormasNorma()->getNumNorma().'/'.$membroComissao->getFkNormasNorma()->getExercicio();
        $dados['descricaoModalidade'] = $edital->getFkLicitacaoLicitacao()->getFkComprasModalidade()->getDescricao();
        $dados['codLicitacao'] = $edital->getCodLicitacao();
        $dados['exercicioLicitacao'] = $edital->getExercicioLicitacao();
        $dados['descricaoObjeto'] = $edital->getFkLicitacaoLicitacao()->getFkComprasObjeto()->getDescricao();
        $dados['valorOrcado'] = $valorOrcado;
        $dados['dt_abertura_propostas'] = $edital->getDtAberturaPropostas()->format('d/m/Y');
        $dados['hora_abertura_propostas'] = $edital->getHoraAberturaPropostas();
        $dados['numeroDia'] = date('d');
        $dados['nomeMes'] = ucfirst(MonthsHelper::getMonthName(date('m')));
        $dados['anoExtenso'] = date('Y');

        $container = $this->container;
        $tributarioTemplatePath = $container->getParameter('patrimonialbundle');

        $openTBS = $this->get('opentbs');
        $openTBS->ResetVarRef(false);
        $openTBS->VarRef = $dados;
        $openTBS->LoadTemplate($tributarioTemplatePath['templateOdt'] . 'termoAutuacaoEdital.odt', OPENTBS_ALREADY_UTF8);
        $openTBS->MergeBlock('Blk', $despesas);
        $openTBS->Show(OPENTBS_DOWNLOAD, 'termoAutuacaoEdital.odt');
    }
}
