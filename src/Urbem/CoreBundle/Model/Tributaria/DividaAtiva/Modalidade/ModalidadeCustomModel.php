<?php

namespace Urbem\CoreBundle\Model\Tributaria\DividaAtiva\Modalidade;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\Entity\Administracao\Funcao;
use Urbem\CoreBundle\Entity\Divida\ModalidadeReducao;
use Urbem\CoreBundle\Entity\Divida\ModalidadeReducaoAcrescimo;
use Urbem\CoreBundle\Entity\Divida\ModalidadeReducaoCredito;

class ModalidadeCustomModel extends ModalidadeModel
{
    const COD_BIBLIOTECA = 3;
    const VALOR_PERCENTUAL = 'valor_percentual';
    const VALOR_ABSOLUTO = 'valor_absoluto';
    const CREDITO = 'credito';
    const ACRESCIMO = 'acrescimo';

    /**
     * AutoridadeModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager);
    }

    /**
     * @param $object
     * @param $request
     * @param $childrens
     */
    public function prePersistCustom($object, $request, $childrens, $modalidade)
    {
        parent::prePersistModel($object, $request, $childrens, $modalidade);
        if (!empty($request->get('reducoesRegraUtilizacao')['codigo'])) {
            foreach ($request->get('reducoesRegraUtilizacao')['codigo'] as $reducoesRegrasUtilizacao) {
                $explode = explode('+', $reducoesRegrasUtilizacao);
                $objExplode = new \ArrayObject($explode);
                $array = $objExplode->getIterator();

                $explodeCreditosAcrescimos = explode('-', $array->current());
                $array->next();
                $dados = new \ArrayObject(explode('.', $array->current()));
                $arrayDadosFuncao = $dados->getIterator();
                $arrayDadosFuncao->next();
                $arrayDadosFuncao->next();

                $reducao = new ModalidadeReducao();
                $funcao = $this->entityManager->getRepository(Funcao::class)->findOneBy([
                    'codFuncao' => $arrayDadosFuncao->current(),
                    'codModulo' => self::COD_MODULO,
                    'codBiblioteca' => self::COD_BIBLIOTECA
                ]);
                $reducao->setFkAdministracaoFuncao($funcao);
                $arrayDadosFuncao->next();
                $valor = str_replace(',', '.', str_replace('.', '', $arrayDadosFuncao->current()));
                $reducao->setValor((float) $valor);

                $arrayDadosFuncao->next();
                $reducao->setPercentual(($arrayDadosFuncao->current() ==  str_replace('valor_', '', self::VALOR_PERCENTUAL) ? true : false));
                foreach ($explodeCreditosAcrescimos as $codigo) {
                    if (strpos($codigo, '.')) {
                        $this->populaReducaoAcrescimo($object, $codigo, $reducao, $arrayDadosFuncao);
                    } else {
                        $this->populaReducaoCreditos($object, $codigo, $reducao, $arrayDadosFuncao);
                    }
                }
            }
        }
    }

    /**
     * @param $object
     * @param $codigo
     * @param $reducao
     * @param $arrayDadosFuncao
     * @return \Closure
     */
    protected function populaReducaoAcrescimo($object, $codigo, $reducao, $arrayDadosFuncao)
    {
        $filter = function ($element) use ($codigo) {
            $acrescimos = explode('.', $codigo);
            return ($acrescimos[0] == $element->getCodAcrescimo() && $acrescimos[1] == $element->getCodTipo());
        };
        if (!$object->getFkDividaModalidadeVigencias()->last()->getFkDividaModalidadeAcrescimos()->isEmpty()) {
            $acrescimos = $object
                ->getFkDividaModalidadeVigencias()
                ->last()
                ->getFkDividaModalidadeAcrescimos()
                ->filter($filter);

            if (!$acrescimos->isEmpty()) {
                $reducao->setFkDividaModalidadeVigencia($acrescimos->current()->getFkDividaModalidadeVigencia());
                $arrayDadosFuncao->next();
                $reducaoAcrescimos = new ModalidadeReducaoAcrescimo();
                $reducaoAcrescimos->setFkDividaModalidadeReducao($reducao);
                $reducaoAcrescimos->setFkDividaModalidadeAcrescimo($acrescimos->current());
                $acrescimos->current()->addFkDividaModalidadeReducaoAcrescimos($reducaoAcrescimos);
            }
        }
    }

