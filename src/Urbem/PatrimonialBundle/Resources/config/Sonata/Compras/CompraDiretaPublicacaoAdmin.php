<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Compras;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use Urbem\CoreBundle\Entity\Compras\PublicacaoCompraDireta;
use Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade;
use Urbem\CoreBundle\Model\Patrimonial\Compras\PublicacaoCompraDiretaModel;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\VeiculosPublicidadeModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

use Urbem\CoreBundle\Entity\Compras;

class CompraDiretaPublicacaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_compras_compra_direta_publicacoes_manter_publicacao';
    protected $baseRoutePattern = 'patrimonial/compras/compra-direta/publicacoes/manter-publicacao';

    protected function configureRoutes(RouteCollection $routeCollection)
    {
        $routeCollection->remove('list');
        $routeCollection->remove('batch');
        $routeCollection->remove('show');
        $routeCollection->remove('export');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $route = $this->getRequest()->get('_sonata_name');

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /** @var EntityManager $entityManager */
        $entityManager = $this
            ->modelManager
            ->getEntityManager($this->getClass());

        $codCompraDireta = $this->getRequest()->get('cod_compra_direta');
        $compraDireta = '';
        /** @var Compras\PublicacaoCompraDireta $publicacaoCompraDireta */
        $publicacaoCompraDireta = $this->getSubject();
        if ($this->baseRouteName . "_create" == $route) {
            $codCompraDireta = $this->getRequest()->get('cod_compra_direta');

            if (!$this->getRequest()->isMethod('GET')) {
                $formData = $this->getRequest()->request->get($this->getUniqid());
                $codCompraDireta = $formData['codCompraDireta'];
                $codEntidade = $formData['codEntidade'];
                $codModalidade = $formData['codModalidade'];
                $exercicioEntidade = $formData['exercicioEntidade'];
            } else {
                list($codCompraDireta, $codEntidade, $exercicioEntidade, $codModalidade) = explode('~', $codCompraDireta);

                $compraDireta = $entityManager
                    ->getRepository(Compras\CompraDireta::class)
                    ->findOneBy(
                        [
                            'codCompraDireta' => $codCompraDireta,
                            'codEntidade' => $codEntidade,
                            'exercicioEntidade' => $exercicioEntidade,
                            'codModalidade' => $codModalidade,
                        ]
                    );
            }
        }

        if ($this->baseRouteName . "_edit" == $route) {
            list($codCompraDireta, $codEntidade, $exercicioEntidade, $codModalidade) = explode('~', $id);
        }

        $fieldOptions = [];

        // Opções do campo Código da Compra Direta
        $fieldOptions['compraDireta'] = [
            'class' => Compras\CompraDireta::class,
            'attr' => [
                'class' => 'select2-parameters ',
            ],
            'choice_label' => function (Compras\CompraDireta $compraDireta) {
                $codigo = $compraDireta->getCodCompraDireta();
                $exercicio = $compraDireta->getExercicioEntidade();
                $entidade = $compraDireta->getFkOrcamentoEntidade()->getFkSwCgm()->getNomCgm();

                return "{$codigo} | {$exercicio} | {$entidade}";
            },
            'label' => 'label.comprasDireta.compraDireta',
            'mapped' => false
        ];

        /** @var Compras\PublicacaoCompraDireta $publicacoesCompraDireta */
        $publicacoesCompraDireta = $entityManager->getRepository(Compras\PublicacaoCompraDireta::class)->findBy(
            [
                'codCompraDireta' => $codCompraDireta,
                'codEntidade' => $codEntidade,
                'exercicioEntidade' => $exercicioEntidade,
                'codModalidade' => $codModalidade,
            ]
        );

        $publicacoes = [];
        /** @var Compras\PublicacaoCompraDireta $publicacao */
        foreach ($publicacoesCompraDireta as $publicacao) {
            $publicacoes[] = $publicacao->getCgmVeiculo();
        }

        if (empty($publicacoes)) {
            $publicacoes = 0;
        }

        // Opções do campo Veículo de Publicação
        $fieldOptions['cgmVeiculo'] = [
            'class' => VeiculosPublicidade::class,
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'choice_label' => 'fkSwcgm.nomCgm',
            'label' => 'label.comprasDireta.manterPublicacao.cgmVeiculo',
            'required' => true,
            'mapped' => false
        ];

        $fieldOptions['compraDireta']['query_builder'] = function (EntityRepository $entityRepository) use ($codCompraDireta, $codEntidade, $exercicioEntidade, $codModalidade) {
            $qb = $entityRepository->createQueryBuilder('compra');
            $result = $qb->where('compra.codCompraDireta = :codCompraDireta')
                ->andWhere('compra.codEntidade = :codEntidade')
                ->andWhere('compra.exercicioEntidade = :exercicioEntidade')
                ->andWhere('compra.codModalidade = :codModalidade')
                ->setParameter(':codCompraDireta', $codCompraDireta)
                ->setParameter(':codEntidade', $codEntidade)
                ->setParameter(':exercicioEntidade', $exercicioEntidade)
                ->setParameter(':codModalidade', $codModalidade);

            return $result;
        };

        if (is_null($this->getAdminRequestId())) {
            $fieldOptions['cgmVeiculo']['query_builder'] = function (EntityRepository $entityRepository) use ($publicacoes) {
                $qb = $entityRepository->createQueryBuilder('publicacao');
                $result = $qb->where($qb->expr()->notIn('publicacao.numcgm', $publicacoes));

                return $result;
            };
            $fieldOptions['compraDireta']['data'] = $compraDireta;
        } else {
            $fieldOptions['cgmVeiculo']['query_builder'] = function (EntityRepository $entityRepository) use ($publicacaoCompraDireta) {
                $qb = $entityRepository->createQueryBuilder('publicacao');
                $result = $qb->where('publicacao.numcgm = :numCgm')
                    ->setParameter(':numCgm', $publicacaoCompraDireta->getCgmVeiculo());

                return $result;
            };
            $fieldOptions['cgmVeiculo']['attr'] = [
                'disabled' => 'disabled'
            ];
            $fieldOptions['compraDireta']['attr'] = [
                'disabled' => 'disabled'
            ];
        }

        // Opções do campo Data da Publicacao
        $fieldOptions['dataPublicacao'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.comprasDireta.manterPublicacao.dataPublicacao',
            'required' => true,
            'widget' => 'single_text'
        ];

        // Opções do campo Observação
        $fieldOptions['observacao'] = [
            'label' => 'label.comprasDireta.manterPublicacao.observacao'
        ];

        // Opções do campo Número da Publicação
        $fieldOptions['numPublicacao'] = [
            'label' => 'label.comprasDireta.manterPublicacao.numPublicacao',
            'attr' => [
                'class' => 'numeric '
            ]
        ];

        $formMapper
            ->with('label.comprasDireta.compraDireta')
            ->add('compraDireta', 'entity', $fieldOptions['compraDireta'], ['admin_code' => 'patrimonial.admin.compra_direta'])
            ->end()
            ->with('label.comprasDireta.manterPublicacao.publicacao')
            ->add('veiculo', 'entity', $fieldOptions['cgmVeiculo'], ['admin_code' => 'core.admin.veiculos_publicidade'])
            ->add('dataPublicacao', 'sonata_type_date_picker', $fieldOptions['dataPublicacao'])
            ->add('observacao', null, $fieldOptions['observacao'])
            ->add('numPublicacao', null, $fieldOptions['numPublicacao'])
            ->add('codCompraDireta', 'hidden', ['mapped' => false, 'data' => $codCompraDireta])
            ->add('codModalidade', 'hidden', ['mapped' => false, 'data' => $codModalidade])
            ->add('exercicioEntidade', 'hidden', ['mapped' => false, 'data' => $exercicioEntidade])
            ->add('codEntidade', 'hidden', ['mapped' => false, 'data' => $codEntidade])
            ->end();
    }

    /**
     * @param PublicacaoCompraDireta $publicacaoCompraDireta
     */
    public function prePersist($publicacaoCompraDireta)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $formData = $this->getRequest()->request->get($this->getUniqid());

        $codCompraDireta = $formData['codCompraDireta'];
        $codEntidade = $formData['codEntidade'];
        $codModalidade = $formData['codModalidade'];
        $exercicioEntidade = $formData['exercicioEntidade'];

        /** @var Compras\CompraDireta compraDireta */
        $compraDireta = $entityManager
            ->getRepository(Compras\CompraDireta::class)
            ->findOneBy(
                [
                    'codCompraDireta' => $codCompraDireta,
                    'codEntidade' => $codEntidade,
                    'exercicioEntidade' => $exercicioEntidade,
                    'codModalidade' => $codModalidade,
                ]
            );
        $form = $this->getForm();
        $cgmVeiculo = $form->get('veiculo')->getData();
        $publicacaoCompraDireta->setFkComprasCompraDireta($compraDireta);
        $publicacaoCompraDireta->setFkLicitacaoVeiculosPublicidade($cgmVeiculo);
    }

    /**
     * @param PublicacaoCompraDireta $publicacaoCompraDireta
     */
    public function redirect(Compras\PublicacaoCompraDireta $publicacaoCompraDireta)
    {
        $this->forceRedirect("/patrimonial/compras/compra-direta/{$this->getObjectKey($publicacaoCompraDireta->getFkComprasCompraDireta())}/show");
    }

    /**
     * @param Compras\PublicacaoCompraDireta $publicacaoCompraDireta
     */
    public function postPersist($publicacaoCompraDireta)
    {
        $this->redirect($publicacaoCompraDireta);
    }

    /**
     * @param Compras\PublicacaoCompraDireta $publicacaoCompraDireta
     */
    public function postUpdate($publicacaoCompraDireta)
    {
        $this->redirect($publicacaoCompraDireta);
    }

    /**
     * @param Compras\PublicacaoCompraDireta $publicacaoCompraDireta
     */
    public function postRemove($publicacaoCompraDireta)
    {
        $this->redirect($publicacaoCompraDireta);
    }
}
