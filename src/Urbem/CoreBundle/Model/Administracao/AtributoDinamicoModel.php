<?php

namespace Urbem\CoreBundle\Model\Administracao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Repository\Administracao\AtributoDinamicoRepository;

class AtributoDinamicoModel extends AbstractModel
{
    protected $entityManager = null;
    /** @var AtributoDinamicoRepository */
    protected $repository = null;

    const VALOR_INICIAL = 1;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Administracao\\AtributoDinamico");
    }

    public function canRemove($object)
    {
    }

    public function canPersist($object)
    {
        $atributoDinamicoRepository = $this->entityManager->getRepository("CoreBundle:Administracao\\AtributoDinamico");
        $res = $atributoDinamicoRepository->findOneBy(
            array(
                'codModulo' => $object->getCodModulo(),
                'codCadastro' => $object->getCodCadastro(),
                'codTipo' => $object->getCodTipo()
            )
        );

        return is_null($res);
    }

    /**
     * @param $codModulo
     * @param $codCadastro
     * @return ORM\QueryBuilder
     */
    public function getAtributosDinamicosPorModuloQuery($codModulo, $codCadastro)
    {
        $queryBuilder = $this->repository->createQueryBuilder('atibutoDinamico');
        $queryBuilder
            ->where('atibutoDinamico.codModulo = :codModule')
            ->andWhere('atibutoDinamico.codCadastro = :codCadastro')
            ->setParameters([
                'codModule' => $codModulo,
                'codCadastro' => $codCadastro
            ])
        ;

        return $queryBuilder;
    }

    public function getAtributosDinamicosPorModuloeCadastro(array $info)
    {
        return $this->repository->getAtributosDinamicosPorModuloeCadastro($info);
    }

    public function getAtributosDinamicosPorModuloeCadastroeContrato(array $info)
    {
        return $this->repository->getAtributosDinamicosPorModuloeCadastroeContrato($info);
    }


    public function getNumMatricula($sw)
    {
        $this->sw = $sw;
        $change = 5;
        if ($this->sw == 'p') {
            $change = 7;
        }

        $str = "SELECT 
                    administracao.atributo_dinamico.cod_modulo, 
                    administracao.atributo_dinamico.cod_cadastro, 
                    administracao.atributo_dinamico.cod_atributo, 
                    administracao.atributo_dinamico.cod_tipo, 
                    administracao.atributo_dinamico.nao_nulo, 
                    administracao.atributo_dinamico.nom_atributo, 
                    administracao.atributo_dinamico.ajuda, 
                    administracao.atributo_dinamico.mascara, 
                    administracao.atributo_dinamico.ativo, 
                    administracao.atributo_dinamico.interno, 
                    administracao.atributo_dinamico.indexavel 
                FROM 
                    administracao.atributo_dinamico WHERE atributo_dinamico.cod_modulo = 22 AND atributo_dinamico.cod_cadastro = {$change} ORDER BY atributo_dinamico.nom_atributo";


        $query = $this->entityManager->getConnection()->prepare($str);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        $hiddenOpts = [];
        $listOpt = [];

        foreach ($result as $key => $optName) {
            $listOpt[$optName->nom_atributo] = $optName->cod_atributo;

            $hiddenOpts['codCadastroData'] =  $optName->cod_cadastro;
            $hiddenOpts['codModulo'] = $optName->cod_modulo;
        }

        return [$listOpt, $hiddenOpts];
    }

    public function getAtributosDinamicosPreEmpenho($codPreEmpenho, $exercicio)
    {
        return $this->repository->getAtributosDinamicosPreEmpenho($codPreEmpenho, $exercicio);
    }

    public function getProximoCodAtributo($codModulo, $codCadastro)
    {
        $repository = $this->repository;
        $atributoDinamico = $repository->findOneBy([
            'codModulo' => $codModulo,
            'codCadastro' => $codCadastro
        ], ['codAtributo' => 'DESC']);
        $codAtributo = self::VALOR_INICIAL;
        if ($atributoDinamico) {
            $codAtributo = $atributoDinamico->getCodAtributo() + 1;
        }
        return $codAtributo;
    }

    public function getProximoCodAtributoValorPadrao($codModulo, $codCadastro, $codAtributo)
    {
        $em = $this->entityManager;
        $repository = $em->getRepository('CoreBundle:Administracao\AtributoValorPadrao');
        $atributoValorPadrao = $repository->findOneBy([
            'codModulo' => $codModulo,
            'codCadastro' => $codCadastro,
            'codAtributo' => $codAtributo
        ], ['codValor' => 'DESC']);
        $codValor = self::VALOR_INICIAL;
        if ($atributoValorPadrao) {
            $codValor = $atributoValorPadrao->getCodValor() + 1;
        }
        return $codValor;
    }

    /**
     * @param mixed $atributo
     * @param array(mixed) $atributosDinamicos
     * @return string $valor
     */
    public function processaAtributoDinamicoUpdate($atributo, &$atributosDinamicos)
    {
        $tipo = $atributo->getFkAdministracaoAtributoDinamico()->getCodTipo();
        $codAtributo = $atributo->getCodAtributo();

        switch ($tipo) {
            case 1:
                $valor = (string) $atributosDinamicos[$codAtributo]['atributoDinamicoNumero'];
                break;
            case 2:
                $valor = (string) $atributosDinamicos[$codAtributo]['atributoDinamicoTexto'];
                break;
            case 3:
                $valor = (string) $atributosDinamicos[$codAtributo]['atributoDinamicoLista'];
                break;
            case 4:
                $valor = (string) $atributosDinamicos[$codAtributo]['atributoDinamicoListaMultipla'];
                break;
            case 5:
                $valor = (string) $atributosDinamicos[$codAtributo]['atributoDinamicoData'];
                break;
            case 6:
                $valor = (string) $atributosDinamicos[$codAtributo]['atributoDinamicoDecimal'];
                break;
            case 7:
                $valor = (string) $atributosDinamicos[$codAtributo]['atributoDinamicoTextoLongo'];
                break;
            default:
                $valor = '';
                break;
        }

        unset($atributosDinamicos[$codAtributo]);
        return $valor;
    }

    /**
     * @param mixed $atributo
     * @param array $valorAtributo
     * @return string $valor
     */
    public function processaAtributoDinamicoPersist($atributo, $valorAtributo)
    {
        $tipo = $atributo->getFkAdministracaoAtributoDinamico()->getCodTipo();

        switch ($tipo) {
            case 1:
                $valor = (string) $valorAtributo['atributoDinamicoNumero'];
                break;
            case 2:
                $valor = (string) $valorAtributo['atributoDinamicoTexto'];
                break;
            case 3:
                $valor = (string) $valorAtributo['atributoDinamicoLista'];
                break;
            case 4:
                $valor = (string) implode(',', $valorAtributo['atributoDinamicoListaMultipla']);
                break;
            case 5:
                $valor = (string) $valorAtributo['atributoDinamicoData'];
                break;
            case 6:
                $valor = (string) $valorAtributo['atributoDinamicoDecimal'];
                break;
            case 7:
                $valor = (string) $valorAtributo['atributoDinamicoTextoLongo'];
                break;
            default:
                $valor = '';
                break;
        }

        return $valor;
    }

    /**
     * @param $params
     * @return array
     */
    public function getAtributosDinamicosPessoal($params)
    {
        return $this->repository->getAtributosDinamicosPessoal($params);
    }

    /**
     * @param $params
     * @return array
     */
    public function getAtributoDinamicoTrecho($params)
    {
        return $this->repository->getAtributoDinamicoTrecho($params);
    }

    /**
     * @param $params
     * @return array
     */
    public function getAtributoDinamicoCadastroEconomico($params)
    {
        return $this->repository->getAtributoDinamicoCadastroEconomico($params);
    }

    /**
     * @param $params
     * @return array
     */
    public function getValorAtributoDinamicoPorTabela($params)
    {
        return $this->repository->getValorAtributoDinamicoPorTabela($params);
    }

    /**
     * @param $params
     * @return array
     */
    public function getValorAtributoDinamicoPorTabelaComCodigo($params)
    {
        return $this->repository->getValorAtributoDinamicoPorTabelaComCodigo($params);
    }
}
