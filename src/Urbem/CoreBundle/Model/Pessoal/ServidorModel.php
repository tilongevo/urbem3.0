<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Pessoal\Servidor;
use Urbem\CoreBundle\Entity\Pessoal\ServidorCid;
use Urbem\CoreBundle\Entity\Pessoal\ServidorConjuge;
use Urbem\CoreBundle\Entity\Pessoal\ServidorPisPasep;
use Urbem\CoreBundle\Repository;

class ServidorModel extends AbstractModel
{
    /**
     * @var ORM\EntityManager|null
     */
    protected $entityManager = null;

    /**
     * @var ORM\EntityRepository|null|Repository\RecursosHumanos\Pessoal\ServidorRepository
     */
    protected $repository = null;

    /**
     * ServidorModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Servidor::class);
    }

    /**
     * @return int
     */
    public function getNextCodServidor()
    {
        return $this->repository->getNextCodServidor();
    }

    /**
     * Verificar se pode remover consultado as seguintes entidades de acordo com o sistema legado
     * @TODO TFolhaPagamentoContratoServidorPeriodo
     * TPessoalAdidoCedido
     * TPessoalAposentadoria
     * @TODO TPessoalAssentamentoGeradoContratoServidor?
     * TPessoalContratoServidorCasoCausa
     * TPessoalContratoServidorCedencia
     * TPessoalFerias
     * @TODO TPessoalContratoPensionista
     * @TODO TFolhaPagamentoConcessaoDecimo
     * @TODO TFolhaPagamentoContratoServidorComplementar
     * @TODO TFolhaPagamentoDescontoExternoIRRF
     * @TODO TFolhaPagamentoDescontoExternoPrevidencia
     * TBeneficioContratoServidorConcessaoValeTransporte
     * TBeneficioContratoServidorGrupoConcessaoValeTransport
     *
     * @param Servidor $servidor
     * @return bool
     */
    public function canRemove(Servidor $servidor)
    {
        $canRemove = true;

        $servidorContratoServidores = $servidor->getFkPessoalServidorContratoServidores();

        foreach ($servidorContratoServidores as $servidorContratoServidor) {
            $contratoServidor = $servidorContratoServidor->getFkPessoalContratoServidor();

            if (! $contratoServidor->getFkPessoalAdidoCedidos()->isEmpty()) {
                foreach ($contratoServidor->getFkPessoalAdidoCedidos() as $adidoCedido) {
                    $canRemove = $this->canRemoveWithAssociation($adidoCedido);

                    if ($canRemove) {
                        $this->remove($adidoCedido, false);
                    }
                }
            }

            if (! $contratoServidor->getFkPessoalAposentadorias()->isEmpty()) {
                foreach ($contratoServidor->getFkPessoalAposentadorias() as $aposentadoria) {
                    $canRemove = $this->canRemoveWithAssociation($aposentadoria);

                    if ($canRemove) {
                        $this->remove($aposentadoria, false);
                    }
                }
            }

            if (! $contratoServidor->getFkPessoalAposentadorias()->isEmpty()) {
                foreach ($contratoServidor->getFkPessoalAposentadorias() as $aposentadoria) {
                    $canRemove = $this->canRemoveWithAssociation($aposentadoria);

                    if ($canRemove) {
                        $this->remove($aposentadoria, false);
                    }
                }
            }

            $contratoServidorCasoCausa = $contratoServidor->getFkPessoalContratoServidorCasoCausa();

            if ($contratoServidorCasoCausa) {
                $canRemove = $this->canRemoveWithAssociation($contratoServidorCasoCausa);

                if ($canRemove) {
                    $this->remove($contratoServidorCasoCausa, false);
                }
            }

            $contratoServidorCedencia = $contratoServidor->getFkPessoalContratoServidorCedencia();

            if ($contratoServidorCedencia) {
                $canRemove = $this->canRemoveWithAssociation($contratoServidorCedencia);

                if ($canRemove) {
                    $this->remove($contratoServidorCedencia, false);
                }
            }

            if (! $contratoServidor->getFkPessoalFerias()->isEmpty()) {
                foreach ($contratoServidor->getFkPessoalFerias() as $ferias) {
                    $canRemove = $this->canRemoveWithAssociation($ferias);

                    if ($canRemove) {
                        $this->remove($ferias, false);
                    }
                }
            }

            if (! $contratoServidor->getFkPessoalContratoServidorValetransportes()->isEmpty()) {
                foreach ($contratoServidor->getFkPessoalContratoServidorValetransportes() as $contratoServidorValetransporte) {
                    $canRemove = $this->canRemoveWithAssociation($contratoServidorValetransporte);

                    if ($canRemove) {
                        $this->remove($contratoServidorValetransporte, false);
                    }
                }
            }

            if (! $contratoServidor->getFkBeneficioContratoServidorGrupoConcessaoValeTransportes()->isEmpty()) {
                foreach ($contratoServidor->getFkBeneficioContratoServidorGrupoConcessaoValeTransportes() as $contratoServidorGrupoConcessaoValeTransporte) {
                    $canRemove = $this->canRemoveWithAssociation($contratoServidorGrupoConcessaoValeTransporte);

                    if ($canRemove) {
                        $this->remove($contratoServidorGrupoConcessaoValeTransporte, false);
                    }
                }
            }

            if ($contratoServidor) {
                $canRemove = $this->canRemoveWithAssociation($contratoServidor);

                if ($canRemove) {
                    $this->remove($contratoServidor, false);
                }
            }
        }

        if ($canRemove) {
            $this->entityManager->flush();
        }

        return $canRemove;
    }

