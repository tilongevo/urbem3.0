<?php
namespace Urbem\CoreBundle\Model\Patrimonial\Frota;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\Mes;
use Urbem\CoreBundle\Entity\Frota\Escola;
use Urbem\CoreBundle\Entity\Frota\TransporteEscolar;
use Urbem\CoreBundle\Entity\Frota\Turno;
use Urbem\CoreBundle\Entity\Frota\Veiculo;
use Urbem\CoreBundle\Helper\ArrayHelper;

/**
 * Class TransporteEscolarModel
 */
class TransporteEscolarModel extends AbstractModel
{
    protected $entityManager = null;

    /** @var EntityRepository $repository */
    protected $repository = null;

    /**
     * TransporteEscolarModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(TransporteEscolar::class);
    }

    /**
     * @param Mes $mes
     * @param Veiculo $veiculo
     * @param Escola $escola
     * @param Turno $turno
     * @param array $data
     * @return TransporteEscolar
     * @throws \Exception
     */
    public function createTransporteEscolar(
        Mes $mes,
        Veiculo $veiculo,
        Escola $escola,
        Turno $turno,
        array $data
    ) {
        $mandatoryKeys = ['exercicio', 'passageiros', 'distancia', 'diasRodados'];

        if (false == ArrayHelper::arrayMultiKeysExists($mandatoryKeys, $data)) {
            throw new \Exception(sprintf(
                'Some mandatory parameters are missing ("%s")',
                implode('", "', $mandatoryKeys)
            ));
        }

        $data = ArrayHelper::transoformAllNullDataInZeros($data);

        $transporteEscolar = new TransporteEscolar();
        $transporteEscolar
            ->setFkAdministracaoMes($mes)
            ->setFkFrotaEscola($escola)
            ->setFkFrotaVeiculo($veiculo)
            ->setFkFrotaTurno($turno)
            ->setPassageiros($data['passageiros'])
            ->setDistancia($data['distancia'])
            ->setDiasRodados($data['diasRodados'])
            ->setExercicio($data['exercicio'])
        ;

        $this->save($transporteEscolar);

        return $transporteEscolar;
    }

    /**
     * @param TransporteEscolar $transporteEscolar
     * @param Turno $turno
     * @param array $data
     * @return TransporteEscolar
     * @throws \Exception
     */
    public function updateTransporteEscolar(
        TransporteEscolar $transporteEscolar,
        Turno $turno,
        array $data
    ) {
        $mandatoryKeys = ['passageiros', 'distancia', 'diasRodados'];

        if (false == ArrayHelper::arrayMultiKeysExists($mandatoryKeys, $data)) {
            throw new \Exception(sprintf(
                'Some mandatory parameters are missing ("%s")',
                implode('", "', $mandatoryKeys)
            ));
        }

        $data = ArrayHelper::transoformAllNullDataInZeros($data);

        $transporteEscolar
            ->setFkFrotaTurno($turno)
            ->setPassageiros($data['passageiros'])
            ->setDistancia($data['distancia'])
            ->setDiasRodados($data['diasRodados'])
        ;

        $this->save($transporteEscolar);

        return $transporteEscolar;
    }

    /**
     * Remove todos os registro 'linkados' com o objeto do tipo Escola
     *
     * @param Escola $escola
     */
    public function removeAllTransporteEscolaInEscola(Escola $escola)
    {
        /** @var TransporteEscolar $transporteEscolar */
        foreach ($escola->getFkFrotaTransporteEscolares() as $transporteEscolar) {
            $escola->removeFkFrotaTransporteEscolares($transporteEscolar);
            $this->remove($transporteEscolar);
        }
    }
}
