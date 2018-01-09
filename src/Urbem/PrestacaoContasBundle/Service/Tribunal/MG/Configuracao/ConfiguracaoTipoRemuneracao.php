<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeRemuneracao;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\CoreBundle\Entity\Folhapagamento\Evento;

/**
 * Class ConfiguracaoTipoRemuneracao
 * @package Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao
 */
final class ConfiguracaoTipoRemuneracao extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/MG/ConfiguracaoTipoRemuneracao.js',
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
            $configuracao = $entityManager->getRepository(Configuracao::class)->findOneBy(['exercicio' => $exercicio, 'parametro' => ConfiguracaoTipoCargoServidor::COD_ENTIDADE_PREFEITURA]);
            if (!$configuracao instanceof Configuracao) {
                throw new \Exception('Não existe entidade definida como prefeitura na configuração do orçamento');
            }

            $schemaFolhaPagamento = $this->getSchemaFolhaPagamento($configuracao, $codEntidade);
            $repository = $entityManager->getRepository(TcemgEntidadeRemuneracao::class);
            $repository->deleteRemuneracao($exercicio, $schemaFolhaPagamento);

            if (isset($parameters['registros'])) {
                $registros = array_shift($parameters['registros']);
                $this->validateEventos($registros);

                foreach ($registros as $registro) {
                    $remuneracao = $registro['remuneracao'];
                    $eventoArray = $registro['evento'];
                    foreach ($eventoArray as $evento) {
                        $repository->save($exercicio, $schemaFolhaPagamento, $remuneracao, $evento);
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
    public function actionLoadTipoRemuneracao()
    {
        $em = $this->factory->getEntityManager();
        $exercicio = $this->factory->getSession()->getExercicio();
        $codEntidade = $this->getCodEntidade($this->getRequest()->get('entidade'));

        /** @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConfiguracaoTipoCargoRemuneracao.php:62 */
        $configuracao = $em->getRepository(Configuracao::class)->findOneBy(['exercicio' => $exercicio, 'parametro' => ConfiguracaoTipoCargoServidor::COD_ENTIDADE_PREFEITURA]);
        if (!$configuracao instanceof Configuracao) {
            throw new \Exception('Não existe entidade definida como prefeitura na configuração do orçamento');
        }
        $schemaFolhaPagamento = $this->getSchemaFolhaPagamento($configuracao, $codEntidade);
        $result = $em->getRepository(TcemgEntidadeRemuneracao::class)->getRemuneracao($exercicio, $schemaFolhaPagamento);

        return [
            'content' => $this->normalizeData($result),
        ];
    }

    /**
     * @throws \Exception
     */
    public function actionValidateRemuneracao()
    {
        $formData = (array) $this->getFormSonata();

        $parameters = array_shift($formData);
        if (isset($parameters['registros'])) {
            $this->validateEventos(array_shift($parameters['registros']));
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
    protected function validateEventos(array $registros)
    {
        $eventos = [];
        foreach ($registros as $registro) {
            $eventos = array_merge($eventos, $registro['evento']);
        }
        $evento = $this->getDuplicateValues($eventos);
        /** @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterConfiguracaoTipoCargoRemuneracao.php:461 */
        if ($evento) {
            throw new \Exception("Este Evento {$evento} já está sendo usado em outro Tipo de Remuneração!");
        }

        return $evento;
    }

    /**
     * @param array $data
     * @return bool|string
     */
    protected function getDuplicateValues(array $data)
    {
        $evento = false;
        $values = array_unique(array_diff_assoc($data, array_unique($data)));
        if (count($values)) {
            /** @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterConfiguracaoTipoCargoRemuneracao.php:461 */
            $evento = $this->getEvento(array_shift($values));
        }

        return $evento;
    }

    /**
     * @param $codEvento
     * @return string
     */
    protected function getEvento($codEvento)
    {
        $evento = $this->factory->getEntityManager()->getRepository(Evento::class)->findOneBy(['codEvento' => $codEvento]);
        if ($evento instanceof Evento) {

            return $evento->getCodEvento() . " - " . $evento->getDescricao();
        }

        return $evento;
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
                $result[$item['cod_tipo']]['cod_evento'][] = $item['cod_evento'];
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
     * @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConfiguracaoTipoCargoRemuneracao.php:87
     *
     * @param Configuracao $configuracao
     * @param $codEntidade
     * @return string
     */
    protected function getSchemaFolhaPagamento(Configuracao $configuracao, $codEntidade)
    {
        return $configuracao->getValor() == $codEntidade ? ConfiguracaoTipoCargoServidor::SCHEMA_FOLHA_PAGAMENTO : ConfiguracaoTipoCargoServidor::SCHEMA_FOLHA_PAGAMENTO. '_' . $codEntidade;
    }
}