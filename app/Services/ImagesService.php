<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Contracts\ImagesContract;
use Illuminate\Support\Facades\Storage;

/**
 * Class ImagesService
 * @package App\Services1
 */
class ImagesService implements ImagesContract
{
    /**
     * @param Request $request
     */
    public function determineMainColorImageAndAddWatermark(Request $request)
    {
        $colorsImageRgbArray = $this->determineColorsImage($request);
        $mainColor = array_keys($colorsImageRgbArray, max($colorsImageRgbArray));
        $colorWatermark = $this->getRulesForColorTextWatermark()[array_shift($mainColor)];

        $this->addWatermarkToImage($request, $colorWatermark);
    }

    /**
     * @param Request $request
     * @param string $color
     */
    public function addWatermarkToImage(Request $request, string $color)
    {
        // For best practice, this posting code must be replaced with a class property and the service is not a very good
        // solution here. But as far as I understand, this is only the first test case, therefore,
        // I'll write better next time.
        $mainImage = $this->imageCreateTrueColor($request->file('image'), $request->file('image')->getClientMimeType());
        $watermarkImagePatch = Storage::path("public/watermarks/$color.jpg");

        $watermarkImage = $this->imageCreateTrueColor($watermarkImagePatch);
        imagecopymerge($watermarkImage, $mainImage, 0, 0, 0, 0, 500, 500, 30);
        header('Content-type: image/jpeg');

        imagejpeg($watermarkImage);
        imagedestroy($mainImage);
        imagedestroy($watermarkImage);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function determineColorsImage(Request $request): array
    {
        $image = $this->imageCreateTrueColor($request->file('image'), $request->file('image')->getClientMimeType());

        $thumb = imagecreatetruecolor(1, 1);
        imagecopyresampled($thumb, $image, 0, 0, 0, 0, 1, 1, imagesx($image), imagesy($image));
        $mainColor = strtoupper(dechex(imagecolorat($thumb, 0, 0)));
        list($r, $g, $b) = sscanf($mainColor, "%02x%02x%02x");

        return [
            'red'   => $r,
            'green' => $g,
            'blue'  => $b,
        ];
    }

    /**
     * @return array
     */
    public function getRulesForColorTextWatermark(): array
    {
        return [
            'red'   => 'black',
            'blue'  => 'yellow',
            'green' => 'red',
        ];
    }

    /**
     * @param $file
     * @param string $mimeType
     * @return false|resource
     */
    public function imageCreateTrueColor($file, string $mimeType = 'jpeg')
    {
        if (strstr($mimeType, 'jpeg') !== false) {
            $image = imagecreatefromjpeg($file);
        } else {
            $image = imagecreatefrompng($file);
        }

        return $image;
    }
}
