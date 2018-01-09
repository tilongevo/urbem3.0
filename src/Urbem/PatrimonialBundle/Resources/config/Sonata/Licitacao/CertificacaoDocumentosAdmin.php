<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Licitacao\CertificacaoDocumentos;
use Urbem\CoreBundle\Entity\Licitacao\ParticipanteCertificacao;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class CertificacaoDocumentosAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao
 */
class CertificacaoDocumentosAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_licitacao_certificacao_documentos';
    protected $baseRoutePattern = 'patrimonial/licitacao/certificacao-documentos';
    protected $exibirBotaoIncluir = false;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('exercicio')
            ->add('numDocumento')
            ->add('dtEmissao')
            ->add('dtValidade')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('numDocumento')
            ->add('dtEmissao')
            ->add('dtValidade')
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $id = $formData['numHCertificacao'];
        }


        /** Verificação da rota para perdonalizar e encontrar as variáveis necessárias [$numCertificado, $exercicio, $cgmFornecedor] */
        $codDocumento = 0;
        $route = $this->getRequest()->get('_sonata_name');
        if ($this->baseRouteName . "_edit" == $route) {
            list($numCertificado, $exercicio, $codDocumento, $cgmFornecedor)  = explode('~', $id);
        }else{
            list($numCertificado, $exercicio, $cgmFornecedor) = explode('~', $id);
        }

        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());


        /** @var ParticipanteCertificacao $certificacao */
        $certificacao = $entityManager
            ->getRepository('CoreBundle:Licitacao\ParticipanteCertificacao')
            ->findOneBy([
                'numCertificacao' => $numCertificado,
                'exercicio' => $exercicio,
                'cgmFornecedor' => $cgmFornecedor
            ]);

        $doc = [];

        if($certificacao and count($certificacao->getFkLicitacaoCertificacaoDocumentos()) > 0){
            foreach($certificacao->getFkLicitacaoCertificacaoDocumentos() as $documentos){
                if($documentos->getCodDocumento() != $codDocumento){
                    $doc[] = $documentos->getCodDocumento();
                }
            }
        } else {
            $doc[] = 0;
        }

        $formMapper
            ->add('numHCertificacao', 'hidden', ['data' => $id, 'mapped' => false])
            ->add(
                'fkLicitacaoDocumento',
                null,
                [
                    'required' => true,
                    'label' => 'label.patrimonial.participante_certificacao.codDocumento',
                    'query_builder' => function (\Doctrine\ORM\EntityRepository $er) use ($doc) {
                        $query = $er
                            ->createQueryBuilder('fkLicitacaoDocumento');
                        $query->where($query->expr()->notIn('fkLicitacaoDocumento.codDocumento', $doc));
                        return $query;
                    },
                    'attr' => [
                        'class' => 'select2-parameters '
                    ]
                ]
            )
            ->add('numDocumento', null, ['label' => 'label.patrimonial.participante_certificacao.numDocumento'])
            ->add(
                'dtEmissao',
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                    'required' => true,
                    'label' => 'Data de Emissão'
                ]
            )
            ->add(
                'dtValidade',
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                    'required' => true,
                    'label' => 'Data de Validade'
                ]
            )
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->add('exercicio')
            ->add('numDocumento')
            ->add('dtEmissao')
            ->add('dtValidade')
        ;
    }

    /**
     * @param CertificacaoDocumentos $certificacaoDocumentos
     */
    public function prePersist($certificacaoDocumentos)
    {
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        $formData = $this->getRequest()->request->get($this->getUniqid());

        list($numCertificado, $exercicio, $cgmFornecedor) = explode('~', $formData['numHCertificacao']);
        /** @var ParticipanteCertificacao $pCertificacao */
        $pCertificacao = $entityManager
            ->getRepository('CoreBundle:Licitacao\ParticipanteCertificacao')
            ->findOneBy([
                'numCertificacao' => $numCertificado,
                'exercicio' => $exercicio,
                'cgmFornecedor' => $cgmFornecedor
            ]);

        $certificacaoDocumentos->setFkLicitacaoParticipanteCertificacao($pCertificacao);
    }

    /**
     * @param CertificacaoDocumentos $certificacaoDocumentos
     */
    public function postPersist($certificacaoDocumentos)
    {
        $this->redirect($certificacaoDocumentos);
    }

    /**
     * @param CertificacaoDocumentos $certificacaoDocumentos
     */
    public function postUpdate($certificacaoDocumentos)
    {

        $this->redirect($certificacaoDocumentos);
    }

    /**
     * @param CertificacaoDocumentos $certificacaoDocumentos
     */
    public function postRemove($certificacaoDocumentos)
    {
        $this->redirect($certificacaoDocumentos);
    }

    /**
     * @param CertificacaoDocumentos $certificacaoDocumentos
     * @param $message
     * @param string $type
     */
    public function redirect(CertificacaoDocumentos $certificacaoDocumentos)
    {

        $this->forceRedirect("/patrimonial/licitacao/participante-certificacao/{$this->getObjectKey($certificacaoDocumentos->getFkLicitacaoParticipanteCertificacao())}/show");
    }
}
