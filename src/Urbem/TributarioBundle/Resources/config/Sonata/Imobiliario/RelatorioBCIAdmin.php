<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Symfony\Component\HttpFoundation\Request;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Doctrine\ORM\EntityRepository;
use Urbem\CoreBundle\Entity\Imobiliario\Imovel;
use Urbem\CoreBundle\Entity\Imobiliario\Localizacao;
use Urbem\CoreBundle\Entity\SwBairro;
use Urbem\CoreBundle\Entity\SwLogradouro;

class RelatorioBCIAdmin extends AbstractAdmin
{
    const NAO_INFORMADO = 0;
    
    protected $baseRouteName = 'urbem_tributario_imobiliario_relatorio_bci';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/relatorios/bci';
    
    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create']);
        $collection->add('relatorio', 'relatorio');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);
        
        $fieldOptions = array();
        
        $fieldOptions['inscricaoImobiliaria'] = [
            'attr'        => ['class' => 'select2-parameters '],
            'class'       => Imovel::class,
            'choice_label' => function (Imovel $imovel) {
                return "{$imovel->getLote() } - {$imovel->getLocalizacao()} - {$imovel->getInscricaoMunicipal()}";
            },
            'label'       => 'label.imobiliarioRelatorios.BCI.inscricaoImobiliariaDe',
            'placeholder' => 'label.selecione',
            'required'    => false,
            'mapped'      => false
        ];
        
        $fieldOptions['localizacao'] = array(
            'label' => 'label.imobiliarioRelatorios.BCI.localizacaoDe',
            'class' => Localizacao::class,
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => false,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['logradouro'] = array(
            'label' => 'label.imobiliarioRelatorios.BCI.logradouroDe',
            'class' => SwLogradouro::class,
            'json_from_admin_code' => $this->code,
            'json_choice_label' => function (SwLogradouro $logradouro) {
                return $logradouro->getCodLogradouro()
                . " - "
                . $logradouro->getCurrentFkSwNomeLogradouro()
                . " - "
                . $logradouro->getFkSwBairroLogradouros()->last()->getFkSwBairro()->getNomBairro()
                . " - "
                . $logradouro->getFkSwMunicipio()->getNomMunicipio();
            },
            'json_query_builder' => function (EntityRepository $er, $term, Request $request) {
                $qb = $er->createQueryBuilder('o');
                $qb->leftJoin('o.fkSwBairroLogradouros', 'b');
                $qb->leftJoin('o.fkSwNomeLogradouros', 'n');
                $qb->leftJoin('n.fkSwTipoLogradouro', 't');
                $qb->where('o.codLogradouro = :codLogradouro');
                $qb->orWhere('LOWER(CONCAT(t.nomTipo, \' \', n.nomLogradouro)) LIKE :nomLogradouro');
                $qb->setParameter('codLogradouro', (int) $term);
                $qb->setParameter('nomLogradouro', sprintf('%%%s%%', strtolower($term)));
                return $qb;
            },
            'mapped' => false,
            'required' => false,
        );
        
        $fieldOptions['bairro'] = array(
            'label' => 'label.imobiliarioRelatorios.BCI.bairroDe',
            'class' => SwBairro::class,
            'choice_label' => 'nomBairro',
            'choice_value' => 'codBairro',
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => false,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('m')
                    ->where('m.codBairro != :codBairro')
                    ->setParameter('codBairro', self::NAO_INFORMADO);
            }
        );

        $formMapper
            ->with('label.imobiliarioRelatorios.BCI.titulo')
                ->add('inscricaoDe', 'entity', $fieldOptions['inscricaoImobiliaria'])
                ->add('inscricaoAte', 'entity', array_merge($fieldOptions['inscricaoImobiliaria'], ['label' => 'label.imobiliarioRelatorios.BCI.ate']))
                ->add('localizacaoDe', 'entity', $fieldOptions['localizacao'])
                ->add('localizacaoAte', 'entity', array_merge($fieldOptions['localizacao'], ['label' => 'label.imobiliarioRelatorios.BCI.ate']))
                ->add('logradouroDe', 'autocomplete', $fieldOptions['logradouro'])
                ->add('logradouroAte', 'autocomplete', array_merge($fieldOptions['logradouro'], ['label' => 'label.imobiliarioRelatorios.BCI.ate']))
                ->add('bairroDe', 'entity', $fieldOptions['bairro'])
                ->add('bairroAte', 'entity', array_merge($fieldOptions['bairro'], ['label' => 'label.imobiliarioRelatorios.BCI.ate']))
            ->end()
        ;
    }

    
    /**
     * @param mixed $object
     */
     public function prePersist($object)
     {
         $params = [
             'inscricaoDe' => $this->_getFormField($this->getForm(), 'inscricaoDe', 'getInscricaoMunicipal'),
             'inscricaoAte' => $this->_getFormField($this->getForm(), 'inscricaoAte', 'getInscricaoMunicipal'),
             'localizacaoDe' => $this->_getFormField($this->getForm(), 'localizacaoDe', 'getCodigoComposto'),
             'localizacaoAte' => $this->_getFormField($this->getForm(), 'localizacaoAte', 'getCodigoComposto'),
             'logradouroDe' => $this->_getFormField($this->getForm(), 'logradouroDe', 'getCodLogradouro'),
             'logradouroAte' => $this->_getFormField($this->getForm(), 'logradouroAte', 'getCodLogradouro'),
             'bairroDe' => $this->_getFormField($this->getForm(), 'bairroDe', 'getCodBairro'),
             'bairroAte' => $this->_getFormField($this->getForm(), 'bairroAte', 'getCodBairro')
         ];
         
         $this->forceRedirect($this->generateUrl('relatorio', $params));
     }
     
     /**
      * 
      * @param FormMapper $form
      * @param string $fieldName
      * @return mixed
      */
     private function _getFormField($form, $fieldName, $method)
     {
         $field = $form->get($fieldName);
         if (!is_null($field)) {
             $data = $field->getData();
             if (is_object($data)) {
                 return $data->$method();
             } else {
                 return $data;
             } 
         }
         return '';
     }
     
     public function parseValueToReport($value, $tipo)
     {
         $em = $this->modelManager->getEntityManager($this->getClass());
         switch ($tipo) {
             case "inscricao":
                 $retorno = $em->getRepository(Imovel::class)
                    ->findOneBy(["inscricaoMunicipal" => $value]);
                 $retornoStr = "{$retorno->getLote() } - {$retorno->getLocalizacao()} - {$retorno->getInscricaoMunicipal()}";
                 break;
             case "localizacao":
                 $retorno = $em->getRepository(Localizacao::class)
                 ->findOneBy(["cod_localizacao" => $value]);
                 $retornoStr = $retorno->__toString();
                 break;
             case "logradouro":
                 $retorno = $em->getRepository(SwLogradouro::class)
                 ->findOneBy(["codLogradouro" => $value]);
                 $retornoStr = $retorno->getCodLogradouro()." - ".$retorno->getCurrentFkSwNomeLogradouro()
                     ." - ".$retorno->getFkSwBairroLogradouros()->last()->getFkSwBairro()->getNomBairro()
                     ." - ".$retorno->getFkSwMunicipio()->getNomMunicipio();
                 break;
             case "bairro":
                 $retorno = $em->getRepository(SwBairro::class)
                 ->findOneBy(["codBairro" => $value]);
                 $retornoStr = $retorno->__toString();
                 break;
         }
         
         return $retornoStr;
     }
}
