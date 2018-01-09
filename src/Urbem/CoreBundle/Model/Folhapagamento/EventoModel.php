<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento\EventoRepository;

class EventoModel
{
    private $entityManager = null;
    /** @var EventoRepository|null  */
    private $eventoRepository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->eventoRepository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\Evento");
    }

    /**
     * @param $sw
     * @param bool $eventoSistema
     * @param bool $tipo
     * @return mixed
     */
    public function getEventoByParams($sw, $eventoSistema = false, $tipo = false)
    {
        return $this->eventoRepository->getEventoByParams($sw, $eventoSistema, $tipo);
    }

    public function getEventoByCodEvento($codEvento)
    {
        $return = $this->eventoRepository->findOneByCodEvento($codEvento);
        return $return;
    }

    public function getEventoPensaoFuncaoPadrao()
    {
        $return = $this->eventoRepository->getEventoPensaoFuncaoPadrao();
        return $return;
    }

    public function getEventoPorNatureza($natureza)
    {
        $return = $this->eventoRepository->findEventosPorNatureza($natureza);
        return $return;
    }

    public function getAll()
    {
        $return = $this->eventoRepository->findAll();
        return $return;
    }

    public function getCodEventoSequenciaCalculo($codigo)
    {
        $return = $this->eventoRepository->getCodEventoSequenciaCalculo($codigo);
        return $return;
    }

    public function montaRecuperaEventosFormatado()
    {
        return $this->eventoRepository->montaRecuperaEventosFormatado();
    }

    public function executaFuncaoPL($sql)
    {
        return $this->eventoRepository->executaFuncaoPL($sql);
    }

    public function recuperaBibliotecaEntidade($cod_modulo, $exercicio)
    {
        return $this->eventoRepository->recuperaBibliotecaEntidade($cod_modulo, $exercicio);
    }

    public function getProximoCodigo($campo, $tabela)
    {
        return $this->eventoRepository->getProximoCodigo($campo, $tabela);
    }

    /**
     * Retorna a lista de eventos para os autocompletes customizados
     * @param  array $params
     * @return array
     */
    public function getApiEventoPorNatureza($params)
    {
        return $this->eventoRepository->findApiEventosPorNatureza($params);
    }

    /**
     * @param $codEvento
     * @param $timestamp
     * @return array
     */
    public function listarEventosBase($codEvento, $timestamp)
    {
        return $this->eventoRepository->listarEventosBase($codEvento, $timestamp);
    }

    /**
     * @param $codEvento
     * @return array
     */
    public function listarEvento($codEvento)
    {
        return $this->eventoRepository->listarEvento($codEvento);
    }

    /**
     * @param string $codigo
     * @param integer|null $codSubDivisao
     * @param integer|null $codEspecialidade
     * @return array
     */
    public function carregaConfiguracaoContratoManutencao($codigo, $codSubDivisao, $codEspecialidade)
    {
        return $this->eventoRepository->carregaConfiguracaoContratoManutencao($codigo, $codSubDivisao, $codEspecialidade);
    }

    /**
     * @return array
     */
    public function getEventos()
    {
        $data = [];
        $eventos = $this->eventoRepository->getEventos();
        if (count($eventos)) {
            foreach ($eventos as $evento) {
                $key = $evento['codigo'] . " - " . $evento['descricao'] . " - " . $evento['proventos_descontos'];
                $data[$key] = $evento['cod_evento'];
            }
        }

        return $data;
    }
}
