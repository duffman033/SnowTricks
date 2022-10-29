<?php

namespace App\Twig;

use App\Service\VideosService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    /**
     * @var VideosService
     */
    private VideosService $videosService;

    public function __construct(VideosService $videosService){
        $this->videosService = $videosService;
    }
    public function getFilters(): array
    {
        return [
            new TwigFilter('urlConvert', [$this, 'doSomething']),
        ];
    }
    
    public function doSomething($value)
    {
        return $this->videosService->vidProviderUrl2Player($value);
    }
}
