<?php

namespace Urbem\CoreBundle\Model\Imobiliario;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;
use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Imobiliario\AtributoCondominioValor;
use Urbem\CoreBundle\Entity\Imobiliario\Condominio;
use Urbem\CoreBundle\Entity\Imobiliario\CondominioAreaComum;
use Urbem\CoreBundle\Entity\Imobiliario\CondominioCgm;
use Urbem\CoreBundle\Entity\Imobiliario\CondominioProcesso;
use Urbem\CoreBundle\Entity\Imobiliario\ImovelCondominio;
use Urbem\CoreBundle\Entity\Imobiliario\ImovelLote;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;
use Urbem\CoreBundle\Entity\Imobiliario\LoteCondominio;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;

class CondominioModel extends AbstractModel
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
        $this->repository = $this->entityManager->getRepository(Condominio::class);
    }

    /**
     * @return int
     */
    public function getNextVal()
    {
        return $this->repository->getNextVal();
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
                    'codCadastro' => Cadastro::CADASTRO_TRIBUTARIO_CONDOMINIO
                )
            );
        return ($caracteristicas) ? true : false;
    }

    /**
     * @param Condominio $condominio
     * @param $form
     * @param $request
     */
    public function popularCondominio(Condominio $condominio, $form, $request)
    {
        $em = $this->entityManager;

        $condominio->setCodCondominio($this->getNextVal());

        if ($form->get('fkSwProcesso')->getData()) {
            $condominioProcesso = new CondominioProcesso();
            $condominioProcesso->setFkSwProcesso($form->get('fkSwProcesso')->getData());
            $condominioProcesso->setTimestamp($condominio->getTimestamp());
            $condominio->addFkImobiliarioCondominioProcessos($condominioProcesso);
        }

        if ($form->get('fkSwCgmPessoaJuridica')->getData()) {
            $condominioCgm = new CondominioCgm();
            $condominioCgm->setFkSwCgmPessoaJuridica($form->get('fkSwCgmPessoaJuridica')->getData());
            $condominio->addFkImobiliarioCondominioCgns($condominioCgm);
        }

        $condominioAreaComum = new CondominioAreaComum();
        $condominioAreaComum->setAreaTotalComum($form->get('areaTotalComum')->getData());
        $condominioAreaComum->setTimestamp($condominio->getTimestamp());
        $condominio->addFkImobiliarioCondominioAreaComuns($condominioAreaComum);

        foreach ($request->get('lote') as $codLote) {
            if ($codLote != '') {
                /** @var Lote $lote */
                $lote = $em->getRepository(Lote::class)->find($codLote);
                $loteCondominio = new LoteCondominio();
                $loteCondominio->setFkImobiliarioLote($lote);
                $condominio->addFkImobiliarioLoteCondominios($loteCondominio);

                /** @var ImovelLote $imovelLote */
                foreach ($lote->getFkImobiliarioImovelLotes() as $imovelLote) {
                    $imovelCondominio = new ImovelCondominio();
                    $imovelCondominio->setFkImobiliarioImovel($imovelLote->getFkImobiliarioImovel());
                    $condominio->addFkImobiliarioImovelCondominios($imovelCondominio);
                }
            }
        }

        $this->atributoDinamico($condominio, $request->get('atributoDinamico'), $condominio->getTimestamp(), false);
    }

    /**
     * @param Condominio $condominio
     * @param $form
     * @param $request
     */
    public function popularAlteracaoCondominio(Condominio $condominio, $form, $request)
    {
        $em = $this->entityManager;

        $condominio->setTimestamp(new DateTimeMicrosecondPK());

        if ($form->get('fkSwProcesso')->getData()) {
            $condominioProcesso = new CondominioProcesso();
            $condominioProcesso->setFkSwProcesso($form->get('fkSwProcesso')->getData());
            $condominioProcesso->setTimestamp($condominio->getTimestamp());
            $condominio->addFkImobiliarioCondominioProcessos($condominioProcesso);
        }

        if ($form->get('fkSwCgmPessoaJuridica')->getData()) {
            $condominioCgm = $condominio->getFkImobiliarioCondominioCgns()->last();
            $condominioCgm->setFkSwCgmPessoaJuridica($form->get('fkSwCgmPessoaJuridica')->getData());
            $em->persist($condominioCgm);
        } else {
            $condominioCgm = $condominio->getFkImobiliarioCondominioCgns()->last();
            $condominio->getFkImobiliarioCondominioCgns()->removeElement($condominioCgm);
        }

        $condominioAreaComum = new CondominioAreaComum();
        $condominioAreaComum->setAreaTotalComum($form->get('areaTotalComum')->getData());
        $condominioAreaComum->setTimestamp($condominio->getTimestamp());
        $condominio->addFkImobiliarioCondominioAreaComuns($condominioAreaComum);

        $lotesOld = ($request->get('lote_old')) ? $request->get('lote_old') : array();
        if ($condominio->getFkImobiliarioLoteCondominios()->count()) {
            /** @var LoteCondominio $loteCondominio */
            foreach ($condominio->getFkImobiliarioLoteCondominios() as $loteCondominio) {
                if (!in_array($this->getObjectIdentifier($loteCondominio), $lotesOld)) {
                    $condominio->getFkImobiliarioLoteCondominios()->removeElement($loteCondominio);
                    /** @var ImovelLote $imovelLote */
                    foreach ($loteCondominio->getFkImobiliarioLote()->getFkImobiliarioImovelLotes() as $imovelLote) {
                        $imoveisCondominio = $condominio->getFkImobiliarioImovelCondominios()->filter(
                            function ($entry) use ($imovelLote) {
                                if ($entry->getInscricaoMunicipal() == $imovelLote->getInscricaoMunicipal()) {
                                    return $entry;
                                }
                            }
                        );
                        /** @var ImovelCondominio $imovelCondominio */
                        foreach ($imoveisCondominio as $imovelCondominio) {
                            $condominio->getFkImobiliarioImovelCondominios()->removeElement($imovelCondominio);
                        }
                    }
                }
            }
        }

        foreach ($request->get('lote') as $codLote) {
            if ($codLote != '') {
                /** @var Lote $lote */
                $lote = $em->getRepository(Lote::class)->find($codLote);
                $loteCondominio = new LoteCondominio();
                $loteCondominio->setFkImobiliarioLote($lote);
                $condominio->addFkImobiliarioLoteCondominios($loteCondominio);

                /** @var ImovelLote $imovelLote */
                foreach ($lote->getFkImobiliarioImovelLotes() as $imovelLote) {
                    $imovelCondominio = new ImovelCondominio();
                    $imovelCondominio->setFkImobiliarioImovel($imovelLote->getFkImobiliarioImovel());
                    $condominio->addFkImobiliarioImovelCondominios($imovelCondominio);
                }
            }
        }

        $this->atributoDinamico($condominio, $request->get('atributoDinamico'), $condominio->getTimestamp(), false);
    }

    /**
     * @param Condominio $condominio
     * @param $atributosDinamicos
     * @param $dtAtual
     * @param bool $limpar
     * @return bool|\Exception
     */
    public function atributoDinamico(Condominio $condominio, $atributosDinamicos, $dtAtual, $limpar = true)
    {
        try {
            $em = $this->entityManager;
            $atributoDinamicoModel = new AtributoDinamicoModel($em);

            foreach ($atributosDinamicos as $codAtributo => $valorAtributo) {
                /** @var AtributoDinamico $atributoDinamico */
                $atributoDinamico = $em->getRepository(AtributoDinamico::class)
                    ->findOneBy(
                        array(
                            'codModulo' => Modulo::MODULO_CADASTRO_IMOBILIARIO,
                            'codCadastro' => Cadastro::CADASTRO_TRIBUTARIO_CONDOMINIO,
                            'codAtributo' => $codAtributo
                        )
                    );

                $atributoCondominioValor = new AtributoCondominioValor();
                $atributoCondominioValor->setFkAdministracaoAtributoDinamico($atributoDinamico);

                $valor = $atributoDinamicoModel
                    ->processaAtributoDinamicoPersist(
                        $atributoCondominioValor,
                        $valorAtributo
                    );

                $atributoCondominioValor->setValor($valor);
                $atributoCondominioValor->setTimestamp($dtAtual);
                $condominio->addFkImobiliarioAtributoCondominioValores($atributoCondominioValor);
            }
            $em->persist($condominio);
            if ($limpar) {
                $em->flush();
            }
            return true;
        } catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * @param Condominio $condominio
     * @param null $timestamp
     * @return array
     */
    public function getNomAtributoValorByCondominio(Condominio $condominio, $timestamp = null)
    {
        if (!$timestamp) {
            $timestamp = ($condominio->getFkImobiliarioAtributoCondominioValores()->count())
                ? $condominio->getFkImobiliarioAtributoCondominioValores()->last()->getTimestamp()
                : null;
        }

        $atributosDinamicos = array();

        $atributoCondominioValores = $condominio->getFkImobiliarioAtributoCondominioValores()->filter(
            function ($entry) use ($timestamp) {
                if ($entry->getTimestamp() == $timestamp) {
                    return $entry;
                }
            }
        );

        /** @var AtributoCondominioValor $atributoCondominioValor */
        foreach ($atributoCondominioValores as $atributoCondominioValor) {
            $atributoDinamico = $atributoCondominioValor->getFkAdministracaoAtributoDinamico();
            $atributosDinamicos[$atributoDinamico->getCodAtributo()]['nomAtributo'] = $atributoDinamico->getNomAtributo();
            $selecteds = explode(',', $atributoCondominioValor->getValor());
            if ($atributoDinamico->getCodTipo() == AtributoDinamico::COD_TIPO_LISTA || $atributoDinamico->getCodTipo() == AtributoDinamico::COD_TIPO_LISTA_MULTIPLA) {
                foreach ($atributoDinamico->getFkAdministracaoAtributoValorPadroes() as $atributoValorPadrao) {
                    if (in_array($atributoValorPadrao->getCodValor(), $selecteds)) {
                        $atributosDinamicos[$atributoDinamico->getCodAtributo()]['valor'][] = $atributoValorPadrao->getValorPadrao();
                    }
                }
            } else {
                $atributosDinamicos[$atributoDinamico->getCodAtributo()]['valor'][] = $atributoCondominioValor->getValor();
            }
        }
        return $atributosDinamicos;
    }

    /**
     * @param $params
     * @return mixed
     */
    public function getCondominioByNomeAndCodigo($params)
    {
        return $this->repository->getCondominioByNomeAndCodigo($params);
    }

    /**
     * @param $codigoCondominio
     * @return mixed
     */
    public function getInformacoesCondominioByCodigo($codigoCondominio)
    {
        return $this->repository->getInformacoesCondominioByCodigo($codigoCondominio);
    }
}
