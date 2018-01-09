<?php

namespace Urbem\CoreBundle\Model\Economico;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Economico\LicencaAtividade;

/**
 * Class LicencaAtividadeModel
 * @package Urbem\CoreBundle\Model\Economico
 */
class LicencaAtividadeModel extends AbstractModel
{
    protected $entityManager;
    protected $repository;

    /**
     * LicencaAtividadeModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(LicencaAtividade::class);
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
     * @param $codLicenca
     * @param $exercicio
     * @return array
     */
    public function getLicencaAtividadeByCodLicencaAndExercicio($codLicenca, $exercicio)
    {
        return $this->repository->findBy(['codLicenca' => $codLicenca, 'exercicio' => $exercicio]);
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
     * @param $entity
     * @param $atividades
     * @return mixed
     */
    public function saveLicencaAtividades($entity, $atividades)
    {
        foreach ($atividades as $codAtividade) {
            $atividadeCadastroEconomico = $this->entityManager->getRepository("CoreBundle:Economico\\AtividadeCadastroEconomico")
                ->findOneByCodAtividade($codAtividade);
            $licencaAtividade = new LicencaAtividade();
            $licencaAtividade->setDtInicio($entity->getDtInicio());
            $licencaAtividade->setDtTermino($entity->getDtTermino());
            $licencaAtividade->setOcorrenciaLicenca($entity->getOcorrenciaLicenca());
            $licencaAtividade->setFkEconomicoLicenca($entity->getFkEconomicoLicenca());
            $licencaAtividade->setFkEconomicoAtividadeCadastroEconomico($atividadeCadastroEconomico);
            $this->entityManager->persist($licencaAtividade);
        }
        $this->entityManager->flush();
        return (new RedirectResponse(sprintf('/tributario/cadastro-economico/licenca/licenca-atividade/%d~%s/show-licenca-atividades', $entity->getCodLicenca(), $entity->getExercicio())))->send();
    }

    /**
     * @param $entity
     * @param $atividades
     * @param $licenca
     * @return mixed
     */
    public function updateLicencaAtividades($entity, $atividades, $licenca)
    {
        foreach ($atividades as $codAtividade) {
            $atividadeCadastroEconomico = $this->entityManager->getRepository("CoreBundle:Economico\\AtividadeCadastroEconomico")
                ->findOneByCodAtividade($codAtividade);
            $licencaAtividade = $this->entityManager->getRepository(LicencaAtividade::class)
                ->findOneBy(['codLicenca' => $licenca, 'codAtividade' => $codAtividade]);
            $licencaAtividade->setFkEconomicoAtividadeCadastroEconomico($atividadeCadastroEconomico);
            $this->entityManager->persist($licencaAtividade);
        }
        $this->entityManager->flush();

        return (new RedirectResponse("/tributario/cadastro-economico/licenca/licenca-atividade/list"))->send();
    }

    /**
    * @param LicencaAtividade $licencaAtividade
    * @param int $exercicio
    * @return array
    */
    public function fetchDadosAlvaraSanitarioMariana(LicencaAtividade $licencaAtividade, $exercicio)
    {
        $dadosArquivo = $this->repository->fetchDadosAlvaraSanitarioMariana([
            'codLicenca' => $licencaAtividade->getCodLicenca(),
            'exercicioLicenca' => $licencaAtividade->getExercicio(),
            'inscricaoEconomica' => $licencaAtividade->getInscricaoEconomica(),
            'exercicio' => $exercicio,
        ]);

        $dadosArquivo = reset($dadosArquivo);
        $dadosArquivo['cnpj_cpf'] = '';
        if ($dadosArquivo['cpf']) {
            $dadosArquivo['cnpj_cpf'] = $this->mask($dadosArquivo['cpf'], '###.###.###-##');
        }

        if ($dadosArquivo['cnpj']) {
            $dadosArquivo['cnpj_cpf'] = $this->mask($dadosArquivo['cnpj'], '##.###.###/####-##');
        }

        return [
            'blocks' => [
                'IE' => [$dadosArquivo],
                'Ati' => $this->repository->fetchDadosAtividadesSecundarias([
                    'inscricaoEconomica' => $licencaAtividade->getInscricaoEconomica(),
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
