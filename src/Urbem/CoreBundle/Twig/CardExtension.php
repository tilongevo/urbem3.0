<?php

namespace Urbem\CoreBundle\Twig;

use Doctrine\Common\Proxy\Exception\InvalidArgumentException;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;

class CardExtension extends \Twig_Extension
{
    /**
     * @var Symfony\Component\Routing\RouterInterface
     */
    private $router;

    /**
     * @var Symfony\Component\Translation\TranslatorInterface
     */
    private $translator;

    /**
     * CardExtension constructor.
     * @param RouterInterface $router
     * @param TranslatorInterface $translator
     */
    public function __construct(RouterInterface $router, TranslatorInterface $translator)
    {
        $this->router = $router;
        $this->translator = $translator;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'singleCard',
                [$this, 'singleCard'],
                [
                    'needs_environment' => true,
                    'is_safe' => ['html']
                ]
            ),

            new \Twig_SimpleFunction(
                'multipleCard',
                [$this, 'multipleCard'],
                [
                    'needs_environment' => true,
                    'is_safe' => ['html']
                ]
            ),
        ];
    }

    /**
     * $text can be an array like:
     *
     * [
     *      'text' => 'my_text',
     *      'parameters' => [
     *          'parameter1' => 'my parameter'
     *      ]
     * ]
     *
     * or need to be a string
     *
     * @param string|array $text to be converted
     *
     * @return string
     */
    protected function getTranslatedText($text)
    {
        if (false === is_array($text)) {
            return $text;
        }

        $parameters = true === empty($text['parameters']) ? [] : $text['parameters'];
        $text = $text['text'];

        if (false === is_array($parameters)) {
            throw new InvalidArgumentException(sprintf(
                '$text["$parameters"] need to be an array. %s was given.',
                gettype($parameters)
            ));
        }

        if (false === is_string($text)) {
            throw new InvalidArgumentException(sprintf(
                '$text need to be a string. %s was given.',
                gettype($text)
            ));
        }

        return $this->translator->trans($text, $parameters);
    }

    /**
     * $route can be an array like:
     *
     * [
     *      'name' => 'my_route',
     *      'parameters' => [
     *          'parameter1' => 'my parameter'
     *      ]
     * ]
     *
     * or need to be a string
     * @param $route
     * @return string
     */
    protected function getGeneratedRoute($route)
    {
        if (false === is_array($route)) {
            return $route;
        }

        $parameters = true === empty($route['parameters']) ? [] : $route['parameters'];
        $route = $route['name'];

        if (false === is_array($parameters)) {
            throw new InvalidArgumentException(sprintf(
                '$route["$parameters"] need to be an array. %s was given.',
                gettype($parameters)
            ));
        }

        if (false === is_string($route)) {
            throw new InvalidArgumentException(sprintf(
                '$route need to be a string. %s was given.',
                gettype($route)
            ));
        }

        return $this->router->generate($route, $parameters);
    }

    /**
     * Render a Single Card for twig theme
     *
     * @param \Twig_Environment $environment
     * @param $route array|string [name, parameters = []]
     * @param $image
     * @param $text array|string [text, parameters = []]
     * @return string
     */
    public function singleCard(\Twig_Environment $environment, $route, $image, $text)
    {
        return $environment->render(
            'CoreBundle::Default/single_card.html.twig',
            [
                'route' => $this->getGeneratedRoute($route),
                'text' => $this->getTranslatedText($text),
                'image' => $image,
            ]
        );
    }

    /**
     * Render a Single Card for twig theme
     *
     * @param \Twig_Environment $environment
     * @param $text array|string [text, parameters = []]
     * @param $image
     * @param $items array
     * @return string
     */
    public function multipleCard(\Twig_Environment $environment, $text, $image, array $items = [])
    {
        foreach ($items as $key => $item) {
            if (false === is_array($item)) {
                throw new InvalidArgumentException(sprintf(
                    '$items["%s"] need to be an array. %s was given.',
                    $key,
                    $item
                ));
            }

            if (true === empty($item['route'])) {
                throw new InvalidArgumentException(sprintf(
                    '$items["%s"]["route"] must be set.',
                    $key
                ));
            }

            if (true === empty($item['text'])) {
                throw new InvalidArgumentException(sprintf(
                    '$items["%s"]["text"] must be set.',
                    $key
                ));
            }

            $items[$key]['route'] = $this->getGeneratedRoute($item['route']);
            $items[$key]['text'] = $this->getTranslatedText($item['text']);
        }

        return $environment->render(
            'CoreBundle::Default/multiple_card.html.twig',
            [
                'text' => $this->getTranslatedText($text),
                'image' => $image,
                'items' => $items
            ]
        );
    }

    public function getName()
    {
        return 'card_extension';
    }
}
