<?php

namespace App\Contracts;

use Illuminate\Http\Request;

/**
 * Interface ImagesContract
 * @package App\Contracts
 */
interface ImagesContract
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function determineMainColorImageAndAddWatermark(Request $request);

    /**
     * @param Request $request
     * @param string $color
     * @return mixed
     */
    public function addWatermarkToImage(Request $request, string $color);

    /**
     * @param Request $request
     * @return array
     */
    public function determineColorsImage(Request $request): array;

    /**
     * @return array
     */
    public function getRulesForColorTextWatermark(): array;

    /**
     * @param $file
     * @param string $mimeType
     * @return false|resource
     */
    public function imageCreateTrueColor($file, string $mimeType = 'jpeg');
}
