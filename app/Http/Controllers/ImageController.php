<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     *  Метод получения изображения по его id
     *
     *
     * @OA\Get(
     *           path="/api/images/{id}",
     *           tags={"ImageController"},
     *        @OA\Parameter(
     *             name="id",
     *                in="path",
     *             description="id изображения",
     *             required=true),
     *           @OA\Response(
     *           response="200",
     *           description="Ответ при успешном выполнении запроса",
     *           type="file")
     *         )
     *       )
     *
     * @param $id
     * @return mixed
     */
    public function getImageByID($id) {
        $image = imagecreatefromstring(base64_decode(Image::where('id', $id)->first()->image));
        header('Content-type: image/png');
        return imagejpeg($image);
    }
}
