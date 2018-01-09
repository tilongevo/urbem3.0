<?php
namespace Urbem\RecursosHumanosBundle\Controller\FolhaPagamento;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Urbem\CoreBundle\Entity\Folhapagamento\Fgts;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Urbem\CoreBundle\Entity\Folhapagamento\FgtsCategoria;
use Urbem\CoreBundle\Entity\Folhapagamento\FgtsEvento;
use Urbem\RecursosHumanosBundle\Form\FolhaPagamento\FgtsCategoriaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Urbem\CoreBundle\Model;

/**
 * Folhapagamento\Fgts controller.
 *
 */
class FgtsController extends ControllerCore\BaseController
{
    /**
     * Lists all Folhapagamento\Fgts entities.
     *
     */
    public function indexAction()
    {
        $this->setBreadCrumb();
        $em = $this->getDoctrine()->getManager();
        $fgts = (new Model\Folhapagamento\FgtsModel($em))
            ->getRecord();
        return $this->render(
            'RecursosHumanosBundle:FolhaPagamento/Fgts:index.html.twig',
            array(
                'fgts' => $fgts,
            )
        );
    }

    /**
     * Creates a new Folhapagamento\Fgts entity.
     *
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $fgts = (new Model\Folhapagamento\FgtsModel($em))
            ->getRecord();

        if (count($fgts) >= 1) {
            return $this->configuracaoCriadaAction();
        }

        $fgts = new Fgts();
        $form = $this->createFormBuilder(array())
            ->add(
                'codEvento1',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:Folhapagamento\Evento',
                    'choice_label' => 'descricao',
                    'choice_value' => 'codEvento',
                )
            )
            ->add(
                'codEvento2',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:Folhapagamento\Evento',
                    'choice_label' => 'descricao',
                    'choice_value' => 'codEvento',
                )
            )
            ->add(
                'codEvento3',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:Folhapagamento\Evento',
                    'choice_label' => 'descricao',
                    'choice_value' => 'codEvento',
                )
            )
            ->add(
                'codCategoria',
                CollectionType::class,
                array(
                    'entry_type' => FgtsCategoriaType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true,
                    'by_reference' => false,
                )
            )
            ->add(
                'vigencia',
                DateType::class,
                [
                    'html5' => false,
                    'widget' => 'single_text',
                    'attr' => [
                        'class' => 'datepicker',
                        'data-provide' => 'datepicker',
                    ]
                ]
            )
            ->add(
                'btnAddCategoria',
                ButtonType::class
            )
            ->setAction($this->generateUrl('folhapagamento_fgts_new', array(
                'fgts' => $fgts,
            )))
            ->getForm();

        $form->handleRequest($request);

        $this->setBreadCrumb();

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $request->request->get('form');

            try {
                $fgts->setVigencia(new \DateTime($data['vigencia']));
                $em->persist($fgts);
                $em->flush();

                $codFgts = $fgts->getCodFgts();

                for ($i = 1; $i <= 3; $i++) {
                    $fgtsEvento = new FgtsEvento();

                    $tipoEvento = (new Model\Folhapagamento\TipoEventoFgtsModel($em))->gettipoEventoFgtsByCodTipo($i);

                    $fgtsEvento->setCodTipo($tipoEvento);
                    $fgtsEvento->setCodFgts($codFgts);

                    $evento = (new Model\Folhapagamento\EventoModel($em))->getEventoByCodEvento($data['codEvento' . $i]);

                    $fgtsEvento->setCodEvento($evento);

                    $em->persist($fgtsEvento);
                    $em->flush();
                }

                if (isset($data['codCategoria'])) {
                    foreach ($data['codCategoria'] as $key => $value) {
                        $fgtsCategoria = new FgtsCategoria();
                        $fgtsCategoria->setCodFgts($codFgts);

                        $categoria = (new Model\Pessoal\CategoriaModel($em))
                            ->getCategoriaByCodCategoria($value['cod_categoria']);

                        $fgtsCategoria->setCodCategoria($categoria);
                        $fgtsCategoria->setAliquotaDeposito($value['aliquota_deposito']);
                        $fgtsCategoria->setAliquotaContribuicao($value['aliquota_contribuicao']);

                        $em->persist($fgtsCategoria);
                        $em->flush();
                    }
                }
            } catch (Exception $e) {
                print_r($e->getMessage());
            }
        }

        return $this->render(
            'RecursosHumanosBundle:FolhaPagamento/Fgts:new.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

    public function configuracaoCriadaAction()
    {
        $this->setBreadCrumb();
        return $this->render(
            'RecursosHumanosBundle:FolhaPagamento/Fgts/configuracao_criada.html.twig'
        );
    }

    /**
     * Finds and displays a Folhapagamento\Fgts entity.
     *
     */
    public function showAction(Request $request)
    {
        $this->setBreadCrumb();
        $form = $this->createFormBuilder(array())
            ->add(
                'vigencia',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:Folhapagamento\Fgts',
                    'choice_label' => function ($fgts) {
                        return $fgts->getVigencia()->format('d/m/Y');
                    },
                    'choice_value' => 'codFgts',
                )
            )
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $request->request->get('form');
            $em = $this->getDoctrine()->getManager();
            $fgts = (new Model\Folhapagamento\FgtsModel($em))
                ->getFgtsByCodFgts($data['vigencia']);

