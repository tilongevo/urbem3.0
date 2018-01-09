<?php

namespace Urbem\CoreBundle\Model\Ppa;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Helper\SessionHelper;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Repository;
use Symfony\Component\Validator\Validator;

class ProgramaModel extends AbstractModel
{
    protected $entityManager;
    protected $repository;
    protected $programaSetorialRepository;
    const NATUREZA_TEMPORAL_T = 't';
    const NATUREZA_TEMPORAL_F = 'f';
    const NATUREZA_TEMPORAL = [
        'label.programas.choices.boNatureza.continuo' => self::NATUREZA_TEMPORAL_T,
        'label.programas.choices.boNatureza.temporario' => self::NATUREZA_TEMPORAL_F
    ];

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Ppa\Programa");
        $this->programaSetorialRepository = $this->entityManager->getRepository("CoreBundle:Ppa\ProgramaSetorial");
    }

    public function getProgramaSetorial($codMacro)
    {
        if (! $codMacro) {
            return array();
        }

        $res = $this->programaSetorialRepository->findByCodMacro($codMacro);

        $programasSetoriais = array();
        foreach ($res as $key => $programaSetorial) {
            $programasSetoriais[$programaSetorial->getCodSetorial()] = $programaSetorial->getDescricao();
        }

        return $programasSetoriais;
    }

    public function getUnidadeByOrgao($codOrgao, $exercicio)
    {
        $sql = "
        SELECT
            unidade.*,
            unidade.nom_unidade,
            orgao.nom_orgao,
            sw_cgm.nom_cgm AS nome_usuario
        FROM orcamento.unidade
        INNER JOIN orcamento.orgao
            ON unidade.exercicio = orgao.exercicio
            AND unidade.num_orgao = orgao.num_orgao
        INNER JOIN sw_cgm
            ON sw_cgm.numcgm = unidade.usuario_responsavel
        WHERE unidade.exercicio = :exercicio
        AND unidade.num_orgao = :num_orgao;";

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('num_orgao', $codOrgao);
        $query->execute();

        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        $unidades = array();
        foreach ($result as $key => $unidade) {
            $unidades[$unidade->num_unidade] = $unidade->nom_unidade;
        }

        return $unidades;
    }

    public function getProximoIndicador()
    {
        $sql = "
        SELECT
            COALESCE(MAX(ppa.programa_indicadores.cod_indicador), 0) AS codigo
        FROM ppa.programa_indicadores";

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->execute();

        $result = $query->fetch(\PDO::FETCH_OBJ);

        return $result->codigo + 1;
    }

    public function newProgramaDados($form, $object)
    {
        
        $continuo = false;
        if ($form->get('boNatureza')->getData() == 't') {
            $continuo = true;
        }
        
        $programaDados = new \Urbem\CoreBundle\Entity\Ppa\ProgramaDados();
        $programaDados->setFkOrcamentoUnidade($form->get('inCodUnidade')->getData());
        $programaDados->setFkPpaPrograma($object);
        $programaDados->setTimestampProgramaDados($object->getUltimoTimestampProgramaDados());
        $programaDados->setFkPpaTipoPrograma($form->get('inCodTipoPrograma')->getData());
        $programaDados->setIdentificacao($form->get('inIdPrograma')->getData());
        $programaDados->setDiagnostico($form->get('inDigPrograma')->getData());
        $programaDados->setObjetivo($form->get('inObjPrograma')->getData());
        $programaDados->setDiretriz($form->get('inDirPrograma')->getData());
        $programaDados->setContinuo($continuo);
        $programaDados->setPublicoAlvo($form->get('inPublicoAlvo')->getData());
        $programaDados->setJustificativa($form->get('inIdPrograma')->getData());
        $this->entityManager->persist($programaDados);

        if ($form->get('boNatureza')->getData() == 'f') {
            $programaTemporarioVigencia = new \Urbem\CoreBundle\Entity\Ppa\ProgramaTemporarioVigencia();
            $programaTemporarioVigencia->setFkPpaProgramaDados($programaDados);
            $programaTemporarioVigencia->setDtInicial($form->get('stDataInicial')->getData());
            $programaTemporarioVigencia->setDtFinal($form->get('stDataFinal')->getData());
            $programaTemporarioVigencia->setValorGlobal(0);
            $this->entityManager->persist($programaTemporarioVigencia);
        }

        $this->entityManager->flush();
    }

    public function newOrcaomentoPrograma($form, $object)
    {
        $ppa = $this->entityManager->getRepository('CoreBundle:Ppa\Ppa')
        ->findOneByCodPpa($form->get('inCodPPA')->getData());
        
        for ($i = (int) $ppa->getAnoInicio(); $i <= (int) $ppa->getAnoFinal(); $i++) {
            $orcamentoPrograma = new \Urbem\CoreBundle\Entity\Orcamento\Programa();
            $orcamentoPrograma->setCodPrograma($object->getCodPrograma());
            $orcamentoPrograma->setExercicio($i);
            $orcamentoPrograma->setDescricao($form->get('inIdPrograma')->getData());
            $this->entityManager->persist($orcamentoPrograma);
            
            $programaPpaPrograma = new \Urbem\CoreBundle\Entity\Orcamento\ProgramaPpaPrograma();
            $programaPpaPrograma->setExercicio($i);
            $programaPpaPrograma->setFkPpaPrograma($object);
            $programaPpaPrograma->setFkOrcamentoPrograma($orcamentoPrograma);
            $this->entityManager->persist($programaPpaPrograma);
        }
        $this->entityManager->flush();
    }

    public function editOrcaomentoPrograma($form, $object)
    {
        $ppa = $this->entityManager->getRepository('CoreBundle:Ppa\Ppa')
        ->findOneByCodPpa($form->get('inCodPPA')->getData());

        for ($i = (int) $ppa->getAnoInicio(); $i <= (int) $ppa->getAnoFinal(); $i++) {
            $orcamentoPrograma = $this->entityManager->getRepository('CoreBundle:Orcamento\Programa')
            ->findOneBy(
                array(
                    'codPrograma' => $object->getCodPrograma(),
                    'exercicio' => $i
                )
            );

            if (!$orcamentoPrograma) {
                $orcamentoPrograma = new \Urbem\CoreBundle\Entity\Orcamento\Programa();
                $orcamentoPrograma->setCodPrograma($object->getCodPrograma());
            }

            $orcamentoPrograma->setExercicio($i);
            $orcamentoPrograma->setDescricao($form->get('inIdPrograma')->getData());
            $this->entityManager->persist($orcamentoPrograma);

            $programaPpaPrograma = $this->entityManager->getRepository('CoreBundle:Orcamento\ProgramaPpaPrograma')
            ->findOneBy(
                array(
                    'codPrograma' => $object->getCodPrograma(),
                    'exercicio' => $i
                )
            );

            if (! $programaPpaPrograma) {
                $programaPpaPrograma = new \Urbem\CoreBundle\Entity\Orcamento\ProgramaPpaPrograma();
            }

            $programaPpaPrograma->setFkPpaPrograma($object);
            $programaPpaPrograma->setFkOrcamentoPrograma($orcamentoPrograma);
            $this->entityManager->persist($programaPpaPrograma);
        }

        $programasIndicadores = $this->entityManager->getRepository('CoreBundle:Ppa\ProgramaIndicadores')
        ->findByCodPrograma($object->getCodPrograma());

        foreach ($programasIndicadores as $programaIndicador) {
            $programaIndicador->setTimestampProgramaDados($object->getUltimoTimestampProgramaDados());
            $this->entityManager->persist($programaIndicador);
        }

        $this->entityManager->flush();
    }

    public function removeRelationships($object)
    {
        $programaIndicadores = $this->entityManager->getRepository('CoreBundle:Ppa\ProgramaIndicadores')
        ->findByCodPrograma($object->getCodPrograma());

        // Remove ProgramaIndicadores
        foreach ($programaIndicadores as $programaIndicador) {
            $this->entityManager->remove($programaIndicador);
        }

        // Remove ProgramaTemporarioVigencia
        $programaTemporarioVigencias = $this->getAllProgramaTemporarioVigencia($object);

        // Remove ProgramaIndicadores
        foreach ($programaTemporarioVigencias as $programaTemporarioVigencia) {
            $this->entityManager->remove($programaTemporarioVigencia);
        }

        // Remove ProgramaDados
        $programaDados = $this->entityManager->getRepository('CoreBundle:Ppa\ProgramaDados')
        ->findByCodPrograma($object->getCodPrograma());

        foreach ($programaDados as $programaDado) {
            $this->entityManager->remove($programaDado);
        }

        // Remove Orcamento\Programa
        $orcamentoProgramas = $this->entityManager->getRepository('CoreBundle:Orcamento\Programa')
        ->findByCodPrograma($object->getCodPrograma());

        foreach ($orcamentoProgramas as $orcamentoPrograma) {
            $this->entityManager->remove($orcamentoPrograma);
        }

        // Remove ProgramaPpaPrograma
        $programaPpaProgramas = $this->entityManager->getRepository('CoreBundle:Orcamento\ProgramaPpaPrograma')
        ->findByCodPrograma($object->getCodPrograma());

        foreach ($programaPpaProgramas as $programaPpaPrograma) {
            $this->entityManager->remove($programaPpaPrograma);
        }

        $this->entityManager->flush();
    }

    public function getProgramaTemporarioVigencia($object)
    {
        return $this->entityManager->getRepository('CoreBundle:Ppa\ProgramaTemporarioVigencia')
        ->findOneBy(
            array(
                'codPrograma' => $object->getCodPrograma(),
                'timestampProgramaDados' => $object->getUltimoTimestampProgramaDados()
            )
        );
    }

    public function getAllProgramaTemporarioVigencia($object)
    {
        return $this->entityManager->getRepository('CoreBundle:Ppa\ProgramaTemporarioVigencia')
        ->findBy(
            array(
                'codPrograma' => $object->getCodPrograma(),
            )
        );
    }

    /**
     * @param $numPrograma
     * @return bool
     */
    public function getNumberPrograma($numPrograma)
    {
        $configuracaoModel = new ConfiguracaoModel($this->entityManager);
        $permitePPADiversosOrgaos = $configuracaoModel->getConfiguracaoOuAnterior(
            'ppa_diversos_orgaos',
            Entity\Administracao\Modulo::MODULO_PLANO_PLURIANUAL,
            SessionHelper::get('exercicio')
        );

        if ($permitePPADiversosOrgaos === 'S') {
            return true;
        }

        $result = $this->entityManager->getRepository('CoreBundle:Ppa\Programa')
            ->findOneBy(['numPrograma' => $numPrograma]);
        return (!$result ? true : false);
    }
}