    /**
     * @param $object
     * @param $codigo
     * @param $reducao
     * @param $arrayDadosFuncao
     */
    protected function populaReducaoCreditos($object, $codigo, $reducao, $arrayDadosFuncao)
    {
        $filter = function ($element) use ($codigo) {
            return $element->getCodCredito() == $codigo;
        };
        if (!$object->getFkDividaModalidadeVigencias()->last()->getFkDividaModalidadeCreditos()->isEmpty()) {
            $creditos = $object
                ->getFkDividaModalidadeVigencias()
                ->last()
                ->getFkDividaModalidadeCreditos()
                ->filter($filter);

            if (!$creditos->isEmpty()) {
                $reducao->setFkDividaModalidadeVigencia($creditos->current()->getFkDividaModalidadeVigencia());
                $arrayDadosFuncao->next();
                $reducaoCredito = new ModalidadeReducaoCredito();
                $reducaoCredito->setFkDividaModalidadeReducao($reducao);
                $reducaoCredito->setFkDividaModalidadeCredito($creditos->current());
                $creditos->current()->addFkDividaModalidadeReducaoCreditos($reducaoCredito);
            }
        }
    }

    /**
     * @return array
     */
    public function getTiposReducao()
    {
        return [
            'label.dividaAtivaModalidade.valorPercentual'=> self::VALOR_PERCENTUAL,
            'label.dividaAtivaModalidade.valorAbsoluto' => self::VALOR_ABSOLUTO
        ];
    }

    /**
     * @return array
     */
    public function getReducoesIncidencia()
    {
        return [
            'label.dividaAtivaModalidade.credito'=> self::CREDITO,
            'label.dividaAtivaModalidade.acrescimo' => self::ACRESCIMO
        ];
    }

