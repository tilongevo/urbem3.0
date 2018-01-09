<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\Pessoal\Cargo;
use Urbem\PrestacaoContasBundle\Model\PgNamespaceModel;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeCargoServidor;

/**
 * Class ConfiguracaoTipoCargoServidor
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao
 */
final class ConfiguracaoTipoCargoServidor extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    const COD_ENTIDADE_PREFEITURA = 'cod_entidade_prefeitura';
    const SCHEMA_PESSOAL = 'pessoal';
    const SCHEMA_FOLHA_PAGAMENTO = 'folhapagamento';

    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/MG/ConfiguracaoTipoCargoRemuneracao.js',
        ];
    }

    /**
     * @return string
     */
    public function dynamicBlockJs()
    {
        return parent::dynamicBlockJs();
    }

    /**
     * @return array
     */
    public function processParameters()
    {
        $params = parent::processParameters();
        return $params;
    }

    /**
     * @return bool
     */
    public function save()
    {
        $formData = (array) $this->getFormSonata();

        $formData = array_shift($formData);
        try {
            $entityManager = $this->factory->getEntityManager();
            $exercicio = $this->factory->getSession()->getExercicio();
            $parameters = array_shift($formData);
            $codEntidade = $this->getCodEntidade($parameters['entidade']);

            /** @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConfiguracaoTipoCargoRemuneracao.php:62 */
            $configuracao = $entityManager->getRepository(Configuracao::class)->findOneBy(['exercicio' => $exercicio, 'parametro' => self::COD_ENTIDADE_PREFEITURA]);
            if (!$configuracao instanceof Configuracao) {
                throw new \Exception('Não existe entidade definida como prefeitura na configuração do orçamento');
            }

            $schemaFolhaPagamento = $this->getSchemaFolhaPagamento($configuracao, $codEntidade);
            $repository = $entityManager->getRepository(TcemgEntidadeCargoServidor::class);
            $repository->deleteEntidadeCargoServidor($exercicio, $schemaFolhaPagamento);

            if (isset($parameters['registros'])) {
                $registros = array_shift($parameters['registros']);
                $this->validateCargos($registros);

                foreach ($registros as $registro) {
                    $tipoCargo = $registro['tipoCargo'];
                    $regimeArray = $registro['regime'];
                    $cargoArray = $registro['cargoServidor'];
                    foreach ($regimeArray as $regime) {
                        foreach ($cargoArray as $cargo) {
                            $repository->saveTipoCargoServidor($exercicio, $schemaFolhaPagamento, $tipoCargo, $regime, $cargo);
                        }
                    }
                }
            }

            return true;
        } catch (\Exception $e) {
            $this->setErrorMessage($e->getMessage());
            return false;
        }
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function actionLoadCargoServidor()
    {
        $em = $this->factory->getEntityManager();
        $exercicio = $this->factory->getSession()->getExercicio();
        $codEntidade = $this->getCodEntidade($this->getRequest()->get('entidade'));

        /** @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConfiguracaoTipoCargoRemuneracao.php:62 */
        $configuracao = $em->getRepository(Configuracao::class)->findOneBy(['exercicio' => $exercicio, 'parametro' => self::COD_ENTIDADE_PREFEITURA]);
        if (!$configuracao instanceof Configuracao) {
            throw new \Exception('Não existe entidade definida como prefeitura na configuração do orçamento');
        }
        $schemaPessoal = $this->getSchemaPessoal($configuracao, $codEntidade);
        $schemaFolhaPagamento = $this->getSchemaFolhaPagamento($configuracao, $codEntidade);
        $result = $em->getRepository(TcemgEntidadeCargoServidor::class)->getTipoCargoServidor($exercicio, $schemaFolhaPagamento, $schemaPessoal);

        return [
            'content' => $this->normalizeData($result),
        ];
    }

    /**
     * @throws \Exception
     */
    public function actionValidateCargoServidor()
    {
        $formData = (array) $this->getFormSonata();

        $parameters = array_shift($formData);
        if (isset($parameters['registros'])) {
            $this->validateCargos(array_shift($parameters['registros']));
        }

        return [
            'content' => true
        ];
    }

    /**
     * @param array $registros
     * @return bool|string
     * @throws \Exception
     */
    protected function validateCargos(array $registros)
    {
        $cargoServidor = [];
        foreach ($registros as $registro) {
            $cargoServidor = array_merge($cargoServidor, $registro['cargoServidor']);
        }
        $cargo = $this->getDuplicateValues($cargoServidor);
        /** @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterConfiguracaoTipoCargoRemuneracao.php:191 */
        if ($cargo) {
            throw new \Exception("Este Regime/Subdivisão e Cargo {$cargo} já está sendo usado em outro Tipo de Cargo!");
        }

        return $cargo;
    }

    /**
     * @param array $data
     * @return bool|string
     */
    protected function getDuplicateValues(array $data)
    {
        $cargo = false;
        $values = array_unique(array_diff_assoc($data, array_unique($data)));
        if (count($values)) {
            /** @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterConfiguracaoTipoCargoRemuneracao.php:191 */
            $cargo = $this->getCargo(array_shift($values));
        }

        return $cargo;
    }


    /**
     * @param $codCargo
     * @return string
     */
    protected function getCargo($codCargo)
    {
        $cargo = $this->factory->getEntityManager()->getRepository(Cargo::class)->findOneBy(['codCargo' => $codCargo]);
        if ($cargo instanceof Cargo) {

            return $cargo->getCodCargo() . " - " . $cargo->getDescricao();
        }

        return $codCargo;
    }

    /**
     * @param TwigEngine|null $templating
     * @return array
     * * @throws \Exception
     */
    public function buildServiceProvider(TwigEngine $templating = null)
    {
        $action = (string) $this->getRequest()->get('action');
        $action = sprintf('action%s', ucfirst($action));

        if (false === method_exists($this, $action)) {
            return [
                'response' => false,
                'message' => sprintf('action %s not found', $action)
            ];
        }

        try {
            return [
                    'response' => true,
                    // action* methods must always return an array
                ] + call_user_func_array([$this, $action], [$templating]);

        } catch (\Exception $e) {
            return [
                'response' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * @param array $data
     * @return array
     */
    protected function normalizeData(array $data)
    {
        $result = [];
        if (count($data)) {
            foreach ($data as $item) {
                $result[$item['cod_tipo']]['cod_cargo'][] = $item['cod_cargo'];
                $result[$item['cod_tipo']]['cod_sub_divisao'][] = $item['cod_sub_divisao'];
            }
        }

        return $result;
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface $objectAdmin
     */
    public function view(FormMapper $formMapper, TceInterface $objectAdmin)
    {
        $formMapper = parent::view($formMapper, $objectAdmin);
    }

    /**
     * @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConfiguracaoTipoCargoRemuneracao.php:82
     *
     * @param Configuracao $configuracao
     * @param $codEntidade
     * @return mixed
     * @throws \Exception
     */
    protected function getSchemaPessoal(Configuracao $configuracao, $codEntidade)
    {
        $schema = $configuracao->getValor() == $codEntidade ? self::SCHEMA_PESSOAL : self::SCHEMA_PESSOAL . '_' . $codEntidade;
        $result = $this->getPgNamespaceModel()->getSchemasCreated($schema);
        if (!count($result)) {
            throw new \Exception('Não existe entidade criada no RH para a entidade selecionada!');
        }
        $result = array_shift($result);

        return $result['nspname'];
    }

    /**
     * @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConfiguracaoTipoCargoRemuneracao.php:87
     *
     * @param Configuracao $configuracao
     * @param $codEntidade
     * @return string
     */
    protected function getSchemaFolhaPagamento(Configuracao $configuracao, $codEntidade)
    {
        return $configuracao->getValor() == $codEntidade ? self::SCHEMA_FOLHA_PAGAMENTO : self::SCHEMA_FOLHA_PAGAMENTO. '_' . $codEntidade;
    }

    /**
     * @return PgNamespaceModel
     */
    protected function getPgNamespaceModel()
    {
        return new PgNamespaceModel($this->factory->getEntityManager());
    }

}