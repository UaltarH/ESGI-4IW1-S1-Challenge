<?php

namespace App\Utilities;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class CommonUtils
{
    private $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }

    public function getLogoTechcareForPdf()
    {
        $path = $this->parameterBag->get('kernel.project_dir') . '/public/assets/images/techcareLogo.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
}