    /**
     * @param $formMapper
     * @param $label
     */
    public function formMapperReducoes($formMapper, $label)
    {
        $formMapper
            ->with($label)
            ->add(
                'tipoReducao',
                'choice',
                [
                    'label' => 'label.dividaAtivaModalidade.tipoReducao',
                    'choices' => $this->getTiposReducao(),
                    'required' => false,
                    'mapped' => false,
                    'placeholder' => 'Selecione',
                    'data' => null,
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->add(
                'valor',
                'text',
                [
                    'label' => 'label.dividaAtivaModalidade.valor',
                    'required' => false,
                    'mapped' => false,
                    'attr' => [
                        'class' => 'mask-monetaria '
                    ]
                ]
            )
            ->add(
                'reducoesIncidencia',
                'choice',
                [
                    'label' => 'label.dividaAtivaModalidade.incidencia',
                    'choices' => $this->getReducoesIncidencia(),
                    'required' => false,
                    'mapped' => false,
                    'placeholder' => 'Selecione',
                    'data' => null,
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->add(
                'creditoAcrescimo',
                'choice',
                [
                    'label' => 'label.dividaAtivaModalidade.credito',
                    'choices' => [],
                    'required' => false,
                    'mapped' => false,
                    'placeholder' => 'Selecione',
                    'help'=>'<a href="javascript://Incluir" class="white-text blue darken-4 btn btn-success incluir-registro" ><i class="material-icons left">input</i>Incluir</a>',
                    'data' => null,
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->end()
        ;
    }

    /**
     * @return ArrayCollection
     */
    protected function findReducaoRegraUtilizacao()
    {
        $regraUtilizacao = $this->repository->findRegraUtilizacao(self::COD_MODULO, self::COD_BIBLIOTECA);
        return $this->buildSelectRegrasUtilizacao($regraUtilizacao);
    }

    /**
     * @param $formMapper
     * @param $label
     */
    public function formMapperReducoesRegrasUtilizacao($formMapper, $label)
    {
        $formMapper
            ->with($label)
                ->add(
                    'reducoesRegraUtilizacao',
                    'choice',
                    [
                        'label' => 'label.dividaAtivaModalidade.regraUtilizacao',
                        'choices' => $this->findReducaoRegraUtilizacao(),
                        'required' => false,
                        'mapped' => false,
                        'placeholder' => 'Selecione',
                        'help'=>'<a href="javascript://Incluir" class="white-text blue darken-4 btn btn-success incluir-registro" ><i class="material-icons left">input</i>Incluir</a>',
                        'data' => null,
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    ]
                )
            ->end()
        ;
    }

    /**
     * @param $formMapper
     * @param $object
     * @param $label
     * @param $translator
     * @return mixed
     */
    public function initAdminEdit($formMapper, $object, $label, $translator)
    {
        $modalidadeVigencia = $object->getFkDividaModalidadeVigencias()->current();
        if (!$modalidadeVigencia->getFkDividaModalidadeReducoes()->isEmpty()) {
            $reducoes = new ArrayCollection();
            foreach ($modalidadeVigencia->getFkDividaModalidadeReducoes() as $fkDividaModalidadeReducoe) {
                $this->initDataRegraUtilizacao($fkDividaModalidadeReducoe, $reducoes);
            }
            $formMapper = parent::initAdminEdit($formMapper, $object, $label, $translator);
            return $this->montaHiddeRegraUtilizacaoEdit($reducoes, $formMapper, $label);
        }
    }

    /**
     * @param $reducoes
     * @param $formMapper
     * @param $label
     * @return mixed
     */
    protected function montaHiddeRegraUtilizacaoEdit($reducoes, $formMapper, $label)
    {
        $formMapper
            ->with($label)
            ->add(
                'reducoesRegraUtilizacaoEdit',
                'hidden',
                [
                    'data' => json_encode($reducoes->toArray()),
                    'mapped' => false,
                ]
            )
            ->end()
        ;

        return $formMapper;
    }

    /**
     * @param $showMapper
     * @param $object
     * @param $label
     * @param $translator
     * @return bool
     */
    public function showFieldsReducoesRegrasUtilizacao($showMapper, $object, $label, $translator, $title)
    {
        $modalidadeVigencia = $object->getFkDividaModalidadeVigencias()->current();
        if ($modalidadeVigencia->getFkDividaModalidadeReducoes()->isEmpty()) {
            return false;
        }
        $reducoesArray = new ArrayCollection();
        $reducoes = clone $reducoesArray;
        foreach ($modalidadeVigencia->getFkDividaModalidadeReducoes() as $fkDividaModalidadeReducoe) {
            $this->initDataRegraUtilizacao($fkDividaModalidadeReducoe, $reducoesArray);
        }

        foreach ($reducoesArray as $value) {
            unset($value['data']['hidden']);
            unset($value['data']['chave']);
            $reducoes->add($value['data']);
        }

        $this->buildShowFieldsTable(
            $showMapper,
            'regrasUtilizacao',
            $label,
            [
                $translator->transChoice('label.dividaAtivaModalidade.tipo', 0, [], 'messages'),
                $translator->transChoice('label.dividaAtivaModalidade.valor', 0, [], 'messages'),
                $translator->transChoice('label.dividaAtivaModalidade.regra', 0, [], 'messages'),
                $translator->transChoice('label.dividaAtivaModalidade.incidencia', 0, [], 'messages')
            ],
            $reducoes,
            $translator->transChoice($title, 0, [], 'messages')
        );
    }

    /**
     * @param $fkDividaModalidadeReducoe
     * @param $reducoes
     */
    protected function initDataRegraUtilizacao($fkDividaModalidadeReducoe, $reducoes)
    {
        $codigo = '';
        $incidencia = '';

        $chave = sprintf(
            '%s.%s.%s',
            $fkDividaModalidadeReducoe->getCodModulo(),
            $fkDividaModalidadeReducoe->getCodBiblioteca(),
            str_pad($fkDividaModalidadeReducoe->getCodFuncao(), 3, 0, STR_PAD_LEFT)
        );
        $tipo = str_replace('valor_', '', ($fkDividaModalidadeReducoe->getPercentual() ? self::VALOR_PERCENTUAL : self::VALOR_ABSOLUTO));

        $regraUtilizacao = $chave;
        $regraUtilizacao .= sprintf('.%s', $fkDividaModalidadeReducoe->getValor());
        $regraUtilizacao .= sprintf('.%s', $tipo);

        foreach ($fkDividaModalidadeReducoe->getFkDividaModalidadeReducaoAcrescimos() as $acrescimo) {
            $codigo .= sprintf('%s.%s-', $acrescimo->getCodAcrescimo(), $acrescimo->getCodTipo());
            $incidencia .= sprintf(
                '%s - %s <br />',
                rtrim($codigo, '-'),
                $acrescimo->getFkDividaModalidadeAcrescimo()->getFkAdministracaoFuncao()->getNomFuncao()
            );
        }

        foreach ($fkDividaModalidadeReducoe->getFkDividaModalidadeReducaoCreditos() as $credito) {
            $codigo .= sprintf('%s-', str_pad($credito->getCodCredito(), 3, 0, STR_PAD_LEFT));
            $credito = $this->findModalidadeCredito($credito->getCodCredito());
            $incidencia .= sprintf('%s - %s <br />', $credito['codigo'], $credito['valor']);
        }

        $retorno['data'] = [
            'chave' => $chave,
            'tipo' => $tipo,
            'valor' => number_format($fkDividaModalidadeReducoe->getValor(), 2, ',', '.'),
            'regra' => sprintf('%s - %s', $chave, $fkDividaModalidadeReducoe->getFkAdministracaoFuncao()->getNomFuncao()),
            'incidencia' => $incidencia
        ];
        $retorno['data']['hidden'] = ['codigo' => sprintf('%s+%s', rtrim($codigo, '-'), $regraUtilizacao)];
        $reducoes->add($retorno);
    }
}
