<?php

namespace Urbem\PatrimonialBundle\Controller\Licitacao;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Sonata\AdminBundle\Controller\CRUDController as Controller;

use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Licitacao\Edital;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Entity;
use Symfony\Component\HttpFoundation\RedirectResponse;

class EditalAdminController extends Controller
{
    public function participanteUpdateAction(Request $request)
    {
        $id = $request->attributes->get('id');
        $id = explode("~", $id);
        $em = $this->getDoctrine()->getManager();

        $renuncia = ($id[5] == 1) ? 'false' : 'true';

        try {
            $participante = $this->getDoctrine()
                ->getRepository('CoreBundle:Licitacao\Participante')
                ->findOneBy([
                    'exercicio' => $id[0],
                    'codEntidade' => $id[1],
                    'codLicitacao' => $id[3],
                    'cgmFornecedor' => $id[4]
                ]);

            $participante->setRenunciaRecurso($renuncia);
            $em->persist($participante);
            $em->flush();

            $message = $this->admin->trans('patrimonial.licitacao.edital.participante.success', [], 'flashes');

            $this->container->get('session')
                ->getFlashBag()
                ->add('success', $message);
        } catch (Exception $e) {
            $message = $this->admin->trans('patrimonial.licitacao.edital.participante.error', [], 'flashes');

            $this->container->get('session')
                ->getFlashBag()
                ->add('error', $message);
        }

        (new RedirectResponse($request->headers->get('referer')))->send();
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function geraEditalAction(Request $request)
    {
        $id = $request->get($this->admin->getIdParameter());
        /** @var Edital $edital */
        $edital = $this->admin->getObject($id);

        /** @var EntityManager $entityManager */
        $entityManager = $this->getDoctrine()->getManager();

        $configuracaoModel = new Model\Administracao\ConfiguracaoModel($entityManager);
        $prefeito = $configuracaoModel->getConfiguracao('CGMPrefeito', $configuracaoModel::MODULO_ADMINISTRACAO, true, $this->admin->getExercicio());

        $swCgmModel = new Model\SwCgmModel($entityManager);
        /** @var Entity\SwCgm $swCgm */
        $swCgm = $swCgmModel->findOneByNumcgm($prefeito);

        /** @var Model\Patrimonial\Licitacao\EditalModel $editalModel */
        $editalModel = new Model\Patrimonial\Licitacao\EditalModel($entityManager);
        $itens = $editalModel->recuperaItensEditalComComplemento($edital->getFkLicitacaoLicitacao()->getCodMapa(), $edital->getExercicio());
        $convenio = [];
        $mapaItem = $editalModel->montaRecuperaDotacaoEdital($edital->getFkLicitacaoLicitacao()->getCodMapa(), $edital->getExercicio());
        $documentos = $editalModel->montaRecuperaDocumentosLicitacao(
            $edital->getFkLicitacaoLicitacao()->getCodMapa(),
            $edital->getExercicio(),
            $edital->getFkLicitacaoLicitacao()->getCodEntidade(),
            $edital->getFkLicitacaoLicitacao()->getCodLicitacao()
        );

        $dtEntrega = $edital->getDtEntregaPropostas();
        $dtFim = $edital->getDtValidadeProposta();

        $diasValidade = $dtEntrega->diff($dtFim);

        $container = $this->container;

        $patrimonialTemplatePath = $container->getParameter('patrimonialbundle');

        $dados = [];
        $arPropriedades = ["nom_prefeitura" => "", "cnpj" => "", "fone" => "", "fax" => "", "e_mail" => "", "logradouro" => "",
            "numero" => "", "nom_municipio" => "", "cep" => "", "logotipo" => "", "cod_uf" => "", "CGMPrefeito" => ""];

        foreach ($arPropriedades as $stParametro => $stValor) {
            $stValor = $configuracaoModel->getConfiguracao(
                $stParametro,
                Model\Administracao\ConfiguracaoModel::MODULO_ADMINISTRACAO,
                true,
                $this->admin->getExercicio()
            );
            $dados[$stParametro] = $stValor;
        }
        $dados['modalidade'] = $edital->getFkLicitacaoLicitacao()->getFkComprasModalidade()->getDescricao();
        $dados['uf'] = $edital->getFkLicitacaoLicitacao()->getFkOrcamentoEntidade()->getFkSwCgm()->getFkSwMunicipio()->getFkSwUf()->getNomUf();
        $dados['sigla_uf'] = $edital->getFkLicitacaoLicitacao()->getFkOrcamentoEntidade()->getFkSwCgm()->getFkSwMunicipio()->getFkSwUf()->getSiglaUf();
        $dados['nom_municipio'] = $edital->getFkLicitacaoLicitacao()->getFkOrcamentoEntidade()->getFkSwCgm()->getFkSwMunicipio()->getNomMunicipio();
        $dados['nom_prefeito'] = $swCgm->getNomCgm();
        $dados['responsavel'] = $edital->getFkSwCgm()->getNomCgm();
        $dados['qtdDiasValidade'] = $diasValidade->d;
        $dados['valorLicitacao'] = $edital->getFkLicitacaoLicitacao()->getVlCotado();
        $dados['criterio'] = $edital->getFkLicitacaoLicitacao()->getFkLicitacaoCriterioJulgamento()->getDescricao();
        $dados['licitacao'] = $edital->getFkLicitacaoLicitacao();
        $dados['processo'] = $edital->getFkLicitacaoLicitacao()->getFkSwProcesso();
        $dados['local_ent'] = $edital->getFkLicitacaoLicitacao()->getFkSwProcesso();
        $dados['dt_ent_prop'] = $edital->getDtEntregaPropostas()->format('d/m/Y');
        $dados['hr_ent_prop'] = $edital->getHoraEntregaPropostas();
        $dados['dt_abr_prop'] = $edital->getDtAberturaPropostas()->format('d/m/Y');
        $dados['hr_abr_prop'] = $edital->getHoraAberturaPropostas();
        $dados['local_abr'] = $edital->getLocalAberturaPropostas();
        $dados['validade'] = $edital->getDtValidadeProposta()->format('d/m/Y');
        $dados['objeto'] = $edital->getFkLicitacaoLicitacao()->getFkComprasObjeto()->getDescricao();
        $dados['prefeito'] = $dados['nom_prefeito'];
        $dados['telefone'] = $dados['fone'];
        $dados['exercicio'] = $this->admin->getExercicio();
        $dados['fpagto'] = $edital->getCondicoesPagamento();

        $openTBS = $this->get('opentbs');
        $openTBS->ResetVarRef(false);
        $openTBS->VarRef = $dados;
        // load your template
        $openTBS->LoadTemplate($patrimonialTemplatePath['templateOdt'] . 'Edital.odt', OPENTBS_ALREADY_UTF8);

        $openTBS->MergeBlock('Bki', $itens);
        $openTBS->MergeBlock('Bco', $convenio);
        $openTBS->MergeBlock('Bdo', $mapaItem);
        $openTBS->MergeBlock('Bdc', $documentos);

        // send the file
        $openTBS->Show(OPENTBS_DOWNLOAD, 'Edital.odt');
    }
}
