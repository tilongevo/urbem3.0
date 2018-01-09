<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Administracao;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractOrganogramaSonata as AbstractAdmin;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Entity\SonataReport;
use Urbem\CoreBundle\Entity\Administracao\Gestao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Relatorio;

/**
 * Class UsuarioRelatorioAdmin
 *
 * @package Urbem\AdministrativoBundle\Resources\config\Sonata\Administracao
 */

class UsuarioRelatorioAdmin extends AbstractAdmin
{
    const ORDENACAO_CGM = "sw_cgm.numcgm";
    const ORDENACAO_NOME = "sw_cgm.nom_cgm";
    const ORDENACAO_USERNAME = "usuario.usename";
    const ORDENACAO_ORGAO = "descricao";
    const COD_ACAO = 28;
    const ORDENACAO_PREFIX = "+ORDER+BY+";
    
    protected $baseRouteName = 'urbem_administrativo_administracao_usuarios_relatorio';
    protected $baseRoutePattern = 'administrativo/administracao/usuarios/relatorio';
    protected $layoutDefaultReport = '/bundles/report/gestaoAdministrativa/fontes/RPT/administracao/report/design/usuario.rptdesign';
    
    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
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
        
        $formMapper->with("label.relatorioUsuario.titulo");
        
        $fieldOptions = array();
        
        $this->createFormOrganograma($formMapper, true);
        
        $ordenacoes = [
            self::ORDENACAO_CGM => "label.relatorioUsuario.ordenacaoOptions.cgm",
            self::ORDENACAO_NOME => "label.relatorioUsuario.ordenacaoOptions.nome",
            self::ORDENACAO_USERNAME => "label.relatorioUsuario.ordenacaoOptions.username",
            self::ORDENACAO_ORGAO => "label.relatorioUsuario.ordenacaoOptions.orgao"
        ];
        
        $fieldOptions['ordenacao'] = [
            'label' => 'label.relatorioUsuario.ordenacao',
            'placeholder' => 'label.selecione',
            'choices' => array_flip($ordenacoes),
            'data' => self::ORDENACAO_CGM,
            'mapped' => false,
            'required' => true
        ];
        
        $formMapper
            ->add('ordenacao', 'choice', $fieldOptions['ordenacao'])
            ->end()
        ;
    }
    
    
    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $exercicio = $this->getExercicio();
        $fileName = $this->parseNameFile("relatorioUsuario");
        $ordenacao = $this->getForm()->get('ordenacao')->getData();
        $pCodOrgao = $this->getOrgaoSelected()->getCodOrgao();
        
        $params = [
            'term_user' => $this->getCurrentUser()->getUserName(),
            'cod_acao' => self::COD_ACAO,
            'exercicio' => $exercicio,
            'inCodGestao' => Gestao::GESTAO_ADMINISTRATIVA,
            'inCodModulo' => Modulo::MODULO_ADMINISTRATIVO ,
            'inCodRelatorio' => Relatorio::ADMINISTRACAO_USUARIO,
            'pCodOrgao' => $pCodOrgao,
            'pOrderBy' =>  self::ORDENACAO_PREFIX.(!empty($ordenacao) ? $ordenacao : "")
        ];
        
        $apiService = $this->getReportService();
        $apiService->setReportNameFile($fileName);
        $apiService->setLayoutDefaultReport($this->layoutDefaultReport);
        $res = $apiService->getReportContent($params);

        $this->parseContentToPdf(
            $res->getBody()->getContents(),
            $fileName
        );
    }
    
}
