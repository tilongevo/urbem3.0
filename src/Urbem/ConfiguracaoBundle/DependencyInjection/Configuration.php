<?php

namespace Urbem\ConfiguracaoBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Urbem\ConfiguracaoBundle\Service\Configuration\Group;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\SwCgm;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $root = $treeBuilder->root('configuracao');
        $this->createAdminNode($root);
        $this->createFinanceiroNode($root);

        return $treeBuilder;
    }

    protected function createFinanceiroNode(ArrayNodeDefinition $root)
    {
        $financeiroNode = $root->children()->arrayNode('financeiro')->addDefaultsIfNotSet()->children();
        $financeiroNode->scalarNode('module_name')->defaultValue('configuracao.modulos.financeiro.nome')->isRequired()->cannotBeEmpty()->end();
        $financeiroNode->scalarNode('module_id')->defaultValue(Modulo::MODULO_PLANO_PLURIANUAL)->isRequired()->cannotBeEmpty()->end();
        $financeiroNode->scalarNode('module_image')->defaultValue('/bundles/financeiro/images/monetization.png')->isRequired()->cannotBeEmpty()->end();

        $groupsNode = $financeiroNode->arrayNode('groups')->addDefaultsIfNotSet()->children();
        $itemGroupNode = $this->createItemsNode($this->createGroupNode($groupsNode, 'group1', 'configuracao.modulos.financeiro.grupos.grupo1'));

        $this->createConfigurationItem($itemGroupNode, 'ppa_diversos_orgaos', 'configuracao.modulos.financeiro.itens.programa_repetido', ['type' => 'configuration_choice', 'choices' => ['sim' => 'S', 'nao' => 'N'], 'required' => true]);
    }

    /**
     * @param ArrayNodeDefinition $root
     */
    protected function createAdminNode(ArrayNodeDefinition $root)
    {
        $administracaoNode = $root->children()->arrayNode('administracao')->addDefaultsIfNotSet()->children();
        $administracaoNode->scalarNode('module_name')->defaultValue('configuracao.modulos.administracao.nome')->isRequired()->cannotBeEmpty()->end();
        $administracaoNode->scalarNode('module_id')->defaultValue(2)->isRequired()->cannotBeEmpty()->end();
        $administracaoNode->scalarNode('module_image')->defaultValue('/bundles/administrativo/images/admin.png')->isRequired()->cannotBeEmpty()->end();

        $groupsNode = $administracaoNode->arrayNode('groups')->addDefaultsIfNotSet()->children();

        $itemGroupNode = $this->createItemsNode($this->createGroupNode($groupsNode, 'group1', 'configuracao.modulos.administracao.grupos.grupo1'));

        $this->createConfigurationItem($itemGroupNode, 'nom_prefeitura', 'configuracao.modulos.administracao.itens.nom_prefeitura', ['type' => 'configuration_text', 'required' => true]);

        $this->createConfigurationItem($itemGroupNode, 'cod_uf', 'configuracao.modulos.administracao.itens.cod_uf', [
            'type' => 'configuration_uf',
            'required' => true,
        ]);

        $this->createConfigurationItem($itemGroupNode, 'cod_municipio', 'configuracao.modulos.administracao.itens.cod_municipio', [
            'type' => 'configuration_municipio',
            'required' => true,
            'cascade_fields' => [
                [
                    'from_field' => 'cod_uf',
                    'search_column' => 'codUf'
                ]
            ],
            'route' => [
                'name' => 'configuracao_autocomplete',
                'parameters' => [
                    'service' => 'administracao',
                ]
            ],
        ]);

        $this->createConfigurationItem($itemGroupNode, 'tipo_logradouro', 'configuracao.modulos.administracao.itens.tipo_logradouro', [
            'type' => 'configuration_tipo_logradouro',
            'required' => true,
        ]);

        $this->createConfigurationItem($itemGroupNode, 'logradouro', 'configuracao.modulos.administracao.itens.logradouro', ['type' => 'configuration_text', 'required' => false]);
        $this->createConfigurationItem($itemGroupNode, 'numero', 'configuracao.modulos.administracao.itens.numero', ['type' => 'configuration_text', 'required' => false]);
        $this->createConfigurationItem($itemGroupNode, 'complemento', 'configuracao.modulos.administracao.itens.complemento', ['type' => 'configuration_text', 'required' => false]);
        $this->createConfigurationItem($itemGroupNode, 'bairro', 'configuracao.modulos.administracao.itens.bairro', ['type' => 'configuration_text', 'required' => false]);

        $this->createConfigurationItem($itemGroupNode, 'cep', 'configuracao.modulos.administracao.itens.cep', [
            'type' => 'configuration_text',
            'required' => true,
            'attr' => ['class' => 'numeric ']
        ]);

        $this->createConfigurationItem($itemGroupNode, 'fone', 'configuracao.modulos.administracao.itens.fone', ['type' => 'configuration_text', 'required' => false]);
        $this->createConfigurationItem($itemGroupNode, 'fax', 'configuracao.modulos.administracao.itens.fax', ['type' => 'configuration_text', 'required' => false]);
        $this->createConfigurationItem($itemGroupNode, 'e_mail', 'configuracao.modulos.administracao.itens.e_mail', ['type' => 'configuration_text', 'required' => false]);
        $this->createConfigurationItem($itemGroupNode, 'site', 'configuracao.modulos.administracao.itens.site', ['type' => 'configuration_text', 'required' => false]);
        $this->createConfigurationItem($itemGroupNode, 'cnpj', 'configuracao.modulos.administracao.itens.cnpj', ['type' => 'configuration_text', 'required' => true]);

        $this->createConfigurationItem($itemGroupNode, 'populacao', 'configuracao.modulos.administracao.itens.populacao', [
            'type' => 'configuration_text',
            'required' => false,
            'attr' => ['class' => 'numeric ']
        ]);

        $this->createConfigurationItem($itemGroupNode, 'CGMPrefeito', 'configuracao.modulos.administracao.itens.CGMPrefeito', [
            'type' => 'configuration_autocomplete',
            'required' => true,
            'class' => SwCgm::class,
            'from_mapping' => false,
            'json_query_builder_fields' => ['nomCgm'],
            'route' => [
                'name' => 'configuracao_autocomplete',
                'parameters' => [
                    'service' => 'administracao',
                ]
            ],
        ]);

        $this->createConfigurationItem($itemGroupNode, 'CGMDiarioOficial', 'configuracao.modulos.administracao.itens.CGMDiarioOficial', [
            'type' => 'configuration_autocomplete',
            'required' => false,
            'class' => SwCgm::class,
            'from_mapping' => false,
            'json_query_builder_fields' => ['nomCgm'],
            'route' => [
                'name' => 'configuracao_autocomplete',
                'parameters' => [
                    'service' => 'administracao',
                ]
            ],
        ]);

        $this->createConfigurationItem($itemGroupNode, 'logotipo', 'configuracao.modulos.administracao.itens.logotipo', [ 'type' => 'configuration_logo_tipo', 'required' => false ]);

        $this->createConfigurationItem($itemGroupNode, 'codigo_ibge', 'configuracao.modulos.administracao.itens.codigoIbge', [
            'type' => 'configuration_text',
            'required' => false,
            'attr' => ['class' => 'numeric ']
        ]);

        $itemGroupNode = $this->createItemsNode($this->createGroupNode($groupsNode, 'group2', 'configuracao.modulos.administracao.grupos.grupo2'));

        $this->createConfigurationItem($itemGroupNode, 'mensagem', 'configuracao.modulos.administracao.itens.mensagem', ['type' => 'configuration_textarea', 'required' => false]);
        $this->createConfigurationItem($itemGroupNode, 'periodo_auditoria', 'configuracao.modulos.administracao.itens.periodo_auditoria', ['type' => 'configuration_text', 'required' => true]);
        $this->createConfigurationItem($itemGroupNode, 'usuario_relatorio', 'configuracao.modulos.administracao.itens.usuario_relatorio', ['type' => 'configuration_choice', 'choices' => ['sim' => 'S', 'nao' => 'N'], 'required' => false]);
        $this->createConfigurationItem($itemGroupNode, 'ano_exercicio', 'configuracao.modulos.administracao.itens.ano_exercicio', ['type' => 'configuration_text', 'required' => true]);
        $this->createConfigurationItem($itemGroupNode, 'mascara_setor', 'configuracao.modulos.administracao.itens.mascara_setor', ['type' => 'configuration_text', 'required' => true]);
        $this->createConfigurationItem($itemGroupNode, 'mascara_local', 'configuracao.modulos.administracao.itens.mascara_local', ['type' => 'configuration_text', 'required' => true]);
        $this->createConfigurationItem($itemGroupNode, 'server_backup', 'configuracao.modulos.administracao.itens.server_backup', ['type' => 'configuration_choice', 'choices' => ['sim' => 'S', 'nao' => 'N'], 'required' => true]);
    }

    /**
     * @param NodeBuilder $groupNode
     * @return NodeBuilder
     */
    protected function createItemsNode(NodeBuilder $groupNode)
    {
        return $groupNode->arrayNode(Group::KEY_ITEMS)->addDefaultsIfNotSet()->children();
    }

    /**
     * @param NodeBuilder $groupsNode
     * @param $group
     * @param $name
     * @return NodeBuilder
     */
    protected function createGroupNode(NodeBuilder $groupsNode, $group, $name)
    {
        $groupNode = $groupsNode->arrayNode($group)->addDefaultsIfNotSet()->children();
        $groupNode->scalarNode(Group::KEY_NAME)->defaultValue($name)->cannotBeOverwritten()->isRequired();

        return $groupNode;
    }

    /**
     * @param NodeBuilder $itemGroupNode
     * @param $name
     * @param $label
     * @param array $options
     */
    protected function createConfigurationItem(NodeBuilder $itemGroupNode, $name, $label, array $options)
    {
        $itemNode = $itemGroupNode->arrayNode($name)->addDefaultsIfNotSet()->children();
        $itemNode->scalarNode('name')->defaultValue($name)->isRequired();
        $itemNode->scalarNode('label')->defaultValue($label)->isRequired();

        foreach ($options as $option => $value) {
            $itemNode->scalarNode($option)->defaultValue($value)->cannotBeOverwritten()->isRequired();
        }
    }
}
