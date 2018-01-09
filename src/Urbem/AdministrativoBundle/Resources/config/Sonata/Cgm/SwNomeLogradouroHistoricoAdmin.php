<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Cgm;

use Doctrine\ORM\EntityManager;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;

use Urbem\CoreBundle\Entity\Normas\Norma;
use Urbem\CoreBundle\Entity\SwLogradouro;
use Urbem\CoreBundle\Entity\SwNomeLogradouro;
use Urbem\CoreBundle\Model\SwLogradouroModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class SwNomeLogradouroHistoricoAdmin
 *
 * @package Urbem\AdministrativoBundle\Resources\config\Sonata\Cgm
 */
class SwNomeLogradouroHistoricoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_administrativo_logradouro_historico';
    protected $baseRoutePattern = 'administrativo/logradouro/historico';

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create', 'edit']);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->label = 'label.swLogradouro.historicoNomeLogradouro';

        $this->setBreadCrumb([]);

        $request = $this->getRequest();

        /** @var string|null $swLogradouroObjectKey */
        $swLogradouroObjectKey = $request->get('logradouro');

        /** @var SwNomeLogradouro $swNomeLogradouro */
        $swNomeLogradouro = $this->getSubject();

        if ((is_null($swLogradouroObjectKey) || $swLogradouroObjectKey == "")
            && $request->getMethod() == 'GET') {
            $this->redirectByRoute('urbem_administrativo_logradouro_list');
        } elseif ($request->getMethod() == 'POST') {
            $formData = $request->get($this->getUniqid());
            $swLogradouroObjectKey = $formData['codLogradouro'];
        }

        /** @var EntityManager $entityManager */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        /** @var SwLogradouro $swLogradouro */
        $swLogradouro = $entityManager->find(SwLogradouro::class, $swLogradouroObjectKey);

        $swNomeLogradouro->setFkSwLogradouro($swLogradouro);

        $exercicio = $this->getExercicio();

        $fieldOptions = [];
        $fieldOptions['codLogradouro'] = [
            'data' => $swLogradouro->getCodLogradouro()
        ];

        $fieldOptions['nomLogradouro'] = [
            'label'  => 'label.swLogradouro.nomeAnterior'
        ];

        $fieldOptions['fkNormasNorma'] = [
            'attr'          => ['class' => 'select2-parameters'],
            'class'         => Norma::class,
            'label'         => 'label.swLogradouro.norma',
            'query_builder' => function (EntityRepository $repository) use ($exercicio) {
                return $repository
                    ->createQueryBuilder('n')
                    ->where('n.exercicio = :exercicio')
                    ->setParameter('exercicio', $exercicio);
            },
            'required'      => true,
            'placeholder'   => 'label.selecione',
        ];

        $fieldOptions['dtInicio'] = [
            'format' => 'dd/MM/yyyy',
            'label'  => 'label.swLogradouro.dtInicio',
        ];

        $fieldOptions['dtFim'] = [
            'format'      => 'dd/MM/yyyy',
            'label'       => 'label.swLogradouro.dtFim',
        ];

        $formMapper
            ->add('codLogradouro', 'hidden', $fieldOptions['codLogradouro'])
            ->add('fkNormasNorma', null, $fieldOptions['fkNormasNorma'])
            ->add('nomLogradouro', null, $fieldOptions['nomLogradouro'])
            ->add('dtInicio', 'sonata_type_date_picker', $fieldOptions['dtInicio'])
            ->add('dtFim', 'sonata_type_date_picker', $fieldOptions['dtFim'])
        ;

        if (preg_match('/(create)/', $request->getUri()) === 1) {
            $formMapper
                ->getFormBuilder()
                ->setAction('create');
        }
    }

    /**
     * @param ErrorElement     $errorElement
     * @param SwNomeLogradouro $swNomeLogradouro
     */
    public function validate(ErrorElement $errorElement, $swNomeLogradouro)
    {
        $dtInicio = $swNomeLogradouro->getDtInicio();
        $dtFim = $swNomeLogradouro->getDtFim();

        if ($dtFim < $dtInicio) {
            $message = $this->trans('swLogradouros.errors.dtinicioMaiorDtFim', [
                '%dtInicio' => $dtInicio->format('d/m/Y')
            ], 'validators');

            $errorElement->with('dtFim')->addViolation($message)->end();
        }
    }

    /**
     * @param SwNomeLogradouro $swNomeLogradouro
     */
    public function prePersist($swNomeLogradouro)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $swLogradouro = $swNomeLogradouro->getFkSwLogradouro();

        $currentSwNomeLogradouro = $swLogradouro->getCurrentFkSwNomeLogradouro();

        $currentTimestamp = $currentSwNomeLogradouro->getTimestamp();
        $newTimestamp = $swNomeLogradouro->getTimestamp();

        $currentSwNomeLogradouro->setTimestamp($newTimestamp);

        $swNomeLogradouro->setTimestamp($currentTimestamp);
        $swNomeLogradouro->setFkSwTipoLogradouro($currentSwNomeLogradouro->getFkSwTipoLogradouro());

        (new SwLogradouroModel($entityManager))
            ->save($currentSwNomeLogradouro);
    }

    /**
     * @param SwNomeLogradouro $swNomeLogradouro
     */
    public function postPersist($swNomeLogradouro)
    {
        $swLogradouroObjectKey = $this->id($swNomeLogradouro->getFkSwLogradouro());
        $this->redirectByRoute('urbem_administrativo_logradouro_show', ['id' => $swLogradouroObjectKey]);
    }
}
