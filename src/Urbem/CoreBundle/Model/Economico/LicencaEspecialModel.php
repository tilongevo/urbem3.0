<?php

namespace Urbem\CoreBundle\Model\Economico;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Economico\LicencaAtividade;
use Urbem\CoreBundle\Entity\Economico\LicencaEspecial;

/**
 * Class LicencaEspecialModel
 * @package Urbem\CoreBundle\Model\Economico
 */
class LicencaEspecialModel extends AbstractModel
{
    protected $entityManager;
    protected $repository;

    /**
     * LicencaEspecialModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(LicencaEspecial::class);
    }

    /**
     * @param $search
     * @return mixed
     */
    public function getSwCgmInscricaoEconomica($search)
    {
        return $this->repository->getSwCgmInscricaoEconomica($search);
    }

    /**
     * @param $inscricaoEconomica
     * @return mixed
     */
    public function getSwCgmByInscricaoEconomica($inscricaoEconomica)
    {
        return $this->repository->getSwCgmByInscricaoEconomica($inscricaoEconomica);
    }

    /**
     * @param $inscricaoEconomica
     * @return mixed
     */
    public function getOcorrenciaLicencaByInscricaoEconomica($inscricaoEconomica)
    {
        return $this->repository->getOcorrenciaLicencaByInscricaoEconomica($inscricaoEconomica);
    }

    /**
     * @param $codLicenca
     * @param $exercicio
     * @return null|object
     */
    public function getLicencaEspecialByCodLicencaAndExercicio($codLicenca, $exercicio)
    {
        return $this->repository->findOneBy(['codLicenca' => $codLicenca, 'exercicio' => $exercicio]);
    }

    /**
     * @param $codLicenca
     * @param $exercicio
     * @return null|object
     */
    public function getLicencaEspecialFindByCodLicencaAndExercicio($codLicenca, $exercicio)
    {
        return $this->repository->findBy(['codLicenca' => $codLicenca, 'exercicio' => $exercicio]);
    }

    /**
     * @param $entity
     * @param $atividades
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function saveLicencaEspecial($entity, $atividades)
    {
        foreach ($atividades as $codAtividade) {
            $atividadeCadastroEconomico = $this->entityManager->getRepository("CoreBundle:Economico\\AtividadeCadastroEconomico")
                ->findOneByCodAtividade($codAtividade);
            $licencaEspecial = new LicencaEspecial();
            $licencaEspecial->setDtInicio($entity->getDtInicio());
            $licencaEspecial->setDtTermino($entity->getDtTermino());
            $licencaEspecial->setOcorrenciaLicenca($entity->getOcorrenciaLicenca());
            $licencaEspecial->setFkEconomicoLicenca($entity->getFkEconomicoLicenca());
            $licencaEspecial->setFkEconomicoAtividadeCadastroEconomico($atividadeCadastroEconomico);
            $this->entityManager->persist($licencaEspecial);
        }
        $this->entityManager->flush();
        return (new RedirectResponse(sprintf('/tributario/cadastro-economico/licenca/licenca-especial/%d~%s/show-licenca-especial', $entity->getCodLicenca(), $entity->getExercicio())))->send();
    }

    /**
     * @param $entity
     * @param $atividades
     * @param $licenca
     */
    public function updateLicencaEspecial($entity, $atividades, $licenca)
    {
        foreach ($atividades as $codAtividade) {
            $atividadeCadastroEconomico = $this->entityManager->getRepository("CoreBundle:Economico\\AtividadeCadastroEconomico")
                ->findOneByCodAtividade($codAtividade);
            $licencaEspecial = $this->entityManager->getRepository(LicencaEspecial::class)
                ->findOneBy(['codLicenca' => $licenca, 'codAtividade' => $codAtividade]);
            $licencaEspecial->setFkEconomicoAtividadeCadastroEconomico($atividadeCadastroEconomico);
            $this->entityManager->persist($licencaEspecial);
        }
        return $this->entityManager->flush();
    }

    /**
    * @param LicencaEspecial $licencaEspecial
    * @return array
    */
    public function fetchDadosAlvaraHorarioEspecialSanitarioMariana(LicencaEspecial $licencaEspecial, $exercicio)
    {
        $dadosArquivo = $this->repository->fetchDadosAlvaraHorarioEspecialSanitarioMariana([
            'codLicenca' => $licencaEspecial->getCodLicenca(),
            'exercicioLicenca' => $licencaEspecial->getExercicio(),
            'inscricaoEconomica' => $licencaEspecial->getInscricaoEconomica(),
            'exercicio' => $exercicio,
        ]);

        $dadosArquivo = reset($dadosArquivo);
        $dadosArquivo['cnpj_cpf'] = $this->mask($dadosArquivo['cnpj_cpf'], '##.###.###/####-##');
        if ($dadosArquivo['cpf']) {
            $dadosArquivo['cnpj_cpf'] = $this->mask($dadosArquivo['cpf'], '###.###.###-##');
        }

        return [
            'blocks' => [
                'IE' => [$dadosArquivo],
                'Ati' => $this->repository->fetchDadosAtividadesSecundarias([
                    'inscricaoEconomica' => $licencaEspecial->getInscricaoEconomica(),
                ]),
                'Hor' => $this->repository->fetchDadosHorariosEspeciais([
                    'exercicioLicenca' => $licencaEspecial->getExercicio(),
                    'codLicenca' => $licencaEspecial->getCodLicenca(),
                ]),
                'Sanit' => $this->repository->fetchDadosSanit([
                    'exercicio' => $exercicio,
                ]),
            ],
            'vars' => [],
        ];
    }

    /**
    * @param string $val
    * @param string $mask
    * @return string
    */
    protected function mask($val, $mask)
    {
        $maskared = '';
        $k = 0;
        for ($i=0; $i<=strlen($mask)-1; $i++) {
            if ($mask[$i] == '#') {
                if (isset($val[$k])) {
                    $maskared .= $val[$k++];
                }
            } else {
                if (isset($mask[$i])) {
                    $maskared .= $mask[$i];
                }
            }
        }
        return $maskared;
    }
}
