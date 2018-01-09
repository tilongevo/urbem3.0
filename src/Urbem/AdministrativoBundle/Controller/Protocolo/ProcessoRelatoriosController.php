<?php

namespace Urbem\AdministrativoBundle\Controller\Protocolo;

use Doctrine\Common\Collections\ArrayCollection;

use Sonata\DoctrineORMAdminBundle\Model\ModelManager;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Urbem\CoreBundle\Entity\Administracao\Gestao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Relatorio;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Entity\SwSituacaoProcesso;
use Urbem\CoreBundle\Helper\DateTimePK;
use Urbem\CoreBundle\Helper\StringHelper;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class ProcessoRelatoriosController
 *
 * @package Urbem\AdministrativoBundle\Controller\Protocolo
 */
class ProcessoRelatoriosController extends AbstractProcessoController
{
    const LAYOUT_REPORT_PATH = '/bundles/report/gestaoAdministrativa/fontes/RPT/protocolo/report/design';

    /** @var AbstractSonataAdmin */
    protected $admin;

    /**
     * Configura os pametros 'default' que todos os relatórios de Processo devem conter.
     *
     * @param Relatorio $relatorio
     *
     * @return array
     */
    private function configureDefaultReportParams(Relatorio $relatorio)
    {
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        /** @var ModelManager $modelManager */
        $modelManager = $this->admin->getModelManager();
        $entityManager = $modelManager->getEntityManager(SwProcesso::class);

        $configuracaoModel = new ConfiguracaoModel($entityManager);

        $codModuloAdmin = Modulo::MODULO_ADMINISTRATIVO;
        $exercicio = $this->admin->getExercicio();

        $nomPrefeitura = $configuracaoModel
            ->getConfiguracaoOuAnterior('nom_prefeitura', $codModuloAdmin, $exercicio);

        $codUf = $configuracaoModel
            ->getConfiguracaoOuAnterior('cod_uf', $codModuloAdmin, $exercicio);

        $codMunicipio = $configuracaoModel
            ->getConfiguracaoOuAnterior('cod_municipio', $codModuloAdmin, $exercicio);

        $centroCusto = $configuracaoModel
            ->getConfiguracaoOuAnterior('centro_custo', $relatorio->getCodModulo(), $exercicio);

        return [
            'inCodGestao'        => $relatorio->getCodGestao(),
            'inCodModulo'        => $relatorio->getCodModulo(),
            'inCodRelatorio'     => $relatorio->getCodRelatorio(),
            'pDataHoje'          => (new \DateTime())->format($this->trans('dateFormat.extenso')),
            'pExercicioSessao'   => $exercicio,
            'pCodMunicipio'      => $codMunicipio,
            'pCodUf'             => $codUf,
            'pEntidadePrincipal' => $nomPrefeitura,
            'centroCusto'        => $centroCusto,
        ];
    }

    /**
     * @return Response
     */
    public function salvarAction()
    {
        /** @var ModelManager $modelManager */
        $modelManager = $this->admin->getModelManager();

        /** @var Relatorio $relatorio */
        $relatorio = $modelManager->findOneBy(Relatorio::class, [
            'codGestao'    => Gestao::GESTAO_ADMINISTRATIVA,
            'codModulo'    => Modulo::MODULO_PROCESSO,
            'codRelatorio' => SwProcesso::RELATORIO_RECIBO_PROCESSO
        ]);

        $this->admin->setLabel($relatorio->getNomRelatorio());

        $form = $this->getForm();
        if ($form->isSubmitted()) {
            /** @var ArrayCollection $assinaturas */
            $assinaturas = $form->get('formType')->get('assinaturas')->getData();

            $swProcesso = $this->getSwProcesso();

            $params = array_merge($this->configureDefaultReportParams($relatorio), [
                'pCodProcesso'         => $swProcesso->getCodProcesso(),
                'pAnoExercicio'        => $swProcesso->getAnoExercicio(),
                'numero_assinatura'    => $assinaturas->count(),
                'entidade_assinatura'  => StringHelper::arrayCollectionToString($assinaturas, ',', 'codEntidade'),
                'timestamp_assinatura' => StringHelper::arrayCollectionToString($assinaturas, ',', 'timestamp'),
                'numcgm_assinatura'    => StringHelper::arrayCollectionToString($assinaturas, ',', 'numcgm'),
            ]);
            
            $layoutReportPath = self::LAYOUT_REPORT_PATH . DIRECTORY_SEPARATOR . $relatorio->getArquivo();

            $content = $this->admin
                ->getReportService()
                ->setLayoutDefaultReport($layoutReportPath)
                ->getReportContent($params);

            $this->admin->parseContentToPdf($content->getBody()->getContents(), $relatorio->getNomRelatorio());
        }

        return $this->editAction();
    }

