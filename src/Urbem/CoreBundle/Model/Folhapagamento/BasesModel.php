<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Repository;
use Urbem\CoreBundle\Entity\Folhapagamento\BasesEvento;
use Symfony\Component\Validator\Validator;
use Symfony\Bridge\Monolog\Logger;

class BasesModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;
    const CODTIPO = 3;
    const CODMODULO = 27;
    const CODVERBA = 50;
    const NATUREZA = "B";
    const TIPO = "B";

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\Bases");
    }

    public function canRemove($object)
    {
        $basesRepository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\BasesEvento");
        $res = $basesRepository->findOneByCodBase($object->getCodBase());

        return is_null($res);
    }
    
    public function montaCorpoPL($object)
    {
        $arLinhas = array();
        $nomBase = $object->getNomBase();
        $arLinhas[] = "\n FUNCTION $nomBase() RETURNS BOOLEAN as '";
        $arLinhas[] = "\n DECLARE";
        $arLinhas[] = "\n     nuValor         NUMERIC:=0;";
        $arLinhas[] = "\n     nuQuantidade    NUMERIC:=0;";
        $arLinhas[] = "\n     boRetorno       BOOLEAN:=true;";
        $arLinhas[] = "\n     listaEventos    VARCHAR:='''';";
        $arLinhas[] = "\n BEGIN";
        $arLinhas[] = "\n    #listaEventos := pegaListaEventosDaBase(''$nomBase'');";

        if (trim($object->getTipoBase() == "V")) {
            $arLinhas[] = "\n    #nuValor      := pega0MontaBaseValorFolhas(#listaEventos, ''$nomBase'');";
        } else {
            $arLinhas[] = "\n    #nuQuantidade := pega0MontaBaseQuantidadeFolhas(#listaEventos, ''$nomBase'');";
        }

        if ($object->getApresentacaoValor() == true) {
            $arLinhas[] = "\n    #boRetorno    := gravarEvento(#nuValor, #nuQuantidade);";
        }

        $arLinhas[] = "\n    RETURN #boRetorno;";
        $arLinhas[] = "\n END;";
        $arLinhas[] = "\n ' LANGUAGE 'plpgsql';";

        return $arLinhas;
    }
    
    public function buscaCorpoPL($object)
    {
        $arLinhas = $this->montaCorpoPL($object);
        $stCorpoPL = "";

        foreach ($arLinhas as $chave => $valor) {
            $stCorpoPL .= $valor;
        }
        $stCorpoPL = str_replace("#", "", $stCorpoPL);

        return $stCorpoPL;
    }
    
    public function montaVariavel()
    {
        $arLinhas = array();

        $arLinhas[0]["DESCRICAO"] = "listaEventos";
        $arLinhas[0]["TIPO"]      = "2";
        $arLinhas[0]["VALOR"]     = "";

        $arLinhas[1]["DESCRICAO"] = "nuValor";
        $arLinhas[1]["TIPO"]      = "4";
        $arLinhas[1]["VALOR"]     = "0";

        $arLinhas[2]["DESCRICAO"] = "nuQuantidade";
        $arLinhas[2]["TIPO"]      = "4";
        $arLinhas[2]["VALOR"]     = "0";

        $arLinhas[3]["DESCRICAO"] = "boRetorno";
        $arLinhas[3]["TIPO"]      = "3";
        $arLinhas[3]["VALOR"]      = "VERDADEIRO";

        return $arLinhas;
    }
    
    /**
     * Persiste bases
     * @param  object $object
     * @param  Logger $logger
     * @return boolean
     */
    public function saveBases($object, Logger $logger)
    {
        try {
            return $this->entityManager->transactional(function ($entityManager) use ($object) {
                
                $eventoModel = new \Urbem\CoreBundle\Model\Folhapagamento\EventoModel($entityManager);
                
                $object->setCodModulo(self::CODMODULO);
                $object->setNomBase(str_replace(" ", "_", $object->getNomBase()));
                $codBiblioteca = (count($eventoModel->recuperaBibliotecaEntidade(27, date('Y'))) > 0) ? $eventoModel->recuperaBibliotecaEntidade(27, date('Y')) : 2;
                $object->setCodBiblioteca($codBiblioteca);
                
                $corpoPL = $this->buscaCorpoPL($object);
                
                $fkAdministracaoBiblioteca = $entityManager->getRepository('CoreBundle:Administracao\Biblioteca')
                ->findOneBy(
                    array(
                        'codModulo' => $object->getCodModulo(),
                        'codBiblioteca' => $object->getCodBiblioteca(),
                    )
                );
                
                $fkAdministracaoTipoPrimitivo = $entityManager->getRepository('CoreBundle:Administracao\TipoPrimitivo')
                ->findOneByCodTipo(self::CODTIPO);
                
                $codFuncao = $entityManager->getRepository("CoreBundle:Administracao\Funcao")
                ->getNextCodFuncao();
                
                $admFuncao = new \Urbem\CoreBundle\Entity\Administracao\Funcao;
                $admFuncao->setFkAdministracaoBiblioteca($fkAdministracaoBiblioteca);
                $admFuncao->setNomFuncao($object->getNomBase());
                $admFuncao->setFkAdministracaoTipoPrimitivo($fkAdministracaoTipoPrimitivo);
                $admFuncao->setCodFuncao($codFuncao);
                $this->save($admFuncao);
                
                $object->setFkAdministracaoFuncao($admFuncao);
                
                $admFuncaoExterna = new \Urbem\CoreBundle\Entity\Administracao\FuncaoExterna();
                $admFuncaoExterna->setFkAdministracaoFuncao($admFuncao);
                $admFuncaoExterna->setComentario("Criação automatica da PL, referente ao Manter Bases de Cálculo.");
                $admFuncaoExterna->setCorpoPl($corpoPL);
                $this->save($admFuncaoExterna);
                
                $arVariaveis = $this->montaVariavel();

                foreach ($arVariaveis as $chave => $dadosVariavel) {
                    $codVariavel = $entityManager->getRepository('CoreBundle:Administracao\Variavel')
                    ->getNexCodVariavel($object->getCodModulo(), $object->getCodBiblioteca(), $codFuncao);
                    $fkAdministracaoTipoPrimitivoVariavel = $entityManager->getRepository('CoreBundle:Administracao\TipoPrimitivo')
                    ->findOneByCodTipo($dadosVariavel['TIPO']);
                    
                    $obVariavel  = new \Urbem\CoreBundle\Entity\Administracao\Variavel();
                    $obVariavel->setFkAdministracaoFuncao($admFuncao);
                    $obVariavel->setFkAdministracaoTipoPrimitivo($fkAdministracaoTipoPrimitivoVariavel);
                    $obVariavel->setCodVariavel($codVariavel);
                    $obVariavel->setNomVariavel($dadosVariavel['DESCRICAO']);
                    $obVariavel->setValorInicial($dadosVariavel['VALOR']);
                    $this->save($obVariavel);
                }
            });
        } catch (\Exception $e) {
            $logger->error($e->getMessage());
            return false;
        }
    }
    
    /**
     * Persistencias adicionais
     * @param  object $object
     * @param  array $base
     * @param  Logger $logger
     * @return boolean
     */
    public function afterSaveBases($object, $base, Logger $logger)
    {
        try {
            return $this->entityManager->transactional(function ($entityManager) use ($object, $base) {
                $eventoModel = new \Urbem\CoreBundle\Model\Folhapagamento\EventoModel($entityManager);
                    
                foreach ($base['eventos'] as $chave => $inCodEvento) {
                    $obBasesEvento = new \Urbem\CoreBundle\Entity\Folhapagamento\BasesEvento();
                    $obEvento = $entityManager->getRepository('CoreBundle:Folhapagamento\Evento')
                    ->findOneByCodEvento($inCodEvento);
                    $obBasesEvento->setFkFolhapagamentoEvento($obEvento);
                    $obBasesEvento->setFkFolhapagamentoBases($object);
                    $this->save($obBasesEvento);
                }
                
                if ($object->getInsercaoAutomatica() == true) {
                    $fkFolhapagamentoVerbaRescisoriaMte = $entityManager->getRepository('CoreBundle:Folhapagamento\VerbaRescisoriaMte')
                    ->findOneByCodVerba(self::CODVERBA);
                    $obRFolhaPagamentoEvento = new \Urbem\CoreBundle\Entity\Folhapagamento\Evento();
                    $codEvento = $eventoModel->getProximoCodigo('cod_evento', 'folhapagamento.evento');
                    $obRFolhaPagamentoEvento->setCodEvento($codEvento);
                    $obRFolhaPagamentoEvento->setCodigo((int) $base['codigoEvento']);
                    $obRFolhaPagamentoEvento->setDescricao($base['descricaoEvento']);
                    $obRFolhaPagamentoEvento->setNatureza(self::NATUREZA);
                    $obRFolhaPagamentoEvento->setTipo(self::TIPO);
                    $obRFolhaPagamentoEvento->setFixado($base['tipoBase']);
                    $obRFolhaPagamentoEvento->setLimiteCalculo(false);
                    $obRFolhaPagamentoEvento->setApresentaParcela(false);
                    $obRFolhaPagamentoEvento->setEventoSistema($base['eventoSistema']);
                    $obRFolhaPagamentoEvento->setFkFolhapagamentoVerbaRescisoriaMte($fkFolhapagamentoVerbaRescisoriaMte);
                    
                    $eventoEvento = new \Urbem\CoreBundle\Entity\Folhapagamento\EventoEvento();
                    $eventoEvento->setObservacao("Evento criado automaticamente pela funcionalidade Bases de Cálculo.");
                    $eventoEvento->setValorQuantidade("0");
                    $eventoEvento->setUnidadeQuantitativa("0");
                    
                    $obRFolhaPagamentoEvento->addFkFolhapagamentoEventoEventos($eventoEvento);

                    $this->save($obRFolhaPagamentoEvento);
                        
                    $obSequencia = $entityManager->getRepository('CoreBundle:Folhapagamento\SequenciaCalculo')
                    ->findOneByCodSequencia($base['codSequencia']);
                    
                    $sequenciaCalculoEvento = new \Urbem\CoreBundle\Entity\Folhapagamento\SequenciaCalculoEvento();
                    $sequenciaCalculoEvento->setFkFolhapagamentoSequenciaCalculo($obSequencia);
                    $sequenciaCalculoEvento->setFkFolhapagamentoEvento($obRFolhaPagamentoEvento);
                    $this->save($sequenciaCalculoEvento);

                    $basesEventoCriado = new \Urbem\CoreBundle\Entity\Folhapagamento\BasesEventoCriado();
                    $basesEventoCriado->setFkFolhapagamentoBases($object);
                    $basesEventoCriado->setFkFolhapagamentoEvento($obRFolhaPagamentoEvento);
                    $this->save($basesEventoCriado);
                }
            });
        } catch (\Exception $e) {
            $logger->error($e->getMessage());
            return false;
        }
    }

    /**
     * @param object $object
     */
    public function beforeUpdateBases($object)
    {
        $basesEventos = $this->entityManager->getRepository('CoreBundle:Folhapagamento\BasesEvento')
            ->findByCodBase($object->getCodBase());

        foreach ($basesEventos as $basesEvento) {
            $this->entityManager->remove($basesEvento);
        }
        $this->entityManager->flush();
    }
    
    /**
     * @param  object $object
     * @param  object $form
     * @param  Logger $logger
     * @return boolean
     */
    public function afterUpdateBases($object, $form, Logger $logger)
    {
        try {
            return $this->entityManager->transactional(function ($entityManager) use ($object, $form) {

                $baseEvento = array_shift($object->getFkFolhapagamentoBasesEventoCriados()->toArray());

                $sequenciaCalculoEventos = $entityManager
                    ->getRepository('CoreBundle:Folhapagamento\SequenciaCalculoEvento')
                    ->findOneByCodEvento($baseEvento->getCodEvento());

                $sequenciaCalculoEventos->setFkFolhapagamentoSequenciaCalculo($form->get('codSequencia')->getData());

                foreach ($form->get('eventos')->getData() as $codEvento) {
                    $basesEvento = new BasesEvento();
                    $basesEvento->setCodBase($object->getCodBase());
                    $basesEvento->setCodEvento($codEvento);
                    $entityManager->persist($basesEvento);
                }
                $entityManager->flush();
            });
        } catch (\Exception $e) {
            $logger->error($e->getMessage());
            return false;
        }
    }
}
