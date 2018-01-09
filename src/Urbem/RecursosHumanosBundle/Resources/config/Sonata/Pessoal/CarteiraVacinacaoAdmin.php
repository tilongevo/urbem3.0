<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Entity\Pessoal\DependenteCarteiraVacinacao;
use Urbem\CoreBundle\Entity\Pessoal\Dependente;
use Urbem\CoreBundle\Entity\Pessoal\CarteiraVacinacao;
use Urbem\CoreBundle\Entity\Pessoal\Servidor;

class CarteiraVacinacaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_servidor_dependente_carteira_vacinacao';
    protected $baseRoutePattern = 'recursos-humanos/pessoal/servidor/dependente/carteira-vacinacao';

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
            'label' => 'label.servidordependente.dtapresentacaoVacinacao'
        ];

        $formMapper
            ->with('label.servidordependente.dependenteVacinacao')
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
     * @param mixed $carteiraVacinacao
     */
    public function prePersist($carteiraVacinacao)
    {
        $entityManager = $this->getDoctrine();

        $codCarteira = $entityManager->getRepository(CarteiraVacinacao::class)
        ->getNextCodCarteira();

        $carteiraVacinacao->setCodCarteira($codCarteira);
        $carteiraVacinacao->setApresentada(false);

        $fkPessoalDependente = $entityManager->getRepository(Dependente::class)
        ->findOneByCodDependente($this->getForm()->get('codDependente')->getData());

        $dependenteCarteiraVacinacao = new DependenteCarteiraVacinacao();
        $dependenteCarteiraVacinacao->setFkPessoalDependente($fkPessoalDependente);
        $dependenteCarteiraVacinacao->setFkPessoalCarteiraVacinacao($carteiraVacinacao);

        $carteiraVacinacao->addFkPessoalDependenteCarteiraVacinacoes($dependenteCarteiraVacinacao);
    }

    /**
     * {@inheritDoc}
     */
    public function postPersist($carteiraVacinacao)
    {
        $servidor = $carteiraVacinacao->getFkPessoalDependenteCarteiraVacinacoes()->last()
        ->getFkPessoalDependente()->getFkPessoalServidorDependentes()->last()->getFkPessoalServidor();

        $this->redirect($servidor);
    }

    /**
     * {@inheritDoc}
     */
    public function postRemove($carteiraVacinacao)
    {
        $servidor = $carteiraVacinacao->getFkPessoalDependenteCarteiraVacinacoes()->last()
        ->getFkPessoalDependente()->getFkPessoalServidorDependentes()->last()->getFkPessoalServidor();

        $this->redirect($servidor);
    }

    /**
     * {@inheritDoc}
     */
    public function toString($carteiraVacinacao)
    {
        return (string) $carteiraVacinacao->getDtApresentacao()->format("d/m/Y");
    }
}
