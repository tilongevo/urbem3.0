<?php

namespace Urbem\CoreBundle\Form\Type;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\Form\ChoiceList\ORMQueryBuilderLoader;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BaseType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Urbem\CoreBundle\Form\Transform\EntityTransform;

class ManyToManyAutoCompleteType extends AbstractManyToManyType
{
    public function getParent()
    {
        return 'autocomplete';
    }

    public function addViewTransform(FormBuilderInterface $builder)
    {
        return;
    }
}
