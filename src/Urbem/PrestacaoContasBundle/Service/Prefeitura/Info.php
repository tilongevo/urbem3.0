<?php

namespace Urbem\PrestacaoContasBundle\Service\Prefeitura;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\SwMunicipioModel;
use Urbem\CoreBundle\Model\SwUfModel;

/**
 * Class Info
 *
 * @package Urbem\PrestacaoContasBundle\Service\Municipio
 */
class Info
{
    /** @var EntityManager */
    private $entityManager;

    /**
     * Info constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Retorna o email da Prefeitura em administracao.configuracao e public.sw_uf.
     *
     * @return string
     */
    public function getUf()
    {
        $swUf = (new SwUfModel($this->entityManager))
            ->getSwUfByConfiguracao(date('Y'));

        return strtoupper($swUf->getSiglaUf());
    }

    /**
     * Retorna o nome da Prefeitura em administracao.configuracao.
     *
     * @return mixed
     */
    public function getNomePrefeitura()
    {
        $nomePrefeitura = (new ConfiguracaoModel($this->entityManager))
            ->getConfiguracaoOuAnterior('nom_prefeitura', Modulo::MODULO_ADMINISTRATIVO, date('Y'));

        return $nomePrefeitura;
    }

    /**
     * Retorna o código do IBGE da Prefeitura em administracao.configuracao.
     *
     * @return mixed
     */
    public function getCodigoIbge()
    {
        $codigoIbge = (new ConfiguracaoModel($this->entityManager))
            ->getConfiguracaoOuAnterior('codigo_ibge', Modulo::MODULO_ADMINISTRATIVO, date('Y'));

        return $codigoIbge;
    }

    /**
     * Retorna o email da Prefeitura em administracao.configuracao.
     *
     * @return mixed
     */
    public function getEmail()
    {
        $email = (new ConfiguracaoModel($this->entityManager))
            ->getConfiguracaoOuAnterior('e_mail', Modulo::MODULO_ADMINISTRATIVO, date('Y'));

        return $email;
    }

    /**
     * Retorna o informação de backup da Prefeitura em configuracao.modulos.administracao.itens.server_backup
     *
     * @return bool
     */
    public function hasBackupExecution()
    {
        $backup = (new ConfiguracaoModel($this->entityManager))
            ->getConfiguracaoOuAnterior('server_backup', Modulo::MODULO_ADMINISTRATIVO, date('Y'));

        return strtoupper($backup) === "S";
    }

    /**
     * @return string
     */
    public function getMunicipio()
    {
        $municipio = (new SwMunicipioModel($this->entityManager))
            ->getSwMunicipioByConfiguracao(date('Y'));

        return $municipio->getNomMunicipio();
    }

    /**
     * Retorna o email da Prefeitura em administracao.configuracao.
     *
     * @return mixed
     */
    public function getCnpj()
    {
        $cnpj = (new ConfiguracaoModel($this->entityManager))
            ->getConfiguracaoOuAnterior('cnpj', Modulo::MODULO_ADMINISTRATIVO, date('Y'));

        return $cnpj;
    }
}
