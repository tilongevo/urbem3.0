<?php

namespace Urbem\CoreBundle\Model\Arrecadacao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Arrecadacao\AtributoDesoneracao;
use Urbem\CoreBundle\Entity\Arrecadacao\AtributoDesoneracaoValor;
use Urbem\CoreBundle\Entity\Arrecadacao\Desonerado;
use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;

/**
 * Class DesoneradoModel
 * @package Urbem\CoreBundle\Model\Arrecadacao
 */
class DesoneradoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * DesoneradoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Desonerado::class);
    }

    /**
     * @param Desonerado $desonerado
     * @param $atributosDinamicos
     * @return bool|\Exception
     */
    public function saveAtributoDinamico(Desonerado $desonerado, $atributosDinamicos)
    {
        try {
            $em = $this->entityManager;
            $atributoDinamicoModel = new AtributoDinamicoModel($em);

            $atributoDesoneracaoValores = array();
            if ($desonerado->getFkArrecadacaoAtributoDesoneracaoValores()->count()) {
                /** @var AtributoDesoneracaoValor $atributoDesoneracaoValor */
                foreach ($desonerado->getFkArrecadacaoAtributoDesoneracaoValores() as $atributoDesoneracaoValor) {
                    $atributoDesoneracaoValores[$atributoDesoneracaoValor->getCodAtributo()] = $atributoDesoneracaoValor;
                }
            }

            foreach ($atributosDinamicos as $codAtributo => $valorAtributo) {
                if (isset($atributoDesoneracaoValores[$codAtributo])) {
                    $atributoDesoneracaoValor = $atributoDesoneracaoValores[$codAtributo];

                    $valor = $atributoDinamicoModel
                        ->processaAtributoDinamicoPersist(
                            $atributoDesoneracaoValor->getFkArrecadacaoAtributoDesoneracao(),
                            $valorAtributo
                        );

                    $atributoDesoneracaoValor->setValor($valor);
                    $em->persist($atributoDesoneracaoValor);
                } else {
                    /** @var AtributoDesoneracao $atributoDesoneracao */
                    $atributoDesoneracao = $em->getRepository(AtributoDesoneracao::class)
                        ->findOneBy(
                            array(
                                'codModulo' => Modulo::MODULO_ARRECADACAO,
                                'codCadastro' => Cadastro::CADASTRO_ARRECADACAO_DESONERACAO,
                                'codAtributo' => $codAtributo
                            )
                        );

                    $atributoDesoneracaoValor = new AtributoDesoneracaoValor();
                    $atributoDesoneracaoValor->setFkArrecadacaoDesonerado($desonerado);
                    $atributoDesoneracaoValor->setFkArrecadacaoAtributoDesoneracao($atributoDesoneracao);

                    $valor = $atributoDinamicoModel
                        ->processaAtributoDinamicoPersist(
                            $atributoDesoneracaoValor->getFkArrecadacaoAtributoDesoneracao(),
                            $valorAtributo
                        );

                    if (!empty($valor)) {
                        $atributoDesoneracaoValor->setValor($valor);
                        $desonerado->addFkArrecadacaoAtributoDesoneracaoValores($atributoDesoneracaoValor);
                    }
                }

                $em->flush();
                return true;
            }
        } catch (\Exception $e) {
            return $e;
        }
    }
}
