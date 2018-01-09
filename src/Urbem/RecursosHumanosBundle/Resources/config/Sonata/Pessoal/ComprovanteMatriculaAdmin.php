<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Pessoal\ComprovanteMatricula;
use Urbem\CoreBundle\Entity\Pessoal\Servidor;
use Urbem\CoreBundle\Entity\Pessoal\Dependente;
use Urbem\CoreBundle\Entity\Pessoal\DependenteComprovanteMatricula;

class ComprovanteMatriculaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_servidor_dependente_comprovante_matricula';
    protected $baseRoutePattern = 'recursos-humanos/pessoal/servidor/dependente/comprovante-matricula';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create','edit','delete']);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = [];

        $fieldOptions['codDependente'] = [
            'data' => $id,
            'mapped' => false
        ];

        $fieldOptions['dtApresentacao'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.servidordependente.dtapresentacaoMatricula'
        ];

        $formMapper
            ->with('label.servidordependente.dependenteMatricula')
                ->add(
                    'codDependente',
                    'hidden',
                    $fieldOptions['codDependente']
                )
                ->add(
                    'dtApresentacao',
                    'sonata_type_date_picker',
                    $fieldOptions['dtApresentacao']
                )
            ->end()
        ;
    }

    public function redirect(Servidor $servidor)
    {
        $servidor = $servidor->getCodServidor();
        $this->forceRedirect('/recursos-humanos/pessoal/servidor/' . $servidor .'/show');
    }

    /**
     * @param mixed $comprovanteMatricula
     */
    public function prePersist($comprovanteMatricula)
    {
        $entityManager = $this->getDoctrine();

        $codComprovante = $entityManager->getRepository(ComprovanteMatricula::class)
        ->getNextCodComprovante();

        $comprovanteMatricula->setCodComprovante($codComprovante);
        $comprovanteMatricula->setApresentada(false);

        $fkPessoalDependente = $entityManager->getRepository(Dependente::class)
        ->findOneByCodDependente($this->getForm()->get('codDependente')->getData());

        $dependenteComprovanteMatricula = new DependenteComprovanteMatricula();
        $dependenteComprovanteMatricula->setFkPessoalDependente($fkPessoalDependente);
        $dependenteComprovanteMatricula->setFkPessoalComprovanteMatricula($comprovanteMatricula);

        $comprovanteMatricula->addFkPessoalDependenteComprovanteMatriculas($dependenteComprovanteMatricula);
    }

    /**
     * {@inheritDoc}
     */
    public function postPersist($comprovanteMatricula)
    {
        $servidor = $comprovanteMatricula->getFkPessoalDependenteComprovanteMatriculas()->last()
        ->getFkPessoalDependente()->getFkPessoalServidorDependentes()->last()->getFkPessoalServidor();

        $this->redirect($servidor);
    }

    /**
     * {@inheritDoc}
     */
    public function postRemove($comprovanteMatricula)
    {
        $servidor = $comprovanteMatricula->getFkPessoalDependenteComprovanteMatriculas()->last()
        ->getFkPessoalDependente()->getFkPessoalServidorDependentes()->last()->getFkPessoalServidor();

        $this->redirect($servidor);
    }

    /**
     * {@inheritDoc}
     */
    public function toString($comprovanteMatricula)
    {
        return (string) $comprovanteMatricula->getDtApresentacao()->format("d/m/Y");
    }
}
