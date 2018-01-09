<?php

namespace Urbem\ConfiguracaoBundle\Service\Configuration;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;

class ConfigurationReader
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var GroupCollection
     */
    protected $groups;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $module;

    /**
     * @var string
     */
    protected $image;

    /***
     * @var string
     */
    protected $service;

    /**
     * ConfigurationReader constructor.
     * @param EntityManager $entityManager
     * @param array $config
     *
     * @see src/Urbem/ConfiguracaoBundle/DependencyInjection/Configuration.php for $config parameter
     */
    public function __construct(EntityManager $entityManager, array $config)
    {
        $this->entityManager = $entityManager;
        $this->config = $config;

        $this->name = $config['name'];
        $this->module = (string) $config['id'];
        $this->image = (string) $config['image'];
        $this->service = (string) $config['service'];
        $this->groups = new GroupCollection($config['groups']);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param FormMapper $formMapper
     * @param string $year
     * @return FormMapper
     */
    public function build(FormMapper $formMapper, $year)
    {
        /** @var Group $group */
        foreach ($this->groups as $group) {
            $groupMapper = $formMapper->with($group->getName());

            /** @var Item $item */
            foreach ($group as $item) {
                $groupMapper->add(
                    $item->getName(),
                    $item->getType(),
                    $item->getOptions() + [
                        'data' => $this->getData($item, $year, true),
                        'year' => $year,
                        'module' => $this->getModule()
                    ]
                );
            }

            $groupMapper->end();
        }

        return $formMapper;
    }

    /**
     * @param Item $item
     * @param $year
     * @return string
     */
    protected function getData(Item $item, $year, $previousYear = false)
    {
        /** @var Configuracao $configuration */
        $configuration = $this->getModule()->getFkAdministracaoConfiguracoes($item->getName(), $year, $previousYear);

        if (false === $configuration instanceof Configuracao) {
            throw new \OutOfBoundsException(sprintf('Parameter "%s" does not exists in "%s".', $item->getName(), $year));
        }

        return (string) $configuration->getValor();
    }

    /**
     * @return Modulo|object
     */
    public function getModule()
    {
        return $this->entityManager->getRepository(Modulo::class)->find($this->module);
    }
}
