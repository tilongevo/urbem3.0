<?php

namespace Urbem\CoreBundle\Model\Beneficio;

use Doctrine\ORM;

use Symfony\Component\HttpFoundation\Response;

use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Beneficio;

class ValeTransporteModel
{
    private $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Beneficio\ValeTransporte");
    }
    
    /**
     * Salva o relacionamento com Beneficio\Custo
     * @param  ValeTransporte $object
     * @param  object $formData
     */
    public function saveRelationship($object, $formData)
    {
        $fkBeneficioCustos = new \Urbem\CoreBundle\Entity\Beneficio\Custo();
        $fkBeneficioCustos->setInicioVigencia($formData->get('inicioVigencia')->getData());
        $fkBeneficioCustos->setFkBeneficioValeTransporte($object);
        $fkBeneficioCustos->setValor($formData->get('valor')->getData());
        
        $this->entityManager->persist($fkBeneficioCustos);
        $this->entityManager->flush();
    }
    
    /**
     * Executa operações adicionais para o persist de ValeTransporte
     * @param  ValeTransporte $object
     * @param  object $form
     * @param  object $formData
     */
    public function customPostPersist($object, $form, $formData)
    {
        // Origem
        $fkSwMunicipio1 = $this->entityManager->getRepository('CoreBundle:SwMunicipio')
        ->findOneByCodMunicipio($form->fkBeneficioItinerario['municipioOrigem']);
        
        // Destino
        $fkSwMunicipio = $this->entityManager->getRepository('CoreBundle:SwMunicipio')
        ->findOneByCodMunicipio($form->fkBeneficioItinerario['municipioDestino']);
        
        $fkBeneficioItinerario = $formData->get('fkBeneficioItinerario')->getData();
        $fkBeneficioItinerario->setFkBeneficioValeTransporte($object);
        $fkBeneficioItinerario->setFkSwMunicipio1($fkSwMunicipio1);
        $fkBeneficioItinerario->setFkSwMunicipio($fkSwMunicipio);
        
        $this->entityManager->persist($fkBeneficioItinerario);
        $this->entityManager->flush();
        
        $object->setFkBeneficioItinerario($fkBeneficioItinerario);
    }
}