    /**
     * Código base para impressão de relatórios de arquivamento, que são semelhantes.
     *
     * @param Relatorio $relatorio
     */
    private function reportArquivamentoBase(Relatorio $relatorio)
    {
        $swProcesso = $this->getSwProcesso();

        $params = array_merge($this->configureDefaultReportParams($relatorio), [
            'pCodProcesso'  => $swProcesso->getCodProcesso(),
            'pAnoExercicio' => $swProcesso->getAnoExercicio(),
            'pMsgEnvio'     => $swProcesso->getFkSwProcessoArquivado()->getTextoComplementar(),
        ]);

        if ($relatorio->getCodRelatorio() == SwProcesso::RELATORIO_ARQUIVAMENTO_PROCESSO_DEFINITIVO) {
            $params['pHistoricoArquivamento'] = $swProcesso->getFkSwProcessoArquivado()->getCodHistorico();
        }

        $layoutReportPath = self::LAYOUT_REPORT_PATH . DIRECTORY_SEPARATOR . $relatorio->getArquivo();

        $content = $this->admin
            ->getReportService()
            ->setLayoutDefaultReport($layoutReportPath)
            ->setReportNameFile($relatorio->getNomRelatorio())
            ->getReportContent($params);

        $this->admin->parseContentToPdf($content->getBody()->getContents(), $relatorio->getNomRelatorio());
    }

    /**
     * Ação de Imprimir o Relatório de Arquivamento Temporario de um Processo
     */
    public function arquivamentoTemporarioAction()
    {
        /** @var ModelManager $modelManager */
        $modelManager = $this->admin->getModelManager();

        /** @var Relatorio $relatorio */
        $relatorio = $modelManager->findOneBy(Relatorio::class, [
            'codGestao'   => Gestao::GESTAO_ADMINISTRATIVA,
            'codModulo'   => Modulo::MODULO_PROCESSO,
            'codRelatorio'=> SwProcesso::RELATORIO_ARQUIVAMENTO_PROCESSO_TEMPORARIO
        ]);

        $this->reportArquivamentoBase($relatorio);
    }

    /**
     * Ação de Imprimir o Relatório de Arquivamento Definitivo de um Processo
     */
    public function arquivamentoDefinitivoAction()
    {
        /** @var ModelManager $modelManager */
        $modelManager = $this->admin->getModelManager();

        /** @var Relatorio $relatorio */
        $relatorio = $modelManager->findOneBy(Relatorio::class, [
            'codGestao'   => Gestao::GESTAO_ADMINISTRATIVA,
            'codModulo'   => Modulo::MODULO_PROCESSO,
            'codRelatorio'=> SwProcesso::RELATORIO_ARQUIVAMENTO_PROCESSO_DEFINITIVO
        ]);

        $this->reportArquivamentoBase($relatorio);
    }

