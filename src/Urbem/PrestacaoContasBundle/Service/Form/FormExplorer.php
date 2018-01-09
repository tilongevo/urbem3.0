<?php

namespace Urbem\PrestacaoContasBundle\Service\Form;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Translation\TranslatorInterface;

class FormExplorer
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * FormError constructor.
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param FormInterface $form
     * @return array
     */
    public function errorToArray(FormInterface $form)
    {
        $errors = [];

        /** @var FormInterface $child */
        foreach ($form as $child) {
            if (0 === $child->getErrors(true)->count()) {
                continue;
            }

            $label = $this->translator->trans($child->getConfig()->getOption('label'));

            $errors[$child->getName()] = [];

            if (0 === $child->count()) {
                $errors[$child->getName()][] = [
                    'message' => str_replace(['ERROR: ', "\n"], '', (string) $child->getErrors()),
                    'label' => $label,
                    'field' => $child->getName()
                ];

            } else {
                foreach ($child as $_child) {
                    if (0 === $_child->getErrors(true)->count()) {
                        continue;
                    }

                    $errors[$child->getName()][] = [
                        'message' => str_replace(['ERROR: ', "\n"], '', (string) $_child->getErrors(true)),
                        'label' => (string) $_child->getData(),
                        'field' => sprintf('%s[%s]', $child->getName(), $_child->getName())
                    ];
                }
            }
        }

        return $errors;
    }

    /**
     * @param FormInterface $form
     * @return array
     */
    public function explain(FormInterface $form, $parent = null)
    {
        $explain = [];

        /** @var FormInterface $child */
        foreach ($form as $child) {
            $label = $this->translator->trans($child->getConfig()->getOption('label'));

            if (null !== $parent) {
                if (null !== $child->getData()) {
                    continue;
                }

                $extra = '';

                if (false === strpos($parent, '[')) {
                    $extra = '[N]';
                }

                $name = sprintf('%s%s[%s]', $parent, $extra, $child->getName());

            } else {
                $name = $child->getName();
            }

            $field = [
                'label' => $label,
                'type' => $child->getConfig()->getType()->getBlockPrefix(),
                'field' => $name
            ];

            if (null !== $child->getConfig()->getAttribute('prototype')) {
                $field['prototype'] = $this->explain($child->getConfig()->getAttribute('prototype'), $name);
            }

            if (0 < $child->count()) {
                $i = 0;

                $prototype = [];

                foreach ($child as $_child) {
                    $item = $this->explain($_child, sprintf('%s[%s]', $name, $i));
                    $item[0]['label'] = sprintf('%s - %s', $item[0]['label'], (string) $_child->getData());

                    $prototype = array_merge($prototype, $item);

                    $i++;
                }

                $field['prototype'] = $prototype;
            }

            $explain[] = $field;
        }

        return $explain;
    }
}
