<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\CotacaoFornecedorItemDesclassificacaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\CotacaoFornecedorItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\CotacaoItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\CotacaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\FornecedorModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\JulgamentoItemModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class JulgamentoAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao
 */
class JulgamentoLicitacaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_licitacao_julgamento_proposta_cotacao_julgamento';
    protected $customHeader = 'PatrimonialBundle:Compras\JulgamentoProposta:header.html.twig';
    protected $baseRoutePattern = 'patrimonial/licitacao/julgamento-proposta/cotacao/julgamento';

    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoExcluir = false;
    protected $exibirBotaoEditar = false;

    protected function buildHelpInfo()
    {
        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $objectId = $this->getAdminRequestId();
        $julgamento = $this->getSubject();

        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $fornecedorModel = new FornecedorModel($entityManager);
        $cotacaoItemModel = new CotacaoItemModel($entityManager);
        $cotacaoModel = new CotacaoModel($entityManager);
        $catalogoItemModel = new CatalogoItemModel($entityManager);
        $cotacaoFornecedorItemModel = new CotacaoFornecedorItemModel($entityManager);

        $keys = explode('~', $this->getRequest()->get('cotacao'));
        $participanteId = $this->getRequest()->get('participante');

        $cotacaoItemObjectId = [
            'exercicio' => $keys[0],
            'codCotacao' => $keys[1],
            'lote' => $keys[2],
            'codItem' => $keys[3]
        ];

        $cotacaoItem = $cotacaoItemModel->findOne($cotacaoItemObjectId);
        $participante = $fornecedorModel->getFornecedor($participanteId);
        $participante = $fornecedorModel->getTipo($participante);
        $catalogoItem = $catalogoItemModel->getOneByCodItem($cotacaoItem->getCodItem());
        $cotacao = $cotacaoModel->getCotacao($cotacaoItemObjectId['codCotacao'], $cotacaoItemObjectId['exercicio']);

        $cotacaoItem->setFkAlmoxarifadoCatalogoItem($catalogoItem);
        $cotacaoItem->setFkComprasCotacao($cotacao);

        $cotacaoFornecedorItem = $cotacaoFornecedorItemModel->getOne(
            array_merge(['cgmFornecedor' => $participante], $cotacaoItemObjectId)
        );

        $cotacaoFornecedorItem = $catalogoItemModel->montaValorUnitario($cotacaoFornecedorItem);

        $julgamento->cotacaoItem = $cotacaoItem;
        $julgamento->participante = $participante;
        $julgamento->cotacaoFornecedorItem = $cotacaoFornecedorItem;

        if ($julgamento->cotacaoItem->getFkComprasCotacaoFornecedorItens()->count() == 1) {
            $julgamento->classificacao = '1';
        } else {
            $arrCotacaoFornecedorItem = $julgamento->cotacaoItem->getFkComprasCotacaoFornecedorItens()->toArray();

            usort($arrCotacaoFornecedorItem, function ($a, $b) {
                /**
                 * @var Compras\CotacaoFornecedorItem $a
                 * @var Compras\CotacaoFornecedorItem $b
                 */
                if ($a->getVlCotacao() == $b->getVlCotacao()) {
                    return 0;
                }
                return ($a->getVlCotacao() < $b->getVlCotacao()) ? -1 : 1;
            });

            foreach ($arrCotacaoFornecedorItem as $key => $cotacaoFornecedorItem) {
                if (!empty($cotacaoFornecedorItem->vlUnitario)) {
                    $julgamento->classificacao = $key + 1;
                }
            }
        }
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $objectId = $this->getAdminRequestId();
        $uniqId = $this->getRequest()->get('uniqid');

        $this->setBreadCrumb($objectId ? ['id' => $objectId] : []);

        if (is_null($uniqId)) {
            $this->buildHelpInfo();
        }

        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $keys[] = $formData['exercicio'];
            $keys[] = $formData['codCotacao'];
            $keys[] = $formData['lote'];
            $keys[] = $formData['codItem'];

            $participante = $formData['cgmFornecedor'];
        } else {
            $keys = explode('~', $this->getRequest()->get('cotacao'));
            $participante = $this->getRequest()->get('participante');
        }

        if (sprintf("%s_edit", $this->baseRouteName) == $this->getRequest()->get('_sonata_name')) {
            /** @var Compras\Julgamento $julgamento */
            $julgamento = $this->getObject($objectId);
        }

        $cotacaoItemObjectId = [
            'exercicio' => $keys[0],
            'codCotacao' => $keys[1],
            'lote' => $keys[2],
            'codItem' => $keys[3]
        ];

        $formMapperOptions = [];

        $formMapperOptions['data'] = [
            'label' => 'label.julgamentoProposta.data',
            'format' => 'd/M/y',
            'mapped' => false,
            'data' => isset($julgamento) ? $julgamento->getTimestamp() : null
        ];

        $formMapperOptions['hora'] = [
            'label' => 'label.julgamentoProposta.hora',
            'mapped' => false,
            'widget' => 'single_text',
            'data' => isset($julgamento) ? $julgamento->getTimestamp() : null
        ];

        $formMapperOptions['status'] = [
            'attr' => ['class' => 'select2-parameters '],
            'choices' => [
                'Classificado' => '1',
                'Desclassificado' => '2'
            ],
            'label' => 'label.julgamentoProposta.status',
            'mapped' => false
        ];

        $formMapperOptions['observacao'] = [
            'label' => 'label.julgamentoProposta.observacao'
        ];

        $formMapper
            ->with('label.julgamentoProposta.julgamentoPropostasParticipantes')
            ->add('data', 'sonata_type_date_picker', $formMapperOptions['data'])
            ->add('hora', 'time', $formMapperOptions['hora'])
            ->end()
            ->with('label.julgamentoProposta.participante')
            ->add('status', 'choice', $formMapperOptions['status'])
            ->add('observacao', 'textarea', $formMapperOptions['observacao'])

            // Hidden fields
            ->add('exercicio', 'hidden', ['data' => $cotacaoItemObjectId['exercicio']])
            ->add('codCotacao', 'hidden', ['data' => $cotacaoItemObjectId['codCotacao']])
            ->add('cgmFornecedor', 'hidden', ['data' => $participante, 'mapped' => false])
            ->add('lote', 'hidden', ['data' => $cotacaoItemObjectId['lote'], 'mapped' => false])
            ->add('codItem', 'hidden', ['data' => $cotacaoItemObjectId['codItem'], 'mapped' => false])
            ->end();
    }

    /**
     * @param Compras\Julgamento $julgamento
     */
    public function prePersist($julgamento)
    {
        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $cotacaoModel = new CotacaoModel($entityManager);

        $formData = $this->getRequest()->get($this->getUniqid());
        $cotacao = $cotacaoModel->getCotacao($formData['codCotacao'], $formData['exercicio']);

        $stringTime = sprintf('%s %s', $formData['data'], $formData['hora']);
        $date = \DateTime::createFromFormat('d/m/Y H:i', $stringTime);

        $julgamento->setTimestamp(new DateTimeMicrosecondPK($date->format('Y-m-d H:i:s.u')));
        $julgamento->setFkComprasCotacao($cotacao);
        $julgamento->setObservacao($formData['observacao']);
    }

    /**
     * @param Compras\Julgamento $julgamento
     */
    public function preUpdate($julgamento)
    {
        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $cotacaoModel = new CotacaoModel($entityManager);

        $formData = $this->getRequest()->get($this->getUniqid());
        $cotacao = $cotacaoModel->getCotacao($formData['codCotacao'], $formData['exercicio']);
        $julgamento->setFkComprasCotacao($cotacao);
    }
    /**
     * @param Compras\Julgamento $julgamento
     */
    public function postPersist($julgamento)
    {
        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $formData = $this->getRequest()->get($this->getUniqid());

        $cotacaoFornecedorItemDesclassificacaoModel = new CotacaoFornecedorItemDesclassificacaoModel($entityManager);

        if ($formData['status'] == 2) {
            $cotacaoFornecedorItemDesclassificacaoModel->buildCotacaoFornecedorItemDesclassificacao(
                array_merge(['justificativa' => $formData['observacao']], $formData)
            );
        } else {
            $cotacaoFornecedorItemDesclassificacaoModel->removeCotacaoFornecedorItemDesclassificacao(
                $formData['codCotacao'],
                $formData['exercicio'],
                $formData['codItem'],
                $formData['cgmFornecedor'],
                $formData['lote']
            );
        }

        $julgamentoItemModel = new JulgamentoItemModel($entityManager);
        $julgamentoItemModel->removeJulgamentoItem(
            $formData['codCotacao'],
            $formData['exercicio'],
            $formData['codItem'],
            $formData['cgmFornecedor'],
            $formData['lote']
        );

        $julgamentoItem = $julgamentoItemModel->buildOne(
            array_merge(['justificativa' => $formData['observacao']], $formData)
        );

        $this->redirect($formData);
    }

    /**
     * @param Compras\Julgamento $julgamento
     */
    public function postUpdate($julgamento)
    {
        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $formData = $this->getRequest()->get($this->getUniqid());

        $cotacaoFornecedorItemDesclassificacaoModel = new CotacaoFornecedorItemDesclassificacaoModel($entityManager);
        $cotacaoFornecedorItemDesclassificacaoModel->removeCotacaoFornecedorItemDesclassificacao(
            $formData['codCotacao'],
            $formData['exercicio'],
            $formData['codItem'],
            $formData['cgmFornecedor'],
            $formData['lote']
        );

        if ($formData['status'] == 2) {
            $cotacaoFornecedorItemDesclassificacaoModel->buildCotacaoFornecedorItemDesclassificacao(
                array_merge(['justificativa' => $formData['observacao']], $formData)
            );
        }

        $julgamentoItemModel = new JulgamentoItemModel($entityManager);
        $julgamentoItemModel->removeJulgamentoItem(
            $formData['codCotacao'],
            $formData['exercicio'],
            $formData['codItem'],
            $formData['cgmFornecedor'],
            $formData['lote']
        );

        $julgamentoItem = $julgamentoItemModel->buildOne(
            array_merge(['justificativa' => $formData['observacao']], $formData)
        );

        $this->redirect($formData);
    }

    /**
     * @param array $params
     */
    public function redirect(array $params)
    {
        $keys[] = $params['exercicio'];
        $keys[] = $params['codCotacao'];
        $keys[] = $params['lote'];
        $keys[] = $params['codItem'];

        $cotacaoItemId = implode('~', $keys);

        $this->forceRedirect(sprintf("/patrimonial/licitacao/julgamento-proposta/cotacao/%s/show", $cotacaoItemId));
    }
}
