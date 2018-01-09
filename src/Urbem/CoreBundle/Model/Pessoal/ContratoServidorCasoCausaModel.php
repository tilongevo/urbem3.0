<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\Folhapagamento\EventoDecimoCalculado;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Pessoal\CasoCausa;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCasoCausa;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;

class ContratoServidorCasoCausaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;
    const PARAMETRO = 'dtContagemInicial';

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(ContratoServidorCasoCausa::class);
    }

    /**
     * Pegar as informações do Caso da Causa e retorna para o controller
     * @param $codContrato
     * @param $codCausaRescisao
     * @param $dtRescisao
     * @param $exercicio
     * @return bool
     */
    public function getCasoCausa($codContrato, $codCausaRescisao, $dtRescisao, $exercicio)
    {
        $params = [];

        $contrato = $this->entityManager->getRepository(Contrato::class)
        ->findOneByCodContrato($codContrato);
        $contratoServidorNomeacaoPosse = $contrato->getFkPessoalContratoServidor()
        ->getFkPessoalContratoServidorNomeacaoPosses()->last()
        ;

        if (! $contratoServidorNomeacaoPosse) {
            return false;
        }

        /** Verifica por qual campo de ContratoServidorNomeacaoPosse deve ser feito o cálculo */
        $configuracao = $this->entityManager->getRepository(Configuracao::class)
        ->findOneBy([
            'codModulo' => ConfiguracaoModel::MODULO_RH_RESCISAO_CONTRATO,
            'parametro' => self::PARAMETRO,
            'exercicio' => $exercicio
        ]);

        $dtInicial = "";

        if ($configuracao) {
            switch ($configuracao->getValor()) {
                case 'dtNomeacao':
                    $dtInicial = $contratoServidorNomeacaoPosse->getDtNomeacao();
                    break;
                case 'dtPosse':
                    $dtInicial = $contratoServidorNomeacaoPosse->getDtPosse();
                    break;
                case 'dtAdmissao':
                    $dtInicial = $contratoServidorNomeacaoPosse->getDtAdmissao();
                    break;
            }

            $intervalo = (new \DateTime($dtRescisao))->diff($dtInicial);

            $params['meses'] = $intervalo->m + ($intervalo->y * 12);
            $params['codCausaRescisao'] = $codCausaRescisao;
            $params['codSubDivisao'] = $contrato
            ->getFkPessoalContratoServidor()->getCodSubDivisao();

            return $this->entityManager->getRepository(CasoCausa::class)
            ->getDescricaoCasoCausa($params);
        }

        return false;
    }


    /**
     * Retorna os Eventos de Décimo Terceiro calculados
     * @param $codContrato
     * @return mixed
     */
    public function getEventosCalculados($codContrato)
    {
        $codPeriodoMovimentacao = $this->entityManager->getRepository(PeriodoMovimentacao::class)
        ->montaRecuperaUltimaMovimentacao();

        return $this->entityManager->getRepository(EventoDecimoCalculado::class)
        ->getEventosCalculados([
            'codContrato' => $codContrato,
            'codPeriodoMovimentacao' => $codPeriodoMovimentacao['cod_periodo_movimentacao']
        ]);
    }

    /**
     * @param $stFiltroContratos
     * @param $stOrdem
     * @param $exercicio
     * @param $periodoMovimentacao
     *
     * @return array
     */
    public function recuperaTermoRescisao($stFiltroContratos, $stOrdem, $exercicio, $periodoMovimentacao)
    {
        return $this->repository->recuperaTermoRescisao($stFiltroContratos, $stOrdem, $exercicio, $periodoMovimentacao);
    }

    /**
     * @param $stFiltro
     *
     * @return mixed
     */
    public function recuperaTodos($stFiltro)
    {
        return $this->repository->recuperaTodos($stFiltro);
    }

    /**
     * @param bool $stFiltro
     *
     * @return mixed
     */
    public function recuperaSefipContrato($stFiltro = false)
    {
        return $this->repository->recuperaSefipContrato($stFiltro);
    }
}