    /**
     * Ação de Imprimir o Relatório de Despacho de um Processo
     */
    public function despachoAction()
    {
        /** @var ModelManager $modelManager */
        $modelManager = $this->admin->getModelManager();

        /** @var Relatorio $relatorio */
        $relatorio = $modelManager->findOneBy(Relatorio::class, [
            'codGestao'   => Gestao::GESTAO_ADMINISTRATIVA,
            'codModulo'   => Modulo::MODULO_PROCESSO,
            'codRelatorio'=> SwProcesso::RELATORIO_DESPACHO
        ]);

        $swProcesso = $this->getSwProcesso();

        $usuario = $this->admin->getCurrentUser();

        $params = array_merge($this->configureDefaultReportParams($relatorio), [
            'pCodProcesso'  => $swProcesso->getCodProcesso(),
            'pAnoE'         => $swProcesso->getAnoExercicio(),
            'pCodAndamento' => $swProcesso->getFkSwUltimoAndamento()->getCodAndamento(),
            'pNumCgm'       => $usuario->getNumcgm()
        ]);

        $layoutReportPath = self::LAYOUT_REPORT_PATH . DIRECTORY_SEPARATOR . $relatorio->getArquivo();

        $content = $this->admin
            ->getReportService()
            ->setLayoutDefaultReport($layoutReportPath)
            ->setReportNameFile($relatorio->getNomRelatorio())
            ->getReportContent($params);

        $this->admin->parseContentToPdf($content->getBody()->getContents(), $relatorio->getNomRelatorio());
    }

    /**
     * Ação de Imprimir os Despachos de um Processo.
     * Obs.: Comportamento diferente de despachoAction()
     */
    public function despachosAction()
    {
        /** @var ModelManager $modelManager */
        $modelManager = $this->admin->getModelManager();

        /** @var Relatorio $relatorio */
        $relatorio = $modelManager->findOneBy(Relatorio::class, [
            'codGestao'   => Gestao::GESTAO_ADMINISTRATIVA,
            'codModulo'   => Modulo::MODULO_PROCESSO,
            'codRelatorio'=> SwProcesso::RELATORIO_DESPACHOS
        ]);

        $swProcesso = $this->getSwProcesso();

        $params = array_merge($this->configureDefaultReportParams($relatorio), [
            'pNumMatricula'        => '',
            'pNumInscricao'        => '',
            'pCodProcesso'         => $swProcesso->getCodProcesso(),
            'pAnoExercicio'        => $swProcesso->getAnoExercicio(),
            'numero_assinatura'    => 0,
            'entidade_assinatura'  => '',
            'timestamp_assinatura' => '',
            'numcgm_assinatura'    => '',
        ]);

        $swProcessoMatricula = $swProcesso->getFkSwProcessoMatricula();
        if (!is_null($swProcessoMatricula)) {
            $params['pNumMatricula'] = $swProcessoMatricula->getNumMatricula();
        }

        $swProcessoInscricao = $swProcesso->getFkSwProcessoInscricao();
        if (!is_null($swProcessoInscricao)) {
            $params['pNumInscricao'] = $swProcessoInscricao->getNumInscricao();
        }

        $layoutReportPath = self::LAYOUT_REPORT_PATH . DIRECTORY_SEPARATOR . $relatorio->getArquivo();

        $content = $this->admin
            ->getReportService()
            ->setLayoutDefaultReport($layoutReportPath)
            ->setReportNameFile($relatorio->getNomRelatorio())
            ->getReportContent($params);

        $this->admin->parseContentToPdf($content->getBody()->getContents(), $relatorio->getNomRelatorio());
    }

