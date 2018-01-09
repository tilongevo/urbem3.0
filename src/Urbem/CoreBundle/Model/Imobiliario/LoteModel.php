<?php

namespace Urbem\CoreBundle\Model\Imobiliario;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;
use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Imobiliario\AreaLote;
use Urbem\CoreBundle\Entity\Imobiliario\AtributoLoteRuralValor;
use Urbem\CoreBundle\Entity\Imobiliario\AtributoLoteUrbanoValor;
use Urbem\CoreBundle\Entity\Imobiliario\Confrontacao;
use Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoDiversa;
use Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoExtensao;
use Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoTrecho;
use Urbem\CoreBundle\Entity\Imobiliario\Imovel;
use Urbem\CoreBundle\Entity\Imobiliario\ImovelConfrontacao;
use Urbem\CoreBundle\Entity\Imobiliario\ImovelLote;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;
use Urbem\CoreBundle\Entity\Imobiliario\LoteBairro;
use Urbem\CoreBundle\Entity\Imobiliario\LoteLocalizacao;
use Urbem\CoreBundle\Entity\Imobiliario\LoteParcelado;
use Urbem\CoreBundle\Entity\Imobiliario\LoteProcesso;
use Urbem\CoreBundle\Entity\Imobiliario\LoteRural;
use Urbem\CoreBundle\Entity\Imobiliario\LoteUrbano;
use Urbem\CoreBundle\Entity\Imobiliario\ParcelamentoSolo;
use Urbem\CoreBundle\Entity\Imobiliario\PontoCardeal;
use Urbem\CoreBundle\Entity\Imobiliario\ProfundidadeMedia;
use Urbem\CoreBundle\Entity\Imobiliario\TipoParcelamento;
use Urbem\CoreBundle\Entity\Imobiliario\Trecho;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;

