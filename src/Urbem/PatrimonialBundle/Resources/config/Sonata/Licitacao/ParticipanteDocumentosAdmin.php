<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Compras;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Licitacao;

class ParticipanteDocumentosAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_licitacao_participante_documentos';
    protected $baseRoutePattern = 'patrimonial/licitacao/participante-documentos';

    /**
     * @param Licitacao\ParticipanteDocumentos $object
     */
    public function prePersist($object)
    {
        $formData = $this->getRequest()->request->get($this->getUniqid());
        list($codLicitacao,
            $codModalidade,
            $codEntidade,
            $exercicio) = explode("~", $formData['codHLicitacao']);

        $object
            ->setCodLicitacao($codLicitacao)
            ->setCodModalidade($codModalidade)
            ->setCodEntidade($codEntidade)
            ->setExercicio($exercicio)
        ;
    }

    /**
     * @param Licitacao\ParticipanteDocumentos $object
     */
    public function postUpdate($object)
    {
        $this->redirect($object->getFkLicitacaoLicitacaoDocumentos()->getFkLicitacaoLicitacao());
    }

    /**
     * @param Licitacao\ParticipanteDocumentos $object
     */
    public function postRemove($object)
    {
        $this->redirect($object->getFkLicitacaoLicitacaoDocumentos()->getFkLicitacaoLicitacao());
    }

    /**
     * @param Licitacao\Licitacao $licitacao
     */
    public function redirect(Licitacao\Licitacao $licitacao)
    {
        $this->forceRedirect("/patrimonial/licitacao/licitacao/" . $this->getObjectKey($licitacao) . "/show");
    }
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('dtValidade')
            ->add('numDocumento')
            ->add('dtEmissao')
            ->add('timestamp')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('dtValidade')
            ->add('numDocumento')
            ->add('dtEmissao')
            ->add('timestamp')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $formData = $this->getRequest()->request->getIterator()->current();

        if (isset($formData['codHLicitacao'])) {
            $id = $formData['codHLicitacao'];
        }
        if (is_null($id)) {
            $id = $this->getRequest()->query->get('param');
        }
        if ($this->baseRouteName . "_edit" == $this->getRequest()->get('_sonata_name')) {
            $id = $this->getObjectKey($this->subject->getFkLicitacaoLicitacaoDocumentos()->getFkLicitacaoLicitacao());
            $readonly = 'readonly';
        }
        $codLicitacao = explode('~', $id);


        /** @var EntityManager $em */
        $em = $this->modelManager
            ->getEntityManager($this->getClass());

        $licitacao = $em->getRepository('CoreBundle:Licitacao\Licitacao')
            ->findOneBy([
                'codLicitacao' => $codLicitacao[0],
                'codModalidade' => $codLicitacao[1],
                'codEntidade' => $codLicitacao[2],
                'exercicio' => $codLicitacao[3],
            ]);

        if (!$this->getRequest()->isMethod('GET')) {
            if ($licitacao->getFkLicitacaoLicitacaoDocumentos()->count() === 0) {
                $this->redirect($licitacao, 'label.patrimonial.licitacao.faltamDocumentos', 'error');
            }
        }

        $queryDocumentos = $em->createQueryBuilder()
            ->select('d')
            ->from('CoreBundle:Licitacao\LicitacaoDocumentos', 'd')
            ->join('d.fkLicitacaoLicitacao', 'l')
            ->andWhere('l.codLicitacao = :codLicitacao')
            ->andWhere('l.codModalidade = :codModalidade')
            ->andWhere('l.codEntidade = :codEntidade')
            ->andWhere('l.exercicio = :exercicio')
            ->setParameter('codLicitacao', $codLicitacao[0])
            ->setParameter('codModalidade', $codLicitacao[1])
            ->setParameter('codEntidade', $codLicitacao[2])
            ->setParameter('exercicio', $codLicitacao[3]);

        if ($this->baseRouteName . "_edit" == $this->getRequest()->get('_sonata_name')) {
            $queryDocumentos
                ->andWhere('d.codDocumento = :codDocumento')
                ->setParameter('codDocumento', $this->subject->getCodDocumento());
        }

        $fieldOptions = [];
        $fieldOptions['dtEmissao'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.patrimonial.licitacao.dtEmissao',
            'pk_class' => DatePK::class,
            'required' => true,
        ];

        $fieldOptions['dtValidade'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.patrimonial.licitacao.dtValidade',
            'pk_class' => DatePK::class,
            'required' => true,
        ];

        $fieldOptions['numDocumento'] = [
            'label' => 'label.patrimonial.licitacao.numDocumento',
            'required' => true,
        ];

        $formMapper
            ->add('fkLicitacaoLicitacaoDocumentos', null, [
                'query_builder' => $queryDocumentos,
                'label' => 'label.patrimonial.licitacao.nomDocumento',
                'required' => true,
                'attr' => [
                    'class' => 'select2-parameters '
                ]
            ])
            ->add('numDocumento', null, $fieldOptions['numDocumento'])
            ->add('dtEmissao', 'datepkpicker', $fieldOptions['dtEmissao'])
            ->add('dtValidade', 'datepkpicker', $fieldOptions['dtValidade'])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('dtValidade')
            ->add('numDocumento')
            ->add('dtEmissao')
            ->add('timestamp')
        ;
    }
}
