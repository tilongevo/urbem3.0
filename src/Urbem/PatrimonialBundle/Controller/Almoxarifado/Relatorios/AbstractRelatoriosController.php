<?php

namespace Urbem\PatrimonialBundle\Controller\Almoxarifado\Relatorios;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\Form\Form;

use Urbem\CoreBundle\Entity\Administracao\Relatorio;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class AbstractRelatoriosController
 *
 * @package Urbem\PatrimonialBundle\Controller\Almoxarifado\Relatorios
 */
class AbstractRelatoriosController extends CRUDController
{
    const LAYOUT_REPORT_PATH = '/bundles/report/gestaoPatrimonial/fontes/RPT/almoxarifado/report/design/';

    /** @var AbstractSonataAdmin */
    protected $admin;

    /**
     * Configura os pametros 'default' que todos os relatórios de Processo devem conter.
     *
     * @param Relatorio $relatorio
     *
     * @return array
     */
    protected function configureDefaultReportParams(Relatorio $relatorio)
    {
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        $exercicio = $this->admin->getExercicio();

        return [
            'inCodGestao'        => $relatorio->getCodGestao(),
            'inCodModulo'        => $relatorio->getCodModulo(),
            'inCodRelatorio'     => $relatorio->getCodRelatorio(),
            'exercicio'          => $exercicio,
            'cod_acao'           => 1411,
        ];
    }

    /**
     * @return Form
     */
    protected function getForm()
    {
        $request = $this->getRequest();

        /** @var $form Form */
        $form = $this->admin->getForm();
        $form->setData($this->admin->getSubject());
        $form->handleRequest($request);

        return $form;
    }
}
