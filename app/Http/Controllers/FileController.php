<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;

class FileController extends Controller
{
    /**
     *  Метод получения файла по его id
     *
     *
     * @OA\Get(
     *           path="/api/files/{id}",
     *           tags={"FileController"},
     *        @OA\Parameter(
     *             name="id",
     *                in="path",
     *             description="id файла",
     *             required=true),
     *           @OA\Response(
     *           response="200",
     *           description="Ответ при успешном выполнении запроса",
     *           type="file")
     *         )
     *       )
     *
     * @param $id
     * @return false|string
     */
    public function getFileByID($id) {
        $file = File::where('id', $id)->first();
        header('Content-type: '.$file->mime);
        return base64_decode($file->file);
    }

}
