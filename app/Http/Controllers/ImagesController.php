<?php

namespace App\Http\Controllers;

use App\Contracts\ImagesContract;
use App\Http\Requests\WatermarkRequest;

/**
 * Class ImagesController
 * @package App\Http\Controllers
 */
class ImagesController extends Controller
{
    /**
     * @var ImagesContract
     */
    protected $imagesService;

    /**
     * ImagesController constructor.
     * @param ImagesContract $imagesService
     */
    public function __construct(ImagesContract $imagesService)
    {
        $this->imagesService = $imagesService;
    }

    /**
     * @param WatermarkRequest $request
     */
    public function addWatermark(WatermarkRequest $request)
    {
        $this->imagesService->determineMainColorImageAndAddWatermark($request);
    }
}
