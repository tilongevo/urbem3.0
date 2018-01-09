<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Licitacao\PublicacaoEdital;
use Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PublicacaoEditalAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_licitacao_publicacao_edital';
    protected $baseRoutePattern = 'patrimonial/licitacao/publicacao-edital';

    /**
     * @param ErrorElement $errorElement
     * @param PublicacaoEdital $publicacaoEdital
     */
    public function validate(ErrorElement $errorElement, $publicacaoEdital)
    {
        $formData = $this->getRequest()->request->get($this->getUniqid());
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $route = $this->getRequest()->get('_sonata_name');

        if ($this->baseRouteName . "_edit" == $route) {
            list($numcgm,
                $dataPublicacao,
                $numEdital,
                $exercicio) = explode('~', $this->getAdminRequestId());
        } else {
            $numEdital = $formData['numHEdital'];
            $exercicio = $formData['exercicio'];
        }

        $edital = $entityManager
            ->getRepository('CoreBundle:Licitacao\Edital')
            ->findOneBy([
                'numEdital' => $numEdital,
                'exercicio' => $exercicio,
            ]);

        $valorMaxNumPublicacao = 9; // Variável para setar o valor máximo permitido na inserção do "número da publicação"
        if (!is_numeric($publicacaoEdital->getNumPublicacao())) {
            $message = $this->trans('publicacao_edital.numpublicacaonaonumerico', [], 'validators');
            $errorElement->with('numPublicacao')->addViolation($message)->end();
        } elseif (strlen($publicacaoEdital->getNumPublicacao()) > $valorMaxNumPublicacao) {
            $message = $this->trans('publicacao_edital.numpublicacaomaiorqueopermitido', ['%valorMax%' => $valorMaxNumPublicacao], 'validators');
            $errorElement->with('numPublicacao')->addViolation($message)->end();
        }

        if ($edital->getDtAprovacaoJuridico() > $publicacaoEdital->getDataPublicacao()) {
            $message = $this->trans('publicacao_edital.dataaprovacaomenordatapublicacao', ['%dataAprovacao%' => $edital->getDtAprovacaoJuridico()->format('d/m/Y')], 'validators');
            $errorElement->with('dataPublicacao')->addViolation($message)->end();
        }

        $publicacaoEdital->setFkLicitacaoEdital($edital);
    }

    /**
     * @param PublicacaoEdital $publicacaoEdital
     */
    public function postPersist($publicacaoEdital)
    {
        $this->redirect($publicacaoEdital);
    }

    /**
     * @param PublicacaoEdital $publicacaoEdital
     */
    public function postUpdate($publicacaoEdital)
    {
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());
        $formData = $this->getRequest()->request->get($this->getUniqid());
        $edital = $entityManager
            ->getRepository('CoreBundle:Licitacao\Edital')
            ->findOneBy([
                'numEdital' => $formData['numHEdital'],
                'exercicio' => $formData['exercicio']
            ]);

        $this->redirect($publicacaoEdital);
    }

    /**
     * @param PublicacaoEdital $publicacaoEdital
     */
    public function postRemove($publicacaoEdital)
    {
        $this->redirect($publicacaoEdital);
    }

    /**
     * @param PublicacaoEdital $publicacaoEdital
     */
    public function prePersist($publicacaoEdital)
    {
        $form = $this->getForm();
        $veiculoPublicidade = $form->get('veiculoPublicidade')->getData();
        $publicacaoEdital->setFkLicitacaoVeiculosPublicidade($veiculoPublicidade);
    }

    /**
     * @param PublicacaoEdital $publicacaoEdital
     * @throws \Exception
     */
    public function redirect(PublicacaoEdital $publicacaoEdital)
    {
        $this->redirectToUrl('/patrimonial/licitacao/edital/' . $this->getObjectKey($publicacaoEdital->getFkLicitacaoEdital()) . '/show');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $route = $this->getRequest()->get('_sonata_name');
        /** @var PublicacaoEdital $publicacaoEdital */
        $publicacaoEdital = $this->getSubject();
        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $numEdital = $formData['numHEdital'];
            $exercicio = $formData['exercicio'];
        } else {
            if (!is_null($route)) {
                list($numEdital, $exercicio) = explode('~', $id);
            }
        }

        $fieldOptions = [];
        $fieldOptions['dataPublicacao'] = [
            'format' => 'dd/MM/yyyy',
            'pk_class' => DatePK::class,
            'label' => 'label.patrimonial.licitacao.publicacaoedital.dataPublicacao',
            'required' => true,
        ];

        $fieldOptions['numcgm'] = [
            'class' => VeiculosPublicidade::class,
            'label' => 'label.convenioAdmin.publicacoes.numcgm',
            'required' => true,
            'mapped' => false,
            'route' => ['name' => 'licitacao_carrega_veiculo_publicidade'],
            'req_params' => [
                'id' => $id
            ]

        ];

        $fieldOptions['observacao'] = [
            'label' => 'label.patrimonial.licitacao.publicacaoedital.observacao',
        ];
        $fieldOptions['numPublicacao'] = [
            'label' => 'label.patrimonial.licitacao.publicacaoedital.numPublicacao',
            'required' => false,
            'attr' => [

            ]
        ];

        if ($publicacaoEdital->getNumcgm()) {
            $fieldOptions['numcgm']['data'] = $publicacaoEdital->getFkLicitacaoVeiculosPublicidade();
            $fieldOptions['numcgm']['disabled'] = 'disabled';
            $fieldOptions['dataPublicacao']['disabled'] = 'disabled';
        }
        if (!is_null($route)) {
            $formMapper
                ->add('exercicio', 'hidden', ['data' => $exercicio, 'mapped' => false])
                ->add('numHEdital', 'hidden', ['data' => $numEdital, 'mapped' => false]);
        }

        $formMapper
            ->add('veiculoPublicidade', 'autocomplete', $fieldOptions['numcgm'])
            ->add('dataPublicacao', 'datepkpicker', $fieldOptions['dataPublicacao'])
            ->add('numPublicacao', null, $fieldOptions['numPublicacao'])
            ->add('observacao', 'textarea', $fieldOptions['observacao']);
    }
}