    public function saveServidorReservista(Servidor $servidor, $formData)
    {
        $fkPessoalServidorReservista = $formData->get('fkPessoalServidorReservista')->getData();

        if (! $fkPessoalServidorReservista->getNrCarteiraRes()) {
            $fkPessoalServidorReservista->setNrCarteiraRes('');
        }
        if (! $fkPessoalServidorReservista->getCatReservista()) {
            $fkPessoalServidorReservista->setCatReservista('');
        }
        if (! $fkPessoalServidorReservista->getOrigemReservista()) {
            $fkPessoalServidorReservista->setOrigemReservista('');
        }

        $servidor->setFkPessoalServidorReservista($fkPessoalServidorReservista);
    }

    /**
     * @param Servidor $servidor
     * @param $formData
     */
    public function saveServidorConjuge(Servidor $servidor, $formData)
    {
        if ($formData->get('conjuge')->getData()) {
            $fkPessoalServidorConjuges = new ServidorConjuge();
            $fkPessoalServidorConjuges->setFkPessoalServidor($servidor);
            $fkPessoalServidorConjuges->setFkSwCgmPessoaFisica($formData->get('conjuge')->getData());

            $servidor->addFkPessoalServidorConjuges($fkPessoalServidorConjuges);
        }
    }

    /**
     * @param Servidor $servidor
     * @param $formData
     */
    public function saveServidorCid(Servidor $servidor, $formData)
    {
        if ($formData->get('cidEntity')->getData()) {
            $fkPessoalServidorCids = new ServidorCid();
            $fkPessoalServidorCids->setFkPessoalServidor($servidor);
            $fkPessoalServidorCids->setFkPessoalCid($formData->get('cidEntity')->getData());
            $fkPessoalServidorCids->setDataLaudo($formData->get('dataLaudoCid')->getData());

            $servidor->addFkPessoalServidorCids($fkPessoalServidorCids);
        }
    }

    /**
     * @param Servidor $servidor
     * @param $formData
     */
    public function saveServidorPisPasep(Servidor $servidor, $formData)
    {
        $fkPessoalServidorPisPaseps = new ServidorPisPasep();
        $fkPessoalServidorPisPaseps->setDtPisPasep($formData->get('dtPisPasep')->getData());
        $fkPessoalServidorPisPaseps->setFkPessoalServidor($servidor);

        $servidor->addFkPessoalServidorPisPaseps($fkPessoalServidorPisPaseps);
    }

    /**
     * @param Servidor $servidor
     * @param $formData
     */
    public function saveSwCgmPessoaFisica(Servidor $servidor, $formData)
    {
        $dtNascimento = $formData->get('dtNascimento')->getData();
        $pis = $formData->get('pis')->getData();
        $cpf = $formData->get('cpf')->getData();

        $fkSwCgmPessoaFisica = $servidor->getFkSwCgmPessoaFisica();
        $fkSwCgmPessoaFisica
            ->setDtNascimento($dtNascimento)
            ->setServidorPisPasep($pis)
            ->setCpf($cpf);

        $this->entityManager->persist($fkSwCgmPessoaFisica);
    }

    /**
     * Confecciona os dados de servidor.
     * @param Servidor $servidor
     * @param $formData
     */
    public function buildServidor(Servidor $servidor, $formData)
    {
        $servidor->setCodServidor($this->getNextCodServidor());
        $fkSwMunicipio = $formData->get('municipioCgm')->getData();
        $servidor->setFkSwMunicipio($fkSwMunicipio);
        $servidor->getFkPessoalServidorReservista()->setFkPessoalServidor($servidor);

        $this->saveServidorReservista($servidor, $formData);
        $this->saveServidorConjuge($servidor, $formData);
        $this->saveServidorCid($servidor, $formData);
        $this->saveServidorPisPasep($servidor, $formData);
        $this->saveSwCgmPessoaFisica($servidor, $formData);
    }

    public function updateServidor(Servidor $servidor, $formData)
    {
        $this->saveServidorReservista($servidor, $formData);
        $this->saveServidorCid($servidor, $formData);
        $this->saveServidorPisPasep($servidor, $formData);
        $this->saveSwCgmPessoaFisica($servidor, $formData);
    }

    /**
     * @param $filtro
     * @return array
     */
    public function getRelatorioServidor($filtro)
    {
        return $this->repository->getRelatorioServidor($filtro);
    }

    /**
     * @param $filtro
     * @return array
     */
    public function getRelatorioServidor2($filtro)
    {
        return $this->repository->getRelatorioServidor2($filtro);
    }

    /**
     * @param $filtro
     * @return array
     */
    public function getDependentesServidor($filtro)
    {
        return $this->repository->getDependentesServidor($filtro);
    }
}
