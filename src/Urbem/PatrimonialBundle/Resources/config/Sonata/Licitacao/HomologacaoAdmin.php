<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\Entity\Administracao\ModeloDocumento;
use Urbem\CoreBundle\Entity\Licitacao\Adjudicacao;
use Urbem\CoreBundle\Entity\Licitacao\Homologacao;
use Urbem\CoreBundle\Entity\Licitacao\Licitacao;
use Urbem\CoreBundle\Entity\Orcamento;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\HomologacaoAnuladaModel;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\HomologacaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\JustificativaRazaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\LicitacaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Compras;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class HomologacaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_licitacao_homologacao';
    protected $baseRoutePattern = 'patrimonial/licitacao/homologacao';

    protected $exibirBotaoExcluir = false;
    protected $exibirBotaoIncluir = false;

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('delete');
        $collection->remove('edit');
        $collection->remove('list');
    }

    protected $includeJs = [
        '/patrimonial/javascripts/licitacao/homologacao.js',
    ];

    /**
     * @param Homologacao $object
     */
    public function prePersist($object)
    {
        $formData = $this->getRequest()->request->get($this->getUniqid());
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $licitacaoModel = new LicitacaoModel($entityManager);
        $homologacaoModel = new HomologacaoModel($entityManager);
        $homologacaoAnuladaModel = new HomologacaoAnuladaModel($entityManager);
        $justificativaModel = new JustificativaRazaoModel($entityManager);

        /* Conform linha 149 do arquivo /licitacao/instancias/homologacao/PRManterHomologacao.php */
        $documento = $entityManager
            ->getRepository(ModeloDocumento::class)
            ->findOneBy([
                'codDocumento' => 0
            ]);
        $licitacao = $licitacaoModel->getOneLicitacao(
            $formData['codHLicitacao'],
            $formData['codHModalidade'],
            $formData['codHEntidade'],
            $formData['exercicio']
        );
        /* Salva Justificativa Razao */
        $justificativaModel->saveJustificativaRazao($licitacao, $object, $formData);

        $itens = $homologacaoModel->montaRecuperaItensComStatus(
            $formData['codHLicitacao'],
            $formData['codHModalidade'],
            $formData['codHEntidade'],
            $formData['exercicio']
        );

        $formDataHora = "{$formData['dataHomologacao']} {$formData["horaHomologacao"]}";
        $datetime = \DateTime::createFromFormat('d/m/Y H:i', $formDataHora);

        foreach ($itens as $item) {
            $adjudicacao = $entityManager
                ->getRepository(Adjudicacao::class)
                ->findOneBy([
                    'numAdjudicacao' => $item->num_adjudicacao,
                    'codCotacao' => $item->cod_cotacao,
                    'codLicitacao' => $licitacao->getCodLicitacao(),
                    'codEntidade' => $licitacao->getCodEntidade(),
                    'codModalidade' => $licitacao->getCodModalidade(),
                    'exercicioLicitacao' => $licitacao->getExercicio()
                ]);

            if (($item->status == 'Anulado') || ($item->status == 'Revogado')) {
                $homologacao = $entityManager
                    ->getRepository(Adjudicacao::class)
                    ->findOneBy([
                        'numAdjudicacao' => $item->num_adjudicacao,
                        'codCotacao' => $item->cod_cotacao,
                        'codLicitacao' => $licitacao->getCodLicitacao(),
                        'codEntidade' => $licitacao->getCodEntidade(),
                        'codModalidade' => $licitacao->getCodModalidade(),
                        'exercicioLicitacao' => $licitacao->getExercicio()
                    ]);
                $homologacaoAnuladaModel->saveHomologacaoAnulada($homologacao, $item);
            } else {
                $homologacaoModel->saveHomologacao($adjudicacao, $datetime, $documento);
            }
        }

        $message = $this->trans('patrimonial.licitacao.homologacao.success', [], 'flashes');
        $this->redirect($licitacao, $message, 'success');
    }

    public function redirect($licitacao, $message, $type = 'success')
    {
        $message = $this->trans($message);
        $container = $this->getConfigurationPool()->getContainer();

        $container->get('session')->getFlashBag()->add($type, $message);

        $this->forceRedirect("/patrimonial/licitacao/licitacao/perfil?id=" . $this->getObjectKey($licitacao));
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('numAdjudicacao')
            ->add('codItem')
            ->add('lote')
            ->add('exercicioCotacao')
            ->add('cgmFornecedor')
            ->add('timestamp')
            ->add('adjudicado');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('numAdjudicacao')
            ->add('codItem')
            ->add('lote')
            ->add('exercicioCotacao')
            ->add('cgmFornecedor')
            ->add('timestamp')
            ->add('adjudicado')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $licitacaoModel = new LicitacaoModel($entityManager);

        $ids = explode('~', $this->getAdminRequestId());

        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $id = $formData['codHLicitacao'];
            $codHModalidade = $formData['codHModalidade'];
            $codHEntidade = $formData['codHEntidade'];
            $exercicio = $formData['exercicio'];
        } else {
            $id = $ids[0];
            $codHModalidade = $ids[1];
            $codHEntidade = $ids[2];
            $exercicio = $ids[3];
        }

        /** @var Licitacao $licitacao */
        $licitacao = $entityManager
            ->getRepository(Licitacao::class)
            ->findOneBy([
                'codLicitacao' => $id,
                'codModalidade' => $codHModalidade,
                'codEntidade' => $codHEntidade,
                'exercicio' => $exercicio
            ]);

        if (null === $licitacao) {
            $container = $this->getConfigurationPool()->getContainer();
            $message = $container->get('translator')->trans('LicitacaoNaoEncontrada');
            $container->get('session')->getFlashBag()->add('error', $message);

            $this->forceRedirect(
                $container->get('router')
                    ->generate('urbem_patrimonial_licitacao_licitacao_list')
            );
        }

        $licitacaoSuspenso = $licitacaoModel->montaRecuperaEditalSuspender($ids[0]);

        if ($licitacaoSuspenso[0]->situacao == 'Suspenso') {
            $container = $this->getConfigurationPool()->getContainer();
            $message = $this->trans('EditalSuspenso', [
                '%num_edital%' => $licitacaoSuspenso[0]->num_edital,
                '%exercicio%' => $licitacaoSuspenso[0]->exercicio,
            ], 'messages');
            $container->get('session')->getFlashBag()->add('error', $container->get('translator')->trans($message));

            $this->forceRedirect(
                $container->get('router')
                    ->generate('urbem_patrimonial_licitacao_licitacao_list')
            );
        }

        $fieldOptions = [];
        $fieldOptions['codModalidade'] = [
            'mapped' => false,
            'data' => $licitacao->getFkComprasModalidade(),
            'attr' => [
                'readonly' => 'readonly'
            ]
        ];
        $fieldOptions['codEntidade'] = [
            'mapped' => false,
            'data' => $licitacao->getFkOrcamentoEntidade(),
            'attr' => [
                'readonly' => 'readonly'
            ]
        ];
        $fieldOptions['processo'] = [
            'mapped' => false,
            'data' => $licitacao->getFkSwProcesso(),
            'attr' => [
                'readonly' => 'readonly'
            ]
        ];
        $fieldOptions['objeto'] = [
            'mapped' => false,
            'data' => $licitacao->getFkComprasObjeto(),
            'attr' => [
                'readonly' => 'readonly'
            ]
        ];
        $fieldOptions['dataHomologacao'] = [
            'mapped' => false,
            'dp_max_date' => date('d/m/Y'),
            'format' => 'dd/MM/yyyy',
            'label' => 'label.patrimonial.licitacao.homologacao.dataHomologacao'
        ];

        $fieldOptions['horaHomologacao'] = [
            'mapped' => false,
            'widget' => 'single_text',
            'label' => 'label.patrimonial.licitacao.homologacao.horaHomologacao'
        ];

        $fieldOptions['justificativa'] = [
            'label' => 'label.patrimonial.licitacao.justificativaRazao.justificativa',
            'mapped' => false,
            'required' => true,
        ];

        $fieldOptions['razao'] = [
            'label' => 'label.patrimonial.licitacao.justificativaRazao.razao',
            'mapped' => false,
            'required' => true,
        ];

        $fieldOptions['fundamentacaoLegal'] = [
            'label' => 'label.patrimonial.licitacao.justificativaRazao.fundamentacaoLegal',
            'mapped' => false,
            'required' => true,
        ];

        $formMapper
            ->with('Dados da Homologação')
            ->add('codHLicitacao', 'hidden', ['data' => $id, 'mapped' => false])
            ->add('codHModalidade', 'hidden', ['data' => $codHModalidade, 'mapped' => false])
            ->add('codHEntidade', 'hidden', ['data' => $codHEntidade, 'mapped' => false])
            ->add('exercicio', 'hidden', ['data' => $exercicio, 'mapped' => false])
            ->add('modalidade', 'text', $fieldOptions['codModalidade'])
            ->add('entidade', 'text', $fieldOptions['codEntidade'])
            ->add('processo', 'text', $fieldOptions['processo'])
            ->add('objeto', 'text', $fieldOptions['objeto'])
            ->add('dataHomologacao', 'sonata_type_date_picker', $fieldOptions['dataHomologacao'])
            ->add('horaHomologacao', 'time', $fieldOptions['horaHomologacao'])
            ->add('justificativa', 'textarea', $fieldOptions['justificativa'])
            ->add('razao', 'textarea', $fieldOptions['razao'])
            ->add('fundamentacaoLegal', 'textarea', $fieldOptions['fundamentacaoLegal'])
            ->end()
            ->with('label.itens.item', [
                'class' => 'col s12 homologacao-items'
            ])
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('numAdjudicacao')
            ->add('codItem')
            ->add('lote')
            ->add('exercicioCotacao')
            ->add('cgmFornecedor')
            ->add('timestamp')
            ->add('adjudicado');
    }
}
