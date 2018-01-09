<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\SwUf;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170725184437 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $em = $this->container->get('doctrine.orm.entity_manager');
        $repository = $em->getRepository(Configuracao::class);
        $UfList = $repository->findByParametro('cod_uf');

        foreach($UfList as $uf) {
            if (!is_numeric($uf->getValor()) && $codUf = $this->getCodUf($uf->getValor(), $em)) {
                $uf->setValor($codUf);
                $em->persist($uf);
            }
        }

        $em->flush();
    }

    /**
     * @param $siglaUf
     * @param $em
     * @return null
     */
    private function getCodUf($siglaUf, $em)
    {
        $swUf = $em->getRepository(SwUf::class)->findOneBy(['siglaUf' => $siglaUf]);

        return !empty($swUf) ? $swUf->getCodUf() : null;
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

    }
}
