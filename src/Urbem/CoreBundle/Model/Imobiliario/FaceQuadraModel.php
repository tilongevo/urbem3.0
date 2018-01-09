<?php

namespace Urbem\CoreBundle\Model\Imobiliario;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;
use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Imobiliario\AtributoFaceQuadraValor;
use Urbem\CoreBundle\Entity\Imobiliario\FaceQuadra;
use Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraAliquota;
use Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraTrecho;
use Urbem\CoreBundle\Entity\Imobiliario\FaceQuadraValorM2;
use Urbem\CoreBundle\Entity\Imobiliario\Trecho;
use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;

class FaceQuadraModel extends AbstractModel
{
    /**
     * @var ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var ORM\EntityRepository
     */
    protected $repository;

    /**
     * NivelModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(FaceQuadra::class);
    }

    /**
     * @param FaceQuadra $faceQuadra
     * @return bool
     */
    public function verificaBaixa(FaceQuadra $faceQuadra)
    {
        $baixa = $faceQuadra->getFkImobiliarioBaixaFaceQuadras()->filter(
            function ($entry) {
                if (!$entry->getDtTermino()) {
                    return $entry;
                }
            }
        );
        return ($baixa->count()) ? true : false;
    }

    /**
     * @return bool
     */
    public function verificaCaracteristicas()
    {
        $caracteristicas = $this
            ->entityManager
            ->getRepository(AtributoDinamico::class)
            ->findOneBy(
                array(
                    'codModulo' => Modulo::MODULO_CADASTRO_IMOBILIARIO,
                    'codCadastro' => Cadastro::CADASTRO_TRIBUTARIO_FACE_QUADRA
                )
            );
        return ($caracteristicas) ? true : false;
    }

    /**
     * @param int $codLocalizacao
     * @return int
     */
    public function getProximoCodFaceQuadra($codLocalizacao)
    {
        /** @var FaceQuadra $lastFaceQuadra */
        $lastFaceQuadra = $this->repository->findOneByCodLocalizacao($codLocalizacao, array('codFace' => 'DESC'));
        return ($lastFaceQuadra) ? $lastFaceQuadra->getCodFace() + 1 : 1;
    }

    /**
     * @param int $codLocalizacao
     * @param int $codTrecho
     * @param int $codLogradouro
     * @param null $codFace
     * @return bool
     */
    public function consultaFaceQuadraTrecho($codLocalizacao, $codTrecho, $codLogradouro, $codFace = null)
    {
        $em = $this->entityManager;

        $params = array(
            'codLocalizacao' => $codLocalizacao,
            'codTrecho' => $codTrecho,
            'codLogradouro' => $codLogradouro
        );

        $qb = $em->getRepository(FaceQuadraTrecho::class)->createQueryBuilder('o');
        $qb->select('count(o)');
        $qb->where('o.codLocalizacao = :codLocalizacao');
        $qb->andWhere('o.codTrecho = :codTrecho');
        $qb->andWhere('o.codLogradouro = :codLogradouro');
        if ($codFace) {
            $qb->andWhere('o.codFace != :codFace');
            $params['codFace'] = $codFace;
        }
        $qb->setParameters($params);
        $result = $qb->getQuery()->getSingleScalarResult();

        return ($result) ? true : false;
    }

    /**
     * @param FaceQuadra $faceQuadra
     * @param array $trechos
     */
    public function faceQuadraTrechos(FaceQuadra $faceQuadra, $trechos)
    {
        $em = $this->entityManager;

        $faceQuadraTrechos = array();
        if ($faceQuadra->getFkImobiliarioFaceQuadraTrechos()->count()) {
            /** @var FaceQuadraTrecho $faceQuadraTrecho */
            foreach ($faceQuadra->getFkImobiliarioFaceQuadraTrechos() as $faceQuadraTrecho) {
                $key = sprintf('%s~%s', $faceQuadraTrecho->getCodTrecho(), $faceQuadraTrecho->getCodLogradouro());
                if (array_key_exists($key, $trechos)) {
                    unset($trechos[$key]);
                } else {
                    $em->remove($faceQuadraTrecho);
                }
                $faceQuadraTrechos[$key] = $faceQuadraTrecho;
            }
        }

        foreach ($trechos as $codTrecho) {
            list($codTrecho, $codLogradouro) = explode('~', $codTrecho);
            /** @var Trecho $trecho */
            $trecho = $this
                ->entityManager
                ->getRepository(Trecho::class)
                ->findOneBy(
                    array(
                        'codTrecho' => $codTrecho,
                        'codLogradouro' => $codLogradouro
                    )
                );
            $faceQuadraTrecho = new FaceQuadraTrecho();
            $faceQuadraTrecho->setFkImobiliarioTrecho($trecho);
            $faceQuadra->addFkImobiliarioFaceQuadraTrechos($faceQuadraTrecho);
        }
    }

