<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Compras;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Compras;

class LicitacaoCotacaoFornecedorItemAdmin extends CotacaoFornecedorItemAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_licitacao_cotacao_fornecedor_item';

    protected $baseRoutePattern = 'patrimonial/licitacao/cotacao-fornecedor-item';

    public function postUpdate($object)
    {
        $this->redirect($object, $this->trans('patrimonial.cotacaoFornecedorItem.update', [], 'flashes'));
    }

    public function redirect($object)
    {
        $em = $this->modelManager->getEntityManager('CoreBundle:Licitacao\CotacaoLicitacao');
        $cotacaoLicitacao = $em->getRepository('CoreBundle:Licitacao\CotacaoLicitacao')->findOneBy([
            'codCotacao' => $object->getCodCotacao(),
            'exercicioCotacao' => $this->getForm()->get('exercicioCotacao')->getData()
        ]);
        $id = $cotacaoLicitacao->getCodLicitacao().'~'.$cotacaoLicitacao->getCodModalidade().
            '~'.$cotacaoLicitacao->getCodEntidade().'~'.$cotacaoLicitacao->getExercicioLicitacao();

        $this->forceRedirect("/patrimonial/licitacao/manutencao-proposta/$id/edit");
    }
}
