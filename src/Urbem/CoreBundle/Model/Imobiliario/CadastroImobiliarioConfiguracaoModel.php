<?php
namespace Urbem\CoreBundle\Model\Imobiliario;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\TributarioBundle\Controller\Imobiliario\ConfiguracaoController;

class CadastroImobiliarioConfiguracaoModel extends AbstractModel
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * ConfiguracaoModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param $parametro
     * @param $codModulo
     * @param $exercicio
     * @return bool
     */
    public function recuperaConfiguracaoBooleano($parametro, $codModulo, $exercicio)
    {
        $valor = false;
        $configuracao = (new ConfiguracaoModel($this->entityManager))
            ->pegaConfiguracao($parametro, $codModulo, $exercicio);

        if (isset($configuracao[0]['valor']) && $configuracao[0]['valor'] != "") {
            if ($configuracao[0]['valor'] == 'true') {
                $valor = true;
            }
        }
        return $valor;
    }

    /**
     * @param $parametro
     * @param $codModulo
     * @param $exercicio
     * @return bool
     */
    public function recuperaConfiguracaoAtivoInativo($parametro, $codModulo, $exercicio)
    {
        $valor = false;
        $configuracao = (new ConfiguracaoModel($this->entityManager))
            ->pegaConfiguracao($parametro, $codModulo, $exercicio);

        if (isset($configuracao[0]['valor']) && $configuracao[0]['valor'] != "") {
            if ($configuracao[0]['valor'] == 'ativo') {
                $valor = true;
            }
        }
        return $valor;
    }

    /**
     * @param $parametro
     * @param $codModulo
     * @param $exercicio
     * @return string
     */
    public function recuperaConfiguracaoTexto($parametro, $codModulo, $exercicio)
    {
        $valor = '';
        $configuracao = (new ConfiguracaoModel($this->entityManager))
            ->pegaConfiguracao($parametro, $codModulo, $exercicio);

        if (isset($configuracao[0]['valor']) && $configuracao[0]['valor'] != "") {
            $valor = trim($configuracao[0]['valor']);
        }
        return $valor;
    }

    /**
     * @param $parametro
     * @param $codModulo
     * @param $exercicio
     * @return array
     */
    public function recuperaConfiguracaoOrdemEntrada($parametro, $codModulo, $exercicio, $translator)
    {
        $valor = array();
        $configuracao = (new ConfiguracaoModel($this->entityManager))
            ->pegaConfiguracao($parametro, $codModulo, $exercicio, true);

        if (!$configuracao) {
            $configuracao = $this->montaOrdemEntrega($codModulo, $exercicio, $translator);
        }

        $ordemEntrada = preg_replace("/[{}\"]/", "", $configuracao);
        $arOrdemEntrega = preg_split("/,/", $ordemEntrada);
        for ($count = 0; $count < count($arOrdemEntrega); $count = $count + 2) {
            $valor[trim($arOrdemEntrega[$count + 1])] = trim($arOrdemEntrega[$count]);
        }

        return $valor;
    }

    /**
     * @param $codModulo
     * @param $exercicio
     * @param $translator
     */
    public function montaOrdemEntrega($codModulo, $exercicio, $translator)
    {
        $padroes = ConfiguracaoController::ORDEM_ENTREGA_VALORES_PADRAO;
        $formatado = '';
        foreach ($padroes as $chave => $valor) {
            $formatado .= ($formatado)
                ? sprintf(',{%d, "%s"}', $chave, $translator->trans($valor))
                : sprintf('{{%d, "%s"}', $chave, $translator->trans($valor));
        }
        $formatado .= '}';

        $configuracaoOrdemPagamento = $this->novaConfiguracao($exercicio, $codModulo, ConfiguracaoController::PARAMETRO_ORDEM_ENTREGA);
        $configuracaoOrdemPagamento->setValor($formatado);

        $this->entityManager->persist($configuracaoOrdemPagamento);
        $this->entityManager->flush();
    }

    /**
     * @param $parametro
     * @param $codModulo
     * @param $exercicio
     * @return array
     */
    public function recuperaConfiguracaoChaveValor($parametro, $codModulo, $exercicio)
    {
        $valor = array();
        $configuracao = (new ConfiguracaoModel($this->entityManager))
            ->pegaConfiguracao($parametro, $codModulo, $exercicio);

        if (isset($configuracao[0]['valor']) && $configuracao[0]['valor'] != "") {
            $arAliquotas = preg_split("/,/", $configuracao[0]['valor']);
            for ($count = 0; $count < count($arAliquotas); $count = $count + 2) {
                if (isset($arAliquotas[$count]) && isset($arAliquotas[$count + 1])) {
                    $valor[trim($arAliquotas[$count])] = trim($arAliquotas[$count + 1]);
                }
            }
        }

        return $valor;
    }

    /**
     * @param $parametro
     * @param $codModulo
     * @param $codCadastro
     * @param $exercicio
     * @return array
     */
    public function recuperaConfiguracaoIds($parametro, $codModulo, $codCadastro, $exercicio)
    {
        $valor = array();
        $configuracao = (new ConfiguracaoModel($this->entityManager))
            ->pegaConfiguracao($parametro, $codModulo, $exercicio);

        $atributos = $this->recuperaAtributoDinamico($codModulo, $codCadastro);

        if (isset($configuracao[0]['valor']) && $configuracao[0]['valor'] != "") {
            $ids = preg_split("/,/", $configuracao[0]['valor']);
            foreach ($ids as $id) {
                $valor[$id] = $atributos[$id];
            }
        }
        return $valor;
    }

    /**
     * @param $codModulo
     * @param $codCadastro
     * @param bool $ativo
     * @return array
     */
    public function recuperaAtributoDinamico($codModulo, $codCadastro, $ativo = true)
    {
        $options = array();
        $atributos = $this->entityManager->getRepository(AtributoDinamico::class)
            ->findBy(
                array(
                    'codModulo' => $codModulo,
                    'codCadastro' => $codCadastro,
                    'ativo' => $ativo
                )
            );

        /** @var AtributoDinamico $atributo */
        foreach ($atributos as $atributo) {
            $options[$atributo->getCodAtributo()] = $atributo->getNomAtributo();
        }

        return $options;
    }

    /**
     * Verifica se existe configuração cadastrada em valor_md ou aliquotas
     *
     * @param $exercicio
     * @param $codModulo
     * @param $parametro
     * @param $valor
     * @return bool
     */
    public function verificaConfiguracao($exercicio, $codModulo, $parametro, $valor)
    {
        $valores = $this->recuperaConfiguracaoChaveValor($parametro, $codModulo, $exercicio);
        if (in_array($valor, $valores)) {
            return true;
        }
        return false;
    }

    /**
     * @param $codModulo
     * @param $form
     * @param $exercicio
     * @param $translator
     * @return bool|\Exception
     */
    public function salvarConfiguracao($codModulo, $form, $exercicio, $translator)
    {
        $em = $this->entityManager;

        try {
            if (isset($form[ConfiguracaoController::PARAMETRO_CODIGO_LOCALIZACAO])) {
                $codigoLocalizacao = $em
                    ->getRepository(Configuracao::class)
                    ->findOneBy(
                        array(
                            'exercicio' => $exercicio,
                            'codModulo' => $codModulo,
                            'parametro' => ConfiguracaoController::PARAMETRO_CODIGO_LOCALIZACAO
                        )
                    );
                if (!$codigoLocalizacao) {
                    $codigoLocalizacao = $this->novaConfiguracao($exercicio, $codModulo, ConfiguracaoController::PARAMETRO_CODIGO_LOCALIZACAO);
                }
                $codigoLocalizacao->setValor($form[ConfiguracaoController::PARAMETRO_CODIGO_LOCALIZACAO]);
                $em->persist($codigoLocalizacao);
            }

            if (isset($form[ConfiguracaoController::PARAMETRO_MASCARA_LOTE])) {
                $mascaraLote = $em
                    ->getRepository(Configuracao::class)
                    ->findOneBy(
                        array(
                            'exercicio' => $exercicio,
                            'codModulo' => $codModulo,
                            'parametro' => ConfiguracaoController::PARAMETRO_MASCARA_LOTE
                        )
                    );
                if (!$mascaraLote) {
                    $mascaraLote = $this->novaConfiguracao($exercicio, $codModulo, ConfiguracaoController::PARAMETRO_MASCARA_LOTE);
                }
                $mascaraLote->setValor($form[ConfiguracaoController::PARAMETRO_MASCARA_LOTE]);
                $em->persist($mascaraLote);
            }

            if (isset($form[ConfiguracaoController::PARAMETRO_NUMERO_INSCRICAO])) {
                $numeroInscricao = $em
                    ->getRepository(Configuracao::class)
                    ->findOneBy(
                        array(
                            'exercicio' => $exercicio,
                            'codModulo' => $codModulo,
                            'parametro' => ConfiguracaoController::PARAMETRO_NUMERO_INSCRICAO
                        )
                    );
                if (!$numeroInscricao) {
                    $numeroInscricao = $this->novaConfiguracao($exercicio, $codModulo, ConfiguracaoController::PARAMETRO_NUMERO_INSCRICAO);
                }
                $numeroInscricao->setValor($form[ConfiguracaoController::PARAMETRO_NUMERO_INSCRICAO]);
                $em->persist($numeroInscricao);
            }

            if (isset($form[ConfiguracaoController::PARAMETRO_MASCARA_INSCRICAO])) {
                $mascaraInscricao = $em
                    ->getRepository(Configuracao::class)
                    ->findOneBy(
                        array(
                            'exercicio' => $exercicio,
                            'codModulo' => $codModulo,
                            'parametro' => ConfiguracaoController::PARAMETRO_MASCARA_INSCRICAO
                        )
                    );
                if (!$mascaraInscricao) {
                    $mascaraInscricao = $this->novaConfiguracao($exercicio, $codModulo, ConfiguracaoController::PARAMETRO_MASCARA_INSCRICAO);
                }
                $mascaraInscricao->setValor($form[ConfiguracaoController::PARAMETRO_MASCARA_INSCRICAO]);
                $em->persist($mascaraInscricao);
            }

            // Não é possivel alterar a Ordem de Entrada

            if (isset($form[ConfiguracaoController::PARAMETRO_NAVEGACAO_AUTOMATICA])) {
                $navegacaoAutomatica = $em
                    ->getRepository(Configuracao::class)
                    ->findOneBy(
                        array(
                            'exercicio' => $exercicio,
                            'codModulo' => $codModulo,
                            'parametro' => ConfiguracaoController::PARAMETRO_NAVEGACAO_AUTOMATICA
                        )
                    );
                if (!$navegacaoAutomatica) {
                    $navegacaoAutomatica = $this->novaConfiguracao($exercicio, $codModulo, ConfiguracaoController::PARAMETRO_NAVEGACAO_AUTOMATICA);
                }
                $navegacaoAutomatica->setValor($form[ConfiguracaoController::PARAMETRO_NAVEGACAO_AUTOMATICA]);
                $em->persist($navegacaoAutomatica);
            }

            if (isset($form[ConfiguracaoController::PARAMETRO_VALOR_MD])) {
                $valorMD = $em
                    ->getRepository(Configuracao::class)
                    ->findOneBy(
                        array(
                            'exercicio' => $exercicio,
                            'codModulo' => $codModulo,
                            'parametro' => ConfiguracaoController::PARAMETRO_VALOR_MD
                        )
                    );
                if (!$valorMD) {
                    $valorMD = $this->novaConfiguracao($exercicio, $codModulo, ConfiguracaoController::PARAMETRO_VALOR_MD);
                }
                $valor = '';
                $opcoes = ConfiguracaoController::OPCOES;
                foreach ($form[ConfiguracaoController::PARAMETRO_VALOR_MD] as $item) {
                    $valor .= ($valor)
                        ? sprintf(',%s,%s', $item, $translator->trans($opcoes[$item]))
                        : sprintf('%s,%s', $item, $translator->trans($opcoes[$item]));
                }
                $valorMD->setValor($valor);
                $em->persist($valorMD);
            }

            if (isset($form[ConfiguracaoController::PARAMETRO_ALIQUOTAS])) {
                $aliquotas = $em
                    ->getRepository(Configuracao::class)
                    ->findOneBy(
                        array(
                            'exercicio' => $exercicio,
                            'codModulo' => $codModulo,
                            'parametro' => ConfiguracaoController::PARAMETRO_ALIQUOTAS
                        )
                    );
                if (!$aliquotas) {
                    $aliquotas = $this->novaConfiguracao($exercicio, $codModulo, ConfiguracaoController::PARAMETRO_ALIQUOTAS);
                }
                $valor = '';
                $opcoes = ConfiguracaoController::OPCOES;
                foreach ($form[ConfiguracaoController::PARAMETRO_ALIQUOTAS] as $item) {
                    $valor .= ($valor)
                        ? sprintf(',%s,%s', $item, $translator->trans($opcoes[$item]))
                        : sprintf('%s,%s', $item, $translator->trans($opcoes[$item]));
                }
                $aliquotas->setValor($valor);
                $em->persist($aliquotas);
            }

            if (isset($form[ConfiguracaoController::PARAMETRO_ATRIB_LOTE_URBANO])) {
                $atribLoteUrbano = $em
                    ->getRepository(Configuracao::class)
                    ->findOneBy(
                        array(
                            'exercicio' => $exercicio,
                            'codModulo' => $codModulo,
                            'parametro' => ConfiguracaoController::PARAMETRO_ATRIB_LOTE_URBANO
                        )
                    );
                if (!$atribLoteUrbano) {
                    $atribLoteUrbano = $this->novaConfiguracao($exercicio, $codModulo, ConfiguracaoController::PARAMETRO_ATRIB_LOTE_URBANO);
                }
                $valor = '';
                foreach ($form[ConfiguracaoController::PARAMETRO_ATRIB_LOTE_URBANO] as $item) {
                    $valor .= ($valor)
                        ? sprintf(',%s', $item)
                        : $item;
                }
                $atribLoteUrbano->setValor($valor);
                $em->persist($atribLoteUrbano);
            }

            if (isset($form[ConfiguracaoController::PARAMETRO_ATRIB_LOTE_RURAL])) {
                $atribLoteRural = $em
                    ->getRepository(Configuracao::class)
                    ->findOneBy(
                        array(
                            'exercicio' => $exercicio,
                            'codModulo' => $codModulo,
                            'parametro' => ConfiguracaoController::PARAMETRO_ATRIB_LOTE_RURAL
                        )
                    );
                if (!$atribLoteRural) {
                    $atribLoteRural = $this->novaConfiguracao($exercicio, $codModulo, ConfiguracaoController::PARAMETRO_ATRIB_LOTE_RURAL);
                }
                $valor = '';
                foreach ($form[ConfiguracaoController::PARAMETRO_ATRIB_LOTE_RURAL] as $item) {
                    $valor .= ($valor)
                        ? sprintf(',%s', $item)
                        : $item;
                }
                $atribLoteRural->setValor($valor);
                $em->persist($atribLoteRural);
            }

            if (isset($form[ConfiguracaoController::PARAMETRO_ATRIB_IMOVEL])) {
                $atribImovel = $em
                    ->getRepository(Configuracao::class)
                    ->findOneBy(
                        array(
                            'exercicio' => $exercicio,
                            'codModulo' => $codModulo,
                            'parametro' => ConfiguracaoController::PARAMETRO_ATRIB_IMOVEL
                        )
                    );
                if (!$atribImovel) {
                    $atribImovel = $this->novaConfiguracao($exercicio, $codModulo, ConfiguracaoController::PARAMETRO_ATRIB_IMOVEL);
                }
                $valor = '';
                foreach ($form[ConfiguracaoController::PARAMETRO_ATRIB_IMOVEL] as $item) {
                    $valor .= ($valor)
                        ? sprintf(',%s', $item)
                        : $item;
                }
                $atribImovel->setValor($valor);
                $em->persist($atribImovel);
            }

            if (isset($form[ConfiguracaoController::PARAMETRO_ATRIB_EDIFICACAO])) {
                $atribEdificacao = $em
                    ->getRepository(Configuracao::class)
                    ->findOneBy(
                        array(
                            'exercicio' => $exercicio,
                            'codModulo' => $codModulo,
                            'parametro' => ConfiguracaoController::PARAMETRO_ATRIB_EDIFICACAO
                        )
                    );
                if (!$atribEdificacao) {
                    $atribEdificacao = $this->novaConfiguracao($exercicio, $codModulo, ConfiguracaoController::PARAMETRO_ATRIB_EDIFICACAO);
                }
                $valor = '';
                foreach ($form[ConfiguracaoController::PARAMETRO_ATRIB_EDIFICACAO] as $item) {
                    $valor .= ($valor)
                        ? sprintf(',%s', $item)
                        : $item;
                }
                $atribEdificacao->setValor($valor);
                $em->persist($atribEdificacao);
            }

            $em->flush();
            return true;
        } catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * @param $exercicio
     * @param $codModulo
     * @param $parametro
     * @return Configuracao
     */
    public function novaConfiguracao($exercicio, $codModulo, $parametro)
    {
        $configuracao = new Configuracao();
        $configuracao->setExercicio($exercicio);
        $configuracao->setCodModulo($codModulo);
        $configuracao->setParametro($parametro);
        return $configuracao;
    }
}
