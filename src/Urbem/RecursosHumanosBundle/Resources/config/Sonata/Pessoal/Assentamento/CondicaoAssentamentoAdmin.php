<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal\Assentamento;

use Doctrine\ORM\EntityRepository;
use Urbem\CoreBundle\Entity\Pessoal\CondicaoAssentamento;
use Urbem\CoreBundle\Model\Pessoal\Assentamento\CondicaoAssentamentoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CondicaoAssentamentoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_assentamento_condicao';
    protected $baseRoutePattern = 'recursos-humanos/pessoal/assentamento/condicao';

    protected $includeJs = array(
        '/recursoshumanos/javascripts/pessoal/assentamento.js',
    );


    /**
     * @param CondicaoAssentamento $condicaoAssentamento
     */
    public function prePersist($condicaoAssentamento)
    {
        $entityManager = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Pessoal\CondicaoAssentamento');
        $condicaoAssentamentoModel = new CondicaoAssentamentoModel($entityManager);
        $codAssentamento = $condicaoAssentamentoModel->getNextCodCondicao(
            $condicaoAssentamento->getTimestamp(),
            $condicaoAssentamento->getCodAssentamento()
        );

        $condicaoAssentamento->setCodCondicao($codAssentamento);
    }


    /**
     * @param CondicaoAssentamento $condicaoAssentamento
     */
    public function preUpdate($condicaoAssentamento)
    {
        $id = $this->getAdminRequestId();
        $em = $this->modelManager->getEntityManager($this->getClass());

        $vinculadosForm = $this->getForm()->get('codAssentamentoVinculado');
        foreach ($vinculadosForm as $vinculado) {
            $delete = $vinculado->get('_delete')->getData();
            if ($delete) {
                $info = $vinculado->getData();
                $vinculadoDelete = $em->getRepository('CoreBundle:Pessoal\AssentamentoVinculado')->findOneBy(['codCondicao' => $id, 'codAssentamentoVinculado' => $info->getCodAssentamentoVinculado()]);
                $em->remove($vinculadoDelete);
                $em->flush();
            }
        }

        $assentamento = $condicaoAssentamento->getCodAssentamento();
        $assentamentoVinculados = $condicaoAssentamento->getCodAssentamentoVinculado();
        foreach ($assentamentoVinculados as $assentamentoVinculado) {
            $manter[] = $assentamentoVinculado->getCodAssentamentoVinculado();
            $assentamentoVinculado->setCodAssentamento($assentamento->getCodAssentamento());
        }
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('fkPessoalAssentamentoAssentamento.fkPessoalClassificacaoAssentamento', null, ['label' => 'label.condicaoAssentamento.assentamento'], 'entity', [
                'attr' => ['class' => 'select2-parameters ']
            ])
            ->add('fkPessoalAssentamentoAssentamento', null, ['label' => 'label.classificacaoAssentamento.descricao'], 'entity', [
                'attr' => ['class' => 'select2-parameters ']
            ]);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codCondicao', 'number', ['label' => 'label.codigo'])
            ->add('fkPessoalAssentamentoAssentamento.fkPessoalClassificacaoAssentamento', null, ['label' => 'label.classificacaoAssentamento.descricao'])
            ->add('fkPessoalAssentamentoAssentamento', null, ['label' => 'label.condicaoAssentamento.assentamento'])
            ->add('timestamp', 'date', ['label.condicaoAssentamento.timestamp']);

        $listMapper
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'),
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

        $dado = null;

        if (!is_null($id)) {
            /** @var CondicaoAssentamento $condicao */
            $condicao = $this->getSubject();
            $dado = $condicao->getFkPessoalAssentamentoAssentamento()->getFkPessoalClassificacaoAssentamento();
        }

        $fieldOptions = [];

        $fieldOptions['codClassificacaoAssentamento'] = [
            'class' => 'CoreBundle:Pessoal\ClassificacaoAssentamento',
            'query_builder' => function (EntityRepository $repository) {
                $qb = $repository->createQueryBuilder('ca')
                    ->join('ca.fkPessoalTipoClassificacao', 'ptc');
                return $qb;
            },
            'placeholder' => 'label.selecione',
            'label' => 'label.classificacaoAssentamento.descricao',
            'attr' => ['class' => 'select2-parameters '],
            'mapped' => false,
            'data' => $dado,
        ];

        $fieldOptions['fkPessoalAssentamentoAssentamento'] = [
            'class' => 'CoreBundle:Pessoal\AssentamentoAssentamento',
            'placeholder' => 'label.selecione',
            'label' => 'label.condicaoAssentamento.assentamento',
            'attr' => ['class' => 'select2-parameters '],
            'required' => true,
        ];

        $formMapper
            ->with('label.condicaoAssentamento.condicaoAssentamentoVinculacao')
            ->add('codClassificacaoAssentamento', 'entity', $fieldOptions['codClassificacaoAssentamento'])
            ->add('fkPessoalAssentamentoAssentamento', null, $fieldOptions['fkPessoalAssentamentoAssentamento'])
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('codCondicao', null, ['label' => 'label.codigo'])
            ->add('codAssentamento.codClassificacao', 'null', ['label' => 'label.classificacao'])
            ->add('codAssentamento.sigla', 'null', ['label' => 'label.condicaoAssentamento.sigla'])
            ->add('codAssentamento.descricao', null, ['label' => 'label.condicaoAssentamento.assentamento']);
    }

    /**
     * @param CondicaoAssentamento $condicaoAssentamento
     */
    public function postPersist($condicaoAssentamento)
    {
        $this->forceRedirect("/recursos-humanos/pessoal/assentamento/condicao/{$this->getObjectKey($condicaoAssentamento)}/show");
    }
}
