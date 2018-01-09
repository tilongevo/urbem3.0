<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Urbem\CoreBundle\Entity\Licitacao\AnulacaoImpugnacaoEdital;
use Urbem\CoreBundle\Entity\Licitacao\Edital;
use Urbem\CoreBundle\Entity\Licitacao\EditalImpugnado;
use Urbem\CoreBundle\Entity\Orcamento;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Model\SwProcessoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Compras;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class AnulacaoImpugnacaoEditalAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_licitacao_anulacao_impugnacao_edital';
    protected $baseRoutePattern = 'patrimonial/licitacao/anulacao-impugnacao-edital';
    protected $exibirBotaoExcluir = false;
    protected $exibirBotaoIncluir = false;


    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('parecerJuridico')
            ->add('exercicioProcesso')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('parecerJuridico')
            ->add('exercicioProcesso')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    public function prePersist($object)
    {

        $formData = $this->getRequest()->request->get($this->getUniqid());
        $em = $this->getModelManager()->getEntityManager($this->getClass());

        $edital = $em
            ->getRepository(Edital::class)
            ->findOneBy([
                'numEdital' => $formData['codEdital'],
                'exercicio' => $formData['hexercicio']
            ]);

        foreach($formData['codProcesso'] as $processo){
            $proc = $em
                ->getRepository(SwProcesso::class)
                ->findOneBy([
                    'codProcesso' => $processo,
                ]);

            $anular = $em
                ->getRepository(EditalImpugnado::class)
                ->findOneBy([
                    'codProcesso' => $proc->getCodProcesso(),
                    'numEdital' => $edital
                ]);

            if(count($anular) > 0){
                $em->remove($anular);
                $em->flush();
            }

            $anulacaoEditalImpugnacao = new AnulacaoImpugnacaoEdital();
            $anulacaoEditalImpugnacao->setCodProcesso($proc);
            $anulacaoEditalImpugnacao->setNumEdital($edital);
            $anulacaoEditalImpugnacao->setExercicioProcesso($proc->getAnoExercicio());
            $anulacaoEditalImpugnacao->setParecerJuridico($object->getParecerJuridico());
            $em->persist($anulacaoEditalImpugnacao);
        }
        $em->flush();

        $edital = $formData['codEdital']."~".$formData['hexercicio'];

        $message = $this->trans('patrimonial.licitacao.edital.anulacaoimpugnado.create', [], 'flashes');
        $this->redirect($edital, $message, 'success');
    }

    public function redirect($edital, $message, $type = 'success')
    {
        $message = $this->trans($message);
        $container = $this->getConfigurationPool()->getContainer();

        $container->get('session')->getFlashBag()->add($type, $message);

        $this->forceRedirect("/patrimonial/licitacao/edital/perfil?id=" . $edital);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $ids = explode('~', $this->getAdminRequestId());

        $id = $ids[0];

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $id = $formData['codEdital'];
            $exercicio = $formData['hexercicio'];
        }else{
            $id = $ids[0];
            $exercicio = $ids[1];
        }
        $em = $this->getModelManager()->getEntityManager($this->getClass());
        $swModel = new SwProcessoModel($em);

        $edital = $em
            ->getRepository('CoreBundle:Licitacao\Edital')
            ->findOneBy([
                'exercicio' => $exercicio,
                'numEdital' => $id,
            ]);

        $editalImpugnado = $em
            ->getRepository('CoreBundle:Licitacao\EditalImpugnado')
            ->findBy([
                'numEdital' => $edital
            ]);

        $processoArray = array();
        foreach($editalImpugnado as $impugnado){
            $processoArray[] = $impugnado->getCodProcesso();
        }

        $processos = $em
            ->getRepository(SwProcesso::class)
            ->findBy([
                'codProcesso' => $processoArray,
            ]);

        $dados = array();
        foreach ($processos as $processo) {
            $dados[$processo->getCodProcesso() . '/' .$processo->getAnoExercicio()] = $processo->getCodProcesso();
        }

        $fieldOptions['codProcesso'] = [
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'label' => 'Processos',
            'choices' => $dados,
            'mapped' => false,
            'multiple' => true,
            'expanded' => false,
            'required' => true
        ];

        $fieldOptions['codProcesso']['choice_attr'] = function ($entity, $key, $index)
 use ($dados) {
            foreach ($dados as $cod) {
                if ($entity == $cod) {
                    return ['selected' => 'selected'];
                }
            }
        };

        $fieldOptions['numEdital'] = [
            'attr' => [
                'readonly' => 'readonly '
            ],
            'label' => 'Edital',
            'data' => $edital->getNumEdital(). "/".$edital->getExercicio(),
            'mapped' => false,
        ];

        $formMapper
            ->add(
                'codEdital',
                'hidden',
                ['data' => $id, 'mapped' => false]
            )
            ->add(
                'hexercicio',
                'hidden',
                ['data' => $exercicio, 'mapped' => false]
            )
            ->add('numEdital', 'text', $fieldOptions['numEdital'])
            ->add('codProcesso', 'choice', $fieldOptions['codProcesso'], ['admin_code' => 'administrativo.admin.processo'])
            ->add('parecerJuridico')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('parecerJuridico')
            ->add('exercicioProcesso')
        ;
    }
}
