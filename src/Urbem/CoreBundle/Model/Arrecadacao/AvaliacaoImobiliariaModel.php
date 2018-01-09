<?php

namespace Urbem\CoreBundle\Model\Arrecadacao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;
use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;
use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Arrecadacao\AtributoImovelVVenalValor;
use Urbem\CoreBundle\Entity\Imobiliario\Proprietario;
use Urbem\CoreBundle\Entity\Arrecadacao\ImovelVVenal;

/**
 * Class AvaliacaoImobiliariaModel
 * @package Urbem\CoreBundle\Model\Arrecadacao
 */
class AvaliacaoImobiliariaModel extends AbstractModel
{
    protected $entityManager = null;

    /**
     * AtributoDesoneracaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param $params
     */
    public function saveAtributoImovelVVenalValor(Proprietario $proprietario, ImovelVVenal $imovelVVenal, $form, $atributosDinamicos)
    {
        $em = $this->entityManager;
        $atributoDinamicoModel = new AtributoDinamicoModel($em);

        foreach ($atributosDinamicos as $codAtributo => $valorAtributo) {
            /** @var AtributoDinamico $atributoDinamico */
            $atributoDinamico = $em->getRepository(AtributoDinamico::class)
                ->findOneBy(
                    array(
                        'codModulo' => Modulo::MODULO_ARRECADACAO,
                        'codCadastro' => Cadastro::CADASTRO_TIPO_LICENCA_DIVERSA,
                        'codAtributo' => $codAtributo
                        )
                );

            $atributoImovelVVenalValor = new AtributoImovelVVenalValor;
            $atributoImovelVVenalValor->setFkAdministracaoAtributoDinamico($atributoDinamico);

            $valor = $atributoDinamicoModel
                ->processaAtributoDinamicoPersist(
                    $atributoImovelVVenalValor,
                    $valorAtributo
                );

            $atributoImovelVVenalValor->setInscricaoMunicipal($proprietario->getInscricaoMunicipal());
            $atributoImovelVVenalValor->setTimestamp($imovelVVenal->getTimestamp());
            $atributoImovelVVenalValor->setValor($valor);

            $proprietario
                ->getFkImobiliarioImovel()
                ->getFkArrecadacaoImovelVVenais()->last()
                ->addFkArrecadacaoAtributoImovelVVenalValores($atributoImovelVVenalValor)
            ;

            $em->persist($proprietario);
            $em->flush();
        }
    }
}
