<?php

namespace Urbem\CoreBundle\Twig;

class FileExtension extends \Twig_Extension
{

    /**
     * Return the functions registered as twig extensions
     *
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('file_exists', 'file_exists'),
        );
    }

    public function getName()
    {
        return 'app_file';
    }
}