class LoteModel extends AbstractModel
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
        $this->repository = $this->entityManager->getRepository(Lote::class);
    }

    /**
     * @param $codLote
     * @return array
     */
    public function recuperaProprietariosLote($codLote)
    {
        return $this->repository->recuperaProprietariosLote($codLote);
    }

    /**
     * @param Lote $lote
     * @return bool
     */
    public function verificaLoteImovel(Lote $lote)
    {
        return ($lote->getFkImobiliarioImovelLotes()->count()) ? true : false;
    }

    /**
     * @param Lote $lote
     * @return bool
     */
    public function verificaLoteParceladoValidado(Lote $lote)
    {
        $loteParcelado = $lote->getFkImobiliarioLoteParcelados()->filter(
            function ($entry) {
                if (!$entry->getValidado()) {
                    return $entry;
                }
            }
        );
        return ($loteParcelado->count()) ? false : true;
    }

    /**
     * @param Lote $lote
     * @return bool
     */
    public function verificaBaixa(Lote $lote)
    {
        $baixa = $lote->getFkImobiliarioBaixaLotes()->filter(
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
                    'codCadastro' => Cadastro::CADASTRO_TRIBUTARIO_LOTE_URBANO
                )
            );
        return ($caracteristicas) ? true : false;
    }

    /**
     * @param Lote $lote
     * @return bool
     */
    public function verificaLoteValidar(Lote $lote)
    {
        $loteParcelado = $lote->getFkImobiliarioLoteParcelados()->filter(
            function ($entry) {
                if (!$entry->getValidado()) {
                    return $entry;
                }
            }
        );
        return ($loteParcelado->count()) ? true : false;
    }

    /**
     * @return int
     */
    public function getProximoCodLote()
    {
        /** @var Lote $lastLote */
        $lastLote = $this->repository->findOneBy(array(), array('codLote' => 'DESC'));
        return ($lastLote) ? $lastLote->getCodLote() + 1 : 1;
    }

    /**
     * @return int
     */
    public function getProximoCodParcelamento()
    {
        /** @var ParcelamentoSolo $lastParcelamentoSolo */
        $lastParcelamentoSolo = $this->entityManager->getRepository(ParcelamentoSolo::class)->findOneBy(array(), array('codParcelamento' => 'DESC'));
        return ($lastParcelamentoSolo) ? $lastParcelamentoSolo->getCodParcelamento() + 1 : 1;
    }

    /**
     * @return int
     */
    public function getProximoCodConfrontacao()
    {
        /** @var Confrontacao $lastConfrontacao */
        $lastConfrontacao = $this->entityManager->getRepository(Confrontacao::class)->findOneBy(array(), array('codConfrontacao' => 'DESC'));
        return ($lastConfrontacao) ? $lastConfrontacao->getCodConfrontacao() + 1 : 1;
    }

    /**
     * @param Lote $lote
     * @param $atributosDinamicos
     * @param $dtAtual
     * @param bool $limpar
     * @return bool|\Exception
     */
    public function atributoDinamico(Lote $lote, $atributosDinamicos, $dtAtual, $limpar = true)
    {
        try {
            $em = $this->entityManager;
            $atributoDinamicoModel = new AtributoDinamicoModel($em);

            if ($lote->getFkImobiliarioLoteUrbano()) {
                $codCadastro = Cadastro::CADASTRO_TRIBUTARIO_LOTE_URBANO;
            } else {
                $codCadastro = Cadastro::CADASTRO_TRIBUTARIO_LOTE_RURAL;
            }

            foreach ($atributosDinamicos as $codAtributo => $valorAtributo) {
                /** @var AtributoDinamico $atributoDinamico */
                $atributoDinamico = $em->getRepository(AtributoDinamico::class)
                    ->findOneBy(
                        array(
                            'codModulo' => Modulo::MODULO_CADASTRO_IMOBILIARIO,
                            'codCadastro' => $codCadastro,
                            'codAtributo' => $codAtributo
                        )
                    );

                if ($lote->getFkImobiliarioLoteUrbano()) {
                    $atributoLoteUrbanoValor = new AtributoLoteUrbanoValor();
                    $atributoLoteUrbanoValor->setFkAdministracaoAtributoDinamico($atributoDinamico);

                    $valor = $atributoDinamicoModel
                        ->processaAtributoDinamicoPersist(
                            $atributoLoteUrbanoValor,
                            $valorAtributo
                        );

                    $atributoLoteUrbanoValor->setValor($valor);
                    $atributoLoteUrbanoValor->setTimestamp($dtAtual);
                    $atributoLoteUrbanoValor->setFkImobiliarioLoteUrbano($lote->getFkImobiliarioLoteUrbano());
                    $lote->getFkImobiliarioLoteUrbano()->addFkImobiliarioAtributoLoteUrbanoValores($atributoLoteUrbanoValor);
                } else {
                    $atributoLoteRuralValor = new AtributoLoteRuralValor();
                    $atributoLoteRuralValor->setFkAdministracaoAtributoDinamico($atributoDinamico);

                    $valor = $atributoDinamicoModel
                        ->processaAtributoDinamicoPersist(
                            $atributoLoteRuralValor,
                            $valorAtributo
                        );

                    $atributoLoteRuralValor->setValor($valor);
                    $atributoLoteRuralValor->setTimestamp($dtAtual);
                    $atributoLoteRuralValor->setFkImobiliarioLoteRural($lote->getFkImobiliarioLoteRural());
                    $lote->getFkImobiliarioLoteRural()->addFkImobiliarioAtributoLoteRuralValores($atributoLoteRuralValor);
                }
            }
            $em->persist($lote);
            if ($limpar) {
                $em->flush();
            }
            return true;
        } catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * @param Lote $lote
     * @param $confrontacoes
     * @param null $confrontacoesOld
     */
    public function montaConfrontacoes(Lote $lote, $confrontacoes, $confrontacoesOld = null)
    {
        $em = $this->entityManager;

        if ($lote->getFkImobiliarioConfrontacoes()->count()) {
            /** @var Confrontacao $confrontacao */
            foreach ($lote->getFkImobiliarioConfrontacoes() as $key => $confrontacao) {
                if (!in_array($this->getObjectIdentifier($confrontacao), $confrontacoesOld)) {
                    $lote->getFkImobiliarioConfrontacoes()->remove($key);
                }
            }
        }

        $codConfrontacao = $this->getProximoCodConfrontacao();

        if (isset($confrontacoes['trecho'])) {
            foreach ($confrontacoes['trecho']['trecho'] as $key => $trecho) {
                list($codTrecho, $codLogradouro) = explode('~', $trecho);
                $params = array('codTrecho' => $codTrecho, 'codLogradouro' => $codLogradouro);
                /** @var Trecho $trecho */
                $trecho = $em->getRepository(Trecho::class)->findOneBy($params);

                $principal = ((int) $confrontacoes['trecho']['principal'][$key]) ? true : false;
                $confrontacaoTrecho = new ConfrontacaoTrecho();
                $confrontacaoTrecho->setFkImobiliarioTrecho($trecho);
                $confrontacaoTrecho->setPrincipal($principal);

                /** @var PontoCardeal $pontoCardeal */
                $pontoCardeal = $em->getRepository(PontoCardeal::class)->find($confrontacoes['trecho']['ponto_cardeal'][$key]);

                $confrontacaoExtensao = new ConfrontacaoExtensao();
                $confrontacaoExtensao->setValor((float) $confrontacoes['trecho']['extensao'][$key]);

                $confrontacao = new Confrontacao();
                $confrontacao->setCodConfrontacao($codConfrontacao);
                $confrontacao->setFkImobiliarioPontoCardeal($pontoCardeal);
                $confrontacao->setFkImobiliarioLote($lote);
                $confrontacao->addFkImobiliarioConfrontacaoExtensoes($confrontacaoExtensao);
                $em->persist($confrontacao);

                $confrontacao->setFkImobiliarioConfrontacaoTrecho($confrontacaoTrecho);
                $lote->addFkImobiliarioConfrontacoes($confrontacao);
                $codConfrontacao++;
            }
        }

        /**
         * @Todo: Verificar tabela imobiliario.confrontacao_lote
         */

        if (isset($confrontacoes['diversa'])) {
            foreach ($confrontacoes['diversa']['diversa'] as $key => $diversa) {
                $confrontacaoDiversa = new ConfrontacaoDiversa();
                $confrontacaoDiversa->setDescricao($diversa);

                /** @var PontoCardeal $pontoCardeal */
                $pontoCardeal = $em->getRepository(PontoCardeal::class)->find($confrontacoes['diversa']['ponto_cardeal'][$key]);

                $confrontacaoExtensao = new ConfrontacaoExtensao();
                $confrontacaoExtensao->setValor((float) $confrontacoes['diversa']['extensao'][$key]);

                $confrontacao = new Confrontacao();
                $confrontacao->setCodConfrontacao($codConfrontacao);
                $confrontacao->setFkImobiliarioPontoCardeal($pontoCardeal);
                $confrontacao->setFkImobiliarioLote($lote);
                $confrontacao->addFkImobiliarioConfrontacaoExtensoes($confrontacaoExtensao);
                $em->persist($confrontacao);

                $confrontacao->setFkImobiliarioConfrontacaoDiversa($confrontacaoDiversa);

                $lote->addFkImobiliarioConfrontacoes($confrontacao);
                $codConfrontacao++;
            }
        }
    }

    /**
     * @param Lote $lote
     * @param $form
     * @param $confrontacoes
     * @param DateTimeMicrosecondPK $dtAtual
     */
    public function salvarLote(Lote $lote, $form, $confrontacoes, $dtAtual)
    {
        // Profundidade Média
        $profundidadeMedia = new ProfundidadeMedia();
        $profundidadeMedia->setVlProfundidadeMedia((float) $form->get('profundidadeMedia')->getData());
        $lote->addFkImobiliarioProfundidadeMedias($profundidadeMedia);

        // Área Lote
        $areaLote = new AreaLote();
        $areaLote->setAreaReal((float) $form->get('area')->getData());
        $areaLote->setFkAdministracaoUnidadeMedida($form->get('fkAdministracaoUnidadeMedida')->getData());
        $lote->addFkImobiliarioAreaLotes($areaLote);

        // Lote Bairro
        $loteBairro = new LoteBairro();
        $loteBairro->setFkSwBairro($form->get('fkSwBairro')->getData());
        $lote->addFkImobiliarioLoteBairros($loteBairro);

        // Lote Precesso
        if ($form->get('codProcesso')->getData()) {
            list($codProcesso, $anoExercicio) = explode('~', $form->get('codProcesso')->getData());
            /** @var SwProcesso $swProcesso */
            $swProcesso = $this->entityManager->getRepository(SwProcesso::class)->findOneBy([
                'codProcesso' => $codProcesso,
                'anoExercicio' => $anoExercicio
            ]);

            $loteProcesso = new LoteProcesso();
            $loteProcesso->setFkSwProcesso($swProcesso);
            $lote->addFkImobiliarioLoteProcessos($loteProcesso);
        }

        // Lote Localização
        $loteLocalizacao = new LoteLocalizacao();
        $loteLocalizacao->setValor($form->get('numLote')->getData());
        $loteLocalizacao->setFkImobiliarioLocalizacao($form->get('fkImobiliarioLocalizacao')->getData());
        $lote->setFkImobiliarioLoteLocalizacao($loteLocalizacao);

        // Confrontacões
        $this->montaConfrontacoes($lote, $confrontacoes);

        if ($form->get('tipoLote')->getData() == Cadastro::CADASTRO_TRIBUTARIO_LOTE_URBANO) {
            $loteUrbano = new LoteUrbano();
            $lote->setFkImobiliarioLoteUrbano($loteUrbano);
        } else {
            $loteRural = new LoteRural();
            $lote->setFkImobiliarioLoteRural($loteRural);
        }
    }

    /**
     * @param Lote $lote
     * @param $form
     * @param $confrontacoes
     * @param $confrontacoesOld
     */
    public function alterarLote(Lote $lote, $form, $confrontacoes, $confrontacoesOld)
    {
        $em = $this->entityManager;

        // Profundidade Média
        $profundidadeMedia = $lote->getFkImobiliarioProfundidadeMedias()->current();
        $profundidadeMedia->setVlProfundidadeMedia((float) $form->get('profundidadeMedia')->getData());
        $em->persist($profundidadeMedia);

        // Área Lote
        $areaLote = $lote->getFkImobiliarioAreaLotes()->current();
        $areaLote->setAreaReal((float) $form->get('area')->getData());
        $areaLote->setFkAdministracaoUnidadeMedida($form->get('fkAdministracaoUnidadeMedida')->getData());
        $em->persist($areaLote);

        // Lote Bairro
        $loteBairro = $lote->getFkImobiliarioLoteBairros()->current();
        $loteBairro->setFkSwBairro($form->get('fkSwBairro')->getData());
        $em->persist($loteBairro);

        // Lote Precesso
        if ($form->get('codProcesso')->getData()) {
            list($codProcesso, $anoExercicio) = explode('~', $form->get('codProcesso')->getData());
            /** @var SwProcesso $swProcesso */
            $swProcesso = $this->entityManager->getRepository(SwProcesso::class)->findOneBy([
                'codProcesso' => $codProcesso,
                'anoExercicio' => $anoExercicio
            ]);

            $loteProcesso = new LoteProcesso();
            $loteProcesso->setFkSwProcesso($swProcesso);
            $lote->addFkImobiliarioLoteProcessos($loteProcesso);
        }

        // Confrontações
        $this->montaConfrontacoes($lote, $confrontacoes, $confrontacoesOld);
    }

    /**
     * @param Lote $lote
     * @param null $timestamp
     * @return array
     */
    public function getNomAtributoValorByLote(Lote $lote, $timestamp = null)
    {
        if (!$timestamp) {
            if ($lote->getFkImobiliarioLoteUrbano()) {
                $timestamp = ($lote->getFkImobiliarioLoteUrbano()->getFkImobiliarioAtributoLoteUrbanoValores()->count())
                    ? $lote->getFkImobiliarioLoteUrbano()->getFkImobiliarioAtributoLoteUrbanoValores()->last()->getTimestamp()
                    : null;
            } else {
                $timestamp = ($lote->getFkImobiliarioLoteRural()->getFkImobiliarioAtributoLoteRuralValores()->count())
                    ? $lote->getFkImobiliarioLoteRural()->getFkImobiliarioAtributoLoteRuralValores()->last()->getTimestamp()
                    : null;
            }
        }

        $atributosDinamicos = array();

        if ($lote->getFkImobiliarioLoteUrbano()) {
            $atributoLoteValores = $lote->getFkImobiliarioLoteUrbano()->getFkImobiliarioAtributoLoteUrbanoValores()->filter(
                function ($entry) use ($timestamp) {
                    if ($entry->getTimestamp() == $timestamp) {
                        return $entry;
                    }
                }
            );
        } else {
            $atributoLoteValores = $lote->getFkImobiliarioLoteRural()->getFkImobiliarioAtributoLoteRuralValores()->filter(
                function ($entry) use ($timestamp) {
                    if ($entry->getTimestamp() == $timestamp) {
                        return $entry;
                    }
                }
            );
        }

        foreach ($atributoLoteValores as $atributoLoteValor) {
            $atributoDinamico = $atributoLoteValor->getFkAdministracaoAtributoDinamico();
            $atributosDinamicos[$atributoDinamico->getCodAtributo()]['nomAtributo'] = $atributoDinamico->getNomAtributo();
            $selecteds = explode(',', $atributoLoteValor->getValor());
            if ($atributoDinamico->getCodTipo() == AtributoDinamico::COD_TIPO_LISTA || $atributoDinamico->getCodTipo() == AtributoDinamico::COD_TIPO_LISTA_MULTIPLA) {
                foreach ($atributoDinamico->getFkAdministracaoAtributoValorPadroes() as $atributoValorPadrao) {
                    if (in_array($atributoValorPadrao->getCodValor(), $selecteds)) {
                        $atributosDinamicos[$atributoDinamico->getCodAtributo()]['valor'][] = $atributoValorPadrao->getValorPadrao();
                    }
                }
            } else {
                $atributosDinamicos[$atributoDinamico->getCodAtributo()]['valor'][] = $atributoLoteValor->getValor();
            }
        }
        return $atributosDinamicos;
    }

    /**
     * @param Lote $lote
     * @param $form
     * @param $confrontacoes
     * @param $confrontacoesOld
     * @param $atributosDinamicos
     * @param $dtAtual
     */
    public function salvarLoteDesmembramento(Lote $lote, $form, $confrontacoes, $confrontacoesOld, $atributosDinamicos, $dtAtual)
    {
        /** @var ORM\EntityManager $em */
        $em = $this->entityManager;

        /** @var ProfundidadeMedia $profundidadeMedia */
        $profundidadeMedia = $lote->getFkImobiliarioProfundidadeMedias()->current();
        $profundidadeMedia->setVlProfundidadeMedia($form->get('profundidadeMedia')->getData());
        $em->persist($profundidadeMedia);

        // Área do Lote
        $areaReal = round($lote->getFkImobiliarioAreaLotes()->current()->getAreaReal() / (int) $form->get('quantidadeLotes')->getData(), 2);
        $areaLote = new AreaLote();
        $areaLote->setTimestamp($dtAtual);
        $areaLote->setAreaReal($areaReal);
        $areaLote->setFkAdministracaoUnidadeMedida($lote->getFkImobiliarioAreaLotes()->current()->getFkAdministracaoUnidadeMedida());
        $lote->addFkImobiliarioAreaLotes($areaLote);

        // Confrontações
        $this->montaConfrontacoes($lote, $confrontacoes, $confrontacoesOld);

        // Processo
        if ($form->get('codProcesso')->getData()) {
            $loteProcesso = new LoteProcesso();
            $loteProcesso->setFkSwProcesso($form->get('codProcesso')->getData());
            $loteProcesso->setTimestamp($dtAtual);
            $lote->addFkImobiliarioLoteProcessos($loteProcesso);
        }

        /** @var TipoParcelamento $tipoParcelamento */
        $tipoParcelamento = $em->getRepository(TipoParcelamento::class)->find(TipoParcelamento::TIPO_PARCELAMENTO_DESMEMBRAMENTO);

        // Controle do parcelamento do lote
        $parcelamentoSolo = new ParcelamentoSolo();
        $parcelamentoSolo->setCodParcelamento($this->getProximoCodParcelamento());
        $parcelamentoSolo->setFkImobiliarioTipoParcelamento($tipoParcelamento);
        $parcelamentoSolo->setDtParcelamento($form->get('dtDesmembramento')->getData());
        $parcelamentoSolo->setFkImobiliarioLote($lote);
        $lote->addFkImobiliarioParcelamentoSolos($parcelamentoSolo);

        $loteParcelado = new LoteParcelado();
        $loteParcelado->setFkImobiliarioParcelamentoSolo($parcelamentoSolo);
        $loteParcelado->setFkImobiliarioLote($lote);
        $lote->addFkImobiliarioLoteParcelados($loteParcelado);

        // Atributos Dinâmicos
        $this->atributoDinamico($lote, $atributosDinamicos, $dtAtual);
        $em->persist($lote);

        $letter = 'a';
        $codLote = $this->getProximoCodLote();
        for ($i = 1; $i < $form->get('quantidadeLotes')->getData(); $i++) {
            $this->criarLoteDoLoteOrigem($lote, $codLote, $letter, $parcelamentoSolo, $areaReal, $atributosDinamicos);
            $letter++;
            $codLote++;
        }

        $em->flush();
    }

    /**
     * @param Lote $loteOrigem
     * @param $codLote
     * @param $controle
     * @param $parcelamentoSolo
     * @param $atributosDinamicos
     * @return Lote
     */
    public function criarLoteDoLoteOrigem(Lote $loteOrigem, $codLote, $controle, $parcelamentoSolo, $areaReal, $atributosDinamicos)
    {
        $lote = new Lote();
        $lote->setCodLote($codLote);
        $lote->setDtInscricao($loteOrigem->getDtInscricao());
        $lote->setLocalizacao($loteOrigem->getFkImobiliarioLoteLocalizacao()->getFkImobiliarioLocalizacao()->getCodigoComposto());

        // Profundidade Média
        $profundidadeMedia = new ProfundidadeMedia();
        $profundidadeMedia->setVlProfundidadeMedia($loteOrigem->getFkImobiliarioProfundidadeMedias()->current()->getVlProfundidadeMedia());
        $lote->addFkImobiliarioProfundidadeMedias($profundidadeMedia);

        // Área Lote
        $areaLote = new AreaLote();
        $areaLote->setAreaReal($areaReal);
        $areaLote->setFkAdministracaoUnidadeMedida($loteOrigem->getFkImobiliarioAreaLotes()->current()->getFkAdministracaoUnidadeMedida());
        $lote->addFkImobiliarioAreaLotes($areaLote);

        // Lote Bairro
        $loteBairro = new LoteBairro();
        $loteBairro->setFkSwBairro($loteOrigem->getFkImobiliarioLoteBairros()->current()->getFkSwBairro());
        $lote->addFkImobiliarioLoteBairros($loteBairro);

        // Lote Localização
        $valor = $loteOrigem->getFkImobiliarioLoteLocalizacao()->getValor() . $controle;
        $loteLocalizacao = new LoteLocalizacao();
        $loteLocalizacao->setValor($valor);
        $loteLocalizacao->setFkImobiliarioLocalizacao($loteOrigem->getFkImobiliarioLoteLocalizacao()->getFkImobiliarioLocalizacao());
        $lote->setFkImobiliarioLoteLocalizacao($loteLocalizacao);

        // Tipo Lote
        if ($loteOrigem->getFkImobiliarioLoteUrbano()) {
            $loteUrbano = new LoteUrbano();
            $lote->setFkImobiliarioLoteUrbano($loteUrbano);
        } else {
            $loteRural = new LoteRural();
            $lote->setFkImobiliarioLoteRural($loteRural);
        }

        // Controle de desmembramento
        $loteParcelado = new LoteParcelado();
        $loteParcelado->setFkImobiliarioParcelamentoSolo($parcelamentoSolo);
        $loteParcelado->setFkImobiliarioLote($lote);
        $lote->addFkImobiliarioLoteParcelados($loteParcelado);

        // Atributos Dinâmicos
        $this->atributoDinamico($lote, $atributosDinamicos, $lote->getTimestamp(), false);

        $this->entityManager->persist($lote);

        return $lote;
    }

    /**
     * @param Lote $lote
     * @param $form
     * @param $lotes
     * @param $confrontacoes
     * @param $confrontacoesOld
     * @param $atributosDinamicos
     * @param $dtAtual
     */
    public function salvarLoteAglutinacao(Lote $lote, $form, $lotes, $confrontacoes, $confrontacoesOld, $atributosDinamicos, $dtAtual)
    {
        /** @var ORM\EntityManager $em */
        $em = $this->entityManager;

        /** @var ProfundidadeMedia $profundidadeMedia */
        $profundidadeMedia = $lote->getFkImobiliarioProfundidadeMedias()->current();
        $profundidadeMedia->setVlProfundidadeMedia($form->get('profundidadeMedia')->getData());
        $em->persist($profundidadeMedia);

        // Confrontações
        $this->montaConfrontacoes($lote, $confrontacoes, $confrontacoesOld);

        // Processo
        if ($form->get('codProcesso')->getData()) {
            $loteProcesso = new LoteProcesso();
            $loteProcesso->setFkSwProcesso($form->get('codProcesso')->getData());
            $loteProcesso->setTimestamp($dtAtual);
            $lote->addFkImobiliarioLoteProcessos($loteProcesso);
        }

        /** @var TipoParcelamento $tipoParcelamento */
        $tipoParcelamento = $em->getRepository(TipoParcelamento::class)->find(TipoParcelamento::TIPO_PARCELAMENTO_AGLUTINACAO);

        // Controle do parcelamento do lote
        $parcelamentoSolo = new ParcelamentoSolo();
        $parcelamentoSolo->setCodParcelamento($this->getProximoCodParcelamento());
        $parcelamentoSolo->setFkImobiliarioTipoParcelamento($tipoParcelamento);
        $parcelamentoSolo->setDtParcelamento($form->get('dtAglutinacao')->getData());
        $parcelamentoSolo->setFkImobiliarioLote($lote);
        $lote->addFkImobiliarioParcelamentoSolos($parcelamentoSolo);

        $areaReal = $lote->getFkImobiliarioAreaLotes()->current()->getAreaReal();

        $confrontacaoTrecho = $em
            ->getRepository(ConfrontacaoTrecho::class)
            ->findOneBy(
                array(
                    'codLote' => $lote->getCodLote(),
                    'principal' => 'true'
                )
            );

        foreach ($lotes as $codLote) {
            /** @var Lote $loteAglutinar */
            $loteAglutinar = $em->getRepository(Lote::class)->find($codLote);

            $areaReal += $loteAglutinar->getFkImobiliarioAreaLotes()->current()->getAreaReal();

            $loteParcelado = new LoteParcelado();
            $loteParcelado->setFkImobiliarioParcelamentoSolo($parcelamentoSolo);
            $loteParcelado->setValidado('true');
            $loteAglutinar->addFkImobiliarioLoteParcelados($loteParcelado);
            $em->persist($loteAglutinar);

            $imoveisLote = $em->getRepository(ImovelLote::class)->findByCodLote($codLote);
            /** @var ImovelLote $imovelLote */
            foreach ($imoveisLote as $imovelLote) {
                // Alterando o lote do imóvel
                $imovel = $imovelLote->getFkImobiliarioImovel();
                $imovel->getFkImobiliarioImovelConfrontacao()->setCodLote($lote->getCodLote());
                $imovel->getFkImobiliarioImovelConfrontacao()->setFkImobiliarioConfrontacaoTrecho($confrontacaoTrecho);
                $em->persist($imovel);

                $novoImovelLote = new ImovelLote();
                $novoImovelLote->setFkImobiliarioImovel($imovel);
                $lote->addFkImobiliarioImovelLotes($novoImovelLote);
            }
        }

        // Área do Lote
        $areaLote = new AreaLote();
        $areaLote->setTimestamp($dtAtual);
        $areaLote->setAreaReal($areaReal);
        $areaLote->setFkAdministracaoUnidadeMedida($lote->getFkImobiliarioAreaLotes()->current()->getFkAdministracaoUnidadeMedida());
        $lote->addFkImobiliarioAreaLotes($areaLote);

        // Atributos Dinâmicos
        $this->atributoDinamico($lote, $atributosDinamicos, $dtAtual, false);
        $em->persist($lote);
        $em->flush();
    }


    /**
     * @param ParcelamentoSolo $parcelamentoSolo
     */
    public function cancelarDesmembramento(ParcelamentoSolo $parcelamentoSolo)
    {
        /** @var ORM\EntityManager $em */
        $em = $this->entityManager;

        $remanecente = $parcelamentoSolo->getFkImobiliarioLote();

        $areaReal = 0;
        $validado = false;
        /** @var LoteParcelado $loteParcelado */
        foreach ($parcelamentoSolo->getFkImobiliarioLoteParcelados() as $loteParcelado) {
            if ($loteParcelado->getValidado() == false) {
                if ($loteParcelado->getFkImobiliarioLote()->getCodLote() != $remanecente->getCodLote()) {
                    $areaReal += $loteParcelado->getFkImobiliarioLote()->getFkImobiliarioAreaLotes()->current()->getAreaReal();
                    $em->remove($loteParcelado->getFkImobiliarioLote());
                }
                $em->remove($loteParcelado);
            } else {
                $validado = true;
            }
        }

        if ($areaReal) {
            $areaLote = new AreaLote();
            $areaLote->setFkAdministracaoUnidadeMedida($remanecente->getFkImobiliarioAreaLotes()->current()->getFkAdministracaoUnidadeMedida());
            $areaLote->setAreaReal($remanecente->getFkImobiliarioAreaLotes()->current()->getAreaReal() + $areaReal);
            $remanecente->addFkImobiliarioAreaLotes($areaLote);
            $em->persist($remanecente);
        }

        if (!$validado) {
            $em->remove($parcelamentoSolo);
        }

        $em->flush();
    }

    /**
     * @param Lote $lote
     * @param $form
     * @param $edificacoes
     * @param $confrontacoes
     * @param $confrontacoesOld
     */
    public function validarLote(Lote $lote, $form, $edificacoes, $confrontacoes, $confrontacoesOld)
    {
        /** @var ORM\EntityManager $em */
        $em = $this->entityManager;

        /** @var LoteParcelado $loteParcelado */
        $loteParcelado = $em
            ->getRepository(LoteParcelado::class)
            ->findOneByCodLote($lote->getCodLote());

        $loteParcelado->setValidado(true);
        $em->persist($loteParcelado);

        $lote->setDtInscricao($form->get('dtInscricao')->getData());
        $lote->getFkImobiliarioLoteLocalizacao()->setValor($form->get('numLote')->getData());
        $lote->getFkImobiliarioProfundidadeMedias()->last()->setVlProfundidadeMedia($form->get('profundidadeMedia')->getData());
        $lote->getFkImobiliarioLoteBairros()->last()->setFkSwBairro($form->get('fkSwBairro')->getData());

        $areaLote = new AreaLote();
        $areaLote->setAreaReal($form->get('area')->getData());
        $areaLote->setFkAdministracaoUnidadeMedida($lote->getFkImobiliarioAreaLotes()->current()->getFkAdministracaoUnidadeMedida());
        $lote->addFkImobiliarioAreaLotes($areaLote);

        if ($form->get('codProcesso')->getData()) {
            $loteProcesso = new LoteProcesso();
            $loteProcesso->setFkSwProcesso($form->get('codProcesso')->getData());
            $lote->addFkImobiliarioLoteProcessos($loteProcesso);
        }

        $this->montaConfrontacoes($lote, $confrontacoes, $confrontacoesOld);

        /** @var Confrontacao $confrontacao */
        $confrontacao = $lote->getFkImobiliarioConfrontacoes()->filter(
            function ($entry) {
                if ($entry->getFkImobiliarioConfrontacaoTrecho()) {
                    if ($entry->getFkImobiliarioConfrontacaoTrecho()->getPrincipal()) {
                        return $entry;
                    }
                }
            }
        )->first();

        $imoveisLote = $loteParcelado
            ->getFkImobiliarioParcelamentoSolo()
            ->getFkImobiliarioLote()
            ->getFkImobiliarioImovelLotes();

        if ($edificacoes) {
            foreach ($edificacoes as $edificacao) {
                $imovelLote = $imoveisLote->filter(
                    function ($entry) use ($edificacao) {
                        if ($entry->getInscricaoMunicipal() == $edificacao) {
                            return $entry;
                        }
                    }
                )->first();
                /** @var Imovel $imovel */
                $imovel = $imovelLote->getFkImobiliarioImovel();
                $imovel->getFkImobiliarioImovelConfrontacao()->setCodLote($lote->getCodLote());
                $imovel->getFkImobiliarioImovelConfrontacao()->setFkImobiliarioConfrontacaoTrecho($confrontacao->getFkImobiliarioConfrontacaoTrecho());
                $remover = $imovel->getFkImobiliarioImovelLotes()->filter(
                    function ($entry) use ($loteParcelado) {
                        if ($entry->getCodLote() == $loteParcelado->getFkImobiliarioParcelamentoSolo()->getFkImobiliarioLote()->getCodLote()) {
                            return $entry;
                        }
                    }
                )->first();

                $imovel->getFkImobiliarioImovelLotes()->removeElement($remover);
                $em->persist($imovel);

                $novoImovelLote = new ImovelLote();
                $novoImovelLote->setFkImobiliarioImovel($imovel);
                $lote->addFkImobiliarioImovelLotes($novoImovelLote);
            }
        }

        $em->persist($lote);
        $em->flush();
    }

    /**
     * @param Lote $lote
     * @return array
     */
    public function getEdificacoes(Lote $lote)
    {
        $qb = $this
            ->entityManager
            ->getRepository(ImovelLote::class)
            ->createQueryBuilder('o');

        $qb->select('o.inscricaoMunicipal, MAX(o.timestamp) as timestamp');
        $qb->leftJoin('o.fkImobiliarioImovel', 'i');
        $qb->leftJoin('i.fkImobiliarioUnidadeAutonomas', 'ua');
        $qb->where('o.codLote = :codLote');
        $qb->andWhere('ua.inscricaoMunicipal is not null');
        $qb->setParameter('codLote', $lote->getCodLote());
        $qb->groupBy('o.inscricaoMunicipal');

        $rlt = $qb->getQuery()->getResult();

        $imoveisLotes = array();
        foreach ($rlt as $item) {
            $imovelLote = $this
                ->entityManager
                ->getRepository(ImovelLote::class)
                ->findOneBy(
                    array(
                        'inscricaoMunicipal' => $item['inscricaoMunicipal'],
                        'timestamp' => $item['timestamp'],
                    )
                );
            $imoveisLotes[] = $imovelLote;
        }

        return $imoveisLotes;
    }

    /**
     * @param Lote $lote
     * @return null|ImovelConfrontacao
     */
    public function verificaDependentes(Lote $lote)
    {
        /** @var ImovelConfrontacao $imovelConfrontacao */
        $imovelConfrontacao = $this->entityManager->getRepository(ImovelConfrontacao::class)
            ->findOneBy(array('codLote' => $lote->getCodLote()));

        return ($imovelConfrontacao) ? $imovelConfrontacao : null;
    }
    
    /**
     * @param $codLote
     */
    public function getLoteByCod($codLote)
    {
        return $this->repository->getLoteByCod($codLote);
    }
}
