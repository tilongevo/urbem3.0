<?php

namespace CodeItNow\BarcodeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        $barcode = new BarcodeGenerator();
        $barcode->setText($name);
        $barcode->setType(BarcodeGenerator::Code39);
        $barcode->setScale(2);
        $barcode->setThickness(25);
        $code = $barcode->generate();
        return new Response('<img src="data:image/png;base64,'.$code.'" />');
    }
}