            return $this->render(
                'RecursosHumanosBundle:FolhaPagamento/Fgts/show.html.twig',
                array(
                    'form' => $form->createView(),
                    'fgts' => $fgts,
                )
            );
        }

        return $this->render(
            'RecursosHumanosBundle:FolhaPagamento/Fgts/show.html.twig',
            array(
                'form' => $form->createView(),
                'fgts' => null,
            )
        );
    }

    /**
     * Displays a form to edit an existing Folhapagamento\Fgts entity.
     *
     */
    public function editAction(Request $request, Fgts $fgts)
    {

        $this->setBreadCrumb(array('id' => $fgts->getCodFgts()));

        $em = $this->getDoctrine()->getManager();

        $categoriaForm = (new Model\Folhapagamento\FgtsCategoriaModel($em))
            ->getFgtsByCodFgts($fgts->getCodFgts());

        $eventoForm = (new Model\Folhapagamento\FgtsEventoModel($em))
            ->getFgtsByCodFgts($fgts->getCodFgts());

        $eventoArray = array();

        foreach ($eventoForm as $evento) {
            $eventoArray[] = $evento->getCodEvento()->getCodEvento();
        }

        $evento = (new Model\Folhapagamento\EventoModel($em))->getAll();

        $categoria = (new Model\Pessoal\CategoriaModel($em))->getAll();

        $form = $this->createForm('Urbem\RecursosHumanosBundle\Form\FolhaPagamento\FgtsType', $fgts);

        $form->handleRequest($request);

        $formEdit = $this->createFormBuilder(array())
            ->setAction($this->generateUrl('folhapagamento_fgts_edit', array('id' => $fgts->getCodFgts()
            )))->getForm();
        $formEdit->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $data = $request->request->all();

                $this->removeFgtsEvento($eventoForm);
                $this->removeFgtsCategoria($categoriaForm);

                foreach ($data['form']['evento'] as $key => $evento) {
                    $fgtsEvento = new FgtsEvento();

                    $tipoEvento = (new Model\Folhapagamento\TipoEventoFgtsModel($em))->gettipoEventoFgtsByCodTipo($key);

                    $fgtsEvento->setCodTipo($tipoEvento);
                    $fgtsEvento->setCodFgts($fgts->getCodFgts());

                    $evento = (new Model\Folhapagamento\EventoModel($em))->getEventoByCodEvento($evento);

                    $fgtsEvento->setCodEvento($evento);

                    $em->persist($fgtsEvento);
                    $em->flush();
                }

                foreach ($data['form']['categoria'] as $key => $cat) {
                    $fgtsCategoria = new FgtsCategoria();
                    $fgtsCategoria->setCodFgts($fgts->getCodFgts());

                    $categoria = (new Model\Pessoal\CategoriaModel($em))
                        ->getCategoriaByCodCategoria($cat['codCategoria']);

                    $fgtsCategoria->setCodCategoria($categoria);
                    $fgtsCategoria->setAliquotaDeposito($cat['aliquotaDeposito']);
                    $fgtsCategoria->setAliquotaContribuicao($cat['aliquotaContribuicao']);

                    $em->persist($fgtsCategoria);
                    $em->flush();
                }

                /*
                 * CASO ADICIONE NOVAS CATEGORIAS IRÁ ENTRAR ENTRAR NO LOOP ABAIXO
                 */
                if (isset($data['fgts']['codCategoria'])) {
                    foreach ($data['fgts']['codCategoria'] as $key => $cat) {
                        $fgtsCategoria = new FgtsCategoria();
                        $fgtsCategoria->setCodFgts($fgts->getCodFgts());

                        $categoria = (new Model\Pessoal\CategoriaModel($em))
                            ->getCategoriaByCodCategoria($cat['cod_categoria']);

                        $fgtsCategoria->setCodCategoria($categoria);
                        $fgtsCategoria->setAliquotaDeposito($cat['aliquota_deposito']);
                        $fgtsCategoria->setAliquotaContribuicao($cat['aliquota_contribuicao']);

                        $em->persist($fgtsCategoria);
                        $em->flush();
                    }
                }
                $request->getSession()->getFlashBag()->add('success', "Salvo com sucesso!");
            } catch (Exception $e) {
                $em->getConnection()->rollback();
                $request->getSession()->getFlashBag()->add('error', "Erro ao gravar!");
                throw $e;
            }

            return $this->redirectToRoute('folhapagamento_fgts_index');
        }

        return $this->render('RecursosHumanosBundle:FolhaPagamento/Fgts/edit.html.twig', array(
            'form' => $form->createView(),
            'formEdit' => $formEdit->createView(),
            'categoria_form' => $categoriaForm,
            'eventoSelecionado' => $eventoArray,
            'evento' => $evento,
            'categoria' => $categoria,
        ));
    }

    public function removeFgtsEvento(array $evento)
    {
        $em = $this->getDoctrine()->getManager();
        foreach ($evento as $ev) {
            $em->remove($ev);
        }
        $em->flush();
    }

    public function removeFgtsCategoria(array $categoria)
    {
        $em = $this->getDoctrine()->getManager();
        foreach ($categoria as $cat) {
            $em->remove($cat);
        }
        $em->flush();
    }

    /**
     * Deletes a Folhapagamento\Fgts entity.
     *
     */
    public function deleteAction(Request $request, Fgts $fgts)
    {
        $form = $this->createDeleteForm($fgts);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fgts);
            $em->flush();
        }

        return $this->redirectToRoute('folhapagamento_fgts_index');
    }

    /**
     * Creates a form to delete a Folhapagamento\Fgts entity.
     *
     * @param Fgts $folhapagamento \Fgt The Folhapagamento\Fgts entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Fgts $fgts)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('folhapagamento_fgts_delete', array('id' => $fgts->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
