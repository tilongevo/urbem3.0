<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Compras;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Model\SwProcessoModel;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

class CompraDiretaAnulacaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_compras_compra_direta_anulacao';
    protected $baseRoutePattern = 'patrimonial/compras/compra-direta/anulacao';

    public $compraDireta;
    public $codMapaItens;
    public $processoAdministrativo;

    protected function configureRoutes(RouteCollection $routeCollection)
    {
        $routeCollection->remove('batch');
        $routeCollection->remove('edit');
        $routeCollection->remove('show');
        $routeCollection->remove('export');
        $routeCollection->remove('delete');
    }

    /**
     * @param integer $codCompraDireta
     */
    private function buildAditionalInfoForForm($codCompraDireta, $codEntidade, $exercicioEntidade, $codModalidade)
    {
        $this->setBreadCrumb();

        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        /** @var Compras\CompraDireta compraDireta */
        $this->compraDireta = $entityManager
            ->getRepository(Compras\CompraDireta::class)
            ->findOneBy(
                [
                    'codCompraDireta' => $codCompraDireta,
                    'codEntidade' => $codEntidade,
                    'exercicioEntidade' => $exercicioEntidade,
                    'codModalidade' => $codModalidade,
                ]
            );

        $this->codMapaItens = $entityManager
            ->getRepository(Compras\MapaItem::class)
            ->findBy([
                'codMapa' => $this->compraDireta->getCodMapa(),
                'exercicio' => $this->compraDireta->getExercicioMapa()
            ]);

        if (count($this->compraDireta->getFkComprasCompraDiretaProcesso()) > 0) {
            $this->processoAdministrativo = $this->compraDireta->getFkComprasCompraDiretaProcesso();

            $this->processoAdministrativo->numcgm = $this->processoAdministrativo
                ->getFkSwProcesso()->getFkSwProcessoInteressados()->last()->getFkSwCgm()->getNumCgm();
        }
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $codCompraDireta = $this->getRequest()->get('cod_compra_direta');

        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());

            $codCompraDireta = $formData['codCompraDireta'];
            $codEntidade = explode('-', $formData['codEntidade']);
            $codEntidade = trim($codEntidade[0]);
            $codModalidade = explode('-', $formData['codModalidade']);
            $codModalidade = trim($codModalidade[0]);
            $exercicioEntidade = $formData['exercicioEntidade'];
        } else {
            list($codCompraDireta, $codEntidade, $exercicioEntidade, $codModalidade) = explode('~', $codCompraDireta);
        }

        $this->buildAditionalInfoForForm($codCompraDireta, $codEntidade, $exercicioEntidade, $codModalidade);

        $fieldOptions = [];

        $fieldOptions['codCompraDireta'] = [
            'attr' => [
                'class' => 'select2-parameters hidden-field ',
                'disabled' => 'disabled'
            ],
            'query_builder' => function (EntityRepository $entityRepository) use ($codCompraDireta, $codEntidade, $exercicioEntidade, $codModalidade) {
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
            },
            'data' => $this->compraDireta,
            'label' => 'label.comprasDireta.compraDireta'
        ];
        $fieldOptions['codModalidade'] = [
            'attr' => [
                'class' => 'hidden-field ',
                'readonly' => 'readonly'
            ],
            'label' => 'label.comprasDireta.codModalidade',
            'data' => $this->compraDireta->getFkComprasModalidade(),
            'mapped' => false,
        ];
        $fieldOptions['exercicioEntidade'] = [
            'attr' => [
                'class' => 'hidden-field readonly ',
                'readonly' => 'readonly'
            ],
            'data' => $this->compraDireta->getExercicioEntidade(),
            'mapped' => false,
        ];
        $fieldOptions['codEntidade'] = [
            'attr' => [
                'class' => 'hidden-field readonly ',
                'readonly' => 'readonly'
            ],
            'label' => 'label.comprasDireta.codEntidade',
            'data' => $this->compraDireta->getFkOrcamentoEntidade(),
            'mapped' => false,
        ];

        // Opções do campo motivo
        $fieldOptions['motivo'] = [
            'label' => 'label.comprasDireta.anulacao.motivo'
        ];

        $formMapper
            ->with('label.comprasDireta.anulacao.anulacao')
            ->add('fkComprasCompraDireta', null, $fieldOptions['codCompraDireta'], ['admin_code' => 'patrimonial.admin.compra_direta'])
            ->add('codCompraDireta', 'hidden', ['mapped' => false, 'data' => $codCompraDireta])
            ->add('codModalidade', 'text', $fieldOptions['codModalidade'])
            ->add('exercicioEntidade', 'text', $fieldOptions['exercicioEntidade'])
            ->add('codEntidade', 'text', $fieldOptions['codEntidade'])
            ->add('motivo', 'textarea', $fieldOptions['motivo'])
            ->end();
    }

    /**
     * @param Compras\CompraDiretaAnulacao $compraDiretaAnulacao
     */
    public function postPersist($compraDiretaAnulacao)
    {
        $this->forceRedirect("/patrimonial/compras/compra-direta/list");
    }

    /**
     * @param Compras\CompraDiretaAnulacao $compraDiretaAnulacao
     */
    public function prePersist($compraDiretaAnulacao)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $formData = $this->getRequest()->request->get($this->getUniqid());

        $codCompraDireta = $formData['codCompraDireta'];
        $codEntidade = explode('-', $formData['codEntidade']);
        $codEntidade = trim($codEntidade[0]);
        $codModalidade = explode('-', $formData['codModalidade']);
        $codModalidade = trim($codModalidade[0]);
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

        $compraDiretaAnulacao->setFkComprasCompraDireta($compraDireta);
    }
}
