<?php

namespace Urbem\CoreBundle\Helper;

use Behat\Mink\Exception\Exception;
use Doctrine\DBAL\Migrations\AbstractMigration as Migration;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Urbem\CoreBundle\Doctrine\TypeConverter\ConverterFactory;

abstract class AbstractMigration extends Migration implements ContainerAwareInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param string $className
     * @param string $column
     */
    public function changeColumnToDateTimeMicrosecondType($className, $column)
    {
        static $converter = null;

        if (null === $converter) {
            $converter = new ConverterFactory($this->container->get('doctrine.orm.entity_manager'));
        }

        foreach ($converter->getToDateTimeMicrosecondTypeUpdateList($className, $column) as $update) {
            $this->addSql($update);
        }

        $this->write(sprintf('<bg=red;options=bold>WARNING! on %s (changeColumnToDateTimeMicrosecondType)</>', $className));
        $this->write(sprintf('<bg=red;options=bold>Please check mapping (change "%s" to DateTimeMicrosecondPk)</>', $column));
        $this->write(sprintf('<bg=red;options=bold>Please check setter (change "%s" to DateTimeMicrosecondPk)</>', $column));
        $this->write(sprintf('<bg=red;options=bold>Please check getter (change "%s" to DateTimeMicrosecondPk)</>', $column));
    }

    /**
     * @param string $className
     * @param string $column
     */
    public function changeColumnToTimeMicrosecondType($className, $column)
    {
        static $converter = null;

        if (null === $converter) {
            $converter = new ConverterFactory($this->container->get('doctrine.orm.entity_manager'));
        }

        foreach ($converter->getToTimeMicrosecondTypeUpdateList($className, $column) as $update) {
            $this->addSql($update);
        }

        $this->write(sprintf('<bg=red;options=bold>WARNING! on %s (changeColumnToTimeMicrosecondType)</>', $className));
        $this->write(sprintf('<bg=red;options=bold>Please check mapping (change "%s" to TimeMicrosecondPk)</>', $column));
        $this->write(sprintf('<bg=red;options=bold>Please check setter (change "%s" to TimeMicrosecondPk)</>', $column));
        $this->write(sprintf('<bg=red;options=bold>Please check getter (change "%s" to TimeMicrosecondPk)</>', $column));
    }

    /**
     * DROP then CREATE a VIEW
     *
     * @param $view
     * @param $content
     */
    protected function createView($view, $content)
    {
        $this->dropView($view);
        $this->addSql(sprintf('CREATE VIEW %s AS %s', $view, $content));
    }

    /**
     * DROP a VIEW
     * @param $view
     */
    protected function dropView($view)
    {
        $this->addSql(sprintf('DROP VIEW IF EXISTS %s', $view));
    }

    /**
     * DROP a SEQUENCE on SCHEMA.TABLE
     *
     * @param $sequence
     * @param $schema
     * @param $table
     * @param $column
     */
    protected function dropSequence($sequence, $schema, $table, $column)
    {
        $schema = null === $schema || 'public' === $schema ? 'public' : $schema;
        $class = sprintf('%s.%s', $schema, $table);

        $this->addSql(sprintf("ALTER TABLE %s ALTER COLUMN \"%s\" DROP DEFAULT;", $class, $column));
        $this->addSql(sprintf("DROP SEQUENCE IF EXISTS %s", $sequence));
    }

    /**
     * CREATE a SEQUENCE on SCHEMA.TABLE
     *
     * @param $sequence
     * @param $schema
     * @param $table
     * @param $column
     */
    protected function createSequence($sequence, $schema, $table, $column)
    {
        $this->dropSequence($sequence, $schema, $table, $column);

        $schema = null === $schema || 'public' === $schema ? 'public' : $schema;
        $class = sprintf('%s.%s', $schema, $table);

        $this->addSql(sprintf("CREATE SEQUENCE %s", $sequence));
        $this->addSql(sprintf("SELECT SETVAL('%s', COALESCE((SELECT MAX(%s) + 1 FROM %s), 1), false);", $sequence, $column, $class));
    }

    /**
     * @param $schema
     * @param $table
     * @param $column
     * @return bool
     */
    protected function hasColumn($schema, $table, $column)
    {
        $sql = "SELECT isc.column_name
          FROM information_schema.columns as isc
          WHERE isc.table_name = :table
            AND isc.table_schema = :schema
            AND isc.column_name = :column;";

        $conn = $this->connection;
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'schema' => $schema,
            'table' => $table,
            'column' => $column
        ]);

        $result = $stmt->fetchAll();

        return false == empty($result);
    }

    /**
     * @param $route
     * @param string $upperRoute
     * @param bool $returnResult
     * @return array|bool
     */
    protected function hasRoute($route, $upperRoute = '', $returnResult = false)
    {
        $sql = "SELECT * FROM administracao.rota WHERE descricao_rota = :route";
        $prm['route'] = $route;

        if (false == empty($upperRoute)) {
            $sql .= " AND rota_superior = :parent_route;";
            $prm['parent_route'] = $upperRoute;
        }

        $conn = $this->connection;
        $stmt = $conn->prepare($sql);
        $stmt->execute($prm);

        $result = $stmt->fetchAll();

        return ($returnResult ? $result : false == empty($result));
    }

    /**
     * @param $route
     * @param string $upperRoute
     * @param bool $returnResult
     * @return array|bool
     */
    protected function hasGrupoPermissao($route, $upperRoute = '', $returnResult = false)
    {
        $route = $this->hasRoute($route, $upperRoute, true);
        $sql = "SELECT * FROM administracao.grupo_permissao WHERE cod_rota = :cod_rota";
        $prm['cod_rota'] = $route[0]['cod_rota'];

        $conn = $this->connection;
        $stmt = $conn->prepare($sql);
        $stmt->execute($prm);

        $result = $stmt->fetchAll();

        return ($returnResult ? $result : false == empty($result));
    }

    /**
     * @param $route
     * @param string $upperRoute
     * @return void
     */
    protected function removeGrupoPermissao($route, $upperRoute = '')
    {
        $grupoPermissao = $this->hasGrupoPermissao($route, $upperRoute, true);
        if (false == empty($grupoPermissao)) {
            $this->addSql("DELETE FROM administracao.grupo_permissao WHERE cod_rota = :cod_rota", [
                'cod_rota' => $grupoPermissao[0]['cod_rota'],
            ]);
        }
    }

    /**
     * @param $route
     * @param string $upperRoute
     * @return void
     */
    protected function removeRoute($route, $upperRoute = '')
    {
        if (true == $this->hasRoute($route, $upperRoute)) {
            $this->removeGrupoPermissao($route, $upperRoute);
            $sql = "DELETE FROM administracao.rota WHERE descricao_rota = :route";
            $prm['route'] = $route;

            if (false == empty($upperRoute)) {
                $sql .= " AND rota_superior = :parent_route;";
                $prm['parent_route'] = $upperRoute;
            }

            $this->addSql($sql, $prm);
        }
    }

    /**
     * @param $route
     * @param $upperRoute
     * @return void
     */
    protected function updateUpperRoute($route, $upperRoute)
    {
        $this->addSql("UPDATE administracao.rota SET rota_superior = :parent_route WHERE descricao_rota = :route;", [
            'parent_route' => $upperRoute,
            'route' => $route
        ]);
    }

    /**
     * @param $route
     * @param $title
     * @param $upperRoute
     * @return void
     */
    protected function insertRoute($route, $title, $upperRoute, $isReport = true)
    {
        if (false == $this->hasRoute($route, $upperRoute)) {
            $this->addSql(
                "INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior, relatorio)
                VALUES (nextval('administracao.rota_cod_rota_seq'), :descricao_rota, :traducao_rota, :rota_superior, :relatorio)",
                [
                    'descricao_rota' => $route,
                    'traducao_rota' => $title,
                    'rota_superior' => $upperRoute,
                    'relatorio' => sprintf("%s", $isReport ? 'true' : 'false')
                ]
            );
        }
    }

    /**
     * @param $route
     * @param $title
     * @return void
     */
    protected function updateRouteTitle($route, $title)
    {
        $this->addSql("UPDATE administracao.rota SET traducao_rota = :title WHERE descricao_rota = :route;", [
            'title' => $title,
            'route' => $route
        ]);
    }
}
