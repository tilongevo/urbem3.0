<?php

namespace Urbem\AdministrativoBundle\Controller\Administracao;

use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Model\Administracao\FuncaoModel;
use Urbem\CoreBundle\Model\Administracao\AtributoFuncaoModel;
use Urbem\CoreBundle\Entity\Administracao\Funcao;
use Urbem\CoreBundle\Entity\Administracao\FuncaoExterna;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class FuncaoController extends BaseController
{

    public function duplicarAction(Request $request)
    {
        $container = $this->container;

        $em = $this->getDoctrine()->getManager();

        try {
            $usuario = $container->get('security.token_storage')->getToken()->getUser()->getId();
            $usuario = $em->getRepository('CoreBundle:SwCgm')->find($usuario);

            $dataForm = $request->request->all();

            $funcaoAntiga = $em->getRepository('CoreBundle:Administracao\Funcao')->findOneBycodFuncao($dataForm['cod_funcao']);
            $funcaoExternaAntiga = $em->getRepository('CoreBundle:Administracao\FuncaoExterna')->findOneByCodFuncao($dataForm['cod_funcao']);

            $objBiblioteca = $em->getRepository('CoreBundle:Administracao\Biblioteca')->findOneBy([
                'codBiblioteca' => $dataForm['duplicar_funcao']['codBiblioteca']
            ]);

            $funcaoNova = (new \Urbem\CoreBundle\Entity\Administracao\Funcao());
            $funcaoNova->setCodModulo($funcaoAntiga->getCodModulo());
            $funcaoNova->setFkAdministracaoBiblioteca($objBiblioteca);
            $funcaoNova->setCodFuncao($funcaoAntiga->getCodFuncao());
            $funcaoNova->setNomFuncao($dataForm['duplicar_funcao']['nomFuncaoNova']);
            $funcaoNova->setCodTipoRetorno($funcaoAntiga->getCodTipoRetorno());


            $modulo = $funcaoNova->getFkAdministracaoBiblioteca()->getFkAdministracaoModulo();

            $biblioteca = $funcaoNova->getFkAdministracaoBiblioteca();

            $comentario = $dataForm['duplicar_funcao']['comentario'];
            if ($comentario == null) {
                $comentario = '';
            }
            $corpoPl = ($funcaoExternaAntiga ? $funcaoExternaAntiga->getCorpoPl() : '');

            $funcaoExterna = (new \Urbem\CoreBundle\Entity\Administracao\FuncaoExterna());
            $funcaoExterna->setCodModulo($modulo->getCodModulo());
            $funcaoExterna->setCodBiblioteca($dataForm['duplicar_funcao']['codBiblioteca']);
            $funcaoExterna->setCodFuncao($funcaoAntiga->getCodFuncao());
            $funcaoExterna->setComentario($comentario);
            $funcaoExterna->setCorpoPl($corpoPl);
            $funcaoNova->addFkAdministracaoFuncaoExternas($funcaoExterna);

            $funcaoModel = new FuncaoModel($em);
            if ($corpoPl) {
                $executarPl = 'CREATE OR REPLACE ';
                $executarPl .= str_replace('\\', '', $corpoPl);

                $executaFuncaoPL = $funcaoModel->executaFuncaoPL($executarPl);
                if (!$executaFuncaoPL) {
                    $container = $this->getConfigurationPool()->getContainer();
                    $container->get('session')->getFlashBag()->add('error', 'Não foi possível criar a função!');
                    $this->forceRedirect('/administrativo/administracao/gerador-calculo/funcao/create');
                }
            }

            $funcaoModel->save($funcaoNova);

            $atributoFuncaoModel = (new \Urbem\CoreBundle\Model\Administracao\AtributoFuncaoModel($em));

            $atributosCollection = $em->getRepository('CoreBundle:Administracao\AtributoFuncao')->findBycodFuncao($funcaoAntiga->getCodFuncao());
            foreach ($atributosCollection as $atributo) {
                $atributoFuncao = (new \Urbem\CoreBundle\Entity\Administracao\AtributoFuncao($em));
                $atributoFuncao->setCodModulo($funcaoNova->getCodModulo()->getCodModulo());
                $atributoFuncao->setCodBiblioteca($funcaoNova->getCodBiblioteca()->getCodBiblioteca());
                $atributoFuncao->setCodFuncao($funcaoNova->getCodFuncao());
                $atributoFuncao->setCodCadastro($atributo->getCodCadastro());
                $atributoFuncao->setCodAtributo($atributo->getCodAtributo());

                $atributoFuncaoModel->save($atributoFuncao);
            }

            $container->get('session')->getFlashBag()->add('success', 'Funcao duplicada com sucesso.');
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            $container->get('session')->getFlashBag()->add('error', 'Erro ao duplicar função.');

            throw $e;
        }

        (new RedirectResponse("/administrativo/administracao/gerador-calculo/funcao/list"))->send();
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function carregaFuncaoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository(Funcao::class)->createQueryBuilder('funcao');

        $this->filterQueryString($qb, $request);

        $results = [];
        foreach ((array) $qb->getQuery()->getResult() as $norma) {
            $results[] = [
                'id' => sprintf('%d~%d~%d', $norma->getCodModulo(), $norma->getCodBiblioteca(), $norma->getCodFuncao()),
                'label' => (string) $norma,
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
        $nomFuncao = $request->get('q');
        $qb->where(sprintf('LOWER(%s.nomFuncao) LIKE :nomFuncao', $qb->getRootAlias()));
        if ($nomFuncao) {
            $qb->setParameter('nomFuncao', sprintf('%%%s%%', strtolower($nomFuncao)));
        }

        if (!$nomFuncao) {
            $qb->setParameter('nomFuncao', null);
        }
    }
}