    /**
     * @param SwProcesso|null $swProcesso
     * @param Form|null       $form
     *
     * @throws \Exception
     */
    private function reportEtiquetaBase(SwProcesso $swProcesso = null, Form $form = null)
    {
        /** @var ModelManager $modelManager */
        $modelManager = $this->admin->getModelManager();

        /** @var Relatorio $relatorio */
        $relatorio = $modelManager->findOneBy(Relatorio::class, [
            'codGestao'   => Gestao::GESTAO_ADMINISTRATIVA,
            'codModulo'   => Modulo::MODULO_PROCESSO,
            'codRelatorio'=> SwProcesso::RELATORIO_ETIQUETA
        ]);

        $params = [
            'prmProcesso' => '',
            'prmAnoExercicio' => '',
            'prmProcessoInicial' => '',
            'prmExeInicial' => '',
            'prmProcessoFinal' => '',
            'prmExeFinal' => '',
            'prmProcessoIni' => '',
            'prmExercicioInicial' => '',
            'prmProcessoFim' => '',
            'prmExercicioFinal' => '',
            'prmResumo' => '',
            'prmCodClassificacao' => '',
            'prmCodAssunto' => '',
            'prmCodOrgao' => '',
            'prmCodUnidade' => '',
            'prmCodDepartamento' => '',
            'prmCodSetor' => '',
            'prmAnoExercicioSetor' => '',
            'prmNumCgm' => '',
            'prmDtIni' => '',
            'prmDtFim' => '',
            'prmDtInicial' => '',
            'prmDtFinal' => '',
            'prmDataIni' => '',
            'prmDataFim' => '',
            'centroCusto' => '',
            'numero_assinatura' => 0,
            'entidade_assinatura' => '',
            'timestamp_assinatura' => '',
            'numcgm_assinatura' => '',
        ];

        if (!is_null($form)) {
            $formData = $form->get('formType')->getData();

            if (!empty($formData['processoInicial'])) {
                $processoInical = explode('/', $formData['processoInicial']);
                $params['prmProcessoIni'] = $processoInical[0];
                $params['prmExercicioInicial'] = $processoInical[1];
            }

            if (!empty($formData['processoFinal'])) {
                $processoFinal = explode('/', $formData['processoFinal']);
                $params['prmProcessoFim'] = $processoFinal[0];
                $params['prmExercicioFinal'] = $processoFinal[1];
            }

            $params['prmNumCgm'] = empty($formData['interessado']) ? "" : $formData['interessado'];
            $params['prmDtIni'] = empty($formData['dataInicial']) ? "" : $formData['dataInicial']->format(DateTimePK::FORMAT);
            $params['prmDtFim'] = empty($formData['dataFinal']) ? "" : $formData['dataFinal']->format(DateTimePK::FORMAT);
        } elseif (!is_null($swProcesso)) {
            $params['prmProcesso'] = $swProcesso->getCodProcesso();
            $params['prmAnoExercicio'] = $swProcesso->getAnoExercicio();
        }

        $layoutReportPath = self::LAYOUT_REPORT_PATH . DIRECTORY_SEPARATOR . $relatorio->getArquivo();

        $content = $this->admin
            ->getReportService()
            ->setLayoutDefaultReport($layoutReportPath)
            ->setReportNameFile($relatorio->getNomRelatorio())
            ->getReportContent($params);

        $this->admin->parseContentToPdf($content->getBody()->getContents(), $relatorio->getNomRelatorio());
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function etiquetaAction()
    {
        $swProcesso = $this->getSwProcesso();

        try {
            $this->reportEtiquetaBase($swProcesso);
        } catch (\Exception $exception) {
            $this->addFlashMessage($exception->getMessage(), [], 'flashes', 'error');
        }

        return $this->redirectToSwProcessoShowPage();
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function etiquetasAction()
    {
        /** @var ModelManager $modelManager */
        $modelManager = $this->admin->getModelManager();

        /** @var Relatorio $relatorio */
        $relatorio = $modelManager->findOneBy(Relatorio::class, [
            'codGestao'   => Gestao::GESTAO_ADMINISTRATIVA,
            'codModulo'   => Modulo::MODULO_PROCESSO,
            'codRelatorio'=> SwProcesso::RELATORIO_ETIQUETA
        ]);

        $this->admin->setLabel($relatorio->getNomRelatorio());

        $form = $this->getForm();
        if ($form->isSubmitted()) {
            $this->reportEtiquetaBase(null, $form);
        }

        return $this->createAction();
    }
}
