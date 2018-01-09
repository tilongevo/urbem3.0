<?php

namespace Urbem\FinanceiroBundle\Controller\Ppa;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model\Ldo\LdoModel;
use Urbem\CoreBundle\Entity\Ppa\PpaEstimativaOrcamentariaBase;
use Urbem\CoreBundle\Model\Ppa\PpaModel;
use Urbem\CoreBundle\Model\Ppa\PpaPublicacaoModel;

class PpaController extends BaseController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function retornaExerciciosLdoAction(Request $request)
    {
        $codPpa = $request->attributes->get('id');

        $ppa = $this->getDoctrine()
            ->getRepository('CoreBundle:Ppa\Ppa')
            ->findOneByCodPpa($codPpa);

        $indicadoresSemCadastro = [];
        for ($i = (integer) $ppa->getAnoInicio(); $i <= (integer) $ppa->getAnoFinal(); ++$i) {
            $indicadoresSemCadastro[$i] = $i;
        }

        $response = new Response();
        $response->setContent(json_encode($indicadoresSemCadastro));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @throws \Exception
     */
    public function homologarAction(Request $request)
    {
        $container = $this->container;

        $em = $this->getDoctrine()->getManager();
        try {
            $dataForm = $request->request->all();
            $ppa = $em->getRepository('CoreBundle:Ppa\Ppa')->findOneByCodPpa($dataForm['cod_ppa']);
            $norma = $em->getRepository('CoreBundle:Normas\Norma')->findOneByCodNorma($dataForm['homologar_ppa']['numeroNorma']);
            $cgmVeiculo = $em->getRepository(VeiculosPublicidade::class)->findOneBynumcgm($dataForm['homologar_ppa']['nomeVeiculo']);
            $periodicidade = $em->getRepository('CoreBundle:Ppa\Periodicidade')->findOneByCodPeriodicidade($dataForm['homologar_ppa']['periodicidadeMetas']);
            if (is_string($dataForm['homologar_ppa']['dataEncaminhamentoLegislativo'])) {
                $data = explode('/', $dataForm['homologar_ppa']['dataEncaminhamentoLegislativo']);
                $dataForm['homologar_ppa']['dataEncaminhamentoLegislativo'] = new \DateTime($data[2] . '-' . $data[1] . '-' . $data[0]);
            }
            if (is_string($dataForm['homologar_ppa']['dataDevExecutivo'])) {
                $data = explode('/', $dataForm['homologar_ppa']['dataDevExecutivo']);
                $dataForm['homologar_ppa']['dataDevExecutivo'] = new \DateTime($data[2] . '-' . $data[1] . '-' . $data[0]);
            }

            $ppaEncaminhamento = (new \Urbem\CoreBundle\Entity\Ppa\PpaEncaminhamento());
            $ppaEncaminhamento->setTimestamp(new DateTimeMicrosecondPK());
            $ppaEncaminhamento->setCodPpa($dataForm['cod_ppa']);
            $ppaEncaminhamento->setDtEncaminhamento($dataForm['homologar_ppa']['dataEncaminhamentoLegislativo']);
            $ppaEncaminhamento->setDtDevolucao($dataForm['homologar_ppa']['dataDevExecutivo']);
            $ppaEncaminhamento->setNroProtocolo($dataForm['homologar_ppa']['numeroProtocolo']);
            $ppaEncaminhamento->setFkPpaPeriodicidade($periodicidade);

            $ppaPublicacao = (new \Urbem\CoreBundle\Entity\Ppa\PpaPublicacao());
            $ppaPublicacao->setTimestamp(new DateTimeMicrosecondPK());
            $ppaPublicacao->setFkNormasNorma($norma);
            $ppaPublicacao->setFkLicitacaoVeiculosPublicidade($cgmVeiculo);
            $ppaPublicacao->setFkPpaPpa($ppa);
            $ppaPublicacao->setFkPpaPpaEncaminhamento($ppaEncaminhamento);
            $ppaPublicacaoModel = new PpaPublicacaoModel($em);
            $ppaPublicacaoModel->save($ppaPublicacao);

            $ldoModel = new LdoModel($em);
            for ($i = 1; $i <= 4; $i++) {
                $ldo = (new \Urbem\CoreBundle\Entity\Ldo\Ldo());
                $ldo->setAno($i);
                $ldo->setTimestamp(new DateTimeMicrosecondPK());
                $ldo->setFkPpaPpa($ppa);
                $ldoModel->save($ldo);
            }
            $container->get('session')->getFlashBag()->add('success', $container->get('translator')->transChoice('label.ppa.homologacaoMsg.homologacaoSucesso', 0, [], 'messages'));
        } catch (\Exception $e) {
            $em->getConnection()->rollback();
            $container->get('session')->getFlashBag()->add('error', $container->get('translator')->transChoice('label.ppa.homologacaoMsg.homologacaoError', 0, [], 'messages'));
            throw $e;
        }
        $this->redirect("/financeiro/plano-plurianual/ppa/list");
        (new RedirectResponse("/financeiro/plano-plurianual/ppa/list"))->send();
    }

    /**
     * @param Request $request
     */
    public function estimativaAction(Request $request)
    {
        $container = $this->container;

        $em = $this->getDoctrine()->getManager();

        try {
            $dataForm = $request->request->all();
            $ppa = $em->getRepository('CoreBundle:Ppa\Ppa')->findOneByCodPpa($dataForm['cod_ppa']);
            $ppaEstimativaModel = (new \Urbem\CoreBundle\Model\Ppa\PpaEstimativaOrcamentariaBaseModel($em));

            $ppaEstimativaCollection = $em->getRepository('CoreBundle:Ppa\PpaEstimativaOrcamentariaBase')->findBycodPpa($dataForm['cod_ppa']);
            foreach ($ppaEstimativaCollection as $ppaEstimativa) {
                $em->remove($ppaEstimativa);
            }
            $em->flush();
            foreach ($dataForm['ppa_valor'] as $index => $value) {
                $ppaEstimativa = new PpaEstimativaOrcamentariaBase();
                $ppaEstimativa->setFkPpaPpa($ppa);
                $estimativaOrcamentaria = $em->getRepository('CoreBundle:Ppa\EstimativaOrcamentariaBase')->findOneByCodReceita($index);
                $ppaEstimativa->setFkPpaEstimativaOrcamentariaBase($estimativaOrcamentaria);
                $ppaEstimativa->setValor((empty($value) ? 0 : $value));
                $ppaEstimativa->setPercentualAno1((int) $dataForm['ppa_ano1'][$index]);
                $ppaEstimativa->setPercentualAno2((int) $dataForm['ppa_ano2'][$index]);
                $ppaEstimativa->setPercentualAno3((int) $dataForm['ppa_ano3'][$index]);
                $ppaEstimativa->setPercentualAno4((int) $dataForm['ppa_ano4'][$index]);
                $ppaEstimativa->setTipoPercentualInformado($dataForm['estimativa_ppa']['porcentagem']);
                $ppaEstimativaModel->save($ppaEstimativa);
            }
            $container->get('session')->getFlashBag()->add('success', $container->get('translator')->transChoice('label.ppa.estimativaReceitaMsg.estimativaSucesso', 0, [], 'messages'));
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            $container->get('session')->getFlashBag()->add('error', $container->get('translator')->transChoice('label.ppa.estimativaReceitaMsg.estimativaError', 0, [], 'messages'));
            throw $e;
        }

        (new RedirectResponse("/financeiro/plano-plurianual/ppa/list"))->send();
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function consultaPpaAcaoAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $codPpa = $request->query->get('codPpa');
        $numPrograma = $request->query->get('numPrograma');

        $ppaModel = new PpaModel($em);

        $params = [
            'codPpa' => $codPpa,
            'numPrograma' => $numPrograma
        ];

        $acoes = $ppaModel->getAcoesByPpaAndPrograma($params);

        $html = '
            <table>
            <tr class="tr-rh">
                <th class="th-rh">Código</th>
                <th class="th-rh">Tipo</th>
                <th class="th-rh">Ações</th>
                <th class="th-rh">Valor</th>
            </tr>
        ';

        if (count($acoes)) {
            foreach ($acoes as $acao) {
                $codigo = $acao['cod_acao'];
                $tipo = $acao['nom_tipo_acao'];
                $descricao = $acao['descricao'];
                $valor = $acao['valor_acao'];

                $html .= sprintf(
                    '<tr class="tr-rh">
                        <td class="td-rh">%s</td>
                        <td class="td-rh">%s</td>
                        <td class="td-rh">%s</td>
                        <td class="td-rh">%s</td>
                    </tr>',
                    $codigo,
                    $tipo,
                    $descricao,
                    $valor
                );
            }
        } else {
            $html .= '<tr class="tr-rh"><td class="td-rh">Nenhum registro encontrado!</td></tr>';
        }

        $html .= '</table>';

        $html = json_encode($html);

        $response = new Response();
        $response->setContent($html);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