    /**
     * @param FaceQuadra $faceQuadra
     * @param $atributosDinamicos
     * @return bool|\Exception
     */
    public function atributoDinamico(FaceQuadra $faceQuadra, $atributosDinamicos)
    {
        try {
            $em = $this->entityManager;
            $atributoDinamicoModel = new AtributoDinamicoModel($em);

            $atributoFaceQuadraValores = array();
            if ($faceQuadra->getFkImobiliarioAtributoFaceQuadraValores()->count()) {
                /** @var AtributoFaceQuadraValor $atributoFaceQuadraValor */
                foreach ($faceQuadra->getFkImobiliarioAtributoFaceQuadraValores() as $atributoFaceQuadraValor) {
                    $atributoFaceQuadraValores[$atributoFaceQuadraValor->getCodAtributo()] = $atributoFaceQuadraValor;
                }
            }

            foreach ($atributosDinamicos as $codAtributo => $valorAtributo) {
                if (isset($atributoFaceQuadraValores[$codAtributo])) {
                    $atributoFaceQuadraValor = $atributoFaceQuadraValores[$codAtributo];

                    $valor = $atributoDinamicoModel
                        ->processaAtributoDinamicoPersist(
                            $atributoFaceQuadraValor,
                            $valorAtributo
                        );

                    $atributoFaceQuadraValor->setValor($valor);
                    $em->persist($atributoFaceQuadraValor);
                } else {
                    /** @var AtributoDinamico $atributoDinamico */
                    $atributoDinamico = $em->getRepository(AtributoDinamico::class)
                        ->findOneBy(
                            array(
                                'codModulo' => Modulo::MODULO_CADASTRO_IMOBILIARIO,
                                'codCadastro' => Cadastro::CADASTRO_TRIBUTARIO_FACE_QUADRA,
                                'codAtributo' => $codAtributo
                            )
                        );

                    $atributoFaceQuadraValor = new AtributoFaceQuadraValor();
                    $atributoFaceQuadraValor->setFkAdministracaoAtributoDinamico($atributoDinamico);

                    $valor = $atributoDinamicoModel
                        ->processaAtributoDinamicoPersist(
                            $atributoFaceQuadraValor,
                            $valorAtributo
                        );

                    $atributoFaceQuadraValor->setValor($valor);
                    $faceQuadra->addFkImobiliarioAtributoFaceQuadraValores($atributoFaceQuadraValor);
                }
            }
            $em->flush();
            return true;
        } catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * @param FaceQuadra $faceQuadra
     * @param $form
     */
    public function insereValorMD(FaceQuadra $faceQuadra, $form)
    {
        $faceQuadraValorM2 = new FaceQuadraValorM2();
        $faceQuadraValorM2->setValorM2Territorial($form->get('fkImobiliarioFaceQuadraValorM2s__valorM2Territorial')->getData());
        $faceQuadraValorM2->setValorM2Predial($form->get('fkImobiliarioFaceQuadraValorM2s__valorM2Predial')->getData());
        $faceQuadraValorM2->setDtVigencia($form->get('fkImobiliarioFaceQuadraValorM2s__dtVigencia')->getData());
        $faceQuadraValorM2->setFkNormasNorma($form->get('fkImobiliarioFaceQuadraValorM2s__fkNormasNorma')->getData());
        $faceQuadra->addFkImobiliarioFaceQuadraValorM2s($faceQuadraValorM2);
    }

    /**
     * @param FaceQuadra $faceQuadra
     * @param $form
     */
    public function insereAliquota(FaceQuadra $faceQuadra, $form)
    {
        $faceQuadraAliquota = new FaceQuadraAliquota();
        $faceQuadraAliquota->setAliquotaTerritorial($form->get('fkImobiliarioFaceQuadraAliquotas__aliquotaTerritorial')->getData());
        $faceQuadraAliquota->setAliquotaPredial($form->get('fkImobiliarioFaceQuadraAliquotas__aliquotaPredial')->getData());
        $faceQuadraAliquota->setDtVigencia($form->get('fkImobiliarioFaceQuadraAliquotas__dtVigencia')->getData());
        $faceQuadraAliquota->setFkNormasNorma($form->get('fkImobiliarioFaceQuadraAliquotas__fkNormasNorma')->getData());
        $faceQuadra->addFkImobiliarioFaceQuadraAliquotas($faceQuadraAliquota);
    }
}
