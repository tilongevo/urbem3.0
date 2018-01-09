<?php

namespace Urbem\CoreBundle\Model\Imobiliario;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Imobiliario\AtributoNivel;
use Urbem\CoreBundle\Entity\Imobiliario\AtributoNivelValor;
use Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoAliquota;
use Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoNivel;
use Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoValorM2;
use Urbem\CoreBundle\Entity\Imobiliario\Nivel;
use Urbem\CoreBundle\Entity\Imobiliario\Vigencia;
use Urbem\CoreBundle\Entity\Imobiliario\Localizacao;
use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;

class LocalizacaoModel extends AbstractModel
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
        $this->repository = $this->entityManager->getRepository(Localizacao::class);
    }

    /**
     * @param Localizacao $localizacao
     * @return Nivel
     */
    public function getNivel(Localizacao $localizacao)
    {
        $codVigencia = $localizacao->getFkImobiliarioLocalizacaoNiveis()->current()->getCodVigencia();
        $arr = explode('.', $localizacao->getCodigoComposto());
        krsort($arr);
        $codNivel = 1;
        foreach ($arr as $key => $value) {
            if ((int) $value) {
                $codNivel = $key + 1;
                break;
            }
        }
        /** @var Nivel $nivel */
        $nivel = $this
            ->entityManager
            ->getRepository(Nivel::class)
            ->findOneBy(
                array(
                    'codNivel' => $codNivel,
                    'codVigencia' => $codVigencia
                )
            );
        return $nivel;
    }

    /**
     * @param Localizacao $localizacao
     * @param Nivel $nivel
     * @return null|Localizacao
     */
    public function getLocalizacaoSuperior(Localizacao $localizacao, Nivel $nivel)
    {
        $arr = explode('.', $localizacao->getCodigoComposto());
        $codLocalizacao = null;
        foreach ($arr as $key => $value) {
            if (($nivel->getCodNivel() - 1) == ($key + 1)) {
                $codLocalizacao = $this
                    ->repository
                    ->getLocalizacaoSuperior(
                        $nivel->getCodVigencia(),
                        ($key + 1),
                        $value,
                        (int) $value
                    );
            }
        }
        if ($codLocalizacao) {
            /** @var Localizacao $localizacao */
            $localizacao = $this->repository->find($codLocalizacao);
            return $localizacao;
        } else {
            return null;
        }
    }

    /**
     * @param Localizacao $localizacao
     * @return string
     */
    public function getValorLocalizacao(Localizacao $localizacao)
    {
        $nivel = $this->getNivel($localizacao);
        /** @var LocalizacaoNivel $localizacaoNivel */
        foreach ($localizacao->getFkImobiliarioLocalizacaoNiveis() as $localizacaoNivel) {
            if ($localizacaoNivel->getFkImobiliarioNivel() === $nivel) {
                return $localizacaoNivel->getValor();
            }
        }
    }

    /**
     * @param Nivel $nivel
     * @param $codigo
     * @param Localizacao|null $localizacao
     * @return bool
     */
    public function verificaCodigo(Nivel $nivel, $codigo, Localizacao $localizacao = null)
    {
        $codigoComposto = array();
        if ($localizacao) {
            $codigoAntigo = $this->getValorLocalizacao($localizacao);
            if ($codigoAntigo == $codigo) {
                return false;
            }
            $arr = explode('.', $localizacao->getCodigoComposto());
            foreach ($arr as $key => $value) {
                if (($key + 1) == $nivel->getCodNivel()) {
                    $codigoComposto[$key + 1] = str_pad($codigo, strlen($nivel->getMascara()), '0', STR_PAD_LEFT);
                } else {
                    $codigoComposto[$key + 1] = $value;
                }
            }
            $codigoComposto = implode('.', $codigoComposto);
        } else {
            /** @var Nivel $fkImobiliarioNivel */
            foreach ($nivel->getFkImobiliarioVigencia()->getFkImobiliarioNiveis() as $fkImobiliarioNivel) {
                if ($nivel->getCodNivel() == $fkImobiliarioNivel->getCodNivel()) {
                    $codigoComposto[$fkImobiliarioNivel->getCodNivel()] = str_pad($codigo, strlen($fkImobiliarioNivel->getMascara()), '0', STR_PAD_LEFT);
                } else {
                    $codigoComposto[$fkImobiliarioNivel->getCodNivel()] = str_pad('0', strlen($fkImobiliarioNivel->getMascara()), '0', STR_PAD_LEFT);
                }
            }
            $codigoComposto = implode('.', $codigoComposto);
        }

        $localizacao = $this->repository->findOneByCodigoComposto($codigoComposto);
        return ($localizacao) ? true : false;
    }

    /**
     * @param Localizacao $localizacao
     * @return string
     */
    public function getCodigoReduzido(Localizacao $localizacao)
    {
        $nivel = $this->getNivel($localizacao);
        $arr = explode('.', $localizacao->getCodigoComposto());
        foreach ($arr as $key => $value) {
            $codigoComposto[$key + 1] = $value;
            if (($key + 1) == $nivel->getCodNivel()) {
                break;
            }
        }
        return implode('.', $codigoComposto);
    }

    /**
     * @param Localizacao $localizacao
     * @return bool
     */
    public function verificaDependentes(Localizacao $localizacao)
    {
        $codigoReduzido = $this->getCodigoReduzido($localizacao);

        $dependentes = $this
            ->repository
            ->getDependentes(
                $localizacao->getFkImobiliarioLocalizacaoNiveis()->current()->getCodVigencia(),
                $localizacao->getCodLocalizacao(),
                $codigoReduzido
            );

        return (count($dependentes)) ? true : false;
    }

    /**
     * @param Localizacao $localizacao
     * @return bool
     */
    public function verificaBaixa(Localizacao $localizacao)
    {
        $baixa = $localizacao->getFkImobiliarioBaixaLocalizacoes()->filter(
            function ($entry) {
                if (!$entry->getDtTermino()) {
                    return $entry;
                }
            }
        );
        return ($baixa->count()) ? true : false;
    }

    /**
     * @param Localizacao $localizacao
     * @return bool
     */
    public function verificaCaracteristicas(Localizacao $localizacao)
    {
        $nivel = $this->getNivel($localizacao);
        return ($nivel->getFkImobiliarioAtributoNiveis()->count())
            ? true
            : false;
    }

    /**
     * @param Localizacao $localizacao
     * @param $form
     * @param $valorMD
     * @param $aliquotas
     * @param null|array $atributoDinamico
     * @return bool|\Exception
     */
    public function salvarLocalizacao(Localizacao $localizacao, $form, $valorMD, $aliquotas, $atributoDinamico = null)
    {
        try {
            $vigencia = $form->get('fkImobiliarioVigencia')->getData();
            $nivel = $form->get('fkImobiliarioNivel')->getData();
            $superior = $form->get('fkImobiliarioLocalizacao')->getData();

            $codVigencia = $vigencia->getCodVigencia();
            $codNivel = $nivel->getCodNivel();
            $codigo = $form->get('codLocalizacao')->getData();

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

            if ($atributoDinamico) {
                $nivel = $this
                    ->entityManager
                    ->getRepository(Nivel::class)
                    ->findOneBy(
                        array(
                            'codNivel' => $codNivel,
                            'codVigencia' => $codVigencia
                        )
                    );
                $atributoDinamicoModel = new AtributoDinamicoModel($this->entityManager);
                /** @var AtributoNivel $atributoNivel */
                foreach ($nivel->getFkImobiliarioAtributoNiveis() as $atributoNivel) {
                    $valor = $atributoDinamicoModel
                        ->processaAtributoDinamicoPersist(
                            $atributoNivel,
                            $atributoDinamico[$atributoNivel->getCodAtributo()]
                        );
                    $atributoNivelValor = new AtributoNivelValor();
                    $atributoNivelValor->setFkImobiliarioAtributoNivel($atributoNivel);
                    $atributoNivelValor->setValor($valor);
                    $localizacao->addFkImobiliarioAtributoNivelValores($atributoNivelValor);
                }
            }

            if ($valorMD) {
                $this->insereValorMD($localizacao, $form);
            }

            if ($aliquotas) {
                $this->insereAliquota($localizacao, $form);
            }

            return true;
        } catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * @param Localizacao $localizacao
     * @param $form
     */
    public function insereValorMD(Localizacao $localizacao, $form)
    {
        $localizacaoValorM2 = new LocalizacaoValorM2();
        $localizacaoValorM2->setValorM2Territorial($form->get('fkImobiliarioLocalizacaoValorM2s__valorM2Territorial')->getData());
        $localizacaoValorM2->setValorM2Predial($form->get('fkImobiliarioLocalizacaoValorM2s__valorM2Predial')->getData());
        $localizacaoValorM2->setDtVigencia($form->get('fkImobiliarioLocalizacaoValorM2s__dtVigencia')->getData());
        $localizacaoValorM2->setFkNormasNorma($form->get('fkImobiliarioLocalizacaoValorM2s__fkNormasNorma')->getData());
        $localizacao->addFkImobiliarioLocalizacaoValorM2s($localizacaoValorM2);
    }

    /**
     * @param Localizacao $localizacao
     * @param $form
     */
    public function insereAliquota(Localizacao $localizacao, $form)
    {
        $localizacaoAliquota = new LocalizacaoAliquota();
        $localizacaoAliquota->setAliquotaTerritorial($form->get('fkImobiliarioLocalizacaoAliquotas__aliquotaTerritorial')->getData());
        $localizacaoAliquota->setAliquotaPredial($form->get('fkImobiliarioLocalizacaoAliquotas__aliquotaPredial')->getData());
        $localizacaoAliquota->setDtVigencia($form->get('fkImobiliarioLocalizacaoAliquotas__dtVigencia')->getData());
        $localizacaoAliquota->setFkNormasNorma($form->get('fkImobiliarioLocalizacaoAliquotas__fkNormasNorma')->getData());
        $localizacao->addFkImobiliarioLocalizacaoAliquotas($localizacaoAliquota);
    }

    /**
     * @param Localizacao $localizacao
     * @param $codigo
     * @param $form
     * @param $valorMD
     * @param $aliquotas
     * @param null|array $atributoDinamico
     * @return bool|\Exception
     */
    public function atualizarLocalizacao(Localizacao $localizacao, $codigo, $form, $valorMD, $aliquotas, $atributoDinamico = null)
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
     * @param Localizacao $localizacao
     * @param $atributoDinamico
     * @return bool|\Exception
     */
    public function atualizarAtributoDinamico(Localizacao $localizacao, $atributoDinamico)
    {
        try {
            $nivel = $this->getNivel($localizacao);
            $atributoDinamicoModel = new AtributoDinamicoModel($this->entityManager);

            /** @var AtributoNivel $atributoNivel */
            foreach ($nivel->getFkImobiliarioAtributoNiveis() as $atributoNivel) {
                $atributoNivelValor = $this
                    ->entityManager
                    ->getRepository(AtributoNivelValor::class)
                    ->findOneBy(
                        array(
                            'codNivel' => $atributoNivel->getCodNivel(),
                            'codVigencia' => $atributoNivel->getCodVigencia(),
                            'codLocalizacao' => $localizacao->getCodLocalizacao(),
                            'codAtributo' => $atributoNivel->getCodAtributo(),
                            'codCadastro' => $atributoNivel->getCodCadastro(),
                            'codModulo' => $atributoNivel->getCodModulo()
                        )
                    );
                $valor = $atributoDinamicoModel
                    ->processaAtributoDinamicoPersist(
                        $atributoNivel,
                        $atributoDinamico[$atributoNivel->getCodAtributo()]
                    );
                if ($atributoNivelValor) {
                    $atributoNivelValor->setValor($valor);
                    $this->entityManager->persist($atributoNivelValor);
                } else {
                    $atributoNivelValor = new AtributoNivelValor();
                    $atributoNivelValor->setFkImobiliarioAtributoNivel($atributoNivel);
                    $atributoNivelValor->setValor($valor);
                    $localizacao->addFkImobiliarioAtributoNivelValores($atributoNivelValor);
                }
            }
            $this->entityManager->persist($localizacao);
            $this->entityManager->flush();
            return true;
        } catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * @return mixed
     */
    public function getLocalizacoes()
    {
        return $this->repository->getLocalizacoes();
    }
}
