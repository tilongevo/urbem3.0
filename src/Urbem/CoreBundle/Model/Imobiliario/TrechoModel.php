<?php

namespace Urbem\CoreBundle\Model\Imobiliario;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;
use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Imobiliario\AtributoTrechoValor;
use Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoNivel;
use Urbem\CoreBundle\Entity\Imobiliario\Nivel;
use Urbem\CoreBundle\Entity\Imobiliario\Trecho;
use Urbem\CoreBundle\Entity\Imobiliario\TrechoAliquota;
use Urbem\CoreBundle\Entity\Imobiliario\TrechoValorM2;
use Urbem\CoreBundle\Entity\Imobiliario\Vigencia;
use Urbem\CoreBundle\Entity\Imobiliario\Localizacao;
use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;
use Urbem\CoreBundle\Repository\Imobiliario\TrechoRepository;

/**
 * Class TrechoModel
 * @package Urbem\CoreBundle\Model\Imobiliario
 */
class TrechoModel extends AbstractModel
{
    /**
     * @var ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var TrechoRepository
     */
    protected $repository;

    /**
     * NivelModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Trecho::class);
    }

    /**
     * @param Trecho $trecho
     * @return bool
     */
    public function verificaBaixa(Trecho $trecho)
    {
        $baixa = $trecho->getFkImobiliarioBaixaTrechos()->filter(
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
                    'codCadastro' => Cadastro::CADASTRO_TRIBUTARIO_TRECHO
                )
            );
        return ($caracteristicas) ? true : false;
    }

    /**
     * @param int $codLogradouro
     * @return int
     */
    public function getCodTrecho($codLogradouro)
    {
        /** @var Trecho $last */
        $last = $this->repository->findOneByCodLogradouro($codLogradouro, array('codTrecho' => 'DESC'));
        return ($last) ? $last->getCodTrecho() + 1 : 1;
    }

    /**
     * @param Trecho $trecho
     * @param $atributosDinamicos
     * @return bool|\Exception
     */
    public function atributoDinamico(Trecho $trecho, $atributosDinamicos)
    {
        try {
            $em = $this->entityManager;
            $atributoDinamicoModel = new AtributoDinamicoModel($em);

            $atributoTrechoValores = array();
            if ($trecho->getFkImobiliarioAtributoTrechoValores()->count()) {
                /** @var AtributoTrechoValor $atributoTrechoValor */
                foreach ($trecho->getFkImobiliarioAtributoTrechoValores() as $atributoTrechoValor) {
                    $atributoTrechoValores[$atributoTrechoValor->getCodAtributo()] = $atributoTrechoValor;
                }
            }

            foreach ($atributosDinamicos as $codAtributo => $valorAtributo) {
                if (isset($atributoTrechoValores[$codAtributo])) {
                    $atributoTrechoValor = $atributoTrechoValores[$codAtributo];

                    $valor = $atributoDinamicoModel
                        ->processaAtributoDinamicoPersist(
                            $atributoTrechoValor,
                            $valorAtributo
                        );

                    $atributoTrechoValor->setValor($valor);
                    $em->persist($atributoTrechoValor);
                } else {
                    /** @var AtributoDinamico $atributoDinamico */
                    $atributoDinamico = $em->getRepository(AtributoDinamico::class)
                        ->findOneBy(
                            array(
                                'codModulo' => Modulo::MODULO_CADASTRO_IMOBILIARIO,
                                'codCadastro' => Cadastro::CADASTRO_TRIBUTARIO_TRECHO,
                                'codAtributo' => $codAtributo
                            )
                        );

                    $atributoTrechoValor = new AtributoTrechoValor();
                    $atributoTrechoValor->setFkAdministracaoAtributoDinamico($atributoDinamico);

                    $valor = $atributoDinamicoModel
                        ->processaAtributoDinamicoPersist(
                            $atributoTrechoValor,
                            $valorAtributo
                        );

                    $atributoTrechoValor->setValor($valor);
                    $trecho->addFkImobiliarioAtributoTrechoValores($atributoTrechoValor);
                }
                $em->flush();
                return true;
            }
        } catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * @param Localizacao $localizacao
     * @param $codVigencia
     * @param $codNivel
     * @param Localizacao|null $superior
     * @return bool|\Exception
     */
    public function salvarLocalizacao(Localizacao $localizacao, $codVigencia, $codNivel, $codigo, Localizacao $superior = null)
    {
        try {
            /** @var Vigencia $vigencia */
            $vigencia = $this->entityManager->getRepository(Vigencia::class)->find($codVigencia);

            $codigoComposto = array();

            $niveis = $vigencia->getFkImobiliarioNiveis()->getValues();
            krsort($niveis);

            /** @var Nivel $nivel */
            foreach ($niveis as $nivel) {
                $localizacaoNivel = new LocalizacaoNivel();
                if ($nivel->getCodNivel() > $codNivel) {
                    $valor = str_pad('0', strlen($nivel->getMascara()), '0', STR_PAD_LEFT);
                    $localizacaoNivel->setValor((int) $valor);
                } elseif ($nivel->getCodNivel() == $codNivel) {
                    $valor = str_pad((string) $codigo, strlen($nivel->getMascara()), '0', STR_PAD_LEFT);
                    $localizacaoNivel->setValor((int) $valor);
                } else {
                    $valor = str_pad((string) $this->getValorLocalizacao($superior), strlen($nivel->getMascara()), '0', STR_PAD_LEFT);
                    $localizacaoNivel->setValor((int) $valor);
                    if ($nivel->getCodNivel() != 1) {
                        $superior = $this->getLocalizacaoSuperior($superior, $nivel);
                    }
                }

                $localizacaoNivel->setFkImobiliarioNivel($nivel);
                $localizacao->addFkImobiliarioLocalizacaoNiveis($localizacaoNivel);
                $codigoComposto[$nivel->getCodNivel()] = $valor;
            }
            ksort($codigoComposto);
            $localizacao->setCodigoComposto(implode('.', $codigoComposto));
            return true;
        } catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * @param Localizacao $localizacao
     * @param $codigo
     * @return bool|\Exception
     */
    public function atualizarLocalizacao(Localizacao $localizacao, $codigo)
    {
        try {
            $nivel = $this->getNivel($localizacao);

            /** @var LocalizacaoNivel $localizacaoNivel */
            foreach ($localizacao->getFkImobiliarioLocalizacaoNiveis() as $localizacaoNivel) {
                if ($localizacaoNivel->getCodNivel() == $nivel->getCodNivel()) {
                    $valor = str_pad((string) $codigo, strlen($nivel->getMascara()), '0', STR_PAD_LEFT);
                    $localizacaoNivel->setValor((int) $codigo);
                    $this->entityManager->persist($localizacaoNivel);
                    $this->entityManager->flush();
                } else {
                    $valor = str_pad((string) $localizacaoNivel->getValor(), strlen($localizacaoNivel->getFkImobiliarioNivel()->getMascara()), '0', STR_PAD_LEFT);
                }

                $codigoComposto[$localizacaoNivel->getCodNivel()] = $valor;
            }
            ksort($codigoComposto);
            $localizacao->setCodigoComposto(implode('.', $codigoComposto));
            $this->entityManager->persist($localizacao);
            return true;
        } catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * @param Trecho $trecho
     * @param $form
     */
    public function insereValorMD(Trecho $trecho, $form)
    {
        $trechoValorM2 = new TrechoValorM2();
        $trechoValorM2->setValorM2Territorial($form->get('fkImobiliarioTrechoValorM2s__valorM2Territorial')->getData());
        $trechoValorM2->setValorM2Predial($form->get('fkImobiliarioTrechoValorM2s__valorM2Predial')->getData());
        $trechoValorM2->setDtVigencia($form->get('fkImobiliarioTrechoValorM2s__dtVigencia')->getData());
        $trechoValorM2->setFkNormasNorma($form->get('fkImobiliarioTrechoValorM2s__fkNormasNorma')->getData());
        $trecho->addFkImobiliarioTrechoValorM2s($trechoValorM2);
    }

    /**
     * @param Trecho $trecho
     * @param $form
     */
    public function insereAliquota(Trecho $trecho, $form)
    {
        $trechoAliquota = new TrechoAliquota();
        $trechoAliquota->setAliquotaTerritorial($form->get('fkImobiliarioTrechoAliquotas__aliquotaTerritorial')->getData());
        $trechoAliquota->setAliquotaPredial($form->get('fkImobiliarioTrechoAliquotas__aliquotaPredial')->getData());
        $trechoAliquota->setDtVigencia($form->get('fkImobiliarioTrechoAliquotas__dtVigencia')->getData());
        $trechoAliquota->setFkNormasNorma($form->get('fkImobiliarioTrechoAliquotas__fkNormasNorma')->getData());
        $trecho->addFkImobiliarioTrechoAliquotas($trechoAliquota);
    }


    /**
     * @return mixed
     */
    public function filtraTrecho($params)
    {
        return $this->repository->filtraTrecho($params);
    }

    /**
     * @param $codTrecho
     * @param $codLogradouro
     * @return array
     */
    public function getFaceQuadraByTrecho($codTrecho, $codLogradouro)
    {
        return $this->repository->getFaceQuadraByTrecho($codTrecho, $codLogradouro);
    }
}
